<?php
$this->TomatoCrumbs->addCrumbs(
    'Navigators',
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

<h3 class="page-header page-header-top"><i class="icon-link"></i> Add Navigator</h3>

<?PHP echo $this->BootstrapForm->create('NavigatorHeader'); ?>

<div class="form-box-content">
<?PHP

echo $this->BootstrapForm->input('NavigatorHeader.title');
echo $this->BootstrapForm->input('NavigatorHeader.tag');

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