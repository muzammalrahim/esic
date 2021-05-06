
                                <div id="step-submission" class="steps step-2 listing-submission">
                                     <!--div class="text-center">
                                        <h2 class="margin-zero">Add Accelerator Listing</h2>
                                    </div-->
                                    <div class="col-blocks col-xs-12 col-sm-12">
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="ProgrammeMemberNameTextBox">
                                                Programme Member Name <span class="required-fields">*</span>
                                            </label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="Member" id="ProgrammeMemberNameTextBox" class="form-control" placeholder="Programme Member Name"/>
                                            </div>
                                        </div> 
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="memberEmailBox">Member Email</label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="memberEmail" id="memberEmailBox" class="form-control" placeholder="Member Email"/>
                                            </div>
                                        </div> 
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="MemberWebsiteBox">Website</label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="website" id="MemberWebsiteBox" class="form-control" placeholder="Member Website"/>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                        <label for="projectTitleBox">Project Title</label>
                                        <div class="form-group bg-shaded">
                                            <input type="text" name="Project_Title" id="projectTitleBox" class="form-control" />
                                        </div>
                                    </div>
                                    <?= $AddressFields; ?>
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                            <label for="programSummaryBox">Program Summary</label>
                                            <div class="form-group bg-shaded">
                                                <textarea type="text" name="Program_Summary" id="programSummaryBox" class="form-control"> </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Address with multiple columns-->
                                    <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                        <label for="address">Project Location</label>
                                        <div class="form-group bg-shaded">
                                            <input type="text" name="Project_Location" id="address" class="form-control">
                                        </div>
                                        <div class="form-group">
                                                <label for="state">State Territory</label>
                                                <div class="form-group bg-shaded">
                                                <input type="text" name="State_Territory" id="state" class="form-control">
                                            </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="post_code">Post Code</label>
                                                <div class="form-group bg-shaded">
                                                <input type="text" name="postal_code" id="post_code" class="form-control">
                                            </div>
                                            </div>
                                            <div class="form-group"> 
                                        <label for="programSummaryBox">Project Summary</label>
                                        <div class="form-group bg-shaded">
                                        <textarea type="text" name="Project_Summary" id="programSummaryBox" class="form-control"> </textarea>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="marketBox">Market</label>
                                        <div class="form-group bg-shaded">
                                        <input type="text" name="Market" id="marketBox" class="form-control" />
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="technologyBox">Technology</label>
                                        <div class="form-group bg-shaded">
                                        <input type="text" name="Technology" id="technologyBox" class="form-control" />
                                    </div>
                                    </div>
                                    <div class="form-group"> 
                                        <label for="shortDescriptionBox">Short Description</label>
                                        <div class="form-group bg-shaded">
                                        <textarea type="text" name="short_description" id="shortDescriptionBox" class="form-control"> </textarea>
                                    </div>
                                    </div>
                                </div>
<script type="text/javascript">
    function getFieldValuesForJson(){
        if($('input[name="companyName"]').val().length > 1){
                    var FormDataToSent = {};
                    var companyName  = $('input[name="companyName"]').val();
                    var businessName = $('input[name="businessName"]').val();

                    var website = $('input[name="website"]').val();

                    var address_streetNumber = $('input[name="address_streetNumber"]').val();
                    var address_streetName   = $('input[name="address_streetName"]').val();
                    var address_town         = $('input[name="address_town"]').val();
                    var address_state        = $('select[name="address_state"]').val();
                    var address_post_code    = $('select[name="address_post_code"]').val(); 
                    var short_description    = $('textarea[name="short_description"]').val(); 

                    if($('input[name="userID"]').val().length > 0){
                        var userID  = $('input[name="userID"]').val();

                        FormDataToSent['userID']  = userID;

                        FormDataToSent['companyName']  = companyName;
                        FormDataToSent['businessName'] = businessName;

                        FormDataToSent['short_description']      = short_description;
                        FormDataToSent['website']  = website;

                        FormDataToSent['address_street_number'] = address_streetNumber;
                        FormDataToSent['address_street_name']   = address_streetName;
                        FormDataToSent['address_town']          = address_town;
                        FormDataToSent['address_state']         = address_state;
                        FormDataToSent['address_post_code']      = address_post_code;
                        <?php if(!empty($ControllerRouteName)){ ?>
                            FormDataToSent['ControllerName'] = '<?= $ControllerRouteName;?>';
                        <?php } ?>
                        return FormDataToSent;
                    }else{
                        Haider.notification('Please Get Register First','error');
                        return null;
                    }
        }else{
            Haider.notification('Please Enter Company Name','error');
            return null;
        }
        return null;
    }
</script>