<?PHP
App::uses('TomatoCmsAppModel', 'TomatoCms.Model');

class PostTag extends TomatoCmsAppModel{

    public function getTags($postId){

        $this->bindModel(array(
            'belongsTo' => array(
                'Tag' => array(
                    'className' => 'TomatoCms.Tag'
                    )
                )
            ));

        $data = $this->find('all', array(

                'conditions' => array(
                    'post_id' => $postId
                    )

            ));

        $tags = array();

        foreach($data as $_data){

            $tags[] = $_data['Tag']['tag'];

        }

        return $tags;
    }
    
}