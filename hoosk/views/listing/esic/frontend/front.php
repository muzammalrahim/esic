
                                <div id="step-submission" class="steps step-2 listing-submission">
                                    <!--div class="text-center">
                                        <h2 class="margin-zero">Add Esic Listing</h2>
                                    </div-->
                                     <div class="col-blocks col-xs-12 col-sm-12">
                                        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                                            <label for="companyNameBox">
                                                    Company Name <span class="required-fields">*</span>
                                            </label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="companyName" id="companyNameBox" class="form-control" placeholder="Company Name"/>
                                            </div>
                                        </div>
                                        <div class="col-blocks col-xs-12  col-sm-6 col-md-6">
                                            <label for="websiteBox">
                                                    Website Name
                                            </label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="website" id="websiteBox" class="form-control" placeholder="Website"/>
                                            </div>
                                        </div>
                                         <div class="">
                                            <div class="col-blocks col-xs-12  col-sm-6 col-md-6">
                                                <label for="businessNameBox">
                                                        Business Name
                                                </label>
                                                <div class="form-group bg-shaded">
                                                    <input type="text" name="businessName" id="businessNameBox" class="form-control" placeholder="Business Name"/>
                                                </div>
                                             </div>
                                             <div class="col-blocks col-xs-12  col-sm-6 col-md-6">
                                                 <label for="businessNameBox">
                                                     ACN
                                                 </label>
                                                 <div class="form-group bg-shaded">
                                                     <input type="text" name="acn_number" id="ACNBox" class="form-control" placeholder="ACN"/>
                                                 </div>
                                             </div>
                                         </div>
                                    </div>
                                    <?= $AddressFields; ?>
                                    <div class="col-blocks col-md-12">
                                         <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                             <label for="AddressBox">
                                                Short Description
                                             </label>
                                            <div class="form-group address-group bg-shaded big-shade col-md-12">
                                                <textarea name="short_description" class="col-md-12 col-sm-12 col-xs-12"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                            <div class="col-xs-6 col-sm-4 col-md-2 register-button">
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
            if ($('input[name="companyName"]').val().length > 1) {
                var FormDataToSent = {};
                var companyName = $('input[name="companyName"]').val();
                var businessName = $('input[name="businessName"]').val();
                var website = $('input[name="website"]').val();
                var address_streetNumber = $('input[name="address_streetNumber"]').val();
                var address_streetName = $('input[name="address_streetName"]').val();
                var address_town = $('input[name="address_town"]').val();
                var address_state = $('select[name="address_state"]').val();
                var address_post_code = $('select[name="address_post_code"]').val();
                var short_description = $('textarea[name="short_description"]').val();
                var sacn_number = $('input[name="acn_number"]').val();

                if ($('input[name="userID"]').val().length > 0) {
                    var userID = $('input[name="userID"]').val();

                    FormDataToSent['userID'] = userID;
                    FormDataToSent['companyName'] = companyName;
                    FormDataToSent['businessName'] = businessName;
                    FormDataToSent['acn_number'] = sacn_number;
                    FormDataToSent['short_description'] = short_description;
                    FormDataToSent['website'] = website;
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
