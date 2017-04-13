<?php
require_once(ROOT . DS . "plugins" . DS . "TomatoCms" . DS ."Lib" . DS . "TomatoFileLoaders.php");

$appEnv = getenv('APP_ENV');
if(!$appEnv){
	$appEnv = "default";
}

if( php_sapi_name() == 'cli' ){
	$appEnv = "development";
}

$whereAmI = dirname( __FILE__ );
TomatoFileLoaders::load( $whereAmI . DS . $appEnv . DS . 'bootstrap' );

function appRoutesCallback(){
}

CakePlugin::load('TomatoCms', array(
    'bootstrap' => true,
    'routes'    => true
));

App::uses('WebConfigManager', 'WebConfig.Lib');
WebConfigManager::initializeData();

Configure::write('TomatoTagResolver.BeforeRender', 'TomatoTagResolverBeforeRender');
function TomatoTagResolverBeforeRender($html){
    App::uses('TomatoHtmlMinified', 'TomatoCms.Lib');
    App::uses('WebConfigManager', 'WebConfig.Lib');

    $domain = Router::url('/', true);
    $html = str_replace("{DOMAIN_NAME}", $domain, $html);

    WebConfigManager::patch($html);
    return $html;
}
