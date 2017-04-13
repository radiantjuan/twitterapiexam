<?php
$this->TomatoCrumbs->addCrumbs(
    'Chiclets',
    'javascript:void(0)',
    array()
);
?>

<h3 class="page-header page-header-top"><i class="icon-cloud"></i> Chiclets</h3>

<div id="datatables_wrapper" class="dataTables_wrapper form-inline" role="grid">
    <div class="row">
        <div class="col-sm-6 col-xs-5">
            <div id="datatables_length" class="dataTables_length">
                <label>
                    <button id="btnAdd" class="btn btn-success btn-sm"><i class="icon-plus"></i> New Chiclet</button>
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
                <th ><?PHP echo $this->Paginator->sort('id'); ?></th>
                <th ><?PHP echo $this->Paginator->sort('tag'); ?></th>
                <th ><?PHP echo $this->Paginator->sort('title'); ?></th>
                <th class="hidden-xs hidden-sm">Status</th>
                <th class="text-center"><i class="icon-bolt"></i> Actions</th>
            </tr>
            </thead>
            <tbody>
            <?PHP foreach($Chiclets as $chiclet): ?>
                <tr>
                    <td><?PHP echo $chiclet['Chiclet']['id']; ?></td>
                    <td><?PHP echo $chiclet['Chiclet']['tag']; ?></td>
                    <td><?PHP echo $chiclet['Chiclet']['title']; ?></td>
                    <td class="text-center hidden-xs hidden-sm">
                        <?PHP if($chiclet['Chiclet']['is_published']==0): ?>
                            <span class="label label-danger">Unpublished</span>
                        <?PHP else: ?>
                            <span class="label label-success">Published</span>
                        <?PHP endif; ?>
                    </td>
                    <td class="text-center">
                        <a href="<?PHP echo Router::url(array("action"=>"edit", $chiclet['Chiclet']['id'])); ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-success"><i class="icon-edit"></i></a>
                        <?PHP
                        echo $this->Form->postLink(__('<i class="icon-trash"></i>'),
                            array('action' => 'delete',$chiclet['Chiclet']['id']),
                            array('escape' => false, 'data-toggle'=>'tooltip', 'title' => 'Delete', 'class' => 'btn btn-xs btn-danger'),
                            __('Are you sure you want to delete # %s?',
                                $chiclet['Chiclet']['id']));
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