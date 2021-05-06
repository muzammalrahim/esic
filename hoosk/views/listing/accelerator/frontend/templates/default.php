<?php
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
            <a href="<?= $redirectUrl;?>" target="_blank" class="permalink" data-link= "<?= $detail->id;?>">
                <img src="<?=$logoUrl;?>" alt="" class="item-logo"/>
            </a>
        </div>
        <div class="detail-box-container clearfix">
            <div class="layout-container">
                <div class="detail-container main-details">
                    <div class="product-details">
                        <label>Name:</label>
                        <a href="<?= base_url().$ListingName.'/'.$detail->alias; ?>" class="permalink" data-link= "<?= $detail->id;?>">
                            <h3><?= $detail->name; ?></h3>

                        </a>
                    </div>
                    <div class="product-details">
                        <label>Phone:</label>
                            <h3><?= $detail->Program_Application_Contact; ?></h3>
                    </div>
                    <?php
                    if(!empty($detail->Program_Criteria)){
                        ?>
                        <div class="product-details">
                            <label>Program Criteria:</label>
                            <h3><?= $detail->Program_Criteria ?></h3>
                        </div>
                    <?php
                    }//End of If Statement
                    ?>

                    <div class="product-details">
                        <label >Website:</label>
                        <h3 class="view_website"><a href="<?= strpos($detail->website,'http')=== 0 ? $detail->website : 'http://'.$detail->website ?>" target="_blank"> <?= $detail->website ?></a></h3>
                    </div>
                    <?php
                        if(isset($detail->email)){
                            ?>
                            <div class="product-details">
                                <label>Email:</label>
                                <h3><?= $detail->email ?></h3>
                            </div>
                    <?php
                        }
                    ?>

                    <?php
                    if($detail->address){
                        ?>
                        <div class="product-details">
                            <label>Address:</label>
                            <h3>
                                <?= $detail->address ?>
                            </h3>
                        </div>
                        <div class="product-details">
                            <label>Post Code:</label>
                            <h3>
                                <?= $detail->post_code ?>
                            </h3>
                        </div>
                        <div class="product-details">
                                <label>Status:</label>
                            <h3>
                                <?= $detail->AcceleratorStatus ?>
                            </h3>
                        </div>
                    <?php
                    }//End of If Address
                    ?>

                    <?php if(!empty($Status)){ ?>
                        <div class="product-details">
                            <label>Status:</label>
                            <?= $Status; ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="detail-container main-dates-container">
                    <?php
                        //Dont Show the Social Section if No Social Exists.
                    //Will Work on this Later. Haider.
                    ?>
                    <div class="social_section">
                        <h3>Social Links</h3>
                        <?php  if(!empty($detail->facebook)){ ?>
                            <a class="btn btn-primary" style="background-color: #4867aa;"
                               href="<?= $detail->facebook;?>">
                                <span class="fa fa-facebook">&nbsp;</span>
                            </a>
                        <?php } if(!empty($detail->twitter)){ ?>
                            <a class="btn btn-primary" style="background-color: #1da1f2;"
                               href="<?=$detail->twitter;?>">
                                <span class="fa fa-twitter">&nbsp;</span>
                            </a>
                        <?php } if(!empty($detail->google)){ ?>
                            <a class="btn btn-primary" style="background-color: #db4437;"
                               href="<?=$detail->google;?>">
                                <span class="fa fa-google-plus">&nbsp;</span>
                            </a>
                        <?php } if(!empty($detail->linkedIn)){ ?>
                            <a class="btn btn-primary" style="background-color: #0077b5;"
                               href="<?=$detail->linkedIn;?>">
                                <span class="fa fa-linkedin">&nbsp;</span>
                            </a>
                        <?php } if(!empty($detail->youTube)){ ?>
                            <a class="btn btn-primary" style="background-color: #e12b28;"
                               href="<?=$detail->youTube;?>">
                                <span class="fa fa-youtube">&nbsp;</span>
                            </a>
                        <?php } if(!empty($detail->vimeo)){ ?>
                            <a class="btn btn-primary" style="background-color: #00b3ec;"
                               href="<?=$detail->vimeo;?>">
                                <span class="fa fa-vimeo">&nbsp;</span>
                            </a>
                        <?php } if(!empty($detail->instagram)){ ?>
                            <a class="btn btn-primary" style="background-color: #ef0b14;"
                               href="<?=$detail->instagram;?>">
                                <span class="fa fa-instagram">&nbsp;</span>
                            </a>
                        <?php }?>
                    </div>
                </div>
                <div class="description">
                    <h3>Program Summary:</h3>
                    <div>
                        <p><?= $detail->Program_Summary; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
