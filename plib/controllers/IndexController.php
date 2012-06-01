<?php

class IndexController extends pm_Controller_Action
{
    public function indexAction()
    {
        //$request = clone $this->getRequest();

        $session = new pm_Session();
        $client = $session->getClient();

        if ($client->isAdmin()) {
            // :TODO:
            $this->_redirect('/admin/index');
            //$request->setControllerName('admin');
        } else if ($client->isReseller()) {
            $this->_redirect('/client/index');
            //$request->setControllerName('client');
        } else if ($client->isClient()) {
            $this->_redirect('/client/index');
            //$request->setControllerName('client');
        } else {
            echo "No access.";
        }

        //$this->_helper->actionStack($request);
    }
}
