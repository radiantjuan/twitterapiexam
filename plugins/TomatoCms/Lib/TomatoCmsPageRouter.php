<?PHP
class TomatoCmsPageRouter
{
    private static $routerName = 'router.page.php';

    private function TomatoCmsPageRouter(){}

    public static function route(){
        $routerFile = TMP . self::$routerName;


        if( !is_file($routerFile) ){

            $fp = fopen($routerFile, 'a+');
            ftruncate($fp, 0);
            fwrite($fp, "<?PHP\n");

            $pageModel = ClassRegistry::init(array(
                'class' => 'TomatoCms.Page',
                'alias' => 'Page'
            ));

            $pages = $pageModel->find('all', array(
                'fields' => array(
                    'id', 'slug'
                ),
                'conditions' => array(
                    'is_published' => 1
                )
            ));

            foreach($pages as $page){
$heredoc = <<<EOT
Router::connect('/{$page['Page']['slug']}',
    array(
        'plugin'     => 'tomato_cms',
        'controller' => 'pages',
        'action'     => 'view_page',
        'page_id'    => {$page['Page']['id']},
        'vanity'     => 1
    ),
    array(
        'pass' => array('location', 'page_id', 'vanity')
    )
);

EOT;
                fwrite($fp, $heredoc);
            }

            fwrite($fp, "?>");
            fclose($fp);
        }
        require_once $routerFile;
    }

    public static function flush(){
        $routerFile = TMP . self::$routerName;

        @unlink(@$routerFile);
    }
}