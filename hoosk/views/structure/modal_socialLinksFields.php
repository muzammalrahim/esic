<?php
$socialDetails = getListingSocialInfo($this,$detail->id,$detail->userID);
?>
<div class="col-md-12">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group col-md-4">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                <input id="email" type="text" class="form-control" name="facebook" placeholder="facebook" value="<?=isset($socialDetails->facebook)?$socialDetails->facebook:'';?>">
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                <input id="email" type="text" class="form-control" name="twitter" placeholder="twitter" value="<?=isset($socialDetails->twitter)?$socialDetails->twitter:'';?>">
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-google-plus"></i></span>
                <input id="email" type="text" class="form-control" name="google" placeholder="google +" value="<?=isset($socialDetails->google)?$socialDetails->google:'';?>">
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-linkedin"></i></span>
                <input id="email" type="text" class="form-control" name="linkedIn" placeholder="linkedin" value="<?=isset($socialDetails->linkedIn)?$socialDetails->linkedIn:'';?>">
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-youtube"></i></span>
                <input id="email" type="text" class="form-control" name="youTube" placeholder="youtube" value="<?=isset($socialDetails->youTube)?$socialDetails->youTube:'';?>">
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-vimeo"></i></span>
                <input id="email" type="text" class="form-control" name="vimeo" placeholder="vimeo" value="<?=isset($socialDetails->vimeo)?$socialDetails->vimeo:'';?>">
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                <input id="email" type="text" class="form-control" name="instagram" placeholder="instagram" value="<?=isset($socialDetails->instagram)?$socialDetails->instagram:'';?>">
            </div>
        </div>
    </div>
</div>
