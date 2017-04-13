<?PHP
class NavigatorComponent extends Component{

    public $cacheConfig = "short";

    protected $controller;

    public function initialize(Controller $controller){
        $this->controller = $controller;
    }

    public function beforeRender(Controller $controller){
        if($this->controller->request->params['action']=="render_navigator"){

            $tag = $this->controller->request->params['named']['tag'];

            $menuTree=Cache::read('navigator_cache', $this->cacheConfig);

            if(!$menuTree[$tag]){

                $header = $this->controller->NavigatorHeader->find('first', array(
                    'conditions' => array(
                        'tag' => $tag
                    )
                ));

                $_menuTree=array();
                if($header['NavigatorHeader']['status']==1){

                    // Get First Layer of menu
                    $navigators = $this->controller->NavigatorDetail->find('all', array(
                        'conditions' => array(
                            'parent_id' => 0,
                            'navigator_header_id' => $header['NavigatorHeader']['id']
                        ),
                        'order' => array(
                            "weight" => "ASC"
                        )
                    ));

                    foreach($navigators as $k => $v){
                        $_menuTree[$k]=$v['NavigatorDetail'];
                        $_menuTree[$k]['childs'] = $this->getLinks($header['NavigatorHeader']['id'], $v['NavigatorDetail']['id']);
                    }
                }
                $menuTree[$tag]=$_menuTree;
                Cache::write('navigator_cache', $menuTree, $this->cacheConfig);
            }
            $this->controller->set('menuTree', $menuTree[$tag]);
        }
    }

    private function getLinks($headerId, $parentId){
        $menuTree=array();

        $data = $this->controller->NavigatorDetail->find('all', array(
            'conditions' => array(
                'parent_id'           => $parentId,
                'navigator_header_id' => $headerId
            )
        ));

        if(!$data){
            return null;
        }

        foreach($data as $k => $v){
            $menuTree[$k]=$v['NavigatorDetail'];
            $menuTree[$k]['childs'] = $this->getLinks($headerId, $v['NavigatorDetail']['id']);
        }

        return $menuTree;
    }
}