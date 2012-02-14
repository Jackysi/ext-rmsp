<?php
/**
 * Admin View
 **/
class modules_rmsp_View_Client extends modules_rmsp_View_Base
{
    public function render()
    {
        $this->_context['title'] .= ' :: client interface';
        $this->_context['menu'] = $this->renderToString(self::TEMPLATE_PATH . 'admin_menu.php', array());

        $client = pm_Session::getClient();
        $request = new modules_rmsp_Model_Request();
        $requests = $request->getByCustomerId($client->getId());

        $this->_context['content'] = $this->renderToString(self::TEMPLATE_PATH . 'client_content.php',
            array('requests' => $requests));
        parent::render();
    }
}
