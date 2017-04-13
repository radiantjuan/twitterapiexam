<?php
$this->TomatoCrumbs->addCrumbs(
    'Media Upload',
    'javascript:void(0);',
    array(
        'class' => 'active'
    )
);
?>

<h3 class="page-header page-header-top"><i class="icon-camera-retro"></i> Media Upload</h3>

<div id="datatables_wrapper" class="dataTables_wrapper form-inline" role="grid">
    <div class="row">
        <div class="col-sm-6 col-xs-5">
            <div id="datatables_length" class="dataTables_length">
                <label>
                    <button id="btnAdd" class="btn btn-success btn-sm"><i class="icon-plus"></i> Add</button>
                </label>
            </div>
        </div>
        <div class="col-sm-6 col-xs-7">
            <div class="dataTables_filter" id="datatables_filter">
                <div class="dataTables_paginate paging_bootstrap">
                </div>
            </div>
        </div>
    </div>
        <table class="table table-striped table-hover table-bordered dataTable">
            <thead>
            <tr>
                <th><?PHP echo $this->Paginator->sort('MediaUpload.filename', 'Filename'); ?></th>
                <th><?PHP echo $this->Paginator->sort('MediaUpload.created', 'Created'); ?></th>
                <th class="text-center"><i class="icon-bolt"></i> Actions</th>
            </tr>
            </thead>
            <tbody>
            <?PHP foreach($MediaUploads as $data): ?>
                <tr>
                    <td><?PHP echo $data['MediaUpload']['filename']; ?></td>
                    <td class="text-center"><?PHP echo $data['MediaUpload']['created']; ?></td>
                    <td class="text-center">

                        <a href="javascript:void(0);" onclick="copyToClipboard('<?PHP echo $data['MediaUpload']['path']; ?>');" data-toggle="tooltip" title="" class="btn btn-xs btn-info" data-original-title="Copy to clipboard"><i class="icon-copy"></i></a>

                        <a target="_blank" href="<?PHP echo $data['MediaUpload']['path']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="icon-eye-open icon-large"></i></a>

                        <?PHP
                        echo $this->Form->postLink(__('<i class="icon-trash icon-large"></i>'),
                            array('action' => 'delete',$data['MediaUpload']['id'],'plans_and_bundle_id' => $this->request->plans_and_bundle_id),
                            array('escape' => false, 'data-toggle'=>'tooltip', 'title' => 'Delete', 'class' => 'btn btn-xs btn-danger'),
                            __('Are you sure you want to delete?',
                                $data['MediaUpload']['id']));
                        ?>
                    </td>
                </tr>
            <?PHP endforeach; ?>
            </tbody>
        </table>
    <div class="row">
        <div class="col-sm-5 hidden-xs">
            <?php
            echo $this->Paginator->counter(array(
                'format' => __('Page <strong>{:page}</strong> of <strong>{:pages}</strong>')
            ));
            ?>
        </div>
        <div class="col-sm-7 col-xs-12 clearfix">
            <div class="dataTables_paginate paging_bootstrap">
                <ul class="pagination pagination-sm remove-margin">
                    <?php
                    echo $this->Paginator->first('<i class="icon-double-angle-left"></i>', array('tag' => 'li', 'escape' => false), '<a href="#"><i class="icon-double-angle-left"></i></a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
                    echo $this->Paginator->prev('<i class="icon-chevron-left"></i>', array('tag' => 'li', 'escape' => false), '<a href="#"><i class="icon-chevron-left"></i></a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
                    echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'active', 'currentTag' => 'a'));
                    echo $this->Paginator->next('<i class="icon-chevron-right"></i>', array('tag' => 'li', 'escape' => false), '<a href="#"><i class="icon-chevron-right"></i></a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
                    echo $this->Paginator->last('<i class="icon-double-angle-right"></i>', array('tag' => 'li', 'escape' => false), '<a href="#"><i class="icon-double-angle-right"></i></a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    $(document).ready(function(){
        $("#btnAdd").unbind('click').click(function(){
            location.href='<?PHP echo Router::url(array("action"=>"add", 'plans_and_bundle_id'=>$this->request->plans_and_bundle_id)); ?>';
            return false;
        });
    });

    function copyToClipboard (text) {
        window.prompt ("Copy to clipboard: Ctrl+C, Enter", text);
    }
</script>