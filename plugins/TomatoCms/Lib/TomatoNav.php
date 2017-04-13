<?PHP
class TomatoNav{

    private static $instance;

    private $navs=array();

    private function TomatoNav(){}

    public static function getInstance(){
        if( TomatoNav::$instance == NULL ){
            TomatoNav::$instance = new TomatoNav();
        }
        return TomatoNav::$instance;
    }

    public static function add($menu, $options){
        $_this = TomatoNav::getInstance();

        if(!isset($_this->navs[$menu])){
            $_this->navs[$menu]=array();
        }

        $_this->navs[$menu][] = $options;
    }//{ public static function add($menu, $options) } 

    public static function addChild($menu, $parentText, $options){
        $_this = TomatoNav::getInstance();

        foreach($_this->navs[$menu] as $index => $parentMenu){
            if( strcasecmp($parentMenu['text'], $parentText) === 0 ){
                $_this->navs[$menu][$index]['children'][]=$options;
                break;
            }
        }
    }

    public static function get($menu){
        $_this = TomatoNav::getInstance();

        // Sort base on priority
        $navs = $_this->navs[$menu];
        $tmpnavs = array();
        $tmpPriority = array();
        foreach($navs as $nav){
            $tmpnavs[ $nav['text'] ] = $nav;

            if(!isset($nav['priority'])){
                $nav['priority']=0;
            }
            $tmpPriority[ $nav['text'] ] = $nav['priority'];
        }
        asort($tmpPriority);

        $navRet = array();
        foreach(array_keys($tmpPriority) as $itemName){
            $tmpnavs[$itemName]['children'] = $_this->sortChild($tmpnavs[$itemName]['children']);
            $navRet[] = $tmpnavs[$itemName];
        }

        return $navRet;
    }

    private function sortChild($array){
        if(sizeof($array)<=1) return $array;

        $tmp = array();
        $tmpnavs = array();
        foreach($array as $item){
            $tmpnavs[ $item['text'] ] = $item;
            $priority=99;
            if(isset($item['priority'])){
                $priority=$item['priority'];
            }
            $tmp[$item['text']] = $priority;
        }
        asort($tmp);

        $navRet=array();
        foreach(array_keys($tmp) as $k){
            $navRet[] = $tmpnavs[$k];
        }

        return $navRet;
    }

}
?>