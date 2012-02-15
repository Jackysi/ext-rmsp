<?php
/**
 * Abstract Model
 **/
define('MODEL_PATH', realpath(dirname(__FILE__)));

abstract class modules_rmsp_Model_Abstract
{
    protected $_dbh = null;

    const DATABASE_NAME = 'rmsp.db';

    public function __construct()
    {
        $this->_dbh = new PDO('sqlite:' . MODEL_PATH
                . DIRECTORY_SEPARATOR . self::DATABASE_NAME);
    }
}
