<?php $this->extend('TomatoCms./Crud/add');

$this->TomatoCrumbs->addCrumbs(
    'Modules',
    Router::url(
        array('action'=>'index')
    ),
    array()
)->addCrumbs(
    'Add',
    Router::url(
        array('action'=>'add')
    ),
    array(
        'class' => 'active'
    )
);

$this->TomatoCrumbs->addCrumbs(
    'Promo Loads',
    Router::url(array('action'=>'index')),
    array()
)->addCrumbs(
    'Add',
    'javascript:void(0);',
    array()
);

$this->assign('crud_title', 'Add Promo Load');

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
$this->set('formOptions', array('novalidate'=>true));