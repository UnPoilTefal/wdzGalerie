<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $title ?> - wdzGalerie</title>

<?php
echo link_tag('css/fullscreenstyle.css');
echo link_tag('css/design.css');
echo link_tag('css/ui-gallery/jquery-ui-1.9.0.custom.min.css');
?>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script src="<?php echo base_url('js/jquery.fullscreenslides.js')?>"></script>
<script src="<?php echo base_url('js/coreGallery.js')?>"></script>

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
	</head>

	<body>
		<div id="message">
			<div id="results" class="ui-widget"></div>
		</div>
