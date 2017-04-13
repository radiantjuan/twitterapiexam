<?PHP
App::uses('AppHelper', 'View/Helper');

/**
 * Layout Helper
 *
 * @category Helper
 * @package  Dmd.View.Helper
 * @version  1.0
 * @author   Rommel de Torres <detorresrc@gmail.com>
 */
class TomatoLayoutHelper extends AppHelper {

    public $helpers = array(
        'Html',
        'Form',
        'Session',
        'Js',
    );

    /**
     * Javascript variables
     *
     * Shows dmd.js file along with useful information like the applications's basePath, etc.
     *
     * Also merges Configure::read('Js') with the dmd js variable.
     * So you can set javascript info anywhere like Configure::write('Js.my_var', 'my value'),
     * and you can access it like 'dmd.my_var' in your javascript.
     *
     * @return string
     */
    public function js() {
        $dmd = array();

        $dmd['basePath'] = Router::url('/');

        $validKeys = array(
            'plugin' => null,
            'controller' => null,
            'action' => null,
            'named' => null,
        );
        $dmd['params'] = array_intersect_key(
            array_merge($validKeys, $this->request->params),
            $validKeys
        );
        if (is_array(Configure::read('Js'))) {
            $dmd = Hash::merge($dmd, Configure::read('Js'));
        }
        return $this->Html->scriptBlock('var TomatoCms = ' . $this->Js->object($dmd) . ';');
    }

    /**
     * isLoggedIn
     *
     * if User is logged in
     *
     * @return boolean
     */
    public function isLoggedIn() {
        if ($this->Session->check('Auth.User.id')) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Get Role ID
     *
     * @return integer
     */
    public function getRoleId() {
        if ($this->isLoggedIn()) {
            $roleId = $this->Session->read('Auth.User.role_id');
        } else {
            // Public
            $roleId = 3;
        }
        return $roleId;
    }

    /**
     * Get Logged In user
     *
     * @return integer
     */
    public function getLoginFullname(){
        return ucfirst($this->Session->read('Auth.User.firstname')). ' ' . strtoupper(substr($this->Session->read('Auth.User.middlename'),0,1)) . '. ' . ucfirst($this->Session->read('Auth.User.lastname'));
    }

    public function getUserId(){
        return $this->Session->read('Auth.User.id');
    }

    public function getBasePath(){
        return Router::url('/');
    }

}