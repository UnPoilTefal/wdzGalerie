        <div class="container">

            <div class="row">
            <div class="page-header">
                <h1>Administration des galeries</h1>
            </div>
			</div>
			
            <div class="row">
            	<div class='span8 offset2'>
	            <table class="table table-striped table-bordered">
	              <thead>
	                <tr>
	                  <th>Galeries</th>
	                  <th>Edition</th>
	                </tr>
	              </thead>
	              <tbody>
	              	<?php foreach ($lst_galeries as $galerie):?>
	                <tr>
	                  <td><?php echo $galerie->get_gallery_name();?></td>
	                  <td><a class="btn btn-primary" href="<?php echo base_url(index_page() . "/admin/edit_gallery/" . $galerie->get_dir_name());?>"><i class="icon-cog icon-white"></i> Editer</a></td>
	                </tr>
	                <?php endforeach;?>
	                </tbody>
	            </table>
            </div>
            <!-- 
		        <div class="span4">
		        <div class='well well-small'>
		          <h4>Initialisation des fichiers XML :</h4>
					<ul>
					<?php foreach ($lst_not_avail_galeries as $galerie):?>
					<li><a href='<?php echo base_url(index_page() . "/admin/init/" . $galerie->get_dir_name());?>'>Initialisation de <?php echo $galerie->get_gallery_name(); ?></a></li>
					<?php endforeach;?>
					</ul>
		        </div>
		        </div>
		        <div class="span4">
		        <div class='well well-small'>
		          <h4>Organisation des images :</h4>
					<ul>
					<?php foreach ($lst_avail_galeries as $galerie):?>
					<li><a href='<?php echo base_url(index_page() . "/admin/sort/" . $galerie->get_dir_name());?>'>Organisation de <?php echo $galerie->get_gallery_name(); ?></a></li>
					<?php endforeach;?>
					</ul>
		        </div>
		        </div>
		        <div class="span4">
		        <div class='well well-small'>
		          <h4>Status :</h4>
					<ul>
					<?php foreach ($lst_galeries as $galerie):?>
					<li><a href='<?php echo base_url(index_page() . "/admin/status/" . $galerie->get_dir_name());?>'>Afficher pour <?php echo $galerie->get_gallery_name(); ?></a></li>
					<?php endforeach;?>
					</ul>
		        </div>
		        </div>
		        <div class="span4">
		        <div class='well well-small'>
		          <h4>Miniatures :</h4>
					<ul>
					<?php foreach ($lst_local_galeries as $galerie):?>
					<li><a href='<?php echo base_url(index_page() . "/admin/miniature/" . $galerie->get_dir_name());?>'>G&eacute;n&eacute;rer pour <?php echo $galerie->get_gallery_name(); ?></a></li>
					<?php endforeach;?>
					</ul>
		        </div>
		        </div>
		         -->
		      </div>
