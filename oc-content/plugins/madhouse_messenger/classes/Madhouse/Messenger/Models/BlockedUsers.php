<?php

/**
 * Blocked users
 * @since 1.50.0
 */
class Madhouse_Messenger_Models_BlockedUsers extends DAO
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
        if ( !self::$instance instanceof self ) {
            self::$instance = new self ;
        }
        return self::$instance ;
    }

    public function __construct()
    {
        parent::__construct();
        // Init base
        $this->setTableName('t_mmessenger_blocked_users');
        $this->setFields(
            array(
                "fk_i_user_id",
                "s_blocked_user",
                "dt_created"
            )
        );
        $this->setPrimaryKey("fk_i_user_id");
    }

    public function findAll($filters = null, $page = null, $n = null)
    {
        if (is_null($filters)) {
            $filters = array();
        }

        $that = $this;
        return Madhouse_Utils_Models::get(
            $this,
            function($dao) use ($filters, $page, $n) {
                if (isset($filters['count']) && $filters["count"]) {
                    $dao->dao->select("COUNT(fk_i_user_id) as total");
                } else {
                    $dao->dao->select($dao->getFields());
                }

                $dao->dao->from($dao->getTableName());


                if (!is_null($n) && !is_null($page)) {
                    $dao->dao->limit(($page - 1) * $n, $n);
                }
            },
            function($r) use ($that, $filters) {
                if (isset($filters["count"]) && $filters["count"]) {
                    return $r->rowObject()->total;
                } else {
                    return $that->buildResults($r, $that);
                }
            },
            false,
            array()
        );
    }

    public function countAll($filters = null) {
         if (is_null($filters)) {
            $filters = array();
        }
        $filters['count'] = true;
        return $this->findAll($filters);
    }

    public function findByUser($user)
    {
        $that = $this;
        return Madhouse_Utils_Models::get(
            $this,
            function($dao) use ($user) {
                $dao->dao->select($dao->getFields());
                $dao->dao->from($dao->getTableName());
                $dao->dao->where("fk_i_user_id", $user->getId());
            },
            function($results) use ($that) {
                return $results->result();
            }
        );
    }

    public function findByUserAndBlockedUser($user, $blockedUser)
    {
        $that = $this;
        return Madhouse_Utils_Models::get(
            $this,
            function($dao) use ($user, $blockedUser) {
                $dao->dao->select($dao->getFields());
                $dao->dao->from($dao->getTableName());
                $dao->dao->where("fk_i_user_id", $user->getId());
                $dao->dao->where("s_blocked_user", ($blockedUser->isRegistered()) ? $blockedUser->getId() : $blockedUser->getEmail());
            },
            function($results) use ($that) {
                return $that->buildResults($results, $that);
            },
            false,
            array()
        );
    }

    public function findByUserAndThread($user, $thread)
    {
        $that = $this;

        if ($thread->isGroup()) {
            return array();
        }

        $threadUser = $thread->getOther();
        if (empty($threadUser)) {
            return array();
        }

        $otherUser = ($threadUser->isRegistered()) ? $threadUser->getId() : $threadUser->getEmail();

        return Madhouse_Utils_Models::get(
            $this,
            function($dao) use ($user, $otherUser) {
                $dao->dao->select($dao->getFields());
                $dao->dao->from($dao->getTableName());
                $dao->dao->where("(fk_i_user_id = " . $user->getId() . " AND " . "s_blocked_user = '". $otherUser . "')");
                $dao->dao->orWhere("(fk_i_user_id = '" . $otherUser . "' AND " . "s_blocked_user = '". $user->getId() . "')");
            },
            function($r) use ($that) {
                return $that->buildResults($r, $that);
            },
            false,
            array()
        );
    }

    private function buildResults($r, $that) {
            return array_map(
                function($v) use ($that) {
                    return $that->buildObject($v);
                },
                $r->result()
            );
        }

    private function buildObject($data, $item = null)
    {
        /*
         * User.
         */
        $user = Madhouse_Utils_Models::findUserByPrimaryKey($data["fk_i_user_id"]);

        /*
         * Blocked User.
         */
        $blockedUserId = filter_var($data["s_blocked_user"], FILTER_VALIDATE_INT);
        if ($blockedUserId === false) {
            // s_blocked_user is an email address.
            $blockedUser = new Madhouse_User(
                array(
                    "s_name" => __("Blocked User", mdh_current_plugin_name()),
                    "s_email" => $data["s_blocked_user"],
                )
            );
        } else {
            // s_blocked_user is a validated integer.
            $blockedUser = Madhouse_Utils_Models::findUserByPrimaryKey($blockedUserId);
        }

        // Return a proper object.
        return new Madhouse_Messenger_BlockedUser($data, $user, $blockedUser);
    }

    public function create($user, $blockedUser)
    {
        $dtCreated = new \DateTime();

        // Insert everything.
        $this->insert(
            array(
                "fk_i_user_id"   => $user->getId(),
                "s_blocked_user" => ($blockedUser->isRegistered()) ? $blockedUser->getId() : $blockedUser->getEmail(),
                'dt_created'     => $dtCreated->format("Y-m-d H:i:s"),
            )
        );

        // Return the updated BlockedUser.
        return $this->findByUserAndBlockedUser($user, $blockedUser);
    }

    public function removeByUserId($userId)
    {
        $result =  $this->delete(
            array(
                "fk_i_user_id"   => $userId
            )
        );

        $result = $this->delete(
            array(
                "s_blocked_user" => $userId
            )
        );

        return $result;
    }

    /**
     * Set blocked user id when user registers
     * @param  Madhouse_User $user  the user that is registered.
     * @return Int                  number of messages that have been blocked/unblocked.
     */
    public function registerUser($user)
    {
        $updated = $this->update(
            array(
                "s_blocked_user"      => $user->getId()
            ),
            array(
                "s_blocked_user" => $user->getEmail()
            )
        );
        if($updated === false) {
            throw new Madhouse_QueryFailedException($this->dao->getErrorDesc());
        }

        // Number of messages that have been blocked.
        return $updated;
    }

    public function removeBlockedUser($user, $blockedUser)
    {
        return $this->delete(
            array(
                "fk_i_user_id"   => $user->getId(),
                "s_blocked_user" => ($blockedUser->isRegistered()) ? $blockedUser->getId() : $blockedUser->getEmail(),
            )
        );
    }
}
