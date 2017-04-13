<?PHP
App::uses('TomatoCmsAppController', 'TomatoCms.Controller');

class WidgetsController extends TomatoCmsAppController{

    public $title_for_layout = "Widgets";

    public function admin_index(){
        $conditions=array();
        $this->Paginator->settings = array(
            'Widget' => array(
                'limit'      => 20,
                'conditions' => $conditions
            )
        );

        $Widgets = $this->Paginator->paginate('Widget');
        $this->set('Widgets', $Widgets);
    }

    public function admin_add(){
        if( $this->request->is(array('post','put')) ){

            $this->Widget->set($this->request->data);

            if ($this->Widget->validates()) {
                $data = $this->Widget->save($this->request->data, false, array(
                    "tag",
                    "title",
                    "description",
                    "package_name",
                    "created_by",
                    "updated_by"
                ));

                $this->Session->setFlash(
                    'Widget successfully created.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-success')
                );
                $this->redirect(array('action' => 'edit', $data['Widget']['id']));
            }
        }
    }

    public function admin_edit($id){
        if( $this->request->is(array('post','put')) ){
            $this->Widget->set($this->request->data);
            if ($this->Widget->validates()) {
                $data = $this->Widget->save($this->request->data, false, array(
                    "tag",
                    "title",
                    "description",
                    "package_name",
                    "created_by",
                    "updated_by"
                ));

                $this->Session->setFlash(
                    'Widget successfully updated.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-success')
                );
                $this->redirect(array('action' => 'edit', $data['Widget']['id']));
            }

        }else{

            $this->Widget->bindModel(array(
                'belongsTo' => array(
                    'ActivatedBy' => array(
                        'className' => 'User'
                    ),
                    'CreatedBy' => array(
                        'className'  => 'User',
                        'foreignKey' => 'created_by'
                    ),
                    'UpdatedBy' => array(
                        'className'  => 'User',
                        'foreignKey' => 'updated_by'
                    )
                )
            ));

            $this->request->data = $this->Widget->read(null, $id);
        }
    }

    public function admin_delete($id){
        $this->autoRender = false;
        $this->Widget->delete($id);

        $this->Session->setFlash(
            'Widget successfully deleted.',
            'TomatoCms.alert-box',
            array('class' => 'alert-success')
        );
        $this->redirect(array('action' => 'index'));
    }

    public function admin_activate($id){
        if( !$id ){
            throw new BadRequestException;
        }

        $data = $this->Widget->read(null, $id);
        if(!$data){
            throw new BadRequestException;
        }

        try{
            // Try to load package.
            CakePlugin::load( $data['Widget']['package_name'] , array(
                'bootstrap'     => false,
                'routes'        => false,
                'ignoreMissing' => true
            ));
        }catch(MissingPluginException $e){
            $this->Session->setFlash(
                'Widget '.$data['Widget']['package_name'].' could not be found.',
                'TomatoCms.alert-box',
                array('class' => 'alert-success')
            );
            $this->redirect(array('action' => 'index'));
        }

        $this->Widget->set('status', 1);
        $this->Widget->set('activated_by_id', CakeSession::read("Auth.User.id"));
        $this->Widget->set('activated_datetime', date("Y-m-d H:i:s"));
        $this->Widget->save();

        $this->Session->setFlash(
            'Widget successfully activated.',
            'TomatoCms.alert-box',
            array('class' => 'alert-success')
        );
        $this->redirect(array('action' => 'index'));
    }

    public function admin_deactivate($id){
        if( !$id ){
            throw new BadRequestException;
        }

        $data = $this->Widget->read(null, $id);
        if(!$data){
            throw new BadRequestException;
        }

        $this->Widget->set('status', 0);
        $this->Widget->save();

        $this->Session->setFlash(
            'Widget successfully deactivated.',
            'TomatoCms.alert-box',
            array('class' => 'alert-success')
        );
        $this->redirect(array('action' => 'index'));
    }
}