<?php
$this->TomatoCrumbs->addCrumbs(
    'Chiclet',
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
?>

<h3 class="page-header page-header-top"><i class="icon-cloud"></i> Edit Chiclet</h3>

<?PHP echo $this->BootstrapForm->create('Page'); ?>

<div class="form-box-content">
    <?PHP

    echo $this->BootstrapForm->input('Chiclet.id');
    echo $this->BootstrapForm->input('Chiclet.tag', array("readonly", 'between' => '<div class="col-lg-3">'));
    echo $this->BootstrapForm->input('Chiclet.title');
    echo $this->BootstrapForm->input('Chiclet.body', array(
        'type' => "textarea",
        "class"=>'ckeditor',
        'between' => '<div class="col-lg-8">'
    ));

    echo $this->BootstrapForm->input('Chiclet.is_published', array(
        "options" => array(0=>"Unpublished", 1=>"Published"),
        "label"   => "Status",
        'between' => '<div class="col-lg-2">'
    ));

    echo $this->BootstrapForm->input('Chiclet.published_datetime', array("type" => "text", "readonly", 'between' => '<div class="col-lg-3">'));
    echo $this->BootstrapForm->input('PublishedBy.email', array("label" => "Published By", "readonly",  'between' => '<div class="col-lg-3">'));

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