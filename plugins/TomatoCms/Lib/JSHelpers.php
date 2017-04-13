<?PHP
class JSHelpers{

    private static $js=NULL;

    private function JSHelpers(){}

    public static function addJS($js){
        if( self::$js ){
            self::$js .= "\n" . $js;
        }else{
            self::$js = $js;
        }
    }

    public static function getJS(){
        return self::$js;
    }

    public static function outJS(){
        $js = self::$js;

        if(!$js) return "";

$jsOut = <<<EOT
<script type="text/javascript">
$(function() {
    {$js}
});
</script>
EOT;

    return $jsOut;
    }

}
