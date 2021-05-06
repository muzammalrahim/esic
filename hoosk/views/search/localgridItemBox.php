<?php
if($counter == 0){
     echo '<row>';
}
if($counter%3 == 0){

echo '</row>';
echo '<div class="clear"></div>';
echo '<row>';
} ?>
<div   class="change_layout col-md-4">

  
    
    <a href="<?=getSlugURL($row['slug'],$row['type'])?>" target="_blank">
    <div class="proposal-card">
        <div class="proposal-bnr-block">
            <div class="proposal-bnr bg-6" style="background-image: url(<?=srcListingBannerImage((isset($row['banner'])?$row['banner']:''))?>); background-size:cover">
<!--                <span class="ad-label label label-danger"> Featured </span>-->
                <div>
                    <img class="proposal-logo" src="<?=srcImage($row['logo'])?>" alt="Proposal Logo">
                </div>
            </div>
        </div>
        <!--<div class="progress profile-complition text-right">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                <span class="sr-only"> 0% <span class="editableLabel" labelid="global:raised">raised</span>
                                    <i class="down"></i>
                </span>
            </div>
        </div>-->
        <span style="width: 100%" class="boxTag label label-success pull-right"><?=$label?></span>
        <div class="caption">
            <h3 class="captionheading"><?php
                    echo $row['name'];
                ?>
            </h3>
            <p class="webAddress"><?=trim($row['website'])?></p>
            <p class="webAddress"> Postcode  <?=trim($row['address_post_code'])?>  </p>
            <p class="webAddress"> ESIC Points  <?=trim($row['ranking_score'])?>  </p>
            <p class="short-summary"><?= strip_tags(trim(substr($row['summary'], 0, 165)))?></p>
            <div>
               <span class="btn btn-default" >Read More   </span>
            </div>
        </div>
    </div>
    </a>
</div>
