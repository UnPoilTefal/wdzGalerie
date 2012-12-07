            <div class="container">
            
            <div class="row">
            <div class="page-header">
                <h1>Informations de la galerie : <small><?php echo $gallery->get_gallery_name();?></small></h1>
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
				
				<form class="form-horizontal">
				  <div class="control-group">
				    <label class="control-label" for="galleryName">Nom de la galerie</label>
				    <div class="controls">
				      <input type="text" id="galleryName" value="<?php echo $gallery->get_gallery_name();?>">
				    </div>
				  </div>
				  <div class="control-group">
				    <label class="control-label" for="remoteGallery">Type de galerie</label>
				    <div class="controls">
				      <div id='remoteGallery' class="btn-group" data-toggle="buttons-radio">
						  <button type="button" class="btn btn-primary <?php if(!$gallery->is_remote_gallery()) {echo 'active';}?>">Locale</button>
						  <button type="button" class="btn btn-primary <?php if($gallery->is_remote_gallery()) {echo 'active';}?>">Distante</button>
					  </div>
				    </div>
				  </div>
				</form>
			
            </div>
            