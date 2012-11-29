        <div class="container-fluid">
        	<!-- Main hero unit for a primary marketing message or call to action -->
            <div class='row-fluid'>
            	<div class="span2">
            	</div>
            	<div class="span10">
            	<div class='row'>
			            <div class="page-header">
			                <h1><?php echo $pagined_galerie['gallery_name'];?></h1>
			            </div>
			    </div>
	            </div>
            </div>
        
        	<div class="row-fluid">
				<div class="span2">
					<ul class="nav nav-list">
	  					<li class="nav-header">Galeries</li>
						<?php foreach ($lst_galeries as $galerie):?>
						<li <?php if($galerie->get_dir_name() == $pagined_galerie['gallery_name']) { echo 'class="active"';} ?>><a href="<?php echo  base_url(index_page() . '/pages/view/' . $galerie->get_dir_name());?>"><?php echo $galerie->get_gallery_name();?></a></li>
	  					<?php endforeach;?>
	 				</ul>
				</div>
			
				<div class="span10">
        	
	        	<div class='row'>
					<div class="alert">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Warning!</strong> La galerie n'est pas disponible pour le moment.
					</div>
	        	
			 	</div>
			 </div>
			</div>        
			