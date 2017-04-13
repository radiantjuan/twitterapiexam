<?php
App::uses('DispatcherFilter', 'Routing');
App::uses('TomatoTagResolver', 'TomatoCms.Lib');

/**
 * This filter will check whether the response was previously cached in the file system
 * and served it back to the client if appropriate.
 *
 * @package Cake.Routing.Filter
 */
class TomatoCmsCacheDispatcher extends DispatcherFilter {

    /**
     * Default priority for all methods in this filter
     * This filter should run before the request gets parsed by router
     *
     * @var int
     */
    public $priority = 8;

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

        $path = $event->data['request']->here();
        if ($path === '/') {
            $path = 'home';
        }
        $prefix = Configure::read('Cache.viewPrefix');
        if ($prefix) {
            $path = $prefix . '_' . $path;
        }
        $path = strtolower(Inflector::slug($path));

        $filename = CACHE . 'views' . DS . $path . '.php';

        $cacheEngine=Configure::read('TomatoCms.CacheViewConfigKey');
        $cacheKey=$path.'.php';
        $data=Cache::read($cacheKey, $cacheEngine);
        debug($data);exit;

        if ($data) {
            $controller = null;
            App::import('View','TomatoCms.TomatoCms');
            $view = new TomatoCmsView($controller);
            $view->response = $event->data['response'];
            $result = $view->renderCacheFromString($path, $data, microtime(true));
            if ($result !== false) {
                $event->stopPropagation();

                $html = (string)$result;
                $tagRes = new TomatoTagResolver($html);

                $event->data['response']->body($tagRes->getOut());
                return $event->data['response'];
            }
        }
    }

}
