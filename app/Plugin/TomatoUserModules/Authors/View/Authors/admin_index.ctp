<?php
$this->TomatoCrumbs->addCrumbs(
    'Author',
    'javascript:void(0);',
    array()
);
?>

<h3 class="page-header page-header-top"><i class="icon-th-list"></i> Authors</h3>

<div class="form-box-content">
    <?PHP echo $this->BootstrapForm->create('Search', [
        'url' => [
            'controller' => 'authors',
            'action' => 'search'
        ]
    ]); ?>

    <?PHP echo $this->BootstrapForm->input('Search.name', [
        'label' => 'Name',
        'required' => false
    ]);?>

    <?PHP echo $this->BootstrapForm->input('Search.email_address', [
        'label' => 'Email Address',
        'required' => false
    ]);?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-md-10">
            <?PHP echo $this->BootstrapForm->button('<i class="icon-search"></i> Search', array('name'=>'btnSearch', 'class' => 'btn btn-sm btn-primary')); ?>
            <?PHP echo $this->BootstrapForm->button('<i class="glyphicon-circle_remove"></i> Reset', array('name'=>'btnReset', 'class' => 'btn btn-sm btn-warning')); ?>
        </div>
    </div>

    <?PHP echo $this->BootstrapForm->end(null); ?>
</div>

<div id="datatables_wrapper" class="dataTables_wrapper form-inline" role="grid">
    <div class="row">
        <div class="col-sm-6 col-xs-5">
            <div id="datatables_length" class="dataTables_length">
                <label>
                    <button id="btnAdd" class="btn btn-primary btn-sm"><i class="icon-plus"></i> Add Author</button>
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
            <th><?PHP echo $this->Paginator->sort('Author.name'); ?></th>
            <th><?PHP echo $this->Paginator->sort('Author.email_address', 'Email'); ?></th>
            <th><?PHP echo $this->Paginator->sort('Author.enabled', 'Status'); ?></th>
            <th class="text-center"><i class="icon-bolt"></i> Actions</th>
        </tr>
        </thead>
        <tbody>
        <?PHP foreach($Authors as $data): ?>
            <tr>
                <td class="text-left"><?PHP echo $data['Author']['name']; ?></td>
                <td class="text-left"><?PHP echo $data['Author']['email_address']; ?></td>
                <td class="text-left">
                    <?PHP if($data['Author']['enabled']==0): ?>
                        <p class="form-control-static"><span class="label label-default">Draft</span></p>
                    <?PHP else: ?>
                        <p class="form-control-static">
                            <span class="label label-success">Published</span>
                            <br/>
                            <span class="label label-default"><small><?PHP echo $data['Author']['enabled_datetime']; ?></small></span>
                        </p>
                    <?PHP endif; ?>
                </td>

                <td class="text-center">

                    <?PHP
                    if($data['Author']['enabled']==0):
                        echo $this->Form->postLink(__('<i class="icon-bolt icon-large"></i>'),
                            array('action' => 'activate',$data['Author']['id']),
                            array('escape' => false, 'data-toggle'=>'tooltip', 'data-title' => 'Publish', 'class' => 'btn btn-xs btn-warning'),
                            __('Are you sure you want to publish this article?',
                                $data['Author']['id']));
                    else:
                        echo $this->Form->postLink(__('<i class="icon-off icon-large"></i>'),
                            array('action' => 'deactivate',$data['Author']['id']),
                            array('escape' => false, 'data-toggle'=>'tooltip', 'data-title' => 'Unpublish', 'class' => 'btn btn-xs btn-success'),
                            __('Are you sure you want to unpublish this article?',
                                $data['Author']['id']));
                    endif;
                    ?>
                    <a href="<?PHP echo Router::url(array("action"=>"edit", $data['Author']['id'])); ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-primary"><i class="icon-edit  icon-large"></i></a>
                    <?PHP
                    echo $this->Form->postLink(__('<i class="icon-trash icon-large"></i>'),
                        array('action' => 'delete',$data['Author']['id']),
                        array('escape' => false, 'data-toggle'=>'tooltip', 'title' => 'Delete', 'class' => 'btn btn-xs btn-danger'),
                        __('Are you sure you want to delete # %s?',
                            $data['Author']['id']));
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
<?php
$urladd = Router::url(array('action'=>'add'));
$mystring = <<<EOT
 $("#btnAdd").unbind('click').click(function(){
    location.href='{$urladd}';
    return false;
});
EOT;
$this->Js->buffer($mystring);
?>
