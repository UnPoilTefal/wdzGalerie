
<script>
	$(document).ready(function(){
		$( "#retour" ).button();
		$( "#retour" ).click(function( event ) {
			$(location).attr('href','<?=base_url(index_page());?>');
			event.preventDefault();
		});
	});

</script>

<div id="main">
	<div>Fichier g�n�r� : <?= $result ?></div>
	<div id="footer">
		<button id="retour">Retour</button>
	</div>
	<br class="clear" />
</div>
