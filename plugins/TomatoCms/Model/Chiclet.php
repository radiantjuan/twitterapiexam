<?PHP
App::uses('TomatoCmsAppModel', 'TomatoCms.Model');

class Chiclet extends TomatoCmsAppModel{
    public $actsAs = array('TomatoCms.Trackable');

    public $validate = array(
        'title' => array(
            'size' => array(
                'rule' => array('minLength', 5),
                'message' => 'Title name should be at least 5 chars long'
            ),
            "notBlank"  => array(
                "rule"          => "notBlank",
                "message"       => "Title is required.",
            )
        ),
        'body' => array(
            "notBlank"  => array(
                "rule"          => "notBlank",
                "message"       => "Body is required.",
            )
        ),
        'tag' => array(
            "notBlank"  => array(
                "rule"          => "notBlank",
                "message"       => "Tag is required.",
            ),
            "isUnique"  => array(
                "rule"     => array('isUnique'),
                "message"  => "Tag already exist."
            )
        )
    );

    public function beforeSave($options = array()){
        if(isset($this->data['Chiclet']['id'])){
            $oldData = $this->find('first', array(
                "conditions" => array(
                    'id' => $this->data['Chiclet']['id']
                )
            ));

            if( $this->data['Chiclet']['is_published'] == 1 && $oldData['Chiclet']['is_published'] == 0 ){
                $this->data['Chiclet']['published_by_id'] = CakeSession::read("Auth.User.id");
                $this->data['Chiclet']['published_datetime'] = date("Y-m-d H:i:s");
            }
        }else{
            if( $this->data['Chiclet']['is_published'] == 1 ){
                $this->data['Chiclet']['published_by_id'] = CakeSession::read("Auth.User.id");
                $this->data['Chiclet']['published_datetime'] = date("Y-m-d H:i:s");
            }
        }

    }

    public function afterSave($created, $options=array()){
        if($created==FALSE){
            $tagMd5 = md5($this->data['Chiclet']['tag']);
            Cache::delete('chiclet_content_'.$tagMd5, 'short');
            Cache::delete('tag_chicklet_'.$this->data['Chiclet']['tag'], 'short');
        }
    }

    public function beforeDelete($cascade=true){
        if( $this->data == false && $this->id ){
            $this->data = $this->find('first', array("conditions" => array("id" => $this->id)));
        }
        return true;
    }

    public function afterDelete(){
        $tagMd5 = md5($this->data['Chiclet']['tag']);
        Cache::delete('chiclet_content_'.$tagMd5, 'short');
        Cache::delete('tag_chicklet_'.$this->data['Chiclet']['tag'], 'short');
    }

    public function getChicletContentByTag($tag){
        $tagMd5 = md5($tag);
        $result = Cache::read('chiclet_content_'.$tagMd5, 'short');
        if (!$result) {
            $result = $this->find('first', array(
                'conditions' => array(
                    'Chiclet.tag' => $tag
                )
            ));
            if($result){
                Cache::write('chiclet_content_'.$tagMd5, $result, 'short');
            }
        }

        return $result;
    }
}