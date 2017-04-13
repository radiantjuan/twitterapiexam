<?PHP
$slug              = "web-config";
$packageName       = 'WebConfig';
$defaultController = 'WebConfig';
$prefix            = 'admin';

Router::connect(
    "/{$prefix}/{$slug}", array(
        'plugin'     => $packageName,
        'controller' => $defaultController,
        'action'     => 'index',
        'prefix'     => $prefix,
        $prefix      => true
    )
);
Router::connect(
    "/{$prefix}/{$slug}/:controller", array(
        'plugin'     => $packageName,
        'action'     => 'index',
        'prefix'     => $prefix,
        $prefix      => true
    )
);
Router::connect(
    "/{$prefix}/{$slug}/:controller/:action/*", array(
        'plugin'     => $packageName,
        'prefix'     => $prefix,
        $prefix      => true
    )
);



Router::connect(
    "/{$slug}", array(
        'plugin'     => $packageName,
        'controller' => $defaultController,
        'action'     => 'index'
    )
);
Router::connect(
    "/{$slug}/:controller", array(
        'plugin' => $packageName,
        'action' => 'index'
    )
);
Router::connect(
    "/{$slug}/:controller/:action/*", array(
        'plugin' => $packageName
    )
);