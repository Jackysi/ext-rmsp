<?php

class ClientController extends pm_Controller_Action
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

        $baseUrl = pm_Context::getBaseUrl();

        $this->view->tools = array(
            array(
                'icon' => $baseUrl . '/img/newdocument.png',
                'title' => 'New request',
                'description' => 'Create new request',
                'action' => 'newrequest',
            )
        );


        $session = new pm_Session();
        $this->client = $session->getClient();

        $this->view->pageTitle = "Request management system";
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
        $this->view->pageTitle = "Add new request";

        $form = new pm_Form_Simple();
        $form->addElement('textarea', 'description', array(
            'label' => 'Description of problem',
            'value' => '',
            'required' => true,
            'rows' => '8',
        ));

        $form->addControlButtons(array(
            'cancelLink' => pm_Context::getBaseUrl(),
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

    public function detailsAction()
    {
        $id = $this->getRequest()->getParam('id');

        if (is_null($id)) {
            $this->_status->addMessage('error', 'Request id is undefined.'); 
            // :TODO: $this->_redirect();
        }

        $this->view->pageTitle = "Request # {$id}";

        $mapper = new modules_rmsp_Model_RequestMapper();
        $this->view->request = $mapper->get($id);

        if (is_null($this->view->request)) {
            $this->_status->addMessage('error', 'Can\'t find request with id in database.');
        }

        $commentMapper = new modules_rmsp_Model_CommentMapper();
        $this->view->comments = $commentMapper->getByRequestId($id);

        // Form
        $form = new pm_Form_Simple();
        $form->addElement('textarea', 'comment', array(
            'label' => 'Your comment',
            'value' => '',
            'required' => true,
            'rows' => '8',
        ));

        $form->addControlButtons(array(
            'cancelHidden' => true,
        ));

        $this->view->form = $form;

        // POST
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            $formValues = $form->getValues();

            $params = array(
                'owner_id' => $this->client->getId(),
                'text' => $formValues['comment'],
                'request_id' => $id,
            );

            $comment = new modules_rmsp_Model_Comment($params);
            $res = $commentMapper->save($comment);

            if ($res === 0 ) {
                $this->_status->addMessage('info', 'Comment added');
            } else {
                $this->_status->addMessage('error', $res);
            }

            $this->_helper->json(array('redirect' => $id));
        }
    }
}

