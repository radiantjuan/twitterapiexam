<?PHP

$mystring = <<<EOT

initialPage = 3;

EOT;

$this->Js->buffer($mystring);
?>
<div class="main content-wrapper" role="main">
	<!-- CONTENT NAVIGATION -->
	<?PHP echo $this->element('FrontEndDesktop.navigator'); ?>

	<span class="flying-image"></span>

	<!-- CONTENT SCRAPBOOK -->
	<div class="scrapbook-wrapper scrapbook-item scrapbook-inner">
	    <div class="flipbook-viewport">
	    	<div class="container">
	    		<div class="flipbook inner">
	    			<div class="page cover-journey">
	    			</div>
	    			<div class="double behind-journey" id="behind_journey">
	    				<div class="col-wrapper">
		    				<div class="col-left">
		    				</div>
		    				<div class="col-right">
		    				</div>
	    				</div>
	    				<div class="col-wrapper">
	    					<div class="col-left">
	    					</div>
	    					<div class="col-right">
	    					</div>
	    				</div>
	    			</div>
	    			<!-- END OF JOIN JOURNEY -->
	    		</div>
	    		<!-- END OF FLIPBOOK -->
	    	</div>
	    	<!-- END OF CONTAINER -->
	    </div>
	    <!-- END OF FLIPBOOK VIEWPORT -->
	</div>

</div>