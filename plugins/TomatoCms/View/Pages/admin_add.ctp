<?php
$this->TomatoCrumbs->addCrumbs(
    'Pages',
    Router::url(
        array(
            'action'=>'index'
        )
    ),
    array()
)->addCrumbs(
    'Add',
    'javascript:void(0);',
    array(
        'class' => 'active'
    )
);
?>

<h3 class="page-header page-header-top"><i class="icon-plus-sign"></i> Add Page</h3>

<?PHP echo $this->BootstrapForm->create('Page', array('novalidate' => true, 'type' => 'file')); ?>

<div class="form-box-content">
    <?PHP
    echo $this->BootstrapForm->input('Page.title');
    echo $this->BootstrapForm->input('Page.slug');
    echo $this->BootstrapForm->input('Page.body', array(
        'type' => "textarea",
        "class"=>'ckeditor',
        'between' => '<div class="col-lg-8">'
    ));

    echo $this->BootstrapForm->input('Page.layout', array(
        "options" => $layouts,
        'empty' => '-- Please select layout --',
        'between' => '<div class="col-lg-3">'
    ));
    ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <input class="btn btn-success" id="btnSave" type="submit" value="Save">
            <button id="btnCancel" class="btn btn-danger" type="submit">Cancel / Back</button>
        </div>
    </div>
</div>

<?PHP echo $this->BootstrapForm->end(null); ?>
<script type="application/javascript">
    $(document).ready(function(){
        $('#PageSlug').slugify('#PageTitle');

        $("#btnCancel").unbind('click').bind('click', function(){
            location.href='<?PHP echo Router::url(array("action"=>'index')); ?>';
            return false;
        });
    });
</script>