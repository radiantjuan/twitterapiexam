<?php
App::uses('CakeText', 'Utility');
App::uses('TomatoCmsAppController', 'TomatoCms.Controller');

class UsersController extends TomatoCmsAppController {

    public $title_for_layout = "Users";

    public $allowToAll = array(
        'admin_logout',
        'admin_login',
        'admin_forgot_password',
        'admin_reset_password',
        'admin_check_credentials'
    );

    public $uses = array(
        'TomatoCms.User',
        'TomatoCms.Role'
        );

    public $components = array(
        'TomatoCms.TomatoCmsCrud' => array(
            'on_save_message'   => 'Successfully saved',
            'on_update_message' => 'Successfully updated',
            'on_delete_message' => 'Successfully deleted',

            'model_class_name' => 'User'
        )
    );

    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'User.created' => 'DESC'
        )
    );

    public function beforeFilter(){
        $this->Security->unlockedActions = array('admin_login', 'admin_logout', 'admin_check_credentials');
        $this->Auth->allow(array('admin_logout', 'admin_login', 'admin_forgot_password', 'admin_reset_password', 'admin_check_credentials'));

        if( $this->request->action == "admin_login" ){
            $this->title_for_layout = "Login";
        }else if( $this->request->action == "admin_forgot_password" ){
            $this->title_for_layout = "Forgot Password";
        }else if( $this->request->action == "admin_reset_password" ){
            $this->title_for_layout = "Reset Password";
        }

        if( $this->request->action == 'admin_add' || $this->request->action == 'admin_edit' ){
            $this->set('roles', $this->Role->find('list', array(
                "fields" => array(
                    "id", "role_name"
                )
            )));
        }
        parent::beforeFilter();
    }

    public function admin_index(){
    }

    public function admin_add(){}

    public function admin_edit($id){
        if( !$this->request->is(array('post','put')) ){
            $this->request->data['User']['password']='';
            $this->request->data['User']['confirm_password']='';

            $this->User->validator()->remove('password', 'notBlank');
            $this->User->validator()->remove('password', 'minLength');
            $this->User->validator()->remove('password', 'equalToConfirmPassword');
            $this->User->validator()->remove('confirm_password', 'notBlank');
        }
    }

     public function admin_deactivate_user($id){
        if(!$id){
            throw new BadRequestException;
        }

        $data = $this->User->read(null, $id);
        if(!$data){
            throw new BadRequestException;
        }
        $this->User->set('active', 0);
        $this->User->save($this->User->data, false, array(
            'active',
            'updated'
            ));    
        

        $this->Session->setFlash(
            'User successfully deactivated.',
            'TomatoCms.alert-box',
            array('class' => 'alert-success')
        );
        $this->redirect($this->referer());
    }

    public function admin_activate_user($id){
        if(!$id){
            throw new BadRequestException;
        }

        $data = $this->User->read(null, $id);
        if(!$data){
            throw new BadRequestException;
        }

        $this->User->set('active', 1);
        $this->User->save($this->User->data, false, array(
            'active',
            'updated'
            ));

        $this->Session->setFlash(
            'User successfully activated.',
            'TomatoCms.alert-box',
            array('class' => 'alert-success')
        );
        $this->redirect($this->referer());
    }

    public function admin_login(){
        if( $this->Auth->loggedIn()){
            return $this->redirect($this->Auth->redirectUrl());
        }

        if($this->request->is('post')){
            $login = $this->Auth->login();
            if($login) {

                $this->TomatoCmsAcl->store($this);

                $this->User->read(null, $this->Auth->User('id') );
                $this->User->set('last_login', date("Y-m-d H:i:s"));
                $this->User->save();

                return $this->redirect($this->Auth->redirectUrl());
            }else{
                $this->Session->setFlash(
                    'Invalid username or password.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-danger')
                );
            }
        }
    }

    public function admin_check_credentials(){

        $user = $this->Auth->identify($this->request, $this->response);
        $sucess = 0;
        if($user){
            $sucess = 1;
        }
        
        $this->layout = false;
        $this->autoRender = false;

        header("Content-Type: application/json");
        return json_encode(array(
            'success' => $sucess,
            'User' => $user
        ));
    }

    public function admin_logout() {
        $this->Cookie->delete('rememberMe');
        return $this->redirect($this->Auth->logout());
    }

    public function admin_forgot_password(){
        if( $this->request->is(array('post', 'put')) ){
            if(trim($this->request->data['User']['email'])==""){
                $this->Session->setFlash(
                    'Please Provide Your Email Adress that You used to Register with Us.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-danger')
                );
                $this->redirect($this->referer());
            }
            $email = $this->request->data['User']['email'];
            $this->User->recursive=-1;
            $userData = $this->User->find('first',array('conditions'=>array('User.email'=>$email)));
            if(!$userData){
                $this->Session->setFlash(
                    'Email does Not Exist.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-danger')
                );
                $this->redirect($this->referer());
            }else if($userData['User']['active']==0){
                $this->Session->setFlash(
                    'This Account is not Active.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-danger')
                );
                $this->redirect($this->referer());
            }else{
                // Process reset password.
                $key = Security::hash(CakeText::uuid(),'sha512',true);
                $hash=sha1($userData['User']['email'].rand(0,100));

                $url = Router::url( '/admin/reset-password', true ).'/'.$key.'#'.$hash;

                $ms=$url;
                $ms=wordwrap($ms,1000);

                $userData['User']['tokenhash']=$key;
                $this->User->id=$userData['User']['id'];
                if($this->User->saveField('tokenhash',$userData['User']['tokenhash'])){

                    if($this->emailResetPassword($email, $ms, $errorMsg)==false){
                        $this->Session->setFlash(
                            $errorMsg,
                            'TomatoCms.alert-box',
                            array('class' => 'alert-danger')
                        );
                        $this->redirect($this->referer());
                    }

                    $this->Session->setFlash(
                        'Check Your Email To Reset your password',
                        'TomatoCms.alert-box',
                        array('class' => 'alert-success')
                    );
                    $this->redirect($this->referer());

                }else{
                    $this->Session->setFlash(
                        'Error Generating Reset link.',
                        'TomatoCms.alert-box',
                        array('class' => 'alert-danger')
                    );
                    $this->redirect($this->referer());
                }

            }
        }
    }

    public function admin_profile(){
        $id = $this->Auth->User('id');

        if(!$id)
            throw new BadRequestException;

        if( $this->request->is(array('post','put')) ){

            if( (int)$this->request->data['User']['change_password'] == 0 ){
                $this->User->validator()->remove('password', 'notBlank');
                $this->User->validator()->remove('password', 'minLength');
                $this->User->validator()->remove('password', 'equalToConfirmPassword');
                $this->User->validator()->remove('confirm_password', 'notBlank');
            }

            $this->User->set($this->request->data);

            if ($this->User->validates()) {
                $data = $this->User->save($this->request->data, false, array(

                    'firstname',
                    'middlename',
                    'lastname',
                    'password'

                    ));

                $this->Session->setFlash(
                    'Profile successfully updated.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-success')
                );
                $this->redirect($this->referer());
            }else{
                $this->request->data['User']['password']='';
                $this->request->data['User']['confirm_password']='';
            }

        }else{
            $this->User->bindModel(array(

                'belongsTo' => array(
                    'Role'
                    )

                ));

            $this->request->data = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $id
                )
            ));

            if(!$this->data){
                throw new BadRequestException;
            }

            $this->request->data['User']['password']='';
            $this->request->data['User']['confirm_password']='';

            $this->User->validator()->remove('password', 'notBlank');
            $this->User->validator()->remove('password', 'minLength');
            $this->User->validator()->remove('password', 'equalToConfirmPassword');
            $this->User->validator()->remove('confirm_password', 'notBlank');
        }
        $this->set('roles', $this->Role->find('list', array(
            "fields" => array(
                "id", "role_name"
            )
        )));

        $this->set('title_for_layout', 'My Profile - ' . Configure::read('TomatoCms.Title') );
    }

    public function admin_reset_password($token=null){
        if(!$token) Throw new BadRequestException;

        $this->User->recursive=-1;
        $userData=$this->User->findBytokenhash($token);
        if(!$userData){
            $this->Session->setFlash(
                'Token corrupted, please try again the reset link work only for once.',
                'TomatoCms.alert-box',
                array('class' => 'alert-danger')
            );
            $this->redirect('/admin/forgot-password');
        }

        if( $this->request->is(array('post','put')) ){
            $this->User->id = $userData['User']['id'];
            $this->User->set($this->data);

            if($this->User->validates(array('fieldList'=>array('password','password_confirm'))) == FALSE){
                $errors = $this->User->invalidFields();
                foreach(array_keys($errors) as $f){
                    $errors[$f]=array_unique($errors[$f]);
                }
                $this->set('errors', $errors);
            }else{
                $this->User->set('tokenhash', '');
                if($this->User->save($this->User->data, false, array('password', 'password_confirm', 'updated'))){
                    $this->Session->setFlash(
                        'Password has been updated.',
                        'TomatoCms.alert-box',
                        array('class' => 'alert-success')
                    );
                    $this->redirect('/admin/tomato/users/login');
                }else{
                    $this->Session->setFlash(
                        'An error occured, please try again.',
                        'TomatoCms.alert-box',
                        array('class' => 'alert-danger')
                    );
                    $this->redirect($this->referer());
                }
            }
        }
    }

    private function emailResetPassword($to, $url, &$errorMsg){
        App::uses('CakeEmail', 'Network/Email');

        try {
            $Email = new CakeEmail();

            $Email->viewVars(array('ms'=>$url));

            $Email->config('default');
            $Email->template('TomatoCms.resetpw');
            $Email->emailFormat('html');
            $Email->from(array('noreply@abs-cbn.com' => Configure::read('FrontEnd.Title')));
            $Email->to($to);
            $Email->subject("Reset Your ".Router::url('/', true)." Password");
            $Email->send();
        }catch(Exception $e){
            $errorMsg = $e->getMessage();
            return false;
        }
        return true;
    }

}