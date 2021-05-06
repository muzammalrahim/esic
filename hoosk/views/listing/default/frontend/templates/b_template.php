<?php
/*echo '<pre>';
print_r($detail);
echo '</pre>';*/
if(!isset($detail) || empty($detail)){
    return false;
}
if(empty($detail->website)){
    $redirectUrl =  base_url().$ListingName.'/'.$detail->alias;
}else{
    $redirectUrl = $detail->website;
}
if(!empty($detail->banner) && is_file(FCPATH.'/'.$detail->banner)){
    $bannerUrl =  base_url().$detail->banner;
}else{
    $bannerUrl =  getDefaultBannerUrl();
}
if(!empty($detail->logo) && is_file(FCPATH.'/'.$detail->logo)){
    $logoUrl =  base_url().$detail->logo;
}else{
    $logoUrl =  getDefaultLogoUrl();
}

if(isset($detail->doShowItems) and !empty($detail->doShowItems)){
    $doShowItems = json_decode($detail->doShowItems);
    $showLogo = ($doShowItems->showLogo === 'No')?false:true;
    $showBanner = ($doShowItems->showBanner === 'No')?false:true;
    $doShowShortDescriptionOnDetails = ($doShowItems->doShowShortDescriptionOnDetails === 'No')?false:true;
}else{
    $showLogo = $showBanner = $doShowShortDescriptionOnDetails = true;
}

if(!empty($detail->Status_ID)){
    switch($detail->Status_ID) {
        case 1:
            $Status = '<span class="featured-green">'.$detail->Status_Label.'</span>';
            break;
        case 2:
            $Status = '<span class="featured-red">'.$detail->Status_Label.'</span>';
            break;
        case 3:
            $Status = '<span class="featured-yellow">'.$detail->Status_Label.'</span>';
            break;
    }
}elseif(!empty($detail->prior_year_status)){
    $json        = json_decode($detail->prior_year_status, true);
    $arrays       = array();
    if($json) {
        foreach ($json as $status) {
            foreach ($esic_status_all as $esicstatus) {
                if ($esicstatus->id == $status['status']) {
                    $arr = array(
                        'year' => $status['year'],
                        'status_id' => $status['status'],
                        'status' => $esicstatus->status,
                        'color' => $esicstatus->color,
                    );
                    array_push($arrays, $arr);
                }
            }
        }
    }
}elseif(!empty($esic_status->status)){
    $Status = '<span style="background-color:'. $esic_status->color .';color:#ffffff;" class="btn btn-xs">'.$esic_status->status.'</span>';
}
else{
    $Status =  '';
}
$editBannerLogo = false;
$pencilEdits = false;
if($detail->showPreview){
    if(isset($detail->PreviewFrontEnd) && $detail->PreviewFrontEnd == true){
        $editBannerLogo = true;
        $pencilEdits = true;
        $addUrl = base_url();
    }else{
        $addUrl = '';
    }
    if(isset($file['logo'])){
        $logoUrl = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents( $file['logo']['tmp_name']));
    }else{
        if(!empty($detail->logo)){
            $logoUrl =  $addUrl.$detail->logo;
        }else{
            $logoUrl =  getDefaultLogoUrl();
        }
    }
    if(isset($file['banner'])){
        $bannerUrl = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents( $file['banner']['tmp_name']));
    }else{
        if(!empty($detail->banner)){
            $bannerUrl =  $addUrl.$detail->banner;
        }else{
            $bannerUrl =  getDefaultBannerUrl();
        }
    }
    
   if(isset($detail->PreviewBackEnd) && $detail->PreviewBackEnd == true){
        if(isset($detail->doShowLogo) && $detail->doShowLogo == 'on'){
            $showLogo = true;
        }else{
            $showLogo = false;
        }
        if(isset($detail->doShowBanner) && $detail->doShowBanner == 'on'){
            $showBanner = true;
        }else{
            $showBanner = false;
        }
        if(isset($detail->doShowShortDescriptionOnDetails) && $detail->doShowShortDescriptionOnDetails == 'on'){
            $doShowShortDescriptionOnDetails = true;
        }else{
            $doShowShortDescriptionOnDetails = false;
        }
    }
    if(empty($detail->name)){
        $detail->name = 'Name Here';
    }
    if(empty($detail->email)){
        $detail->email = 'Email Here';
    }
    if(empty($detail->website)){
        $detail->website = 'Website Address Here';
    }
    if(empty($detail->address_street_number)){
        $detail->address_street_number = '#1234';
    }
    if(empty($detail->address_street_name)){
        $detail->address_street_name = 'ST red';
    }
    if(empty($detail->address_town)){
        $detail->address_town = 'Down Town';
    }
    if(empty($detail->address_state)){
        $detail->address_state = 'Australian Capital Territory';
    }
    if(empty($detail->address_post_code)){
        $detail->address_post_code = '0000';
    }
    if(empty($detail->facebook)){
        $detail->facebook = '#';
    }
    if(empty($detail->twitter)){
        $detail->twitter = '#';
    }
    if(empty($detail->google)){
        $detail->google = '#';
    }
    if(empty($detail->linkedIn)){
        $detail->linkedIn = '#';
    }
    if(empty($detail->youTube)){
        $detail->youTube = '#';
    }
    if(empty($detail->vimeo)){
        $detail->vimeo = '#';
    }
    if(empty($detail->instagram)){
        $detail->instagram = '#';
    }
    if(empty($detail->long_description)){
        $detail->long_description = '';
    }
                  
                                
}
if($showBanner){ ?>
<div class="template-b">
    <div class="background-img-container banner-box" style="">
        <img src="<?=$bannerUrl;?>" id="Banner-show" alt="" class="left">
        <?php if($editBannerLogo){ ?>
        <div class="edit-tool edit-banner">
            <label for="Banner-file" class="btn"><i class="fa fa-camera"></i> Change Banner</label>
            <input type="file" name="banner" id="Banner-file" style="visibility:hidden;">
        </div>
        <?php } ?>
    </div>
    <?php } ?>
    <section class="listing">
        <div class="container">
            <div class="detail-box-container clearfix">
                <?php if($showLogo){ ?>
                <div class="col-md-4">
                    <div class="logo-area logo-box">
                        <div class="logo_img">
                            <span>
                                <img src="<?=$logoUrl;?>" alt="" id="Logo-show" class="item-logo"/>
                            </span>
                        </div>
                        <?php if($editBannerLogo){ ?>
                        <div class="edit-tool edit-logo">
                            <label for="Logo-file" class="btn"><i class="fa fa-camera"></i> Change Logo</label>
                            <input type="file" name="logo" id="Logo-file" style="visibility:hidden;">
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
                <div class="col-md-8">
                    <div class="layout-container">
                        <div class="main-details">
                            <div class="product-details editable-input" data-edit="input" data-column="name">
                                <label>Name:</label>
                                <a <?php if(!$detail->showPreview) { ?>
                                    href="<?= base_url().$ListingName.'/'.$detail->alias; ?>"
                                    <?php } ?> class="permalink" data-link= "<?= $detail->id;?>">
                                    <h3><?= $detail->name; ?></h3>
                                </a>
                                <?php
                                if($pencilEdits){
                                    echo '<span style="display:none;"><i class="fa fa-pencil"></i></span>';
                                }
                                ?>
                            </div>
                            <div class="product-details editable-input" data-edit="input" data-column="website">
                                <label>Website:</label>
                                <h3 class="view_website"><a href="<?= strpos($detail->website,'http')=== 0 ? $detail->website : 'http://'.$detail->website ?>" target="_blank"> <?= $detail->website ?></a></h3>

                                <?php
                                if($pencilEdits){
                                    echo '<span style="display:none;"><i class="fa fa-pencil"></i></span>';
                                }
                                ?>
                            </div>
                             <?php if(
                                    !empty($detail->address_street_number) 
                                    || !empty($detail->address_street_name)
                                    || !empty($detail->address_town)
                                    || !empty($detail->address_state)){ ?>
                            <div class="product-details editable-input" data-edit="address" data-column="address">
                                <label>Address:</label>
                                <h3>
                                    <?= $detail->address_street_number ?>
                                    <?= $detail->address_street_name ?>,
                                    <?= $detail->address_town ?>
                                    <?= $detail->address_state ?>
                                    <?= $detail->address_post_code ?>
                                </h3>

                                <?php
                                if($pencilEdits){
                                    echo '<span style="display:none;"><i class="fa fa-pencil"></i></span>';
                                }
                                ?>
                            </div>
                            <?php } ?>
                            <?php if(!empty($Status)){ ?>
                                <div class="product-details">
                                    <label>Status:</label>
                                    <?= $Status; ?>

                                    <?php
                                    if($pencilEdits){
                                        echo '<span style="display:none;"><i class="fa fa-pencil"></i></span>';
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                            <?php
                            if($arrays){
                                $inc=1;
                                foreach ($arrays as $ar){
                                    if($inc>3){break;}
                                    ?>
                                    <div class="product-details editable-input">
                                    <label>Status:</label> <?= $ar['year'] ?> <p style="background-color:<?= $ar['color'] ?>;color:#ffffff" class="btn btn-xs"> <?= $ar['status']; ;?>  </p><br>
                                    </div><?php
                                    $inc++;
                                }
                            } ?>
                        </div>
                    </div>
                    <div class="social_section">
                        <div class="social_content">
                            <?php  if(!empty($detail->facebook)){ ?>
                                <a class="btn btn-primary" style="background-color: #4867aa;"
                                   href="<?= $detail->facebook;?>" target="_blank" >
                                    <span class="fa fa-facebook">&nbsp;</span>
                                </a>
                            <?php } if(!empty($detail->twitter)){ ?>
                                <a class="btn btn-primary" style="background-color: #1da1f2;"
                                   href="<?=$detail->twitter;?>" target="_blank" >
                                    <span class="fa fa-twitter">&nbsp;</span>
                                </a>
                            <?php } if(!empty($detail->google)){ ?>
                                <a class="btn btn-primary" style="background-color: #db4437;"
                                   href="<?=$detail->google;?>" target="_blank" >
                                    <span class="fa fa-google-plus">&nbsp;</span>
                                </a>
                            <?php } if(!empty($detail->linkedIn)){ ?>
                                <a class="btn btn-primary" style="background-color: #0077b5;"
                                   href="<?=$detail->linkedIn;?>" target="_blank" >
                                    <span class="fa fa-linkedin">&nbsp;</span>
                                </a>
                            <?php } if(!empty($detail->youTube)){ ?>
                                <a class="btn btn-primary" style="background-color: #e12b28;"
                                   href="<?=$detail->youTube;?>" target="_blank" >
                                    <span class="fa fa-youtube">&nbsp;</span>
                                </a>
                            <?php } if(!empty($detail->vimeo)){ ?>
                                <a class="btn btn-primary" style="background-color: #00b3ec;"
                                   href="<?=$detail->vimeo;?>" target="_blank" >
                                    <span class="fa fa-vimeo">&nbsp;</span>
                                </a>
                            <?php } if(!empty($detail->instagram)){ ?>
                                <a class="btn btn-primary" style="background-color: #ef0b14;"
                                   href="<?=$detail->instagram;?>" target="_blank" >
                                    <span class="fa fa-instagram">&nbsp;</span>
                                </a>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail-box-container clearfix">
                <div class="col-md-12">
                    <?php 
                    /*if(isCurrentUserAdmin($this)){ ?>
                        <div class="editing">
                            <a href="<?= base_url().'admin/'.$ListingName.'/view/'.$detail->ListID; ?>" class="btn btn-primary pull-right">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?php } */
                    ?>
                    <div class="description">
                        <div class="product-details editable-input" data-edit="textarea" data-column="short_description">
                            <strong>Short Description:</strong>
                            <?php if($pencilEdits){ echo '<span style="display:none;"><i class="fa fa-pencil"></i></span>'; } ?>
                        </div>
                                <!--h3 class="content-heading-h3">Introduction:</h3-->
                                <div class="short-descrp">
                                    <p style="width:100%"><?= !empty($detail->short_description) ? $detail->short_description: '...'; ?></p>
                                </div>
                            <?php if(!empty($detail->about)){?>
                                <!--h3 class="content-heading-h3">About:</h3-->
                                <div>
                                    <p><?= $detail->about; ?></p>
                                </div>
                            <?php } ?>
                            <?php if(!empty($detail->long_description)){?>
                                <!--h3 class="content-heading-h3">Description:</h3-->
                                <div>
                                    <p><?= $detail->long_description; ?></p>
                                </div>
                            <?php } ?>
                    </div>
                </div>
                <div class="col-md-12">
                        <div class="listing-linked-container">
                            <div class="offer-details-team-section">
                                <?php 
                                    if(isset($ListingValues) && !empty($ListingValues)){
                                        $listingDefaultLogoUrl =  getDefaultLogoUrl();
                                        foreach ($ListingValues as $key => $ListingValue) { ?>
                                            <div class="od-team-section-block">
                                                <a target="_blank" href="<?=base_url().$ListingValue->type.'/'.$ListingValue->slug;?>" class="main-link-listing">
                                                <div class="img-container-listing">
                                                    <?php 
                                                        if(!empty($ListingValue->Logo) && is_file(FCPATH.'/'.$ListingValue->Logo)){
                                                            $listingLogoUrl = base_url().$ListingValue->Logo;
                                                        }else{
                                                            $listingLogoUrl = $listingDefaultLogoUrl;
                                                        }
                                                        $color = '';
                                                        if(!empty($ListingValue->color)){
                                                            $color = $ListingValue->color;
                                                        }
                                                    ?>
                                                      <img src="<?=$listingLogoUrl;?>" class="" alt="">
                                                    <div class="detail-container-listing">
                                                        <span class="listing-name"><?=$ListingValue->Name;?></span>
                                                        <span class="type-label" style="background: <?=$color;?>"><?= $ListingValue->label; ?></span>
                                                    </div>
                                                </div>
                                                 </a>
                                            </div>
                                <?php 
                                        }    
                                    } 
                                ?>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </section>
</div>

<?php $this->load->view('listing/temp_js') ?>
