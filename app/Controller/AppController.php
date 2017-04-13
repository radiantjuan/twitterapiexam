<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('TomatoCmsAppController', 'TomatoCms.Controller');
App::uses('Security', 'Utility');
App::uses('SocialMeta', 'TomatoCms.Lib');
App::uses('FBSession', 'TomatoCms.Lib');
App::uses('JSHelpers', 'TomatoCms.Lib');
App::uses('Sanitize', 'Utility');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package     app.Controller
 * @link        http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends TomatoCmsAppController {
    public $helpers = array(
        'Form',
        'TomatoCms.FormEmpty',
        'TomatoCms.TomatoLayout',
        'TomatoCms.TomatoNav',
        'TomatoCms.TomatoCrumbs',
        'TomatoCms.BootstrapForm',
        'Cache' => array(
            'className' => 'TomatoCms.TomatoCacheStatic'
        )
    );

    public function beforeFilter(){
        parent::beforeFilter();
    }

    public function error_page(){
        $this->set('title_for_layout', 'Error');
    }
}
