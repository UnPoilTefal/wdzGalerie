<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php require_once 'application/classes/init.php';
$dispContent = new DisplayContent();
$galleryName = $_REQUEST['galleryname'];
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/design.css" type="text/css" rel="stylesheet"></link>
<link href="css/ui-gallery/jquery-ui-1.9.0.custom.min.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>

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
			$(location).attr('href','index.php');
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
					galleryname : '<?=$galleryName?>'
			};
			$.ajax({
				url : 'application/classes/SortGalerie.php',
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
</head>
<body>
	<div id="message">
		<div id="results" class="ui-widget"></div>
	</div>
	<div id="main">
	<ul id="container" ><?=$dispContent->displaySortGallery($galleryName); ?></ul>
	<div id="footer">
		<button id="retour">Retour</button>
	</div>
	<br class="clear"/>
	</div>
</body>
</html>
