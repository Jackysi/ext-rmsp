<?php
$factory = new modules_rmsp_View_Factory($GLOBALS['session']);
$view = $factory->getViewForSession();
$view->render();
