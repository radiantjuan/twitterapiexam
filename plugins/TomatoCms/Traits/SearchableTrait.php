<?php
trait SearchableTrait
{

    public function admin_search()
    {
        if(!$this->request->is(['post', 'put'])){
            throw new BadRequestException;
        }
        $this->autoRender = false;

        if( isset( $this->request->data['btnReset'] ) ){
            $this->Session->delete(self::$searchKey);
        }else{
            $this->Session->write(self::$searchKey, $this->request->data);
        }

        $this->redirect($this->request->referer());
    }

}
