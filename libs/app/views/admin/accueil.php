        <div class="container">

            <div class="row">
            <div class="page-header">
                <h1>Administration des galeries</h1>
            </div>
			</div>
			
            <div class="row">
		        <div class="span5">
		          <h4>Initialisation des fichiers XML :</h4>
					<ul>
					<?php foreach ($lst_not_avail_galeries as $galerie):?>
					<li><a href='<?php echo base_url(index_page() . "/admin/init/" . $galerie->get_dir_name());?>'>Initialisation de <?php echo $galerie->get_gallery_name(); ?></a></li>
					<?php endforeach;?>
					</ul>
		        </div>
		        <div class="span5">
		          <h4>Organisation des images :</h4>
					<ul>
					<?php foreach ($lst_avail_galeries as $galerie):?>
					<li><a href='<?php echo base_url(index_page() . "/admin/sort/" . $galerie->get_dir_name());?>'>Organisation de <?php echo $galerie->get_gallery_name(); ?></a></li>
					<?php endforeach;?>
					</ul>
		        </div>
		        <div class="span5">
		          <h4>Status :</h4>
					<ul>
					<?php foreach ($lst_galeries as $galerie):?>
					<li><a href='<?php echo base_url(index_page() . "/admin/status/" . $galerie->get_dir_name());?>'>Afficher le status de <?php echo $galerie->get_gallery_name(); ?></a></li>
					<?php endforeach;?>
					</ul>
		        </div>
		        <div class="span5">
		          <h4>Miniatures :</h4>
					<ul>
					<?php foreach ($lst_local_galeries as $galerie):?>
					<li><a href='<?php echo base_url(index_page() . "/admin/miniature/" . $galerie->get_dir_name());?>'>G&eacute;n&eacute;rer les miniatures de <?php echo $galerie->get_gallery_name(); ?></a></li>
					<?php endforeach;?>
					</ul>
		        </div>
		        
		      </div>
