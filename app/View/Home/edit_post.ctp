<div class="container-fluid">
	<?php echo $this->element('nav'); ?>
	<div class="jumbotron">
		<form method="post">
			<label>Title: </label>
			<h1><input type="text" class="form-control" name="title" value="<?php echo $data->title->rendered; ?>"></h1>
			<span class="label label-info">By: <?php echo $data->_embedded->author[0]->name; ?></span>
			<span class="label label-info">Published: <?php echo $data->date; ?></span>
			<div style="text-align: center; margin-top: 20px;margin-bottom: 20px;">
				<img src="<?php echo $data->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->full->source_url; ?>">
			</div>
			<textarea id="blog-content" name="blog-content" class="form-control" rows="30">
				<?php echo $data->content->rendered; ?>
			</textarea>
			<button type="submit" class="btn btn-success" style="text-align: center;">Update Post</button>
		</form>
	</div>
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Comments:</h3>
	  </div>
	  <div class="panel-body">
	  	<div class="container-fluid">
	  	
		  <?php foreach ($data->_embedded->replies[0] as $key => $replies): ?>
		  	<div class="row">
			  	<div class="col-md-2">
			  		<img src="<?php echo $replies->author_avatar_urls->{'48'}; ?>">
			  	</div>
			  	<div class="col-md-10">
			  		<h5><?php echo $replies->author_name; ?></h5>
			  		<small><?php echo $replies->date; ?></small>
			  		<p><?php echo $replies->content->rendered; ?></p>
			  	</div>
		  	</div>
		  <?php endforeach ?>
	  	</div>
	  </div>
	</div>
</div>

<script type="text/javascript">
	CKEDITOR.replace( 'blog-content' );
</script>