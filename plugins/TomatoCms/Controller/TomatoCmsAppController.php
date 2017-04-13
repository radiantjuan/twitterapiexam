<?php

App::uses('Controller', 'Controller');

class TomatoCmsAppController extends Controller {

    // Cache View
    public $viewClass = 'TomatoCms.TomatoCms';

    public $helpers = array(
        'Form',
        'TomatoCms.FormEmpty',
        'TomatoCms.TomatoLayout',
        'TomatoCms.TomatoNav',
        'TomatoCms.TomatoCrumbs',
        'TomatoCms.BootstrapForm',
        'Cache' => array(
            'className' => 'TomatoCms.TomatoCache'
        )
    );

    public $components = array(
        'TomatoCms.TomatoCmsAcl',
        'Session',
        'Cookie',
        'DebugKit.Toolbar',
        'Security' => array(
            'csrfExpires' => '+1 hour',
            'csrfUseOnce' => false // For Debug Only
        ),
        'Paginator',
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'TomatoCms.User',
                    'fields' => array(
                        'username' => 'email'
                    ),
                    'scope' => array(
                        'User.active' => 1
                    ),
                    'passwordHasher' => 'Blowfish'
                )
            ),
            'loginAction' => array(
                'controller'     => 'users',
                'action'         => 'login',
                'plugin'         => 'tomato_cms',
                'prefix'         => 'admin',
                'admin'          => true
            ),
            'loginRedirect' => '/admin',
            'logoutRedirect' => array(
                'controller'     => 'users',
                'action'         => 'login',
                'plugin'         => 'tomato_cms',
                'prefix'         => 'admin',
                'admin'          => true
            )
        )
    );

    public $allowToAll = array(
        'admin_home'
    );

    public function beforeFilter(){
        parent::beforeFilter();

        if( isset($this->request->params['admin']) ){
            $this->Auth->authError        = "This error shows up with the user tries to access a part of the website that is protected.";
            $this->Auth->flash['element'] = "alert-box";
            $this->Auth->flash['params']  = array('class' => 'alert-danger');

            if( $this->Auth->loggedIn()){
                $this->layout = "TomatoCms.default";
            }else{
                $this->layout = "TomatoCms.login";
            }
        }else{
            $this->Auth->allow();
            $this->layout = "frontend_layout_default";
        }

        if( isset($this->title_for_layout) && $this->title_for_layout!=false ){
            if( isset($this->request->params['admin']) ) {
                $this->set('title_for_layout', $this->title_for_layout . ' - ' . Configure::read('TomatoCms.Title') . ' V ' .Configure::read('TomatoCms.Version') );
            }else{
                if(!Configure::read('FrontEnd.Title')){
                    $this->set('title_for_layout', Configure::read('FrontEnd.Title') );
                }else{
                    $this->set('title_for_layout', $this->title_for_layout);
                }
            }
        }
    }

    public function afterFilter(){
        if(  strcasecmp($this->name, 'CakeError') === 0 ){
             $this->handleError();
        }
    }

    public function admin_home(){
        $this->set('title_for_layout', 'Home - ' . Configure::read('TomatoCms.Title'));
        $this->render('Pages/home');
    }

    public function handleError(){
        App::uses('TomatoTagResolver', 'TomatoCms.Lib');
        $html = (string)$this->response;

        $tagRes = new TomatoTagResolver($html);
        $this->response->body($tagRes->getOut());

        if( isset($this->title_for_layout) && $this->title_for_layout!=false ){
            if( isset($this->request->params['admin']) ) {
                $this->set('title_for_layout', $this->title_for_layout . ' - ' . Configure::read('TomatoCms.Title'));
            }else{
                if(!Configure::read('FrontEnd.Title')){
                    $this->set('title_for_layout', Configure::read('FrontEnd.Title') );
                }else{
                    $this->set('title_for_layout', $this->title_for_layout);
                }
            }
        }
    }
}
