        <div class="container">

            <!-- Main hero unit for a primary marketing message or call to action -->
            <div class="hero-unit">
                <h1>Liste des galeries</h1>
                <p>Liste des galeries disponibles.</p>
                <p><a class="btn btn-primary btn-large">En savoir plus &raquo;</a></p>
            </div>

            <!-- Example row of columns -->
            <div class="row">
	            <?php foreach ($lst_galeries as $galerie):?>
	                <div class="span4">
	                    <h2><?php echo $galerie; ?></h2>
	                    <p>Affichage de la galerie <?php echo $galerie; ?></p>
	                    <p><img src="http://placehold.it/210x110" class="img-polaroid"></p>
	                    <p><?php echo "<a class='btn' href='" . base_url(index_page() . '/pages/view/' . $galerie) . "'>Afficher &raquo;</a>"; ?></p>
	                </div>
	            <?php endforeach;?>
            </div>
