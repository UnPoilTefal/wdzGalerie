<?php
class GalerieManager {

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
}