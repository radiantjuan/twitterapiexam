<?PHP
App::uses('TomatoCmsAppModel', 'TomatoCms.Model');

class Widget extends TomatoCmsAppModel{
    public $actsAs = array('TomatoCms.Trackable');

    public $validate = array(
        'title' => array(
            'size' => array(
                'rule' => array('minLength', 5),
                'message' => 'Title name should be at least 5 chars long'
            ),
            "notEmpty"  => array(
                "rule"          => "notBlank",
                "message"       => "Title is required.",
            )
        ),
        'package_name' => array(
            "notEmpty"  => array(
                "rule"          => "notBlank",
                "message"       => "Package Name is required.",
            )
        ),
        'tag' => array(
            "notEmpty"  => array(
                "rule"          => "notBlank",
                "message"       => "Tag is required.",
            ),
            "isUnique"  => array(
                "rule"     => array('isUnique'),
                "message"  => "Tag already exist."
            ),
            "alphaNumeric"  => array(
                "rule"     => 'alphaNumeric',
                "message"  => "Alphanumeric only."
            )
        )
    );

    public function getWidgetByTag($tag){
        $this->recursive = -1;

        $data = Cache::read('widget_bytag_'.$tag, 'short');

        if( $data == false ){
            $data = $this->find('first', array(
                'conditions' => array(
                    'tag' => $tag
                )
            ));
            Cache::write('widget_bytag_'.$tag, $data, 'short');
        }
        return $data;
    }

    public function afterSave($created, $options=array()){
        if($created==FALSE){
            Cache::delete('widget_content_'.$this->data['Widget']['tag'], 'short');
            Cache::delete('widget_bytag_'.$this->data['Widget']['tag'], 'short');
            Cache::delete('tag_widget_'.$this->data['Widget']['tag'], 'short');
        }
        Cache::delete('active_widget_list', 'short');
    }

    public function beforeDelete($cascade=true){
        if( $this->data == false ){
            $this->read(null, $this->id);
        }
    }

    public function afterDelete(){
        Cache::delete('widget_content_'.$this->data['Widget']['tag'], 'short');
        Cache::delete('widget_bytag_'.$this->data['Widget']['tag'], 'short');
        Cache::delete('tag_widget_'.$this->data['Widget']['tag'], 'short');
        Cache::delete('active_widget_list', 'short');
    }

    public function getActiveWidgets(){
        $result = Cache::read('active_widget_list', 'short');
        if(!$result){
            $result = $this->find('all', array(
               "conditions" => array(
                   "status" => 1
               )
            ));
            if($result){
                Cache::write('active_widget_list', $result, 'short');
            }
        }
        return $result;
    }
}