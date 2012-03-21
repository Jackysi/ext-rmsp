<?php
class AdminController extends pm_Controller_Action
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

        $this->view->pageTitle = 'Request Management System for Plesk :: Admin';
    }

    public function indexAction()
    {
        $mapper = new modules_rmsp_Model_RequestMapper();

        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $mapper->updateStateByIds($post['chboxList'], modules_rmsp_Model_Request::STATE_RESOLVED);
            $this->_status->addMessage('info', 'Requests updated.');
        }

        $this->view->requests = $mapper->getAll(modules_rmsp_Model_Request::STATE_UNRESOLVED);
    }

    public function resolvedAction()
    {
        $mapper = new modules_rmsp_Model_RequestMapper();

        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $mapper->updateStateByIds($post['chboxList'], modules_rmsp_Model_Request::STATE_UNRESOLVED);
            $this->_status->addMessage('info', 'Requests updated.');
        }

        $this->view->requests = $mapper->getAll(modules_rmsp_Model_Request::STATE_RESOLVED);
    }
}

