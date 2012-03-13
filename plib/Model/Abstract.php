<?php
/**
 * Abstract Model
 **/

abstract class modules_rmsp_Model_Abstract
{
    protected $_dbh = null;

    const DATABASE_NAME = 'rmsp.db';

    public function __construct()
    {
        # TODO Remove PRODUCT_ROOT_D and use native consts
        $this->_dbh = new PDO('sqlite:' . PRODUCT_ROOT_D . DIRECTORY_SEPARATOR
            . 'var' . DIRECTORY_SEPARATOR
            . 'modules' . DIRECTORY_SEPARATOR
            . 'rmsp' . DIRECTORY_SEPARATOR
            . DIRECTORY_SEPARATOR . self::DATABASE_NAME);
    }
}
