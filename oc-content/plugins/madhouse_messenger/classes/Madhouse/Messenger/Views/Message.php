<?php

class Madhouse_Messenger_Views_Message extends Madhouse_Messenger_Message
{
    /**
     * The user that is looking at this message.
     * @var Madhouse_User
     * @since 1.10
     */
    protected $viewer;

	public function __construct($viewer, $message)
    {
        parent::__construct(
            $message->getContent(),
            $message->getSender(),
            $message->getRecipients()
        );
        $this->withId($message->getId());
        $this->withSentDate($message->getSentDate());
        $this->withState($message->getState());
        $this->withThread($message->getThread());
        $this->withEvent($message->getEvent());
        $this->withHidden($message->getHidden());
        $this->withBlocked($message->isBlocked());
        $this->withStatus($message->getStatus());
        $this->withResources($message->getResources());

        $this->viewer = $viewer;
    }

    /**
     * Returns the content (body) of this message.
     * @return a string.
     * @override parent::computeText();
     * @since 1.20
     */
    public function getText()
    {
        if($this->isBlocked()) {
            // Blocked by an admin.
            return __("Sorry. This message has been blocked by an administrator (reason: spam).", mdh_current_plugin_name());
        } else if($this->isHidden()) {
            // Hidden by the viewer.
            return __("This message has been deleted.", mdh_current_plugin_name());
        }

        // Default (parent) implementation.
        return parent::getText();
    }

    public function isHidden()
    {
        /*
         * A message is seen as hidden if :
         * - viewer is author of this message and has hid the message (getHidden == true)
         * - viewer is recipient of this message and has hid the message
         */
        return ($this->isHiddenFor($this->viewer) || ($this->viewer->getId() == $this->getSender()->getId() && $this->getHidden()));
    }

    public function isAuto()
    {
        return ($this->isHidden() || $this->isBlocked() || $this->hasEvent()) ? true : false;
    }

    public function isFromViewer()
    {
        return ($this->viewer->getId() == $this->getSender()->getId()) ? true : false;
    }

    public function isRead()
    {
        return ($this->getReadDate()) ? true : false;
    }

    public function getReadDate()
    {
        foreach ($this->getState() as $s) {
            if($s["readOn"]) {
                return $s["readOn"];
            }
        }
        return null;
    }

    public function isSystem() {
        return ($this->isHidden() || $this->isBlocked() || ($this->hasEvent() && $this->getEvent()->isSystem()));
    }

    /**
     * Return true if the user can delete the message
     * @return boolean
     */
    public function canDelete()
    {
        $settingsService = Madhouse_Messenger_Services_SettingsService::newInstance();

        if ($settingsService->getDeleteMode() !== $settingsService::DELETE_MODE_ALL && $this->getSender()) {
            return true;
        } elseif (
            $settingsService->getDeleteMode() === $settingsService::DELETE_MODE_ALL &&
            $this->viewer->isRegistered() && $this->viewer->getId() == $this->getSender()->getid()
        ) {
            return true;
        } elseif (
            $settingsService->getDeleteMode() === $settingsService::DELETE_MODE_ALL &&
            !$this->viewer->isRegistered() && $this->viewer->getEmail() == $this->getSender()->getEmail()
        ) {
            return true;
        }

        return false;
    }

    /**
     * Get the delete url for this message.
     *
     * @param  string $secret
     * @param  string $email
     *
     * @return string
     *
     * @since  2.0.0
     */
    public function getDeleteURL($secret = null, $email = null)
    {
        if ($this->viewer->isRegistered()) {
            return parent::getDeleteURL();
        }
        return mdh_messenger_message_delete_url($this->getId(), $this->getThread()->getSecret(), $this->viewer->getEmail());
    }

    public function toArray()
    {
        return array_merge(
            parent::toArray(),
            array(
                "is_auto" => $this->isAuto(),
                "is_system" => $this->isSystem(),
                "is_hidden" => $this->isHidden(),
                "is_from_viewer" => $this->isFromViewer(),
                "is_read" => $this->isRead(),
                "can_delete" => $this->canDelete(),
                "read_date" => array(
                    "fb_formatted" => (($this->isRead()) ? Madhouse_Utils_Dates::smartDate($this->getReadDate()) : null)
                )
            )
        );
    }
}

?>