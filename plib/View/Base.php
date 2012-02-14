<?php
/**
 * Base View
 **/
class modules_rmsp_View_Base
{
    protected $_context = null;
    const TEMPLATE_PATH = 'modules/rmsp/template/';

    public function __construct()
    {
        $this->_context = array();
        $this->_context['title'] = 'RMS for Plesk';
        $this->_context['STATIC_URL'] = '/modules/rmsp/';
    }

    public function render()
    {
        $context = $this->_context;
        require_once(self::TEMPLATE_PATH . 'base.php');
    }

    public function renderToString($filePath, Array $data)
    {
        extract($data, EXTR_SKIP);

        ob_start();

        try {
            include $filePath;
        } catch (Exception $e) {
            ob_end_clean();
            throw $e;
        }

        return ob_get_clean();
    }
}
