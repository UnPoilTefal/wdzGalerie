<script>
	$(document).ready(function(){
		initSlideShow();
		/*updateSize();	*/
		$( "#retour" ).button();
		$( "#retour" ).click(function( event ) {
			$(location).attr('href','<?=base_url(index_page());?>');
			event.preventDefault();
		});
		/*
		$(window).resize(function() {
			updateSize();
		});
		*/
	});

</script>