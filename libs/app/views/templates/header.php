<!DOCTYPE html>
<html lang="fr">
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

	</head>

	<body>
		<div id="message">
			<div id="results" class="ui-widget"></div>
		</div>
