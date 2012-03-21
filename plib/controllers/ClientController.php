<?php

class ClientController extends pm_Controller_Action
{
    public function init()
    {
        parent::init();

        Zend_Controller_Front::getInstance()->throwExceptions(true);

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

        $baseUrl = pm_Context::getBaseUrl();

        $this->view->tools = array(
            array(
                'icon' => $baseUrl . '/img/newdocument.png',
                'title' => 'New request',
                'description' => 'Create new request',
                'action' => 'newrequest',
            )
        );

        $this->view->pageTitle = 'Request Management System for Plesk :: Client';

        $session = new pm_Session();
        $this->client = $session->getClient();
    }

    public function indexAction()
    {
        $mapper = new modules_rmsp_Model_RequestMapper();

        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $requests = $mapper->getList($post['chboxList']);
            $client_id = $this->client->getId();

            foreach ($requests as $request) {
                if ($request->customer_id == $client_id) {
                    $request->state = modules_rmsp_Model_Request::STATE_RESOLVED;
                    $mapper->save($request);
                }
            }

            $this->_status->addMessage('info', 'Request(s) updated.');
        }

        $this->view->requests = $mapper->getByClientId($this->client->getId(),
            modules_rmsp_Model_Request::STATE_UNRESOLVED);
    }

    public function resolvedAction()
    {
        $mapper = new modules_rmsp_Model_RequestMapper();

        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $requests = $mapper->getList($post['chboxList']);
            $client_id = $this->client->getId();

            foreach ($requests as $request) {
                if ($request->customer_id == $client_id) {
                    $request->state = modules_rmsp_Model_Request::STATE_UNRESOLVED;
                    $mapper->save($request);
                }
            }

            $this->_status->addMessage('info', 'Request(s) updated.');
        }

        $this->view->requests = $mapper->getByClientId($this->client->getId(),
            modules_rmsp_Model_Request::STATE_RESOLVED);
    }

    public function newrequestAction()
    {
        $form = new pm_Form_Simple();
        $form->addElement('textarea', 'description', array(
            'label' => 'Description of problem',
            'value' => '',
            'required' => true,
        ));

        $form->addControlButtons(array(
            'cancelHidden' => true,
        ));

        if($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            $formValues = $form->getValues();

            $params = array(
                'customer_id' => $this->client->getId(),
                'description' => $formValues['description'],
            );

            $request = new modules_rmsp_Model_Request($params);
            $mapper = new modules_rmsp_Model_RequestMapper();
            $res = $mapper->save($request);
            if ($res === 0 ) {
                $this->_status->addMessage('info', 'Request created');
                $this->_helper->json(array('redirect' => 'index'));
            } else {
                $this->_status->addMessage('error', $res);
            }
        }

        $this->view->form = $form;
    }
}

