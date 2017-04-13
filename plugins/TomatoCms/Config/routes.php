<?php

$prefix="admin";
$cmsName="tomato";
$pluginName="tomato_cms";

Router::redirect('/dmdadmin/*', Router::url('/admin'));
Router::redirect('/dmdpanel/*', Router::url('/admin'));

Router::connect("/{$prefix}", array(
    'plugin'     => $pluginName    ,
    'controller' => 'TomatoCmsApp' ,
    'action'     => 'home'         ,
    'prefix'     => $prefix        ,
    $prefix      => true
));
Router::connect("/{$prefix}/{$cmsName}", array(
    'plugin'     => $pluginName,
    'controller' => 'TomatoCmsApp'  ,
    'action'     => 'home'     ,
    'prefix'     => $prefix    ,
    $prefix      => true
));
Router::connect("/{$prefix}/{$cmsName}/:controller", array(
    'plugin'     => $pluginName,
    'action'     => 'index',
    'prefix'     => $prefix,
    $prefix      => true
));
Router::connect("/{$prefix}/{$cmsName}/:controller/:action/*", array(
    'plugin'     => $pluginName,
    'prefix'     => $prefix,
    $prefix      => true
));

Router::connect("/{$cmsName}", array(
    'plugin'     => $pluginName,
    'controller' => 'TomatoCmsApp'  ,
    'action'     => 'home'
));
Router::connect('/{$cmsName}/:controller', array(
    'plugin'     => $pluginName,
    'action'     => 'index'
));
Router::connect("/{$cmsName}/:controller/:action/*", array(
    'plugin'     => $pluginName
));

// Pages Route
Router::connect('/pages/:page_id/:slug',
    array(
        'plugin'     => $pluginName,
        'controller' => 'pages',
        'action'     => 'view_page'
    ),
    array(
        'page_id' => '[0-9]+'
    )
);
Router::connect('/pages/:page_id/:year/:month/:day/:slug',
    array(
        'plugin'     => $pluginName,
        'controller' => 'pages',
        'action'     => 'view_page'
    ),
    array(
        'page_id' => '[0-9]+',
        'year'    => '[0-9]{4}',
        'month'   => '[0-9]{2}',
        'day'     => '[0-9]{2}'
    )
);

Router::connect("/{$prefix}/profile/*",
    array(
        'plugin'     => $pluginName,
        'controller' => 'users',
        'action'     => 'profile',
        'prefix'     => $prefix,
        $prefix      => true
    )
);

// Forgot Password
Router::connect("/{$prefix}/forgot-password",
    array(
        'plugin'     => $pluginName,
        'controller' => 'users',
        'action'     => 'forgot_password',
        'prefix'     => $prefix,
        $prefix      => true
    )
);
Router::connect("/{$prefix}/reset-password/*",
    array(
        'plugin'     => $pluginName,
        'controller' => 'users',
        'action'     => 'reset_password',
        'prefix'     => $prefix,
        $prefix      => true
    )
);