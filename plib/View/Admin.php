<?php
/**
 * Admin View
 **/
class modules_rmsp_View_Admin extends modules_rmsp_View_Base
{
    public function render()
    {
        $this->_context['title'] .= ' :: admin interface';
        $this->_context['menu'] = $this->renderToString(self::TEMPLATE_PATH . 'admin_menu.php', array());
        
        $request = new modules_rmsp_Model_Request(); 
        $requests = $request->getAll();
        $this->_context['content'] = $this->renderToString(self::TEMPLATE_PATH . 'admin_content.php',
            array('requests' => $requests));
        parent::render();
    }
}
