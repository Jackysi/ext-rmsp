<?php
// Copyright 1999-2015. Parallels IP Holdings GmbH.
pm_Context::init('rmsp');

$id = pm_Settings::get('button-id');

$request = <<<XML
<ui>
    <delete-custombutton>
        <filter>
            <custombutton-id>{$id}</custombutton-id>
        </filter>
    </delete-custombutton>
</ui>
XML;

pm_ApiRpc::getService('1.6.3.0')->call($request);
