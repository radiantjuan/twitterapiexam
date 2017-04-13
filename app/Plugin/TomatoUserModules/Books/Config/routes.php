<?PHP
$slug              = Configure::read('Module.Books.slug');
$packageName       = Configure::read('Module.Books.package_name');
$defaultController = Configure::read('Module.Books.package_name');
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

Configure::delete('Module.Books.slug');
Configure::delete('Module.Books.package_name');