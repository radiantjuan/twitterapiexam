<?PHP
trait CrudOnEditBeforeCallbackTraits
{
    public function onEditBeforeFindCallback(){
        $this->bindModel(array(
            'belongsTo' => array(
                'CreatedBy' => array(
                    'className' => 'User'
                ),
                'UpdatedBy' => array(
                    'className' => 'User'
                ),
                'ActivatedBy' => array(
                    'className' => 'User',
                    'foreignKey' => 'enabled_by_id'
                )
            )
        ));
    }
}
