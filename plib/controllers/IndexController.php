<?php

class IndexController extends pm_Controller_Action
{
    public function indexAction()
    {
        $request = clone $this->getRequest();

        $session = new pm_Session();
        $client = $session->getClient();

        if ($client->isAdmin()) {
            $request->setControllerName('admin');
        } else if ($client->isReseller()) {
            $request->setControllerName('client');
        } else if ($client->isClient()) {
            $request->setControllerName('client');
        } else {
            echo "No access.";
        }

        $this->_helper->actionStack($request);
    }
}
