<?PHP
App::uses('DispatcherFilter', 'Routing');

class FrontEndDispatcher extends DispatcherFilter{

    public $priority = 8;

    public function beforeDispatch(CakeEvent $event){
        $request = $event->data['request'];

        return true;
    }
}
?>
