<?php

App::uses('WebConfigAppController', 'WebConfig.Controller');

class WebConfigController extends WebConfigAppController {

	public $title_for_layout = "WEB CONFIG";

	public $uses = array(
		'WebConfig.WebConfig'
		);

	public $components = array(
        'TomatoCms.TomatoCmsCrud' => array(
            'on_save_message'   => 'Config successfully saved',
            'on_update_message' => 'Config successfully updated',
            'on_delete_message' => 'Config successfully deleted',

            'model_class_name' => 'WebConfig'
        )
    );

    public $paginate = array(
        'limit' => 25,
        'order' => array(
            'WebConfig.variable' => 'ASC'
        )
    );

	public function index(){
	}

	public function admin_index(){
	}

	public function admin_add(){}

	public function admin_edit($id){

        if( !$this->request->is(array('post', 'put')) ){
            if($this->request->data['WebConfig']['type']!="image"){
                $this->request->data['WebConfig']['value_'.$this->request->data['WebConfig']['type']] = $this->request->data['WebConfig']['value'];    
            }
            $this->request->data['WebConfig']['value_image_old'] = $this->request->data['WebConfig']['value_image'];
        }

    }

}
