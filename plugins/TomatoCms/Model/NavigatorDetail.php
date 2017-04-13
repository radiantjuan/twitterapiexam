<?PHP
App::uses('TomatoCmsAppModel', 'TomatoCms.Model');

class NavigatorDetail extends TomatoCmsAppModel{
    public $actsAs = array(
        'TomatoCms.Trackable',
        'TomatoCms.Ordered' => array(
            'field'       => 'weight',
            'foreign_key' => 'navigator_header_id'
        )
    );

    public function afterSave($created, $options=array()){
         $this->deleteCache();
    }

    public function afterDelete($cascade=true){
        $this->deleteCache();
    }

    public function afterSaveAll($options){
        $this->deleteCache();
    }

    public function deleteCache(){
        $this->requestAction(array(
            'plugin'     => 'tomato_cms',
            'controller' => 'navigators',
            'action'     => 'clear_cache',
            'admin'      => true,
            'prefix'     => 'admin'
        ));
    }
}