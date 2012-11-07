        <div class="container">

            <!-- Main hero unit for a primary marketing message or call to action -->
            <div class="hero-unit">
                <h1>Administration des galeries</h1>
            </div>

            <div class="row">
		        <div class="span6">
		          <h2>Initialisation des fichiers XML :</h2>
					<ul>
					<?php foreach ($lst_galeries as $galerie):?>
					<li><a href='<?php echo base_url(index_page() . "/admin/init/" . $galerie);?>'>Initialisation de <?php echo $galerie; ?></a></li>
					<?php endforeach;?>
					</ul>
		        </div>
		        <div class="span6">
		          <h2>Organisation des images :</h2>
					<ul>
					<?php foreach ($lst_galeries as $galerie):?>
					<li><a href='<?php echo base_url(index_page() . "/admin/sort/" . $galerie);?>'>Organisation de <?php echo $galerie; ?></a></li>
					<?php endforeach;?>
					</ul>
		        </div>
		      </div>
