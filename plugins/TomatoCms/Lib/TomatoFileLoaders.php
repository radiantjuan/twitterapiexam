<?PHP
class TomatoFileLoaders{

    private static $instance = NULL;

    private function TomatoFileLoaders(){}

    public static function getInstance(){
        if( TomatoFileLoaders::$instance == NULL ){
            TomatoFileLoaders::$instance = new TomatoFileLoaders();
        }
        return TomatoFileLoaders::$instance;
    }


    public static function load($dirName){
        if(!is_dir($dirName)){
            return false;
        }
        $d = dir( $dirName );
        while (false !== ($entry = $d->read())) {
            if( !in_array($entry, array(".", "..")) ){
                require_once( $dirName . DS . $entry );
            }
        }
        $d->close();

        return true;
    }
}