<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $context['title'] ?></title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="<?php echo $context['STATIC_URL'];?>css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="<?php echo $context['STATIC_URL'];?>css/bootstrap-responsive.css" rel="stylesheet">

  </head>

  <body>
    <div class='container'>
        <?php
        if (isset($context['message'])) {
            echo "<div class='alert alert-{$context['message']['class']}'>{$context['message']['text']}</div>";
        }
        echo isset($context['body']) ? $context['body'] : ''
        ?>
    </div> <!-- /container -->
    <!-- Le javascript
    ================================================== -->
    <!--script type="text/javascript" src="<?php echo $context['STATIC_URL'];?>js/bootstrap.js"></script-->
  </body>
</html>
