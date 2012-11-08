        <div class="container-fluid">
        	<!-- Main hero unit for a primary marketing message or call to action -->
            <div class='row-fluid'>
            	<div class="span2">
            	</div>
            	<div class="span10">
            	<div class='row'>
			            <div class="page-header">
			                <h1><?php echo $gallery['name'];?></h1>
			            </div>
			    </div>
	            </div>
            </div>
        
        	<div class="row-fluid">
				<div class="span2">
					<ul class="nav nav-list">
	  					<li class="nav-header">Galeries</li>
						<?php foreach ($lst_galeries as $galerie):?>
						<li <?php if($galerie == $gallery['name']) { echo 'class="active"';} ?>><a href="<?php echo  base_url(index_page() . '/pages/view/' . $galerie);?>"><?php echo $galerie;?></a></li>
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
			