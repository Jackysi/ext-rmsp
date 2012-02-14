<?php
/**
 * View Factory
 **/
class modules_rmsp_View_Factory
{
    const SESSION_ADMIN = 1;
    const SESSION_RESELLER = 2;
    const SESSION_CUSTOMER = 4;

    protected $_session = null;

    function __construct($session)
    {
        $this->_session = $session;
    }

    public function getViewForSession()
    {
        switch ($this->_session->_type) {
            case self::SESSION_ADMIN:
                return new modules_rmsp_View_Admin();
            case self::SESSION_RESELLER:
                echo "REseller";
                break;
            case self::SESSION_CUSTOMER:
                return new modules_rmsp_View_Client();
                break;
            default:
                echo "Access denied";
                break;
        }
    }
}
