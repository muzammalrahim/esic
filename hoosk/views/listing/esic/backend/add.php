
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url().$ControllerRouteName.'/AddSave';?>" method="post" class="form" enctype="multipart/form-data">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Add <?= $ListingLabel ; ?></h3>
                            <div class="add-New-container">
                                <a href="<?= base_url().$ControllerRouteName.'/Listing';?>" class="addNewBtn">Summary</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" id="hiddenListID" value="">
                                <div class="col-md-12">
                                <!--label for="NewUserDetails">Esic Details:</label-->
                                    <div class="form-group">
                                        <label for="NameTextBox">Esic Name</label>
                                        <input type="text" name="name" id="NameTextBox" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="EmailBox">Email</label>
                                        <input type="text" name="email" id="EmailBox" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="WebsiteBox">Website</label>
                                        <input type="text" name="website" id="WebsiteBox" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="AddressBox">Address :</label>
                                        <div class="row">
                                            <div class="form-group col-lg-2">
                                                <label for="address_street_number">Street Number</label>
                                                <input type="text" name="address_street_number" id="address_street_number" class="form-control">
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label for="address_street_name">Street Name</label>
                                                <input type="text" name="address_street_name" id="address_street_name" class="form-control">
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label for="address_town">Town</label>
                                                <input type="text" name="address_town" id="address_town" class="form-control">
                                            </div>

                                            <div class="form-group col-lg-3">
                                                <label for="address_state">State</label>
                                                    <select class="form-control customSelect2" name="address_state" id="address_state" placeholder="State">
                                                        <?php
                                                            if(isset($selectors) and !empty($selectors['states'])){
                                                                foreach ($selectors['states'] as $state) {
                                                                    if(!empty($state)){
                                                                        echo '<option value="' . $state['Value'] . '">' . $state['State'] . '</option>';
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label for="address_post_code">Post Code</label>
                                                <select class="form-control " name="address_post_code" id="address_post_code">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="BusinessBox">Business Name</label>
                                        <input type="text" name="business" id="BusinessBox" class="form-control" />
                                    </div>
                                    <div class="row dates-container">
                                        <div class="col-md-4 form-group">
                                            <label for="IncorporateDateBox">Incorporation Date</label>
                                            <input type="text"  placeholder="E.g <?=Date('d-m-Y')?>" name="corporate_date" id="IncorporateDateBox" class="DateBox form-control date_picker"/>
                                        </div>
                                         <?php if(isCurrentUserAdmin($this)){ ?>
                                        <div class="col-md-4 form-group">
                                            <label for="AddedDateBox">Added Date</label>
                                            <input type="text" name="added_date" id="AddedDateBox" class="DateBox form-control date_picker" placeholder="E.g <?=Date('d-m-Y')?>"/>
                                        </div>
                                        <?php } ?>
                                        <?php
                                        //echo '<div class="col-md-4 form-group">
                                         //   <label for="ExpiryDateBox">Expiry Date</label>
                                         //   <input type="text" name="expiry_date" id="ExpiryDateBox" class="form-control date_picker" />
                                        //</div>';
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="ACNBox">ACN #</label>
                                        <input type="text" name="acn_number" id="ACNBox" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="ShortDescriptionBox">Short Description of Business</label>
                                        <textarea type="text" name="short_description" id="ShortDescriptionBox" class="form-control"> </textarea>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="KeywordsBox">Keywords</label>
                                            <input type="text" name="keywords" id="KeywordsBox" class="form-control" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Ranking score">Boost your ESIC points</label>
                                            <input type="number" max="100" min="0" name="ranking_score" id="ranking_score" class="form-control" />
                                        </div>
                                    </div>

<!--                                    --><?php //if(isCurrentUserAdmin($this)){ ?>
<!--                                     <div class="form-group">-->
<!--                                        <label for="statusFlagBox">Status</label>-->
<!--                                        <select id="statusFlagBox" name="Publish" class="form-control select2-active">-->
<!--                                            --><?php //
//                                                if(isset($itemStatuses) || !empty($itemStatuses)){
//                                                    foreach ($itemStatuses as $key => $itemStatus) {
//                                             ?><!--         <option value="--><?php //= $itemStatus->id; ?><!--"> --><?php //= $itemStatus->Label; ?><!--</option>-->
<!--                                            --><?php //
//                                                    }
//                                                }
//                                            ?>
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                    --><?php //} ?>
                                    <div class="form-group">
                                        <label for="update-logo-file">Logo</label>
                                        <div class="img-reponsive">
                                            <div class="img-container img-logo img-responsive">
                                                <img src="<?= base_url()?>pictures/defaultLogo.png" class="Logo-show" id="Logo-show" />
                                            </div>
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <span class="btn btn-file btn-logo-edit"><span class="fileupload-new">Click To</span><span class="fileupload-exists"> Add</span>
                                                    <input type="file" name="Logoimage" id="Logo-file"  />
                                                </span>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="update-Banner-file">Banner</label>
                                        <div class="img-reponsive">
                                            <div class="img-container img-logo img-responsive">
                                                <img src="<?= base_url()?>pictures/defaultLogo.png" class="banner-show" id="banner-show" />
                                            </div>
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <span class="btn btn-file btn-logo-edit"><span class="fileupload-new">Click To</span><span class="fileupload-exists"> Add</span>
                                                    <input type="file" name="Bannerimage" id="banner-file"  />
                                                </span>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="update-product-file">Product</label>
                                        <div class="img-reponsive">
                                            <div class="img-container img-logo img-responsive">
                                                <img src="<?= base_url()?>pictures/defaultLogo.png" class="product-show" id="product-show" />
                                            </div>
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <span class="btn btn-file btn-logo-edit"><span class="fileupload-new">Click To</span><span class="fileupload-exists"> Add</span>
                                                    <input type="file" name="productImage" id="product-file"  />
                                                </span>
                                            </div>
                                       </div>
                                    </div>
                                    <!--div class="form-group">
                                        <label for="update-CoDevelopmentAgreement-file">CO-Development Agreement</label>
                                        <div class="file-reponsive">
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <span class="btn btn-file btn-logo-edit"><span class="fileupload-new">Click To</span><span class="fileupload-exists"> Edit</span>
                                                    <input type="file" name="CoDevelopmentAgreement" id="CoDevelopmentAgreement-file"  />
                                                </span>
                                            </div>
                                       </div>
                                    </div-->
                                </div>
                                <div class="col-md-12">
                                    <div class="social-container">
                                        <label for="AddressBox">Social Links:</label>
                                        <div class="row">
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="FacebookLink">Facebook</label>
                                                <input type="text" name="facebook" id="FacebookLink" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="TwitterLink">Twitter</label>
                                                <input type="text" name="twitter" id="TwitterLink" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="GoogleLink">Google Plus</label>
                                                <input type="text" name="google" id="GoogleLink" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="LinkedInLink">LinkedIn</label>
                                                <input type="text" name="linkedIn" id="LinkedInLink" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="InstagramLink">Instagram</label>
                                                <input type="text" name="instagram" id="InstagramLink" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="YoutubeLink">Youtube</label>
                                                <input type="text" name="youTube" id="YoutubeLink" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="VimeoLink">Vimeo</label>
                                                <input type="text" name="vimeo" id="VimeoLink" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="template-container">
                                        <label for="TemplatesBox">Template Block:</label>
                                        <div class="row">
                                          <?php if(isset($templates) && !empty($templates)){ ?>
                                            <div class="form-group col-md-6">
                                              <label for="TemplatesBox">Templates:</label>
                                                <select id="templateFlagBox" name="template" class="form-control select2-active">
                                                <?php foreach($templates as $key => $value) {?>
                                                    <option value="<?= $value->id;?>"><?= $value->name;?></option>
                                                <?php } ?>
                                                </select>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="button-container">
                                <input type="submit" class="btn btn-primary" value="Save" />
<!--                                <input type="button" class="btn btn-primary" value="Preview"/>-->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.col -->
        </div>