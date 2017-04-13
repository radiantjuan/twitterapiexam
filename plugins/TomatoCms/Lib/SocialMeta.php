<?PHP
class SocialMeta{

    private static $title=NULL;
    private static $url=NULL;
    private static $description=NULL;
    private static $image=NULL;
    private static $tags=NULL;

    private function SocialMeta(){}

    public static function setTags($tags){
        self::$tags = $tags;
    }

    public static function getTags(){
        return Sanitize::html(self::$tags);
    }

    public static function setTitle($title){
        self::$title = $title;
    }

    public static function getTitle($title=NULL){
        if( self::$title ){
            return Sanitize::html(self::$title);
        }else if($title){
            return Sanitize::html($title);
        }
        return NULL;
    }

    public static function setUrl($url){
        self::$url = $url;
    }

    public static function getUrl($url=NULL){
        $finalURL = "";
        if( self::$url ){
            $finalURL = self::$url;
        }else if($url){
            $finalURL = $url;
        }

        return $finalURL;
    }

    public static function setDescription($description){
        self::$description = $description;
    }

    public static function getDescription($description=NULL){
        if( self::$description ){
            return Sanitize::html(self::$description);
        }else if($description){
            return Sanitize::html($description);
        }
        return NULL;
    }

    public static function setImage($image){
        self::$image = $image;
    }

    public static function getImage($image=NULL){
        if( self::$image ){
            return self::$image;
        }else if($image){
            return $image;
        }
        return NULL;
    }

}
