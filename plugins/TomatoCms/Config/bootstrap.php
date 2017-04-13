<?PHP
Configure::write('TomatoCms.Version', '2.0');
Configure::write('TomatoCms.AdminRoleId', 1);
Configure::write('TomatoCms.UserModulePluginsPath', APP . DS . 'Plugin' . DS . 'TomatoUserModules');
Configure::write('TomatoCms.UserWidgetPluginsPath', APP . DS . 'Plugin' . DS . 'TomatoUserWidgets');

Configure::write("TOMATO_CMS_PLUGINNAME", "tomato");
Configure::write("TOMATO_CMS_ADMIN_PREFIX", "admin");

App::uses('TomatoNav', 'TomatoCms.Lib');
App::uses('TomatoFileLoaders', 'TomatoCms.Lib');
App::uses('TomatoCmsModuleLoader', 'TomatoCms.Lib');
App::uses('TomatoCmsWidgetLoader', 'TomatoCms.Lib');
App::uses('TomatoCmsPageRouter', 'TomatoCms.Lib');
App::uses('TomatoPosts', 'TomatoCms.Lib');

TomatoFileLoaders::load(dirname(__FILE__) . DS . 'menus');

$cacheDispatcher = 'TomatoCms.TomatoCmsCacheDispatcher';
if(Configure::read('TomatoCms.CacheDispatcher')){
    $cacheDispatcher=Configure::read('TomatoCms.CacheDispatcher');
}

$oldDispatcher = Configure::read('Dispatcher.filters');
$dispatchers = array(
    'AssetDispatcher',
    'FrontEndDispatcher',
    $cacheDispatcher,
    'TomatoCms.TomatoPostDispatcher',
    'TomatoCms.TomatoCmsDispatcher'
);
if(is_array($oldDispatcher) && sizeof($oldDispatcher)>0){
    $dispatchers = array_merge($oldDispatcher, $dispatchers);
}
Configure::write('Dispatcher.filters', $dispatchers);

App::build(array(
    'Plugin' => array(
        Configure::read('TomatoCms.UserModulePluginsPath') . DS,
        Configure::read('TomatoCms.UserWidgetPluginsPath') . DS
    )
));

TomatoCmsModuleLoader::load();
TomatoCmsWidgetLoader::load();

CakePlugin::load('DebugKit');
CakePlugin::load('Search');
// CakePlugin::load('MediaUpload', array(
//     'bootstrap'     => true,
//     'routes'        => true
// ));

// Cache View
Configure::write('TomatoCms.CacheViewConfigKey', '__cache_view__');
Configure::write('TomatoCms.CacheViewPrefix', '__cache_view__');
if( !Cache::read('__cache_view__') ) {
    Cache::config('__cache_view__', array(
        'engine'   => 'File',
        'duration' => 300,
        'path'     => CACHE . 'views' . DS,
        'prefix'   => '__cache_view__'
    ));
}

if( function_exists('appRoutesCallback') ){
    appRoutesCallback();
}

TomatoPosts::initialize();
require_once APP . 'Config' . DS . 'routes.php';
CakePlugin::routes();
require CAKE . 'Config' . DS . 'routes.php';
