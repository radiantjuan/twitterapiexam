<?PHP
$this->Html->css('TomatoCms./tagmanager/tagmanager', array('inline' => false));
$this->Html->script('TomatoCms./tagmanager/typeahead.bundle', array('inline' => false));
$this->Html->script('TomatoCms./tagmanager/tagmanager', array('inline' => false));

?>
<style>
	.form-box-header{
		padding: 10px !important;
	}
	.form-box-content{
		padding-top: 5px !important;
		padding-bottom: 5px !important;
	}
	.form-box .form-group{
		border-top: none !important;
		border-bottom: none !important;
	}

	/*typeahead*/
	.tt-dropdown-menu {
		width: 200px;
		margin-top: 12px;
		padding: 8px 0;
		background-color: #fff;
		border: 1px solid #ccc;
		border: 1px solid rgba(0, 0, 0, 0.2);
		-webkit-border-radius: 8px;
		-moz-border-radius: 8px;
		border-radius: 8px;
		-webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
		-moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
		box-shadow: 0 5px 10px rgba(0,0,0,.2);
	}

	.tt-suggestion {
	padding: 3px 20px;
	font-size: 18px;
	line-height: 24px;
	}

	.tt-suggestion.tt-is-under-cursor {
	color: #fff;
	background-color: #0097cf;
	}

	.tt-suggestion p {
	margin: 0;
	}
</style>
<?PHP
$this->TomatoCrumbs->addCrumbs(
    'Posts',
    Router::url(
        array('action'=>'index')
    ),
    array()
)->addCrumbs(
    'Edit',
    'javascript:void(0)'
);
?>

<h3 class="page-header page-header-top"><i class="icon-pencil"></i> Edit Post</h3>

<?PHP echo $this->BootstrapForm->create('Post'

	,array(
		'novalidate' => true,
	    'inputDefaults' => array(
            'div' => array(
                'class' => 'form-group'
            ),
            'label' => array(
                'class' => 'col-md-2 control-label'
            ),
            'between' => '<div class="col-md-6">',
            'after' => '</div>',
            'class' => 'form-control input-sm',
            'error' => array(
                'attributes' => array(
                    'class' => 'help-block',
                    'wrap'  => 'span'
                )
            )
        ),
        'class' => 'form-horizontal form-box',
        'role' => 'form',
	)
);
echo $this->BootstrapForm->hidden('Post.id');
echo $this->BootstrapForm->hidden('Post.post_status');
echo $this->BootstrapForm->hidden('Post.post_published');
?>


<div class="row">
    <div class="col-md-9">
		<div class="form-box-content">

    	<?PHP echo $this->BootstrapForm->input('Post.post_title',array(
        	'placeholder' => 'Enter title here',
        	'type' => 'text',
        	'label' => false,
        	'between' => '<div class="col-md-12 col-sm-12">',
        	'after' => '</div>',
        )); ?>
        <div class="form-group">
    		<div class="col-md-12 col-sm-12">
    			<strong>Permalink:</strong> <a target="_blank" href="#" id="permalink" data-base="<?PHP echo Router::url('/', true); ?>"><?PHP echo Router::url('/', true); ?></a>
				<a id="permalink-edit" href="#">&nbsp;&nbsp;<i class="icon-edit"></i></a>
    		</div>
    	</div>
        <?PHP echo $this->BootstrapForm->input('Post.permalink',array(
        	'placeholder' => 'Enter slug here',
        	'type' => 'text',
        	'label' => false,
        	'between' => '<div class="col-md-8 col-sm-12">',
        	'after' => '</div>',
			'div' => array(
				'id' => 'div-permalink',
				'style' => 'display: none;',
				'class' => 'form-group'
			),
			'data-active' => '0'
        )); ?>

        <?PHP echo $this->BootstrapForm->input('Post.post_content', array(
        	'label' => false,
            'type'    => "textarea",
            "class"   => 'ckeditor',
            'between' => '<div class="col-md-12 col-sm-12">'
        ));
        ?>

        <br/>
        <?PHP echo $this->BootstrapForm->input('Post.tags',array(
        	'placeholder' => 'Tags',
        	'class' => 'form-control tm-input tm-input-success tm-input-typeahead',
        	'type' => 'text',
        	'label' => false,
        	'between' => '<div class="col-md-12 col-sm-12">',
        	'after' => '<br/><em><small></small>Type tags in the input field, and separate them with enter, comma, or tab</em></div>',
        )); ?>

		<br/>
		<h4>SEO</h4>
		<?PHP echo $this->BootstrapForm->input('Post.seo_title', array(
			'title' => 'Title',
			'type' => 'text'
		));
		?>
		<?PHP echo $this->BootstrapForm->input('Post.seo_description', array(
			'title' => 'Title',
			'type' => 'textarea'
		));
		?>
		<?PHP echo $this->BootstrapForm->input('Post.seo_tags', array(
			'title' => 'Meta Tags',
			'type' => 'text'
		));
		?>

        </div>

    </div>
    <div class="col-md-3">
    	
    	<div class="form-horizontal form-box" style="margin-top: 10px !important;">
	        <h5 class="form-box-header">Publish</h5>
	        <div class="form-box-content">

	        <?PHP if($this->request->data['Post']['post_status']=='draft') : ?>
	        	<div class="form-group">
	        		<div class="col-md-12 col-sm-12">
	        			<?PHP echo $this->BootstrapForm->button('Save Draft', array(
	        					'name' => 'data[Button][save_draft]',
				        		'class' => 'btn btn-default btn-sm'
				        	)); ?>
	        		</div>
	        	</div>
	        <?PHP endif; ?>

	        	<?PHP if($this->request->data['Post']['post_status']!='draft') : ?>

	        	<?PHP echo $this->BootstrapForm->input('Post.post_status', array(
		        	'label' => 'Status',
		        	'options' => array(
		        		'published' => 'Published',
		        		'draft' => 'Draft' 
		        		),
		            'between' => '<div class="col-md-12 col-sm-12">'
		        ));
	        	?>

	        	<?PHP else: ?>

	        	<div class="form-group">
	        		<div class="col-md-12 col-sm-12">
	        			Status : Draft
	        		</div>
	        	</div>

	        	<?PHP endif; ?>

		        <?PHP if($this->request->data['Post']['post_published']): ?>
		        <div class="form-group">
	        		<div class="col-md-12 col-sm-12">
	        			<small>Published on: <strong><?PHP echo date("M d,Y @ H:i", strtotime($this->request->data['Post']['post_published'])); ?></strong></small>
	        		</div>
	        	</div>
		        <?PHP endif; ?>

			<?PHP if($this->request->data['Post']['post_status']=='draft') : ?>
	        	<div class="form-group">
	        		<div class="col-md-6 col-sm-6 text-left">
	        			<?PHP echo $this->BootstrapForm->button('Move To Trash', array(
	        					'name' => 'data[Button][move_to_trash]',
				        		'class' => 'btn btn-danger btn-sm'
				        	)); ?>
	        		</div>
	        		<div class="col-md-6 col-sm-6 text-right">
	        			<?PHP echo $this->BootstrapForm->button('Publish', array(
	        					'name' => 'data[Button][published]',
				        		'class' => 'btn btn-primary btn-sm'
				        	)); ?>
	        		</div>
	        	</div>
	        <?PHP endif; ?>
	        <?PHP if($this->request->data['Post']['post_status']=='published') : ?>
	        	<div class="form-group">
	        		<div class="col-md-6 col-sm-6 text-left">
	        			<?PHP echo $this->BootstrapForm->button('Move To Trash', array(
	        					'name' => 'data[Button][move_to_trash]',
				        		'class' => 'btn btn-danger btn-sm'
				        	)); ?>
	        		</div>
	        		<div class="col-md-6 col-sm-6 text-right">
	        			<?PHP echo $this->BootstrapForm->button('Update', array(
	        					'name' => 'data[Button][update]',
				        		'class' => 'btn btn-primary btn-sm'
				        	)); ?>
	        		</div>
	        	</div>
	        <?PHP endif; ?>

	        	<h5 class="form-box-header">Layout</h5>
		        <div class="form-box-content">
		        	<?PHP echo $this->BootstrapForm->input('Post.post_layout',array(
			        	'options' => TomatoFrontendLayout::getLayouts(),
			        	'label' => false,
			        	'between' => '<div class="col-md-12 col-sm-12">'
			        )); ?>
		        </div>
            </div>
	    </div>

    </div>
</div>

<?PHP echo $this->BootstrapForm->end(null); ?>

<?php
$urlBack = Router::url(array('action'=>'index'));
$ajaxUrlTag = Router::url(array('action'=>'get_tags'));
$varSlugGenerator = Router::url(array('action'=>'generate_slug'));
$tags = json_encode($tags);

$mystring = <<<EOT
$("#btnCancel").on('click', function(e){
    location.href='{$urlBack}';
    return false;
});

var Tags = new Bloodhound({
	datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	limit: 10,
	prefetch: {
		ttl: 1,
		url: '{$ajaxUrlTag}',
		filter: function (list) {
			return $.map(list, function (tag) {
				return { name: tag };
			});
		}
	}
});

Tags.clearPrefetchCache();
Tags.initialize(true);

var tagApi = $(".tm-input.tm-input-typeahead").tagsManager({
	hiddenTagListName: 'data[Tag][tag_list]',
	prefilled: {$tags} 
});

$(".tm-input.tm-input-typeahead").typeahead(null, {
	name: 'Tags',
	displayKey: 'name',
	source: Tags.ttAdapter()
}).on('typeahead:selected', function (e, d) {
	tagApi.tagsManager("pushTag", d.name);
});

var oldData;

$("#PostPostTitle").focus(function(){

	oldData = $(this).val();
	console.log("oldData => " + oldData);

});

$("#PostPostTitle").blur(function(){

	var _val = $(this).val();

	if( oldData == _val ){
		return false;
	}
	
	if( parseInt( $("#PostPermalink").data('active') ) == 1 ){
		return true;
	}

	$.ajax({
		url : '{$varSlugGenerator}/' + encodeURIComponent(_val),
		success : function(ret){
			if( ret.slug ){
				var base = $("#permalink").data('base');
				$("#permalink").html(base+ret.slug);
				$("#permalink").attr('href',base+ret.slug);
				$("#PostPermalink").val(ret.slug);
			}
		}
	});

	return true;
});

$("#PostPermalink").blur(function(){

	var _this = $(this);
	console.log( _this.val() );
	
	$.ajax({
		url : '{$varSlugGenerator}/' + encodeURIComponent(_this.val()),
		success : function(ret){
			if( ret.slug ){
				var base = $("#permalink").data('base');
				$("#permalink").html(base+ret.slug);
				$("#permalink").attr('href',base+ret.slug);
				$("#PostPermalink").val(ret.slug);
			}
		}
	});

	return true;

});

$("#permalink").html($("#permalink").data('base')+$("#PostPermalink").val());
$("#permalink").attr('href',$("#PostPermalink").val());

$("#PostPermalink").blur(function(){

	var _this = $(this);
	console.log( _this.val() );
	
	$.ajax({
		url : '{$varSlugGenerator}/' + encodeURIComponent(_this.val()),
		success : function(ret){
			if( ret.slug ){
				var base = $("#permalink").data('base');
				$("#permalink").html(base+ret.slug);
				$("#permalink").attr('href',base+ret.slug);
				$("#PostPermalink").val(ret.slug);
			}
		}
	});

	return true;

});
$("#PostPermalink").trigger('blur');

$("#permalink-edit").click(function(evt){
	evt.preventDefault();
	
	$("#div-permalink").show();
	$("#PostPermalink").data('active', '1');
	console.log( $("#PostPermalink").data('active') );
});
EOT;
?>
<?PHP $this->Js->buffer($mystring); ?>