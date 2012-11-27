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

			<div class='span4 offset2'>
				<h4>G&eacute;n&eacute;ration des miniatures :</h4>
				<div class="progress">
					<div class="bar" style="width: 0%;"
						max-perc='<?php echo count($lst_filename['lst_miniatures']);?>'></div>
				</div>
				<p>
					<a id='lancer' href='#'
						class="btn btn-primary">Lancer</a>
				</p>
			</div>
		</div>
	</div>