<?PHP
App::uses('AppController', 'Controller');
App::uses('TwitterAPIExchange', 'Lib');

class HomeController extends AppController {
    public $components = array('RequestHandler',
        'Security' => array(
                'csrfExpires' => '+1 hour',
                'unlockedActions' => array(
                    'search_post',
                    'edit_post'
                )
            )
        );

	public function index(){
		try {
			$settings = array(
				'oauth_access_token' => '717360042442264576-l3MSFFPvRyaiaF1cNp6s4QWD6IF0uKB',
				'oauth_access_token_secret' => '8jsL50JbamubEIuZPuaBo8rz9qqGqq2vex6cWQx498WIR',
				'consumer_key' => 'AB59fz6YYBWGIgywKCFkIsQ9J',
				'consumer_secret' => 'Ef9ipykI2R1GIFCNs1OYA1h3HHs386r5ulqUHDHD13gGGH3S4P'
			);
			$twitter = new TwitterAPIExchange($settings);

			$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
			$getfield = '?screen_name=radiantcjuan';
			$requestMethod = 'GET';

			$response = $twitter->setGetfield($getfield)
			    ->buildOauth($url, $requestMethod)
			    ->performRequest();

			pr(json_decode($response));

		} catch (Exception $e) {
			pr($e);
		}
	}

	public function get_post(){

	}

	public function search_post(){

	}

	public function edit_post(){

	}

}