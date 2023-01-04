<?php

class Madhouse_Messenger_Services_MessageService
{
    /**
     * Model objects for messages.
     *
     * Messages are stored in a table and who's receiving the message
     *
     * @var Madhouse_Messenger_Models_Messages
     */
    protected $messageModel;
    protected $recipientsModel;

    /**
     * Messenger settings service.
     *
     * @var Madhouse_Messenger_Services_SettingsService
     */
    protected $settings;

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
            Madhouse_Messenger_Models_Messages::newInstance(),
            Madhouse_Messenger_Models_Recipients::newInstance(),
            Madhouse_Messenger_Services_SettingsService::newInstance(),
            Madhouse_Messenger_Services_UserService::newInstance(),
            Madhouse_Messenger_Services_ResourceUploader::newInstance()
        );
    }

    public function __construct($messageModel, $recipientsModel, $settingsService, $userService, $resourceService)
    {
        $this->messageModel = $messageModel;
        $this->recipientsModel = $recipientsModel;
        $this->settings = $settingsService;
        $this->users = $userService;
        $this->resources = $resourceService;
    }

    /**
     * Find a message by its primary key.
     *
     * @param  int $messageId
     *
     * @return Madhouse_Messenger_Message
     */
    public function findMessageById($messageId)
    {
        // @TODO add $user and return a MessageView ?
        return $this->messageModel->findByPrimaryKey($messageId);
    }

    public function findAll($filters, $pagination = null, $sorting = null)
    {
        if (isset($filters["thread"]) && isset($filters["user"]) && isset($filters["unread"])) {
            return $this->messageModel->findUnreadByThread($filters["thread"], $filters["user"]);
        }

        if (isset($filters["thread"])) {
            // Return the messages.
            return $this->messageModel->findByThread(
                $filters["thread"],
                (isset($pagination["iDisplayPage"])) ? $pagination["iDisplayPage"] : 1,
                (isset($pagination["iDisplayLength"])) ? $pagination["iDisplayLength"] : 10
            );
        }

        return array();
    }

    public function countAll($filters = null)
    {
        if (isset($filters["user"])) {
            // Return the count of messages of a given $user.
            return $this->messageModel->countByUser($filters["user"], $filters);
        }

        throw new Exception(); // @TODO
    }

    public function createMessage($nm)
    {
        // Check if sender of the first message is valid.
        if(!$nm->getSender() instanceof Madhouse_User) {
            throw new InvalidArgumentException();
        }

        $content = $nm->getContent();
        $resources = $nm->getResources();
        $thread = $nm->getThread();

        // If message has only resource(s) add event "resources_only"
        if ($nm->hasResources() && (!isset($content) || empty($content)) && !$nm->hasEvent()) {
            $nm->withEvent(
                Madhouse_Messenger_Models_Events::newInstance()->findByName("resources_only")
            );
        }

        if((!isset($content) || empty($content)) && !$nm->hasEvent()) {
            throw new Madhouse_Messenger_EmptyMessageException();
        }

        // Check if recipients are valid.
        $filteredRecipients = $this->filterRecipients($nm->getSender(), $nm->getRecipients());
        if(count($filteredRecipients) === 0) {
            throw new Madhouse_Messenger_NoValidRecipientsException();
        }

        // Re-set recipients, just to be sure.
        $nm->setRecipients($filteredRecipients);

        osc_run_hook('mdh_messenger_pre_send', $nm, $thread);

        // Send the message.
        $message = $this->messageModel->create($nm, $thread);

        osc_run_hook('mdh_messenger_post_send', $message, $thread);

        //
        return $message;
    }

    public function deleteMessage($message, $user)
    {
        if(!$this->users->isAuthorized($user, $message->getThread())) {
            throw new Madhouse_AuthorizationException(
                "'user' is not authorized to modify this thread."
            );
        }

        if (!$message->canDelete()) {
            throw new Madhouse_Messenger_ForbiddenOperationException(
                "'user' is not authorized to modify this message."
            );
        }

        // Test if message is already deleted.
        if($message->isHiddenFor($user)) {
            // Already deleted / hidden. @TODO exceptions ?
            return;
        }

        $settingsService = $this->settings;

        if ($settingsService->getDeleteMode() === $settingsService::DELETE_MODE_ALL) {
            /*
             * Delete for everybody.
             *
             * This mode will delete the message for sender and all recipients
             * if one of them deletes it.
             */
            foreach ($message->getRecipients() as $user) {
                $this->recipientsModel->hide($message, $user);
            }

            // Hide the message for sender.
            $this->messageModel->hide($message);
        } else {
            /*
             * Delete for one.
             *
             * This mode will delete the message only for the one who does the
             * action. All other users will still see the message.
             */
            if($message->getSender()->getId() == $user->getId()) {
                // Hide the message as sender of this message.
                $this->messageModel->hide($message);
            } else {
                // Hide the message for one recipient.
                $this->recipientsModel->hide($message, $user);
            }
        }
    }

    /**
     * Filter recipients to remove deleted users, sender and duplicate users.
     *
     * @param  Madhouse_User $sender.
     * @param  array $recipients.
     *
     * @return array.
     */
    public function filterRecipients($sender, $recipients)
    {
        // Filter each recipients to see if it's valid.
        $filteredRecipients = array();
        foreach ($recipients as $recipient) {
            if (
                $recipient instanceof Madhouse_User
                && !$recipient->isDeleted()
                && (
                    !$recipient->isRegistered() || ($recipient->isRegistered() && $recipient->isEnabled() && $recipient->isActive())
                )
                && (
                    $sender->isRegistered() && $sender->getId() !== $recipient->getId()
                    || !$sender->isRegistered() && $sender->getEmail() !== $recipient->getEmail()
                )
                && (
                    !in_array($recipient, $filteredRecipients)
                )
            ) {
                $filteredRecipients[] = $recipient;
            }
        }

        // Return filtered list of recipients.
        return $filteredRecipients;
    }

    /**
     * Mark as read a message
     * @param  Madhouse_Messenger_Message $unreadMessages
     * @param  Madhouse_User $viewer
     * @return boolean
     */
    public function markAsRead($unreadMessages, $viewer) {
        return $this->recipientsModel->read($unreadMessages, $viewer);
    }

    /**
     * Find the template and clean it up.
     *
     * @param  int $userId
     *
     * @return String
     */
    public function findMessageTemplateByUser($userId)
    {
        if ($userId == false) {
            // Probably 'null' or 0.
            throw new \InvalidArgumentException();
        }

        // Retrieve the template message.
        $message = $this->messageModel->findTemplateByUser($userId);

        // Get the candidate template content.
        $template = $message->getContent();

        // Clean it up for each recipient.
        foreach($message->getRecipients() as $recipient) {
            // Search token array
            $search = array_merge(
                array($recipient->getName()),
                explode(" ", $recipient->getName())
            );

            // Replace by a token.
            $template = str_ireplace(
                $search,
                array_fill(0, count($search), "{RECIPIENT_NAME}"),
                $template
            );
        }

        // Return the template, cleaned up.
        return $template;
    }

    public function countByFormat($type = "day", $period = 10, $filters = array())
    {
        if ($type == "month") {
            $format = "F Y";
            $key = "M";
        } elseif ($type == "week") {
            $format = "W Y";
            $key = "W";
        } else {
            $format = "Y-m-d";
            $key = "D";
        }

        $stats = array();
        $date = new \DateTime();

        for($i = 0; $i < $period; $i ++) {
            $stats[$date->format($format)] = 0;
            $date->sub(new DateInterval('P1' . $key));
        }

        $stats = array_reverse($stats);

        $results = $this->countBy($type, $period, $filters);

        foreach($results as $result) {
            if ($type == "month" || $type == "week") {
                $stats[$result['d_date'] . " " . $result['year']] = $result['num'];
            } else {
                $stats[$result['d_date']] = $result['num'];
            }
        }
        return $stats;
    }

    public function countBy($type = "day", $period = 10, $filters = array())
    {
        $period = $period -1;
        if ($type == "month") {
            $key = "M";
        } elseif ($type == "week") {
            $key = "W";
        } else {
            $key = "D";
        }

        $date = new \DateTime();
        $date->sub(new DateInterval('P'. $period . $key));
        $period = $date->format('Y-m-d H:i:s');
        return $this->messageModel->countByPeriod($period, $key, $filters);
    }
}
