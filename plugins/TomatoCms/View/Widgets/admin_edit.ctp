<?php
$this->TomatoCrumbs->addCrumbs(
    'Widgets',
    Router::url(
        array('action'=>'index')
    ),
    array()
)->addCrumbs(
    'Edit',
    'javascript:void(0)',
    array(
        'class' => 'status'
    )
);
?>

<h3 class="page-header page-header-top"><i class="glyphicon-package"></i> Edit Widget</h3>

<?PHP echo $this->BootstrapForm->create('Widget'); ?>
<div class="form-box-content">
<?PHP

echo $this->BootstrapForm->hidden('Widget.id');
echo $this->BootstrapForm->input('Widget.tag');
echo $this->BootstrapForm->input('Widget.title');
echo $this->BootstrapForm->input('Widget.package_name');
echo $this->BootstrapForm->input('Widget.description', array("type"=>"textarea"));
?>

    <div class="form-group">
        <label class="col-lg-2 control-label">Active</label>
        <div class="col-lg-6">
            <?PHP if($this->data['Widget']['status']==0): ?>
                <p class="form-control-static"><span class="label label-default">No</span></p>
            <?PHP else: ?>
                <p class="form-control-static"><span class="label label-success">Yes</span></p>
            <?PHP endif; ?>
        </div>
    </div>
    <div class="form-group">
        <label for="ModuleNewsTitle" class="col-lg-2 control-label">Activated By</label>
        <div class="col-lg-6">
            <p class="form-control-static"><?PHP echo $this->data['ActivatedBy']['email']; ?></p>
        </div>
    </div>
    <div class="form-group">
        <label for="ModuleNewsTitle" class="col-lg-2 control-label">Activated Date Time</label>
        <div class="col-lg-6">
            <p class="form-control-static"><?PHP echo $this->data['Widget']['activated_datetime']; ?></p>
        </div>
    </div>

    <div class="form-group">
        <label for="ModuleNewsTitle" class="col-lg-2 control-label">Created Date Time</label>
        <div class="col-lg-6">
            <p class="form-control-static"><?PHP echo $this->data['Widget']['created']; ?></p>
        </div>
    </div>
    <div class="form-group">
        <label for="ModuleNewsTitle" class="col-lg-2 control-label">Created By</label>
        <div class="col-lg-6">
            <p class="form-control-static"><?PHP echo $this->data['CreatedBy']['email']; ?></p>
        </div>
    </div>

    <div class="form-group">
        <label for="ModuleNewsTitle" class="col-lg-2 control-label">Updated Date Time</label>
        <div class="col-lg-6">
            <p class="form-control-static"><?PHP echo $this->data['Widget']['modified']; ?></p>
        </div>
    </div>
    <div class="form-group">
        <label for="ModuleNewsTitle" class="col-lg-2 control-label">Updated By</label>
        <div class="col-lg-6">
            <p class="form-control-static"><?PHP echo $this->data['UpdatedBy']['email']; ?></p>
        </div>
    </div>

<?PHP
echo $this->BootstrapForm->submit('Update', array(
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