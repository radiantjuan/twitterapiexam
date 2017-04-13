<?php
$this->TomatoCrumbs->addCrumbs(
    'Users',
    Router::url(
        array('action'=>'index')
    ),
    array()
)->addCrumbs(
    'Edit',
    'javascript::void(0)',
    array(
        'class' => 'active'
    )
);
?>

<h3 class="page-header page-header-top"><i class="icon-user"></i> My Profile</h3>

<?PHP echo $this->BootstrapForm->create('User', array('novalidate'=>true)); ?>

<div class="form-box-content">
    <?PHP

    echo $this->BootstrapForm->hidden('User.id');
    echo $this->BootstrapForm->input('User.email', array('readonly'));
    echo $this->BootstrapForm->input('User.firstname');
    echo $this->BootstrapForm->input('User.middlename');
    echo $this->BootstrapForm->input('User.lastname');
    echo $this->BootstrapForm->input('Role.role_name', array('readonly'));
    ?>
    <h4>Password <?PHP echo $this->BootstrapForm->checkbox('User.change_password'); ?> </h4>
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
<script type="application/javascript">
    $(document).ready(function(){
        $("#btnCancel").unbind('click').bind('click', function(){
            location.href='<?PHP echo Router::url(array("action"=>'index')); ?>';
            return false;
        });
    });
</script>