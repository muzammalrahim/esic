<?php
    if(isset($id) && !empty($id)){
        $id = $id;
    }else{
        return 'Sorry No ID Set';
    }
    if(isset($data) && !empty($data)){
        $name    = $data->name;
        $website = $data->website;
        $email   = $data->email;
        $slug    = $data->slug;

        //Address Fields
        $address_streetNumber = $data->address_street_number;
        $address_streetName = $data->address_street_name;
        $address_town = $data->address_town;
        $address_state = $data->address_state;
        $address_postCode = $data->address_post_code;

        $logo = $data->logo;

        $Program_Summary    = $data->Program_Summary;
        $Program_Criteria   = $data->Program_Criteria;
        $Program_Start_Date = $data->Program_Start_Date;
        $Program_Application_Contact = $data->Program_Application_Contact;
        $Program_Application_Method  = $data->Program_Application_Method;
        $AcceleratorStatus  = $data->AcceleratorStatus;

    }
?>
      <div class="row">
          <div class="col-md-12">
              <div class="text-right" style="margin-bottom: 5px;">
                  <a href="<?= base_url().$ControllerRouteName.'/Listing'?>" class="btn addNewBtn btn-primary">All listings</a>
                  <a href="<?= base_url().$ControllerRouteName.'/Edit/'.$id;?>" class="btn addNewBtn btn-primary">Edit</a>
                  <a href="<?= base_url().$ControllerRouteName.'/'.$slug;?>" class="btn addNewBtn btn-primary" target="_blank">View</a>
              </div>
          </div>
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile" id="profile-box-container" data-user-id="<?= $id;?>" data-img="<?= FCPATH.$logo?>">
            <?php 
                    if(!empty($logo) and is_file(FCPATH.$logo)){ 
                      $logoImage = base_url().'/'.$logo;
                    }else{
                       $logoImage = base_url('pictures/defaultLogo.png');
                    }

            ?>
                <div class="user-logo-container">
                  <img id="User-Logo" class="profile-user-img img-responsive" src="<?= $logoImage; ?>" alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">
                    <b><?= $name;?></b>
                </h3>
                <div class="text-center">
                    <?php if($ver_status) { 
                    if($ver_status == 'Pending' ) { 
                        echo '<label class="label label-warning">'.$ver_status.'</label>';
                    } else {
                        echo '<label data-trigger="hover" data-toggle="popover" title="Reason!" class="label label-danger" data-content="'.$data->cancel_msg.'">'.$ver_status.'</label>';
                    } } ?>
                </div>
                <?php if(!empty($email)){ ?>
                <div class="email-container">
                    <label for="">Email:</label>
                    <p class=""><?= $email; ?></p>
                </div>
                 <?php } ?>
                <?php if(!empty($website)){ ?>
                <div class="web-container">
                    <label for="">Website:</label>
                    <?php
                    $findme   = 'http';
                    $pos = strpos($website, $findme);
                    if ($pos === false) {
                        $website = 'http://'.$website;
                    }
                    ?>
                    <a href="<?= $website; ?>" class="btn btn-primary btn-block" target="_blank">
                        <?= $website; ?>
                    </a>
                </div>
                 <?php } ?>
                <?php if(!empty($Program_Start_Date)){ 
                        if(strtotime($Program_Start_Date) > strtotime('20 year ago')){
                  ?>
                    <div class="text-container">
                        <label for="">Program Start Date:</label>
                        <p class=""><?= date('d-m-Y',strtotime($Program_Start_Date)) ?></p>
                    </div>
                <?php } }?>
                <?php if(!empty($AcceleratorStatus)){ ?>
                <div class="web-container">
                    <label for="">Accelerator Status:</label>
                    <p class="">
                    <?php 
                      if($AcceleratorStatus == 'Eligible'){
                          echo '<span class="label label-success success">Eligible</span>';
                      }else if($AcceleratorStatus == 'Pending'){
                          echo '<span class="label label-danger danger">Pending</span>';
                      }else{
                          echo '<span class="label label-warning warning">Not Selected</span>';
                      }
                    ?>
                    </p>
                </div>
                 <?php } ?>
                <?php if($address){ ?>
                    <div class="address-container">
                        <div class="address-text">
                            <strong><i class="fa fa-globe margin-r-5"></i>Address</strong>
                            <?php if(!empty($address_streetNumber)){?>
                                <div class="text-muted">Street Number: <span class="street_number"><?=$address_streetNumber;?></span></div>
                            <?php } ?>
                            <?php if(!empty($address_streetName)){?>
                                <div class="text-muted">Street Name: <span class="street_name"><?=$address_streetName;?></span></div>
                            <?php } ?>
                            <?php if(!empty($address_town)){?>
                                <div class="text-muted">Town: <span class="town"><?=$address_town?></span></div>
                            <?php } ?>
                            <?php if(!empty($address_state)){?>
                                <div class="text-muted">State: <span class="state"> <?=$address_state?> </span></div>
                            <?php } ?>
                            <?php if(!empty($address_postCode)){?>
                                <div class="text-muted">Post Code: <span class="post_code"><?=$address_postCode?></span></div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#questions" data-toggle="tab">Questions</a></li>
                <li><a href="#description" data-toggle="tab">Description</a></li>
                <!-- Year filter-->
                <select class="form-control year-filter pull-right" data-toggle="tooltip" title="Prior Year Status"  name="year" data-id="<?= $id;?>" id="filter_by_year" data-placeholder="Filter By Year" onchange="listQuestionByYear(this)">
                    <?php if(!empty($yearsList)){
                        $c_date = date('Y-m-d');
                        $c_Year = date('Y');
                        if( $c_date > date("$c_Year-06-30") && $c_date <= date("$c_Year-12-31") ){
                            $c_Year +=1;
                        }else if($c_date < date("$c_Year-07-01") && $c_date >= date("$c_Year-01-01") ){
                            $c_Year = date('Y');
                        }
                        //echo "<option>".$c_Year."</option>";
                        foreach($yearsList as $year){
                            echo "<option>".$year."</option>";
                        }
                    }?>
                </select>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="questions">
                    <?= $showUserQuestionAnswers;?>
                 </div>
                <div class="tab-pane" id="description">
                <ul class="timeline timeline-inverse">
                    <li>
                        <div class="timeline-item">
                          <h3 class="timeline-header">Program Summary:</h3>
                          <div id="short-desc-text" class="timeline-body">
                                <pre><?= trim(urldecode($Program_Summary));?></pre>
                          </div>
                        </div>
                        <div class="timeline-item">
                          <h3 class="timeline-header">Program Criteria:</h3>
                          <div id="short-desc-text" class="timeline-body">
                                <pre><?= trim(urldecode($Program_Criteria));?></pre>
                          </div>
                        </div>
                        <div class="timeline-item">
                          <h3 class="timeline-header">Program Application Method:</h3>
                          <div id="short-desc-text" class="timeline-body">
                                <pre><?= trim(urldecode($Program_Application_Method));?></pre>
                          </div>
                        </div>
                        <div class="timeline-item">
                          <h3 class="timeline-header">Program Application Contact:</h3>
                          <div id="short-desc-text" class="timeline-body">
                                <pre><?= trim(urldecode($Program_Application_Contact));?></pre>
                          </div>
                        </div>
                    </li>      
                </ul>
              </div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
       </div>
    <div class="box">
        <div class="box-footer">
            <div class="button-container action-button-sticky-bar">
                <a href="<?= base_url().$ControllerRouteName.'/Listing'?>" class="btn addNewBtn btn-primary">All listings</a>
                <a href="<?= base_url().$ControllerRouteName.'/Edit/'.$id;?>" class="btn addNewBtn btn-primary">Edit</a>
                <a href="<?= base_url().$ControllerRouteName.'/'.$slug;?>" class="btn addNewBtn btn-primary" target="_blank">View</a>
            </div>
        </div>
    </div>
    <?= $viewFooter;?>