<?php
$this->TomatoCrumbs->addCrumbs(
    'Users',
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
?>

<h3 class="page-header page-header-top"><i class="icon-user"></i> Add User</h3>

<?PHP echo $this->BootstrapForm->create('User'); ?>

<div class="form-box-content">
    <?PHP
    echo $this->BootstrapForm->input('User.email');
    echo $this->BootstrapForm->input('User.firstname');
    echo $this->BootstrapForm->input('User.middlename');
    echo $this->BootstrapForm->input('User.lastname');

    echo $this->BootstrapForm->input('User.role_id', array(
        'empty' => '-- Please Select Role --'
    ));
    ?>
    <h4>Password</h4>
    <?PHP
    echo $this->BootstrapForm->input('User.password');
    echo $this->BootstrapForm->input('User.confirm_password', array(
        'type' => 'password'
    ));

    echo $this->BootstrapForm->submit('Save', array(
        "id" => 'btnSave',
        'after' =>  '&nbsp;'.$this->BootstrapForm->button('Cancel', array('id' => 'btnCancel', 'class' => 'btn btn-danger', 'div' => false, 'label' => false)).'</div>'
    ));

    ?>
</div>

<?PHP echo $this->BootstrapForm->end(null); ?>

<?php
$url = Router::url(array("action"=>'index'));
$mystring = <<<EOT
$("#btnCancel").unbind('click').bind('click', function(){
    location.href='{$url}';
    return false;
});
EOT;
?>
<?PHP $this->Js->buffer($mystring); ?>