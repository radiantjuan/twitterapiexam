<?PHP
class CacheManagerBehavior  extends ModelBehavior {

    public function afterSave(Model $model, $created, $options = array()) {

        if( isset($model->disabledClearCached) && $model->disabledClearCached==true ){
            CakeLog::debug("ClearCache skip.");
            return true;
        }

        CakeLog::debug("Clearing cache.");

        $this->clearCache(APP . 'tmp' . DS . 'cache');
        $this->clearCache(APP . 'tmp' . DS . 'cache' . DS . 'views');

        return true;
    }

    public function afterDelete(Model $model){

        if( isset($model->disabledClearCached) && $model->disabledClearCached==true ){
            CakeLog::debug("ClearCache skip.");
            return true;
        }

        CakeLog::debug("Clearing cache.");

        $this->clearCache(APP . 'tmp' . DS . 'cache');
        $this->clearCache(APP . 'tmp' . DS . 'cache' . DS . 'views');

        return true;
    }

    private function clearCache($dirName){
        $files = glob($dirName . DS . '*');

        if ($files === false) {
            return false;
        }

        foreach ($files as $file) {
            if (is_file($file)) {
                //@codingStandardsIgnoreStart
                @unlink($file);
                //@codingStandardsIgnoreEnd
            }
        }
    }
}