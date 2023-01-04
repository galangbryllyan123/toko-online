<?php

class Madhouse_Messenger_Services_EmailService
{
    public static function newInstance()
    {
        return new self();
    }

    public function __construct()
    {
    }

    /**
     * Notify the administrator(s) that a user has been blocked, for moderation purpose.
     *
     * @param  Madhouse_User $user.
     * @param  Madhouse_User $blockedUser.
     *
     * @return void.
     */
    public function notifyBlockedUserAdmin($user, $blockedUser)
    {
        $now = new \DateTime();
        Madhouse_Utils_Emails::send(
            "email_admin_on_blocked_user",
            array(
                "{USER_NAME}" => $user->getName(),
                "{BLOCKED_USER_NAME}" => $blockedUser->getName(),
                "{ADMIN_USER_URL}" => osc_admin_base_url(true) . "?page=users&amp;userId=" . $blockedUser->getId(). "&amp;user=". $blockedUser->getName(),
                "{CREATION_DATE}" => $now->format(osc_date_format()),
            ),
            array(),
            array()
        );
    }

    public static function notifyNewMessage($message, $thread, $reply = false)
    {
        $emailName = ($reply) ? 'email_mmessenger_reply_user' : 'email_mmessenger_contact_user';

        $trash = Madhouse_Messenger_Models_Labels::newInstance()->findByName("trash");

        // For each recipient in the recipients list.
        foreach ($message->getRecipients() as $recipient) {
            // Always send a notification if the user isn't registered
            if (!$recipient->isRegistered()) {
                self::notify($recipient, $message, $thread, $emailName);
            } elseif ($recipient->isRegistered() && !$thread->hasLabel($trash, $recipient)) {

                // Number of unread messages for this recipient (user).
                $nbUnread = Madhouse_Messenger_Models_Messages::newInstance()->countByUser(
                    $recipient,
                    array(
                        "label" => Madhouse_Messenger_Models_Labels::newInstance()->findByName("inbox"),
                        "received" => true,
                        "unread" => true
                    )
                );

                if (
                    (osc_get_preference('notify_everytime', mdh_current_preferences_section()) && !$reply) ||
                    $nbUnread <= osc_get_preference('stop_notify_after', mdh_current_preferences_section())
                ) {
                    // Send a notification for each first message if notify everytime is true
                    // Or unread messages is under or equal stop_notify_after setting
                    self::notify($recipient, $message, $thread, $emailName);
                } elseif($nbUnread % osc_get_preference('reminder_every', mdh_current_preferences_section()) == 0) {

                    // Send reminder each 'reminder every' setting
                    Madhouse_Utils_Emails::send(
                        "email_alert_mmessenger_messages",
                        array(
                            "{NB_UNREAD_MESSAGES}" => $nbUnread
                        ),
                        array($recipient),
                        array($message)
                    );
                }
            }
        }
    }

    public static function notifyReply($message, $thread)
    {
        // Notify for a new message
        self::notifyNewMessage($message, $thread, true);
    }

    public static function notifyContact($message, $thread)
    {
        // Notify for a new message
        self::notifyNewMessage($message, $thread, false);
    }

    public static function notifySender($message, $thread)
    {
        if (!$message->getSender()->isRegistered()) {
            self::notify($message->getSender(), $message, $thread, 'email_mmessenger_contact_sender');
        }
    }

    /**
     * Notify users that they have some messages waiting in the inbox.
     * @param  Madhouse_Messenger_Message $message the new message to notify its recipients about.
     * @return void
     * @since  1.25
     */
    public static function notify($recipient, $message, $thread, $emailName)
    {
        if(osc_get_preference('enable_notifications', mdh_current_preferences_section())) {
            $threadUrl = ($recipient->isRegistered()) ? mdh_messenger_thread_url($thread->getId()) : mdh_messenger_thread_url($thread->getId(), $thread->getSecret(), $recipient->getEmail());

            $itemTitle = ($message->getThread()->hasItem()) ? $message->getThread()->getItem()->getTitle() : __("No related item", mdh_current_plugin_name());
            $itemUrl   = ($message->getThread()->hasItem()) ? $message->getThread()->getItem()->getURL() : "#";
            $itemLink  = sprintf('<a href="%s">%s</a>', $itemUrl, $itemTitle);

            $params = array(
                "{SENDER_NAME}"      => $message->getSender()->getName(),
                "{SENDER_URL}"       => $message->getSender()->getURL(),
                "{SENDER_AVATAR}"    => $message->getSender()->getAvatar(),
                "{MESSAGE_EXCERPT}"  => $message->getExcerpt(osc_get_preference("email_excerpt_length", mdh_current_preferences_section()), osc_get_preference("email_excerpt_oneline", mdh_current_preferences_section())),
                "{MESSAGE_CONTENT}"  => $message->getText(),
                "{MESSAGE_DATE}"     => $message->getFormattedSentDate(),
                "{THREAD_URL}"       => $threadUrl,
                "{THREAD_LINK}"      => sprintf('<a href="%s">%s</a>', $threadUrl, __("See thread", mdh_current_plugin_name()), $threadUrl),
                "{ITEM_TITLE}"       => $itemTitle, // if has an item, get the URL. If not : "No related item"
                "{ITEM_URL}"         => $itemUrl, // if has an item, get the URL. If not : "#"
                "{ITEM_LINK}"        => $itemLink // if has an item, get the URL. If not : "#"
            );

            if (count($message->getRecipients()) == 1) {
                $recipients = $message->getRecipients();
                $params["{RECIPIENT_NAME}"]   = $recipients[0]->getName();
                $params["{RECIPIENT_URL}"]    = $recipients[0]->getURL();
                $params["{RECIPIENT_AVATAR}"] = $recipients[0]->getAvatar();
            }

            // Notification for you.
            Madhouse_Utils_Emails::send(
                $emailName,
                $params,
                array($recipient),
                array($message)
            );
        }
    }

    public static function notifyDaily()
    {
        if(osc_get_preference('enable_notifications', mdh_current_preferences_section()) && osc_get_preference('enable_reminders', mdh_current_preferences_section())) {
            $report = Madhouse_Messenger_Models_Messages::newInstance()->reportDaily();
            foreach($report as $r) {
                // This is today midnight.
                $tday = new \DateTime("today midnight");

                // This is the date of the last sent message.
                $start = new DateTime($r["date"]->format("Y-m-d"));

                // This is the date when we stop sending reminders.
                $end = new DateTime($start->format("Y-m-d"));
                $end->add(new \DateInterval(sprintf("P%dD", osc_get_preference("stop_reminder_after", mdh_current_preferences_section()))));

                /*
                 * Make sure the last message is older than today.
                 * If not, we do not send a reminder today, the user already got an
                 * email today.
                 */
                if($start < $tday && $tday < $end) {
                    // Compute the delta in days.
                    $delta = $tday->diff($start)->format("%a");
                    if($delta % osc_get_preference("reminder_every_days", mdh_current_preferences_section()) == 0) {
                        // Actually send the reminder.
                        Madhouse_Utils_Emails::send(
                            "email_alert_mmessenger_messages",
                            array(
                                "{NB_UNREAD_MESSAGES}" => $r["count"]
                            ),
                            array($r["user"])
                        );
                    }
                }
            }
        }
    }
}
