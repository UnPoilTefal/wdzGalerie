        <div class="container">
			<div class="row">
	            <div class='span12'>
	            <div class="page-header">
	                <h2>Liste des galeries</h2>
	            </div>
				</div>
				
				<div class='span12'>
				<?php foreach ($lst_galeries as $rows):?>				
            	<ul class="thumbnails">
	            	<?php foreach ($rows as $galerie):?>
						<li class='span3'>
				            <div class="thumbnail">
	                    		<img class='img-polaroid' src="<?php if(is_null($galerie->get_hl_pic()) || $galerie->get_hl_pic()->get_thumb_url() === '') {echo 'http://placehold.it/210x110';} else { echo $galerie->get_hl_pic()->get_thumb_url();}?>">
		                    	<div class="caption">
		                    		<h4><?php echo $galerie->get_gallery_name(); ?></h4>
		                    		<p><a href='<?php echo  base_url(index_page() . '/pages/view/' . $galerie->get_dir_name());?>' class="btn btn-primary btn-block">Afficher</a></p>
		                    	</div>
	                    	</div>
	                    </li>
	            	<?php endforeach;?>
            	</ul>
            	<?php endforeach;?>
            	</div>
            </div>
