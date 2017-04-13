<table class="table table-striped table-hover table-bordered dataTable">
    <thead>
    <tr>
        <th><?PHP echo $this->Paginator->sort('MediaUpload.filename', 'Filename'); ?></th>
        <th><?PHP echo $this->Paginator->sort('MediaUpload.created', 'Created'); ?></th>
        <th>Image</th>
        <th class="text-center"><i class="icon-bolt"></i> Actions</th>
    </tr>
    </thead>
    <tbody>
    <?PHP foreach($MediaUploads as $data): ?>
        <tr>
            <td><?PHP echo $data['MediaUpload']['filename']; ?></td>
            <td class="text-center"><?PHP echo $data['MediaUpload']['created']; ?></td>
            <td class="text-center"><img src="<?PHP echo $data['MediaUpload']['path']; ?>"/></td>
            <td class="text-center">
                <a href="javascript:void(0);" data-filename="<?PHP echo str_replace('.'.$data['MediaUpload']['ext'], '', $data['MediaUpload']['filename']); ?>" data-path="<?PHP echo $data['MediaUpload']['path']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-info btn-setter" data-original-title=""><i class="icon-eye-open"></i></a>
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
<script>
    function getUrlParam( paramName ) {
        var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' ) ;
        var match = window.location.search.match(reParam) ;

        return ( match && match.length > 1 ) ? match[ 1 ] : null ;
    }
    var funcNum = getUrlParam( 'CKEditorFuncNum' );

    $(document).ready(function(){
        $(".btn-setter").click(function(){
            var path = $(this).data('path');
            window.opener.CKEDITOR.tools.callFunction( funcNum, path, function() {
                // Get the reference to a dialog window.
                var element,
                    dialog = this.getDialog();
                // Check if this is the Image dialog window.
                if ( dialog.getName() == 'image' ) {
                    // Get the reference to a text field that holds the "alt" attribute.
                    element = dialog.getContentElement( 'info', 'txtAlt' );
                    // Assign the new value.
                    if ( element ){
                        element.setValue( $(".btn-setter").data('filename') );
                    }
                }
               return true;
            });

            window.close();
        });
    });
</script>