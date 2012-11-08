            <div class="container">
            
            <div class="row">
            <div class="page-header">
                <h1>Status de la galerie : <?php echo $gallery_name;?></h1>
            </div>
            </div>
			<div class="row">
			<table class="table">
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
            