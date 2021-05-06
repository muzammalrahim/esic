<?php echo $header; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?php echo $this->lang->line('cat_header'); ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                <i class="fa fa-dashboard"></i>
                	<a href="/admin"><?php echo $this->lang->line('nav_dash'); ?></a>
                </li>
                <li class="active">
                <i class="fa fa-fw fa-list"></i>
                	<a href="/admin/posts/categories"><?php echo $this->lang->line('cat_header'); ?></a>
                </li>
            </ol>
        </div>
    </div>
</div>
<div class="container-fluid">
  	<div class="row">
      	<div class="col-md-12">
			<table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th> <?php echo $this->lang->line('cat_table_category'); ?> </th>
                    <th class="td-actions"> </th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
					foreach ($categories as $c) {
						echo '<tr>';
						echo '<td>'.$c['categoryTitle'].'</td>';
						echo '<td class="td-actions"><a href="/admin/posts/categories/edit/'.$c['categoryID'].'" class="btn btn-small btn-success"><i class="fa fa-pencil"> </i></a> <a data-toggle="modal" data-target="#ajaxModal" class="btn btn-danger btn-small" href="'.BASE_URL.'/admin/posts/categories/delete/'.$c['categoryID'].'"><i class="fa fa-remove"></i></a></td>';
						echo '</tr>';
					} ?>
                </tbody>
              </table>
              <?php echo $this->pagination->create_links(); ?>
         </div>
          <!-- /colmd12 -->
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
<?php echo $footer; ?>