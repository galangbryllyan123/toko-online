<?php

/**
 * DAO class for messages.
 *
 * Messages are at the core of the messenger plugin.
 * They are organise into threads.
 *
 * @since  1.10
 */
class Madhouse_Messenger_Models_Messages extends Madhouse_Messenger_Models_MessagesBase
{
	/**
	 * Singleton.
	 */
	private static $instance;

    public $recipientsDAO;

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
        $this->setTableName('t_mmessenger_message');
        $this->setPrimaryKey("id");
        $this->setFields(array("id", "content", "sentOn", "hidden", "reported", "root_id", "sender_id", "s_contact_name", "s_contact_email", "status_id", "event_id", "item_id"));

        $this->recipientsDAO = Madhouse_Messenger_Models_Recipients::newInstance();
    }

    public function getSelectedField()
    {
        return join(
            ",",
            array_merge(
                Madhouse_Utils_Models::getFieldsPrefixed($this, "m"),
                Madhouse_Utils_Models::getFieldsPrefixed(Madhouse_Messenger_Models_Threads::newInstance(), "t", "thread_")
            )
        );
    }

    /**
     * Finds a message by its UID.
     * @param $messageId the unique-identifier of the message.
     * @return instance of Madhouse_Messenger_Message.
     * @thows Exception if query fails.
     * @since 1.10
     */
    public function findByPrimaryKey($messageId)
    {
        return Madhouse_Utils_Models::get(
            $this,
            function($dao) use ($messageId) {
                $dao->dao->select($dao->getSelectedField());
                $dao->dao->from($dao->getTableName() . " AS m");
                $dao->dao->join(sprintf("%s AS t", $dao->getTableName()), "t.id = m.root_id", "INNER");
                $dao->dao->where("m.id", $messageId);
            },
            function($r, $dao) {
                return $dao->buildObject($r->row());
            }
        );
    }

    /**
     * Finds the $max messages starting from page $page.
     * @param $page page number.
     * @param $max number of element to query.
     * @return Array<Madhouse_Messenger_Message>
     * @throws Exception if query fails.
     * @since 1.10
     */
    public function findAll($page=1, $max=50) {
        return Madhouse_Utils_Models::get(
            $this,
            function($dao) use ($page, $max) {
                $dao->dao->select($dao->getSelectedField());
                $dao->dao->from(sprintf("%s AS m", $dao->getTableName()));
                $dao->dao->join(sprintf("%s AS t", $dao->getTableName()), "t.id = m.root_id", "INNER");
                $dao->dao->orderBy(sprintf("m.id DESC LIMIT %d, %d", (($page-1) * $max), $max));
            },
            function($r, $dao) {
                return array_map(
                    function($v) use ($dao) {
                        return $dao->buildObject($v);
                    },
                    $r->result()
                );
            },
            false,
            array()
        );
    }

    /**
     * Finds all the message sent by a user.
     * @param $userId the UID of the user.
     * @param $page pagination parameter.
     * @param $max number of messages per page.
     * @return an array of Madhouse_Messenger_Message.
     */
    public function findByUser($user, $filters=null, $page=null, $max=null)
    {
        return Madhouse_Utils_Models::get(
            $this,
            function($dao) use ($user, $page, $max) {
                $dao->dao->select($dao->getSelectedField());
                $dao->dao->from(sprintf("%s AS m", $dao->getTableName()));
                $dao->dao->join(sprintf("%s AS t", $dao->getTableName()), "m.root_id = t.id");

                if ($user->isRegistered()) {
                    $dao->dao->where("m.sender_id", $user->getId());
                } else {
                    $dao->dao->where("m.s_contact_email", $user->getEmail());
                }

                if(!is_null($page) && !is_null($max)) {
                    $dao->dao->limit(($page-1) * $max, $max);
                }
                $dao->dao->orderBy("m.id", "DESC");
            },
            function($r, $dao) {
                return array_map(
                    function($v) use ($dao) {
                        return $dao->buildObject($v);
                    },
                    $r->result()
                );
            },
            false,
            array()
        );
    }

    /**
     * Gets the (total) number of messages in a thread.
     * @param $threadId the id of the thread.
     * @returns an int.
     */
    public function countByUser($user, $filters = null)
    {
        if(is_null($filters)) {
            $filters = array();
        }

        /*
         * Filter 'sent' / 'received'
         */
        $userFilter = "";
        $filterSent = (isset($filters["sent"]) && $filters["sent"] == true) ? true : false;
        $filterReceived = (isset($filters["received"]) && $filters["received"] == true) ? true : false;
        if ($user->isRegistered()) {
            if ($filterSent && !$filterReceived) {
                $userFilter = sprintf("m.sender_id = %d", $user->getId());
            } elseif (!$filterSent && $filterReceived) {
                $userFilter = sprintf("r.recipient_id = %d", $user->getId());
            } else {
                $userFilter = sprintf("(r.recipient_id = %d OR m.sender_id = %d)", $user->getId(), $user->getId());
            }
        } else {
            if ($filterSent && !$filterReceived) {
                $userFilter = sprintf("m.s_contact_email = '%s'", $user->getEmail());
            } elseif (!$filterSent && $filterReceived) {
                $userFilter = sprintf("r.s_contact_email = '%s'", $user->getEmail());
            } else {
                $userFilter = sprintf("(r.s_contact_email = '%s' OR m.s_contact_email = '%s')", $user->getEmail(), $user->getEmail());
            }
        }

        $threadsDAO = Madhouse_Messenger_Models_Threads::newInstance();

        // More complex query to handle all filters combination.
        return Madhouse_Utils_Models::get(
            $this,
            sprintf("SELECT COUNT(r.message_id) AS count
                     FROM %s as r
                     JOIN %s as m
                        ON m.id = r.message_id
                     JOIN %s as t
                        ON t.id = m.root_id
                     %s
                     WHERE
                     %s
                     %s
                     %s
                ",
                $this->recipientsDAO->getTableName(),
                $this->getTableName(),
                $threadsDAO->getTableName(),
                (
                    ($user->isRegistered() && isset($filters["label"])) ?
                        $this->filterOnLabels($user, $filters["label"])
                    :
                        ""
                ),
                $userFilter,
                (
                    (isset($filters["thread"])) ?
                        sprintf(
                            "AND (m.id = %d OR m.root_id = %d)",
                            $filters["thread"]->getId(),
                            $filters["thread"]->getId()
                        )
                    :
                        ""
                ),
                (
                    (isset($filters["unread"]) && $filters["unread"] === true) ?
                        "AND r.readOn IS NULL"
                    :
                        ""
                )
            ),
            function($r, $dao) {
                return $r->rowObject()->count;
            },
            false,
            0
        );
    }

    /**
     * Gets messages of a particular threadId.
     * @param $threadId the thread id
     * @param $page pagination parameter.
     * @param $max number of messages per page.
     * @return an array of Madhouse_Messenger_Message objects ordered from the latest to the oldest.
     */
    public function findByThread($thread, $page=1, $max=10)
    {
        return Madhouse_Utils_Models::get(
            $this,
            function($dao) use ($thread, $page, $max) {
                $dao->dao->select($dao->getSelectedField());
                $dao->dao->from(sprintf("%s AS m", $dao->getTableName()));
                $dao->dao->join(sprintf("%s AS t", $dao->getTableName()), "t.id = m.root_id", "INNER");
                $dao->dao->where(sprintf("m.id = %d OR m.root_id = %d", $thread->getId(), $thread->getId()));
                $dao->dao->orderBy(sprintf("m.id DESC LIMIT %d, %d", (($page-1) * $max), $max));
            },
            function($r, $dao) use ($thread) {
                return array_map(
                    function($v) use ($dao, $thread) {
                        return $dao->buildObject($v, $thread);
                    },
                    $r->result()
                );
            }
        );
    }

    /**
     * Gets messages of a particular threadId and user.
     * @param $thread the thread id
     * @param $user the user
     * @param $page pagination parameter.
     * @param $max number of messages per page.
     * @return an array of Madhouse_Messenger_Message objects ordered from the latest to the oldest.
     */
    public function findReceivedMessages($thread, $user, $page=1, $max=10)
    {
        return Madhouse_Utils_Models::get(
            $this,
            function($dao) use ($thread, $user, $page, $max) {
                $dao->dao->select($dao->getSelectedField());
                $dao->dao->from(sprintf("%s AS m", $dao->getTableName()));
                $dao->dao->join(sprintf("%s AS t", $dao->getTableName()), "t.id = m.root_id", "INNER");
                $dao->dao->where(sprintf("(m.id = %d OR m.root_id = %d)", $thread->getId(), $thread->getId()));
                // "m.sender_id IS NULL"  is necessary because 1 <> NULL == NULL
                // http://stackoverflow.com/questions/8994408/query-not-equal-doesnt-work
                $dao->dao->where(sprintf("(m.sender_id IS NULL OR m.sender_id <> %d)", $user->getId()));
                $dao->dao->orderBy(sprintf("m.id DESC LIMIT %d, %d", (($page-1) * $max), $max));
            },
            function($r, $dao) use ($thread) {
                return array_map(
                    function($v) use ($dao, $thread) {
                        return $dao->buildObject($v, $thread);
                    },
                    $r->result()
                );
            },
            false,
            array()
        );
    }

    /**
     * Gets the list of the unread messages UID of a thread.
     * @param $threadId the id of the thread
     * @param $userId id of the user that look at the thread
     * @returns an array of message UID objects ordered from the latest to the oldest.
     */
    public function findUnreadByThread($thread, $user)
    {


        return Madhouse_Utils_Models::get(
    	    $this,
    	    function($dao) use($thread, $user) {
    	        $dao->dao->select($dao->getSelectedField());
    	        $dao->dao->from(sprintf("%s AS m", $dao->getTableName()));
    	        $dao->dao->join(sprintf("%s AS r", $dao->recipientsDAO->getTableName()), 'm.id = r.message_id', 'INNER');
                $dao->dao->join(sprintf("%s AS t", $dao->getTableName()), "t.id = m.root_id", "INNER");

                if ($user->isRegistered()) {
                    $dao->dao->where("r.recipient_id", $user->getId());
                } else {
                    $dao->dao->where("r.s_contact_email", $user->getEmail());
                }

                $dao->dao->where("r.readOn IS NULL");
                $dao->dao->where(sprintf("(m.id = %d OR m.root_id = %d)", $thread->getId(), $thread->getId()));

    	        $dao->dao->orderBy("m.id DESC");
    	    },
    	    function($r, $dao) use ($thread) {
                return array_map(
                    function($v) use ($dao, $thread) {
                        return $dao->buildObject($v, $thread);
                    },
                    $r->result()
                );
            },
    	    false,
    	    array()
    	);
    }


    /**
     * Gets the (total) number of messages in a thread.
     * @param $threadId the id of the thread.
     * @returns an int.
     */
    public function countByThread($threadId)
    {
        return Madhouse_Utils_Models::countByField($this, "root_id", $threadId);
    }

    /**
     * Gets messages of a particular item.
     * @param $itemId the item id
     * @param $page pagination parameter.
     * @param $max number of messages per page.
     * @return an array of Madhouse_Messenger_Message objects ordered from the latest to the oldest.
     */
    public function findByItem($itemId, $page=1, $max=10)
    {
        return Madhouse_Utils_Models::get(
            $this,
            function($dao) use ($itemId, $page, $max) {
                $dao->dao->select($dao->getSelectedField());
                $dao->dao->from(sprintf("%s AS m", $dao->getTableName()));
                $dao->dao->join(sprintf("%s AS t", $dao->getTableName()), "t.id = m.root_id", "INNER");
                $dao->dao->where(sprintf("t.item_id = %d", $itemId));
                $dao->dao->orderBy(sprintf("m.id DESC LIMIT %d, %d", (($page-1) * $max), $max));
            },
            function($r, $dao) {
                return array_map(
                    function($v) use ($dao) {
                        return $dao->buildObject($v);
                    },
                    $r->result()
                );
            },
            false,
            array()
        );
    }

    public function findTemplateByUser($userId)
    {
        if ($userId == false) {
            // $userId is not an integer.
            throw new \InvalidArgumentException();
        }

        $that = $this;
        return Madhouse_Utils_Models::get(
            $this,
            function($dao) use ($userId) {
                $dao->dao->select($dao->getSelectedField());
                $dao->dao->from(sprintf("%s AS m", $dao->getTableName()));
                $dao->dao->join(sprintf("%s AS t", $dao->getTableName()), "t.id = m.root_id", "INNER");
                $dao->dao->where("m.root_id = m.id");
                $dao->dao->where(sprintf("m.sender_id = %d", $userId));
                $dao->dao->orderBy("m.id DESC");
                $dao->dao->limit(1);
            },
            function($r, $dao) use ($that) {
                return $that->buildObject($r->row());
            }
        );
    }

    /**
     * Gets the (total) number of messages linked to an item.
     * @param $itemId the id of the thread.
     * @returns an int.
     */
    public function countByItem($itemId)
    {
        return Madhouse_Utils_Models::get(
            $this,
            function($dao) use ($itemId) {
                $dao->dao->select("COUNT(1) as count");
                $dao->dao->from($dao->getTableName() . " AS t");
                $dao->dao->join($dao->getTableName() . " AS m", "t.id = m.root_id", "INNER");
                $dao->dao->where("t.item_id", $itemId);
            },
            function($r, $dao) {
                return $r->rowObject()->count;
            }
        );
    }

    public function countByPeriod($period, $periodType = 'D', $filters = array())
    {
        return Madhouse_Utils_Models::get(
            $this,
            function($dao) use ($period, $periodType, $filters) {
                $select = "COUNT(id) as num";
                $groupBy = "";
                if($periodType == 'W') {
                    $select .= ', WEEK(sentOn) as d_date, YEAR(sentOn) as year';
                    $groupBy .='WEEK(sentOn)';
                } elseif($periodType == 'M') {
                    $select .= ', MONTHNAME(sentOn) as d_date, YEAR(sentOn) as year';
                    $groupBy .= 'MONTH(sentOn), YEAR(sentOn)';
                } elseif($periodType == 'D') {
                    $select .= ', DATE(sentOn) as d_date';
                    $groupBy .='DAY(sentOn)';
                }

                if (isset($filters['item']) && $filters['item']) {
                    $select  = 'COUNT(id) as num, item_id';
                    $groupBy = 'item_id';
                    $dao->dao->where("item_id != 0");
                    $dao->dao->join(sprintf("%s AS i", Item::newInstance()->getTableName()), "m.item_id = i.pk_i_id", "INNER");
                    $dao->dao->limit(0,10);
                } elseif (isset($filters['user']) && $filters['user']) {
                    $select  = 'COUNT(id) as num, IFNULL(sender_id, s_contact_email) as sender, s_contact_name';
                    $dao->dao->join(sprintf("%s AS u", User::newInstance()->getTableName()), "m.sender_id = u.pk_i_id", "INNER");
                    $groupBy = 'sender';
                    $dao->dao->limit(0,10);
                }

                if (
                    (isset($filters['item']) && $filters['item']) ||
                    (isset($filters['user']) && $filters['user'])
                ) {
                    $dao->dao->orderBy('num', 'DESC');
                } else {
                    $dao->dao->orderBy('sentOn', 'DESC');
                }

                $dao->dao->select($select);
                $dao->dao->groupBy($groupBy);

                $dao->dao->from($this->getTableName() . ' m');
                $dao->dao->where("sentOn >= '$period'");

                if (isset($filters['thread']) && $filters['thread']) {
                    $dao->dao->where("root_id = id");
                }

            },
            function($r, $dao) use ($filters) {
                if (isset($filters['item']) && $filters['item']) {
                    return array_map(
                        function($v) {
                            $result = Item::newInstance()->findByPrimaryKey($v['item_id']);
                            return array(
                                'num'  => $v['num'],
                                'item' => new Madhouse_Item($result)
                            );
                        },
                        $r->resultArray()
                    );
                } elseif (isset($filters['user']) && $filters['user']) {
                    return array_map(
                        function($v) {
                            if (is_numeric($v["sender"])) {
                                return array(
                                    'num'  => $v['num'],
                                    'user' => Madhouse_Utils_Models::findUserByPrimaryKey($v["sender"])
                                );
                            }
                            return array(
                                'num'  => $v['num'],
                                'user' => new Madhouse_User(
                                    array(
                                        's_email' => $v["sender"],
                                        's_name' => $v["s_contact_name"],
                                    )
                                )
                            );
                        },
                        $r->resultArray()
                    );
                } else {
                    return $r->resultArray();
                }
            },
            false,
            array()
        );
    }

    /**
     * Count today's element.
     * @since 1.10
     */
    public function countToday()
    {
        return Madhouse_Utils_Models::countToday($this, "sentOn");
    }

    public function countYesterday()
    {
        return Madhouse_Utils_Models::countYesterday($this, "sentOn");
    }

    public function countThisWeek()
    {
        return Madhouse_Utils_Models::countThisWeek($this, "sentOn");
    }

    public function countLastWeek()
    {
        return Madhouse_Utils_Models::countLastWeek($this, "sentOn");
    }

    public function countThisMonth()
    {
        return Madhouse_Utils_Models::countThisMonth($this, "sentOn");
    }

    public function countLastMonth()
    {
        return Madhouse_Utils_Models::countLastMonth($this, "sentOn");
    }

    /**
     * Builds a daily report of users with unread messages.
     * @return Array   The report where each row represent a user, his unread
     *                 messages count and the date of his last unread message.
     */
    public function reportDaily()
    {
        $inbox = Madhouse_Messenger_Models_Labels::newInstance()->findByName("inbox");
        return Madhouse_Utils_Models::get(
            $this,
            sprintf("SELECT report.recipient_id, report.unread_count, m.sentOn AS last_date
             FROM %s u
             INNER JOIN (
                 SELECT r.recipient_id, MAX(r.message_id) AS max, COUNT(1) AS unread_count
                 FROM %s r
                 INNER JOIN %s m ON m.id = r.message_id
                 JOIN %s ml
                 ON (
                    ml.fk_i_message_id = m.root_id
                    AND ml.fk_i_label_id = %d
                    AND ml.fk_i_user_id = r.recipient_id
                 )
                 WHERE r.readOn IS NULL
                 GROUP BY r.recipient_id
             ) report ON u.pk_i_id = report.recipient_id
             INNER JOIN %s m ON m.id = report.max",
                User::newInstance()->getTableName(),
                Madhouse_Messenger_Models_Recipients::newInstance()->getTableName(),
                Madhouse_Messenger_Models_Messages::newInstance()->getTableName(),
                Madhouse_Messenger_Models_MessageLabels::newInstance()->getTableName(),
                $inbox->getId(),
                $this->getTableName()
             ),
             function($r, $dao) {
                return array_map(
                    function($v) {
                        return array(
                            "user" => Madhouse_Utils_Models::findUserByPrimaryKey($v["recipient_id"]),
                            "count" => $v["unread_count"],
                            "date" => new \DateTime($v["last_date"])
                        );
                    },
                    $r->result()
                );
             },
             false,
             array()
        );
    }

	/**
	 * Creates (sends) a message from $senderId to each recipient in thread $threadId.
	 * @param $message the message to insert.
	 * @param $thread the thread to add the message to.
	 * @return the id of the newly created message.
	 * @since 1.00
	 */
	public function create($message, $thread)
	{
		$datas = array(
			"content" => $message->getContent(),
			"sentOn" => date("Y-m-d H:i:s")
		);

        // Set sender informations.
        $sender = $message->getSender();
        if ($sender->isRegistered() === false) {
            /*
             * User is NOT a registered user.
             * Store name and email of the sender in the message.
             */
            $datas["s_contact_name"] = $sender->getName();
            $datas["s_contact_email"] = $sender->getEmail();
        } elseif ($sender->isRegistered() === true) {
            /*
             * User is a registered user.
             * Just link that to the user id of the sender.
             */
            $datas["sender_id"] = $sender->getId();
        } else {
            /*
             * User is a shim but is probably deleted.
             * Do nothing.
             */
        }

        // Set event if has any.
		if($message->hasEvent()) {
			$datas["event_id"] = $message->getEvent()->getId();
		}

        // Set status if has nay.
		if($message->hasStatus()) {
			$datas["status_id"] = $message->getStatus()->getId();
		}

	    // Save the message.
        $messageId = $this->save($datas, $thread);

        // Sends the message to everyone in the thread.
        $this->recipientsDAO->send($messageId, $message->getRecipients());

        // Get an updated version of the message.
        return $message = $this->findByPrimaryKey($messageId);
	}

    /**
     * Hides a message.
     * @param  Madhouse_Messenger_Message $message the message to hide.
     * @return void
     * @since  1.10
     */
    public function hide($message)
    {
    	// Update the messages to mark them as hidden.
        $updated = $this->updateByPrimaryKey(array("hidden" => true), $message->getId());
        if($updated === false) {
            throw new Madhouse_QueryFailedException($this->dao->getErrorDesc());
        }

        return $updated;
    }


    /**
     * Block a single message (or a bunch of it)
     * @param  Madhouse_Messenger_Message         $m    the message to block.
     *         Array<Madhouse_Messenger_Message>  $m    the list of messages to block.
     * @param  boolean $block                           Set the value to true/false. Default is true.
     * @return int                                      Number of messages that have been blocked.
     */
    public function block($m, $block=true)
    {
        if(! is_array($m)) {
            // Update the messages to mark them as hidden.
            $updated = $this->updateByPrimaryKey(array("reported" => $block), $m);
            if($updated === false) {
                throw new Madhouse_QueryFailedException($this->dao->getErrorDesc());
            }
        } else {
            $where = sprintf("id IN (%s)", implode(",", $m));

            $updated = $this->update(
                array(
                    "reported" => $block
                ),
                array(
                    $where // reported IN ([...])
                )
            );
            if($updated === false) {
                throw new Madhouse_QueryFailedException($this->dao->getErrorDesc());
            }
        }

        return $updated;
    }

    /**
     * Block or unblock all the messages of a given user.
     * @param  Madhouse_User $user  the user that needs his messages to be blocked/unblocked.
     * @param  boolean $block       true/false, the value, to block or unblock.
     * @return Int                  number of messages that have been blocked/unblocked.
     */
    public function setBlockByUser($user, $block)
    {
        $updated = $this->update(
            array(
                "reported" => $block
            ),
            array(
                "sender_id" => $user->getId()
            )
        );
        if($updated === false) {
            throw new Madhouse_QueryFailedException($this->dao->getErrorDesc());
        }

        // Number of messages that have been blocked.
        return $updated;
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
                "sender_id"      => $user->getId()
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

    /**
     * Builds a Madhouse_Messenger_Message object from the database row.
     * @param  Array $row                                the row from the database (result of a query).
     * @param  Madhouse_Messenger_ThreadSkeleton $thread the thread (skeleton) for this message.
     *                                                   Given for performance reason.
     * @return Madhouse_Messenger_Message                a newly created Madhouse_Messenger_Message object.
     * @since 1.24
     */
    public function buildObject($row, $thread=null)
    {
        if(is_null($thread)) {
            $thread = Madhouse_Messenger_Models_Threads::buildSkeleton(
                array(
                    "id" => $row["thread_id"],
                    "s_secret" => $row["thread_s_secret"],
                    "title" => $row["thread_title"],
                    "status_id" => $row["thread_status_id"],
                    "item_id" => $row["thread_item_id"]
                )
            );
        }

        // Retrieve the global state of the message.
        $state = $this->recipientsDAO->getState($row["id"]);

        // Get the sender.
        if (isset($row["sender_id"]) && !empty($row["sender_id"])) {
            $sender = Madhouse_Utils_Models::findUserByPrimaryKey($row["sender_id"]);
        } else {
            $sender = new Madhouse_User(
                array(
                    "s_name" => $row["s_contact_name"],
                    "s_email" => $row["s_contact_email"],
                )
            );
        }

        // Get the recipients.
        $recipients = array_map(
            function($s) {
                return $s["recipient"];
            },
            $state
        );

        // Actually create the message object.
        $m = new Madhouse_Messenger_Message(
            $row["content"],
            $sender,
            $recipients
        );

        $m->withId($row["id"]);
        $m->withHidden($row["hidden"]);
        $m->withBlocked($row["reported"]);
        $m->withSentDate($row["sentOn"]);
        $m->withState($state);

        if(!is_null($thread)) {
            $m->withThread($thread);
        }

        if(isset($row["event_id"]) && !empty($row["event_id"])) {
        	$m->withEvent(Madhouse_Messenger_Models_Events::newInstance()->findByPrimaryKey($row["event_id"]));
        }

        if(isset($row["status_id"]) && !empty($row["status_id"])) {
        	$m->withStatus(Madhouse_Messenger_Models_Status::newInstance()->findByPrimaryKey($row["status_id"]));
        }

        $messageResources = Madhouse_Messenger_Models_Resource::newInstance()->findAll(
            array(
                "message" => $m->getId()
            )
        );

        $m->withResources($messageResources);

        return $m;
    }
}

?>
