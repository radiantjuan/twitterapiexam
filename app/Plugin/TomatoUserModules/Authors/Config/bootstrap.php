<?PHP
$packageName = 'Authors';
TomatoNav::add('sidebar',
    [
        'priority' => 1.0,
        'parent'   => true,
        'text'     => 'Author',
        'icon'     => array('class' => 'glyphicon-user'),
        'url'      => [
            'plugin'     => $packageName,
            'controller' => 'authors',
            'action'     => 'index',
            'prefix'     => Configure::read("TOMATO_CMS_ADMIN_PREFIX"),
            Configure::read("TOMATO_CMS_ADMIN_PREFIX") => true
        ],
        'children' => []
    ]
);
