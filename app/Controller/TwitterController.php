<?PHP
App::uses('AppController', 'Controller');
App::uses('TwitterAPIExchange', 'Lib');

class TwitterController extends AppController {
    public $components = array('RequestHandler',
        'Security' => array(
                'csrfExpires' => '+1 hour',
                'unlockedActions' => array(
                    'search_post',
                    'edit_post'
                )
            )
        );

	public function gettweets($screen_name){
		try {
			$this->layout=false;
			$this->autoRender=false;
			$this->loadModel('Tweets');
			$settings = array(
				'oauth_access_token' => '717360042442264576-l3MSFFPvRyaiaF1cNp6s4QWD6IF0uKB',
				'oauth_access_token_secret' => '8jsL50JbamubEIuZPuaBo8rz9qqGqq2vex6cWQx498WIR',
				'consumer_key' => 'AB59fz6YYBWGIgywKCFkIsQ9J',
				'consumer_secret' => 'Ef9ipykI2R1GIFCNs1OYA1h3HHs386r5ulqUHDHD13gGGH3S4P'
			);
			$twitter = new TwitterAPIExchange($settings);

			$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
			$getfield = '?screen_name='.$screen_name.'&include_rts=0&count=200';
			$requestMethod = 'GET';

			$response = $twitter->setGetfield($getfield)
			    ->buildOauth($url, $requestMethod)
			    ->performRequest();

			$responseArr = json_decode($response);
			$responseCount = count($responseArr);
			$tweetCounts = $responseArr[$responseCount-1]->user->statuses_count;
			
			$this->Tweets->query('TRUNCATE TABLE tweets;');
			foreach ($responseArr as $key => $value) {
				$this->Tweets->set(
					array(
						'tweet_id' => $value->id,
						'tweet_text' => $value->text,
						'created_at' => date('Y-m-d H:i',strtotime($value->created_at)),
						'created_date' => date('Y-m-d',strtotime($value->created_at)),
						'created_hour' => date('H',strtotime($value->created_at)),
						'user_id' => $value->user->id,
						'user_name' => $value->user->name,
						'screen_name' => $value->user->screen_name,
						'user_url' => $value->user->url,
						'profile_image' => str_replace("_normal", "", $value->user->profile_image_url)
					)
				);
				$this->Tweets->saveAll();
			}

			$totalTweetCount = $this->Tweets->find('count');

			if ($tweetCounts > 500) {
				while($totalTweetCount < 500){
					$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
					$count = 200;
					if($totalTweetCount >= 400){
						$count = 100;
					}
					$getfield = '?screen_name='.$screen_name.'&include_rts=0&count='.$count.'&max_id='.$responseArr[$responseCount-1]->id;
					$requestMethod = 'GET';
					$response = $twitter->setGetfield($getfield)
					    ->buildOauth($url, $requestMethod)
					    ->performRequest();
					$responseArr = json_decode($response);
					$responseCount = count($responseArr);
					foreach ($responseArr as $key => $value) {
						$this->Tweets->set(
							array(
								'tweet_id' => $value->id,
								'tweet_text' => $value->text,
								'created_at' => date('Y-m-d H:i',strtotime($value->created_at)),
								'created_date' => date('Y-m-d',strtotime($value->created_at)),
								'created_hour' => date('H',strtotime($value->created_at)),
								'user_id' => $value->user->id,
								'user_name' => $value->user->name,
								'screen_name' => $value->user->screen_name,
								'user_url' => $value->user->url,
								'profile_image' => str_replace("_normal", "", $value->user->profile_image_url)
							)
						);
						$this->Tweets->saveAll();
					}
					$totalTweetCount = $this->Tweets->find('count');
				}
			}

	        return true;

		} catch (Exception $e) {
			pr($e);
			return false;
		}
	}

	public function viewtweets($screen_name){
		$this->layout=false;
		$this->autoRender=false;
		$this->response->header('Access-Control-Allow-Origin','*');
		if ($this->gettweets($screen_name)) {
			$this->loadModel('Tweets');
			try {
				$data = $this->Tweets->find('all',
					array(
						'fields'=>array('count(id) as tweetcount','created_hour','screen_name','profile_image'),
						'group' => array('created_hour','screen_name','profile_image'),
						'order' => array('created_hour' => 'asc')
					)
				);
				return json_encode($data);
			} catch (Exception $e) {
				pr($e);
			}
		}

		// $this->response->header('Access-Control-Allow-Origin','*');
		// $this->loadModel('Tweets');
		// $this->layout=false;
		// $this->autoRender=false;
		// try {
		// 	$data = $this->Tweets->find('all',
		// 		array(
		// 			'fields'=>array('count(id) as tweetcount','created_hour','user_url'),
		// 			'group' => array('created_hour','user_url'),
		// 			'order' => array('created_hour' => 'asc')
		// 		)
		// 	);
		// 	// $data2 = Set::extract('/Tweets/.', $data);
		// 	// pr($data2);
		// 	return json_encode($data);
		// } catch (Exception $e) {
		// 	pr($e);
		// }
	}

}