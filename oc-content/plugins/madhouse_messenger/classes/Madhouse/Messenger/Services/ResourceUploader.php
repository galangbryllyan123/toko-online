<?php

use \RandomLib\Factory as RandomFactory;

use MimeTyper\Repository\ExtendedRepository;

use Madhouse\HttpFoundation\File\UploadedFile;

use Madhouse\Resource\UploaderService;

/**
 * Manage resources attached to messages.
 *
 * @since 2.0.0
 */
class Madhouse_Messenger_Services_ResourceUploader
{
    /**
     * Data Access Object for resource.
     *
     * @var Madhouse_DAO_BaseDAO
     */
    protected $model;

    /**
     * Uploader service.
     *
     * @var Madhouse_Resource_UploaderService
     */
    protected $uploader;

    /**
     * Random generator service.
     *
     * @var
     */
    protected $randomGenerator;

    /**
     * Destination path of the resource.
     *
     * @var string.
     */
    protected $basePath;

    /**
     * Formats (name => dimensions) to generate for each resource.
     *
     * @var array.
     */
    protected $formats;

    /**
     * Create a new object with dependency injection and settings.
     *
     * @return $this
     */
    public static function newInstance()
    {
        // Get dependencies.
        $model = Madhouse_Messenger_Models_Resource::newInstance();
        $settingsService = Madhouse_Messenger_Services_SettingsService::newInstance();


        // Get a random factory.
        $randomFactory = new RandomFactory();
        $randomGenerator = $randomFactory->getMediumStrengthGenerator();

        // Get allowed extensions from settings.
        $extensionsWhitelist = $settingsService->getResourceExtensionList();

        // Create the actual uploader service.
        $uploaderService = new UploaderService(
            new ExtendedRepository(),
            $randomGenerator,
            $settingsService->getResourceMaxSize(),
            $extensionsWhitelist
        );

        // Create the new instance.
        return new self(
            $model,
            $uploaderService,
            $randomGenerator,
            osc_uploads_path() . DIRECTORY_SEPARATOR . mdh_current_plugin_name(),
            array(
                "thumbnail" => osc_get_preference('resources_thumbnail_size', mdh_current_preferences_section())
            )
        );
    }

    /**
     * Constructor.
     *
     * @param Madhouse_DAO_BaseDAO              $model.
     * @param Madhouse\Resource\UploaderService $uploaderService.
     * @param string                            $path.
     * @param array                             $formats.
     */
    public function __construct($model, $uploaderService, $randomGenerator, $path, $formats = null)
    {
        // Init the base directory.
        $basePath = Madhouse_Utils_Text::sanitizePath($path);


        $this->model = $model;
        $this->uploader = $uploaderService;
        $this->randomGenerator = $randomGenerator;
        $this->basePath = $basePath;
        $this->formats = ($formats !== null) ? $formats : array();
    }

    /**
     * Find a resource by its secret key.
     *
     * @param  string $secret.
     *
     * @return Madhouse_Messenger_Resource.
     */
    public function findResourceBySecret($secret)
    {
        return $this->model->findBySecret($secret);
    }

    public function findAll($filters = null)
    {
        if ($filters === null) {
            $filters = array();
        }

        return $this->model->findAll($filters);
    }

    /**
     * Update a resource.
     *
     * @param  Madhouse_Messenger_Resource $resource
     *
     * @return Madhouse_Messenger_Resource.
     */
    public function updateResource($resource)
    {
        return $this->model->update($resource);
    }

    /**
     * Delete a resource.
     *
     * It also delete the file on disk, if exists.
     *
     * @param  Madhouse\Resource\Resource $resource.
     *
     * @return void.
     */
    public function deleteResource($resource)
    {
        // Delete resource @ database.
        $this->model->delete($resource);

        // Delete resource on disk.
        if (file_exists($resource->getRealPath()) && is_file($resource->getRealPath())) {
            @unlink($resource->getRealPath());
        }
    }

    /**
     * Upload all the given $uploadedFiles files and save them in database.
     *
     * @param  array<Madhouse\HttpFoundation\File\UploadedFile> $uploadedFiles.
     *
     * @return array<Madhouse\Messenger\Resource> $resource
     */
    public function uploadResources($uploadedFiles)
    {
        if (!is_array($uploadedFiles)) {
            // Don't throw exception, just skip the whole processing.
            return array();
        }

        // Filter null values.
        $uploadedFiles = array_filter($uploadedFiles);

        $uploadedResources = array();
        if ($uploadedFiles) {
            // Upload each files and create a resource.
            foreach ($uploadedFiles as $uploadedFile) {
                $uploadedResources[] = $this->uploadResource($uploadedFile);
            }
        }

        return $uploadedResources;
    }

    /**
     * Upload a resource.
     *
     * @param  array $resource
     *
     * @return Madhouse_Messenger_Resource
     */
    public function uploadResource($uploadedFile)
    {
        if (!$uploadedFile instanceof UploadedFile) {
            // Resources are created from valid HTTP uploaded files.
            throw new \InvalidArgumentException(
                "'uploadedFile' must be a valid instance of UploadedFile"
            );
        }

        // Check that the filesystem is ready!
        $this->checkFilesystem();

        // Create a new resource.
        $resource = new Madhouse_Messenger_Resource();

        // Create the new resource @ database to get its primary key.
        $resource = $this->model->insert($resource);

        $uploadedResource = null;
        try {
            // Upload the resource to the server.
            $uploadedResource = $this->uploader->upload(
                $uploadedFile,
                $this->resolveResourcePath($resource),
                $this->resolveResourceName($resource, $uploadedFile),
                $this->formats
            );
        } catch (Exception $e) {
            // Cleanup resource, something has failed while uploading.
            $this->deleteResource($resource);

            throw $e;
        }

        // Update resource with uploaded resource info.
        $resource
            ->setPath($uploadedResource->getPath())
            ->setName($uploadedResource->getName())
            ->setSecret($uploadedResource->getSecret())
            ->setOriginalName($uploadedResource->getOriginalName())
            ->setExtension($uploadedResource->getExtension())
            ->setMimeType($uploadedResource->getMimeType())
        ;
        return $this->model->update($resource);
    }

    /**
     * Attach the given $resources resources to the given $message message.
     *
     * @param  array<Madhouse\Messenger\Resource> $resources.
     * @param  Madhouse_Messenger_Message $message.
     *
     * @return array<Madhouse\Messenger\Resource>.
     */
    public function attachResources($resources, $message)
    {
        $updatedResources = array();
        if ($resources) {
            foreach ($resources as $resource) {
                // Set the message id.
                $resource->setMessageId($message->getId());
                try {
                    // Attach the resource to the message.
                    $updatedResources[] = $this->updateResource($resource);
                } catch (Exception $e) {
                    // @TODO: log some things.
                }
            }
        }

        return $updatedResources;
    }

    /**
     * Check if the filesystem is ready for uploads!
     *
     * @return void
     */
    public function checkFilesystem()
    {
        $basePath = $this->getBasePath();

        if (!file_exists($basePath)) {
            // basePath does not exists.
            throw new \RuntimeException(
                "Upload directory '$basePath' does not exist"
            );
        }
        if (file_exists($basePath) && !is_dir($basePath)) {
            // basePath is everything but a directory.
            throw new \RuntimeException(
                "Upload directory '$basePath' exists but is NOT a directory"
            );
        }
    }

    public function setupFilesystem($proxy = true, $htaccessContent = null)
    {
        if (!file_exists($this->basePath)) {
            // Create the directory, if necessary.
            if (!@mkdir($this->basePath, 0755, true)) {
                $error = error_get_last();
                throw new Exception($error["message"]);
            }
        }

        // Setup an htaccess to protect the resource directory.
        $htaccessFile = $this->getBasePath() . "/.htaccess";
        if (!is_null($htaccessContent)) {
            if (!@file_put_contents($htaccessFile, $htaccessContent)) {
                $error = error_get_last();
                throw new Exception($error["message"]);
            }
        }

        // Setup default .htaccess.
        if (!file_exists($htaccessFile)) {
            // Create the .htaccess file, if necessary.
            if (!@copy(mdh_current_plugin_path("assets/htaccess-sample.conf", false), $htaccessFile)) {
                $error = error_get_last();
                throw new Exception($error["message"]);
            }
        }
    }

    /**
     * Get the base path where resources are uploaded.
     *
     * @return string.
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Get formats for each resource.
     *
     * @return array.
     */
    public function getFormats()
    {
        return $this->formats;
    }

    /**
     * Is the extension be supported?
     *
     * Not that the extension is allowed but that it exists and match to a type.
     *
     * @param  string  $extension
     *
     * @return boolean
     */
    public function isExtensionSupported($extension)
    {
        return $this->uploader->isExtensionSupported($extension);
    }

    /**
     * Test if any mime type guessing method is available.
     *
     * @return boolean
     */
    public function hasMimeTypeGuesser()
    {
        return $this->uploader->hasMimeTypeGuesser();
    }

    /**
     * Resolve the target directory where the resource will be uploaded.
     *
     * Resources are stored in subfolders depending
     *
     * @param  Madhouse\Resource\Resource $resource
     *
     * @return string
     */
    public function resolveResourcePath($resource)
    {
        // Check if resource is valid.
        if (!$resource->getId()) {
            throw new InvalidArgumentException(
                "'resource' is invalid, no valid id found."
            );
        }

        // Compute the subfolder where resource will be uploaded.
        $subfolder = floor($resource->getId() / 100);

        // Return absolute path to target directory.
        return $this->basePath . DIRECTORY_SEPARATOR . $subfolder;
    }

    /**
     * Resolve a new file name for the resource.
     *
     * @param  Madhouse\Resource\Resource $resource.
     * @param  Madhouse\HttpFoundation\UploadedFile $uploadedFile.
     *
     * @return string.
     */
    public function resolveResourceName($resource, $uploadedFile)
    {
        // Generate a random salt.
        $randomGenerator = $this->randomGenerator; // PHP <5.4
        $salt = $randomGenerator->generateString(8, $randomGenerator::CHAR_ALNUM);

        // Return a new safe (and random) filename.
        return $resource->getId() . "_" . $salt;
    }
}
