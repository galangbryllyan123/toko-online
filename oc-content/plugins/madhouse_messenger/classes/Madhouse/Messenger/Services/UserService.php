<?php

class Madhouse_Messenger_Services_UserService
{
    /**
     * Database object for Blocked Users feature.
     *
     * @var Madhouse_Messenger_Models_BlockedUsers
     */
    protected $modelBlockedUser;

    public static function newInstance()
    {
        return new self(
            Madhouse_Messenger_Models_BlockedUsers::newInstance()
        );
    }

    public function __construct($modelUser)
    {
        $this->modelBlockedUser = $modelUser;
    }

    /**
     * Is the user authorized to alter the thread in any way?
     *
     * In other words, is he part of the conversation, or has he been part if it
     * in the past.
     *
     * @param  Madhouse_User                      $user.
     * @param  Madhouse_Messenger_ThreadSummary   $thread.
     *
     * @return boolean.
     */
    public function isAuthorized($user, $thread)
    {
        if(! method_exists($thread, "getUsers")) {
            $thread = Madhouse_Messenger_Models_Threads::newInstance()->findByPrimaryKey($thread->getId());
        }

        $threadUsers = $thread->getUsers();
        foreach ($threadUsers as $threadUser) {
            if ($user->isRegistered() && $user->getId() === $threadUser->getId()) {
                return true;
            } elseif (!$user->isRegistered() && $user->getEmail() === $threadUser->getEmail()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Block a user $blockedUser for the user $user.
     *
     * @param  Madhouse_User $user
     * @param  String|Madhouse_User The blocked user (can be an id or an email).
     *
     * @return String|Madhouse_User
     */
    public function blockUser($user, $blockedUser)
    {
        if(! mdh_get_preference("enable_block_user")) {
            throw new Madhouse_AuthorizationException();
        }

        // User is deleted, can't do that.
        if ($blockedUser->isDeleted()) {
            throw new Madhouse_Messenger_ForbiddenOperationException(
                "User 'blockedUser' is deleted."
            );
        }

        // User is already blocked.
        if ($this->isBlocked($blockedUser, array($user))) {
            throw new Madhouse_Messenger_ForbiddenOperationException(
                "This user is already blocked"
            );
        }

        // Insert @ database.
        $this->modelBlockedUser->create($user, $blockedUser);

        // Run hook after user has been blocked.
        osc_run_hook("mdh_messenger_user_post_block", $user, $blockedUser);

        return $blockedUser;
    }

    /**
     * Unblock user $blockedUser for user $user.
     *
     * @param  Madhouse_User $user.
     * @param  Madhouse_User $blockedUser.
     *
     * @return String|Madhouse_User.
     */
    public function unblockUser($user, $blockedUser)
    {
        // User is deleted.
        if ($blockedUser->isDeleted()) {
            throw new Madhouse_Messenger_ForbiddenOperationException(
                "User 'blockedUser' is deleted."
            );
        }

        // If not blocked, throw an exception.
        if (!$this->isBlocked($blockedUser, array($user))) {
            throw new Madhouse_Messenger_ForbiddenOperationException(
                "This user isn't blocked"
            );
        }

        // Unblock user and return.
        return $this->modelBlockedUser->removeBlockedUser($user, $blockedUser);
    }

    /**
     * Is the sender authorized to send a message to $recipients?
     *
     * @param  Madhouse_User         $sender.
     * @param  array<Madhouse_User>  $recipients
     *
     * @return boolean
     */
    public function isBlocked($sender, $recipients)
    {
        foreach ($recipients as $recipient) {
            $isBlocked = $this->modelBlockedUser->findByUserAndBlockedUser($recipient, $sender);
            if (count($isBlocked) > 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Mark all messages of a given $user user as spam (reported).
     *
     * This is different than block user feature where a user blocks another user. This is ONLY used by administrators
     * for moderation purposes.
     *
     * @param  Madhouse_User $user          The user for whom we want to block his messages.
     *
     * @return void
     *
     * @throws InvalidArgumentException     If the user is not a Madhouse_User object.
     *
     * @since  1.30
     */
    public static function disableUser($user)
    {
        if(!$user instanceof Madhouse_User) {
            throw new InvalidArgumentException(
                "'user' must be a valid instance of Madhouse_User"
            );
        }

        // Just set all messages as spam=true.
        return Madhouse_Messenger_Models_Messages::newInstance()->setBlockByUser($user, true);
    }

    /**
     * Unmark all messages of a given $user user as spam (reported).
     *
     * This is different than block user feature where a user blocks another user. This is ONLY used by administrators
     * for moderation purposes.
     *
     * @param  Madhouse_User $user          The user for whom we want to block his messages.
     *
     * @return void
     *
     * @throws InvalidArgumentException     If the user is not a Madhouse_User object.
     *
     * @since  1.30
     */
    public static function enableUser($user)
    {
        if(! $user instanceof Madhouse_User) {
            throw new InvalidArgumentException(
                "'user' must be a valid instance of Madhouse_User"
            );
        }

        // Just set all messages as spam=false.
        Madhouse_Messenger_Models_Messages::newInstance()->setBlockByUser($user, false);
    }
}
