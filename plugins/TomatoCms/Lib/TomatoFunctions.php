<?PHP
class TomatoFunctions {

    private static $instance=NULL;

    private function TomatoFunctions(){}

    public static function generateRandomString($length){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $length; $i++) {
            $randstring .= $characters[rand(0, (strlen($characters)-1) )];
        }
        return $randstring;
    }
}