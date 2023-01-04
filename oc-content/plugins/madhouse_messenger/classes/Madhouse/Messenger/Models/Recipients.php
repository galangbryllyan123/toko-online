<?php

/**
 *
 *
 *
 * @since 1.10
 */
class Madhouse_Messenger_Models_Recipients extends DAO
{
	/**
	 * Singleton.
	 */
	private static $instance;

	/**
	 * Singleton constructor.
	 * @return an MadhouseMessengerDAO object.
	 */
	public static function newInstance()
	{
		if(!self::$instance instanceof self) {
			self::$instance = new self;
		}
		return self::$instance;
	}

    public function __construct()
    {
        parent::__construct();
        $this->setTableName('t_mmessenger_recipients');
        $this->setFields(
            array("pk_i_id", "message_id", "recipient_id", "s_contact_name", "s_contact_email", "sentOn", "hidden"));
        $this->setPrimaryKey("pk_i_id"); // USELESS.
    }

    /**
     * Gets the overall state of a message.
     *
     * Gets the read and hidden state for each user receiving
     * a message.
     * @param TODO
     * @return an associative array, where key is user and value is
     * the read and hidden state for this user.
     * @since 1.10
     */
    public function getState($messageId) {
        return Madhouse_Utils_Models::get(
            $this,
            function($dao) use ($messageId) {
                $dao->dao->select();
                $dao->dao->from($dao->getTableName());
                $dao->dao->where("message_id", $messageId);
            },
            function($res, $dao) {
                $gstate = array();
                foreach ($res->result() as $r) {
                    if (isset($r["recipient_id"]) && !empty($r["recipient_id"])) {
                        $recipient = Madhouse_Utils_Models::findUserByPrimaryKey($r["recipient_id"]);
                    } else {
                        $recipient = new Madhouse_User(
                            array(
                                "s_name" => $r["s_contact_name"],
                                "s_email" => $r["s_contact_email"],
                            )
                        );
                    }

                	$gstate[] = array(
                        "recipient" => $recipient,
                	    "readOn" => $r["readOn"],
                	    "hidden" => $r["hidden"]
                	);
                }

                return $gstate;
            }
        );
    }

    public function send($messageId, $recipients) {
        /*
         * Send the message to each recipients.
         */
        foreach($recipients as $recipient) {
            $data = array(
                "message_id" => $messageId,
            );

            if ($recipient->isRegistered() === false) {
                /*
                 * Recipient is not a registered user:
                 * Send message and store name and email locally.
                 */
                $data["s_contact_name"] = $recipient->getName();
                $data["s_contact_email"] = $recipient->getEmail();
            } elseif ($recipient->isRegistered() === true) {
                /*
                 * Recipient is a registered user:
                 * Send message and just link it to the user.
                 */
                $data["recipient_id"] = $recipient->getId();
            } else {
                /*
                 * Recipient $recipient is a shim user, probably deleted user...
                 * @TODO: exception ? means rollback for previous.
                 */
            }

            // Create message @ database.
            $insert = $this->insert($data);

        	if($insert === false) {
                // @TODO kick that exception ? rollback ?
        	    throw new Madhouse_Messenger_NotSentException($this->dao->getErrorDesc());
        	}
        }
    }

    /**
     * Mark that the messages of a particular thread have been read by a user.
     * @param $messages array of message (Madhouse_Messenger_Message object).
     * @param $userId if of the user that read the messages.
     * @return void.
     * @throw Madhouse_QueryFailedException if the SQL UPDATE failed.
     */
    public function read($messages, $user)
    {
    	// Update the messages to mark them as read by this user.
    	$this->dao->from($this->getTableName());
    	$this->dao->set(
    	    array(
    		    "readOn" => date("Y-m-d H:i:s")
    	    )
    	);

        if ($user->isRegistered()) {
            $this->dao->where("recipient_id", $user->getId());
        } else {
            $this->dao->where("s_contact_email", $user->getEmail());
        }

    	$this->dao->whereIn(
    	    "message_id",
    	    Madhouse_Utils_Collections::getIdsFromList($messages)
    	);

    	$isUpdated = $this->dao->update();
    	if($isUpdated === false) {
    		throw new Madhouse_QueryFailedException($this->dao->getErrorDesc());
    	}

        return $isUpdated;
    }

    /**
     * Hides the message $messageId for user $userId.
     * @param $messageId the id of the message to hide.
     * @param $userId the id of the user that received the message.
     * @return void.
     * @throw Madhouse_QueryFailedException if the SQL UPDATE failed.
     */
    public function hide($message, $user)
    {
        // Update the messages to mark them as read by this user.
        $this->dao->from($this->getTableName());
        $this->dao->set(
            array(
                "hidden" => true
            )
        );

        if ($user->isRegistered()) {
            $this->dao->where("recipient_id", $user->getId());
        } else {
            $this->dao->where("s_contact_email", $user->getEmail());
        }

        $this->dao->whereIn(
            "message_id",
            $message->getId()
        );

        $isUpdated = $this->dao->update();
        if($isUpdated === false) {
            throw new Madhouse_QueryFailedException($this->dao->getErrorDesc());
        }

        return $isUpdated;
    }

    /**
     * Mark that the messages of a particular thread has unread.
     * @param $messages array of message (Madhouse_Messenger_Message object).
     * @param $userId if of the user that read the messages.
     * @return void.
     * @throw Madhouse_QueryFailedException if the SQL UPDATE failed.
     */
    public function unread($messages, $user)
    {
        // Update the messages to mark them as read by this user.
        $this->dao->from($this->getTableName());
        $this->dao->set(
            array(
                "readOn" => null
            )
        );
        $this->dao->where("recipient_id", $user->getId());
        $this->dao->whereIn(
            "message_id",
            Madhouse_Utils_Collections::getIdsFromList($messages)
        );


        $isUpdated = $this->dao->update();
        if($isUpdated === false) {
            throw new Madhouse_QueryFailedException($this->dao->getErrorDesc());
        }

        return $isUpdated;
    }

    /**
     * Set sender id when user registers
     * @param  Madhouse_User $user  the user that is registered.
     * @return Int                  number of messages that have been blocked/unblocked.
     */
    public function registerUser($user)
    {
        $updated = $this->update(
            array(
                "s_contact_email" => null,
                "s_contact_name" => null,
                "recipient_id"      => $user->getId()
            ),
            array(
                "s_contact_email" => $user->getEmail()
            )
        );
        if($updated === false) {
            throw new Madhouse_QueryFailedException($this->dao->getErrorDesc());
        }

        // Number of messages that have been blocked.
        return $updated;
    }
}

?>