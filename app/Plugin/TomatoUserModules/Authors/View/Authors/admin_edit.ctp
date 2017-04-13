<?php
function crud_view_edit_form_box_upper(){
    $buttons = <<<EOT
<div class="form-group">
    <div class="col-md-10">
        <button id="btnTest" class="btn btn-primary" type="button"><i class="glyphicon-sort"></i> Test Button</button>
    </div>
</div>
EOT;
    return $buttons;
}
$this->extend('TomatoCms./Crud/edit');

$this->TomatoCrumbs->addCrumbs(
    'Author',
    Router::url(array('action'=>'index')),
    array()
)->addCrumbs(
    'Edit',
    'javascript:void(0);',
    array()
);

$this->assign('crud_title', 'Edit Auhor');

require_once dirname(__FILE__) . DS . 'common.php';
$this->set('modelPK'    , 'id');

$mystring = <<<EOT
$("#btnTest").click(function(evt){
    evt.preventDefault();

    alert('Test');
});
EOT;
$this->Js->buffer($mystring);
?>
