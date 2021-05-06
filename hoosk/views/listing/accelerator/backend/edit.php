<?php
    if(isset($id) && !empty($id)){
        $id = $id;
    }else{
        return 'Sorry No ID Set';
    }
    if(isset($data) && !empty($data)){



        $name    = $data->name;
        if($roll_back && $slug->slug)
            $slug               = $slug->slug;
        else
            $slug               = $data->slug;
        $email   = $data->email;
        $website = $data->website;

        //Getting Address Fields
        $address_street_number  = $data->address_street_number;
        $address_street_name    = $data->address_street_name;
        $address_town           = $data->address_town;
        $address_state          = $data->address_state;
        $address_post_code      = $data->address_post_code;
        $ranking_score          = $data->ranking_score;

        $logo   = $data->logo;
        $banner = $data->banner;

        $long_description   = $data->long_description;
        $businessShortDescriptionJSON = $data->businessShortDescriptionJSON;    

        $Program_Summary    = $data->Program_Summary;
        $Program_Criteria   = $data->Program_Criteria;
        $Program_Start_Date = $data->Program_Start_Date;
        $Program_Application_Contact = $data->Program_Application_Contact;
        $Program_Application_Method  = $data->Program_Application_Method;

        $AcceleratorStatus = $data->AcceleratorStatus;

        $templateSelectedID = $data->template;

    }

    if(isset($SocialLinks) && !empty($SocialLinks)){

        $facebook   = $SocialLinks->facebook;
        $twitter    = $SocialLinks->twitter;
        $google     = $SocialLinks->google;
        $linkedIn   = $SocialLinks->linkedIn;
        $youTube    = $SocialLinks->youTube;
        $vimeo      = $SocialLinks->vimeo;
        $instagram  = $SocialLinks->instagram;
    }

    if(isset($data->doShowItems) and !empty($data->doShowItems)) {
        $doShowItems = json_decode($data->doShowItems);
        $showLogo = ($doShowItems->showLogo === 'No') ? false : true;
        $showBanner = ($doShowItems->showBanner === 'No') ? false : true;
        $showShortDescription = ($doShowItems->showShortDescription === 'No') ? false : true;
    } else {
        $showLogo = $showBanner = $showShortDescription = true;
    }


    ?>
       <div class="row">
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
                                <a href="<?= base_url().'admin/'.$ControllerRouteName.'/view/'.$id;?>" class="addNewBtn btn btn-primary">Details Page</a>
                                <a href="#" id="desc-edit" data-toggle="modal" data-target="#desc-edit-modal" data-user-id="<?= $userProfile['userID'];?>" class="addNewBtn desc-edit btn btn-primary">Page Builder</a>
                                 <a href="<?= base_url().$ControllerRouteName.'/Listing'?>" class="addNewBtn btn btn-primary">Summary</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" id="hiddenListID" value="">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="NameTextBox">Name</label>
                                        <input type="text" name="name" id="NameTextBox" value="<?= $name;?>" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="emailBox">Email</label>
                                        <input type="text" name="email" id="emailBox" value="<?= $email;?>" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="WebsiteBox">Website</label>
                                        <input type="text" name="website" id="WebsiteBox" value="<?= $website;?>" class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <label for="AddressBox">Address :</label>
                                        <div class="row">
                                            <div class="form-group col-lg-2">
                                                <label for="address_street_number">Street Number</label>
                                                <input type="text" name="address_street_number" id="address_street_number" value="<?=(isset($address_street_number) and !empty($address_street_number))?$address_street_number:''?>" class="form-control">
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label for="address_street_name">Street Name</label>
                                                <input type="text" name="address_street_name" id="address_street_name" value="<?=(isset($address_street_name) and !empty($address_street_name))?$address_street_name:''?>" class="form-control">
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label for="address_town">Town</label>
                                                <input type="text" name="address_town" id="address_town" value="<?=(isset($address_town) and !empty($address_town))?$address_town:''?>" class="form-control">
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
                                                <select class="form-control " name="address_post_code" id="address_post_code" data-post="<?= $address_post_code ?>">
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group"> 
                                        <label for="programSummaryBox">Program Summary</label>
                                        <textarea type="text" name="Program_Summary" id="programSummaryBox" class="form-control"> <?= $Program_Summary;?> </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="programCriteriaBox">Program Criteria</label>
                                        <input type="text" name="Program_Criteria" id="programCriteriaBox" class="form-control" value="<?= $Program_Criteria;?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="ProgramStartDateBox">Program Start Date</label>
                                        <input type="text" name="Program_Start_Date" id="ProgramStartDateBox" class="DateBox form-control date_picker"    placeholder="E.g <?=Date('d-m-Y')?>" value="<?= $Program_Start_Date == 0000-00-00 || $Program_Start_Date == NULL ? " " : date("d-m-Y",strtotime($Program_Start_Date)) ;?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="programApplicationContactBox">Program Application Contact</label>
                                        <input type="text" name="Program_Application_Contact" id="programApplicationContactBox" class="form-control" value="<?= $Program_Application_Contact;?>">
                                    </div>
                                     <div class="form-group">
                                        <label for="programApplicationMethodBox">Program Application Method</label>
                                        <input type="text" name="Program_Application_Method" id="programApplicationMethodBox" class="form-control" value="<?= $Program_Application_Method;?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="ranking_score">Boost your ESIC points</label>
                                        <input  type="number" max="100" min="0" name="ranking_score" id="ranking_score" value="<?=$ranking_score;?>"  class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="LongDescriptionBox">Detail Description<a href="#" id="desc-edit" data-toggle="modal" data-target="#desc-edit-modal" data-user-id="<?= $userProfile['userID'];?>" class="pull-right btn-box-tool desc-edit">
                                        <input type="submit" class="btn btn-primary" value="Page Builder" style="margin-top: -9px">
                                            
                                    
                                        </a></label>    
                                    </div>
                                <?php if(isCurrentUserAdmin($this)){ ?>
                                   <div class="form-group">
                                        <label for="acceleratorStatusBox">Accelerator Status</label>
                                        <select name="AcceleratorStatus" id="acceleratorStatusBox" class="form-control select2-active">
                                            <?php 
                                                $selected = '';
                                                if($AcceleratorStatus == 'Eligible'){ 
                                                        $selected = 'SELECTED';
                                                } 
                                            ?>
                                            <option value="Eligible" <?= $selected;?>>Eligible</option>

                                             <?php 
                                                $selected = '';
                                                if($AcceleratorStatus == 'Pending'){ 
                                                        $selected = 'SELECTED';
                                                } 
                                            ?>

                                            <option value="Pending" <?= $selected;?>>Pending</option>
                                        </select>
                                    </div>
                                <?php } ?>
                                    <div class="form-group">
                                        <label for="update-logo-file">Logo</label>
                                        (<span><label for="doShowLogo"><input type="checkbox" id="doShowLogo" name="doShowLogo" <?=($showLogo)?'checked="checked"':''?>> Do Show <i data-toggle="tooltip" title="Show Logo on the Details Page." class="fa fa-question-circle"></i> </label></span> )
                                        <div class="img-reponsive">
                                            <div class="img-container img-logo edit-img-logo img-responsive">
                                                 <?php if(!empty($logo) and is_file(FCPATH.$logo)){ 
                                                          $logoImage = base_url().'/'.$logo;
                                                        }else{
                                                           $logoImage = base_url('pictures/defaultLogo2.jpg');
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
                                            <div class="img-container img-logo edit-img-banner img-responsive">
                                                <?php if(!empty($banner)){ ?>
                                                    
                                                        <img src="<?= base_url().$banner;?>" class="banner-show" id="banner-show" />

                                                <?php }else{ ?>
                                                        <img src="<?= base_url()?>pictures/defaultBanner.jpg" class="logo-show" id="banner-show" />
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
                                <a href="<?= base_url().'admin/'.$ControllerRouteName.'/view/'.$id;?>" class="addNewBtn btn btn-primary">Details Page</a>
                                <a href="#" id="desc-edit" data-toggle="modal" data-target="#desc-edit-modal" data-user-id="<?= $userProfile['userID'];?>" class="addNewBtn desc-edit btn btn-primary">Page Builder</a>
                                <a href="<?= base_url().$ControllerRouteName.'/Listing'?>" class="addNewBtn btn btn-primary">Summary</a>
                                <input type="hidden" name="id" value="<?= $id;?>" />
                                <input type="submit" class="btn btn-primary addNewBtn" value="Save" />
                                <input type="button" class="btn btn-primary addNewBtn" value="Preview" id="previewSubmit"/>
                                <a href="<?=base_url().$this->Name.'/'.$slug;?>" class="btn btn-primary addNewBtn" View id="Viewfront" target="_blank">View</a>
                            </div> 
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

 <!-- Modal -->
   <div class="modal fade" id="desc-edit-modal" tabindex="-1" role="dialog" aria-labelledby="editDescriptionPage" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                   <h4 class="modal-title" id="myModalLabel">Modal title</h4>
               </div>
               <form  method="POST" action="<?=BASE_URL.'/admin/Accelerator/savedesc'?>" id="descriptionPage">
                   <input type="hidden" name="uID" value="<?=(isset($id)?$id:'')?>" >
                   <input type="hidden" name="action_vl" value="edit_list";
                   <div class="modal-body">
                   <textarea class="js-st-instance" id="desc-content" name="desc-content">
                       <?= htmlentities($businessShortDescriptionJSON);?>
                    </textarea>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   <button type="submit" class="btn btn-primary">Save changes</button>
               </div>
               </form>
           </div>
       </div>
   </div>
    <link href="<?= ADMIN_THEME; ?>/js/trevor/sir-trevor.css" rel="stylesheet">
    <link href="<?= ADMIN_THEME; ?>/js/trevor/sir-trevor-bootstrap.css" rel="stylesheet">
    <link href="<?= ADMIN_THEME; ?>/js/trevor/sir-trevor-icons.css" rel="stylesheet">
      <!--bower work-->
      <script src="<?= ADMIN_THEME; ?>/js/sirTrevor/bower_components/es5-shim/es5-shim.js" type="text/javascript" charset="utf-8"></script>
      <!-- es6-shim should be bundled in with SirTrevor for now -->
      <!-- <script src="../node_modules/es6-shim/es6-shim.js" type="text/javascript" charset="utf-8"></script> -->
      <!--script src="<?= ADMIN_THEME; ?>/js/sirTrevor/bower_components/jquery/dist/jquery.js" type="text/javascript" charset="utf-8"></script-->
      <script src="<?= ADMIN_THEME; ?>/js/sirTrevor/sir-trevor.js" type="text/javascript"></script>
      <script src="<?=  ADMIN_THEME; ?>/js/sirTrevor/bower_components/sir-trevor-columns-block/dist/sir-trevor-columns-block.js" type="text/javascript" charset="utf-8"></script>
      <script src="<?= ADMIN_THEME; ?>/js/sirTrevor/bower_components/underscore/underscore.js" type="text/javascript" charset="utf-8"></script>
      <script src="<?= ADMIN_THEME; ?>/js/sirTrevor/iFrame.js" type="text/javascript" charset="utf-8"></script>
      <script src="<?= ADMIN_THEME; ?>/js/sirTrevor/image-extended.js" type="text/javascript" charset="utf-8"></script>
      <!--TinyMCE-->
      <script src="<?= ADMIN_THEME; ?>/js/sirTrevor/mce/sir-trevor-tinymce.js" type="text/javascript" charset="utf-8"></script>
      <script src="<?= ADMIN_THEME; ?>/js/sirTrevor/Button.js" type="text/javascript"></script>

   <script type="text/javascript">
       $(function(){

           //For Toolip
           $('[data-toggle="tooltip"]').tooltip();

           SirTrevor.config.debug = true;
           SirTrevor.config.scribeDebug = true;
           SirTrevor.config.language = "en";
           SirTrevor.setBlockOptions("Text", {
               onBlockRender: function() {
                  // console.log("Text block rendered");
               }
           });
           window.editor = new SirTrevor.Editor({
               el: $('.js-st-instance'),
               blockTypes: [
                   "Columns",
                   "Text",
                   "List",
                   "Quote",
                   "ImageExtended",
                   "Video",
                   "Tweet",
                   "Button",
                   "Iframe"
               ]
           });

           SirTrevor.onBeforeSubmit();
       });
      function formPreviewSubmit(){
           SirTrevor.onBeforeSubmit();
           //document.getElementById("descriptionPage").submit();
       }
       function formSubmit(){
           SirTrevor.onBeforeSubmit();
           document.getElementById("descriptionPage").submit();
       }

   </script>
