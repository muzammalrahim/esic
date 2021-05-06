<style type="text/css">
    .proposal-bnr{
        height:300px;
    }
    .proposal-bnr div{
        vertical-align: bottom;
    }
    .proposal-bnr div > a{
        display: block;
        margin-bottom:10px;
    }
    .caption > h3 > a{
        font-size:14pt;
    }
    .proposal-card .caption p.short-summary{
        font-size:12px;
    }
    .caption > p.short-summary{
        max-height: 66px;
        min-height: 0px;
        height:auto;
    }
</style>
<div class="col-md-12">
    <a href="<?=getSlugURL($row['slug'],$row['type'])?>" target="_blank">
    <div class="proposal-card cards-changed">
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
            <h3 class="captionheading">
                <?php
                    echo $row['name'];
                ?>
            </h3>
            <p class="webAddress"><?=trim($row['website'])?></p>
            <p class="short-summary"><?=strip_tags(trim($row['Summary']))?></p>
            <div>
               <span class="btn btn-default" >Read More</span>
            </div>
        </div>
    </div>
    </a>
</div>
