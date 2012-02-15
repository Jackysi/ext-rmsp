<?php
/**
 * Base View
 **/
class modules_rmsp_View_Base
{
    protected $_context = null;
    protected $_template = null;
    const TEMPLATE_PATH = 'modules/rmsp/template/';
    const BASE_TEMPLATE = 'base.php';

    public function __construct()
    {
        $this->_context = array();
        $this->_context['title'] = 'RMS for Plesk';
        $this->_context['STATIC_URL'] = '/modules/rmsp/';
        $this->_context['BASE_URL'] = '/modules/rmsp/';
    }

    public function setTemplate($templateName)
    {
        $this->_template = "{$templateName}.php";
    }

    public function __set($name, $value)
    {
        $this->_context[$name] = $value;
    }

    public function render()
    {
        if (is_null($this->_template)) {
            echo 'Template is null';
            return;
        }
        $context = $this->_context;
        $context['body'] = $this->_renderToString($this->_template, $context);
        require_once(self::TEMPLATE_PATH . self::BASE_TEMPLATE);
    }

    protected function _renderToString($filePath, Array $data)
    {
        extract($data, EXTR_SKIP);

        ob_start();

        try {
            include self::TEMPLATE_PATH . $filePath;
        } catch (Exception $e) {
            ob_end_clean();
            echo $e;
        }

        return ob_get_clean();
    }
}
