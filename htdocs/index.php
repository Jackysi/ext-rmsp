<?php
$factory = new modules_rmsp_Controller_Factory();
$controller = $factory->getControllerForCurrentSession();
if (isset($_GET['action'])) {
    $controller->setAction($_GET['action']);
}
$controller->runAction();
