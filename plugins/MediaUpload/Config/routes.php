<?PHP
$prefix = 'admin';

Router::connect(
    "/{$prefix}/media_upload/:action/*", array(
        'plugin'     => 'media_upload',
        'controller' => 'media_upload',
        'prefix'     => $prefix,
        $prefix      => true
    )
);