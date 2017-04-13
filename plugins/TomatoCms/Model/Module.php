<?PHP
App::uses('TomatoCmsAppModel', 'TomatoCms.Model');

class Module extends TomatoCmsAppModel{

    public $useDbConfig = 'admin';

    public $actsAs = array();

    public $validate = array(
        'title' => array(
            'size' => array(
                'rule' => array('minLength', 5),
                'message' => 'Title name should be at least 5 chars long'
            ),
            "notEmpty"  => array(
                "rule"          => "notBlank",
                "message"       => "This is required.",
            )
        ),
        'slug' => array(
            'slug' => array(
                'rule'    => 'extendedSlug',
                'message' => 'Slug can only be letters, numbers, dash, forward slash and underscore'
            ),
            "notEmpty"  => array(
                "rule"          => "notBlank",
                "message"       => "This is required.",
            )
        ),
        'package_name' => array(
            "notEmpty"  => array(
                "rule"          => "notBlank",
                "message"       => "This is required.",
            )
        )
    );

    public function getModules(){
        $result = $this->find('all', array(
           "conditions" => array(
               "enabled" => 1
           )
        ));
        return $result;
    }
}