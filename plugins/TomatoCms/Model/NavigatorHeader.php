<?php
App::uses('TomatoCmsAppModel', 'TomatoCms.Model');

class NavigatorHeader extends TomatoCmsAppModel{
    public $actsAs = array(
        'TomatoCms.Trackable'
    );

    public $validate = array(
        'title' => array(
            "notEmpty"  => array(
                "rule"          => "notBlank",
                "message"       => "Title is required.",
            )
        ),
        'tag' => array(
            "notEmpty"  => array(
                "rule"          => "notBlank",
                "message"       => "Tag is required.",
            ),
            "alphaNumericDashUnderscore" => array(
                "rule"          => "alphaNumericDashUnderscore",
                "message"       => "tag can only be letters, numbers, dash and underscore",
            ),
            "isUnique"  => array(
                "rule"     => array('isUnique'),
                "message"  => "Tag already exist."
            )
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