<?php echo $header; ?>
<style>
    .main-footer {
        margin: 0 auto;
    }
    </style>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?php echo $this->lang->line('user_edit_header'); ?>
            </h1>
			<?php if(isCurrentUserAdmin($this)){?>
            <ol class="breadcrumb">
                <li>
                <i class="fa fa-dashboard"></i>
                	<a href="<?=BASE_URL?>/admin"><?php echo $this->lang->line('nav_dash'); ?></a>
                </li>
                <li>
                <i class="fa fa-fw fa-user"></i>
                	<a href="<?=BASE_URL?>/admin/users"><?php echo $this->lang->line('user_header'); ?></a>
                </li>
                <li class="active">
                <i class="fa fa-fw fa-pencil"></i>
                	<?php echo $this->lang->line('user_edit_header'); ?>
                </li>
            </ol>
			<?php } ?>
        </div>
    </div>
</div>
<div class="container-fluid">
  <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-pencil fa-fw"></i>
                    <?php echo $this->lang->line('user_edit_header'); ?>
                </h3>
            </div>
            
         <div class="panel-body">
             <?php foreach ($users as $u) {
			 echo form_open(BASE_URL.'/admin/users/edited/'.$this->uri->segment(4)); ?>
            <div class="row">
				<div class="col-md-6">
	                <div class="form-group">		
	                <?php echo form_error('username', '<div class="alert alert-danger">', '</div>'); ?>									
						<label class="control-label" for="username"><?php echo $this->lang->line('user_new_username'); ?></label>
						<div class="controls">
	                    <?php 	$data = array(
							  'name'        => 'username',
							  'id'          => 'username',
							  'class'       => 'form-control disabled',
							  'value'		=> set_value('username', $u['userName']),
							  'disabled'	=> ''
							);
				
							echo form_input($data); ?>

							<p class="help-block"><?php echo $this->lang->line('user_new_message'); ?></p>
						</div> <!-- /controls -->				
					</div> <!-- /form-group -->
				</div>
				<div class="col-md-6">
					<div class="form-group">		
	                <?php echo form_error('email', '<div class="alert alert-danger">', '</div>'); ?>									
						<label class="control-label" for="email"><?php echo $this->lang->line('user_new_email'); ?></label>
						<div class="controls">
							 <?php 	$data = array(
							  'name'        => 'email',
							  'id'          => 'email',
							  'class'       => 'form-control',
							  'value'		=> set_value('email', $u['email']),
							);
				
							echo form_input($data); ?>

						</div> <!-- /controls -->				
					</div> <!-- /form-group -->
				 </div>
			</div>
			<div class="row">
				 <div class="col-md-6">
	                <div class="form-group">		
	                <?php echo form_error('password', '<div class="alert alert-danger">', '</div>'); ?>									
						<label class="control-label" for="password"><?php echo $this->lang->line('user_new_pass'); ?></label>
						<div class="controls">
							<?php 	$data = array(
							  'name'        => 'password',
							  'id'          => 'password',
							  'class'       => 'form-control',
							  'value'		=> set_value('password')
							);
				
							echo form_password($data); ?>
						</div> <!-- /controls -->				
					</div> <!-- /form-group -->
				 </div>
				 <div class="col-md-6">
					<div class="form-group">	
	                <?php echo form_error('con_password', '<div class="alert alert-danger">', '</div>'); ?>									
						<label class="control-label" for="con_password"><?php echo $this->lang->line('user_new_confirm'); ?></label>
						<div class="controls">
							<?php 	$data = array(
							  'name'        => 'con_password',
							  'id'          => 'con_password',
							  'class'       => 'form-control',
							  'value'		=> set_value('con_password')
							);
				
							echo form_password($data); ?>
						</div> <!-- /controls -->				
					</div> <!-- /form-group -->
				 </div>
				 <div class="col-md-12">
					<div class="form-group">	
	                <?php echo form_error('password_recovery_question', '<div class="alert alert-danger">', '</div>'); ?>					
						<label class="control-label" for="password_recovery_question">Password Recovery Question</label>
						<div class="controls">
							<?php 	$data = array(
							  'name'        => 'password_recovery_question',
							  'id'          => 'password_recovery_question',
							  'class'       => 'form-control',
							  'value'		=> set_value('password_recovery_question',$u['password_recovery_question'])
							);
				
							echo form_input($data); ?>
						</div> <!-- /controls -->				
					</div> <!-- /form-group -->
				 </div>
			 	 <div class="col-md-12">
						<div class="form-group">	
		                <?php echo form_error('password_recovery_answer', '<div class="alert alert-danger">', '</div>'); ?>					
							<label class="control-label" for="password_recovery_answer">Password Recovery Answer</label>
							<div class="controls">
								<?php 	$data = array(
								  'name'        => 'password_recovery_answer',
								  'id'          => 'password_recovery_answer',
								  'class'       => 'form-control',
								  'value'		=> set_value('password_recovery_answer',$u['password_recovery_answer'])
								);
					
								echo form_input($data); ?>
							</div> <!-- /controls -->				
						</div> <!-- /form-group -->
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?php echo form_error('phone', '<div class="alert alert-danger">', '</div>'); ?>
						<label class="control-label" for="phone">Phone No</label>
						<div class="controls">
							<?php 	$data = array(
								'name'        => 'phone',
								'id'          => 'phone',
								'class'       => 'form-control',
								'value'		=> set_value('phone',$u['phone'])
							);

							echo form_input($data); ?>
						</div> <!-- /controls -->
					</div>  
				</div>
				<?php if(isCurrentUserAdmin($this)){ ?>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="Roles">Role</label>
						<div class="controls">
							<select name="role[]" class="form-control js-example-basic-multiple select2-active" multiple>
							<?php 
								$options = array();
								if(!empty($users[0]['userRole'])){
									$options = json_decode($users[0]['userRole']);
								}
								if(isset($roles) and !empty($roles)){
									foreach ($roles as $role){
										$selected = '';
										if(in_array($role['id'],$options)){
											$selected = 'SELECTED';
										}
										echo '<option value="'.$role['id'].'" '.$selected.'>'.$role['Label'].'</option>';
									}
								}
							?>
							</select>
						</div>
		            </div>
		        </div>
		        <?php } ?>
	        </div>
	        <div class="panel-footer">
                <?php 	$data = array(
						  'name'        => 'submit',
						  'id'          => 'submit',
						  'class'       => 'btn btn-primary',
						  'value'		=> $this->lang->line('btn_save'),
						);
					 echo form_submit($data); ?> 
					<a class="btn" href="<?php echo BASE_URL; ?>/admin/users"><?php echo $this->lang->line('btn_cancel'); ?></a>
				</div> <!-- /form-actions -->
               <?php  echo form_close(); 
			 }
			 ?>
			</div>
		</div>
	</div>

<?php echo $footer; ?>
