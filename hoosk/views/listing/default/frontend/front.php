
                                <div id="step-submission" class="steps step-2 listing-submission">
                                    <!--div class="text-center">
                                        <h2 class="margin-zero">Add <?= $this->NameMessage;?> Listing</h2>
                                    </div-->
                                    <div class="col-blocks col-xs-12 col-sm-12">
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="<?= $this->ControllerRouteName;?>NameTextBox">
                                                <?= $this->NameMessage;?> Name <span class="required-fields">*</span>
                                            </label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="<?= $this->ControllerRouteName;?>Name" id="<?= $this->ControllerRouteName;?>NameTextBox" class="form-control" placeholder="<?= $this->NameMessage;?> Name"/>
                                            </div>
                                        </div> 
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="<?= $this->ControllerRouteName;?>EmailBox"><?= $this->NameMessage;?> Email</label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="<?= $this->ControllerRouteName;?>Email" id="<?= $this->ControllerRouteName;?>EmailBox" class="form-control" placeholder="<?= $this->NameMessage;?> Email"/>
                                            </div>
                                        </div> 
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="WebsiteBox">Website</label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="website" id="WebsiteBox" class="form-control" placeholder="<?= $this->NameMessage;?> Website"/>
                                            </div>
                                        </div> 
                                    </div>
                                    <?php if($this->Name == 'RndConsultant'){ ?>
                                    <div class="col-blocks col-xs-12 col-sm-12">
                                        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                                            <label for="workBox">Tell us what you do</label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="work" id="workBox" class="form-control" placeholder="Tell us what you do"/>
                                            </div>
                                        </div>
                                        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                                            <label for="projectnexperienceBox">Projects & Experience</label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="projectnexperience" id="projectnexperienceBox" class="form-control" placeholder="Projects & Experience"/>
                                            </div>
                                        </div>  
                                    </div>
                                    <?php } ?>
                                    <?= $AddressFields; ?>
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                            <label for="ShortDescriptionBox">Short Description</label>
                                            <div class="form-group bg-shaded textarea-group">
                                                <textarea type="text" name="short_description" id="ShortDescriptionBox" class="form-control"> </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                            <div class="col-xs-12 col-sm-4 col-md-2 register-button">
                                                <a href="#" id="SaveListing" class="btn btn-block btn-flat btn-primary">Save</a>
                                            </div>
                                            <!--div class="prev col-xs-12 col-sm-4 col-md-2">
                                                <a href="#" id="getUserAccountSection" class="btn btn-block btn-flat btn-primary">Prev</a>
                                            </div-->
                                        </div>
                                    </div>
                                </div>
<script type="text/javascript">
        function getFieldValuesForJson() {
            if ($('input[name="<?= $this->ControllerRouteName;?>Name"]').val().length > 1) {
                var FormDataToSent = {};
                var name = $('input[name="<?= $this->ControllerRouteName;?>Name"]').val();
                var email = $('input[name="<?= $this->ControllerRouteName;?>Email]').val();
                var website = $('input[name="website"]').val();


                var address_streetNumber = $('input[name="address_streetNumber"]').val();
                var address_streetName = $('input[name="address_streetName"]').val();
                var address_town = $('input[name="address_town"]').val();
                var address_state = $('select[name="address_state"]').val();
                var address_post_code = $('select[name="address_post_code"]').val();

                var short_description = $('textarea[name="short_description"]').val();


                <?php if($this->Name == 'RndConsultant'){ ?>
                var work = $('input[name="work"]').val();
                var projectnexperience = $('input[name="work"]').val();
                <?php } ?>

                if ($('input[name="userID"]').val().length > 0) {
                    var userID = $('input[name="userID"]').val();

                    FormDataToSent['userID'] = userID;

                    FormDataToSent['name'] = name;
                    FormDataToSent['email'] = email;
                    FormDataToSent['website'] = website;
                    FormDataToSent['short_description'] = short_description;

                    <?php if($this->Name == 'RndConsultant'){ ?>
                    FormDataToSent['work'] = work;
                    FormDataToSent['projectnexperience'] = projectnexperience;
                    <?php } ?>

                    FormDataToSent['address_street_number'] = address_streetNumber;
                    FormDataToSent['address_street_name'] = address_streetName;
                    FormDataToSent['address_town'] = address_town;
                    FormDataToSent['address_state'] = address_state;
                    FormDataToSent['address_post_code'] = address_post_code;
                    <?php if(!empty($ControllerRouteName)){ ?>
                    FormDataToSent['ControllerName'] = '<?= $ControllerRouteName;?>';
                    <?php } ?>
                    return FormDataToSent;
                } else {
                    Haider.notification('Please Get Register First', 'error');
                    return null;
                }
            } else {
                Haider.notification('Please Enter Company Name', 'error');
                return null;
            }
            return null;
        }
</script>
