<?php
App::uses('DispatcherFilter', 'Routing');
App::uses('TomatoTagResolver', 'TomatoCms.Lib');

/**
 * This filter will check whether the response was previously cached in the file system
 * and served it back to the client if appropriate.
 *
 * @package Cake.Routing.Filter
 */
class TomatoCmsCacheStaticDispatcher extends DispatcherFilter {

    /**
     * Default priority for all methods in this filter
     * This filter should run before the request gets parsed by router
     *
     * @var int
     */
    public $priority = 9;

    /**
     * Checks whether the response was cached and set the body accordingly.
     *
     * @param CakeEvent $event containing the request and response object
     * @return CakeResponse with cached content if found, null otherwise
     */
    public function beforeDispatch(CakeEvent $event) {
        if (Configure::read('Cache.check') !== true) {
            return;
        }

        if($event->data['request']->is('ajax')==true){
            return true;
        }

        $path = $event->data['request']->here();
        if ($path === '/') {
            $path = 'home';
        }
        $prefix = Configure::read('Cache.viewPrefix');
        if ($prefix) {
            $path = $prefix . '_' . $path;
        }
        $path = strtolower(Inflector::slug($path));

        $cacheEngine=Configure::read('TomatoCms.CacheViewConfigKey');
        $cacheKey=$path.'.php';
        $data=Cache::read($cacheKey, $cacheEngine);

        if ($data) {

            // TODO:
            // Add Callback Object for the Dynamic Content
            // : Sample code how to instantiate SessionComponent
            /*
            App::uses('SessionComponent', 'Controller/Component');
            $session = new SessionComponent(new ComponentCollection());
            pr($session->read());
            */
echo "<!--
Cache Version
-->";
            $event->stopPropagation();
            $event->data['response']->body($data);
            return $event->data['response'];
        }
    }

}
