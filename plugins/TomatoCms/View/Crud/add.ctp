<h3 class="page-header page-header-top"><i class="icon-plus-sign"></i> <?php echo $this->fetch('crud_title'); ?></h3>

<?PHP echo $this->BootstrapForm->create($modelName, $formOptions); ?>

<div class="form-box-content">

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
        }
        
    ?>

    <?PHP
        endforeach;
        if( is_callable('crud_view_after_foreach') ){
            crud_view_after_foreach($this, 'add');
        }
    endif; ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-md-10">
            <?PHP echo $this->BootstrapForm->button('Save', array('name'=>'btnSave', 'class' => 'btn btn-success')); ?>
            <?PHP if(isset($buttonSaveThenCreate) && $buttonSaveThenCreate): ?>
                <?PHP echo $this->BootstrapForm->button('Save then Add New', array('name'=>'btnSaveAndCreateNew', 'class' => 'btn btn-primary')); ?>
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