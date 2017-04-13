<?PHP
App::uses('TomatoCmsAppController', 'TomatoCms.Controller');

class TestMailController extends TomatoCmsAppController{
    public $components = array('Email');

    public function mail_test(){
        $this->Email->delivery = 'smtp';
        $this->Email->from = 'detorresrc@gmail.com';
        $this->Email->to = 'detorresrc@gmail.com';
        $this->set('name', 'Rommel de Torres');
        $this->Email->subject = 'This is a subject';
        $this->Email->template = 'default';
        $this->Email->sendAs = 'both';
        pr( $this->Email->send() );

        $this->autoRender = false;
    }
}