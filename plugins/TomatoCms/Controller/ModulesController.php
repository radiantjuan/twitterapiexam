<?PHP
App::uses('TomatoCmsAppController', 'TomatoCms.Controller');

class ModulesController extends TomatoCmsAppController{

    public $title_for_layout = "Modules";

    public function admin_index(){
        $conditions=array();
        $this->Paginator->settings = array(
            'Module' => array(
                'limit'      => 20,
                'conditions' => $conditions
            )
        );

        $Modules = $this->Paginator->paginate('Module');
        $this->set('Modules', $Modules);
    }

    public function admin_add(){
        if( $this->request->is(array('post','put')) ){

            $this->Module->set($this->request->data);

            if ($this->Module->validates()) {
                $page = $this->Module->save($this->request->data, false, array(
                    "title",
                    "slug",
                    "description",
                    "package_name",
                    "created_by",
                    "updated_by"
                ));

                $this->Session->setFlash(
                    'Module successfully created.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-success')
                );
                $this->redirect(array('action' => 'edit', $page['Module']['id']));
            }
        }
    }

    public function admin_edit($id){
        if( $this->request->is(array('post','put')) ){
            $this->Module->set($this->request->data);
            if ($this->Module->validates()) {
                $module = $this->Module->save($this->request->data, false, array(
                    "title",
                    "slug",
                    "description",
                    "package_name",
                    "created_by",
                    "updated_by"
                ));

                $this->Session->setFlash(
                    'Module successfully updated.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-success')
                );
                $this->redirect(array('action' => 'edit', $module['Module']['id']));
            }

        }else{

            $this->Module->bindModel(array(
                'belongsTo' => array(
                    'ActivatedBy' => array(
                        'className' => 'User'
                    )
                )
            ));

            $this->request->data = $this->Module->read(null, $id);
        }
    }

    public function admin_delete($id){
        $this->autoRender = false;
        $this->Module->delete($id);

        $this->Session->setFlash(
            'Module successfully deleted.',
            'TomatoCms.alert-box',
            array('class' => 'alert-success')
        );
        $this->redirect(array('action' => 'index'));
    }

    public function admin_activate($id){
        if( !$id ){
            throw new BadRequestException;
        }

        $data = $this->Module->read(null, $id);
        if(!$data){
            throw new BadRequestException;
        }

        try{
            // Try to load package.
            CakePlugin::load( $data['Module']['package_name'] , array(
                'bootstrap'     => false,
                'routes'        => false,
                'ignoreMissing' => true
            ));
        }catch(MissingPluginException $e){
            $this->Session->setFlash(
                'Module "'.$data['Module']['package_name'].'" could not be found.',
                'TomatoCms.alert-box',
                array('class' => 'alert-danger')
            );
            $this->redirect(array('action' => 'index'));
        }

        $this->Module->set('enabled', 1);
        $this->Module->save($this->Module->data, false, array(
            'enabled',
            'updated'
            ));

        $this->Session->setFlash(
            'Module successfully activated.',
            'TomatoCms.alert-box',
            array('class' => 'alert-success')
        );
        $this->redirect($this->referer());
    }

    public function admin_deactivate($id){
        if( !$id ){
            throw new BadRequestException;
        }

        $data = $this->Module->read(null, $id);
        if(!$data){
            throw new BadRequestException;
        }

        $this->Module->set('enabled', 0);
        $this->Module->save($this->Module->data, false, array(
            'enabled',
            'updated'
            ));

        $this->Session->setFlash(
            'Module successfully deactivated.',
            'TomatoCms.alert-box',
            array('class' => 'alert-success')
        );
        $this->redirect($this->referer());
    }
}