<?php

class Madhouse_Messenger_Services_ThreadService
{
    /**
     * Model objects for threads.
     *
     * @var Madhouse_Messenger_Models_Threads
     */
    protected $model;

    /**
     * Messenger settings service.
     *
     * @var Madhouse_Messenger_Services_SettingsService
     */
    protected $settings;

    /**
     * Messenger message service.
     *
     * @var Madhouse_Messenger_Services_MessageService
     */
    protected $messages;

    /**
     * Messenger user service.
     *
     * @var Madhouse_Messenger_Services_UserService
     */
    protected $users;

    /**
     * Factory method for this object.
     *
     * @TODO dependency injection, somewhere, somewhat.
     *
     * @return $this
     */
    public static function newInstance()
    {
        return new self(
            Madhouse_Messenger_Models_Threads::newInstance(),
            Madhouse_Messenger_Services_SettingsService::newInstance(),
            Madhouse_Messenger_Services_MessageService::newInstance(),
            Madhouse_Messenger_Services_UserService::newInstance()
        );
    }

    public function __construct($model, $settingsService, $messageService, $userService)
    {
        $this->model = $model;
        $this->settings = $settingsService;
        $this->messages = $messageService;
        $this->users = $userService;
    }

    /**
     * Find one thread by its primary key.
     *
     * @param  int $threadId.
     *
     * @return Madhouse_Messenger_ThreadSkeleton
     */
    public function findThreadById($threadId)
    {
        return $this->model->findByPrimaryKey($threadId);
    }

    public function findThreadByUsers($user1, $user2, $item = null)
    {
        // Search @ database for a thread where $user1 and $user2 belongs to.
        return $this->model->findByUsers($user1, $user2, $item);
    }

    /**
     * Search and returns threads for a user and some filters.
     * @param  Madhouse_User $user                  The user for whom we're searching
     * @param  String $filter                       One of: "all" for all threads, "unread" for only unread threads
     * @param  Int $page                            Pagination (page number)
     * @param  Int $num                             Pagination (number of threads per cairo_pattern_get_extend(pattern))
     * @return Array<Madhouse_Messenger_Threads>    The list of found threads.
     */
    public function findAll($filters = null, $pagination = null, $sorting = null)
    {
        // Throw exception if user is not a valid user object.
        if(isset($filters["user"]) && !$filters["user"] instanceof Madhouse_User) {
            throw new InvalidArgumentException(
                "'user' must be a valid Madhouse_User"
            );
        }

        $params = array();

        /*
         * @filterName 'label'
         * @filterType string|Madhouse_Messenger_Label
         */
        if (isset($filters['label']) && $filters['label'] instanceof Madhouse_Messenger_Label) {
            // Filter is already a Madhouse_Messenger_Label object.
            $params['label'] = $filters['label'];
        } elseif (isset($filters['label'])) {
            // Filter is a string, event internal name.
            try {
                // First try within persistent labels (such as inbox, archive, spam...).
                $params['label'] = Madhouse_Messenger_Models_Labels::newInstance()->findByName($filters["label"]);
            } catch(Madhouse_NoResultsException $e) {
                // Try within user's labels and let the exception handling to controller.
                $params['label'] = null;
                if (isset($filters["user"])) {
                    try {
                        $params['label'] = Madhouse_Messenger_Models_Labels::newInstance()->findByName(
                            $filters["label"],
                            $filters["user"]
                        );
                    } catch (Madhouse_NoResultsException $e) {
                    }
                }
            }
        }

        /*
         * @filterName 'unread'
         * @filterType string|Madhouse_Messenger_Label
         */
        $params['unread'] = (isset($filters["unread"]) && $filters["unread"] === true) ? true : false;

        /*
         * @filterName 'item'
         * @filterType Madhouse_Item
         */
        if (isset($filters["item"])) {
            $params["item"] = ($filters["item"] instanceof Madhouse_Item) ? $filters["item"]->getId() : $filters["item"];
        }

        /*
         * @filterName 'user'
         * @filterType Madhouse_User
         */
        if (isset($filters["user"])) {
            $params["user"] = $filters["user"];
        }

        // Find threads matching criteria.
        $results = $this->model->findAll(
            $params,
            isset($pagination["iDisplayPage"]) ? $pagination["iDisplayPage"] : null,
            isset($pagination["iDisplayLength"]) ? $pagination["iDisplayLength"] : null
        );


        if (isset($filters["user"])) {
            // Transform Madhouse_Messenger_Threads to Views objects.
            $user = $filters["user"];
            $results = array_map(
                function ($thread) use ($user) {
                    return $this->buildViewObject($thread, $user);
                },
                $results
            );
        }

        // Return the list.
        return $results;
    }

    public function createThread($nm, $item = null, $title = null)
    {
        $content = $nm->getContent();
        if(!isset($content) || empty($content)) {
            throw new Madhouse_Messenger_EmptyMessageException();
        }

        if(! is_null($item)) {
            if(! View::newInstance()->_exists("item")) {
                // Export item $item to access helpers.
                View::newInstance()->_exportVariableToView("item", $item);
            }

            if(! osc_item_is_enabled() || ! osc_item_is_active() || osc_item_is_spam() || osc_item_is_expired()) {
                // Can't contact a "not valid" item.
                throw new Madhouse_NoValidItemException();
            }
        }

        // Check if sender of the first message is valid.
        if(! $nm->getSender() instanceof Madhouse_User) {
            throw new InvalidArgumentException();
        }

        // Check if recipients are valid.
        $fRecipients = $this->messages->filterRecipients($nm->getSender(), $nm->getRecipients());
        if(count($fRecipients) === 0) {
            throw new Madhouse_Messenger_NoValidRecipientsException();
        }

        // Just before sending the message. Hook on this.
        osc_run_hook('mdh_messenger_pre_send', $nm, null);

        // Generate a secret for the thread.
        $factory = new \RandomLib\Factory();
        $randomGenerator = $factory->getMediumStrengthGenerator();
        $secret = $randomGenerator->generateString(10, $randomGenerator::CHAR_DIGITS | $randomGenerator::CHAR_UPPER);

        // Create the thread @ database.
        $thread = $this->model->create(
            $nm,
            $secret,
            (!is_null($item)) ? $item["pk_i_id"] : null,
            $title
        );

        // Message is finally sent (first of thread). Hook on this.
        osc_run_hook('mdh_messenger_post_send', $thread->getLastMessage(), $thread);

        // Thread is created. Hook on this.
        osc_run_hook('mdh_messenger_thread_created', $thread);

        return $thread;
    }

    public function updateThread($thread)
    {
        return $this->model->edit($thread);
    }

    public function markAsRead($thread, $viewer)
    {
        if(!$this->users->isAuthorized($viewer, $thread)) {
            throw new Madhouse_AuthorizationException(
                "'viewer' is not authorized to modify this thread."
            );
        }

        // Gets all unread messages of the thread $thread.
        $unreadMessages = $this->messages->findAll(
            array(
                "thread" => $thread,
                "user" => $viewer,
                "unread" => true
            )
        );

        if(!empty($unreadMessages)) {
            // Just mark them as read, if there's any.
            $this->messages->markAsRead($unreadMessages, $viewer);
        }
    }

    /**
     * Build the view object.
     *
     * @param  Madhouse_Messenger_Views $thread
     *
     * @return Madhouse_Messenger_Views_ThreadSummary
     */
    public function buildViewObject($thread, $viewer)
    {
        // Get the number of unread.
        $countUnread = $this->messages->countAll(
            array("user" => $viewer, "thread" => $thread, "received" => true, "unread" => true)
        );

        // Create the view object.
        $threadView = new Madhouse_Messenger_Views_ThreadSummary($viewer, $thread, $countUnread);
        $threadView->setBlockedUsers(Madhouse_Messenger_Models_BlockedUsers::newInstance()->findByUserAndThread($viewer, $threadView));

        // Return the created object.
        return $threadView;
    }
}
