<?PHP
class WebConfigManager{

	private static $isInitialzed = false;

	public static function patch(&$html){
		preg_match_all('/{TMT_WC_[a-zA-Z0-9_\-]+}/', $html, $matches);
	    $matches = array_unique($matches[0]);

	    if(!$matches){
	    	return false;
	    }

	    self::initializeData();
	    
	    foreach($matches as $match){
	        $match = str_replace("{", "", $match);
	        $match = str_replace("}", "", $match);
	        list($prefix, $varName) = explode("TMT_WC_", $match);

	        $html = str_replace("{TMT_WC_{$varName}}", Configure::read('WebConfig.'.$varName), $html);
	    }

	    return true;
	}

	public static function initializeData(){
		if(self::$isInitialzed) return true;

		$webConfig = ClassRegistry::init(array(
			'class' => 'WebConfig.WebConfig',
			'alias' => 'WebConfig'
			));

		$data = Cache::remember('newest_config', function() use ($webConfig){

            return $webConfig->getConfig();

        }, 'web_config_cache');

		foreach($data as $k => $v){
			Configure::write('WebConfig.'.$k, $v);
		}

		self::$isInitialzed = true;
	}

	public static function get($k=null){
		if(!$k){
			return Configure::read('WebConfig');
		}

		return Configure::read('WebConfig.' . $k);
	}
}