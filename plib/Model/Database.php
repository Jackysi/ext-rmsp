<?php
/**
 * Database Model
 **/
class modules_rmsp_Model_Database extends PDO
{
    protected static $_instance = null;

    public static function getInstance($string)
    {
        if (self::$_instance == null){
            return new self($string);
        }
        return self::$_instance;
    }
}
