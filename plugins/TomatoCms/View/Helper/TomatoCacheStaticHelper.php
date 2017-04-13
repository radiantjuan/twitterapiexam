<?php
App::uses('CacheHelper', 'View/Helper');
App::uses('TomatoTagResolver', 'TomatoCms.Lib');

class TomatoCacheStaticHelper extends CacheHelper{

    /**
     * Write a cached version of the file
     *
     * @param string $content view content to write to a cache file.
     * @param string $timestamp Duration to set for cache file.
     * @param bool $useCallbacks Whether to include statements in cached file which
     *   run callbacks.
     * @return bool success of caching view.
     */
    protected function _writeFile($content, $timestamp, $useCallbacks = false) {

        $tagRes = new TomatoTagResolver($content);
        $content = $tagRes->getOut();

        $path = $this->request->here();
        if ($path === '/') {
            $path = 'home';
        }
        $prefix = Configure::read('Cache.viewPrefix');
        if ($prefix) {
            $path = $prefix . '_' . $path;
        }
        $cache = strtolower(Inflector::slug($path));

        if (empty($cache)) {
            return;
        }
        $cache = $cache . '.php';


        $cacheEngine = Configure::read('TomatoCms.CacheViewConfigKey');
        $cacheKey    = $cache;
        if(!Cache::write($cacheKey, $content, $cacheEngine)) {
            return NULL;
        }

        return true;
    }

}
