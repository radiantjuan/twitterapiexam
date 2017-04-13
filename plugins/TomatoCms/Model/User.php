<?PHP
App::uses('TomatoCmsAppModel', 'TomatoCms.Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends TomatoCmsAppModel{
    public $actsAs = array('TomatoCms.Trackable');
    public $disabledClearCached = true;

    public $validate = array(
        'email' => array(
            'email' => array(
                'rule' => array('email'),
                'message' => 'Invalid email format.'
            ),
            "notBlank"  => array(
                "rule"          => "notBlank",
                "message"       => "Email is required.",
            ),
            "isUnique"  => array(
                "rule"          => "isUnique",
                "message"       => "Email already taken.",
            )
        ),
        'firstname' => array(
            "notBlank"  => array(
                "rule"          => "notBlank",
                "message"       => "Firstname is required.",
            )
        ),
        'lastname' => array(
            "notBlank"  => array(
                "rule"          => "notBlank",
                "message"       => "Lastname is required.",
            )
        ),
        'role_id' => array(
            "notBlank"  => array(
                "rule"          => "notBlank",
                "message"       => "Role is required.",
            )
        ),
        'password' => array(
            "notBlank"  => array(
                "rule"          => "notBlank",
                "message"       => "Password is required.",
                ''
            ),
            "minLength"  => array(
                "rule"          => array('minLength', 8),
                "message"       => "Minimum of 8 characters long.",
            ),
            "equalToConfirmPassword" => array(
                "rule"          => array('equalToField', 'confirm_password'),
                "message"       => "Password didn't match.",
            )
        ),
        'confirm_password' => array(
            "notBlank"  => array(
                "rule"          => "notBlank",
                "message"       => "Confirm Password is required.",
            )
        )
    );

    function equalToField($array, $field) {
        return strcmp($this->data[$this->alias][key($array)], $this->data[$this->alias][$field]) == 0;
    }

    public function beforeSave($options = array()) {

        if (isset($this->data[$this->alias]['password']) && $this->data[$this->alias]['password'] != '') {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }

        if( isset( $this->data[$this->alias][$this->primaryKey] ) ){
            if( !isset($this->data[$this->alias]['change_password']) || ( isset($this->data[$this->alias]['change_password']) && $this->data[$this->alias]['change_password'] != 1 ) ){
                unset($this->data[$this->alias]['password']);
                unset($this->data[$this->alias]['confirm_password']);
                unset($this->data[$this->alias]['change_password']);
            }
        }
        

        return true;
    }

    public function beforevalidate($options=array()){
        if( !isset($this->data[$this->alias]['change_password']) || ( isset($this->data[$this->alias]['change_password']) && $this->data[$this->alias]['change_password'] != 1 ) ){
            $this->validator()->remove('password', 'notBlank');
            $this->validator()->remove('password', 'minLength');
            $this->validator()->remove('password', 'equalToConfirmPassword');
            $this->validator()->remove('confirm_password', 'notBlank');
        }
    }

    public function onIndexBeforePaginateCallback(){

        $this->bindModel(array(
            'belongsTo' => array(
                'Role' => array(
                    'className' => 'TomatoCms.Role',
                    'foreignKey' => 'role_id'
                )
            )
        ));

        return true;
    }
}