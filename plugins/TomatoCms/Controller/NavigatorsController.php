<?PHP
App::uses('TomatoCmsAppController', 'TomatoCms.Controller');
App::uses('TomatoFrontendLayout', 'TomatoCms.Lib');

class NavigatorsController extends TomatoCmsAppController{

    public $title_for_layout = "Navigators";

    public $allowToAll = array(
        'admin_get_navigator_detail',
        'admin_clear_cache'
    );

    public $components = array('TomatoCms.Navigator');
    public $uses = array('TomatoCms.NavigatorHeader', 'TomatoCms.NavigatorDetail');

    public function beforeFilter(){
        parent::beforeFilter();

        $this->Security->unlockedActions=array(
            'admin_add_sublink',
            'admin_delete_sublink',
            'admin_update_sublink'
        );
    }

    public function render_navigator(){
        $tag = $this->request->params['named']['tag'];

        $elementLocation = APP . DS . 'View' . DS . 'Elements' . DS . 'Navigators' . DS;
        $elementDefault = $elementLocation . 'default.ctp';
        $elementTag = $elementLocation . $tag . '.ctp';

        $elementUse = $elementDefault;

        if( is_file($elementTag) === TRUE ){
            $elementUse = $elementTag;
        }
        $this->layout= "";
        $this->render($elementUse);
    }

    public function admin_clear_cache(){
        $this->autoRender = false;

        Cache::delete('navigator_cache', 'short');

        $navs = $this->NavigatorHeader->find('all', array(
            'fields' => array('tag')
        ));
        foreach($navs as $nav){
            Cache::delete('tag_navigator_'.$nav['NavigatorHeader']['tag'], 'short');
        }
    }

    public function admin_index(){
        $conditions=array();
        $this->Paginator->settings = array(
            'NavigatorHeader' => array(
                'limit'      => 20,
                'conditions' => $conditions
            )
        );

        $NavigatorHeaders = $this->Paginator->paginate('NavigatorHeader');

        $sublinkCnt=null;
        foreach(array_keys($NavigatorHeaders) as $key){
            $sublinkCnt = $this->NavigatorDetail->find('count', array(
                'conditions' => array(
                    'navigator_header_id' => $NavigatorHeaders[$key]['NavigatorHeader']['id'],
                    'parent_id'           => 0
                )
            ));

            $NavigatorHeaders[$key]['NavigatorHeader']['sublink_cnt'] = $sublinkCnt;
        }

        $this->set('NavigatorHeaders', $NavigatorHeaders);
    }

    public function admin_add(){
        if( $this->request->is(array('post','put')) ){

            $this->NavigatorHeader->set($this->request->data);

            if ($this->NavigatorHeader->validates()) {
                $data = $this->NavigatorHeader->save($this->request->data, false, array(
                    "title",
                    "tag",
                    "created_by",
                    "updated_by"
                ));

                $this->Session->setFlash(
                    'Navigator successfully created.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-success')
                );
                $this->redirect(array('action' => 'edit', $data['NavigatorHeader']['id']));
            }
        }
    }

    public function admin_edit($id){
        if(!$id){
            throw new BadRequestException;
        }

        if( $this->request->is(array('post','put')) ){
            $this->NavigatorHeader->set($this->request->data);
            if ($this->NavigatorHeader->validates()) {
                $data = $this->NavigatorHeader->save($this->request->data, false, array(
                    "title",
                    "tag",
                    "created_by",
                    "updated_by"
                ));

                $this->Session->setFlash(
                    'Navigator successfully updated.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-success')
                );
                $this->redirect(array('action' => 'edit', $data['NavigatorHeader']['id']));
            }
        }else{
            $this->NavigatorHeader->recursive=-1;
            $this->data = $this->NavigatorHeader->read(null, $id);
        }
    }

    public function admin_delete($id){
        $this->NavigatorHeader->bindModel(array(
            'hasMany' => array(
                'NavigatorDetail'
            )
        ));

        $this->NavigatorHeader->NavigatorDetail->deleteAll(array('NavigatorDetail.navigator_header_id'=>$id), false);
        $this->NavigatorHeader->delete($id, false);

        $this->Session->setFlash(
            'Navigator successfully deleted.',
            'TomatoCms.alert-box',
            array('class' => 'alert-success')
        );
        $this->redirect($this->referer());
    }

    public function admin_sublink($navigatorId, $parentId){
        $navCrumbs=array();

        if($parentId==0){
            $parentData = $this->NavigatorHeader->find('first', array(
                'conditions' => array(
                    'id' => $navigatorId
                )
            ));

            $navCrumbs[] = array(
                "title" => $parentData['NavigatorHeader']['title'],
                "url"   => Router::url(array("action" => "sublink", $navigatorId, 0))
            );
        }else{
            $lastParendtId = $parentId;
            while(true){
                $_navCrumb = $this->NavigatorDetail->find('first', array(
                    'conditions' => array(
                        'id' => $lastParendtId
                    )
                ));
                if($_navCrumb){
                    $navCrumbs[] = array(
                        "title" => $_navCrumb['NavigatorDetail']['title'],
                        "url"   => Router::url(array("action" => "sublink", $navigatorId, $lastParendtId))
                    );

                    $lastParendtId = $_navCrumb['NavigatorDetail']['parent_id'];
                }else{

                    if($lastParendtId==0){
                        $parentData = $this->NavigatorHeader->find('first', array(
                            'conditions' => array(
                                'id' => $navigatorId
                            )
                        ));

                        $navCrumbs[] = array(
                            "title" => $parentData['NavigatorHeader']['title'],
                            "url"   => Router::url(array("action" => "sublink", $navigatorId, 0))
                        );
                    }

                    break;
                }
            }
            krsort($navCrumbs);
        }
        $this->set(compact('navCrumbs'));

        $sublinks = $this->NavigatorDetail->find('all', array(
            'conditions' => array(
                'navigator_header_id' => $navigatorId,
                'parent_id'           => $parentId
            )
        ));

        foreach(array_keys($sublinks) as $key){
            $sublinkCnt = $this->NavigatorDetail->find('count', array(
                'conditions' => array(
                    'navigator_header_id' => $navigatorId,
                    'parent_id'           => $sublinks[$key]['NavigatorDetail']['id']
                )
            ));

            $sublinks[$key]['NavigatorDetail']['sublink_cnt'] = $sublinkCnt;
        }

        $this->set(compact('sublinks'));
    }

    public function admin_get_navigator_detail($id){
        if(!$id){
            throw new NotFoundException(__('Invalid Request'));
        }

        $return = array();
        $return['error'] = false;
        $return['message'] = "";

        $data = $this->NavigatorDetail->find('first', array(
            'conditions' => array(
                'id' => $id
            )
        ));

        if(!$data){
            throw new NotFoundException(__('Invalid Request'));
        }

        $return['model'] = $data;

        $this->autoRender = false;
        $this->response->type('json');
        $this->response->body(json_encode($return));
    }

    public function admin_add_sublink($navigatorId, $parentId){
        $this->autoRender = false;

        $this->request->data['NavigatorDetail']['navigator_header_id']=$navigatorId;
        $this->request->data['NavigatorDetail']['parent_id']=$parentId;

        $this->NavigatorDetail->create($this->request->data);
        $this->NavigatorDetail->save();
        $this->redirect(array("action"=>"sublink", $navigatorId, $parentId));
    }

    public function admin_delete_sublink($navigatorId, $parentId, $id){
        $this->autoRender = false;

        if( $this->NavigatorDetail->find('count', array('conditions' => array('parent_id' => $id))) > 0 ){
            $this->Session->setFlash(
                'Please delete sublink first.',
                'TomatoCms.alert-box',
                array('class' => 'alert-danger')
            );
        }else{
            $this->NavigatorDetail->delete($id);
        }
        $this->redirect(array("action"=>"sublink", $navigatorId, $parentId));
    }

    public function admin_update_sublink($navigatorId, $parentId){
        $this->autoRender = false;

        if($this->request->is(array('post','put'))){

            $this->NavigatorDetail->save(array(
                'NavigatorDetail' => $this->request->data['NavigatorDetailEdit']
            ));
            $this->redirect(array("action"=>"sublink", $navigatorId, $parentId));
        }
    }

    public function admin_moveup($id, $navigatorId, $parentId){
        if (!$id) {
            throw new BadRequestException;
        }

        $this->NavigatorDetail->moveUp($id);

        $this->redirect(array("action"=>"sublink", $navigatorId, $parentId));
    }

    public function admin_movedown($id, $navigatorId, $parentId){
        if (!$id) {
            throw new BadRequestException;
        }

        $this->NavigatorDetail->moveDown($id);

        $this->redirect(array("action"=>"sublink", $navigatorId, $parentId));
    }

    public function admin_activate($id){
        if( !$id ){
            throw new BadRequestException;
        }

        $data = $this->NavigatorHeader->read(null, $id);
        if(!$data){
            throw new BadRequestException;
        }

        $this->NavigatorHeader->set('status', 1);
        $this->NavigatorHeader->save();

        $this->Session->setFlash(
            'Navigator successfully activated.',
            'TomatoCms.alert-box',
            array('class' => 'alert-success')
        );
        $this->redirect(array('action' => 'index'));
    }

    public function admin_deactivate($id){
        if( !$id ){
            throw new BadRequestException;
        }

        $data = $this->NavigatorHeader->read(null, $id);
        if(!$data){
            throw new BadRequestException;
        }

        $this->NavigatorHeader->set('status', 0);
        $this->NavigatorHeader->save();

        $this->Session->setFlash(
            'Navigator successfully deactivated.',
            'TomatoCms.alert-box',
            array('class' => 'alert-success')
        );
        $this->redirect(array('action' => 'index'));
    }
}