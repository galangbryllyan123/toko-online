<?php

class Madhouse_Messenger_Services_LabelService
{
    /**
     * Model access object.
     *
     * @var Madhouse_Messenger_Models_Labels
     */
    protected $model;

    public static function newInstance()
    {
        return new self(
            Madhouse_Messenger_Models_Labels::newInstance()
        );
    }

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Find a given label.
     *
     * @param  array $filters
     *
     * @return Madhouse_Messenger_Label
     */
    public function findLabel($filters = null)
    {
        if (is_null($filters)) {
            $filters = array();
        }

        if (isset($filters["id"])) {
            // Search the label by id.
            return $this->model->findByPrimaryKey($filters["id"]);
        }

        if (isset($filters["name"])) {
            // Search the label by name.
            return $this->model->findByName(
                $filters["name"],
                ($filters["user"]) ? $filters["user"] : null
            );
        }
    }

    /**
     * Find a list of labels.
     *
     * @param  array $filters
     * @param  array $pagination
     * @param  array $sorting
     *
     * @return array
     */
    public function findLabels($filters = null, $pagination = null, $sorting = null)
    {
        return $this->model->findAll($filters, $pagination, $sorting);
    }

    /**
     * Create a label.
     *
     * @param  Madhouse_Messenger_Label $label
     *
     * @return Madhouse_Messenger_Label
     */
    public function createLabel($label)
    {
        // Check if a label with this title exists.
        $checkLabel = null;
        try {
            // Get the label using the name.
            $checkLabel = $this->model->findByName($label->getName());

            // Can't create a label with the same name.
            throw new Madhouse_Messenger_ForbiddenOperationException();
        } catch (Madhouse_NoResultsException $e) {
        }

        // Create and return the newly created label.
        return $this->model->create($label);
    }

    public function updateLabel($label)
    {
        // Get the original label.
        $originalLabel = $this->findLabel(array("id" => $label->getId()));

        // Get all locales of the new label version.
        $labelLocales = $label->getLocales();

        foreach ($labelLocales as $code => $localeInfo) {
            // Inspect each locale to see if it already exist.
            if ($originalLabel->hasLocale($code)) {
                // Original label already have that label, just update.
                $this->model->updateDescription($label, $code);
            } else {
                // That's a new locale to add.
                $this->model->insertDescription($label, $code);
            }
        }

        // @TODO return?
    }

    /**
     * Delete a label.
     *
     * @param  Madhouse_Messenger_Label $label
     *
     * @return void
     */
    public function deleteLabel($label)
    {
        $this->model->remove($label);
    }
}
