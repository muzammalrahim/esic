
                                <div id="step-submission" class="steps step-2 listing-submission">
                                    <!--div class="text-center">
                                        <h2 class="margin-zero">Add Accelerator Listing</h2>
                                    </div-->
                                    <div class="col-blocks col-xs-12 col-sm-12">
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="AcceleratorNameTextBox">
                                                Accelerator Name <span class="required-fields">*</span>
                                            </label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="acceleratorName" id="AcceleratorNameTextBox" class="form-control" placeholder="Accelerators Name"/>
                                            </div>
                                        </div>
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="acceleratorEmailBox">Accelerator Email</label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="acceleratorEmail" id="acceleratorEmailBox" class="form-control" placeholder="Accelerators Email"/>
                                            </div>
                                        </div>
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="WebsiteBox">Website</label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="website" id="WebsiteBox" class="form-control" placeholder="Accelerators Website"/>
                                            </div>
                                        </div>
                                    </div>
                                    <?= $AddressFields; ?>
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="programCriteriaBox">Program Criteria</label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="Program_Criteria" id="programCriteriaBox" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="ProgramStartDateBox">Program Start Date</label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="Program_Start_Date" id="ProgramStartDateBox" class="form-control date_picker" />
                                            </div>
                                        </div>
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="ProgramApplicationContactBox">Program Application Contact</label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="Program_Application_Contact" id="ProgramApplicationContactBox" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="Program_Application_Method">Program Application Method</label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="Program_Application_Method" id="Program_Application_Method" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                            <label for="programSummaryBox">Program Summary</label>
                                            <div class="form-group bg-shaded">
                                                <textarea type="text" name="Program_Summary" id="programSummaryBox" class="form-control"> </textarea>
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
    function getFieldValuesForJson(){
        if($('input[name="acceleratorName"]').val().length > 1){
                    var FormDataToSent = {};
                    var acceleratorName  = $('input[name="acceleratorName"]').val();
                    var acceleratorEmail = $('input[name="acceleratorEmail"]').val();

                    var website = $('input[name="website"]').val();

                    var address_streetNumber = $('input[name="address_streetNumber"]').val();
                    var address_streetName   = $('input[name="address_streetName"]').val();
                    var address_town         = $('input[name="address_town"]').val();
                    var address_state        = $('select[name="address_state"]').val();
                    var address_post_code    = $('select[name="address_post_code"]').val();

                    var Program_Criteria   = $('input[name="Program_Criteria"]').val();
                    var Program_Start_Date = $('input[name="Program_Start_Date"]').val();
                    var Program_Application_Contact = $('input[name="Program_Application_Contact"]').val();
                    var Program_Application_Method  = $('input[name="Program_Application_Method"]').val();
                    var Program_Summary    = $('textarea[name="Program_Summary"]').val();

                    if($('input[name="userID"]').val().length > 0){
                        var userID  = $('input[name="userID"]').val();

                        FormDataToSent['userID']  = userID;

                        FormDataToSent['acceleratorName']  = acceleratorName;
                        FormDataToSent['acceleratorEmail'] = acceleratorEmail;
                        FormDataToSent['website']  = website;

                        FormDataToSent['address_street_number'] = address_streetNumber;
                        FormDataToSent['address_street_name']   = address_streetName;
                        FormDataToSent['address_town']          = address_town;
                        FormDataToSent['address_state']         = address_state;
                        FormDataToSent['address_post_code']      = address_post_code;


                        FormDataToSent['Program_Criteria']   = Program_Criteria;
                        FormDataToSent['Program_Start_Date'] = Program_Start_Date;
                        FormDataToSent['Program_Application_Contact']= Program_Application_Contact;
                        FormDataToSent['Program_Application_Method'] = Program_Application_Method;
                        FormDataToSent['Program_Summary'] = Program_Summary;

                        <?php if(!empty($ControllerRouteName)){ ?>
                            FormDataToSent['ControllerName'] = '<?= $ControllerRouteName;?>';
                        <?php } ?>
                        return FormDataToSent;
                    }else{
                        Haider.notification('Please Get Register First','error');
                        return null;
                    }
        }else{
            Haider.notification('Please Enter Accelerator Name','error');
            return null;
        }
        return null;
    }
</script>
