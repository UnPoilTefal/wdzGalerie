<div class="container">
	<div class="row">
		<div class="page-header">
			<h2>
				Cr&eacute;ation des miniatures de la galerie
				<?php echo $galerie->get_gallery_name();?>
			</h2>
		</div>
		<!-- Example row of columns -->

		<div class="row">

			<div class='span5 offset2'>
				<h4>G&eacute;n&eacute;ration des miniatures :</h4>
				<div id='message'></div>
				<div class="progress">
					<div class="bar" style="width: 0%;"
						max-perc='<?php echo count($lst_filename['lst_miniatures']);?>'></div>
				</div>
				<button id='lancer' type="button" data-loading-text="Traitement en cours..." class="btn btn-primary" >Lancer</button>
			</div>
		</div>
	</div>