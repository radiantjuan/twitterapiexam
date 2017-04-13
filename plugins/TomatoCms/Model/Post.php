<?PHP
App::uses('TomatoCmsAppModel', 'TomatoCms.Model');

class Post extends TomatoCmsAppModel{

    public $actsAs = array(
        );

    public $validate = array(
        'post_title' => array(
            "notEmpty"  => array(
                "rule"          => "notBlank",
                "message"       => "This is required.",
            )
        ),
        'post_content' => array(
            "notEmpty"  => array(
                "rule"          => "notBlank",
                "message"       => "This is required.",
            )
        ),
        'permalink' => array(
            "notEmpty"  => array(
                "rule"          => "notBlank",
                "message"       => "This is required.",
            )
        )
    );

    public $updateTags = true;
    public function afterSave($created, $options = array()){

        if(!$this->updateTags){
            return true;
        }

        if( !isset($this->data['Tag']['tag_list']) || !$this->data['Tag']['tag_list'] ){
            return true;
        }

        $tag = ClassRegistry::init(array(
            'class' => 'TomatoCms.Tag',
            'alias' => 'Tag'
        ));

        $tag->saveTags($this->data[$this->alias]['id'], $this->data['Tag']['tag_list']);

        $postsRevision = ClassRegistry::init(array(
            'class' => 'TomatoCms.PostsRevision',
            'alias' => 'PostsRevision'
        ));

        if($this->withRevision):
            $this->oldData[$this->alias]['post_id'] = $this->oldData[$this->alias]['id'];
            unset($this->oldData[$this->alias]['id']);
            $postsRevision->create($this->oldData[$this->alias]);
            $postsRevision->set('post_author', CakeSession::read('Auth.User.id'));
            $postsRevision->set('revision_date', date("Y-m-d H:i:s"));
            $postsRevision->save();
            $this->withRevision = false;
        endif;

        return true;
    }

    public $oldData = array();
    public $withRevision = false;
    public function beforeSave($options=array()){
        $this->oldData = array();
        $this->withRevision = false;

        $this->data[$this->alias]['permalink'] = strtolower( Inflector::slug($this->data[$this->alias]['permalink'], '-') );

        if( isset($this->data[$this->alias]['id']) ){
            $this->oldData = $this->find('first', array(
                'conditions' => array(
                    'id' => $this->data[$this->alias]['id']
                    )
                ));

            if(
                ($this->data[$this->alias]['post_title'] != $this->oldData[$this->alias]['post_title'])
                ||
                ($this->data[$this->alias]['post_content'] != $this->oldData[$this->alias]['post_content'])
                ){

                $this->withRevision = true;

            }
        }
    }
}