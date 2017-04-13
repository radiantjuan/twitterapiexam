<?php
App::uses('TomatoCmsAppController', 'TomatoCms.Controller');

class RolesController extends TomatoCmsAppController{
    public $title_for_layout = "Roles";

    public $uses = array('TomatoCms.Role');

    public function beforeFilter(){
        parent::beforeFilter();

        $this->Security->unlockedActions = array('admin_permissions');
    }

    public function admin_index(){
        $conditions=array();
        $this->Paginator->settings = array(
            'Role' => array(
                'limit'      => 20,
                'conditions' => $conditions
            )
        );

        $Roles = $this->Paginator->paginate('Role');
        $this->set('Roles', $Roles);
    }

    public function admin_add(){
        if( $this->request->is(array('post','put')) ){
            $this->Role->set($this->request->data);

            if ($this->Role->validates()) {
                $data = $this->Role->save($this->request->data, false, array(
                    "role_name",
                    "created_by",
                    "updated_by"
                ));

                $this->Session->setFlash(
                    'Role successfully created.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-success')
                );
                $this->redirect(array('action' => 'edit', $data['Role']['id']));
            }
        }
    }

    public function admin_edit($id){
        if(!$id){
            throw new BadRequestException;
        }

        if( $this->request->is(array('post','put')) ){
            $this->Role->set($this->request->data);

            if ($this->Role->validates()) {
                $data = $this->Role->save($this->request->data, false, array(
                    "role_name",
                    "created_by",
                    "updated_by"
                ));

                $this->Session->setFlash(
                    'Role successfully updated.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-success')
                );
                $this->redirect(array('action' => 'edit', $data['Role']['id']));
            }
        }else{
            $this->request->data = $this->Role->read(null, $id);
            if(!$this->request->data){
                throw new BadRequestException;
            }
        }
    }

    public function admin_delete($id){
        if(!$id){
            throw new BadRequestException;
        }
        $this->Role->delete($id);

        $this->Session->setFlash(
            'Role successfully deleted.',
            'TomatoCms.alert-box',
            array('class' => 'alert-success')
        );
        $this->redirect($this->referer());
    }

    public function admin_permissions($id){
        $this->loadModel('TomatoCms.AccessList');

        require_once( dirname(__FILE__) . DS . '..' . DS . 'Config' . DS . 'tomato-acl.php' );

        if($this->request->is(array('post','put'))){

            $data = array();
            foreach($this->request->data as $plugin => $data2){
                foreach($data2 as $controller => $data3){
                    foreach($data3 as $action => $enabled){
                        $data[] = array(
                            "role_id"    => $id,
                            "plugin"     => $plugin,
                            "controller" => $controller,
                            "action"     => $action,
                            "enabled"    => $enabled
                        ) ;
                    }
                }
            }

            try {
                $this->AccessList->begin();
                $this->AccessList->deleteAll(
                    array(
                        'AccessList.role_id' => $id
                    ),
                    false
                );
                $this->AccessList->saveMany($data, array('atomic' => false));
                $this->AccessList->commit();

                $this->Session->setFlash(
                    'Role Permission successfully updated.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-success')
                );
                $this->redirect(Router::url(array('action'=>'admin_permissions', $id)));
            }catch(Exception $e){
                $this->Session->setFlash(
                    $e->getMessage(),
                    'TomatoCms.alert-box',
                    array('class' => 'alert-danger')
                );
            }
        }else{
            $data = $this->AccessList->find('all',
                array(
                    'conditions' => array(
                        'AccessList.role_id' => $id
                    )
                )
            );
            $this->request->data = array();
            foreach($data as $_data){
                $this->request->data[$_data['AccessList']['plugin']][$_data['AccessList']['controller']][$_data['AccessList']['action']]=$_data['AccessList']['enabled'];
            }
        }

        $tomatoCmsControllers = Configure::read('TomatoAcl.TomatoCms');
        $this->set('tomatoCmsControllers', $tomatoCmsControllers);

        // Get User Module Packages
        $userModulesController = array();
        $this->loadModel('TomatoCms.Module');
        $modules = $this->Module->getModules();
        $path = Configure::read('TomatoCms.UserModulePluginsPath');
        foreach($modules as $module){
            if( is_file( $path . DS . $module['Module']['package_name'] . DS . 'Config' . DS . 'tomato-acl.php' ) ){
                require_once( $path . DS . $module['Module']['package_name'] . DS . 'Config' . DS . 'tomato-acl.php' );

                if(!Configure::read('TomatoAcl.'.$module['Module']['package_name'])) continue;

                $var = array(
                    $module['Module']['package_name'] => Configure::read('TomatoAcl.'.$module['Module']['package_name'])
                );

                $userModulesController = array_merge($userModulesController, $var );
            }
        }
        $this->set('userModulesControllers', $userModulesController);

        // Get User Widgets Packages
        $userWidgetsController = array();
        $this->loadModel('TomatoCms.Widget');
        $widgets = $this->Widget->getActiveWidgets();
        $path = Configure::read('TomatoCms.UserWidgetPluginsPath');
        foreach($widgets as $widget){
            if( is_file( $path . DS . $widget['Widget']['package_name'] . DS . 'Config' . DS . 'tomato-acl.php' ) ){
                require_once( $path . DS . $widget['Widget']['package_name'] . DS . 'Config' . DS . 'tomato-acl.php' );

                if(!Configure::read('TomatoAcl.'.$widget['Widget']['package_name'])) continue;

                $var = array(
                    $widget['Widget']['package_name'] => Configure::read('TomatoAcl.'.$widget['Widget']['package_name'])
                );

                $userWidgetsController = array_merge($userWidgetsController, $var );
            }
        }
        $this->set('userWidgetsControllers', $userWidgetsController);
    }
}