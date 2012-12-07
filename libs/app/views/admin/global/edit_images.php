            <div class="container">
            
            <div class="row">
            <div class="page-header">
                <h1>Informations sur les images de la galerie : <small><?php echo $gallery->get_gallery_name();?></small></h1>
            </div>
            </div>
			<div class="row">
				<ul class="nav nav-tabs">
				  <li>
				    <a href="<?php echo base_url(index_page() . "/admin/edit_gallery/" . $gallery->get_dir_name());?>">Informations</a>
				  </li>
				  <li><a href="<?php echo base_url(index_page() . "/admin/edit_images/" . $gallery->get_dir_name());?>">Images</a></li>
				  <li><a href='<?php echo base_url(index_page() . "/admin/status/" . $gallery->get_dir_name());?>'>Status</a></li>
				</ul>
			</div>