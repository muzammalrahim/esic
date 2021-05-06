<div id="step-submission" class="steps step-2 listing-submission">
    <!--div class="text-center">
        <h2 class="margin-zero">Add Accelerator Listing</h2>
    </div-->
    <div class="col-blocks col-xs-12 col-sm-12">
        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
            <label for="RndPartnerTextBox">
                R&D Partner Name <span class="required-fields">*</span>
            </label>
            <div class="form-group bg-shaded">
                <input type="text" name="rndPartnerName" id="RndPartnerTextBox" class="form-control"
                       placeholder="R&D Partner Name"/>
            </div>
        </div>
        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
            <label for="IDNumberTextBox">
                ID Number:
            </label>
            <div class="form-group bg-shaded">
                <input type="text" name="IDNumber" id="IDNumberTextBox" class="form-control" placeholder="ID Number"/>
            </div>
        </div>
    </div>
    <div class="col-blocks col-xs-12 col-sm-12">
        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
            <label for="rndPartnerEmailBox">R&D Partner Email</label>
            <div class="form-group bg-shaded">
                <input type="text" name="rndPartnerEmail" id="rndPartnerEmailBox" class="form-control"
                       placeholder="R&D Partner Email"/>
            </div>
        </div>
        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
            <label for="WebsiteBox">Website</label>
            <div class="form-group bg-shaded">
                <input type="text" name="website" id="WebsiteBox" class="form-control" placeholder="Website"/>
            </div>
        </div>
    </div>
    <div class="col-blocks col-xs-12 col-sm-12">
        <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
            <label for="ANZSRCBox">Registered ANZSRC Codes</label>
            <div class="form-group bg-shaded">
                <select class="form-control select2-active js-example-basic-multiple" name="ANZSRC[]" id="ANZSRCBox"
                        multiple="multiple">
                    <?php if (isset($anzsrc) and !empty($anzsrc)) {
                        foreach ($anzsrc as $code) {
                            ?>
                            <option value="<?= $code->ANZSRC ?>"><?= $code->ANZSRC . '-' . $code->text ?></option>
                            <?php
                        }
                    } ?>
                </select>
            </div>
        </div>
    </div>
    <?= $AddressFields; ?>
    <div class="col-blocks col-md-12">
        <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
            <label for="RndCredentialsSummaryBox">R&D Credentials Summary</label>
            <div class="form-group bg-shaded">
                <input type="text" name="RndCredentialsSummary" id="RndCredentialsSummaryBox" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="col-blocks col-md-12">
        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
            <label for="workBox">Tell us what you do</label>
            <div class="form-group bg-shaded">
                <input type="text" name="work" id="workBox" class="form-control" placeholder="Tell us what you do"/>
            </div>
        </div>
        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
            <label for="ProjectsNExperienceBox">Projects & Experience</label>
            <div class="form-group bg-shaded">
                <input type="text" name="projectnexperience" id="ProjectsNExperienceBox" class="form-control"/>
            </div>
        </div>
        <!--div class="col-blocks col-xs-12 col-sm-4 col-md-4">
            <label for="ProgramStartDateBox">Program Start Date</label>
            <div class="form-group bg-shaded">
                <input type="text" name="ProgramStartDate" id="ProgramStartDateBox" class="form-control date_picker" />
            </div>
        </div-->
    </div>
    <div class="col-blocks col-md-12">
        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
            <label for="contactNameBox">Contact Name:</label>
            <div class="form-group bg-shaded">
                <input type="text" name="contactName" id="contactNameBox" class="form-control"/>
            </div>
        </div>
        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
            <label for="roleDepartmentBox">Contact Role/Department:</label>
            <div class="form-group bg-shaded">
                <input type="text" name="roleDepartment" id="roleDepartmentBox" class="form-control"/>
            </div>
        </div>
        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
            <label for="EmailBox">Contact Email:</label>
            <div class="form-group bg-shaded">
                <input type="text" name="ContactEmail" id="EmailBox" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="col-blocks col-md-12">
        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
            <label for="PhoneTextBox">Contact Phone:</label>
            <div class="form-group bg-shaded">
                <input type="text" name="phone" id="PhoneTextBox" class="form-control"/>
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
        if ($('input[name="rndPartnerName"]').val().length > 1) {
            var FormDataToSent = {};
            var rndPartnerName = $('input[name="rndPartnerName"]').val();
            var IDNumber = $('input[name="IDNumber"]').val();
            var rndPartnerEmail = $('input[name="rndPartnerEmail"]').val();

            var website = $('input[name="website"]').val();

            var address_streetNumber = $('input[name="address_streetNumber"]').val();
            var address_streetName = $('input[name="address_streetName"]').val();
            var address_town = $('input[name="address_town"]').val();
            var address_state = $('select[name="address_state"]').val();
            var address_post_code = $('select[name="address_post_code"]').val();

            var projectnexperience = $('input[name="projectnexperience"]').val();
            var ANZSRC = $('#ANZSRCBox').val();
            var RndCredentialsSummary = $('input[name="RndCredentialsSummary"]').val();
            var work = $('input[name="work"]').val();

            var contactName = $('input[name="contactName"]').val();
            var roleDepartment = $('input[name="roleDepartment"]').val();
            var ContactEmail = $('input[name="ContactEmail"]').val();
            var phone = $('input[name="phone"]').val();
            var Program_Summary = $('textarea[name="Program_Summary"]').val();
            var Program_Application_Method = $('input[name="Program_Application_Method"]').val();

            if ($('input[name="userID"]').val().length > 0) {
                var userID = $('input[name="userID"]').val();

                FormDataToSent['userID'] = userID;

                FormDataToSent['rndPartnerName'] = rndPartnerName;
                FormDataToSent['rndPartnerEmail'] = rndPartnerEmail;
                FormDataToSent['IDNumber'] = IDNumber;
                FormDataToSent['website'] = website;

                FormDataToSent['projectnexperience'] = projectnexperience;
                FormDataToSent['ANZSRC'] = ANZSRC;
                FormDataToSent['RndCredentialsSummary'] = RndCredentialsSummary;
                FormDataToSent['work'] = work;
                FormDataToSent['contactName'] = contactName;
                FormDataToSent['roleDepartment'] = roleDepartment;
                FormDataToSent['ContactEmail'] = ContactEmail;
                FormDataToSent['phone'] = phone;
                FormDataToSent['Program_Summary'] = Program_Summary;
                FormDataToSent['Program_Application_Method'] = Program_Application_Method;

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
