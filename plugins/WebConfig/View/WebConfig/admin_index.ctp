<?php
$this->TomatoCrumbs->addCrumbs(
    'Web Config',
    'javascript:void(0);',
    array()
);
?>

<h3 class="page-header page-header-top"><i class="icon-th-list"></i> Web Config</h3>

<div id="datatables_wrapper" class="dataTables_wrapper form-inline" role="grid">
    <div class="row">
        <div class="col-sm-6 col-xs-5">
            <div id="datatables_length" class="dataTables_length">
                <label>
                    <button id="btnAdd" class="btn btn-success btn-sm"><i class="icon-plus"></i> Add Web Config</button>
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
                <th><?PHP echo $this->Paginator->sort('WebConfig.variable', 'Variable'); ?></th>
                <th><?PHP echo $this->Paginator->sort('WebConfig.remarks', 'Remarks'); ?></th>
                <th><?PHP echo $this->Paginator->sort('WebConfig.enabled', 'Enabled'); ?></th>
                <th><?PHP echo $this->Paginator->sort('WebConfig.enabled_datetime', 'Enabled DateTime'); ?></th>
                <th><?PHP echo $this->Paginator->sort('WebConfig.created', 'Created DateTime'); ?></th>
                <th class="text-center"><i class="icon-bolt"></i> Actions</th>
            </tr>
            </thead>
            <tbody>
            <?PHP foreach($WebConfigs as $data): ?>
                <tr>
                    <td class="text-left"><strong>{TMT_WC_<?PHP echo $data['WebConfig']['variable']; ?>}</strong></td>
                    <td class="text-left"><?PHP echo $data['WebConfig']['remarks']; ?></td>
                    <td class="text-center">
                        <?PHP if($data['WebConfig']['enabled']==0): ?>
                            <p class="form-control-static"><span class="label label-default">No</span></p>
                        <?PHP else: ?>
                            <p class="form-control-static"><span class="label label-success">Yes</span></p>
                        <?PHP endif; ?>
                    </td>
                    <td class="text-center"><?PHP echo $data['WebConfig']['enabled_datetime']; ?></td>
                    <td class="text-center"><?PHP echo $data['WebConfig']['created']; ?></td>
                    <td class="text-center">
                        <?PHP
                        if($data['WebConfig']['enabled']==0):
                            echo $this->Form->postLink(__('<i class="icon-bolt icon-large"></i>'),
                                array('action' => 'activate',$data['WebConfig']['id']),
                                array('escape' => false, 'data-toggle'=>'tooltip', 'data-title' => 'Activate', 'class' => 'btn btn-xs btn-primary'),
                                __('Are you sure you want to activate?',
                                    $data['WebConfig']['id']));
                        else:
                            echo $this->Form->postLink(__('<i class="icon-off icon-large"></i>'),
                                array('action' => 'deactivate',$data['WebConfig']['id']),
                                array('escape' => false, 'data-toggle'=>'tooltip', 'data-title' => 'Deactivate', 'class' => 'btn btn-xs btn-primary'),
                                __('Are you sure you want to deactivate?',
                                    $data['WebConfig']['id']));
                        endif;
                        ?>
                        <a href="<?PHP echo Router::url(array("action"=>"edit", $data['WebConfig']['id'])); ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-primary"><i class="icon-edit  icon-large"></i></a>
                        <?PHP
                        echo $this->Form->postLink(__('<i class="icon-trash icon-large"></i>'),
                            array('action' => 'delete',$data['WebConfig']['id']),
                            array('escape' => false, 'data-toggle'=>'tooltip', 'title' => 'Delete', 'class' => 'btn btn-xs btn-danger'),
                            __('Are you sure you want to delete # %s?',
                                $data['WebConfig']['id']));
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
            location.href='<?PHP echo Router::url(array("action"=>"add")); ?>';
            return false;
        });
    });
</script>
