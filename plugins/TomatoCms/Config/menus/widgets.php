<?PHP
// TomatoNav::add('sidebar',
//     array(
//         'priority' => 4,
//         'parent'   => true,
//         'text'     => 'Widgets',
//         'icon'     => array('class' => 'glyphicon-package'),
//         'url'      => 'javascript:void(0)',
//         'children' => array(
//             array(
//                 'parent'   => false,
//                 'text'     => 'All Widgets',
//                 'icon'     => array('class' => 'icon-chevron-sign-right'),
//                 'url'      => array(
//                     'plugin'     => Configure::read("TOMATO_CMS_PLUGINNAME"),
//                     'controller' => 'widgets',
//                     'action'     => 'index',
//                     'prefix'     => Configure::read("TOMATO_CMS_ADMIN_PREFIX"),
//                     Configure::read("TOMATO_CMS_ADMIN_PREFIX") => true
//                 )
//             )
//         ),
//     )
// );