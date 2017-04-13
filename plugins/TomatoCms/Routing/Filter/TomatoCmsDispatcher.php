<?PHP
App::uses('DispatcherFilter', 'Routing');
App::uses('TomatoTagResolver', 'TomatoCms.Lib');

class TomatoCmsDispatcher extends DispatcherFilter{

    public $priority = 9;

    public function afterDispatch(CakeEvent $event){
        $request = $event->data['request'];
        $response = $event->data['response'];

        if( isset($request->params['admin']) ){
            return true;
        }

        $html = (string)$response;

        $tagRes = new TomatoTagResolver($html);

        $event->data['response']->body( $tagRes->getOut() );
    }
}
?>