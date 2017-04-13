<?PHP
//
// Configure::read('TomatoPost.id');

class TomatoPosts{

	private function TomatoPosts(){}

	public static function initialize(){

		$post = ClassRegistry::init(array(
            'class' => 'TomatoCms.Post',
            'alias' => 'Post'
        ));

		if(!isset($_SERVER['REQUEST_URI'])) return false;

		$url = $_SERVER['REQUEST_URI'];
		if($url[0]=='/'){
			$url = substr($url, 1);
		}

		if( Configure::read('IS_SUBFOLDER') == true ){
			$url = str_replace( Configure::read('SUBFOLDER_NAME').'/', '', $url  );
		}

		$data = $post->find('first', array(
			'fields' => array('Post.id'),
        	'conditions' => array(
        		'permalink' => $url
        		)
        	));

		if($data){
			Router::connect("/{$url}",
			    array(
			        'plugin'     => 'tomato_cms',
			        'controller' => 'posts',
			        'action'     => 'view_page',
			        'post_id'    => $data['Post']['id']
			    ),
			    array(
			        'pass' => array('post_id')
			    )
			);

			Configure::write('TomatoPost.id', $data['Post']['id']);	
		}

	}

	public static function getCurrentPost(){
		$id = Configure::read('TomatoPost.id');
		if( !$id ){
			return false;
		}

		$post = ClassRegistry::init(array(
            'class' => 'TomatoCms.Post',
            'alias' => 'Post'
        ));

		$post->bindModel(array(
			'belongsTo' => array(
				'Author' => array(
					'className' => 'TomatoCms.User',
					'foreignKey' => 'post_author'
					)
				)
			));

		$conditions = array(
			'Post.id' => $id
		);
		if( !CakeSession::read('Auth.User.id') ){
			$conditions[] = array(
				'Post.post_status' => 'published'
			);
		}

        $data = $post->find('first', array(
        	'fields' => array(
        		'Post.*', 'Author.email', 'Author.firstname', 'Author.middlename', 'Author.lastname', 'Author.id' 
        		),
        	'conditions' => $conditions
        	));

        return $data;
	}

	public static function getRelatedPosts(){
		$id = Configure::read('TomatoPost.id');
		if( !$id ){
			return false;
		}

		$post = ClassRegistry::init(array(
            'class' => 'TomatoCms.Post',
            'alias' => 'Post'
        ));

		$post->bindModel(array(
			'belongsTo' => array(
				'Author' => array(
					'className' => 'TomatoCms.User',
					'foreignKey' => 'post_author'
					)
				)
			));

        $data = $post->find('all', array(
        	'fields' => array(
        		'Post.*', 'Author.email', 'Author.firstname', 'Author.middlename', 'Author.lastname', 'Author.id' 
        		),
        	'conditions' => array(
        		'Post.id IN (
        			SELECT B.post_id FROM post_tags B WHERE B.tag_id IN( 
		        		SELECT A.tag_id FROM post_tags A WHERE A.post_id='.$id.' 
		        	)
        		)',
        		'Post.id <> '.$id,
        		'Post.post_status' => 'published'
        		)

        	));

        return ($data);
	}

}