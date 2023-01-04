<?php

class Madhouse_Messenger_Actions
{
    public static function createStatus($status)
    {
        // Just create the status @ database.
        return Madhouse_Messenger_Models_Status::newInstance()->create($status);
    }

    public static function createEvent($event)
    {
        // Just create the event @ database.
        return Madhouse_Messenger_Models_Events::newInstance()->create($event);
    }

    public static function createLabel($label)
    {
        // Just create the label @ database.
        return Madhouse_Messenger_Models_Labels::newInstance()->create($label);
    }
}
