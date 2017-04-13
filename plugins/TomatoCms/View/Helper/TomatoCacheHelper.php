<?php
App::uses('CacheHelper', 'View/Helper');
App::uses('TomatoTagResolver', 'TomatoCms.Lib');

class TomatoCacheHelper extends CacheHelper{

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

        $now = time();

        if (is_numeric($timestamp)) {
            $cacheTime = $now + $timestamp;
        } else {
            $cacheTime = strtotime($timestamp, $now);
        }
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
        $file = '<!--cachetime:' . $cacheTime . '--><?php';

        if (empty($this->_View->plugin)) {
            $file .= "
			App::uses('{$this->_View->name}Controller', 'Controller');
			";
        } else {
            $file .= "
			App::uses('{$this->_View->plugin}AppController', '{$this->_View->plugin}.Controller');
			App::uses('{$this->_View->name}Controller', '{$this->_View->plugin}.Controller');
			";
        }

        $file .= '
				$request = unserialize(base64_decode(\'' . base64_encode(serialize($this->request)) . '\'));
				$response->type(\'' . $this->_View->response->type() . '\');
				$controller = new ' . $this->_View->name . 'Controller($request, $response);
				$controller->plugin = $this->plugin = \'' . $this->_View->plugin . '\';
				$controller->helpers = $this->helpers = unserialize(base64_decode(\'' . base64_encode(serialize($this->_View->helpers)) . '\'));
				$controller->layout = $this->layout = \'' . $this->_View->layout . '\';
				$controller->theme = $this->theme = \'' . $this->_View->theme . '\';
				$controller->viewVars = unserialize(base64_decode(\'' . base64_encode(serialize($this->_View->viewVars)) . '\'));
				Router::setRequestInfo($controller->request);
				$this->request = $request;';

        if ($useCallbacks) {
            $file .= '
				$controller->constructClasses();
				$controller->startupProcess();';
        }

        $file .= '
				$this->viewVars = $controller->viewVars;
				$this->loadHelpers();
				extract($this->viewVars, EXTR_SKIP);
		?>';
        $content = preg_replace("/(<\\?xml)/", "<?php echo '$1'; ?>", $content);
        $file .= $content;

        $cacheEngine = Configure::read('TomatoCms.CacheViewConfigKey');
        $cacheKey    = $cache;
        if(!Cache::write($cacheKey, $file, $cacheEngine)) {
            return NULL;
        }

        return $file;
    }

}
