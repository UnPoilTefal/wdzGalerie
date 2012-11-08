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
					<li><a href='<?php echo base_url(index_page() . "/admin/init/" . $galerie);?>'>Initialisation de <?php echo $galerie; ?></a></li>
					<?php endforeach;?>
					</ul>
		        </div>
		        <div class="span5">
		          <h4>Organisation des images :</h4>
					<ul>
					<?php foreach ($lst_galeries as $galerie):?>
					<li><a href='<?php echo base_url(index_page() . "/admin/sort/" . $galerie);?>'>Organisation de <?php echo $galerie; ?></a></li>
					<?php endforeach;?>
					</ul>
		        </div>
		        <div class="span5">
		          <h4>Status :</h4>
					<ul>
					<?php foreach ($lst_galeries as $galerie):?>
					<li><a href='<?php echo base_url(index_page() . "/admin/status/" . $galerie);?>'>Afficher le status de <?php echo $galerie; ?></a></li>
					<?php endforeach;?>
					</ul>
		        </div>
		        
		      </div>
