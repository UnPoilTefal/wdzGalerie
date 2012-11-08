        <div class="container">

            <!-- Main hero unit for a primary marketing message or call to action -->
            <div class="page-header">
                <h2>Liste des galeries</h2>
            </div>

            <!-- Example row of columns -->
            <div class="row">
	            <?php foreach ($lst_galeries as $galerie):?>
	                <div class="span4">
	                    <h4><?php echo $galerie; ?></h4>
	                    <a href='<?php echo  base_url(index_page() . '/pages/view/' . $galerie);?>'><img src="http://placehold.it/210x110" class="img-polaroid"></a>
	                </div>
	            <?php endforeach;?>
            </div>
