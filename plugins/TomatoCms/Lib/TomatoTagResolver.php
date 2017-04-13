<?PHP
class TomatoTagResolver{

    private $html;

    private $objRequester = null;

    public function TomatoTagResolver($html){
        $this->html = $html;

        $this->init();
    }

    public function getOut(){
        return $this->html;
    }

    private function init(){
        preg_match_all('/{type=.*}/i', $this->html, $matches);

        $tags=array_unique($matches[0]);
        $arrayTags = $this->tagToArray($tags);

        if((array)sizeof($arrayTags) > 0){

            $this->objRequester = new Object();

            foreach($arrayTags as $attributes){
                $method = "process_".$attributes['type'];
                $methodExists = method_exists($this, $method);
                try {
                    if ($methodExists == true) {
                        $this->{$method}($attributes, $this->html);
                    } else {
                        if (Configure::read('debug') > 0) {
                            $this->html = str_replace($attributes['raw_tag'], "TAG ERROR!", $this->html);
                        }
                    }
                }catch(Exception $e){
                    $this->html = str_replace($attributes['raw_tag'], "<div style=\"background-color: red; color: #fff;\">TAG ERROR! : " . $e->getMessage()."</div>", $this->html);
                }
            }
        }

        if( Configure::read('TomatoTagResolver.BeforeRender') && function_exists(Configure::read('TomatoTagResolver.BeforeRender'))  ){
            $this->html = call_user_func_array(Configure::read('TomatoTagResolver.BeforeRender'), array($this->html) );
        }
    }

    public function process_widget($attributes, &$html){
        $body = null;
        if(isset($attributes['cache_enable']) && $attributes['cache_enable']==1){
            $body = Cache::read('tag_widget_'.$attributes['tag'], 'short');
        }

        if($body==FALSE){
            $modelWidget = ClassRegistry::getObject('widget');
            if( $modelWidget == FALSE ){
                $modelWidget = $this->loadModel('TomatoCms.Widget');
            }
            $widgetData = $modelWidget->getWidgetByTag($attributes['tag']);

            $body = $this->objRequester->requestAction(
                array_merge(
                    array(
                        "plugin"       => Inflector::underscore($widgetData['Widget']['package_name']),
                        "controller"   => Inflector::underscore($widgetData['Widget']['package_name']),
                        "action"       => (isset($attributes['action']))?$attributes['action']:"render_widget",
                        "tag"          => $attributes['tag'],
                        "tag_resolver" => 1
                    ),
                    $this->getArrayParams($attributes)
                )
            );

            if(isset($attributes['cache_enable']) && $attributes['cache_enable']==1) {
                Cache::write('tag_widget_' . $attributes['tag'], $body, 'short');
            }
        }
        $html = str_replace($attributes['raw_tag'], $body, $html);
    }

    public function process_navigator($attributes, &$html){
        $body = Cache::read('tag_navigator_'.$attributes['tag'], 'short');
        if($body==FALSE){
            $body = $this->objRequester->requestAction(
                array(
                    "plugin"       => "tomato_cms",
                    "controller"   => "navigators",
                    "action"       => "render_navigator",
                    "tag"          => $attributes['tag'],
                    "tag_resolver" => 1
                )
            );

            Cache::write('tag_navigator_'.$attributes['tag'], $body, 'short');
        }
        $html = str_replace($attributes['raw_tag'], $body, $html);
    }

    public function process_chiclet($attributes, &$html){
        $chicletBody = Cache::read('tag_chicklet_'.$attributes['tag'], 'short');
        if($chicletBody==FALSE){
            $chicletBody = $this->objRequester->requestAction(
                array(
                    "plugin"       => "tomato_cms",
                    "controller"   => "chiclets",
                    "action"       => "get_chiclet",
                    "tag_resolver" => 1,
                    $attributes['tag']
                ) );

            Cache::write('tag_chicklet_'.$attributes['tag'], $chicletBody, 'short');
        }
        $html = str_replace($attributes['raw_tag'], $chicletBody, $html);
    }

    private function tagToArray(array $rawTag){
        $return = array();

        foreach($rawTag as $_rawTag){
            $_attributes=array(
                'raw_tag' => $_rawTag
            );

            $_rawTag = preg_replace('/(\{|\})/', '', $_rawTag);
            $_rawTag = str_replace('|', '"', $_rawTag);

            $domDoc = new DOMDocument;
            @$domDoc->loadHTML('<div '.$_rawTag .'></div>');

            $domTag = $domDoc->getElementsByTagName('div');

            foreach($domTag->item(0)->attributes as $attr){
                $_attributes[ $attr->nodeName ] = $attr->nodeValue;
            }

            $return[] = $_attributes;

            unset($domDoc);
        }//{ foreach($rawTag as $_rawTag) }

        return $return;
    }


    private function loadModel($modelClass = null, $id = null) {
        list($plugin, $modelClass) = pluginSplit($modelClass, true);

        $model = ClassRegistry::init(array(
            'class' => $plugin . $modelClass, 'alias' => $modelClass, 'id' => $id
        ));
        if (!$model) {
            throw new MissingModelException($modelClass);
        }
        return $model;
    }

    private function getArrayParams($array, $exclude=array('raw_tag','type','tag', 'cache_enable')){
        $tmpArray = $array;
        foreach($exclude as $k){
            unset($tmpArray[$k]);
        }

        return $tmpArray;
    }
}
