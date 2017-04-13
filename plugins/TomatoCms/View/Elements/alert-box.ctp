<div id="flashMessage" class="alert <?php echo $class;?>" >
    <button type="button" class="close" data-dismiss="alert">×</button>
    <?php echo $message; ?>
</div>

<script type="application/javascript">
    $(document).ready(function(){
        $( $("#flashMessage") ).insertAfter(".page-header.page-header-top");
    });
</script>

