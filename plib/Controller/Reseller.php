<?php
/**
 * Reseller Controller
 **/
class modules_rmsp_Controller_Reseller extends modules_rmsp_Controller_Abstract
{
    public function action_index()
    {
        $view = new modules_rmsp_View_Base();
        $view->setTemplate('reseller_index');
        $view->title .= ' :: reseller interface';
        $view->render();
    }
}
