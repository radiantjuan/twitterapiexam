<?PHP
class TomatoGoogleUrl{

	public static $key=NULL;

	public static function getShort($url){
		$hash = md5($url);    
	    $purl = $url;

	    $shortUrl = Cache::remember('url_'.$hash, function() use ($hash, $purl){

	        $link = ClassRegistry::init(array(
	            'class' => 'Link',
	            'alias' => 'Link'
	            ));

	        $result = $link->find('first', array(
	            'conditions' => array(
	                'hash' => $hash
	                )
	            ));

	        if(!$result){
	            App::uses('Google', 'Lib');
	            $google = new Google(self::$key);
	            $shortUrl = $google->shorten($purl);

	            $link->create(array(
	                'hash' => $hash,
	                'url' => $purl,
	                'short_url' => $shortUrl
	                ));
	            $link->save();

	        }else{
	            $shortUrl = $result[$link->alias]['short_url'];    
	        }

	        return $shortUrl;

	    }, 'long');

	    return $shortUrl;
	}

}