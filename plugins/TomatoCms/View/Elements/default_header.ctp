<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title><?php echo $this->fetch('title'); ?></title>

    <meta name="description" content="TomatoCake CMS">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <?PHP echo $this->Html->meta(array(
        'rel'  => 'shortcut icon',
        'link' => 'TomatoCms.img/favicon.ico'
    ));?>
    <!-- END Icons -->

    <!-- Get Jquery library from Google but if something goes wrong get Jquery from local file - Remove 'http:' if you have SSL -->
    <?PHP if(
        (isset($dont_include_jquery) && !$dont_include_jquery)
        ||
        (!isset($dont_include_jquery))
    ): ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <?PHP endif; ?>

    <!-- Stylesheets -->
    <!-- The roboto font is included from Google Web Fonts -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,400italic,700,700italic">
    <!-- Bootstrap is included in its original form, unaltered -->
    <?PHP echo $this->Html->css('TomatoCms.bootstrap'); ?>

    <!-- Related styles of various javascript plugins -->
    <?PHP echo $this->Html->css('TomatoCms.plugins'); ?>

    <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
    <?PHP echo $this->Html->css('TomatoCms.main'); ?>

    <?PHP echo $this->Html->css('TomatoCms.themes'); ?>
    <?PHP echo $this->Html->css('TomatoCms.themes/deepblue'); ?>
    <!-- END Stylesheets -->

    <?PHP echo $this->Html->css('TomatoCms.others'); ?>

    <?PHP echo $this->fetch('css'); ?>
</head>

<?PHP if($this->request->controller=="users" && $this->request->action=="admin_login"): ?>
<body class="login">
<?PHP else: ?>
<body>
<?PHP endif ?>
<!-- Page Container -->
<div id="page-container">
    <?PHP if($this->TomatoLayout->isLoggedIn()): ?>
    <!-- Header -->
    <!-- Add the class .navbar-fixed-top or .navbar-fixed-bottom for a fixed header on top or bottom respectively -->
    <!-- <header class="navbar navbar-inverse navbar-fixed-top"> -->
    <!-- <header class="navbar navbar-inverse navbar-fixed-bottom"> -->
    <header class="navbar navbar-inverse navbar-fixed-top">
        <!-- Mobile Navigation, Shows up  on smaller screens -->
        <ul class="navbar-nav-custom pull-right hidden-md hidden-lg">
            <li>
                <!-- It is set to open and close the main navigation on smaller screens. The class .navbar-main-collapse was added to aside#page-sidebar -->
                <a href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="icon-reorder"></i>
                </a>
            </li>
        </ul>
        <!-- END Mobile Navigation -->

        <!-- Logo -->
        <?PHP
       //  echo $this->Html->link(
       //     $this->Html->image('TomatoCms.template/admin-logo.png', array('alt' => 'Logo')),
       //     '/admin',
       //     array('escapeTitle' => false)
       // );
        ?>

        <!-- Loading Indicator, Used for demostrating how loading of widgets could happen, check main.js - uiDemo() -->
        <div id="loading" class="pull-left"><i class="icon-certificate icon-spin"></i></div>

        <!-- Header Widgets -->
        <!-- You can create the widgets you want by replicating the following. Each one exists in a <li> element -->
        <ul id="widgets" class="navbar-nav-custom pull-right">
            <!-- Just a divider -->
            <li class="divider-vertical"></li>

            <!-- User Menu -->
            <li class="dropdown pull-right dropdown-user">
                <?PHP
                echo $this->Html->link(
                    '<i class="icon icon-user" style="font-size:20px; color: #fff;"></i><b class="caret"></b>',
                    "javascript:void(0)",
                    array(
                        'escapeTitle' => false,
                        'class'       => 'dropdown-toggle',
                        'data-toggle' => 'dropdown'
                    )
                );
                ?>

                <ul class="dropdown-menu">
                    <li>
                        <!-- Modal div is at the bottom of the page before including javascript code -->
                        <a href="<?PHP echo Router::url('/admin/profile'); ?>" role="button" data-toggle="modal"><i class="icon-user"></i> <?PHP echo __('User Profile'); ?></a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="<?PHP echo Router::url('/'); ?>" target="_blank"><i class="icon-eye-open"></i> <?PHP echo __('View Site'); ?></a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <?PHP echo $this->Html->link(
                            '<i class="icon-lock"></i>' . __('Log out'),
                            array(
                                'plugin'     => 'tomato_cms',
                                'controller' => 'users',
                                'action'     => 'logout'
                            ),
                            array(
                                'escapeTitle' => false
                            )
                        ); ?>
                    </li>
                </ul>
            </li>
            <!-- END User Menu -->
        </ul>
        <!-- END Header Widgets -->
    </header>
    <!-- END Header -->
    <?PHP endif; ?>