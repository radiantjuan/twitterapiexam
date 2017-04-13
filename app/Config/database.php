<?php
$appEnv = getenv('APP_ENV');
if(!$appEnv){
	$appEnv = "default";
}

if( php_sapi_name() == 'cli' ){
	$appEnv = "development";
}

$whereAmI = dirname( __FILE__ );
require_once($whereAmI . DS . $appEnv . DS . 'database.php');
