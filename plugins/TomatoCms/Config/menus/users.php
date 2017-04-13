<?PHP
TomatoNav::add('sidebar',
    array(
        'priority' => 6,
        'parent'   => true,
        'text'     => 'Users',
        'icon'     => array('class' => 'icon-group'),
        'children' => array(),
        'url'      => 'javascript:void(0)',
        'children' => array(
            array(
                'priority' => 1,
                'parent'   => false,
                'text'     => 'Users',
                'url'      => array(
                    'plugin'     => Configure::read("TOMATO_CMS_PLUGINNAME"),
                    'controller' => 'users',
                    'action'     => 'index',
                    'prefix'     => Configure::read("TOMATO_CMS_ADMIN_PREFIX"),
                    Configure::read("TOMATO_CMS_ADMIN_PREFIX") => true
                )
            ),
            array(
                'priority' => 2,
                'parent'   => false,
                'text'     => 'Roles',
                'url'      => array(
                    'plugin'     => Configure::read("TOMATO_CMS_PLUGINNAME"),
                    'controller' => 'roles',
                    'action'     => 'index',
                    'prefix'     => Configure::read("TOMATO_CMS_ADMIN_PREFIX"),
                    Configure::read("TOMATO_CMS_ADMIN_PREFIX") => true
                )
            )
        )
    )
);