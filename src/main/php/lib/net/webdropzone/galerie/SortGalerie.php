<?php
require_once 'init.php';

$data = $_POST['images'];
$galleryname = $_POST['galleryname'];
sortGallery($galleryname, $data);

function sortGallery($galleryname, $data) {
	
	$exportDoc = new GalleryContent($galleryname);
	$imagesNodeList = $exportDoc->getImages()->getElementsByTagName('image');
	
	foreach ($imagesNodeList as $existingImage) {
	
		foreach($data as $image){
			$filename = $image['id'];
			$order = $image['order'];
	
			if ($existingImage->getAttribute('filename') == $filename) {
				$existingImage->setAttribute('order', $order);
			}
	
		}
	
	}
	$exportDoc->save();
	
}
echo '<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
		<strong>Gallery status :</strong> Updated.</p>
	</div>';
?>