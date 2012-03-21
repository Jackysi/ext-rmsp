<?php

pm_Context::init('rmsp');

$request = <<<XML
<ui>
    <create-custombutton>
        <owner>
            <admin/>
        </owner>
        <properties>
            <public>true</public>
            <internal>true</internal>
            <noframe>true</noframe>
            <place>domain</place>
            <url>/modules/rmsp</url>
            <text>My Requests</text>
        </properties>
    </create-custombutton>
</ui>
XML;

$response = pm_ApiRpc::getService('1.6.3.5')->call($request);
$id = (string) $response->ui->{'create-custombutton'}->result->id;
pm_Settings::set('button-id', $id);
