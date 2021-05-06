<?php
if(isset($CurrentUserData) && !empty($CurrentUserData)){
    $ReadyOnlyFlag = 'readonly';
    $UserEmail  = $CurrentUserData['Email'];
    $FirstName  = $CurrentUserData['firstName'];

   
}else{
    $ReadyOnlyFlag = '';
    $UserEmail  = '';
    $FirstName  = '';
}
?>
<?php 
    $RegButtonLabel = 'Register';
    if(isUserLoggedIn($this)){
        $RegButtonLabel = 'Next';
    }
?>
        <div class="row">
            <div class="col-blocks col-md-12">
                <form id="ListingForm" action="<?= base_url().$ControllerRouteName.'/New';?>" method="post" class="form" enctype="multipart/form-data">
                    <div class="">
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" id="hiddenListID" value="">
                                <!-- Blade Version Of Codeigniter -->
                                <div id="step-submission" class="steps step-2 listing-submission" style="display:block;">
                                    <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                         <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="NameTextBox">
                                                First Name: <span class="required-fields">*</span>
                                            </label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="name" id="NameTextBox" class="form-control" placeholder="First Name" value="<?=$FirstName;?>" />
                                            </div>
                                        </div>
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="EmailBox">
                                                Email: <span class="required-fields">*</span>
                                            </label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="email" id="EmailBox" class="form-control" placeholder="Email" value="<?=$UserEmail;?>"/>
                                            </div>
                                        </div>
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="amountBox">
                                                Preferred Investment Amount:
                                            </label>
                                            <div class="form-group bg-shaded">
                                                <select id="amountBox" name="preferred_investment_amount" class="form-control select2-active"> 
                                                <option value="">Select Amount</option>
                                                    <?php    
                                                        if(isset($investmentAmounts) || !empty($investmentAmounts)){
                                                            foreach ($investmentAmounts as $key => $investmentAmount) { 
                                                        ?>
                                                            <option value="<?= $investmentAmount->id;?>" > <?= $investmentAmount->label;?></option>
                                                    <?php 
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                                            <label for="industiresBox">
                                                Preferred Investment Industires:
                                            </label>
                                            <div class="form-group bg-shaded">
                                                <select id="industiresBox" name="preferred_investment_industires[]" class="form-control js-example-basic-multiple select2-active" multiple data-placeholder="Select All" placeholder="Select All">
                                                <option value="all">Select All</option>
                                                    <?php    
                                                        if(isset($industires) || !empty($industires)){
                                                            foreach ($industires as $key => $industry) {

                                                    ?>
                                                            <option value="<?= $industry->id;?>" > <?= $industry->sector;?></option>
                                                     <?php 
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                                            <label for="investorTypeFlagBox">
                                                Investor Type:
                                            </label>
                                            <div class="form-group bg-shaded">
                                                <select id="investorTypeFlagBox" name="investor_type_id" class="form-control select2-active">
                                                <option value="">Select Investor Type</option>                  
                                                    <?php    
                                                        if(isset($investorTypes) || !empty($investorTypes)){
                                                            foreach ($investorTypes as $key => $investorType) {            
                                                         ?>
                                                            <option value="<?= $investorType->id;?>" > <?= $investorType->label;?></option>
                                                        <?php 
                                                                }
                                                            }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                            <!-- Blade Version Of Codeigniter -->
                                            <?= $questions;  ?>
                                        </div>
                                    </div>
                                    <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                            <div class="custom-questions">
                                                 <fieldset id="investor-selected-type" style="display: none">
                                                        <div class="form-group bg-shaded clearfix">
                                                          <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                                                            <label>Are you a Sophisticated Investor under S708 of the Corporations Act 2001?</label>
                                                          </div>
                                                            <div class="col-blocks col-xs-3 col-sm-1 col-md-1">
                                                                <div class="radio">
                                                                    <label>
                                                                        <input id="Act_2001" type="radio" class="minimal" name="Act_2001" value="1"> Yes
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-blocks col-xs-3 col-sm-1 col-md-1">
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="minimal" name="Act_2001" value="0" checked="checked"> No
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>         
                                                        <div  id="investor-selected-type-yes" style="display: none">
                                                        <div class="form-group bg-shaded clearfix">
                                                          <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                                                            <label>Sophisticated investor certificate upload here:
                                                              <span data-toggle="tooltip" title="Sophisticated Investors are entitled to exclusive content">
                                                              <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                              </span>
                                                            </label>
                                                          </div>
                                                          <div class="form-group">
                                                            <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                                               <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                                  <div class="form-control" data-trigger="fileinput">
                                                                      <i class="glyphicon glyphicon-file fileinput-exists"></i> 
                                                                      <span class="fileinput-filename"></span>
                                                                  </div>
                                                                      <span class="input-group-addon btn btn-default btn-file">
                                                                      <span class="fileinput-new">Select file</span>
                                                                      <span class="fileinput-exists">Change</span>
                                                                      <input type="hidden">
                                                                      <input type="file" id="certificate" name="certificate">
                                                                      </span>
                                                                     <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                                  </div>
                                                            </div>
                                                          </div>  
                                                        </div>         
                                                  </fieldset>  
                                            </div>   
                                        </div>  
                                    </div>
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                            <div class="col-xs-12 col-sm-4 col-md-2 register-button">
                                                <a href="#" id="SubmitListing" class="btn btn-primary">Enquire Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-choose" class="steps step-2 listing-submission">
                                    <div class="col-blocks col-md-12 ">
                                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                            <div class="choose-para text-center">
                                                <h2>Almost Done ! Lets Begin.</h2>
                                                <p>
                                                    Your Account Has Been Created.</br>
                                                    <span class="check-your-email">
                                                    Please Check Your Email For Login Details</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12 text-center">
                                            <div class="button-center-container">
                                            <?php if(!isUserLoggedIn($this)){ ?>
                                                <a href="<?= base_url().'login'?>" id="goToLogin" class="btn btn-block btn-flat btn-primary">Login</a>
                                            <?php }else{ ?>
                                               <a href="<?= base_url().'admin'?>" id="goToDashboard" class="btn btn-block btn-flat btn-primary">Dashboard</a>
                                            <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                        </div> <!-- /.box-body -->
                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                            <input type="hidden" id="userIDHidden" name="userID" value="<?= $userID;?>" />
                            <input type="hidden" id="listingIDHidden" name="listingID" value="<?= $listingID;?>" />
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.col -->
        </div>
<script type="text/javascript">
    var ControllerName = "<?=$this->ControllerName;?>"
    window.addEventListener('DOMContentLoaded', function() { //Load after the page is fully loaded.
        $(document).ready(function ($) {
            $('#step-reg').click(function (event) {
                event.preventDefault();
                $('.steps').slideUp('slow');
                $('.steps-layout a').removeClass('active');
                $(this).addClass('active');
                $('#step-registration').slideDown('slow');
            });
            $('#step-sub').click(function (event) {
                event.preventDefault();
                $('.steps').slideUp('slow');
                $('.steps-layout a').removeClass('active');
                $(this).addClass('active');
                $('#step-submission').slideDown('slow');
            });
            $('#step-cho').click(function (event) {
                event.preventDefault();
                $('.steps').slideUp('slow');
                $('.steps-layout a').removeClass('active');
                $(this).addClass('active');
                $('#step-choose').slideDown('slow');
            });
            $('#backToShow').click(function (event) {
                event.preventDefault();
                $('.steps').slideUp('slow');
                $('.steps-layout a').removeClass('active');
                $('#step-cho').addClass('active');
                $('#step-choose').slideDown('slow');
            });
            var shouldUploadCertificate = false;
            $('#investorTypeFlagBox').change(function (event) {
                if (this.value == 1 || this.value == 2) {
                    $('#investor-selected-type').show();
                } else {
                    $('#investor-selected-type').hide();
                }
            });
            $('input[name="Act_2001"]').change(function (event) {
                if (this.value == 1) {
                    $('#investor-selected-type-yes').show();
                    shouldUploadCertificate = true;
                } else {
                    $('#investor-selected-type-yes').hide();
                    shouldUploadCertificate = false;
                }
            });
            $('#industiresBox').change(function (event) {
                if (this.value == 'all') {
                    this.value = 'all';
                }
            });
            $('#SubmitListing').click(function (event) {
                event.preventDefault();
                var FormDataToSent = {};
                var name = $('input[name="name"]').val();
                var email = $('input[name="email"]').val();
                if (name.length > 1 || email.length > 3) {
                    var preferred_investment_amount = $('select[name="preferred_investment_amount"]').val();
                    var preferred_investment_industires = $('select[name="preferred_investment_industires[]"]').val();
                    var investor_type_id = $('select[name="investor_type_id"]').val();
                    var Act_2001 = $('input[name="Act_2001"]').val();

                    FormDataToSent['name'] = name;
                    FormDataToSent['email'] = email;
                    if (preferred_investment_amount != '') {
                        FormDataToSent['preferred_investment_amount'] = preferred_investment_amount;
                    }
                    FormDataToSent['preferred_investment_industires'] = preferred_investment_industires;
                    FormDataToSent['investor_type_id'] = investor_type_id;
                    FormDataToSent['Act_2001'] = Act_2001;
                    <?php if(!empty($ControllerRouteName)){ ?>
                    FormDataToSent['ControllerName'] = '<?= $ControllerRouteName;?>';
                    <?php } ?>
                    $.ajax({
                        url: base_url + 'Investor/New',
                        type: 'POST',
                        data: FormDataToSent,
                        success: function (output) {
                            var data = output.trim().split('::');
                            if (data[0].split(' ').join('') === 'OK') {
                                Haider.notification(data[1], data[2]);
                                var userID = data[3];
                                var listingID = data[4];
                                saveQuestionnaire(userID, listingID);
                                UploadCertificate(userID, listingID);
                            } else if (data[0].split(' ').join('') === 'FAIL') {
                                Haider.notification(data[1], data[2]);
                            }
                        }
                    });
                } else {
                    Haider.notification('Please Fill All Required Fields', 'error');
                }
            });

            function UploadCertificate(userID, listingID) {
                if (shouldUploadCertificate == true) {
                    var file = $('#certificate')[0].files[0];
                    var name = file.name;
                    var size = file.size;
                    var type = file.type;
                    if (file.name.length < 1) {
                        Haider.notification('Please Upload Valid File', 'error');
                    } else if (file.size > 1000000) {
                        Haider.notification('The file is too big', 'error');
                    } else if (file.type != 'application/pdf'
                        && file.type != 'image/png'
                        && file.type != 'image/jpg'
                        && file.type != 'text/plain'
                        && file.type != 'image/gif'
                        && file.type != 'image/jpeg') {
                        Haider.notification('The file does not match pdf, text, png, jpg or gif', 'error');
                    } else {

                        var formData = new FormData();
                        formData.append('certificate', $('#certificate')[0].files[0]);
                        formData.append('userID', userID);
                        formData.append('listingID', listingID);
                        $.ajax({
                            url: base_url + 'admin/investor/certificate/upload',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                //location.href = base_url;
                            }
                        });
                    }
                } else {
                    //location.href = base_url;
                }
            }

            $('input[name="email"]').on('change', function () {
                var email = this.value;
                var $this = $('input[name="email"]');
                var postData = {
                    email: email
                }
                if (validatedEmail(email)) {
                    $.ajax({
                        url: base_url + 'admin/<?=$ControllerRouteName;?>/emailcheck',
                        type: 'POST',
                        data: postData,
                        success: function (output) {
                            var data = output.trim().split('::');
                            if (data[0].split(' ').join('') === 'OK') {
                                $this.removeClass('error');
                                $this.parent().parent().children('label').removeClass('error');
                                Haider.notification(data[1], data[2]);
                            } else if (data[0].split(' ').join('') === 'FAIL') {
                                $this.addClass('error');
                                $this.parent().parent().children('label').addClass('error');
                                Haider.notification(data[1], data[2]);
                            }
                        }
                    });
                } else {
                    Haider.notification('Email Not Valid ' + email, 'error');
                }
            });
        });
    });
</script>
