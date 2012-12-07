<div data-role="content">
	<div class="ui-grid-solo">
		<div class="ui-block-a"><h2>Liste des galeries</h2></div>
	</div>
   	<div class="ui-grid-a">
    <?php foreach ($lst_galeries as $rows):?>	
    	<?php $ligne_a = true;?>
       	<?php foreach ($rows as $galerie):?>
       	<?php if($ligne_a) { echo "<div class='ui-block-a'>";} else {echo "<div class='ui-block-b'>";}?>
			 <a data-role="button" href="<?php echo  base_url(index_page() . '/pages/view/' . $galerie->get_dir_name());?>" data-transition="flip">
		      <img  src="<?php if(is_null($galerie->get_hl_pic()) || $galerie->get_hl_pic()->get_thumb_url() === '') {echo 'http://placehold.it/210x110';} else { echo $galerie->get_hl_pic()->get_thumb_url();}?>">
		      <h3><?php echo $galerie->get_gallery_name(); ?></h3>
		      <p>Description de la galerie...</p>
             </a>
		</div>
		<?php $ligne_a = !$ligne_a;?>
        <?php endforeach;?>
    <?php endforeach;?>
   	</div>
	
</div><!-- /content -->