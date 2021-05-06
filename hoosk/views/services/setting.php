<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?php echo $this->lang->line('pages_header'); ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>
                    <a href="<?= BASE_URL?>/admin">
                        <?php echo $this->lang->line('nav_dash'); ?>
                    </a>
                </li>
                <li>
                    <i class="fa fa-cogs"></i>
                    <a href="#">
                        Setting
                    </a>
                </li>
                <li class="active">
                    <i class="fa fa-fw fa-file"></i>
                    <a href="<?= BASE_URL?>/admin/setting/services">
                        Services
                    </a>
                </li>
            </ol>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Services Setting</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
	    <div class="box-body">
  	     <div class="row">
      	    <div class="col-md-12">
                <table id="pages-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Service</th>
                            <th>Color</th>
                            <th class="td-actions"> </th>
                        </tr>
                    </thead>
                    <tbody>
            <?php foreach ($labels as $label) { ?>
                    <tr>
                        <td><?= $label['id']; ?></td>
                        <td><?= $label['label']; ?></td>
                        <td><?= $label['color']; ?></td>
                        <td class="td-actions">
                            <a href="<?= BASE_URL.'/admin/setting/services/'.$label['id']; ?>" class="btn btn-small btn-success">
                                <i class="fa fa-pencil"></i>
                            </a> 
                        </td>
                    </tr>
            <?php } ?>
                    </tbody>
                </table>
            </div><!-- /col --> 
         </div><!-- /row --> 
        </div><!-- /.box-body -->
     <div class="box-footer clearfix">
     </div>
    </div><!-- /.box-info -->
</div><!-- /.container-fluid -->
