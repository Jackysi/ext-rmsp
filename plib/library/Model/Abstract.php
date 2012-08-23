<?php
/**
 * Abstract Model
 **/

abstract class Modules_Rmsp_Model_Abstract
{
    protected $_dbh = null;

    const DATABASE_NAME = 'rmsp.db';

    public function __construct()
    {
        $this->_dbh = new PDO('sqlite:' . pm_Context::getVarDir() . DIRECTORY_SEPARATOR . self::DATABASE_NAME);
    }
}
