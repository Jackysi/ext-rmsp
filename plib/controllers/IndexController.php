<?php

class IndexController extends pm_Controller_Action
{
    public function indexAction()
    {
        //$request = clone $this->getRequest();

        $session = new pm_Session();
        $client = $session->getClient();

        if ($client->isAdmin()) {
            $this->_redirect('/admin/index');
        } else if ($client->isReseller()) {
            $this->_redirect('/client/index');
        } else if ($client->isClient()) {
            $this->_redirect('/client/index');
        } else {
            echo "No access.";
        }

        //$this->_helper->actionStack($request);
    }
}
