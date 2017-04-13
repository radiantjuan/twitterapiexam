<?PHP
define("FRONTEND_LAYOUT_PREFIX", "frontend_layout_");
class TomatoFrontendLayout{

    private static $instance=NULL;

    private function TomatoFrontendLayout(){}

    public static function getInstance(){
        if( TomatoFrontendLayout::$instance == NULL ){
            TomatoFrontendLayout::$instance = new TomatoFrontendLayout();
        }
        return TomatoFrontendLayout::$instance;
    }

    public static function getLayouts(){
        $layouts = array();
        $dir = APP . DS . "View" . DS . "Layouts";

        $d = dir($dir);
        while( ($f = $d->read()) !== FALSE ){
            if(!in_array($f, array(".",".."))){
                if( preg_match('/^'.FRONTEND_LAYOUT_PREFIX.'.*/',$f) ){
                    $f = preg_replace('/.ctp$/', '', $f);
                    $layouts[$f] = $f;
                }
            }
        }

        return $layouts;
    }

}