        <div class="container-fluid">
        	<!-- Main hero unit for a primary marketing message or call to action -->
            <div class='row-fluid'>
            	<div class="span2">
            	</div>
            	<div class="span10">
            	<div class='row'>
			            <div class="page-header">
			                <h1><?php echo $gallery->get_gallery_name();?></h1>
			            </div>
			    </div>
	            </div>
            </div>
        
        	<div class="row-fluid">
				<div class="span2">
					<ul class="nav nav-list">
	  					<li class="nav-header">Galeries</li>
						<?php foreach ($lst_galeries as $galerie):?>
						<li <?php if($galerie->get_dir_name() == $gallery->get_dir_name()) { echo 'class="active"';} ?>><a href="<?php echo  base_url(index_page() . '/pages/view/' . $galerie->get_dir_name());?>"><?php echo $galerie->get_gallery_name();?></a></li>
	  					<?php endforeach;?>
	 				</ul>
				</div>
			
				<div class="span10">
        	
	        	<div class='row'>
				<ul class="thumbnails">
				<?php $count = 0;?>
				  <?php foreach ($gallery->get_lst_images() as $image):?>
				  <?php $count++ ?>
				  <li class="span2">
				      <a class='thumbnail' rel='gallery' title='<?php echo $image->get_caption(); ?>' href='<?php echo $image->get_url(); ?>'><img class="fade" src="<?php echo $image->get_thumb_url();?>" alt="<?php echo $image->get_caption() ?>"></a>
				  </li>
				  <?php if($count === 6) {
				  	$count = 0;
				  	echo "</ul></div><div class='row'><ul class='thumbnails'>";
				  }
				  ?>
				  <?php endforeach;?>
				</ul>
			 </div>
			 </div>
			</div>        
			 