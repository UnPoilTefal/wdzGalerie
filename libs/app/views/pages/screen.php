	<script>
	$(document).ready(function(){
		initSlideShow();
		updateSize();	
		$( "#retour" ).button();
		$( "#retour" ).click(function( event ) {
			$(location).attr('href','<?=base_url(index_page());?>');
			event.preventDefault();
		});
		$(window).resize(function() {
			updateSize();
		});
	});

		</script>
<div id="main">
		<ul id="container" ><?=$this->displaycontent->displayGallery($galleryname); ?>
		</ul>
		<div id="footer">
			<button id="retour">Retour</button>
		</div>
		<br class="clear"/>
		</div>
