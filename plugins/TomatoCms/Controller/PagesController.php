<?PHP
App::uses('AppController', 'Controller');
App::uses('TomatoFrontendLayout', 'TomatoCms.Lib');

class PagesController extends AppController{

    public $uses = array('TomatoCms.Page');

    public $title_for_layout = "Pages";

    public $components = array(
        'TomatoCms.TomatoCmsCrud' => array(
            'on_save_message'   => 'Page successfully saved',
            'on_update_message' => 'Page successfully updated',
            'on_delete_message' => 'Page successfully deleted',

            'model_class_name' => 'Page'
        )
    );

    public $paginate = array(
        'Page' => array(
            'fields' => array('Page.*'),
            'limit'  => 20,
            'order'  => array(
                'Page.updated' => 'asc'
            )
        )
    );

    public function admin_index(){}
    public function admin_add(){
        $this->set('layouts', TomatoFrontendLayout::getLayouts() );
    }
    public function admin_edit(){
        $this->set('layouts', TomatoFrontendLayout::getLayouts() );
    }

    public function admin_activate_page($id){
        if( !$id ){
            throw new BadRequestException;
        }

        $data = $this->Page->read(null, $id);
        if(!$data){
            throw new BadRequestException;
        }

        $this->Page->save(
            array(
                'Page' => array(
                    'id' => $id,
                    'is_published' => 1,
                    'published_by_id' => CakeSession::read("Auth.User.id"),
                    'published_datetime' => date("Y-m-d H:i:s")
                )
            ),
            false
        );

        $this->Session->setFlash(
            'Page successfully activated.',
            'TomatoCms.alert-box',
            array('class' => 'alert-success')
        );
        $this->redirect($this->referer());
    }

    public function admin_deactivate_page($id){
        if( !$id ){
            throw new BadRequestException;
        }

        $data = $this->Page->read(null, $id);
        if(!$data){
            throw new BadRequestException;
        }

        $this->Page->save(
            array(
                'Page' => array(
                    'id' => $id,
                    'is_published' => 0
                )
            ),
            false
        );

        $this->Session->setFlash(
            'Page successfully deactivated.',
            'TomatoCms.alert-box',
            array('class' => 'alert-success')
        );
        $this->redirect($this->referer());
    }

    public function view_page(){
        if( !isset( $this->request->params['page_id'] ) ){
            throw new BadRequestException;
        }

        $pageData = $this->Page->find('first', array(
            'conditions' => array(
                'id' => $this->request->params['page_id']
            )
        ));

        if( !$pageData ){
            throw new BadRequestException;
        }

        if($pageData['Page']['is_published']==0 && $this->Auth->loggedIn()==FALSE ){
            throw new NotFoundException;
        }

        $this->layout = $pageData['Page']['layout'];

        $this->set('pageData', $pageData['Page']);
        $this->set('title_for_layout', $pageData['Page']['title']);
    }
}