<?php
App::uses('AuthorsAppController', 'Authors.Controller');
App::uses('SearchableTrait', 'TomatoCms.Traits');

class AuthorsController extends AuthorsAppController {

	use SearchableTrait;

	private static $searchKey = "Authors";

    public $title_for_layout = "Authors";

    public $uses = array(
        'Authors.Author'
    );

    public $components = array(
        'TomatoCms.TomatoCmsCrud' => array(
			'on_delete_message' => 'Author successfully deleted',
            'on_save_message'   => 'Author successfully saved',
            'on_update_message' => 'Author successfully updated',

            'model_class_name' => 'Author'
        )
    );

    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'Author.created' => 'DESC'
        )
    );

    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    public function index()
	{
    }

	public function admin_index()
	{
        if( $this->Session->read(self::$searchKey) ){
            $this->request->data = $this->Session->read(self::$searchKey);
        }
    }

    public function admin_add()
	{

    }

    public function admin_edit($id)
	{

	}

    /*
     * Callbacks
     * */
    public function onIndexBeforeIndexCallback(){

        $conditions = [];
        if( $this->Session->read(self::$searchKey) ){
            $s = $this->Session->read(self::$searchKey);
            if( isset($s['Search']['name']) && $s['Search']['name'] ){
                $conditions[] = [
                    'Author.name LIKE ' => "%".$s['Search']['name']."%"
                ];
            }
            if( isset($s['Search']['email_address']) && $s['Search']['email_address'] ){
                $conditions[] = [
                    'Author.email_address LIKE ' => "%".$s['Search']['email_address']."%"
                ];
            }
        }

        $this->paginate['conditions'] = $conditions;

        return true;
    }

}
