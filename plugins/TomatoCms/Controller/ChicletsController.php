<?PHP
App::uses('TomatoCmsAppController', 'TomatoCms.Controller');
App::uses('TomatoFunctions', 'TomatoCms.Lib');

class ChicletsController extends TomatoCmsAppController{

    public $title_for_layout = "Chiclets";

    public $uses = array('TomatoCms.Chiclet');

    public function admin_index(){
        $conditions=array();
        $this->Paginator->settings = array(
            'Chiclet' => array(
                'limit'      => 20,
                'conditions' => $conditions
            )
        );

        $Chiclets = $this->Paginator->paginate('Chiclet');
        $this->set('Chiclets', $Chiclets);
    }

    public function admin_add(){
        if( $this->request->is(array('post','put')) ){

            $this->Chiclet->set($this->request->data);

            if ($this->Chiclet->validates()) {
                $Chiclet = $this->Chiclet->save($this->request->data, array(
                    "title",
                    "body",
                    "is_published",
                    "published_by_id",
                    "published_datetime"
                ));

                $this->Session->setFlash(
                    'Chiclet successfully created.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-success')
                );
                $this->redirect(array('action' => 'edit', $Chiclet['Chiclet']['id']));
            }
        }else{
            $this->request->data['Chiclet']['tag'] = "chiclet_".TomatoFunctions::generateRandomString(15);
        }
    }

    public function admin_edit($id){
        if( $this->request->is(array('post','put')) ){
            $this->Chiclet->set($this->request->data);
            if ($this->Chiclet->validates()) {
                $Chiclet = $this->Chiclet->save($this->request->data, array(
                    "title",
                    "body",
                    "is_published",
                    "published_by_id",
                    "published_datetime"
                ));

                $this->Session->setFlash(
                    'Chiclet successfully updated.',
                    'TomatoCms.alert-box',
                    array('class' => 'alert-success')
                );
                $this->redirect(array('action' => 'edit', $Chiclet['Chiclet']['id']));
            }

        }else{

            $this->Chiclet->bindModel(array(
                'belongsTo' => array(
                    'PublishedBy' => array(
                        'className' => 'User'
                    )
                )
            ));

            $this->request->data = $this->Chiclet->read(null, $id);
        }
    }

    public function admin_delete($id){
        $this->autoRender = false;
        $this->Chiclet->delete($id);

        $this->Session->setFlash(
            'Chiclet successfully deleted.',
            'TomatoCms.alert-box',
            array('class' => 'alert-success')
        );
        $this->redirect(array('action' => 'index'));
    }

    public function get_chiclet($tag){
        $this->autoRender = false;

        if( !$tag ){
            throw new BadRequestException;
        }

        $chicletData = $this->Chiclet->getChicletContentByTag($tag);

        if( !$chicletData ){
            throw new BadRequestException;
        }

        if( $chicletData['Chiclet']['is_published'] == 1 ){
            return $chicletData['Chiclet']['body'];
        }else if( $chicletData['Chiclet']['is_published'] == 0 && $this->Auth->loggedIn()==TRUE ){
            return $chicletData['Chiclet']['body'];
        }

        return "";
    }
}