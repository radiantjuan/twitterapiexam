<?php

App::uses('MediaUploadAppController', 'MediaUpload.Controller');

class MediaUploadController extends MediaUploadAppController {

    public $title_for_layout = "Media Upload";

    public $components = array(
        'TomatoCms.TomatoCmsCrud' => array(
            'on_save_message'   => 'Successfully saved and uploaded',
            'on_delete_message' => 'Successfully deleted',

            'model_class_name' => 'MediaUpload'
        )
    );

    public $paginate = array(
        'MediaUpload' => array(
            'fields' => array('MediaUpload.*'),
            'limit'  => 10
        )
    );

	public function index(){
	}

	public function admin_index(){
	}

    public function admin_add(){}
    public function admin_edit(){
        $this->redirect(array('action'=>'index'));
    }

    public function admin_browse(){
        $this->layout = 'TomatoCms.nolayout';

        $this->Paginator->settings = $this->paginate;

        $this->set('MediaUploads', $this->Paginator->paginate('MediaUpload'));
    }
}
