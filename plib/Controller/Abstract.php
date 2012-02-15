<?php
/**
 * Abstract Controller 
 **/
class modules_rmsp_Controller_Abstract
{
    protected $_action = 'index';

    public function setAction($action)
    {
        $this->_action = $action;
    }

    public function runAction()
    {
        call_user_func(array(self, 'action_' . $this->_action));
    }
}
