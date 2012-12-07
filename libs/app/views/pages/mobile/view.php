<div data-role="content">
<?php foreach ($pagined_galerie['pages'] as $num_page=>$page):?>
<?php if($pagined_galerie['num_by_row'] <= 2) { $grid = 'a'; } elseif($pagined_galerie['num_by_row'] == 3) { $grid = 'b';} elseif($pagined_galerie['num_by_row'] == 4) { $grid = 'c';} else { $grid = 'd';}?>
<div class="ui-grid-<?php echo $grid;?>">
	<?php foreach ($page['rows'] as $row):?> 
		<?php $ligne = 'a' ?>
		<?php foreach ($row['images'] as $image):?>
			<div class="ui-block-<?php echo $ligne;?>">
			<a rel='gallery' title='<?php echo $image->get_caption(); ?>' href='<?php echo $image->get_url(); ?>'><img class="fade" src="<?php echo $image->get_thumb_url();?>" alt="<?php echo $image->get_caption() ?>"></a></div>
			<?php if($ligne === 'a') { $ligne = 'b';} elseif($ligne === 'b') { $ligne = 'c';} elseif($ligne === 'c') { $ligne = 'd';} elseif($ligne === 'd') { $ligne = 'a';} ?>
		<?php endforeach;?>
	<?php endforeach;?>
</div>
<?php endforeach;?>
</div><!-- /content -->