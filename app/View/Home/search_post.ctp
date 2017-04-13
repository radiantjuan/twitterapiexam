<div class="container-fluid">
	<?php echo $this->element('nav'); ?>
	<div class="jumbotron">
	  <h1>Search for a blog post!</h1>
	  <form action="<?php echo Router::url(array('action'=>'search_post')); ?>" method="post">
			<div class="input-group">
				<span class="input-group-btn">
					<button class="btn btn-primary" type="submi"t><i class="glyphicon glyphicon-search"></i> Search</button>
				</span>
				<input type="text" name="query" class="form-control" placeholder="Search for...">
			</div><!-- /input-group -->
			<input type="checkbox" name="advancesearch" value="on"> Advance Search
			<div class="input-group advancesearch-container">
				<h3>Search By Date Post</h3>
				 <div class="col-md-6">
			 		<label for=".from">From</label>
					<input type="text" name="from" class="form-control from col-md-6 " placeholder="from..." >
				 </div>

				 <div class="col-md-6">
				 	<label for=".to">to</label>
					<input type="text" name="to" class="form-control to col-md-6 " placeholder="to.." >
				 </div>
			</div>
	  </form>
	</div>
</div>

<?php if (isset($data)): ?>
            
    <div class="container-fluid">
    <table id="search-results" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th></th>
                <th>Title</th>
                <th>Author</th>
                <th>Who Commented to the post?</th>
                <th>Published</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $key => $value): ?>
            <tr>
                <td><img src="<?php echo $value->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->thumbnail->source_url; ?>"></td>
                <td><a href="<?php echo Router::url('/post/'.$value->id."/".$value->slug); ?>"><?php echo $value->title->rendered; ?></a></td>
                <td><?php echo $value->_embedded->author[0]->name; ?></td>
                <td>
                    <?php foreach ($value->_embedded->replies[0] as $key => $replies): ?>
                        <ul>
                           <li>
                               <?php echo $replies->author_name; ?>
                           </li> 
                        </ul>
                    <?php endforeach; ?>
                </td>
                <td> <?php echo $value->date; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>


<?php endif; ?>


<?php

$mystring = <<<EOT
$( function() {


    $(document).ready(function(){
    	$('#search-results').DataTable({searching:false});
    });

	$('.advancesearch-container').hide();
	$('input[name="advancesearch"]').change(function(){
		if($('input[name="advancesearch"]:checked').val() == 'on'){
			$('.advancesearch-container').show('fast');	
		}else{
			$('.advancesearch-container').hide('fast');
		}

	});

    var dateFormat = "yy/mm/dd",
      from = $( ".from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 3
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( ".to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
EOT;

$this->Js->buffer($mystring);

?>