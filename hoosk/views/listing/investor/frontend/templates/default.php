<?php
if(!isset($detail) || empty($detail)){
    return false;
}
if(empty($detail->website)){
    $redirectUrl =  base_url().$ListingName.'/'.$detail->slug;
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
                <a href="<?= $redirectUrl;?>" class="permalink" data-link= "<?= $detail->id;?>">
                    <img src="<?=$logoUrl;?>" alt="" class="item-logo"/>
                </a>
            </div>
			<div class="detail-box-container clearfix">
                <div class="layout-container">
                        <div class="detail-container main-details">
                            <div class="product-details">
                                    <label>Name:</label>
                                <a href="<?= base_url().$ListingName.'/'.$detail->slug; ?>" class="permalink" data-link= "<?= $detail->id;?>">
                                     <h3><?= $detail->name; ?></h3>

                                 </a>
                             </div>
                        <div class="product-details">
                            <label>Phone Number:</label>
                                <h3><?= $detail->phone ?></h3>
                        </div>
                        <div class="product-details">
                            <label>Website:</label>
                                <h3 class="view_website"><a href="<?= strpos($detail->website,'http')=== 0 ? $detail->website : 'http://'.$detail->website ?>" target="_blank"> <?= $detail->website ?></a></h3>
                        </div>
                        <div class="product-details">
                            <label>Email:</label>
                                <h3><?= $detail->email ?></h3>
                        </div>
                        <?php if(isset($detail->company_name) && !empty($detail->company_name)){ ?>
                        <div class="product-details">
                            <label>Company Name:</label>
                                <h3><?= $detail->company_name ?></h3>
                        </div>
                        <?php } ?>
                        <?php if(isset($detail->company_email) && !empty($detail->company_email)){ ?>
                        <div class="product-details">
                            <label>Company Email:</label>
                                <h3><?= $detail->company_email ?></h3>
                        </div>
                        <?php } ?>
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
						<?php if(isset($detail->TypeName) && !empty($detail->TypeName)){ ?>
							<div class="product-details">
								<label>Investor Type:</label>
								<h3>
									<?= $detail->TypeName; ?>
								</h3>
							</div>
						<?php } ?>
						<?php if(isset($detail->AmountLabel) && !empty($detail->AmountLabel)){ ?>
							<div class="product-details">
								<label>Preferred Investment Amount:</label>
								<h3>
									<?= $detail->AmountLabel; ?>
								</h3>
							</div>
						<?php } ?>
						<div class="clear"></div>
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
                             <?php } ?>
                        </div>
                    </div>
                    <?php if(isset($detail->about) && !empty($detail->about)){ ?>
	                    <div class="description">
	                        <h3>Introduction:</h3>
	                        <div>
	                            <p><?= $detail->about; ?></p>
	                        </div>
	                    </div>
                     <?php }?>
                </div>
			</div>
		</div>
</section>
