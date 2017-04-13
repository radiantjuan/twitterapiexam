<?php
App::uses('WebConfigAppModel', 'WebConfig.Model');
class WebConfig  extends WebConfigAppModel {

    public $actsAs = array(
        'TomatoCms.Trackable' => array(
            'priority' => 1,
            'fields' => array(
                'created_by' => 'created_by_id',
                'updated_by' => 'updated_by_id'
            )
        ),
        'WebConfig.WebConfig' => array(
            'priority'    => 2
        ),
        'TomatoCms.UploadValidator' => array(
            'priority'  => 3,
            'fileField' => array('value_image')
        ),
        'TomatoCms.SThreeUpload'  => array(
            'priority'            => 4,
            'fileField'           => array('value_image'),
            'deleteAfterUpdate'   => false
        )
    );

	public $validate = array(
        'variable' => array(
			"notBlank"  => array(
				"rule"          => "notBlank",
				"message"       => "Title is required",
			),
            "maxLength"  => array(
                "rule"    => array('maxLength', 30),
                'message' => 'Variable must be no larger than 30 characters long.'
            ),
            'isUnique' => array(
                'rule'     => 'isUnique',
                'required' => 'create',
                'message'  => 'Variable already used.'
            ),
            'alphaNumeric' => array(
                'rule'     => 'validVariableName',
                'message'  => 'Allowed character : alphanumeric , _ , -'
            )
		),
        'type' => array(
            "notBlank"  => array(
                "rule"          => "notBlank",
                "message"       => "Type is required",
            )
        )
    );

    public function validVariableName($check) {
        $value = array_values($check);
        $value = $value[0];
        
        $ret = preg_match('/^[a-zA-Z0-9_-]+$/', $value);

        return $ret;
    }

    public function __construct($id = false, $table = null, $ds = null) {
        $this->actsAs['TomatoCms.SThreeUpload']['s3BucketName']      = Configure::read('TomatoCms.S3BucketName');
        $this->actsAs['TomatoCms.SThreeUpload']['s3AccessKeyId']     = Configure::read('TomatoCms.S3AccessKeyId');
        $this->actsAs['TomatoCms.SThreeUpload']['s3SecretAccessKey'] = Configure::read('TomatoCms.S3SecretAccessKey');
        $this->actsAs['TomatoCms.SThreeUpload']['s3Endpoint']        = Configure::read('TomatoCms.S3Endpoint');
        $this->actsAs['TomatoCms.SThreeUpload']['s3Location']        = Configure::read('TomatoCms.S3PrefixLocation') . '/web-config/';

        parent::__construct($id, $table, $ds);
    }

    public function onEditBeforeFindCallback(){
        $this->bindModel(array(
            'belongsTo' => array(
                'CreatedBy' => array(
                    'className' => 'User'
                ),
                'UpdatedBy' => array(
                    'className' => 'User'
                ),
                'ActivatedBy' => array(
                    'className' => 'User',
                    'foreignKey' => 'enabled_by_id'
                )
            )
        ));
    }

    public function getConfig(){

        $data = $this->find('all', array(
            'conditions' => array(
                'enabled' => 1
                )
            ));

        $return = array();
        foreach($data as $_data){

            $f = 'value';
            if($_data['WebConfig']['type']=='image'){
                $f = 'value_image';
            }

            $return[ $_data['WebConfig']['variable'] ] = $_data['WebConfig'][$f];
        }

        return $return;
    }

    public function afterSave($created, $options = array()) {

        $this->flushConfig();

    }

    public function beforeSave($options=array()){
        $f = "value_" . $this->data[$this->alias]['type'];
        if( $this->data[$this->alias]['type'] != 'image' && isset( $this->data[$this->alias][$f] ) ){

            $this->data[$this->alias]['value'] = $this->data[$this->alias][$f];

        }

        return true;
    }

    public function afterDelete() {

        $this->flushConfig();

    }

    private function flushConfig(){
        if( file_exists(CACHE . '__web_config_cache__newest_config') ){
            @unlink(CACHE . '__web_config_cache__newest_config');
        }
    }
}