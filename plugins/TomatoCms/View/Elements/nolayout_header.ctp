<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title><?php echo $this->fetch('title'); ?></title>

    <meta name="description" content="uAdmin is a Professional, Responsive and Flat Admin Template created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <?PHP echo $this->Html->meta(array(
        'rel'  => 'shortcut icon',
        'link' => 'TomatoCms.img/favicon.ico'
    ));?>
    <?PHP echo $this->Html->meta(array(
        'rel' => 'apple-touch-icon',
        'link' => 'TomatoCms.img/icon57.png',
        'sizes' => '57x57'
    ));?>
    <?PHP echo $this->Html->meta(array(
        'rel' => 'apple-touch-icon',
        'link' => 'TomatoCms.img/icon72.png',
        'sizes' => '72x72'
    ));?>
    <?PHP echo $this->Html->meta(array(
        'rel' => 'apple-touch-icon',
        'link' => 'TomatoCms.img/icon76.png',
        'sizes' => '76x76'
    ));?>
    <?PHP echo $this->Html->meta(array(
        'rel' => 'apple-touch-icon',
        'link' => 'TomatoCms.img/icon114.png',
        'sizes' => '114x114'
    ));?>
    <?PHP echo $this->Html->meta(array(
        'rel' => 'apple-touch-icon',
        'link' => 'TomatoCms.img/icon120.png',
        'sizes' => '120x120'
    ));?>
    <?PHP echo $this->Html->meta(array(
        'rel' => 'apple-touch-icon',
        'link' => 'TomatoCms.img/icon144.png',
        'sizes' => '144x144'
    ));?>
    <?PHP echo $this->Html->meta(array(
        'rel' => 'apple-touch-icon',
        'link' => 'TomatoCms.img/icon152.png',
        'sizes' => '152x152'
    ));?>
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- The roboto font is included from Google Web Fonts -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,400italic,700,700italic">

    <!-- Bootstrap is included in its original form, unaltered -->
    <?PHP echo $this->Html->css('TomatoCms.bootstrap'); ?>

    <!-- Related styles of various javascript plugins -->
    <?PHP echo $this->Html->css('TomatoCms.plugins'); ?>

    <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
    <?PHP echo $this->Html->css('TomatoCms.main'); ?>
    <!-- END Stylesheets -->

    <?PHP echo $this->Html->css('TomatoCms.others'); ?>

    <!-- Modernizr (Browser feature detection library) & Respond.js (Enable responsive CSS code on browsers that don't support them) -->

    <?PHP echo $this->Html->script('TomatoCms.vendor/modernizr-2.6.2-respond-1.1.0.min'); ?>

    <?php echo $this->Html->script('TomatoCms.ckeditor/ckeditor', array('inline' => false));?>
    <?php echo $this->Html->script('TomatoCms.ckeditor/config', array('inline' => false));?>

    <!-- Get Jquery library from Google but if something goes wrong get Jquery from local file - Remove 'http:' if you have SSL -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>!window.jQuery && document.write(unescape('%3Cscript src="/tomato_cms/js/vendor/jquery-1.9.1.min.js"%3E%3C/script%3E'));</script>

    <!-- Bootstrap.js -->
    <?PHP echo $this->Html->script('TomatoCms.vendor/bootstrap.min'); ?>

    <!-- Jquery plugins and custom javascript code -->
    <?PHP echo $this->Html->script('TomatoCms.plugins'); ?>
    <?PHP echo $this->Html->script('TomatoCms.main'); ?>

    <!-- Javascript code only for this page -->

    <!-- CakePHP SCRIPT,CSS WriteBuffer -->
    <?php
    echo $this->TomatoLayout->js();

    echo $this->fetch('css');
    echo $this->fetch('script');
    echo $this->Js->writeBuffer();
    ?>
    <!-- End CakePHP CSS WriteBuffer -->
</head>
<body>