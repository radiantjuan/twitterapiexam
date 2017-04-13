<nav class="navbar navbar-default">
  <div class="container-fluid">
	<div class="navbar-header">
	  <a class="navbar-brand" href="#"><img src="https://s3-ap-southeast-1.amazonaws.com/kalibrr-company-assets/logos_YFPVJTTFBDUCLR4C6L88-560cd529.png" style="width: 100px;"></a>
	</div>
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	  <ul class="nav navbar-nav">
		<li class="blog"><a href="<?php echo Router::url('/'); ?>">Blog <span class="sr-only">(current)</span></a></li>
		<li class="search"><a href="<?php echo Router::url('/search'); ?>">Search</a></li>
	</div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<?php

$here = $this->request->url;

$mystring = <<<EOT
	$(document).ready(function(){
		var here = '{$here}';
		switch(here){
			case "search":
				$('.navbar-nav > li').removeClass('active');
				$('.search').addClass('active');
			break;
			default:
				$('.navbar-nav > li').removeClass('active');
				$('.blog').addClass('active');
			break;
		}
	});
EOT;

$this->Js->buffer($mystring);

?>