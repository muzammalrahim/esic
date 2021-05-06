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
    .btn{
        float: left !important;
        margin-right: 2px !important;
    }
    .td-actions .btn {
        margin: 2px !important;
        padding: 0px 2px !important;
    }
    span.user-role-label-block {
        background-color: #337ab7;
        border-color: #2e6da4;
        color: #fff;
        padding: 2px 5px;
        margin: 0px 5px;
        font-size: 12px;
        border-radius: 3px;
        vertical-align: middle;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?php echo $this->lang->line('user_header'); ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                <i class="fa fa-dashboard"></i>
                	<a href="<?= BASE_URL.'/admin'?>"><?php echo $this->lang->line('nav_dash'); ?></a>
                </li>
                <li class="active">
                <i class="fa fa-fw fa-user"></i>
                	<a href="<?= BASE_URL.'/admin/users'?>"><?php echo $this->lang->line('user_header'); ?></a>
                </li>
            </ol>
        </div>
    </div>
</div>
  
<div class="container-fluid">
  	<div class="row">
      	<div class="col-md-12">
            <form method="post" action="<?= BASE_URL.'/admin/users/email';?>">
			<table id="users-table" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>          
                      	 <select name="example1_length" aria-controls="example1" class="form-control input-sm">
                             <option value="">Send Email</option>
                         </select>
                    </th>
                    <th>
                        <button class="btn btn-primary btn-small">Send</button>
                    </th>
                </tr>
                  <tr>
                    <th>
                       <input type="checkbox" name="select_all" class="checkbox" id="select_all">
                    </th>
                    <th> 
                        <?=$this->lang->line('user_username'); ?> 
                    </th>
                    <th> 
                        Role 
                    </th>
                    <th> 
                        <?= $this->lang->line('user_email'); ?> 
                    </th>
                    <th class="td-actions">Actions  </th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user) { 
                    $UserRoleLabels = getAllUserRolesLabels($this,$user['userID']);
                ?>
				    <tr>
                        <td style="width:50px;white-space: nowrap"> 
                            <input type="checkbox" name="checked_id[]" class="checkbox" value="<?= $user['email'] ?>" >
                        </td>
						<td style="width:50px;white-space: nowrap"> 
                        <?= $user['userName'];?>
                        </td>
                        <td>
                       <?php 
                            if(is_array($UserRoleLabels) && !empty($UserRoleLabels)) {
                                foreach ($UserRoleLabels as $key => $UserRoleLabel) { 
                        ?>
                            <span class="user-role-label-block">
                                <?= $UserRoleLabel;?>
                            </span>

                        <?php 

                                }
                            }
                        ?>
                        </td>
						<td><?= $user['email'];?></td>
						<td class="td-actions" colspan="2">
                            <form method="post" action="<?= BASE_URL.'/admin/users/email';?>">
                                 <input type="hidden" name="emailss" class="" value="<?= $user["email"]; ?>">
        						 <button class="btn btn-primary btn-small"><i class="fa fa-envelope-o"> </i></button>  
                            </form>
    						<a href="<?= BASE_URL.'/admin/users/edit/'.$user['userID'];?>" class="btn btn-small btn-success">
                                <i class="fa fa-pencil"> </i>
                            </a> 
                            <a data-toggle="modal" data-target="#ajaxModal" class="btn btn-danger btn-small" href="<?=BASE_URL.'/admin/users/delete/'.$user['userID'];?>">
                                <i class="fa fa-remove"> </i>
                            </a>
                        </td>
					</tr>
				  <?php  } ?>
                </tbody>
            </table>
            </form>
        	</div>
      </div>
 </div>
<?php echo $footer; ?>
<script>
$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});
</script>