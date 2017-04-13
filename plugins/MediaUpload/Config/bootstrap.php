<?PHP
TomatoNav::add('sidebar',
    array(
        'priority' => 5,
        'parent'   => true,
        'text'     => 'Media Upload',
        'icon'     => array('class' => 'icon-camera-retro'),
        'url'      => array(
            'plugin'     => 'media_upload',
            'controller' => 'media_upload'
        ),
        'children' => null
    )
);
?>