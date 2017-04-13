<?PHP
App::uses('TomatoCmsAppController', 'TomatoCms.Controller');
App::uses('TomatoFrontendLayout', 'TomatoCms.Lib');

class PostsController extends TomatoCmsAppController{

	public $title_for_layout = 'Posts';

	public $uses = array('TomatoCms.Post');

	public $helpers = array(
		'Cache' => array(
		    'className' => 'TomatoCms.TomatoCacheStatic'
		)
    );

	public $cacheAction = array(
		'view_page' => 36000
	);

	public function beforeFilter(){

		$this->Security->unlockedFields = array('Tag.tag_list', 'Button.save_draft', 'Button.update', 'Button.published', 'Button.move_to_trash');

		parent::beforeFilter();
	}

	public function view_page(){
		$currentPost = TomatoPosts::getCurrentPost();
		if(!$currentPost){
			throw new NotFoundException();
		}

		if( $currentPost['Post']['post_layout'] ){
			$this->layout = $currentPost['Post']['post_layout'];
		}

		SocialMeta::setUrl(Router::url(null, true));
		SocialMeta::setDescription($currentPost['Post']['seo_description']);
		SocialMeta::setTitle($currentPost['Post']['seo_title']);
		SocialMeta::setTags($currentPost['Post']['seo_tags']);

		if($currentPost['Post']['seo_title']){
			$this->set('title', $currentPost['Post']['seo_title']);
		}else{
			$this->set('title', $currentPost['Post']['post_title']);
		}

		$this->set('currentPost', $currentPost);
	}

	public function admin_index(){
		$conditions=array();

		if( isset($this->request->named['status']) && $this->request->named['status'] ){
			$conditions[] = array(
				'Post.post_status' => $this->request->named['status']
				);			
		}else{
			$conditions[] = array(
				'Post.post_status <> ' => 'trash'
				);
		}

		if( isset($this->request->named['tag']) && $this->request->named['tag'] ){
			$conditions[] = array(
				'Post.id IN (SELECT A.post_id FROM post_tags A WHERE A.tag_id='.$this->request->named['tag'].' ) '
				);
		}

		
        $this->Paginator->settings = array(
            'Post' => array(
                'limit'      => 20,
                'conditions' => $conditions,

                'contain' => array(
                	'Author',
                	'PostTag' => array(
                		'Tag' => array(
                			'fields' => array(
                				'tag', 'id'
                				)
                			)
                		)
                	)
            )
        );

        $this->Post->Behaviors->load('Containable');
        $this->Post->bindModel(array(
			'belongsTo' => array(
				'Author' => array(
					'className' => 'TomatoCms.User',
					'foreignKey' => 'post_author'
					)
				)
			)
        );

        $this->Post->bindModel(array(
			'hasMany' => array(
        		'PostTag' => array(
        			'className' => 'TomatoCms.PostTag'
        			)
        		)
			)
        );
        $this->Post->PostTag->bindModel(array(

        	'belongsTo' => array(
        		'Tag' => array(
        			'className' => 'TomatoCms.Tag'
        			)
        		)

        	));
        	

        $Posts = $this->Paginator->paginate('Post');
        $this->set('Posts', $Posts);
	}

	public function admin_add(){
		
		if( $this->request->is(array('post','put')) ){

			$this->Post->create($this->request->data);
			$validate = $this->Post->validates();
			if(!$validate){
				$this->Session->setFlash(
                    'Please check error.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-danger')
                );
			}else{

				$this->Post->set('post_date', date("Y-m-d H:i:s"));
				$this->Post->set('post_modified', date("Y-m-d H:i:s"));
				$this->Post->set('post_published', NULL);
				$this->Post->set('post_status', 'draft');
				$this->Post->set('post_author', CakeSession::read('Auth.User.id'));

				$this->Post->save($this->Post->data, false);

				 $this->Session->setFlash(
	                'Post successfully saved.',
	                'TomatoCms.alert-box',
	                array('class' => 'alert-success')
	            );

				$this->redirect( array('action'=>'edit', $this->Post->id) );

			}

		}

	}

	public function admin_edit($id){
		App::uses('TimeAgo', 'Lib');
		
		if( !$this->request->is(array('post','put')) ){
			$this->request->data = $this->Post->find('first', array(

				'conditions' => array(
					'Post.id' => $id
					)

				));
			if($this->request->data['Post']['post_status']=='trash'){
				throw new BadRequestException();
			}

			$this->loadModel('TomatoCms.PostTag');
			$tags = $this->PostTag->getTags($id);
			$this->set('tags', $tags);
		}else{
			$tags = explode(",",$this->request->data['Tag']['tag_list']);
			$this->set('tags', $tags);

			$this->Post->set($this->request->data);
			$validate = $this->Post->validates();
			if(!$validate){
				$this->Session->setFlash(
                    'Please check error.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-danger')
                );
			}else{
				$this->Post->set('post_modified', date("Y-m-d H:i:s"));
				if( isset($this->request->data['Button']['move_to_trash']) ){
					
					$this->Post->updateTags = false;
					$this->Post->set('post_status', 'trash');
					$this->Post->save($this->Post->data, false, array(

						'post_status',
						'post_modified'

						));

				}else{
					if( isset($this->request->data['Button']['save_draft']) ){
						$this->Post->set('post_status', 'draft');
					}else if( isset($this->request->data['Button']['published']) ){
						$this->Post->set('post_status', 'published');
						$this->Post->set('post_published', date("Y-m-d H:i:s"));
					}
					
					$this->Post->save($this->Post->data, false);
				}

				 $this->Session->setFlash(
	                'Post successfully saved.',
	                'TomatoCms.alert-box',
	                array('class' => 'alert-success')
	            );

				$this->redirect( array('action'=>'edit', $this->Post->id) );

			}

		}

		$this->loadModel('TomatoCms.PostsRevision');
		$this->PostsRevision->bindModel(array(
			'belongsTo' => array(
				'Author' => array(
					'className' => 'TomatoCms.User',
					'foreignKey' => 'post_author'
					)
				)
			));
		$this->set('revisions', $this->PostsRevision->find('all', array(
			'conditions' => array(
				'PostsRevision.post_id' => $id
				)
			)));
	}

	public function admin_trash($id){
		$this->autoRender = false;

		$data = $this->Post->read(null,$id);
		if(!$data){
			throw new BadRequestException();
		}

		if( $this->Post->data['Post']['post_status'] == 'trash' ){
			throw new BadRequestException();
		}

		$this->Post->set('post_status', 'trash');
		$this->Post->set('post_modified', date("Y-m-d H:i:s"));
		$this->Post->save($this->Post->data, false, array(
			'post_status',
			'post_modified'
			));

		$this->redirect( array('action'=>'index') );
	}

	public function admin_restore($id){
		$this->autoRender = false;

		$data = $this->Post->read(null,$id);
		if(!$data){
			throw new BadRequestException();
		}

		if( $this->Post->data['Post']['post_status'] != 'trash' ){
			throw new BadRequestException();
		}

		$this->Post->set('post_status', 'draft');
		$this->Post->set('post_modified', date("Y-m-d H:i:s"));
		$this->Post->save($this->Post->data, false, array(
			'post_status',
			'post_modified'
			));

		$this->redirect( $this->request->referer() );
	}

	public function admin_get_tags(){
		$this->autoRender = false;

		$this->loadModel('Tag');

		$tags = $this->Tag->find('all', array(
			'fields' => array(
				'tag'
				)
			));

		$data = array();
		foreach($tags as $t){
			$data[] = $t['Tag']['tag'];
		}

		header("Content-Type: application/json");
		echo json_encode($data);


		exit;
	}

	public function admin_generate_slug($title){
		$this->autoRender = false;

		header("Content-Type: application/json");

		$return = array();
		$return['slug'] = strtolower( Inflector::slug($title, '-') );

		echo json_encode($return);

		exit;
	}
}