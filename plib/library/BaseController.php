<?php
// Copyright 1999-2015. Parallels IP Holdings GmbH.
class Modules_Rmsp_BaseController extends pm_Controller_Action
{
    public function init()
    {
        parent::init();

        $this->view->tabs = array(
            array(
                'title' => 'Unresolved',
                'action' => 'index'
            ),
            array(
                'title' => 'Resolved',
                'action' => 'resolved',
            )
        );

        $session = new pm_Session();
        $this->client = $session->getClient();

        $this->view->pageTitle = "Request management system";

        $this->_requestMapper = new Modules_Rmsp_Model_RequestMapper();
    }
    protected $_requestMapper = null;

    protected function _cutString($string, $symbolsFromTail = 100)
    {
         return substr($string, 0, $symbolsFromTail) . '...';
    }

    protected function _createAndGetRequestList($requests)
    {
        // Collect data for list helper
        $data = array();
        foreach ($requests as $request) {
            $columns = array();
            $columns['id'] = "<input type=\"checkbox\" value=\"$request->id\" name=\"chboxList[]\">";
            $columns['post_date'] = $request->post_date;
            $columns['state'] = $request->state === '0' ? 'Active' : 'Resolved';
            $columns['description'] = $this->_cutString($request->description);
            $columns['details'] = "<a href=\"" . $this->_helper->url(
                'details', $this->getRequest()->getControllerName(), null, array('id' => $request->id))
                ."\" >Open details</a>";
            $data[] = $columns;
        }

        // Create columns for list helper
        $columns = array();
        $columns['id'] = array('title' => '#', 'noEscape' => true);
        $columns['post_date'] = array('title' => 'Post date', 'noEscape' => true);
        $columns['state'] = array('title' => 'State', 'noEscape' => true);
        $columns['description'] = array('title' => 'Description');
        $columns['details'] = array('title' => 'Details', 'noEscape' => true);

        // Create list helper and pass data and column to it
        $list = new pm_View_List_Simple($this->view, $this->_request);
        $list->setData($data);
        $list->setColumns($columns);

        return $list;
    }
}
