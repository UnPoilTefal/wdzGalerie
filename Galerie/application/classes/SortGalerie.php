<?php

$data = $_POST['images'];
$galleryname = $_POST['galleryname'];
sortGallery();

function sortGallery() {
	
	$exportDoc = new GalleryContent($galleryName);
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
	
}
echo "Updated";
?>