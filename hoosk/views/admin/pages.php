<?php echo $header; ?>
<style>
.form-controlsbutton {
	margin-top: 25px;
	}
 .form-actions a {
    position: relative;
    float: left;
    padding: 6px 12px;
    margin-left: -1px;
    line-height: 1.42857143;
    color: #337ab7;
    text-decoration: none;
    background: #fff;
    color: #666;
    border: 1px solid #ddd;
	border-radius: 3px;
	}
 .form-actions strong {
    position: relative;
    float: left;
    padding: 7px 12px;
    margin-left: -1px;
    line-height: 1.42857143;
    text-decoration: none;
    z-index: 3;
    color: #fff;
    cursor: pointer;
    background-color: #337ab7;
    border-color: #fff;
	border-radius: 3px;
	}
</style>
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
                <li class="active">
                    <i class="fa fa-fw fa-file"></i>
                    <a href="<?= BASE_URL?>/admin/pages">
                        <?php echo $this->lang->line('nav_pages_all'); ?> 
                    </a>
                </li>
            </ol>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="box box-info">
        <!--div class="box-header with-border">
            <h3 class="box-title">Filter By</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div-->
        <!-- /.box-header -->
	    <div class="box-body">
            <!--form action="<?php base_url()?>" method="post">
                <div class="row">
               
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Page</label>
                            <input type="text" id="Sea" name="page" class="form-control select2" placeholder="Search By Page Name">   
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-controlsbutton">
                           <input type="submit" id="" class="btn btn-sm btn-primary" value="Search">   
                           <input type="submit" id="" class="btn btn-sm btn-primary" value="Reset"> 
                        </div>
                    </div>
                </div>
            </form-->
  	     <div class="row">
      	    <div class="col-md-12">
			     <table id="pages-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>S.No </th>
                            <th><?php echo $this->lang->line('pages_table_page'); ?> </th>
                            <th><?php echo $this->lang->line('pages_table_updated'); ?> </th>
                            <th><?php echo $this->lang->line('pages_table_created'); ?> </th>
                            <th>Jumbotron</th>
                            <th>Search Widget</th>
                            <th class="td-actions"> </th>
                        </tr>
                    </thead>
                    <tbody>
<?php 
$pCount = 1;
    foreach ($pages as $p) { 
?>
		<tr>
            <td><?= $pCount ?></td>
		    <td><?= $p['navTitle'] ?></td>
            <td><?= $p['pageUpdated'] ?></td>
            <td><?= $p['pageCreated'] ?></td>
            <td>
                <a href="<?= BASE_URL.'/admin/pages/jumbo/'.$p['pageID'];?>" class="btn btn-small btn-primary">
                   <i class="fa fa-image"> </i>
                </a> 
            </td>
            <td> <button data-value="<?= $p['search_widget']?>" data-id="<?= $p['pageID']?>" class="btn search_widget btn-xs <?=$p['search_widget'] == 1?'btn-success':'btn-danger'?>"
                         data-toggle="tooltip" title="<?=$p['search_widget']== 1?'Hide':'Show'?>" data-placement="right"> <?= $p['search_widget'] == 1 ? 'Visible' : 'Hidden'  ?> </button></td>
            <td class="td-actions">
                <a href="<?= BASE_URL.'/'.$p['pageURL'] ?>" class="btn btn-xs btn-success" target="_blank">
                    <i class="fa fa-eye"> </i>
                </a> 
		        <a href="<?= BASE_URL.'/admin/pages/edit/'.$p['pageID']; ?>" class="btn btn-xs btn-success">
                    <i class="fa fa-pencil"></i>
                </a> 
		        <a data-toggle="modal" data-target="#ajaxModal" class="btn btn-danger btn-xs" href="<?= BASE_URL.'/admin/pages/delete/'.$p['pageID'];?>">
                    <i class="fa fa-remove"> </i>
                </a>
            </td>
        </tr>
<?php       
    $pCount ++;
    } 
?>
                    </tbody>
                </table>
<?php echo $this->pagination->create_links(); ?>
            </div><!-- /col --> 
         </div><!-- /row --> 
        </div><!-- /.box-body -->
     <div class="box-footer clearfix">
     </div>
    </div><!-- /.box-info -->
</div><!-- /.container-fluid -->
<!-- /container -->
<script>
    jQuery(document).ready(function () {
        $(document).on('click','.search_widget',function(){
            var id  = $(this).data('id');
            var res = $(this).data('value');
            res = res == 1 ? 0 : 1; // changed value to update database            
            $.ajax({
                url:base_url+'admin/pages/search_widget_status',
                type:'POST',
                data:{id:id,value:res},
                success:function (data) {                  
                        location.reload();                   
                }
            });
        });
    });
</script>
<?php echo $footer; ?>