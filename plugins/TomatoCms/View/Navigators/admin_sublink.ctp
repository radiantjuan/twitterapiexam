<style>
    #modalAddSublink .modal-dialog, #modalEditSublink .modal-dialog  {width:75%;}
</style>
<?php
$this->TomatoCrumbs->addCrumbs(
    'Navigators',
    Router::url(array('action'=>'index')),
    array()
);

foreach((array)$navCrumbs as $crumb){
    $this->TomatoCrumbs->addCrumbs(
        $crumb['title'],
        $crumb['url'],
        array()
    );
}
?>
<h3 class="page-header page-header-top">
    <i class="icon-link"></i> Links / Sub Links
</h3>

<div id="example-datatables_wrapper" class="dataTables_wrapper form-inline" role="grid">
    <div class="row">
        <div class="col-sm-6 col-xs-5">
            <div id="example-datatables_length" class="dataTables_length">
                <label>
                    <button id="addRow" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAddSublink"><i class="icon-plus"></i> Add New Link</button>
                </label>
            </div>
        </div>
        <div class="col-sm-6 col-xs-7">
            <div class="dataTables_filter" id="example-datatables_filter">
                <div class="dataTables_paginate paging_bootstrap">

                </div>
            </div>
        </div>
    </div>

    <table class="table table-striped table-bordered table-hover dataTable" aria-describedby="example-datatables_info">
        <thead>
        <tr>
            <th>Title</th>
            <th class="hidden-xs hidden-sm">Link</th>
            <th class="text-center"><i class="icon-bolt"></i> Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($sublinks as $sublink): ?>
            <tr>
                <td><a href="<?PHP echo Router::url(array("action" => "sublink", $sublink['NavigatorDetail']['navigator_header_id'], $sublink['NavigatorDetail']['id']));?>"><?PHP echo $sublink['NavigatorDetail']['title']; ?> <span class="badge badge-<?PHP if((int)$sublink['NavigatorDetail']['sublink_cnt']>0)echo "success";else echo "danger"; ?>"><?PHP echo $sublink['NavigatorDetail']['sublink_cnt']; ?></span></a></td>
                <td class="hidden-xs hidden-sm"><?PHP echo $sublink['NavigatorDetail']['link']; ?></td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="#" class="btn btn-xs btn-primary btn-up" attr_id="<?PHP echo $sublink['NavigatorDetail']['id']; ?>"><i class="icon-large icon-caret-up"></i></a>
                        <a href="#" class="btn btn-xs btn-primary btn-down" attr_id="<?PHP echo $sublink['NavigatorDetail']['id']; ?>"><i class="icon-large icon-caret-down"></i></a>
                    </div>

                    <div class="btn-group">
                        <a href="#" attr_id="<?PHP echo $sublink['NavigatorDetail']['id']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-primary btn-edit"><i class="icon-large icon-pencil"></i></a>
                        <i class="loader-08" style="display: none;" id="button_loader_<?PHP echo $sublink['NavigatorDetail']['id']; ?>"></i>
                        <a href="#" attr_id="<?PHP echo $sublink['NavigatorDetail']['id']; ?>" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger btn-trash"><i class="icon-large icon-trash"></i></a>
                    </div>
                </td>
            </tr>
        <?PHP endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalAddSublink" tabindex="-1" role="dialog" aria-labelledby="modalAddSublinkLabel" aria-hidden="true">
    <div class="modal-dialog  modal-vertical-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modalAddSublinkLabel">Add Link</h4>
            </div>
            <div class="modal-body">
                <?PHP echo $this->BootstrapForm->create('NavigatorDetail', array(
                    "url" => array('controller' => 'navigators', 'action' => 'add_sublink', $this->request->params['pass'][0], $this->request->params['pass'][1])
                )); ?>

                <?PHP
                echo $this->BootstrapForm->input('title');
                echo $this->BootstrapForm->input('link');
                ?>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="btn-save">Save</button>
                <button type="button" class="btn btn-warning btn-sm" id="btn-cancel">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditSublink" tabindex="-1" role="dialog" aria-labelledby="modalEditSublink" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modalEditSublink">Edit Link</h4>
            </div>
            <div class="modal-body">
                <?PHP echo $this->BootstrapForm->create('NavigatorDetailEdit', array(
                    "url" => array('controller' => 'navigators', 'action' => 'update_sublink', $this->request->params['pass'][0], $this->request->params['pass'][1])
                )); ?>

                <?PHP
                echo $this->BootstrapForm->hidden('id');
                echo $this->BootstrapForm->input('title');
                echo $this->BootstrapForm->input('link');
                ?>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="btn-update">Save</button>
                <button type="button" class="btn btn-warning btn-sm" id="btn-edit-cancel">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#btn-cancel").click(function(){
            $('#modalAddSublink').modal('hide');
        });

        $("#btn-edit-cancel").click(function(){
            $('#modalEditSublink').modal('hide');
        });

        $("#NavigatorDetailAdminSublinkForm").submit(function(){

            if($("#NavigatorDetailTitle").val()==""){
                $("#NavigatorDetailTitle").focus();
                alert('Please input Title');
                return false;
            }

            if($("#NavigatorDetailLink").val()==""){
                $("#NavigatorDetailLink").focus();
                alert('Please input Link');
                return false;
            }

            return true;
        });

        $("#NavigatorDetailEditAdminSublinkForm").submit(function(){

            if($("#NavigatorDetailEditTitle").val()==""){
                $("#NavigatorDetailEditTitle").focus();
                alert('Please input Title');
                return false;
            }

            if($("#NavigatorDetailEditLink").val()==""){
                $("#NavigatorDetailEditLink").focus();
                alert('Please input Link');
                return false;
            }

            return true;
        });

        $("#btn-save").click(function(){
            $(this).button('loading');
            $(this).html('Loading..');
            $("#NavigatorDetailAdminSublinkForm").trigger('submit');
        });

        $("#btn-update").click(function(){
            $(this).button('loading');
            $(this).html('Loading..');
            $("#NavigatorDetailEditAdminSublinkForm").trigger('submit');
        });

        $(".btn.btn-xs.btn-primary.btn-up").click(function(){
            var btn = $(this);
            var id = btn.attr('attr_id');

            location.href="<?PHP echo Router::url(array('controller' => 'navigators', 'action' => 'moveup')); ?>/"+id+'/<?PHP echo $this->request->params['pass'][0]; ?>/<?PHP echo $this->request->params['pass'][1]; ?>';

            return false;
        });

        $(".btn.btn-xs.btn-primary.btn-down").click(function(){
            var btn = $(this);
            var id = btn.attr('attr_id');

            location.href="<?PHP echo Router::url(array('controller' => 'navigators', 'action' => 'movedown')); ?>/"+id+'/<?PHP echo $this->request->params['pass'][0]; ?>/<?PHP echo $this->request->params['pass'][1]; ?>';

            return false;
        });

        $(".btn.btn-xs.btn-primary.btn-edit").click(function(){
            var id = $(this).attr("attr_id");
            var _this = $(this);

            $("#button_loader_"+id).show();
            _this.hide();
            $.ajax({

                url  : '<?PHP echo Router::url(array('action'=>'get_navigator_detail')); ?>/'+id,
                type : 'GET',
                error : function(){
                    alert('An erorr has occured, please try again.');
                },
                complete : function(){
                    $("#button_loader_"+id).hide();
                    _this.show();
                },
                success : function(ret){
                    if(ret.error==false){
                        $("#NavigatorDetailEditId").val( id );
                        $("#NavigatorDetailEditTitle").val( ret.model.NavigatorDetail.title );
                        $("#NavigatorDetailEditLink").val( ret.model.NavigatorDetail.link );
                        $('#modalEditSublink').modal('show');
                    }
                }

            });

            return false;
        });

        $(".btn.btn-xs.btn-danger.btn-trash").click(function(){
            var id = $(this).attr("attr_id");
            var _this = $(this);

            if( confirm('Are you sure you want to delete this link?') ){
                location.href="<?PHP echo Router::url(array("action"=>"delete_sublink", $this->request->params['pass'][0], $this->request->params['pass'][1])); ?>/" + id;
            }

            return false;
        });
    });
</script>