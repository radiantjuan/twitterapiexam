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
    'Edit',
    'javascript:void(0);',
    array(
        'class' => 'active'
    )
);
?>

<h3 class="page-header page-header-top"><i class="icon-edit-sign"></i> Edit Plan Kit</h3>

<?PHP echo $this->BootstrapForm->create('Page', array('novalidate' => true, 'type' => 'file')); ?>

<?PHP
echo $this->BootstrapForm->hidden('Page.is_published');
echo $this->BootstrapForm->hidden('Page.created');
echo $this->BootstrapForm->hidden('Page.modified');
echo $this->BootstrapForm->hidden('Page.published_datetime');
echo $this->BootstrapForm->hidden('CreatedBy.email');
echo $this->BootstrapForm->hidden('UpdatedBy.email');
echo $this->BootstrapForm->hidden('PublishedBy.email');
?>

<div class="form-box-content">
    <div class="form-group">
        <label class="col-md-2 control-label">Published</label>
        <div class="col-md-6">
            <?PHP if($this->data['Page']['is_published']==0): ?>
                <p class="form-control-static"><span class="label label-default">No</span></p>
            <?PHP else: ?>
                <p class="form-control-static"><span class="label label-success">Yes</span></p>
            <?PHP endif; ?>
        </div>
    </div>

    <?PHP
    echo $this->BootstrapForm->hidden('Page.id');
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

    <h4>Other Info</h4>
    <div class="form-group">
        <label class="col-md-2 control-label">Created</label>
        <div class="col-md-6">
            <p class="form-control-static">
                <?PHP echo $this->data['Page']['created']; ?> / <?PHP echo $this->data['CreatedBy']['email']; ?>
            </p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">Updated</label>
        <div class="col-md-6">
            <p class="form-control-static">
                <?PHP echo $this->data['Page']['modified']; ?> / <?PHP echo $this->data['UpdatedBy']['email']; ?>
            </p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">Published</label>
        <div class="col-md-6">
            <p class="form-control-static">
                <?PHP echo $this->data['Page']['published_datetime']; ?> / <?PHP echo $this->data['PublishedBy']['email']; ?>
            </p>
        </div>
    </div>

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