<?php

if(!isset($detail) || empty($detail)){
    return false;
}
if(empty($detail->website)){
    $redirectUrl =  base_url().$ListingName.'/'.$detail->alias;
}else{
    $redirectUrl = $detail->website;
}
if(strpos($detail->banner, 'http') === false){

    if(!empty($detail->banner) && is_file(FCPATH.'/'.$detail->banner)){
        $bannerUrl =  base_url().$detail->banner;
    }else{
        $bannerUrl =  getDefaultBannerUrl();
    }
}else{
    if(!empty($detail->banner)){
        $bannerUrl =  $detail->banner;
    }else{
        $bannerUrl =  getDefaultBannerUrl();
    }

}

if(strpos($detail->logo, 'http') === false){

    if(!empty($detail->logo) && is_file(FCPATH.'/'.$detail->logo)){
        $logoUrl =  base_url().$detail->logo;
    }else{
        $logoUrl =  getDefaultLogoUrl();
    }
}else{
    if(!empty($detail->logo)){
        $logoUrl =  $detail->logo;
    }else{
        $logoUrl =  getDefaultLogoUrl();
    }
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
        default:
            $Status = '<span class="featured-yellow"> </span>';
            break;
    }
}else{
    $Status =  '';
}
?>
<div class="background-img-container">
    <img src="<?=$bannerUrl;?>" alt="" class="left">
</div>
<section class="listing">
    <div class="container">
        <div class="img-container logo-container">
            <?php  $redirectUrl = strpos($redirectUrl ,'http') === false ?  'http://'.$redirectUrl : $redirectUrl ;?>
            <a href="<?= $redirectUrl;?>"  target="_blank"  class="permalink" data-link= "<?= $detail->id;?>">
                <img src="<?=$logoUrl;?>" alt="" class="item-logo"/>
            </a>
        </div>
        <div class="detail-box-container clearfix">
            <div class="layout-container">
                <?php if(isCurrentUserAdmin($this)){ ?>
                    <a href="<?= base_url().'admin/'.$ListingName.'/view/'.$detail->ListID; ?>" class="btn btn-primary pull-right" style="margin-top: -60px;">
                        <i class="fa fa-pencil"></i>
                    </a>
                <?php } ?>
                <div class="detail-container main-details">
                    <div class="product-details">
                        <label>Name:</label>
                        <a href="<?= base_url().$ListingName.'/'.$detail->alias; ?>" class="permalink" data-link= "<?= $detail->id;?>">
                            <h3><?= $detail->name; ?></h3>

                        </a>
                    </div>
                    <div class="product-details">
                        <label>Phone Number:</label>
                        <h3><?= $detail->phone ?></h3>
                    </div>
                    <div class="product-details">
                        <labe>Website:</labe>
                        <h3  class="view_website"><a href="<?= strpos($detail->website,'http') === 0 ? $detail->website : 'http://'.$detail->website ?>" target="_blank"> <?= $detail->website ?></a></h3>
                    </div>
                    <div class="product-details">
                        <label>Email:</label>
                        <h3><?= $detail->email ?></h3>
                    </div>
                    <div class="product-details">
                        <label>Address:</label>
                        <h3>
                            <?= $detail->address_street_number ?>
                            <?= $detail->address_street_name ?>,
                            <?= $detail->address_town ?>
                            <?= $detail->address_state ?>
                            <?= $detail->address_post_code ?>
                        </h3>
                    </div>
                    <?php if(!empty($Status)){ ?>
                        <div class="product-details">
                            <label>Status:</label>
                            <?= $Status; ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="detail-container main-dates-container">
                    <div class="social_section">
                        <h3>Social Links</h3>
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
                <div class="description">
                    <h3>Introduction:</h3>
                    <div>
                        <p><?= $detail->short_description; ?></p>
                    </div>
                    <h3>Description:</h3>
                    <div>
                        <p><?= $detail->long_description; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>