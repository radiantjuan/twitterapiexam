<?PHP
$packageName = 'WebConfig';
TomatoNav::add('sidebar',
    array(
        'priority' => 2.1,
        'parent'   => true,
        'text'     => 'Web Config',
        'icon'     => array('class' => 'icon-wrench'),
        'url'      => array(
                    'plugin'     => $packageName,
                    'controller' => 'WebConfig',
                    'action'     => 'index'
                ),
        'children' => array()
    )
);