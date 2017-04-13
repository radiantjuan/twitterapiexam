<?php
$this->TomatoCrumbs->addCrumbs(
    'Web Config',
    Router::url(array('action'=>'index')),
    array()
)->addCrumbs(
    'Edit',
    'javascript:void(0);',
    array()
);
?>

<h3 class="page-header page-header-top"><i class="icon-pencil"></i> Edit Web Config</h3>

<?PHP echo $this->BootstrapForm->create('WebConfig', array('novalidate'=>true, 'type' => 'file')); ?>

<?PHP
echo $this->BootstrapForm->hidden('WebConfig.type');
echo $this->BootstrapForm->hidden('WebConfig.variable');

echo $this->BootstrapForm->hidden('WebConfig.value_image_old');
echo $this->BootstrapForm->hidden('WebConfig.enabled');
echo $this->BootstrapForm->hidden('WebConfig.created');
echo $this->BootstrapForm->hidden('WebConfig.updated');
echo $this->BootstrapForm->hidden('WebConfig.enabled_datetime');
echo $this->BootstrapForm->hidden('WebConfig.id');
echo $this->BootstrapForm->hidden('CreatedBy.email');
echo $this->BootstrapForm->hidden('UpdatedBy.email');
echo $this->BootstrapForm->hidden('ActivatedBy.email');
?>

<div class="form-box-content">

    <div class="form-group">
        <label class="col-md-2 control-label">Type</label>
        <div class="col-md-10">
            <?PHP echo $this->data['WebConfig']['type']; ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">Variable</label>
        <div class="col-md-10">
            <?PHP echo $this->data['WebConfig']['variable']; ?>
        </div>
    </div>

    <?PHP
    echo $this->BootstrapForm->input('WebConfig.value_textfield', array(
        'label' => 'Value',
        'div' => array(
            'class' => 'form-group div-field',
            'id'    => 'div_value_textfield',
            'style' => 'display: none'
        )
    ));
    ?>

    <?PHP
    echo $this->BootstrapForm->input('WebConfig.value_textarea', array(
        'type' => 'textarea',
        'label' => 'Value',
        'div' => array(
            'class' => 'form-group div-field',
            'id'    => 'div_value_textarea',
            'style' => 'display: none'
        )
    ));
    ?>

    <?PHP
    echo $this->BootstrapForm->input('WebConfig.value_ckeditor', array(
        'label' => 'Value',
        'type'    => "textarea",
        "class"   => 'ckeditor',
        'between' => '<div class="col-md-8">',
        'div' => array(
            'class' => 'form-group div-field',
            'id'    => 'div_value_ckeditor',
            'style' => 'display: none'
        )
    ));
    ?>

    <div id="div_value_image" class="div-field" class="display: none">

    <?PHP
    echo $this->BootstrapForm->input('WebConfig.value_image', array(
        'type' => 'file',
        'label' => 'Image<br/><em style="color: blue;"></em>'
    ));
    ?>

    <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-10">
            <div style="overflow: scroll; width: 100%;">
                <img src="<?PHP echo $this->data['WebConfig']['value_image_old']; ?>"/>
            </div>
        </div>
    </div>

    </div>

    <?PHP
    echo $this->BootstrapForm->input('WebConfig.remarks', array(
        'type' => 'textarea'
    ));
    ?>

    <h4>Other Info</h4>
    <div class="form-group">
        <label class="col-md-2 control-label">Created</label>
        <div class="col-md-6">
            <p class="form-control-static">
                <?PHP echo $this->data['WebConfig']['created']; ?> / <?PHP echo $this->data['CreatedBy']['email']; ?>
            </p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">Updated</label>
        <div class="col-md-6">
            <p class="form-control-static">
                <?PHP echo $this->data['WebConfig']['updated']; ?> / <?PHP echo $this->data['UpdatedBy']['email']; ?>
            </p>
        </div>
    </div>

    <?PHP if($this->data['WebConfig']['enabled']==1): ?>
    <div class="form-group">
        <label class="col-md-2 control-label">Activated By</label>
        <div class="col-md-6">
            <p class="form-control-static">
                <?PHP echo $this->data['WebConfig']['enabled_datetime']; ?> / <?PHP echo $this->data['ActivatedBy']['email']; ?>
            </p>
        </div>
    </div>
    <?PHP endif; ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-md-10">
            <input class="btn btn-success" id="btnSave" type="submit" value="Save">

            <?PHP if($this->data['WebConfig']['enabled']==0): ?>
                <button type="button" class="btn btn-primary" id="btnActivate"><i class="icon-bolt"></i> Activate / Enable</button>
            <?PHP endif; ?>

            <button id="btnCancel" class="btn btn-danger" type="submit">Cancel / Back</button>
        </div>
    </div>
</div>

<?PHP echo $this->BootstrapForm->end(null); ?>

<?PHP echo $this->Form->create('FrmActivate', array(
    'url' => array(
        'controller' => $this->request->controller,
        'action' => 'activate',
        $this->request->pass[0]
    ),
    'style' => 'display:none;',
    'id'    => 'FrmActivate'
)); ?>
<?PHP echo $this->Form->end(null); ?>

<?php
$urlBack = Router::url(array('action'=>'index'));
$mystring = <<<EOT
$("#btnCancel").on('click', function(e){
    location.href='{$urlBack}';
    return false;
});

$("#btnActivate").unbind('click').bind('click', function(){
    if(confirm('Are you sure you want to activate?')==false) return false;

    $("#FrmActivate").submit();
    return false;
});

$("#WebConfigType").change(function(){

    var value = $(this).val();

    $(".div-field").hide();

    $("#div_value_"+value).show();    

});

$("#WebConfigType").trigger('change');
EOT;
?>
<?PHP $this->Js->buffer($mystring); ?>