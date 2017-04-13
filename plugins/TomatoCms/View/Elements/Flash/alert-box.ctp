<?PHP $msg_id=time(); ?>
<!--<div class="alert --><?php //echo $class;?><!--">-->
<!--    <button type="button" class="close" data-dismiss="alert" id="msg_btn_--><?PHP //echo $msg_id; ?><!--">&times;</button>-->
<!--    --><?php //echo $message; ?>
<!--</div>-->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-vertical-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Message</h4>
            </div>
            <div class="modal-body">
                <div class="alert <?php echo $class;?>">
                    <?php echo $message; ?>
                </div>
            </div>
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
<!--            </div>-->
        </div>
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function(){
//        $("#msg_btn_<?PHP //echo $msg_id; ?>//").click(function(){
//            $("#msg_<?PHP //echo $msg_id; ?>//").fadeOut('slow', function(){
//                $("#msg_<?PHP //echo $msg_id; ?>//").remove();
//            });
//        });

        //$('#myModal').modal('show');

        $("<div>hello world</div>").insertBefore(".page-header.page-header-top");
    });
</script>


