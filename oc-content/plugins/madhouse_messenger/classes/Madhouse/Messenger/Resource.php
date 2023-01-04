<?php

use Madhouse\Resource\Resource as BaseResource;

class Madhouse_Messenger_Resource extends BaseResource
{
    /**
     * Unique id of the message from which the resource is attached.
     *
     * @var int
     */
    protected $messageId;

    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
        return $this;
    }

    public function getMessageId()
    {
        return $this->messageId;
    }

    public function getUrl($format = null)
    {
        // @TODO, pass this as an argument, in some way.
        if (osc_get_preference("resources_secure_url", mdh_current_preferences_section())) {
            return mdh_messenger_resource_raw_url($this->getSecret(), $format);
        }

        return parent::getUrl($format);
    }

    public function getThumbnailUrl()
    {
        return $this->getUrl("thumbnail");
    }

    /**
     * Serialization utility.
     * @returns an associative array of this object.
     */
    public function toArray() {
        return array_merge(
            parent::toArray(),
            array(
                "url_thumbnail" => $this->getThumbnailUrl()
            )
        );
    }
}