<?PHP
$slug              = Configure::read('Module.Authors.slug');
$packageName       = Configure::read('Module.Authors.package_name');
$defaultController = Configure::read('Module.Authors.package_name');
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

Configure::delete('Module.Authors.slug');
Configure::delete('Module.Authors.package_name');