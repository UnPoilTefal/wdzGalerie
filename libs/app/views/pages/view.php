        <div class="container-fluid">
        	<!-- Main hero unit for a primary marketing message or call to action -->
            <div class='row-fluid'>
            	<div class="span2">
            	</div>
            	<div class="span10">
            	<div class='row-fluid'>
			            <div class="page-header">
			                <h4><?php echo $pagined_galerie['galerie']->get_gallery_name();?></h4>
			            </div>
			    </div>
	            </div>
            </div>
        
        	<div class="row-fluid">
				<div class="span2">
					<ul class="nav nav-list">
	  					<li class="nav-header">Galeries</li>
						<?php foreach ($lst_galeries as $curr_galerie):?>
						<li <?php if($curr_galerie->get_dir_name() == $pagined_galerie['galerie']->get_dir_name()) { echo 'class="active"';} ?>><a href="<?php echo  base_url(index_page() . '/pages/view/' . $curr_galerie->get_dir_name());?>"><?php echo $curr_galerie->get_gallery_name();?></a></li>
	  					<?php endforeach;?>
	 				</ul>
				</div>
			
				<div id='content' class="span10">
	        		<?php foreach ($pagined_galerie['pages'] as $num_page=>$page):?>
		        	<div <?php echo "id='page_".$num_page."'" . " class='page'"; if($num_page > 1) {echo "style='display: none;'";}?>>
						<?php foreach ($page['rows'] as $row):?> 
			        	<ul class="thumbnails">
						  <?php foreach ($row['images'] as $image):?>
						  <li class="span2">
						      <a class='thumbnail' rel='gallery' title='<?php echo $image->get_caption(); ?>' href='<?php echo $image->get_url(); ?>'><img class="fade" src="<?php echo $image->get_thumb_url();?>" alt="<?php echo $image->get_caption() ?>"></a>
						  </li>
						  <?php endforeach;?>
						</ul>
						<?php endforeach;?>
						<div><span class='badge'><?php echo $page['num_min'];?> - <?php echo $page['num_max'];?> / <?php echo $pagined_galerie['total_images'];?></span></div>
				 	</div>
				 	<?php endforeach;?>
			 	</div>
			</div>        
			 