<?PHP
App::uses('TomatoCmsAppModel', 'TomatoCms.Model');

class Role extends TomatoCmsAppModel{
    public $actsAs = array('TomatoCms.Trackable');

    public $validate = array(
        'role_name' => array(
            "notBlank"  => array(
                "rule"          => "notBlank",
                "message"       => "Role Name is required.",
            )
        )
    );
}