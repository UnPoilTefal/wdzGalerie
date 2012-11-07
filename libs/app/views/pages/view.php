        <div class="container">
            <!-- Main hero unit for a primary marketing message or call to action -->
            <div class="page-header">
                <h1><?php echo $gallery['name'];?></h1>
            </div>
        	
        	<div class='row-fluid'>
				<ul class="thumbnails">
				  <?php foreach ($gallery['lst_images'] as $image):?>
				  <li class="span3 image">
				      <a class='thumbnail' rel='gallery' title='<?php echo $image["caption"]; ?>' href='<?php echo $image["src"]; ?>'><img class="fade" src="<?php echo $image['thumb'];?>" alt="<?php echo $image['caption']; ?>"></a>
				  </li>
				  <?php endforeach;?>
				</ul>
			 </div>
