<?PHP
// SET DEFAULTS
if(!isset($modelNameCreated)){
    $modelNameCreated = "CreatedBy";
}
if(!isset($fieldCreateddDT)){
    $fieldCreateddDT = "created";
}

if(!isset($modelNameUpdated)){
    $modelNameUpdated = "UpdatedBy";
}
if(!isset($fieldUpdateddDT)){
    $fieldUpdateddDT = "updated";
}

if(!isset($modelNameActivated)){
    $modelNameActivated = "ActivatedBy";
}
if(!isset($fieldActivatedEnabled)){
    $fieldActivatedEnabled = "enabled";
}
if(!isset($fieldActivatedDT)){
    $fieldActivatedDT = "enabled_datetime";
}

if( $this->request->data[$modelName][$fieldActivatedEnabled] == NULL ){
    $this->request->data[$modelName][$fieldActivatedEnabled] = false;
}
?>
<h3 class="page-header page-header-top"><i class="icon-pencil"></i> <?php echo $this->fetch('crud_title'); ?></h3>

<?PHP echo $this->BootstrapForm->create($modelName, $formOptions); ?>

<?PHP
echo $this->BootstrapForm->hidden($modelName.'.'.$fieldActivatedEnabled);
echo $this->BootstrapForm->hidden($modelName.'.'.$fieldActivatedDT);
echo $this->BootstrapForm->hidden($modelName.'.'.$fieldCreateddDT);
echo $this->BootstrapForm->hidden($modelName.'.'.$fieldUpdateddDT);
echo $this->BootstrapForm->hidden($modelName.'.'.$modelPK);
echo $this->BootstrapForm->hidden($modelNameCreated.'.email');
echo $this->BootstrapForm->hidden($modelNameUpdated.'.email');
echo $this->BootstrapForm->hidden($modelNameActivated.'.email');
?>

<div class="form-box-content">

    <?PHP
    if( is_callable('crud_view_edit_form_box_upper') ){
        echo crud_view_edit_form_box_upper();
    }
    ?>

    <?PHP
    if($crudShema):
        foreach($crudShema as $_crudShema): ?>

    <?PHP
        if( isset($_crudShema['type']) && $_crudShema['type']=='html' ){
            echo $_crudShema['html'];
        }else if( isset($_crudShema['options']['type']) && $_crudShema['options']['type'] == 'checkbox' ){
            $_label = "";
            if($_crudShema['options']['label']){
                $_label=$_crudShema['options']['label'];
            }
            $_checkbox = $this->BootstrapForm->checkbox($_crudShema['fieldName'], array(
                'label' => false,
                'div' => false
            ));
            echo "
                <div class=\"form-group\">
                    <label class=\"col-md-2 control-label\">{$_label}</label>
                    <div class=\"col-md-10\">
                        {$_checkbox}
                    </div>
                </div>
                ";
        }else{
            echo $this->BootstrapForm->input($_crudShema['fieldName'], $_crudShema['options']);

            $_fieldName = $_crudShema['fieldName'];
            if( strstr($_fieldName, ".") != FALSE ){
                list($_modelName, $_fieldName) = explode(".", $_fieldName);
            }

            if(isset($_crudShema['options']['type']) && $_crudShema['options']['type'] == 'file' && isset($this->request->data[$_modelName][$_fieldName.'_old']) && $this->request->data[$_modelName][$_fieldName.'_old'] ){
                $_dataOld = $this->request->data[$_modelName][$_fieldName.'_old'];
                echo "
                <div class=\"form-group\" id=\"div_{$_fieldName}_old\">
                    <label class=\"col-md-2 control-label\"></label>
                    <div class=\"col-md-10\">
                        <div >
                            <img style=\"height:100px; width:auto;\" src=\"{$_dataOld}\"/>
                        </div>
                    </div>
                </div>
                ";

                echo $this->BootstrapForm->hidden($modelName.'.'.$_fieldName.'_old');
            }
        }
    ?>

    <?PHP
        endforeach;
        if( is_callable('crud_view_after_foreach') ){
            crud_view_after_foreach($this, 'edit');
        }
    endif; ?>

    <?PHP if( (isset($hideInfo) && $hideInfo==true) == FALSE ):  ?>
    <h4>Other Info</h4>
    <div class="form-group">
        <label class="col-md-2 control-label">Created</label>
        <div class="col-md-6">
            <p class="form-control-static">
                <?PHP echo $this->data[$modelName][$fieldCreateddDT]; ?> / <?PHP echo $this->data[$modelNameCreated]['email']; ?>
            </p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">Updated</label>
        <div class="col-md-6">
            <p class="form-control-static">
                <?PHP echo $this->data[$modelName][$fieldUpdateddDT]; ?> / <?PHP echo $this->data[$modelNameUpdated]['email']; ?>
            </p>
        </div>
    </div>

    <?PHP if(isset($this->data[$modelName][$fieldActivatedEnabled]) && $this->data[$modelName][$fieldActivatedEnabled]==1): ?>
    <div class="form-group">
        <label class="col-md-2 control-label">Activated By</label>
        <div class="col-md-6">
            <p class="form-control-static">
                <?PHP echo $this->data[$modelName][$fieldActivatedDT]; ?> / <?PHP echo $this->data[$modelNameActivated]['email']; ?>
            </p>
        </div>
    </div>
    <?PHP endif; ?>

    <?PHP endif; ?>

    <div class="form-group">
        <div class="col-md-10">
            <input class="btn btn-success" id="btnSave" type="submit" value="Update">
            <?PHP if(isset($this->data[$modelName][$fieldActivatedEnabled]) && !$this->data[$modelName][$fieldActivatedEnabled]): ?>
                <button type="button" class="btn btn-primary" id="btnActivate"><i class="icon-bolt"></i> Activate / Enable</button>
            <?PHP endif; ?>
            <button id="btnCancel" class="btn btn-danger" type="submit">Cancel / Back</button>
        </div>
    </div>
</div>

<?PHP echo $this->BootstrapForm->end(null); ?>

<?php
if(!isset($urlBack)){
    $urlBack = Router::url(array('action'=>'index'));    
}
$mystring = <<<EOT
$("#btnCancel").on('click', function(e){
    location.href='{$urlBack}';
    return false;
});
EOT;
?>
<?PHP $this->Js->buffer($mystring); ?>

<?PHP
if(isset($this->data[$modelName][$fieldActivatedEnabled]) && $this->data[$modelName][$fieldActivatedEnabled]==0):

echo $this->Form->create('FrmActivate', array(
    'url' => array(
        'controller' => $this->request->controller,
        'action' => 'activate',
        $this->request->pass[0]
    ),
    'style' => 'display:none;',
    'id'    => 'FrmActivate'
));
echo $this->Form->end(null);

$mystring = <<<EOT

$("#btnActivate").unbind('click').bind('click', function(){
    if(confirm('Are you sure you want to publish?')==false) return false;

    $("#FrmActivate").submit();
    return false;
});

EOT;
    $this->Js->buffer($mystring);
endif;
?>