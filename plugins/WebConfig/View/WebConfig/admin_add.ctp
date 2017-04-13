<?php
$this->TomatoCrumbs->addCrumbs(
    'Web Config',
    Router::url(array('action'=>'index')),
    array()
)->addCrumbs(
    'Add',
    'javascript:void(0);',
    array()
);
?>

<h3 class="page-header page-header-top"><i class="icon-plus-sign"></i> Add Web Config</h3>

<?PHP echo $this->BootstrapForm->create('WebConfig', array('novalidate'=>true, 'type' => 'file')); ?>

<div class="form-box-content">

    <?PHP
    echo $this->BootstrapForm->input('WebConfig.type', array(
        'options' => array(
                'textfield' => 'textfield', 'textarea' => 'textarea', 'ckeditor' => 'ckeditor', 'image' => 'image'
            )
    ));
    ?>

    <?PHP
    echo $this->BootstrapForm->input('WebConfig.variable', array(
    ));
    ?>

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

    <?PHP
    echo $this->BootstrapForm->input('WebConfig.value_image', array(
        'type' => 'file',
        'label' => 'Image<br/><em style="color: blue;"></em>',
        'div' => array(
            'class' => 'form-group div-field',
            'id'    => 'div_value_image',
            'style' => 'display: none'
        )
    ));
    ?>

    <?PHP
    echo $this->BootstrapForm->input('WebConfig.remarks', array(
        'type' => 'textarea'
    ));
    ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-md-10">
            <input class="btn btn-success" id="btnSave" type="submit" value="Save">
            <button id="btnCancel" class="btn btn-danger" type="submit">Cancel / Back</button>
        </div>
    </div>
</div>

<?PHP echo $this->BootstrapForm->end(null); ?>

<?php
$urlBack = Router::url(array('action'=>'index'));
$mystring = <<<EOT
$("#btnCancel").on('click', function(e){
    location.href='{$urlBack}';
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