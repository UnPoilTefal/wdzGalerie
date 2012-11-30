
<script>
	$(document).ready(function(){
		$( "#retour" ).button();
		$( "#retour" ).click(function( event ) {
			$(location).attr('href','<?=base_url(index_page().'/admin/accueil');?>');
			event.preventDefault();
		});
	});

</script>

<div id="main">
	<div class='.ui-widget-content'>Initialisation de la galerie : <?php echo $result; ?></div>
	<div id="footer">
		<button id="retour">Retour</button>
	</div>
	<br class="clear" />
</div>
