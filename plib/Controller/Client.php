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
        $view->activeMenu = 'unresolved';

        if (isset($_POST['description'])) {

        }
        

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
                    'class' => 'success',
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
}
