<?php $this->extend('TomatoCms./Crud/add');

$this->TomatoCrumbs->addCrumbs(
    'Authors',
    Router::url(['action'=>'index']),
    array()
)->addCrumbs(
    'Add',
    'javascript:void(0);',
    []
);

$this->assign('crud_title', 'Add Author');

require_once dirname(__FILE__) . DS . 'common.php';

$mystring = <<<EOT
EOT;
$this->Js->buffer($mystring);
?>
