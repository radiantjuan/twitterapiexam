<?PHP
TomatoNav::add('sidebar',
    array(
        'priority' => 2,
        'parent'   => true,
        'text'     => 'Modules',
        'icon'     => array('class' => 'icon-dropbox'),
        'url'      => '#',
        'children' => array(
            array(
                'priority' => 1,
                'parent'   => false,
                'text'     => 'All Modules',
                'icon'     => array('class' => 'icon-chevron-sign-right'),
                'url'      => array(
                    'plugin'     => Configure::read("TOMATO_CMS_PLUGINNAME"),
                    'controller' => 'modules',
                    'action'     => 'index',
                    'prefix'     => Configure::read("TOMATO_CMS_ADMIN_PREFIX"),
                    Configure::read("TOMATO_CMS_ADMIN_PREFIX") => true
                )
            )
        ),
    )
);