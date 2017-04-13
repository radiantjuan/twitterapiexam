<?PHP
App::uses('S3', 'TomatoCms.Lib');

class SThreeUploadBehavior extends ModelBehavior {
    /**
     * Settings array
     *
     * @var array
     */
    public $settings = array();


    /**
     * Default settings array
     *
     * @var array
     */
    protected $_defaults = array(
        'fileField' => 'file',
        'allowNoFileErrorOnUpdate' => true,

        's3BucketName'       => '',
        's3AccessKeyId'      => '',
        's3SecretAccessKey'  => '',
        's3Endpoint'         => '',
        's3Location'         => '',
        's3Acl'              => S3::ACL_PUBLIC_READ,

        'deleteAfterSave'    => true
    );

    /**
     * Behavior setup
     *
     * Merge settings with default config, then it is checking if the target directory
     * exists and if it is writeable. It will throw an error if one of both fails.
     *
     * @param \AppModel|\Model $Model
     * @param array $settings
     * @throws InvalidArgumentException
     * @return void
     */
    public function setup(Model $Model, $settings = array()) {
        if (!is_array($settings)) {
            throw new InvalidArgumentException(__d('file_storage', 'Settings must be passed as array!'));
        }

        if(!is_array($this->_defaults['fileField'])){
            $f=$this->_defaults['fileField'];
            $this->_defaults['fileField'] = array(
                $f
            );unset($f);
        }

        $this->settings[$Model->alias] = array_merge($this->_defaults, $settings);
    }

    public function beforeSave(Model $Model, $options = array()){
        extract($this->settings[$Model->alias]);

        $filename = "";
        if(is_array($fileField)){
            $tmpFileFiled = $fileField;
            foreach($tmpFileFiled as $fileField){
                if(!isset($Model->data[$Model->alias][ $fileField ])) continue;
                if( $this->doUpload($Model, $fileField, $Model->data[$Model->alias][ $fileField ], $filename) == false ){
                    return false;
                }
            }
        }

        return true;
    }

    public function afterSave(Model $Model, $created, $options = array()) {
        extract($this->settings[$Model->alias]);

        if(isset($this->settings[$Model->alias]['deleteAfterUpdate']) && $this->settings[$Model->alias]['deleteAfterUpdate'] == false ){
            return true;
        }

        if($deleteAfterSave!=true){
            return true;
        }

        S3::$useExceptions = true;
        $s3 = new S3($s3AccessKeyId, $s3SecretAccessKey);

        $tmpFileFiled = $fileField;
        foreach($tmpFileFiled as $fileField){

            if( isset($Model->data[$Model->alias][ $fileField . '_old' ]) && isset($Model->data[$Model->alias][ $fileField ]) ){
                $url = parse_url( $Model->data[$Model->alias][ $fileField . '_old' ] );

                CakeLog::debug("afterSave() :: Deleting object : Field => " . $fileField . ' Url : ' . substr($url['path'], 1));

                try {
                    $s3->deleteObject($s3BucketName, substr($url['path'], 1));
                }catch(Exception $e){
                    CakeLog::debug($e->getMessage());
                }
            }
        }
    }

    public function beforeDelete(Model $Model, $cascade = true) {
        if(!$Model->data && sizeof($Model->data)==0){
            $Model->read(null, $Model->id);
        }

        $Model->oldData = $Model->data;

        return true;
    }

    public function afterDelete(Model $Model) {
        $Model->data = $Model->oldData;

        extract($this->settings[$Model->alias]);

        if($deleteAfterSave!=true){
            return true;
        }

        S3::$useExceptions = true;
        $s3 = new S3($s3AccessKeyId, $s3SecretAccessKey);

        $tmpFileFiled = $fileField;
        foreach($tmpFileFiled as $fileField){
            if($Model->data[$Model->alias][ $fileField ]==""){
                continue;
            }
            $url = parse_url( $Model->data[$Model->alias][ $fileField ] );
            CakeLog::debug("afterDelete() :: Deleting object : " . substr($url['path'], 1));
            $s3->deleteObject($s3BucketName, substr($url['path'], 1));
        }

        return true;
    }

    private function doUpload(Model $Model, $fileField, $file, &$filename){
        if(isset($Model->data[ $Model->alias ][ $Model->primaryKey ]) &&  !is_array($file)) return true;

        if( isset($Model->data[ $Model->alias ][ $Model->primaryKey ]) && $this->settings[$Model->alias]['allowNoFileErrorOnUpdate'] == true && $file['error'] == UPLOAD_ERR_NO_FILE ){
            unset($Model->data[$Model->alias][ $fileField ]);
            return true;
        }
        if( $file['error'] == UPLOAD_ERR_NO_FILE ){
            unset($Model->data[$Model->alias][ $fileField ]);
            return true;
        }

        S3::$useExceptions = true;
        $s3 = new S3($this->settings[$Model->alias]['s3AccessKeyId'], $this->settings[$Model->alias]['s3SecretAccessKey']);
        $ret = false;

        $Model->s3ErrorMessage = '';
        $Model->s3HasError = false;

        $pathinfo = ( pathinfo($file['name']) );
        $filenameFormated = strtolower( Inflector::slug($pathinfo['filename'], '-') ) .'.'. $pathinfo['extension'];

        $filename = $this->settings[$Model->alias]['s3Location'] . time().'_'.$filenameFormated;
        try {
            $ret = $s3->putObjectFile(
                $file['tmp_name'],
                $this->settings[$Model->alias]['s3BucketName'],
                $filename,
                $this->settings[$Model->alias]['s3Acl'],
                array(),
                $file['type']
            );
        }catch(Exception $e){
            $Model->s3ErrorMessage = $e->getMessage();
            $Model->s3HasError = true;
        }

        $Model->data[$Model->alias][ $fileField ] = "http://".$this->settings[$Model->alias]['s3BucketName'].'.s3.amazonaws.com/'.$filename;

        return $ret;
    }
}
