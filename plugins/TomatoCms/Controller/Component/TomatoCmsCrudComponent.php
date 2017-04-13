<?PHP
App::uses('Component', 'Controller');

/**
 * Callbacks

// Controller Callbacks
onIndexBeforeIndexCallback
onAddBeforeAddCallback
onEditBeforeEditCallback
onDeleteBeforeDeleteCallback
onActivateBeforeActivateCallback
onActivateBeforeSaveCallback
onDeactivateBeforeDeactivateCallback

// Model Callback
onIndexBeforePaginateCallback
 *
 */

class TomatoCmsCrudComponent extends Component {

    public $_settings = array(
        'override_redirect_after_save' => false,

        'on_save_message'   => 'Successfully Saved',
        'on_update_message' => 'Successfully Updated',
        'on_delete_message' => 'Successfully Deleted',
        'on_activate_message' => 'Successfully Activated',
        'on_deactivate_message' => 'Successfully Deactivated',

        'on_save_url_extra_params'       => array(),
        'on_update_url_extra_params'     => array(),
        'on_delete_url_extra_params'     => array(),
        'on_activate_url_extra_params'   => array(),
        'on_deactivate_url_extra_params' => array(),

        'id_params_pass_index' => 0,

        'action_index'      => 'admin_index',
        'action_add'        => 'admin_add',
        'action_edit'       => 'admin_edit',
        'action_delete'     => 'admin_delete',
        'action_activate'   => 'admin_activate',
        'action_deactivate' => 'admin_deactivate',
        'action_movedown'     => 'admin_movedown',
        'action_moveup'     => 'admin_moveup',

        'model_class_name' => false,
        'atomic' => false
    );

    protected $request;
    protected $response;
    protected $controller;

    public $isValidationError = false;
    public $validationError = null;

    public function startup(Controller $controller) {
        $this->settings = array_merge($this->_settings, $this->settings);

        if(!isset($this->settings['model_class_name']) || $this->settings['model_class_name']==false){
            $this->settings['model_class_name'] = Inflector::singularize($controller->name);
        }

        $this->request = $controller->request;
        $this->response = $controller->response;
        $this->controller = $controller;

        if( $this->request->action == $this->settings['action_add'] ){
            $this->add();
        }else if( $this->request->action == $this->settings['action_edit'] ){
            $this->edit();
        }else if( $this->request->action == $this->settings['action_index'] ){
            $this->index();
        }else if( $this->request->action == $this->settings['action_delete'] ){
            $this->delete();
        }else if( $this->request->action == $this->settings['action_activate'] ){
            $this->activate();
        }else if( $this->request->action == $this->settings['action_deactivate'] ){
            $this->deactivate();
        }else if( $this->request->action == $this->settings['action_moveup'] ){
            $this->moveup();
        }else if( $this->request->action == $this->settings['action_movedown'] ){
            $this->movedown();
        }
    }

    private function add(){
        $model = $this->settings['model_class_name'];

        if( method_exists($this->controller, 'onAddBeforeAddCallback') ){
            if( $this->controller->onAddBeforeAddCallback() == false ){
                return false;
            }
        }

        if( $this->request->is(array('post', 'put')) ){

            $this->controller->{$model}->create();
            $this->controller->{$model}->set($this->request->data);

            if( $this->controller->{$model}->validates() == false ){

                $this->isValidationError = true;
                $this->validationError = $this->controller->{$model}->validationErrors;

                $this->controller->Session->setFlash(
                    'Please check error.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-danger')
                );
            }else{
                try{

                    if($this->settings['atomic']==true){
                        $this->controller->{$model}->getDataSource()->begin();
                    }

                    $data = $this->controller->{$model}->save(null, false);

                    if(!$data && $this->controller->{$model}->s3HasError==true){
                        throw new Exception($this->controller->{$model}->s3ErrorMessage);
                    }

                    $this->controller->Session->setFlash(
                        $this->settings['on_save_message'],
                        'TomatoCms.alert-box',
                        array('class' => 'alert-success')
                    );

                    if( $this->settings['override_redirect_after_save'] ){
                        $url = $this->settings['override_redirect_after_save'];
                    }else{
                        $url = array_merge(
                            array('action'=>'edit', $data[$this->controller->{$model}->alias]['id']),
                            $this->settings['on_save_url_extra_params']
                        );    
                    }

                    if($this->settings['atomic']==true){
                        $this->controller->{$model}->getDataSource()->commit();
                    }

                    $this->controller->redirect( $url );
                }catch(Exception $e){
                    if($this->settings['atomic']==true){
                        $this->controller->{$model}->getDataSource()->rollback();
                    }

                    $this->controller->Session->setFlash(
                        $e->getMessage(),
                        'TomatoCms.alert-box',
                        array('class' => 'alert-danger')
                    );
                }
            }
        }
    }

    private function edit(){
        $model = $this->settings['model_class_name'];

        if( method_exists($this->controller, 'onEditBeforeEditCallback') ){
            if( $this->controller->onEditBeforeEditCallback() == false ){
                return false;
            }
        }

        if( $this->request->is(array('post', 'put')) ){
            $model = $this->settings['model_class_name'];
            $this->controller->{$model}->create();
            $this->controller->{$model}->set($this->request->data);

            if( $this->controller->{$model}->validates() == false ){

                $this->isValidationError = true;
                $this->validationError = $this->controller->{$model}->validationErrors;

                $this->controller->Session->setFlash(
                    'Please check error.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-danger')
                );
            }else{
                try{

                    if($this->settings['atomic']==true){
                        $this->controller->{$model}->getDataSource()->begin();
                    }

                    $data = $this->controller->{$model}->save(null, false);

                    if(!$data && $this->controller->{$model}->s3HasError==true){
                        throw new Exception($this->controller->{$model}->s3ErrorMessage);
                    }

                    $url = array_merge(
                        array('action'=>'edit', $data[$this->controller->{$model}->alias]['id']),
                        $this->settings['on_update_url_extra_params']
                    );

                    if($this->settings['atomic']==true){
                        $this->controller->{$model}->getDataSource()->commit();
                    }

                    $this->controller->Session->setFlash(
                        $this->settings['on_update_message'],
                        'TomatoCms.alert-box',
                        array('class' => 'alert-success')
                    );

                    $this->controller->redirect( $url );
                }catch(Exception $e){
                    if($this->settings['atomic']==true){
                        $this->controller->{$model}->getDataSource()->rollback();
                    }

                    $this->controller->Session->setFlash(
                        $e->getMessage(),
                        'TomatoCms.alert-box',
                        array('class' => 'alert-danger')
                    );
                }
            }
        }else{
            if( !$this->request->pass[$this->settings['id_params_pass_index']] ){
                throw new BadRequestException;
            }

            if( method_exists($this->controller->{$model}, 'onEditBeforeFindCallback') ){
                $this->controller->{$model}->onEditBeforeFindCallback();
            }

            $this->request->data = $this->controller->{$model}->read(null, $this->request->pass[$this->settings['id_params_pass_index']]);
            if( !$this->request->data ){
                throw new BadRequestException;
            }

            $this->request->data[$this->controller->{$model}->alias]['PrimaryKey']=$this->controller->{$model}->primaryKey;
        }
    }

    private function index(){
        $model = $this->settings['model_class_name'];

        if( method_exists($this->controller, 'onIndexBeforeIndexCallback') ){
            if( $this->controller->onIndexBeforeIndexCallback() == false ){
                return false;
            }
        }

        if( method_exists($this->controller->{$model}, 'onIndexBeforePaginateCallback') ){
            $this->controller->{$model}->onIndexBeforePaginateCallback();
        }
        $this->controller->Paginator->settings = $this->controller->paginate;

        $this->controller->set(Inflector::pluralize($model), $this->controller->Paginator->paginate($model));
    }

    private function delete(){
        $model = $this->settings['model_class_name'];

        if( method_exists($this->controller, 'onDeleteBeforeDeleteCallback') ){
            if( $this->controller->onDeleteBeforeDeleteCallback() == false ){
                return false;
            }
        }

        if( !$this->request->pass[$this->settings['id_params_pass_index']] ){
            throw new BadRequestException;
        }

        try{
            $this->controller->{$model}->delete($this->request->pass[$this->settings['id_params_pass_index']]);

            $this->controller->Session->setFlash(
                $this->settings['on_delete_message'],
                'TomatoCms.alert-box',
                array('class' => 'alert-success')
            );
        }catch(PDOException $e){
            $errorMsg = $e->getMessage();
            if( $e->getCode() == 23000 ){
                $errorMsg = 'Cannot delete a parent row: a foreign key constraint fails';
            }
            $this->controller->Session->setFlash(
                $errorMsg,
                'TomatoCms.alert-box',
                array('class' => 'alert-danger')
            );
        }catch(Exception $e){
            $this->controller->Session->setFlash(
                $e->getMessage(),
                'TomatoCms.alert-box',
                array('class' => 'alert-danger')
            );
        }
        $this->controller->redirect( $this->controller->referer() );
    }

    private function activate(){
        $model = $this->settings['model_class_name'];

        if( method_exists($this->controller, 'onActivateBeforeActivateCallback') ){
            if( $this->controller->onActivateBeforeActivateCallback() == false ){
                return false;
            }
        }

        if( !$this->request->pass[$this->settings['id_params_pass_index']] ){
            throw new BadRequestException;
        }

        try{
            $this->controller->{$model}->read(null, $this->request->pass[$this->settings['id_params_pass_index']]);
            if(!$this->controller->{$model}->data){
                throw new BadRequestException;
            }
            $this->controller->{$model}->set('enabled', 1);

            $fields=array(
                'enabled',
                'updated',
                'updated_by_id'
            );
            if($this->controller->{$model}->hasField('enabled_datetime')){
                $this->controller->{$model}->set('enabled_datetime', date("Y-m-d H:i:s"));
                $fields[]='enabled_datetime';
            }
            if($this->controller->{$model}->hasField('enabled_by_id')){
                $this->controller->{$model}->set('enabled_by_id', CakeSession::read('Auth.User.id'));
                $fields[]='enabled_by_id';
            }

            if( method_exists($this->controller, 'onActivateBeforeSaveCallback') ){
                if( $this->controller->onActivateBeforeSaveCallback() == false ){
                    return false;
                }
            }

            $this->controller->{$model}->save(null, false, $fields);

            $this->controller->Session->setFlash(
                $this->settings['on_activate_message'],
                'TomatoCms.alert-box',
                array('class' => 'alert-success')
            );

            $this->controller->redirect( $this->controller->referer() );
        }catch(Exception $e){
            $this->controller->Session->setFlash(
                $e->getMessage(),
                'TomatoCms.alert-box',
                array('class' => 'alert-danger')
            );
        }
    }

    private function deactivate(){
        $model = $this->settings['model_class_name'];

        if( method_exists($this->controller, 'onDeactivateBeforeDeactivateCallback') ){
            if( $this->controller->onDeactivateBeforeDeactivateCallback() == false ){
                return false;
            }
        }

        if( !$this->request->pass[$this->settings['id_params_pass_index']] ){
            throw new BadRequestException;
        }

        try{
            $this->controller->{$model}->read(null, $this->request->pass[$this->settings['id_params_pass_index']]);
            if(!$this->controller->{$model}->data){
                throw new BadRequestException;
            }
            $fields=array(
                'enabled',
                'updated',
                'updated_by_id'
            );
            $this->controller->{$model}->set('enabled', 0);
            $this->controller->{$model}->save(null, false, $fields);

            $this->controller->Session->setFlash(
                $this->settings['on_deactivate_message'],
                'TomatoCms.alert-box',
                array('class' => 'alert-success')
            );

            $this->controller->redirect( $this->controller->referer() );
        }catch(Exception $e){
            $this->controller->Session->setFlash(
                $e->getMessage(),
                'TomatoCms.alert-box',
                array('class' => 'alert-danger')
            );
        }
    }

    public function moveup(){
        $model = $this->settings['model_class_name'];

        if( !$this->request->pass[$this->settings['id_params_pass_index']] ){
            throw new BadRequestException;
        }

        try{
            $this->controller->{$model}->moveUp($this->request->pass[$this->settings['id_params_pass_index']]);

            $this->controller->redirect( $this->controller->referer() );
        }catch(Exception $e){
            $this->controller->Session->setFlash(
                $e->getMessage(),
                'TomatoCms.alert-box',
                array('class' => 'alert-danger')
            );
        }
    }

    public function movedown(){
        $model = $this->settings['model_class_name'];

        if( !$this->request->pass[$this->settings['id_params_pass_index']] ){
            throw new BadRequestException;
        }

        try{
            $this->controller->{$model}->moveDown($this->request->pass[$this->settings['id_params_pass_index']]);

            $this->controller->redirect( $this->controller->referer() );
        }catch(Exception $e){
            $this->controller->Session->setFlash(
                $e->getMessage(),
                'TomatoCms.alert-box',
                array('class' => 'alert-danger')
            );
        }
    }
}

?>