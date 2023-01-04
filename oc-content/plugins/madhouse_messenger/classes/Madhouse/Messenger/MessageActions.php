<?php

class Madhouse_Messenger_MessageActions
{
    /**
     * Deletes (hide) a message $message for user $user.
     * @param $message Madhouse_Messenger_Message to delete.
     * @param $user Madhouse_User that wants to delete the message.
     * @return void
     * @throws Madhouse_AuthorizationException
     * @throws Madhouse_QueryFailedException
     * @since 1.22
     */
    public static function delete($message, $user)
    {
        /*
         * Check that the current user is part of the thread
         * in which the message he tries to delete belongs to.
         */
        if(!Madhouse_Messenger_Services_UserService::newInstance()->isAuthorized($user, $message->getThread())) {
            throw new Madhouse_AuthorizationException(
                "'sender' is not authorized to modify this thread."
            );
        }

        if(! $message->isHiddenFor($user->getId())) {
            // If the message is already hidden, don't do anything.
        	if (osc_get_preference('delete_mode', mdh_current_preferences_section())) {

                foreach ($message->getRecipients() as $user) {
                    Madhouse_Messenger_Models_Recipients::newInstance()->hide($message, $user);
                }

                Madhouse_Messenger_Models_Messages::newInstance()->hide($message);
            } elseif($message->getSender()->getId() == $user->getId()) {
        	    // Hide the message as sender of it.
        		Madhouse_Messenger_Models_Messages::newInstance()->hide($message);
        	} else {
        	    // Hide the message as recipient of it.
        		Madhouse_Messenger_Models_Recipients::newInstance()->hide($message, $user);
        	}
        }
    }
}

?>