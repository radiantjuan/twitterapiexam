<?PHP
App::uses('TomatoCmsPageRouter', 'TomatoCms.Lib');
App::uses('TomatoCmsAppModel', 'TomatoCms.Model');

class Page extends TomatoCmsAppModel{
    public $actsAs = array(
        'TomatoCms.Trackable' => array(
            'priority' => 1,
            'fields' => array(
                'created_by' => 'created_by',
                'updated_by' => 'updated_by'
            )
        )
    );

    public $validate = array(
        'title' => array(
            'size' => array(
                'rule' => array('minLength', 5),
                'message' => 'Title name should be at least 5 chars long'
            ),
            "notEmpty"  => array(
                "rule"          => "notEmpty",
                "message"       => "Title is required.",
            )
        ),
        'slug' => array(
            'slug' => array(
                'rule'    => 'alphaNumericDashUnderscore',
                'message' => 'Slug can only be letters, numbers, dash and underscore'
            ),
            "notEmpty"  => array(
                "rule"          => "notEmpty",
                "message"       => "Slug is required.",
            )
        ),
        'body' => array(
            "notEmpty"  => array(
                "rule"          => "notEmpty",
                "message"       => "Body is required.",
            )
        ),
        'layout' => array(
            "notEmpty"  => array(
                "rule"          => "notEmpty",
                "message"       => "Layout is required.",
            )
        )
    );

    public function onEditBeforeFindCallback(){
        $this->bindModel(array(
            'belongsTo' => array(
                'CreatedBy' => array(
                    'className' => 'User',
                    'foreignKey' => 'created_by'
                ),
                'UpdatedBy' => array(
                    'className' => 'User',
                    'foreignKey' => 'updated_by'
                ),
                'PublishedBy' => array(
                    'className' => 'User',
                    'foreignKey' => 'published_by_id'
                )
            )
        ));
    }

    public function afterSave($created, $options = array()){
        parent::afterSave($created, $options);
        TomatoCmsPageRouter::flush();
    }

    public function afterDelete(){
        parent::afterDelete();
        TomatoCmsPageRouter::flush();
    }
}