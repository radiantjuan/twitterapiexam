<?PHP
require_once VENDORS.'facebook/php-sdk-v4/src/Facebook/autoload.php';

class TomatoCurlOptsHttpClient extends Facebook\HttpClients\FacebookCurlHttpClient{
    public function openConnection($url, $method, $body, array $headers, $timeOut){
        parent::openConnection($url, $method, $body, $headers, $timeOut);
        
        $options = [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_TIMEOUT => 60
        ];
        
        $this->facebookCurl->setoptArray($options);
    }
}