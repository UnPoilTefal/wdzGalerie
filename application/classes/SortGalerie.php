<?php
require_once 'init.php';

$data = $_POST['images'];
$galleryname = $_POST['galleryname'];
$galerieManager = new GalerieManager();
$galerieManager->sortGallery($galleryname, $data);

echo '<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
		<strong>Gallery status :</strong> Updated.</p>
	</div>';
?>