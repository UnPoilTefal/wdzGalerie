<script>
$(document).ready(function(){
	
	$("#lancer").click(function( event ) {
				$(this).button('loading');
	            var me = $('.progress .bar');
	            var max_perc = 100;
	            var url = '<?php echo base_url(index_page().'/admin/genminiature');?>';
	            var perc = me.attr("max-perc");
	            if(perc>0) {
					var current_perc = 0;
		            var lst_filename = new Array("<?php echo implode('","', $lst_filename['lst_miniatures']);?>");
					
		            $.each(lst_filename, function() {
						var filename = escape(this);
						var	galleryname = '<?php echo $galerie->get_dir_name(); ?>';
						var current_url = url + "/" + galleryname + "/" + filename;
						
	                  	$.ajaxSetup({'async': false});
	                	$.post(current_url , '', function(data) {
	                        //$('#progress_bar').stopTime('statusLog'); //long operation is finished - stop the timer
	                    });
	                    current_perc += 1/perc*max_perc;
	                    me.css('width', (current_perc)+'%');
		                
		                me.text(Math.floor(current_perc)+'%');
		            });
	            } else {
		           $("#message").append("<div class='alert'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Warning!</strong> Il n'y a aucune miniature à generer !</div>"); 
	            }
		event.preventDefault();
		$("#message").append("<div class='alert alert-block alert-success fade in'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Succ&egrave;s : </strong> Le traitement des miniatures est terminé</div>");
		setTimeout(function(){
			$('#lancer').button('reset');
			me.css('width', '0%');	
			me.text('');	
		}, 3000
		);
		
		
		
		
	});

});


</script>
