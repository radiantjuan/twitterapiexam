<?PHP
class TomatoCmsAclComponent extends Component{
    public static $key = "TomatoCmsAcl";
    public $components = array('Session', 'Auth');

    public function initialize(Controller $controller){
        if( isset($controller->request->params['admin']) && $controller->request->params['admin'] == true && $this->Auth->loggedIn()==true ) {
            $roleId = $this->Auth->user('role_id');
            if ($roleId != Configure::read('TomatoCms.AdminRoleId')) {
                $accessList = $this->Session->read(TomatoCmsAclComponent::$key);
                if (in_array($controller->request->params['action'], (array)$controller->allowToAll) == false) {
                    if (!isset($accessList["{$controller->plugin}.{$controller->name}.{$controller->request->params['action']}"]) || $accessList["{$controller->plugin}.{$controller->name}.{$controller->request->params['action']}"] != 1) {
                        $debugMsg = "";
                        if(Configure::read('debug')>0){
                            $debugMsg = "<br/><br/><br/>Key : {$controller->plugin}.{$controller->name}.{$controller->request->params['action']}";
                        }
                        $this->Session->setFlash(
                            'Sorry you dont have an access to that page.'.$debugMsg,
                            'TomatoCms.alert-box',
                            array('class' => 'alert-danger')
                        );
                        $controller->redirect($controller->referer());
                    }
                }
            }
        }
    }

    public function store(Controller $controller){
        require_once( ROOT . DS . 'plugins' . DS . 'TomatoCms' . DS . 'Config' . DS . 'tomato-acl.php' );

        // Include User Module tomato-acl.php
        $controller->loadModel('TomatoCms.Module');
        $modules = $controller->Module->getModules();
        $path = Configure::read('TomatoCms.UserModulePluginsPath');
        foreach($modules as $module){
            if( is_file( $path . DS . $module['Module']['package_name'] . DS . 'Config' . DS . 'tomato-acl.php' ) ){
                require_once( $path . DS . $module['Module']['package_name'] . DS . 'Config' . DS . 'tomato-acl.php' );
            }
        }

        // Include User Widget tomato-acl.php
        $controller->loadModel('TomatoCms.Widget');
        $widgets = $controller->Widget->getActiveWidgets();
        $path = Configure::read('TomatoCms.UserWidgetPluginsPath');
        foreach($widgets as $widget){
            if( is_file( $path . DS . $widget['Widget']['package_name'] . DS . 'Config' . DS . 'tomato-acl.php' ) ){
                require_once( $path . DS . $widget['Widget']['package_name'] . DS . 'Config' . DS . 'tomato-acl.php' );
            }
        }


        $controller->loadModel('TomatoCms.AccessList');
        $accessLists = $controller->AccessList->find('all', array(
            'conditions' => array(
                'AccessList.role_id' => $controller->Auth->user('role_id'),
                'AccessList.enabled' => 1
            )
        ));
        $permissions = array();
        foreach($accessLists as $accessList){
            $tmp = Configure::read("TomatoAcl.{$accessList['AccessList']['plugin']}.{$accessList['AccessList']['controller']}.{$accessList['AccessList']['action']}");
            if($tmp==false){
                continue;
            }
            foreach($tmp as $action){
                $permissions["{$accessList['AccessList']['plugin']}.{$accessList['AccessList']['controller']}.{$action}"] = 1;
            }
        }
        $this->Session->write(TomatoCmsAclComponent::$key, $permissions);
    }
}