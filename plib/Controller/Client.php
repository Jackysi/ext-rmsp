<?php
/**
 * Client Controller
 **/
class modules_rmsp_Controller_Client extends modules_rmsp_Controller_Abstract
{
    public function action_index()
    {
        $this->action_unresolved();
    }

    public function action_unresolved()
    {
        $view = new modules_rmsp_View_Base();
        $view->setTemplate('client_index');
        $view->title .= ' :: client interface';
        $view->activeMenu = 'unresolved';

        $session = new pm_Session();
        $client = $session->getClient();

        $mapper = new modules_rmsp_Model_RequestMapper();
        $requests = $mapper->getByClientId($client->getId(), modules_rmsp_Model_Request::STATE_UNRESOLVED);

        $view->requests = $requests;
        $view->render();
    }

    public function action_resolved()
    {
        $view = new modules_rmsp_View_Base();
        $view->setTemplate('client_index');
        $view->title .= ' :: client interface';
        $view->activeMenu = 'resolved';

        $session = new pm_Session();
        $client = $session->getClient();

        $mapper = new modules_rmsp_Model_RequestMapper();
        $requests = $mapper->getByClientId($client->getId(), modules_rmsp_Model_Request::STATE_RESOLVED);


        $view->requests = $requests;
        $view->render();
    }

    public function action_newrequest()
    {
        $view = new modules_rmsp_View_Base();
        $view->setTemplate('client_newrequest');
        $view->title .= ' :: client interface';

        $form = new Zend_Form();
        $form->setAction("index.php?action=addrequest")->setMethod('post');

        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel("Description of problem (required)");
        $description->setRequired(true);

        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->setAttrib('class', 'btn');

        $form->addElement($description);
        $form->addElement($submit);

        $view->form = $form->render(new Zend_View());

        $view->render();
    }

    public function action_addrequest()
    {
        $view = new modules_rmsp_View_Base();
        $view->setTemplate('client_index');
        $view->title .= ' :: client interface';
        $view->activeMenu = 'unresolved';

        $session = new pm_Session();
        $client = $session->getClient();
        $mapper = new modules_rmsp_Model_RequestMapper();

        if (isset($_POST['description'])) {
            $params = array(
                'customer_id' => $client->getId(),
                'description' => $_POST['description'],
            );
            $request = new modules_rmsp_Model_Request($params);
            $res = $mapper->save($request);
            if ($res === 0) {
                $view->message = array(
                    'class' => 'info',
                    'text' => "Request was added.",
                );
            } else {
                $view->message = array(
                    'class' => 'error',
                    'text' => $res,
                );
            }
        } else {
            $view->message = array(
                'class' => 'error',
                'text' => 'description is unknown.',
            );
        }

        $requests = $mapper->getByClientId($client->getId(), modules_rmsp_Model_Request::STATE_UNRESOLVED);

        $view->requests = $requests;
        $view->render();
    }

    public function action_reopen()
    {
        $view = new modules_rmsp_View_Base();
        $view->setTemplate('client_index');
        $view->title .= ' :: client interface';
        $view->activeMenu = 'unresolved';

        $session = new pm_Session();
        $client = $session->getClient();

        $mapper = new modules_rmsp_Model_RequestMapper();

        if (isset($_POST['request_id'])) {


            $request = $mapper->get($_POST['request_id']);

            if ($request->customer_id != $client->getId()) {
                $view->message = array(
                    'class' => 'error',
                    'text' => "Request with id {$request->id} not bind to you account.",
                );
            } else {
                $request->state = modules_rmsp_Model_Request::STATE_UNRESOLVED;
                $res = $mapper->save($request);

                if ($res === 0) {
                    $view->message = array(
                        'class' => 'info',
                        'text' => "Request with id = {$request->id} was reopened.",
                    );
                } else {
                    $view->message = array(
                        'class' => 'error',
                        'text' => $res,
                    );
                }
            }
        } else {
            $view->message = array(
                'class' => 'error',
                'text' => 'request_id is unknown.',
            );
        }

        $requests = $mapper->getByClientId($client->getId(), modules_rmsp_Model_Request::STATE_UNRESOLVED);

        $view->requests = $requests;
        $view->render();
    }
}
