<?php

class Madhouse_Messenger_Services_MessengerService
{
    /**
     * Thread service object.
     *
     * @var Madhouse_Messenger_Services_ServiceInterface
     */
    protected $threads;

    /**
     * Message service object.
     *
     * @var Madhouse_Messenger_Services_ServiceInterface
     */
    protected $messages;

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
            Madhouse_Messenger_Services_SettingsService::newInstance(),
            Madhouse_Messenger_Services_ThreadService::newInstance(),
            Madhouse_Messenger_Services_MessageService::newInstance(),
            Madhouse_Messenger_Services_UserService::newInstance(),
            Madhouse_Messenger_Services_ResourceUploader::newInstance()
        );
    }

    /**
     * Constructor.
     *
     * @param Madhouse_Messenger_Services_ServiceInterface $threadService
     * @param Madhouse_Messenger_Services_ServiceInterface $messageService
     */
    public function __construct($settingsService, $threadService, $messageService, $userService, $resourceService)
    {
        $this->settings = $settingsService;
        $this->threads = $threadService;
        $this->messages = $messageService;
        $this->resources = $resourceService;
        $this->users = $userService;
    }

    /**
     * Contact between users.
     *
     * User $sender is sending a message $content to each user in $recipients (opt. about an item $item).
     *
     * @param $content content of the message to send.
     * @param $sender user sending the message (Madhouse_User).
     * @param $recipients list of the recipients of the message (array of Madhouse_User objects).
     * @param $item item to link to the message/thread.
     *
     * @return void.
     *
     * @since 1.22
     */
    public function contact($message, $uploadedFiles = null, $item = null, $title = null)
    {
        if (!$message instanceof Madhouse_Messenger_Message) {
            throw new InvalidArgumentException(
                "'message' must be a valid Madhouse_Messenger_Message"
            );
        }

        // Get the sender.
        $sender = $message->getSender();

        if ($sender->isShim() && ($sender->getName("") == false || $sender->getEmail() == false)) {
            throw new Madhouse_Messenger_ForbiddenOperationException(
                "Sender is not valid",
                4
            );
        }

        // If sender isn't registered test if email is existing in user table
        if (!$sender->isRegistered()) {
            if (count(User::newInstance()->findByEmail($sender->getEmail())) > 0) {
                throw new Madhouse_Messenger_ForbiddenOperationException(
                    "User already registered",
                    1
                );
            }
        }

        if (!$sender->isRegistered() && $this->settings->isRegisteredOnlyEnabled()) {
            throw new Madhouse_Messenger_ForbiddenOperationException(
                "Only registered users can contact an item.",
                3
            );
        }

        // Get recipients from the message.
        $recipients = $message->getRecipients();

        // Filter recipients to remove deleted / duplicate.
        $frecipients = $this->messages->filterRecipients($sender, $recipients);
        if(count($frecipients) === 0) {
            throw new Madhouse_Messenger_NoValidRecipientsException();
        }

        // Upload resources, if any, transform uploaded files into qualified resources.
        if ($this->settings->isAttachementEnabled()) {
            $resources = $this->resources->uploadResources($uploadedFiles);
            $message->withResources($resources);
        }

        // Hook before a contact form has been filled.
        osc_run_hook("mdh_messenger_pre_contact");

        if (count($frecipients) > 1) {
            /**
             * GROUP MESSAGE.
             * Just create a new thread with $content as first message.
             * (no check for existing thread)
             */
            $thread = $this->threads->createThread($message, $item, $title);
        } else {
            /**
             * REGULAR ONE-TO-ONE MESSAGE.
             * IF:   a thread already exists, append a new message to it.
             * ELSE: a thread is created with $content as first message.
             */
            $thread = $this->threads->findThreadByUsers(
                $sender,
                $frecipients[0],
                (isset($item["pk_i_id"])) ? $item["pk_i_id"] : null
            );

            if(isset($thread) && !empty($thread)) {
                $message->setThread($thread);
                $thread = $this->replyToThread($message);

                // Hook after a contact form has been filled again.
                osc_run_hook("mdh_messenger_post_contacted_again", $message, $thread);
            } else {
                $thread = $this->createThread($message, $item, $title);
            }
        }

        // Hook after an item has been contacted.
        osc_run_hook("mdh_messenger_post_contact", $message, $thread);

        return $thread;
    }

    public function createThread($newMessage, $item, $title)
    {
        // Check if the recipient blocked the sender
        if ($this->users->isBlocked($newMessage->getSender(), $newMessage->getRecipients())) {
            throw new Madhouse_Messenger_ForbiddenOperationException(
                "This user blocked you",
                2
            );
        }

        $resources = $newMessage->getResources();

        try {
            // Create the thread from this first message.
            $thread = $this->threads->createThread($newMessage, $item, $title);
            $message = $thread->getLastMessage();

            // Attach resources to the message.
            if ($this->settings->isAttachementEnabled()) {
                $this->resources->attachResources($resources, $message);
            }
        } catch (Exception $e) {
            // Delete all uploaded resources.
            foreach ($resources as $resource) {
                $this->resources->deleteResource($resource);
            }

            // Rethrow exception to higher level debug..
            throw $e;
        }

        // Re-get the thread since it has been modified.
        $thread = $this->threads->findThreadById($thread->getId());

        // Hook after a contact form has been filled for the first time.
        osc_run_hook("mdh_messenger_post_contact_first", $message, $thread);

        // Return the new thread.
        return $thread;
    }

    public function replyToThread($message)
    {
        $sender = $message->getSender();
        $thread = $message->getThread();
        $resources = $message->getResources();

        if(!$thread instanceof Madhouse_Messenger_ThreadSkeleton) {
            throw new InvalidArgumentException(
                "'thread' must be a valid instance of Madhouse_Messenger_ThreadSkeleton"
            );
        }

        // If user isn't registered but the thread already exist, get it in the thread (Avoid name edition)
        if (!$sender->isRegistered()) {
            foreach ($thread->getUsers() as $threadUser) {
                if ($sender->getEmail() == $threadUser->getEmail()) {
                    $message->setSender($threadUser);
                }
            }
        }

        try {
            if(!$this->users->isAuthorized($message->getSender(), $thread)) {
                throw new Madhouse_AuthorizationException(
                    "'sender' is not authorized to modify this thread."
                );
            }

            // Check if the recipient blocked the sender
            if ($this->users->isBlocked($message->getSender(), $message->getRecipients())) {
                throw new Madhouse_Messenger_ForbiddenOperationException(
                    "This user blocked you",
                    2
                );
            }

            // Actually create the message.
            $message = $this->messages->createMessage($message, $thread);

            // Update resources and set them in the message.
            if ($this->settings->isAttachementEnabled()) {
                $resources = $this->resources->attachResources($resources, $message);
                $message->withResources($resources);
            }
        } catch (Exception $e) {
            // Delete all uploaded resources.
            foreach ($resources as $resource) {
                $this->resources->deleteResource($resource);
            }

            // Rethrow exception to higher level debug..
            throw $e;
        }

        // Update the thread if necessary.
        $this->wakeUp($thread);

        // Re-get the thread since it has been modified.
        $thread = $this->threads->findThreadById($thread->getId());

        // Return the updated thread.
        return $thread;
    }

    /**
     * Reply to a thread.
     *
     * @param $content content of the message to send.
     * @param $sender user sending the message (Madhouse_User).
     * @param $recipients list of the recipients of the message (array of Madhouse_User objects).
     * @param $thread the thread to send the message in (Madhouse_Messenger_Thread).
     *
     * @return void.
     *
     * @since 1.22.
     */
    public function reply($thread, $message, $uploadedFiles)
    {

        // Upload resources, if any.
        if ($this->settings->isAttachementEnabled()) {
            $resources = $this->resources->uploadResources($uploadedFiles);
            $message->withResources($resources);
        }

        osc_run_hook("mdh_messenger_pre_reply", $message, $thread);

        // Actually reply to thread $thread.
        $thread = $this->replyToThread($message);

        osc_run_hook("mdh_messenger_post_reply", $message, $thread);

        return $thread;
    }

    /**
     * Broadcast a message (with optional event) to a bunch of threads related
     * to an item or a user.
     *
     * @param  Madhouse_Item|Madhouse_User  $itemOrUser
     * @param  string                       $content
     * @param  Madhouse_Messenger_Event     $event
     * @param  boolean                      $onlyUnanswered
     *
     * @return array
     */
    public function broadcast($itemOrUser, $content = null, $event = null, $onlyUnanswered = false)
    {
        if(is_null($event) && (!isset($content) || empty($content))) {
            throw new Madhouse_Messenger_EmptyMessageException();
        }

        if($itemOrUser instanceof Madhouse_User) {
            if (!$itemOrUser->isRegistered()) {
                // We can't do that for non-registered users.
                throw new Madhouse_Messenger_ForbiddenOperationException(
                    "'itemOrUser' is not a registered user"
                );
            }

            // Find all matching thread for this user.
            $threads = $this->threads->findAll(
                array(
                    "user" => $itemOrUser,
                    "label" => "inbox",
                )
            );

            // Set sender for this broadcast message.
            $sender = $itemOrUser;
        } else if($itemOrUser instanceof Madhouse_Item) {
            // Find all matching threads for this item.
            $threads = $this->threads->findAll(
                array(
                    "item" => $itemOrUser,
                    "label" => "inbox",
                )
            );

            // Set sender for this broadcast message.
            if ($itemOrUser->getUserId()) {
                $sender = Madhouse_Utils_Models::findUserByPrimaryKey($itemOrUser->getUserId());
            } else {
                $sender = new Madhouse_User(
                    array(
                        "s_name" => $itemOrUser->getContactName(),
                        "s_email" => $itemOrUser->getContactEmail(),
                    )
                );
            }
        } else {
            // Can't match $itemOrUser to any allowed type.
            throw new InvalidArgumentException(
                "'itemOrUser' must be a valid Madhouse_User or Madhouse_Item object"
            );
        }

        // Iterate over all threads.
        $broadcastedMessages = array();
        foreach ($threads as $t) {
            if(
                $onlyUnanswered === false
                || $onlyUnanswered === true && $sender != $t->getLastMessage()->getSender()
            ) {
                // Maximum number of days allowed for a thread.
                $delta = mdh_get_preference("automessage_newer_days");

                // Oldest date allowed.
                $sent = new \DateTime($t->getLastMessage()->getSentDate());
                $max = new \DateTime("today midnight");
                $max->sub(new \DateInterval(sprintf("P%dD", $delta)));

                if(empty($delta) || $delta === 0 || $max < $sent) {
                    // Filter recipients of the new message.
                    $frecipients = $this->messages->filterRecipients($sender, $t->getUsers());

                    // If there's recipients left in the thread.
                    if(count($frecipients) > 0) {
                        // Create the candidate message to send.
                        $nm = new Madhouse_Messenger_Message(
                            $content,
                            $sender,
                            $frecipients
                        );
                        // Set thread.
                        $nm->setThread($t);

                        // Set the event, if necessary.
                        if(!is_null($event)) {
                            $nm->withEvent($event);
                        }

                        // Create the message and store it for latter use.
                        $broadcastedMessages[] = $this->messages->createMessage($nm, $t);
                    }
                }
            }
        }

        // Return a list of all messages sent.
        return $broadcastedMessages;
    }

    public function applyStatus($thread, $newStatus, $user)
    {
        if(!$this->users->isAuthorized($user, $thread) || !mdh_messenger_status_enabled() ||
            ($thread->hasItem() && mdh_messenger_status_for_owner() && (($user->isRegistered() && $user->getId() != $thread->getItem()->getUserId()) || ((!$user->isRegistered() && $user->getEmail() != $thread->getItem()->getContactEmail()))))
        ) {
            throw new Madhouse_AuthorizationException(
                "'user' is not authorized to modify this thread."
            );
        }

        // Check recipients for the status message.
        $filteredRecipients = $this->messages->filterRecipients($user, $thread->getUsers());
        if(count($filteredRecipients) === 0) {
            throw new Madhouse_Messenger_NoValidRecipientsException();
        }

        // Apply status change on the thread.
        $thread->withStatus($newStatus);
        $thread = $this->threads->updateThread($thread);

        // Create an auto-message to notify the status change.
        $newMessage = new Madhouse_Messenger_Message("", $user, $filteredRecipients);
        $newMessage
            ->setThread($thread)
            ->withStatus($newStatus)
            ->withEvent(
                Madhouse_Messenger_Models_Events::newInstance()->findByName("status_change")
            );

        // Create a new message in the given $thread.
        $message = $this->messages->createMessage($newMessage, $thread);

        // Run the reply hook (because a status can only be applied at replying).
        osc_run_hook("mdh_messenger_post_reply", $message, $thread);

        // Return the message.
        return $message;
    }

    public function wakeUp($thread)
    {
        $archiveLabel = Madhouse_Messenger_Models_Labels::newInstance()->findByName("archive");
        $inboxLabel = Madhouse_Messenger_Models_Labels::newInstance()->findByName("inbox");

        foreach ($thread->getUsers() as $user) {
            if ($thread->hasLabel($archiveLabel, $user)) {
                Madhouse_Messenger_ThreadActions::addLabel($thread, $user, $inboxLabel);
            }
        }
    }

    /**
     * Hook after item&action=contact_post or page=user&action=contact_post.
     *
     * This will intercept the request and redirect it to messenger controller
     * to send the message in a thread instead of sending an email (default
     * Osclass action).
     *
     * @return void
     */
    public function onContactPost()
    {
        if (Params::getParam("phoneNumber") != "") {
            // Append phone number at the end of the message since messenger does not have this field.
            Params::setParam(
                "message",
                Params::getParam("message") . "\n\n" . sprintf(__("Phone number: %s", mdh_current_plugin_name()), Params::getParam("phoneNumber"))
            );
        }

        // Forward request to Messenger controller.
        Params::setParam("route", mdh_current_plugin_name() . "_send");
        $do = new Madhouse_Messenger_Controllers_WebNonSecure();
        $do->doModel();
    }

    /**
     * Hook after an item is deleted to broadcast a message to all threads of
     * that particular item.
     *
     * @param  array $item
     *
     * @return array        List of all broadcasted messages.
     */
    public function onItemDelete($item)
    {
        // Get message and event if necessary.
        $messageText = Params::getParam("mdhMessengerBroadcast");
        $event = null;
        if(empty($message)) {
            // Get the event @ database.
            $event = Madhouse_Messenger_Models_Events::newInstance()->findByName("item_deleted");
        }

        // Send the message to all threads matching item.
        return $this->broadcast(new Madhouse_Item($item), $messageText, $event);
    }


    /**
     * Hook after an item is marked as spam to broadcast a message to all threads
     * of that particular item.
     *
     * @param  array $item
     *
     * @return array        List of all broadcasted messages.
     */
    public function onItemSpam($item)
    {
        // Find the event @ database.
        $event = Madhouse_Messenger_Models_Events::newInstance()->findByName("item_spammed");

        // Send the message to all threads matching item.
        $this->broadcast(new Madhouse_Item($item), null, $event);
    }

    /**
     * Update all messages and blocked users rules for a new registered user.
     *
     * @param  int|array $user
     *
     * @return void.
     */
    public function onUserRegister($user)
    {
        try {
            if (is_array($user)) {
                // Build a proper object.
                $userId = $user["pk_i_id"];
            } else {
                // $user is a pk_i_id, find the user @ database.
                $userId = $user;
            }

            // Re-get the user to make sure it is up-to-date.
            $user = Madhouse_Utils_Models::findUserByPrimaryKey($userId);

            if ($user->isActive()) {
                // Update all sent and recieved messages.
                Madhouse_Messenger_Models_Messages::newInstance()->registerUser($user);
                Madhouse_Messenger_Models_Recipients::newInstance()->registerUser($user);

                // Update all blocked users rules.
                Madhouse_Messenger_Models_BlockedUsers::newInstance()->registerUser($user);

                // Find all threads to update.
                $threads = $this->threads->findAll(array("user" => $user));

                // Find inbox label.
                $inbox = Madhouse_Messenger_Models_Labels::newInstance()->findByName("inbox");

                // Process each threads to apply the inbox label on them.
                foreach ($threads as $t) {
                    $t = Madhouse_Messenger_ThreadActions::addLabel($t, $user, $inbox);
                }
            }
        } catch (Exception $e) {
            // Ignore them all, never throw exception in hooks.
            // @TODO logs maybe.
        }
    }
}
