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

        $session = new pm_Session();
        $this->client = $session->getClient();

        $this->view->pageTitle = "Request management system";
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

    public function detailsAction()
    {
        $this->view->uplevelLink = $this->_helper->url('index', 'admin');

        $id = $this->getRequest()->getParam('id');

        if (is_null($id)) {
            $this->_status->addMessage('error', 'Request id is undefined.');
            $this->_redirect('/admin/index');
        }

        $this->view->pageTitle = "Request # {$id}";

        $mapper = new modules_rmsp_Model_RequestMapper();
        $this->view->request = $mapper->get($id);
        if (is_null($this->view->request)) {
            $this->_status->addMessage('error', 'Can\'t find request with id in database.');
        }

        $commentMapper = new modules_rmsp_Model_CommentMapper();
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

