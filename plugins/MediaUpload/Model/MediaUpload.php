<?PHP
App::uses('MediaUploadAppModel', 'MediaUpload.Model');

class MediaUpload extends MediaUploadAppModel{

    public $actsAs = array(
        'TomatoCms.Trackable' => array(
            'priority' => 1,
            'fields' => array(
                'created_by' => 'created_by_id'
            )
        ),
        'TomatoCms.UploadValidator' => array(
            'priority' => 2,
            'fileField' => array('path')
        ),
        'TomatoCms.SThreeUpload'  => array(
            'priority'            => 3,
            'fileField'           => array('path')
        )
    );

    public function __construct($id = false, $table = null, $ds = null) {
        $this->actsAs['TomatoCms.SThreeUpload']['s3BucketName']      = Configure::read('TomatoCms.S3BucketName');
        $this->actsAs['TomatoCms.SThreeUpload']['s3AccessKeyId']     = Configure::read('TomatoCms.S3AccessKeyId');
        $this->actsAs['TomatoCms.SThreeUpload']['s3SecretAccessKey'] = Configure::read('TomatoCms.S3SecretAccessKey');
        $this->actsAs['TomatoCms.SThreeUpload']['s3Endpoint']        = Configure::read('TomatoCms.S3Endpoint');
        $this->actsAs['TomatoCms.SThreeUpload']['s3Location']        = Configure::read('TomatoCms.S3PrefixLocation') . '/media-upload/';

        parent::__construct($id, $table, $ds);
    }

    public function onIndexBeforePaginateCallback(){
        $this->bindModel(array(
            'belongsTo' => array(
                'CreatedBy' => array(
                    'className' => 'User'
                )
            )
        ));
    }

    public function beforeSave($options = array()){
        $pathinfo = pathinfo($this->data['MediaUpload']['path']);
        $this->data['MediaUpload']['filename'] = $pathinfo['basename'];
        $this->data['MediaUpload']['ext'] = $pathinfo['extension'];
    }
}