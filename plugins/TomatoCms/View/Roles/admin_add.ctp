<?php
$this->TomatoCrumbs->addCrumbs(
    'Roles',
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

<h3 class="page-header page-header-top"><i class="glyphicon-parents"></i> Add Role</h3>

<?PHP echo $this->BootstrapForm->create('Role'); ?>

<div class="form-box-content">
    <?PHP
    echo $this->BootstrapForm->input('Role.role_name');

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