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
					<?php foreach ($lst_galeries as $galerie):?>
					<li><a href='<?php echo base_url(index_page() . "/admin/init/" . $galerie['dir_name']);?>'>Initialisation de <?php echo $galerie['gallery_name']; ?></a></li>
					<?php endforeach;?>
					</ul>
		        </div>
		        <div class="span5">
		          <h4>Organisation des images :</h4>
					<ul>
					<?php foreach ($lst_galeries as $galerie):?>
					<li><a href='<?php echo base_url(index_page() . "/admin/sort/" . $galerie['dir_name']);?>'>Organisation de <?php echo $galerie['gallery_name']; ?></a></li>
					<?php endforeach;?>
					</ul>
		        </div>
		        <div class="span5">
		          <h4>Status :</h4>
					<ul>
					<?php foreach ($lst_galeries as $galerie):?>
					<li><a href='<?php echo base_url(index_page() . "/admin/status/" . $galerie['dir_name']);?>'>Afficher le status de <?php echo $galerie['gallery_name']; ?></a></li>
					<?php endforeach;?>
					</ul>
		        </div>
		        
		      </div>
