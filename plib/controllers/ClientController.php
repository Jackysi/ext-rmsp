<?php
// Copyright 1999-2015. Parallels IP Holdings GmbH.
class ClientController extends Modules_Rmsp_BaseController
{
    public function init()
    {
        parent::init();

        $baseUrl = pm_Context::getBaseUrl();

        $this->view->tools = array(
            array(
                'icon' => $baseUrl . '/img/newdocument.png',
                'title' => 'New request',
                'description' => 'Create new request',
                'action' => 'newrequest',
            )
        );

    }

    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $requests = $this->_requestMapper->getList($post['chboxList']);
            $client_id = $this->client->getId();

            foreach ($requests as $request) {
                if ($request->customer_id == $client_id) {
                    $request->state = Modules_Rmsp_Model_Request::STATE_RESOLVED;
                    $this->_requestMapper->save($request);
                }
            }

            $this->_status->addMessage('info', 'Request(s) updated.');
        }

        $requests = $this->_requestMapper->getByClientId($this->client->getId(),
            Modules_Rmsp_Model_Request::STATE_UNRESOLVED);
        $this->view->list = $this->_createAndGetRequestList($requests);
        $this->view->list->setDataUrl(array('action' => 'get-unresolved'));
    }

    public function getUnresolvedAction()
    {
        $requests = $this->_requestMapper->getByClientId($this->client->getId(),
            Modules_Rmsp_Model_Request::STATE_UNRESOLVED);
        return $this->_helper->json(
            $this->_createAndGetRequestList($requests)->fetchData());
    }

    public function getResolvedAction()
    {
        $requests = $this->_requestMapper->getByClientId($this->client->getId(),
            Modules_Rmsp_Model_Request::STATE_RESOLVED);
        return $this->_helper->json(
            $this->_createAndGetRequestList($requests)->fetchData());

    }

    public function resolvedAction()
    {
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $requests = $this->_requestMapper->getList($post['chboxList']);
            $client_id = $this->client->getId();

            foreach ($requests as $request) {
                if ($request->customer_id == $client_id) {
                    $request->state = Modules_Rmsp_Model_Request::STATE_UNRESOLVED;
                    $this->_requestMapper->save($request);
                }
            }

            $this->_status->addMessage('info', 'Request(s) updated.');
        }

        $requests = $this->_requestMapper->getByClientId($this->client->getId(),
            Modules_Rmsp_Model_Request::STATE_RESOLVED);
        $this->view->list = $this->_createAndGetRequestList($requests);
        $this->view->list->setDataUrl(array('action' => 'get-resolved'));
    }

    public function newrequestAction()
    {
        $this->view->uplevelLink = $this->_helper->url('index', 'client');

        $this->view->pageTitle = "Add new request";

        $form = new pm_Form_Simple();
        $form->addElement('textarea', 'description', array(
            'label' => 'Description of problem',
            'value' => 'Steps to reproduce:',
            'required' => true,
            'cols' => 24,
            'rows' => '8',
            'style' => 'width:100%;'
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

            $request = new Modules_Rmsp_Model_Request($params);
            $res = $this->_requestMapper->save($request);
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
        $this->view->uplevelLink = $this->_helper->url('index', 'client');

        $id = $this->getRequest()->getParam('id');

        if (is_null($id)) {
            $this->_status->addMessage('error', 'Request id is undefined.');
            $this->_redirect('/client/index');
        }

        $this->view->pageTitle = "Request # {$id}";

        $this->view->request = $this->_requestMapper->get($id);

        if (is_null($this->view->request)) {
            $this->_status->addMessage('error', "Can't find request with id = $id in database.");
        }

        $commentMapper = new Modules_Rmsp_Model_CommentMapper();
        $this->view->comments = $commentMapper->getByRequestId($id, true);

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

            $comment = new Modules_Rmsp_Model_Comment($params);
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

