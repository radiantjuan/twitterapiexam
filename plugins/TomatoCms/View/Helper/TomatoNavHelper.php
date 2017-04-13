<?PHP
App::uses('AppHelper', 'View/Helper');

/**
 * TomatoNav Helper
 *
 * @category Helper
 * @package  TomatoCms.View.Helper
 * @version  1.0
 * @author   Rommel de Torres <detorresrc@gmail.com>
 */
class TomatoNavHelper extends AppHelper {

    public $controller="";
    public $action="";

    public $helpers = array(
        'Html'
    );

    public function renderNav($menu='sidebar'){
        $this->controller = $this->request->params['controller'];
        $this->plugin = $this->request->params['plugin'];

        $navs = TomatoNav::get($menu);

        $html = "<nav id=\"primary-nav\"><ul>";

        foreach($navs as $nav){
            $activeChildCnt=0;
            $html.=$this->_renderNav($nav, $activeChildCnt);
        }

        return $html."</ul></nav>";

    }//{ public function renderNav($menu='sidebar') }

    private function _renderNav($nav, &$activeChildCnt){
        $currentChild = 0;
        $link = "javascript:void();";
        if(isset($nav['url'])){
            if( is_string($nav['url']) ){
                $link = $nav['url'];
            }else if( is_array($nav['url']) ){
                $link = Router::url($nav['url']);
            }
        }

        // parse Link
        if(is_array($nav['url'])){
            if(
                strcasecmp($this->controller, $nav['url']['controller']) === 0
                &&
                strcasecmp($this->plugin, $nav['url']['plugin']) === 0
            ){

                $activeChildCnt++;
                $currentChild++;
            }

            if( strcasecmp($this->plugin, $nav['url']['plugin']) === 0 && isset($nav['dependentControllers']) && sizeof((array)$nav['dependentControllers'])>0 ){
                if( in_array($this->controller, $nav['dependentControllers']) ){
                    $activeChildCnt++;
                    $currentChild++;
                }
            }
        }

        $children="";
        $activeChildCntLower=0;
        if(isset($nav['children'])){
            if(sizeof($nav['children'])>0){
                foreach($nav['children'] as $child){
                    $children.=$this->_renderNav($child, $activeChildCntLower);
                }
            }
        }
        $activeChildCnt+=$activeChildCntLower;

        $icon = "";
        if(isset($nav['icon'])){
            if(is_array($nav['icon'])){
                if(sizeof($nav['icon'])>0){
                    $icon = $this->Html->tag('i', '', $nav['icon']);
                }
            }
        }
        if(!$nav['parent']){
            $icon = $this->Html->tag('i', '', array('class'=>'icon-double-angle-right'));
        }

        if(!isset($nav['text'])){
            $nav['text']="&nbsp;";
        }
        $aAttributes=array(
            'href' => $link
        );
        if($nav['parent']==true && $activeChildCnt>0 && $activeChildCntLower==0){
            $aAttributes['class']='active';
        }else if($nav['parent']!==true && $currentChild>0){
            $aAttributes['class']='active';
        }
        $a = $this->Html->tag('a', $icon.$nav['text'],$aAttributes);

        if(strlen($children)>0){
            $ulAttribute="";
            if($nav['parent']==true&&$activeChildCnt>0){
                $ulAttribute='style="display: block;"';
            }
            $children="<ul {$ulAttribute}>{$children}</ul>";
        }

        $li = $this->Html->tag('li', $a.$children);

        return $li;
    }

}

?>