<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $context['title'] ?></title>
        
        <link href="/skins/default/css/base.css" rel="stylesheet" >
        <link href="/skins/default/css/btns.css" rel="stylesheet" >
        <link href="/skins/default/css/custom.css" rel="stylesheet" >
        <link href="/skins/default/css/admin/main.css" rel="stylesheet" >
        <link href="/skins/default/css/admin/custom.css" rel="stylesheet" >

    </head>

    <body>
        <div id="page">
            <div id="wrapper">
                <div class="heading">
                    <h2>Request Management System for Plesk</h2>
                </div>
                <div id="content-body" class="clearfix">
                    <div id="main" class="tabed">
                    <?php
                        if (isset($context['message'])) { ?>
                            <div class="msg-box msg-<?php echo $context['message']['class'];?>">
                                <div class="msg-content">
                                    <?php echo $context['message']['text']; ?>
                                </div>
                            </div>
                    <?php
                        }
                        echo isset($context['body']) ? $context['body'] : ''
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
