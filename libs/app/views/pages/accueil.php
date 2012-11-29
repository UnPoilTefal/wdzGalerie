        <div class="container">
			<div class="row">
	            <div class="page-header">
	                <h2>Liste des galeries</h2>
	            </div>
			<!-- Example row of columns -->
				<?php $count = 0;?>
				<div class="row-fluid">
            	<ul class="thumbnails">
	            	<?php foreach ($lst_galeries as $galerie):?>
					<?php $count++;?>
						<li class="span3">
				            <div class="thumbnail">
				            	
	                    		<img src="<?php if(is_null($galerie->get_hl_pic()) || $galerie->get_hl_pic()->get_thumb_url() === '') {echo 'http://placehold.it/210x110';} else { echo $galerie->get_hl_pic()->get_thumb_url();}?>">
		                    	<div class="caption">
		                    		<h4><?php echo $galerie->get_gallery_name(); ?></h4>
		                    		<p><a href='<?php echo  base_url(index_page() . '/pages/view/' . $galerie->get_dir_name());?>' class="btn btn-primary">Afficher</a></p>
		                    	</div>
	                    	</div>
	                    </li>
	                 	<?php if($count === 4) {
				  	 		$count = 0;
				  			echo "</ul></div><div class='row-fluid'><ul class='thumbnails'>";
				  		}
				  		?>
	            	<?php endforeach;?>
            	</ul>
            	</div>
            </div>
