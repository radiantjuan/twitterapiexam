<?php $this->extend('TomatoCms./Crud/edit');

$this->TomatoCrumbs->addCrumbs(
    'Modules',
    Router::url(
        array('action'=>'index')
    ),
    array()
)->addCrumbs(
    'Edit',
    'javascript:void(0)',
    array(
        'class' => 'active'
    )
);

$this->assign('crud_title', 'Edit Module');

$crudShema = array(

    array(
        'fieldName' => 'Module.title',
        'options' => array(
            )
        ),

    array(
        'fieldName' => 'Module.slug',
        'options' => array(
            'between' => '<div class="col-lg-6">' . Router::url('/', true)
            )
        ),

    array(
        'fieldName' => 'Module.package_name',
        'options' => array(
            )
        ),

    array(
        'fieldName' => 'Module.description',
        'options' => array(
            "type"=>"textarea"
            )
        ),

);

$this->set('crudShema'  , $crudShema);
$this->set('modelName'  , 'Module');
$this->set('modelPK'    , 'id');
$this->set('formOptions', array('novalidate'=>true, 'type' => 'file'));

$this->set('hideInfo', true);