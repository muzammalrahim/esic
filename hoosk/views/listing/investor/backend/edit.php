<?php 
    if(isset($id) && !empty($id)){
        $id = $id;
    }else{
        return 'Sorry No ID Set';
    }
    if(isset($data) && !empty($data)){

        $name                   = $data->name;
        if($roll_back && $slug->slug)
            $slug               = $slug->slug;
        else
            $slug               = $data->slug;
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
        $banner                 = $data->banner;
        $about                  = $data->about;
        $investor_type_id       = $data->investor_type_id;

        $preferred_investment_amount     = $data->preferred_investment_amount;
        $preferred_investment_industires = $data->preferred_investment_industires;
        $preferred_esic_status_ids       = $data->preferred_esic_status_ids;
        $ranking_score                   = $data->ranking_score;

        $templateSelectedID = $data->template;

    }

//    if(isset($UserData) && !empty($UserData)){
//
//        $firstName    = $UserData->firstName;
//        $lastName     = $UserData->lastName;
//        $email        = $UserData->email;
//
//    }else{
//
//        $firstName    = ''; 
//        $lastName     = ''; 
//        if(!isset($email) && empty($email)){
//          $email        = ''; 
//        }
//    }
    if(isset($SocialLinks) && !empty($SocialLinks)){

        $facebook   = $SocialLinks->facebook;
        $twitter    = $SocialLinks->twitter;
        $google     = $SocialLinks->google;
        $linkedIn   = $SocialLinks->linkedIn;
        $youTube    = $SocialLinks->youTube;
        $vimeo      = $SocialLinks->vimeo;
        $instagram  = $SocialLinks->instagram;
    }

    if (isset($data->doShowItems) and !empty($data->doShowItems)) {
        $doShowItems = json_decode($data->doShowItems);
        $showLogo = ($doShowItems->showLogo === 'No') ? false : true;
        $showBanner = ($doShowItems->showBanner === 'No') ? false : true;
        $showShortDescription = ($doShowItems->showShortDescription === 'No') ? false : true;
    } else {
        $showLogo = $showBanner = $showShortDescription = true;
    }

?>   <div class="row">
        <div class="col-md-12">
             <div class="callout callout-info">
                <p>Welcome “this is the detailed listing for your page in ESIC Directory” you can edit and save changes to your listing here, however we will review and approve or reject your listing request before it is made public.</p>
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url().$ControllerRouteName.'/EditSave'?>" method="post" class="form" enctype="multipart/form-data">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Edit <?= $ListingLabel ; ?></h3>
                            <div class="add-New-container">
                                <?php
                                if($roll_back){
                                    $verId = $data->id;
                                    echo '<a data-id="'.$verId.'" data-list-id = "'.$id.'" data-trigger="hover" data-toggle="popover" title="Roll Back" data-content="Roll back to previous approved version" class="roll-back addNewBtn btn btn-primary" style="cursor:pointer" onclick="rollBack(this)">Roll Back</a>';
                                }
                                ?>
                                 <a href="<?= base_url().'admin/'.$ControllerRouteName.'/view/'.$id;?>" class="addNewBtn btn btn-primary">Page Details</a>
                                 <a href="<?= base_url().$ControllerRouteName.'/Listing'?>" class="addNewBtn btn btn-primary">Summary</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" id="hiddenListID" value="">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="NameTextBox">Investor Name</label>
                                        <input type="text" name="name" id="NameTextBox" value="<?= $name;?>" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="PhoneTextBox">Phone</label>
                                        <input type="text" name="phone" id="PhoneTextBox" value="<?= $phone;?>" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="EmailBox">Email</label>
                                        <input type="text" name="email" id="EmailBox" value="<?= $email;?>" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="WebsiteBox">Website</label>
                                        <input type="text" name="website" id="WebsiteBox" value="<?= $website;?>" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="CompanyNameBox">Company Name:</label>
                                        <input type="text" name="company_name" id="CompanyNameBox" class="form-control" value="<?= $company_name;?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="CompanyEmailBox">Company Email:</label>
                                        <input type="text" name="company_email" id="CompanyEmailBox" class="form-control" value="<?= $company_email;?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="AddressBox">Address :</label>
                                        <div class="row">
                                            <div class="form-group col-lg-2">
                                                <label for="address_streetNumber">Street Number</label>
                                                <input type="text" name="address_street_number" id="address_street_number" value="<?= $address_street_number;?>" class="form-control">
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label for="address_streetName">Street Name</label>
                                                <input type="text" name="address_street_name" id="address_streetName" value="<?= $address_street_name;?>" class="form-control">
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label for="address_town">Town</label>
                                                <input type="text" name="address_town" id="address_town" value="<?= $address_town;?>" class="form-control">
                                            </div>

                                            <div class="form-group col-lg-3">
                                                <label for="address_state">State</label>
                                                <!--input type="text" name="address_state" id="address_state" value="<?=(isset($address_state) and !empty($address_state))?$address_state:''?>" class="form-control"-->
                                                    <select class="form-control customSelect2" name="address_state" id="address_state" placeholder="State">
                                                        <?php
                                                            if(isset($selectors) and !empty($selectors['states'])){
                                                                foreach ($selectors['states'] as $state) {
                                                                    if(!empty($state)){
                                                                        if(!empty($address_state)){
                                                                            if($state['Value'] == $address_state){
                                                                                $stateSelectSelected = 'selected="selected"';
                                                                            }else{
                                                                                $stateSelectSelected = '';
                                                                            }
                                                                        }
                                                                        echo '<option value="' . $state['Value'] . '" '.$stateSelectSelected.'>' . $state['State'] . '</option>';
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                            </div>

                                            <div class="form-group col-lg-3">
                                                <label for="address_post_code">Post Code</label>
                                                <!--input type="text" name="address_post_code" id="address_post_code" value="<?=(isset($address_post_code) and !empty($address_post_code))?$address_post_code:''?>" class="form-control"-->
                                                <select class="form-control " name="address_post_code" id="address_post_code" data-post="<?php print_r($address_post_code);?>">
                                                    </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="investorTypeFlagBox">Investor Type:</label>
                                        <select id="investorTypeFlagBox" name="investor_type_id" class="form-control select2-active">    
                                            <option value="">Select Investor Type</option>                  
                                            <?php    
                                                if(isset($investorTypes) || !empty($investorTypes)){
                                                    foreach ($investorTypes as $key => $investorType) { 
                                                        $selected = '';
                                                    if($investor_type_id == $investorType->id){
                                                        $selected = 'SELECTED';
                                                    }           
                                             ?>
                                                        <option value="<?= $investorType->id;?>" <?=$selected;?> > <?= $investorType->label;?></option>
                                            <?php 
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="amountBox">Preferred Investment Amount:</label>
                                        <select id="amountBox" name="preferred_investment_amount" class="form-control select2-active">                                 
                                           <option value="">Select Amount</option>
                                            <?php    
                                                if(isset($investmentAmounts) || !empty($investmentAmounts)){
                                                    foreach ($investmentAmounts as $key => $investmentAmount){
                                                            $selected = '';
                                                        if($preferred_investment_amount == $investmentAmount->id){
                                                            $selected = 'SELECTED';
                                                        }           
                                            ?>
                                                        <option value="<?= $investmentAmount->id;?>" <?=$selected;?>> <?= $investmentAmount->label;?></option>
                                            <?php 
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="industiresBox">Preferred Investment Industires:</label>
                                         <select id="industiresBox" name="preferred_investment_industires[]" class="form-control js-example-basic-multiple select2-active" multiple>
                                            <?php    
                                            $PII = json_decode($preferred_investment_industires, TRUE);
                                                if(isset($industires) || !empty($industires)){
                                                    foreach ($industires as $key => $industry) { 
                                                            $selected = '';
                                                        if(in_array($industry->id, $PII)){
                                                            $selected = 'SELECTED';
                                                        }
                                            ?>
                                                        <option value="<?= $industry->id;?>" <?=$selected;?> > <?= $industry->sector;?></option>
                                            <?php 
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="esicStatuesBox">Preferred ESIC Status:</label>
                                         <select id="esicStatuesBox" name="preferred_esic_status_ids[]" class="form-control js-example-basic-multiple select2-active" multiple>
                                            <option value="All">All</option>
                                            <?php  
                                            $PESI = json_decode($preferred_esic_status_ids, TRUE);  
                                                if(isset($esicStatues) || !empty($esicStatues)){
                                                    foreach ($esicStatues as $key => $esicStatus) { 
                                                          $selected = '';
                                                        if(in_array($esicStatus->id, $PESI)){
                                                            $selected = 'SELECTED';
                                                        }
                                            ?>
                                                        <option value="<?= $esicStatus->id;?>" <?=$selected;?>> <?= $esicStatus->status;?></option>
                                            <?php 
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ranking_score">Boost your ESIC points:</label>
                                        <input type="number" max="100" min="0" name="ranking_score" id="ranking_score" class="form-control" value="<?=$ranking_score;?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="AboutBox">About:</label>
                                        <textarea type="text" name="about" id="AboutBox" class="form-control"> <?= $about; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="update-logo-file">Logo</label>
                                        (<span><label for="doShowLogo"><input type="checkbox" id="doShowLogo" name="doShowLogo" <?=($showLogo)?'checked="checked"':''?>> Do Show <i data-toggle="tooltip" title="Show Logo on the Details Page." class="fa fa-question-circle"></i> </label></span> )
                                        <div class="img-reponsive">
                                            <div class="img-container img-logo img-responsive">
                                                 <?php if(!empty($logo) and is_file(FCPATH.$logo)){ 
                                                          $logoImage = base_url().'/'.$logo;
                                                        }else{
                                                           $logoImage = base_url('pictures/defaultLogo.png');
                                                        }
                                                ?>
                                                        <img src="<?=$logoImage;?>" class="logo-show" id="Logo-show" />
                                            </div>
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <span class="btn btn-file btn-logo-edit"><span class="fileupload-new">Click To</span><span class="fileupload-exists"> Edit</span>
                                                    <input type="file" name="Logoimage" id="Logo-file"  />
                                                </span>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="update-Banner-file">Banner</label>
                                        ( <span><label for="doShowBanner"><input type="checkbox" id="doShowBanner" name="doShowBanner" <?=($showBanner)?'checked="checked"':''?>> Do Show <i data-toggle="tooltip" title="Show Banner on the Details Page." class="fa fa-question-circle"></i> </label></span> )
                                        <div class="img-reponsive">
                                            <div class="img-container img-logo img-responsive">
                                                <?php if(!empty($banner)){ ?>
                                                    
                                                        <img src="<?= base_url().$banner;?>" class="banner-show" id="banner-show" />

                                                <?php }else{ ?>
                                                        <img src="<?= base_url()?>pictures/defaultLogo.png" class="logo-show" id="banner-show" />
                                                <?php } ?>
                                            </div>
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <span class="btn btn-file btn-logo-edit"><span class="fileupload-new">Click To</span><span class="fileupload-exists"> Edit</span>
                                                    <input type="file" name="Bannerimage" id="banner-file"  />
                                                </span>
                                            </div>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="social-container">
                                        <label for="AddressBox">Social Links:</label>
                                        <div class="row">
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="FacebookLink">Facebook</label>
                                                <input type="text" name="facebook" id="FacebookLink" class="form-control" value="<?= $facebook;?>" >
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="TwitterLink">Twitter</label>
                                                <input type="text" name="twitter" id="TwitterLink" class="form-control" value="<?= $twitter;?>">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="GoogleLink">Google Plus</label>
                                                <input type="text" name="google" id="GoogleLink" class="form-control" value="<?= $google;?>">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="LinkedInLink">LinkedIn</label>
                                                <input type="text" name="linkedIn" id="LinkedInLink" class="form-control" value="<?= $linkedIn;?>">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="InstagramLink">Instagram</label>
                                                <input type="text" name="instagram" id="InstagramLink" class="form-control" value="<?= $instagram;?>">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="YoutubeLink">Youtube</label>
                                                <input type="text" name="youTube" id="YoutubeLink" class="form-control" value="<?= $youTube;?>">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="VimeoLink">Vimeo</label>
                                                <input type="text" name="vimeo" id="VimeoLink" class="form-control"  value="<?= $vimeo;?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php if(isset($templates) && !empty($templates)){ ?>
                                <div class="col-md-12">
                                    <div class="template-container">
                                        <label for="TemplatesBox">Template Block:</label>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                              <label for="TemplatesBox">Templates:</label>
                                                <select id="templateFlagBox" name="template" class="form-control select2-active">
                                                <?php foreach($templates as $key => $value) { 
                                                  $tempSelected  = '';
                                                    if($value->id == $templateSelectedID){
                                                      $tempSelected  = 'SELECTED';
                                                    }
                                                 ?>
                                                    <option value="<?= $value->id;?>" <?=$tempSelected;?> ><?= $value->name;?></option>
                                                <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                        </div> <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="button-container action-button-sticky-bar">
                                <a href="<?= base_url().'admin/'.$ControllerRouteName.'/view/'.$id;?>" class="addNewBtn btn btn-primary">Page Details</a>
                                <a href="<?= base_url().$ControllerRouteName.'/Listing'?>" class="addNewBtn btn btn-primary">Summary</a>
                                <input type="hidden" name="id" value="<?= $id;?>" />
                                <input type="submit" class="btn btn-primary addNewBtn" value="Save" />
                                <input type="button" class="btn btn-primary addNewBtn" value="Preview" id="previewSubmitWOPB"/>
                                <a href="<?=base_url().$this->Name.'/'.$slug;?>" class="btn btn-primary addNewBtn" View id="Viewfront" target="_blank">View</a>
                            </div> 
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->