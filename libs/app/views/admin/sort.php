<script type="text/javascript">
	$(document).ready(function(){

		$('#container').sortable({
			handle: 'img',
			cursor : 'move',
			placeholder : 'placeholder',
			//forcePlaceholderSize : true, 
			opacity : 0.4,
			stop : function(event, ui) {
				saveState();
			}
		});
		$('#container').disableSelection();
		$( "#retour" ).button();
		$( "#retour" ).click(function( event ) {
			$(location).attr('href','<?=base_url(index_page());?>');
			event.preventDefault();
		});

		function saveState() {
			var chargement = '<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span><strong>Gallery status :</strong> Saving...</p></div>';
			var items = [];
			// traverse all column div and fetch its id and its item detail. 
				$(".image").each(function(i) { // here i is the order, it start from 0 to...
					var image = {
						id : $('img', this).attr('rel'),
						order : i +1
					}
					items.push(image);
				});
			$("#results").html(chargement).show();
			var erreur = '<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Gallery status :</strong> Error during sort action.</p></div>';
			var shortorder = {
					images : items,
					galleryname : '<?php echo $galleryname; ?>'
			};
			$.ajax({
				url : '<?php echo base_url(index_page() . '/admin/sort_galerie');?>',
				async : false,
				data : shortorder,
				dataType : "html",
				type : "POST",
				success : function(html) {
					$("#results").html(html).delay(3000).fadeOut();
					
				},
				error: function(){  
					$("#results").html(erreur).delay(3000).fadeOut();
				  }
			});

		}
		
	});	
</script>
	<div id="main">
	<ul id="container" ><?=$this->displaycontent->displaySortGallery($galleryname); ?></ul>
	<div id="footer">
		<button id="retour">Retour</button>
	</div>
	<br class="clear"/>
	</div>
