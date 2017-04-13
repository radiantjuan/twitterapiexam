<?PHP
$this->TomatoCrumbs->addCrumbs(
    'Posts',
    'javascript:void(0)',
    array()
);
?>

<h3 class="page-header page-header-top"><i class="icon-th-list"></i> Posts <button id="btnAdd" class="btn btn-primary btn-sm"><i class="icon-plus"></i> Add New</button></h3>

<div id="datatables_wrapper" class="dataTables_wrapper form-inline" role="grid">
        <div class="row" style="padding-left: 5px;">
            <a href="<?PHP echo Router::url(array('action'=>'index', 'status'=>false)); ?>">All</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
            <a href="<?PHP echo Router::url(array('action'=>'index', 'status'=>'published')); ?>">Published</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
            <a href="<?PHP echo Router::url(array('action'=>'index', 'status'=>'trash')); ?>">Trash</a>
        </div>
        
        <table class="table table-hover">
            <thead>
            <tr>
                <th><?PHP echo $this->Paginator->sort('Post.post_title', 'Title'); ?></th>
                <th><?PHP echo $this->Paginator->sort('Author.email', 'Author'); ?></th>
                <?PHP if(isset($this->request->named['status'])&&$this->request->named['status']!='trash'): ?>
                <th><?PHP echo $this->Paginator->sort('Post.post_status', 'Status'); ?></th>
                <?PHP endif; ?>
                <th>Tags</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <?PHP foreach($Posts as $data): ?>
                <tr class="data-row">
                    <td class="text-left">
                    	<?PHP echo $data['Post']['post_title']; ?>
                    	
                    </td>
                    <td class="text-left"><?PHP echo $data['Author']['email']; ?></td>
                    <?PHP if(isset($this->request->named['status'])&&$this->request->named['status']!='trash'): ?>
                    <td class="text-left">
                    	<?PHP if($data['Post']['post_status']=='draft'): ?>
                    		<span class="label label-default">
                    	<?PHP elseif($data['Post']['post_status']=='published'): ?>
                    		<span class="label label-success">
                    	<?PHP elseif($data['Post']['post_status']=='trash'): ?>
                    		<span class="label label-inverse">
                    	<?PHP endif; ?>
                    		<?PHP echo $data['Post']['post_status']; ?>
                    		</span>
                    </td>
                    <?PHP endif; ?>
                    <td class="text-left">
                        <?PHP $ctr=0;if($data['PostTag']): foreach($data['PostTag'] as $tags): ?>
                        	<?PHP $ctr++; if($ctr>1) echo ', '; ?>

                        	<a href="<?PHP echo Router::url(array("action"=>"index", 'tag' => $tags['Tag']['id'])); ?>"><?PHP echo $tags['Tag']['tag']; ?></a>
                        <?PHP endforeach; endif; ?>
                    </td>
                    <td class="text-left">
                    	<small>
                    	<?PHP if($data['Post']['post_status']=='draft'): ?>
                    		Last Modified
                    		<br/>
                    		<?PHP echo $data['Post']['post_modified']; ?>
                    	<?PHP elseif($data['Post']['post_status']=='published'): ?>
                    		Published
                    		<br/>
                    		<?PHP echo $data['Post']['post_published']; ?>
                    	<?PHP endif; ?>
                    	</small>
                    </td>
                </tr>

                <tr class="action" style="display: none;">
                    <td colspan="4">
                        <?PHP if(
                            ( !isset($this->request->named['status']) )
                            ||
                            (isset($this->request->named['status'])&&$this->request->named['status']!='trash')
                            ): ?>
                            <a href="<?PHP echo Router::url(array("action"=>"edit", $data['Post']['id'])); ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-primary"><i class="icon-edit icon-large"></i></a>
                            <?PHP
                            echo $this->Form->postLink(__('<i class="icon-trash  icon-large"></i>'),
                                array('action' => 'trash',$data['Post']['id']),
                                array('escape' => false, 'data-toggle'=>'tooltip', 'title' => 'Trash', 'class' => 'btn btn-xs btn-danger'),
                                __('Are you sure you want to trash that post?'));
                            ?>
                            <a href="<?PHP echo Router::url('/'.$data['Post']['permalink']); ?>" target="_blank" data-toggle="tooltip" title="Preview" class="btn btn-xs btn-success"><i class="icon-share icon-large"></i></a>
                        <?PHP else : ?>
                            <a href="<?PHP echo Router::url(array('action'=>'restore', 'status'=>$this->request->named['status'], $data['Post']['id'])); ?>" data-toggle="tooltip" title="Restore">Restore</a>
                        <?PHP endif; ?>
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

$("tr.data-row").mouseover(function(){
    $(this).next('tr.action').show();
});
$("tr.data-row").mouseout(function(){
    $(this).next('tr.action').hide();

    $(this).next('tr.action').unbind('mouseover').mouseover(function(){
        $(this).show();
    });
    $(this).next('tr.action').unbind('mouseout').mouseout(function(){
        $(this).hide();
    });
});
EOT;
$this->Js->buffer($mystring);
?>