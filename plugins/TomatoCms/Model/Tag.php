<?php
App::uses('TomatoCmsAppModel', 'TomatoCms.Model');

class Tag extends TomatoCmsAppModel {

    public function saveTags($articleId, $tags){
        $articleTag = ClassRegistry::init(array(
            'class' => 'TomatoCms.PostTag', 
            'alias' => 'PostTag'
        ));
        
        $tagsTmp = trim($tags);
        $tagsTmp = preg_split('/(,|;)/', $tagsTmp);
        foreach($tagsTmp as $k => $t){
            $tagsTmp[$k] = trim($t);
        }
        
        $articleTag->deleteAll(array(
            "post_id" => $articleId
        ));
            
        foreach($tagsTmp as $tag){
            if($tag=="")continue;
            
            $tagData = $this->find('first', array(
               
               "conditions" => array(
                   "tag" => $tag
               ) 
                
            ));
            
            if(!$tagData){
                
                $this->create();
                $tagData = $this->save(array(
                    "tag" => $tag
                ));
                
            }
            
            $articleTag->create();
            $articleTag->save(array(
                "post_id" => $articleId,
                "tag_id"     => $tagData['Tag']['id']
            ));
        }
    }
    
}