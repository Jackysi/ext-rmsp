<?php
/**
 * Controllers Factory
 **/
class modules_rmsp_Controller_Factory
{
    public function getControllerForCurrentSession()
    {
        $session = new pm_Session();
        $client = $session->getClient();

        if ($client->isAdmin()) {
            return new modules_rmsp_Controller_Admin();
        } else if ($client->isReseller()) {
            return new modules_rmsp_Controller_Reseller();
        } else if ($client->isClient()) {
            return new modules_rmsp_Controller_Client();
        } else {
            echo "No access.";
        }
        //Test changes
        //next change
    }
}
