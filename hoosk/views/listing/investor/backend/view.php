<?php
    if(isset($id) && !empty($id)){
        $id = $id;
    }else{
        return 'Sorry No ID Set';
    }
    if(isset($data) && !empty($data)){

        $name                   = $data->name;
        $slug                   = $data->slug; 
        $phone                  = $data->phone;
        $website                = $data->website;
        $email                  = $data->email;

        $company_name           = $data->company_name;
        $company_email          = $data->company_email;

        $address_street_number  = $data->address_street_number;
        $address_street_name    = $data->address_street_name;
        $address_town           = $data->address_town;
        $address_state          = $data->address_state;
        $address_post_code      = $data->address_post_code;

        $logo                   = $data->logo;
        $about                  = $data->about;
        $investor_type_id       = $data->investor_type_id;

        $preferred_investment_amount_id     = $data->preferred_investment_amount;
        $preferred_investment_industires = $data->preferred_investment_industires;
        $preferred_esic_status_ids       = $data->preferred_esic_status_ids;

    }else{

        $name                   = '';
        $phone                  = '';
        $website                = '';
        $email                  = '';

        $company_name           = '';
        $company_email          = '';
        
        $address_street_number  = '';
        $address_street_name    = '';
        $address_town           = '';
        $address_state          = '';
        $address_post_code      = '';

        $logo                   = '';
        $about                  = '';
        $investor_type_id       = '';

        $preferred_investment_amount_id     = '';
        $preferred_investment_industires = '';
        $preferred_esic_status_ids       = '';
    }
    $investor_type = '';
    if(isset($investorTypes) || !empty($investorTypes)){
        foreach ($investorTypes as $key => $investorType) { 
            if($investor_type_id == $investorType->id){
                $investor_type = $investorType->label;
            }  
        }
    } 
    $preferred_investment_amount = '';
    if(isset($investmentAmounts) || !empty($investmentAmounts)){
        foreach ($investmentAmounts as $key => $investmentAmount) { 
            if($preferred_investment_amount_id == $investmentAmount->id){
                $preferred_investment_amount = $investmentAmount->label;
            }  
        }
    }
    $CurrentIndustires = array();
    if(isset($industires) || !empty($industires)){
        if(!empty($preferred_investment_industires)){
            $industiresIDsArray = json_decode($preferred_investment_industires);
            if(!empty($industiresIDsArray)){
                foreach($industires as $key => $industry) { 
                    if(in_array($industry->id, $industiresIDsArray)){
                        $CurrentIndustires[] = $industry->sector;
                    }  
                }
            }
        }
    } 
    $CurrentEsicStatuses = array();
    if(isset($esicStatues) || !empty($esicStatues)){
        if(!empty($preferred_esic_status_ids)){
            $EsicStatusIDsArray = json_decode($preferred_esic_status_ids);
            if(!empty($EsicStatusIDsArray)){
                foreach($esicStatues as $key => $esicStatus) { 
                    if(in_array($esicStatus->id, $EsicStatusIDsArray)){
                        $CurrentEsicStatuses[] = $esicStatus->status;
                    }  
                }
            }
        }
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
                <?php if(!empty($email)){ ?>
                    <div class="email-container">
                        <label for="">Email:</label>
                        <p class=""><?= $email; ?></p>
                    </div>
                <?php } ?>
                <?php if(!empty($phone)){ ?>
                    <div class="phone-container">
                        <label for="">Phone:</label>
                        <p class=""><?= $phone; ?></p>
                    </div>
                <?php } ?>
                <?php if(!empty($company_name)){ ?>
                    <div class="company-name-container">
                        <label for="">Company Name:</label>
                        <p class=""><?= $company_name; ?></p>
                    </div>
                <?php } ?>
                <?php if(!empty($company_email)){ ?>
                    <div class="company-email-container">
                        <label for="">Company Email:</label>
                        <p class=""><?= $company_email; ?></p>
                    </div>
                <?php } ?>
                <?php if(!empty($investor_type)){ ?>
                    <div class="investor-type-container">
                        <label for="">Investor Type:</label>
                        <p class=""><?= $investor_type; ?></p>
                    </div>
                <?php } ?>
                <?php if(!empty($preferred_investment_amount)){ ?>
                    <div class="company-email-container">
                        <label for="">Preferred Investment Amount:</label>
                        <p class=""><?= $preferred_investment_amount; ?></p>
                    </div>
                <?php } ?>
                <?php if(!empty($CurrentIndustires)){ ?>
                    <div class="esic-industry-container">
                        <label for="">Preferred Industires:</label>
                        <div class="multiple-item-container">
                        <?php foreach ($CurrentIndustires as $key => $CurrentIndustry) { ?>
                            <span class=""><?= $CurrentIndustry; ?></span>
                        <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if(!empty($CurrentEsicStatuses)){ ?>
                    <div class="esic-status-container">
                        <label for="">Preferred Esic Statuses:</label>
                        <div class="multiple-item-container">
                        <?php foreach ($CurrentEsicStatuses as $key => $CurrentEsicStatus) { ?>
                            <span class=""><?= $CurrentEsicStatus; ?></span>
                        <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                
                <?php if($address){ ?>
                    <div class="address-container">
                        <div class="address-text">
                            <strong><i class="fa fa-globe margin-r-5"></i>Address</strong>
                            <?php if(!empty($address_street_number)){?>
                                <div class="text-muted">Street Number: <span class="street_number"><?=$address_street_number;?></span></div>
                            <?php } ?>
                            <?php if(!empty($address_street_name)){?>
                                <div class="text-muted">Street Name: <span class="street_name"><?=$address_street_name;?></span></div>
                            <?php } ?>
                            <?php if(!empty($address_town)){?>
                                <div class="text-muted">Town: <span class="town"><?=$address_town?></span></div>
                            <?php } ?>
                            <?php if(!empty($address_state)){?>
                                <div class="text-muted">State: <span class="state"> <?=$address_state?> </span></div>
                            <?php } ?>
                            <?php if(!empty($address_post_code)){?>
                                <div class="text-muted">Post Code: <span class="post_code"><?=$address_post_code?></span></div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#questions" data-toggle="tab">Questions</a></li>
              <li><a href="#description" data-toggle="tab">Description</a></li>
                <!-- Year filter-->
                <select class="form-control year-filter pull-right" name="year" data-toggle="tooltip" title="Prior Year Status"  data-id="<?= $id;?>" id="filter_by_year" data-placeholder="Filter By Year" onchange="listQuestionByYear(this)">
                    <?php if(!empty($yearsList)){
                        $c_date = date('Y-m-d');
                        $c_Year = date('Y');
                        if( $c_date > date("$c_Year-06-30") && $c_date <= date("$c_Year-12-31") ){
                            $c_Year +=1;
                        }else if($c_date < date("$c_Year-07-01") && $c_date >= date("$c_Year-01-01") ){
                            $c_Year = date('Y');
                        }
                       // echo "<option>".$c_Year."</option>";
                        foreach($yearsList as $year){ $year = explode('-',$year);
                            ?> <option <?php if($c_Year == $year[0] ){echo "selected"; }?>> <?= $year[0] ?></option>
                        <?php
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
                          <h3 class="timeline-header">About:</h3>
                          <div id="short-desc-text" class="timeline-body">
                                <pre><?= trim(urldecode($about));?></pre>
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
        <!-- /.col -->
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