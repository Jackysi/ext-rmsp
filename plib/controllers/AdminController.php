<?php
// Copyright 1999-2015. Parallels IP Holdings GmbH.
class AdminController extends Modules_Rmsp_BaseController
{
    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $this->_requestMapper->updateStateByIds($post['chboxList'], Modules_Rmsp_Model_Request::STATE_RESOLVED);
            $this->_status->addMessage('info', 'Requests updated.');
        }

        $requests = $this->_requestMapper->getAll(Modules_Rmsp_Model_Request::STATE_UNRESOLVED);
        $this->view->list = $this->_createAndGetRequestList($requests);
        $this->view->list->setDataUrl(array('action' => 'get-unresolved'));
    }

    public function getUnresolvedAction()
    {
        $requests = $this->_requestMapper->getAll(Modules_Rmsp_Model_Request::STATE_UNRESOLVED);
        return $this->_helper->json(
            $this->_createAndGetRequestList($requests)->fetchData());
    }

    public function getResolvedAction()
    {
        $requests = $this->_requestMapper->getAll(Modules_Rmsp_Model_Request::STATE_RESOLVED);
        return $this->_helper->json(
            $this->_createAndGetRequestList($requests)->fetchData());

    }

    public function resolvedAction()
    {
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $this->_requestMapper->updateStateByIds($post['chboxList'], Modules_Rmsp_Model_Request::STATE_UNRESOLVED);
            $this->_status->addMessage('info', 'Requests updated.');
        }

        $requests = $this->_requestMapper->getAll(Modules_Rmsp_Model_Request::STATE_RESOLVED);
        $this->view->list = $this->_createAndGetRequestList($requests);
        $this->view->list->setDataUrl(array('action' => 'get-resolved'));
    }

    public function detailsAction()
    {
        $this->view->uplevelLink = $this->_helper->url('index', 'admin');

        $id = $this->getRequest()->getParam('id');

        if (is_null($id)) {
            $this->_status->addMessage('error', 'Request id is undefined.');
            $this->_redirect('/admin/index');
        }

        $this->view->pageTitle = "Request # {$id}";

        $this->view->request = $this->_requestMapper->get($id);
        if (is_null($this->view->request)) {
            $this->_status->addMessage('error', 'Can\'t find request with id in database.');
        }

        $commentMapper = new Modules_Rmsp_Model_CommentMapper();
        $this->view->comments = $commentMapper->getByRequestId($id, true);
        $this->view->client = pm_Client::getByClientId($this->view->request->customer_id);

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

