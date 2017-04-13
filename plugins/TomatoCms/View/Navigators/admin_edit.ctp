<?php
$this->TomatoCrumbs->addCrumbs(
    'Navigators',
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

<h3 class="page-header page-header-top"><i class="icon-link"></i> Edit Navigator</h3>

<?PHP echo $this->BootstrapForm->create('NavigatorHeader'); ?>

<div class="form-box-content">
<?PHP

echo $this->BootstrapForm->hidden('NavigatorHeader.id');
echo $this->BootstrapForm->input('NavigatorHeader.title');
echo $this->BootstrapForm->input('NavigatorHeader.tag');

echo $this->BootstrapForm->submit('Update', array(
    "id" => 'btnUpdate',
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