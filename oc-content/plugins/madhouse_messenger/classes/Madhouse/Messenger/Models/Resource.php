<?php

class Madhouse_Messenger_Models_Resource extends Madhouse_DAO_BaseDAO
{
    /**
     * Singleton.
     */
    private static $instance;

    /**
     * Singleton.
     *
     * @return $this.
     */
    public static function newInstance()
    {
        if(!self::$instance instanceof self) {
            $helper = new Madhouse_DAO_Helper();
            self::$instance = new self($helper);
        }
        return self::$instance;
    }

    /**
     * Constructor.
     *
     * @param Madhouse_DAO_Helper $helper
     */
    public function __construct($helper)
    {
        $helper->setFields(
            array(
                "pk_i_id",
                "fk_i_message_id",
                "s_name",
                "s_original_name",
                "s_secret",
                "s_extension",
                "s_content_type",
                "s_path",
            )
        );
        $helper->setTableName("t_mmessenger_resource");
        $helper->setPrimaryKey("pk_i_id");

        parent::__construct($helper);
    }

    /**
     * Find resource by secret.
     *
     * @param  string $secret
     *
     * @return Madhouse_Messenger_Resource
     */
    public function findBySecret($secret)
    {
        $that = $this;
        return $this->helper->findOneBy(
            array(
                "s_secret" => $secret
            ),
            array($this, "buildObject")
        );
    }

    public function findAll($filters = null, $pagination = null, $sorting = null)
    {
        return $this->helper->findBy(
            function ($helper) use ($filters, $pagination, $sorting) {
                $helper->dao->select("rs.*");
                $helper->dao->from($helper->getTableName() . " AS rs");

                /*
                 * filter: 'message'
                 * Filter by message id, eg. get all resources attached to a given message.
                 */
                if (isset($filters["message"])) {
                    $helper->dao->where("rs.fk_i_message_id", $filters["message"]);
                }

                /*
                 * filter: 'thread'
                 * Filter by thread id, eg. get all resources attached to messages belonging to a given thread.
                 */
                if (isset($filters["thread"])) {
                    $helper->dao->join(
                        Madhouse_Messenger_Models_Messages::newInstance()->getTableName() . " AS m",
                        "m.id = rs.fk_i_message_id"
                    );
                    $helper->dao->join(
                        Madhouse_Messenger_Models_Threads::newInstance()->getTableName() . " AS t",
                        "t.id = m.root_id"
                    );
                    $helper->dao->where("t.id", $filters["thread"]);
                }
            },
            function ($results, $helper) {
                return $this->buildObjects($results->result());
            },
            false,
            array()
        );
    }

    public function insert($resource)
    {
        // Insert the resource @ database.
        $resourceId = $this->helper->insert(
            array(
                "fk_i_message_id" => $resource->getMessageId(),
                "s_secret" => $resource->getSecret(),
                "s_name" => $resource->getName(),
                "s_original_name" => $resource->getOriginalName(),
                "s_path" => $resource->getPath(),
                "s_extension" => $resource->getExtension(),
                "s_content_type" => $resource->getMimeType(),
            )
        );

        // Return the resource.
        return $this->findByPrimaryKey($resourceId);
    }

    public function update($resource)
    {
        $this->helper->update(
            array(
                "fk_i_message_id" => $resource->getMessageId(),
                "s_secret" => $resource->getSecret(),
                "s_name" => $resource->getName(),
                "s_original_name" => $resource->getOriginalName(),
                "s_path" => $resource->getPath(),
                "s_extension" => $resource->getExtension(),
                "s_content_type" => $resource->getMimeType(),
            ),
            array(
                $this->helper->getPrimaryKey() => $resource->getId(),
            )
        );

        return $this->findByPrimaryKey($resource->getId());
    }

    public function delete($resource)
    {
        return $this->helper->delete(
            array(
                $this->helper->getPrimaryKey() => $resource->getId(),
            )
        );
    }

    public function buildObject($row)
    {
        $resource = new Madhouse_Messenger_Resource();
        $resource
            ->setId($row[$this->helper->getPrimaryKey()])
            ->setMessageId($row["fk_i_message_id"])
            ->setSecret($row["s_secret"])
            ->setOriginalName($row["s_original_name"])
            ->setName($row["s_name"])
            ->setExtension($row["s_extension"])
            ->setMimeType($row["s_content_type"])
            ->setPath($row["s_path"])
        ;
        return $resource;
    }
}
