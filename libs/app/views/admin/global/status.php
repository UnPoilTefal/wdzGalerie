            <div class="container">
            
            <div class="row">
            <div class="page-header">
                <h1>Status de la galerie : <small><?php echo $gallery->get_gallery_name();?></small></h1>
            </div>
            </div>
			<div class="row">
				<ul class="nav nav-tabs">
				  <li>
				    <a href="<?php echo base_url(index_page() . "/admin/edit_gallery/" . $gallery->get_dir_name());?>">Informations</a>
				  </li>
				  <li><a href="<?php echo base_url(index_page() . "/admin/edit_images/" . $gallery->get_dir_name());?>">Images</a></li>
				  <li><a href='<?php echo base_url(index_page() . "/admin/status/" . $gallery->get_dir_name());?>'>Status</a></li>
				</ul>
			
			<table class="table table-bordered">
              <thead>
                <tr>
                  <th>Control</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
              	<?php foreach ($check_lst as $item):?>
                <tr <?php echo $item['class'];?>>
                  <td><?php echo $item['libelle'];?></td>
                  <td><?php echo $item['status'];?></td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            </div>
            