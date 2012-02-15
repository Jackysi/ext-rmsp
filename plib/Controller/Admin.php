<?php
/**
 * Admin Controller
 **/
class modules_rmsp_Controller_Admin extends modules_rmsp_Controller_Abstract
{
    public function action_index()
    {
        $this->action_unresolved();
    }

    public function action_unresolved()
    {
        $view = new modules_rmsp_View_Base();
        $view->setTemplate('admin_index');
        $view->title .= ' :: admin interface';
        $view->activeMenu = 'unresolved';

        $mapper = new modules_rmsp_Model_RequestMapper();
        $requests = $mapper->getAll(modules_rmsp_Model_Request::STATE_UNRESOLVED);

        $view->requests = $requests;
        $view->render();
    }

    public function action_resolved()
    {
        $view = new modules_rmsp_View_Base();
        $view->setTemplate('admin_index');
        $view->title .= ' :: admin interface';
        $view->activeMenu = 'resolved';

        $mapper = new modules_rmsp_Model_RequestMapper();
        $requests = $mapper->getAll(modules_rmsp_Model_Request::STATE_RESOLVED);


        $view->requests = $requests;
        $view->render();
    }

    public function action_resolve()
    {
        $view = new modules_rmsp_View_Base();
        $view->setTemplate('admin_index');
        $view->title .= ' :: admin interface';
        $view->activeMenu = 'unresolved';

        $mapper = new modules_rmsp_Model_RequestMapper();

        if (isset($_POST['request_id'])) {
            $request = $mapper->get($_POST['request_id']);
            $request->state = modules_rmsp_Model_Request::STATE_RESOLVED;
            $res = $mapper->save($request);
            if ($res === 0) {
                $view->message = array(
                    'class' => 'success',
                    'text' => "Request with id = {$request->id} was resolved.",
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
                'text' => 'request_id is unknown.',
            );
        }

        $requests = $mapper->getAll(modules_rmsp_Model_Request::STATE_UNRESOLVED);


        $view->requests = $requests;
        $view->render();
    }
}
