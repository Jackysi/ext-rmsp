<?php
require_once 'pm/Loader.php';
pm_Loader::enableAutoload();

$request = <<<XML
<ui>
    <create-custombutton>
        <owner>
            <admin/>
        </owner>
        <properties>
            <place>navigation</place>
            <url>/modules/rmsp/</url>
            <text>Customer Requests</text>
        </properties>
    </create-custombutton>
</ui>
XML;
pm_ApiRpc::getService('1.6.3.0')->call($request);

$request = <<<XML
<ui>
    <create-custombutton>
        <owner>
            <admin/>
        </owner>
        <properties>
            <public>true</public>
            <place>domain</place>
            <url>/modules/rmsp</url>
            <text>My Requests</text>
        </properties>
    </create-custombutton>
</ui>
XML;

pm_ApiRpc::getService('1.6.3.0')->call($request);
