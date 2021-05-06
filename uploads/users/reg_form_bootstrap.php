<!doctype html>

<html lang="en">

<head>
    <title>Form to Wizard with jQuery Validation plugin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css">
    <link href="<?=base_url();?>assets/css/form.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
    <link href="<?=base_url();?>assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
    <script type="text/javascript" src="<?=base_url();?>assets/vendors/select2/dist/js/select2.full.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/vendors/select2/dist/js/select2.full.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">
        $(function() {
            $('#SaveAccount').click(function(event) {
                event.preventDefault();
                $("#form1").slideUp('slow');
                $("#SignupFormStep2").slideDown('slow');
            });
            $('#back').click(function(event) {
                event.preventDefault();
                $("#SignupFormStep2").slideUp('slow');
                $("#form1").slideDown('slow');
            });
        });
    </script>
    <style type="text/css">
        #mainFormDiv {
/*background-color: #424242;*/
  box-shadow: 0 0 9px rgba(0,0,0,0.3);
  background-image: url(uploads/8/4/3/6/84367404/background-images/561993498.jpg) !important;
}
#loading-submit{
    display: none;
    background: rgba(0,0,0,0.50);
    z-index: 9999;
    width: 100%;
    height: 100%;
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    text-align: center;
}
#loading-submit img{
    padding-top: 20%;
}
    </style>
</head>

<body>
<div class="row wrap">
    <div class="col-lg-12" id="mainFormDiv">
        <form id="SignupForm" action="<?php echo base_url('Reg/submit')?>" method="post" enctype="multipart/form-data">
              <div id="form1">
                <fieldset>
                    <legend>Early Stage Companies Pre-assessment</legend>
                    <p>
                        This pre-assessment will help you determine if you are likely to qualify as an Eligible Early Stage
                        Innovation Company, i.e. a company that meets both the Early Stage Test and either the 100 point
                        Innovation Test or the Principles-based Innovation Test. Failing these tests, the company may
                        request a taxation ruling from the Australian Tax Office.
                    </p>

                    <div class="form-group">
                        <label for="Name">Name</label>
                        <div class="row">
                            <div class="col-lg-6">
                                <input id="NameFirst" name="firstName" type="text" placeholder="First" class="form-control"
                                      required />
                            </div>
                            <div class="col-lg-6">
                                <input id="NameLast" name="lastName" type="text" placeholder="Last" class="form-control"
                                      required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input id="Email" name="email" type="email" class="form-control" placeholder="e-g: jhon@example.com" required />
                    </div>
                    <!--div class="form-group">
                        <label for="Website">Website Address</label>
                        <input id="Website" name="website" type="text" class="form-control" placeholder="e-g: www.example.com" required />
                    </div-->
                    <div class="form-group">
                        <label for="Company">Company Name</label>
                        <input id="Company" name="company" type="text" class="form-control" placeholder="Company" />
                    </div>
                    <div class="form-group">
                        <label for="Business">Business Name (if different)</label>
                        <input id="Business" name="business" type="text" class="form-control" placeholder="Business Name" />
                    </div>
                    <div class="form-group">
                        <label for="shortDescription">Short Description of business</label>
                        <textarea id="shortDescription" class="form-control" name="shortDescription"></textarea>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Early Stage Limb</legend>
                    <div>
                        <strong>Did your business have less than or equal to $1 million in expenses in the previous income year?</strong>
                        <div class="radio">
                            <label><input type="radio" value="Yes" name="1mExpense">Yes</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="No" name="1mExpense">No</label>
                        </div>
                    </div>

                    <div>
                        <strong>Did your business have less than or equal to $200,000 in assessable income in the previous income year? (Excluding Accelerating Commercialisation Grant)</strong>
                        <div class="radio">
                            <label><input type="radio" value="Yes" name="assessableIncomeYear">Yes</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="No" name="assessableIncomeYear">No</label>
                        </div>
                    </div>

                    <div>
                        <strong>Is your business listed on any stock exchanges?</strong>
                        <div class="radio">
                            <label><input type="radio" value="Yes" name="listedInSExchange">Yes</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="No" name="listedInSExchange">No</label>
                        </div>
                    </div>

                    <div>
                        <strong>When was your company incorporated in Australia?</strong>
                        <div class="radio">
                            <label><input type="radio" value="Within the past three years" name="incorporatedAus">Within the past three years</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" id="3and6" value="Between six and three years ago" name="incorporatedAus">Between six and three years ago</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="Greater than six years ago" name="incorporatedAus">Greater than six years ago</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="Not incorporated in Australia" name="incorporatedAus">Not incorporated in Australia</label>
                        </div>
                         <!--Div For Input-->
                        <div class="inputDiv" id="dateInsertDiv">
                            <label for="selectorUniversity">Enter The Dates</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="cop_date">Incorporation Date</label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <input id="cop_date" name="cop_date" type="text" class="form-control" placeholder="DD/MM/YYYY" />
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="form-group">
                                        <label for="acn">ACN #</label>
                                        <input id="acn" name="acn" type="text" class="form-control" placeholder="ACN #" />
                                    </div>
                                    <!--div class="form-group">
                                        <label for="exp_date">Expiry Date</label>
                                        <input id="exp_date" name="exp_date" type="text" class="form-control" placeholder="DD/MM/YYYY" />
                                    </div-->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="whollyOwned">
                        <strong>Have you and your wholly owned subsidiaries incurred less than $1 million in expenses total across the last 3 income years?</strong>
                        <div class="radio">
                            <label><input type="radio" value="Yes" name="ownedSubsidiaries">Yes</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="No" name="ownedSubsidiaries">No</label>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="form-horizontal" role="form">
                    <legend>Innovation Limb</legend>
                    <span style="text-decoration: underline">Principles-Based Test</span>

                    <div>
                        <strong>Is your company developing a new or significantly improved type of innovation? (See http://www.oecd.org/sti/oslomanual for examples of innovation)
                        </strong>
                        <div class="radio">
                            <label><input type="radio" value="Yes" name="improvedInnovation">Yes</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="No" name="improvedInnovation">No</label>
                        </div>
                    </div>

                    <div>
                        <strong>Does your company have the potential for high growth?</strong>
                        <div class="radio">
                            <label><input type="radio" value="Yes" name="potentialHighGrowth">Yes</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="No" name="potentialHighGrowth">No</label>
                        </div>
                    </div>

                    <div>
                        <strong>Is your company scalable? (Can you reduce or minimize cost increase as your revenues grow)
                        </strong>
                        <div class="radio">
                            <label><input type="radio" value="Yes" name="companyScalable">Yes</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="No" name="companyScalable">No</label>
                        </div>
                    </div>

                    <div>
                        <strong>Will you be able to address a national, international or global market?</strong>
                        <div class="radio">
                            <label><input type="radio" value="Yes" name="globalMarket">Yes</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="No" name="globalMarket">No</label>
                        </div>
                    </div>

                    <div>
                        <strong>Is there potential for a clear competitive advantage over other companies? </strong>
                        <div class="radio">
                            <label><input type="radio" value="Yes" name="competitiveAdvantage">Yes</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="No" name="competitiveAdvantage">No</label>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="form-horizontal" role="form">
                    <legend>Innovation Limb</legend>
                    <p><span style="text-decoration: underline">Objective Test (100 Points Required)</span><br />
                        See the <span style="text-decoration: underline">FAQ</span> for an explanation of how points are awarded.
                    </p>

                    <div>
                        <strong>Which of the following describes your R&D expenses as a proportion of total expenses?
                        </strong>
                        <div class="radio">
                            <label><input type="radio" value="Greater than or equal to 50%" name="rdExpenses">Greater than or equal to 50%</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="Between 15% and 50%" name="rdExpenses">Between 15% and 50%</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="Less than 15%" name="rdExpenses">Less than 15%</label>
                        </div>
                        <div class="selectorDiv" id="RnD">
                            <label for="selectRnD">Select R&D</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <select class="select2Style" id="selectRnD" style="width:90%">
                                        <option value="0">Select...</option>
                                        <?php
                                        if(isset($RnDs) and !empty($RnDs)){
                                            print_r($RnDs);
                                            foreach($RnDs as $RnD){
                                                echo '<option value="'.$RnD->id.'">'.$RnD->rndname.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <a></a>
                                    <a class="btn addBtn" data-toggle="modal" data-target=".RndModal" id="addRnDModel"><span style="font-size: 12px;" class="glyphicon glyphicon-plus"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <strong>Have you received an Accelerating Commercialisation Grant under the Accelerating Commercialisation element of the Commonwealth's Entrepreneur's programme?</strong>
                        <div class="radio">
                            <label><input type="radio" value="Yes" name="EntrepreneurProgramme">Yes</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="No" name="EntrepreneurProgramme">No</label>
                        </div>
                        <!--                    Div For Selector-->
                        <div class="selectorDiv" id="EntrepreneurProgramme">
                            <label for="selectAcceleration">Select Acceleration Commercial</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <select class="select2Style" id="selectAcceleration" style="width:90%">
                                        <option value="0">Select...</option>
                                        <?php
                                        if(isset($accelerationCommercials) and !empty($accelerationCommercials)){
                                            foreach($accelerationCommercials as $accelerationCommercial){
                                                echo '<option value="'.$accelerationCommercial->id.'">'.$accelerationCommercial->Member.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <a></a>
                                    <a class="btn addBtn" data-toggle="modal" data-target=".EntrepreneurProgrammeModal" id="addProgramme"><span style="font-size: 12px;" class="glyphicon glyphicon-plus"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <strong>Has your business undertaken or completed an accelerator programme? Provided that the entity has been operating the programme for 6 months and has provided a complete programme to at least one cohort of entrepreneurs.
                        </strong>
                        <div class="radio">
                            <label><input type="radio" value="Yes" name="cohortOfEntrepreneurs">Yes</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="No" name="cohortOfEntrepreneurs">No</label>
                        </div>
                        <!--                    Div For Selector-->
                        <div class="selectorDiv" id="acceleratorProgramme">
                            <label for="acceleratorAcceleration">Select Acceleration</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <select class="select2Style" id="selectAcceleratorProgramme" style="width:90%">
                                        <option value="0">Select...</option>
                                        <?php
                                        if(isset($acceleratorProgramme) and !empty($acceleratorProgramme)){
                                            foreach($acceleratorProgramme as $acceleratorProgramme){
                                                echo '<option value="'.$acceleratorProgramme->id.'">'.$acceleratorProgramme->name.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <a></a>
                                    <a class="btn addBtn" data-toggle="modal" data-target=".acceleratorProgrammeModal" id="addAcceleratorProgrammeBtn"><span style="font-size: 12px;" class="glyphicon glyphicon-plus"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <strong>Has your business issued $50,000 or more in shares to a third party who was not an associate and did not acquire those shares to help another entity become entitled to the tax incentives? </strong>
                        <div class="radio">
                            <label><input type="radio" value="Yes" name="taxIncentives">Yes</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="No" name="taxIncentives">No</label>
                        </div>
                    </div>

                    <div>
                        <strong>Does your business have a standard patent or plant breeder's right, or the equivalent in another country within the past 5 years?  </strong>
                        <div class="radio">
                            <label><input type="radio" value="Yes" name="standardPatent">Yes</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="No" name="standardPatent">No</label>
                        </div>
                    </div>

                    <div>
                        <strong>Does your business have an innovation patent or design right or the equivalent in another country within the the past 5 years?</strong>
                        <div class="radio">
                            <label><input type="radio" value="Yes" name="innovationPatent">Yes</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="No" name="innovationPatent">No</label>
                        </div>
                    </div>

                    <div>
                        <strong>Does your business hold a license to IP that falls into either of the previous 2 categories? </strong>
                        <div class="radio">
                            <label><input type="radio" value="Yes" name="previous2Categories">Yes</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="No" name="previous2Categories">No</label>
                        </div>
                    </div>

                    <div>
                        <strong>Does your business have a written agreement to co-develop and commercialise an innovation with a university or a research organization? </strong>
                        <div class="radio">
                            <label><input type="radio" value="Yes" name="researchOrganization">Yes</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="No" name="researchOrganization">No</label>
                        </div>
    <!--                    Div For Selector-->
                        <div class="selectorDiv" id="selectorUniversityDiv">
                            <label for="selectorUniversity">Select University</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <select class="select2Style" id="selectorUniversity" style="width: 90%">
                                        <option value="0">Select...</option>
                                        <?php
                                        if(isset($institutions) and !empty($institutions)){
                                            foreach($institutions as $institution){
                                                echo '<option value="'.$institution->id.'">'.$institution->institution.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <a></a>
                                    <a class="btn addBtn" data-toggle="modal" data-target=".InstitutionModal" id="addSelectorUniversity"><span style="font-size: 12px;" class="glyphicon glyphicon-plus"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                   </fieldset>
                <div class="button-container">
                    <button type="button" id="SaveAccount" class="btn btn-primary">Submit form</button>
                </div>
              </div>
            <div class="clear"></div>
            <div id="SignupFormStep2">
                <fieldset>
                    <legend>Early Stage Companies Pre-assessment</legend>
                    <p>
                        This pre-assessment will help you determine if you are likely to qualify as an Eligible Early Stage
                        Innovation Company, i.e. a company that meets both the Early Stage Test and either the 100 point
                        Innovation Test or the Principles-based Innovation Test. Failing these tests, the company may
                        request a taxation ruling from the Australian Tax Office.
                    </p>

                    <div class="form-group">
                        <label for="Logo">Logo</label>
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                            <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
                                <input type="file" id="Logo" name="Logo"></span>
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="BannerImage">Banner Image</label>
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                            <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
                                <input type="file" id="BannerImage" name="Banner"></span>
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="productImage">Product / Service Image</label>
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                            <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
                                <input type="file" id="productImage" name="product"></span>
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="industryClassification">Industry classification (from our provided listing))</label>
                        <div class="row">
                            <div class="col-lg-6">
                                <select id="industryClassification" style="width: 80%;">
                                    <option value="0">Select...</option>
                                    <?php
                                    if(isset($sectors) and !empty($sectors)){
                                        foreach($sectors as $sector){
                                            echo '<option value="'.$sector->id.'">'.$sector->sector.'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                 <a class="btn addBtn" data-toggle="modal" data-target=".IndustryClassificationModal" id="addIndustryClassification">
                                 <span style="font-size: 12px;" class="glyphicon glyphicon-plus"></span></a>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="button-container">
                    <button id="back"  class="btn btn-primary submit">Back</button>
                    <button id="SubmitForm" type="button" class="btn btn-primary submit">Submit</button>
                </div>
            </div>
        </form>

    </div></div>

<!--Working on Modals-->

<div class="modal RndModal" tabindex="-1" role="dialog" aria-labelledby="R&D" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">R&D</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="rndname">R&D Name</label>
                    <input id="rndname" name="rndname" type="text" class="form-control" placeholder="R&D Name" />
                </div>
                 <div class="form-group">
                    <label for="rndIdNumber">R&D ID Number </label>
                    <input id="rndIdNumber" name="rndIdNumber" type="text" class="form-control" placeholder="R&D ID Number" />
                </div>
                 <div class="form-group">
                    <label for="rndAddress">R&D Address</label>
                    <input id="rndAddress" name="rndAddress" type="text" class="form-control" placeholder="R&D Address" />
                </div>
                 <div class="form-group">
                    <label for="ANZSRC">R&D ANZSRC</label>
                    <input id="ANZSRC" name="ANZSRC" type="text" class="form-control" placeholder="R&D ANZSRC" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="addRnD" type="button" class="btn btn-primary" data-dismiss="modal">Add</button>
            </div>
        </div>
    </div>
</div>

<div class="modal InstitutionModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Institution</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="Institution">Institution Name</label>
                    <input id="Institution" name="institution" type="text" class="form-control" placeholder="Institution" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="addInstitution" type="button" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>

<div class="modal EntrepreneurProgrammeModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Entrepreneur Programme</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="Member">Programme Member Name</label>
                    <input id="Member" name="Member" type="text" class="form-control" placeholder="Member" />
                </div>
                <div class="form-group">
                    <label for="Web_Address">Web Address</label>
                    <input id="Web_Address" name="Web_Address" type="text" class="form-control" placeholder="Web Address" />
                </div>
                <div class="form-group">
                    <label for="State_Territory">State Territory</label>
                    <input id="State_Territory" name="State_Territory" type="text" class="form-control" placeholder="State_Territory" />
                </div>
                <div class="form-group">
                    <label for="Project_Location">Project Location</label>
                    <input id="Project_Location" name="Project_Location" type="text" class="form-control" placeholder="Project_Location" />
                </div>
                <div class="form-group">
                    <label for="Project_Title">Project Title</label>
                    <input id="Project_Title" name="Project_Title" type="text" class="form-control" placeholder="Project_Title" />
                </div>
                <div class="form-group">
                    <label for="Project_Summary">Project Summary</label>
                    <input id="Project_Summary" name="Project_Summary" type="text" class="form-control" placeholder="Project_Summary" />
                </div>
                <div class="form-group">
                    <label for="Market">Market</label>
                    <input id="Market" name="Market" type="text" class="form-control" placeholder="Market" />
                </div>
                 <div class="form-group">
                    <label for="Technology">Technology</label>
                    <input id="Technology" name="Technology" type="text" class="form-control" placeholder="Technology" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="addEntrepreneurProgramme" type="button" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>

<div class="modal acceleratorProgrammeModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Accelerator Programme</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="AcceleratorProgrammeName">Accelerator Programme Name</label>
                    <input id="AcceleratorProgrammeName" name="AcceleratorProgrammeName" type="text" class="form-control" placeholder="Programme Name" />
                </div>
                <div class="form-group">
                    <label for="Programme_Web_Address">Programme Web Address</label>
                    <input id="Programme_Web_Address" name="Programme_Web_Address" type="text" class="form-control" placeholder="Programme Web Address" />
                </div>
                <div class="form-group">
                   <label for="logoImage">Logo Image</label>
                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i> 
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                        <span class="fileinput-new">Select file</span>
                        <span class="fileinput-exists">Change</span>
                                <input type="file" id="ProgrammeLogoImage" name="ProgrammeLogoImage"/>
                        </span>
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="addAcceleratorProgramme" type="button" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>

<div class="modal IndustryClassificationModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Industry Classification</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="Industry">Industry Classification Name</label>
                    <input id="Industry" name="Industry" type="text" class="form-control" placeholder="Industry Classification" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="addClassification" type="button" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>

<div id="loading-submit">
    <img src="<?=base_url();?>assets/images/loading.gif" alt="loading">
</div>

<script type="text/javascript">
    $(function(){
        $("input[name='incorporatedAus']").on("change",function(){
            if($(this).val() === 'Between six and three years ago'){
                $("#whollyOwned").show();
                console.log("show");
            }else{
                $("#whollyOwned").hide();
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#selectorUniversity, #selectAcceleration,#selectAcceleratorProgramme,#selectRnD").select2();
        $("input[name=EntrepreneurProgramme]").on("change",function(){
            var EntrepreneurProgramme = $(this).val();
            if(EntrepreneurProgramme === 'Yes'){
                $("#EntrepreneurProgramme").css('display','block');
            }else{
                $("#EntrepreneurProgramme").css('display','none');
            }
        });
        $("input[name=researchOrganization]").on("change",function(){
            var researchOrganization = $(this).val();
            if(researchOrganization === 'Yes'){
                $("#selectorUniversityDiv").css('display','block');
            }else{
                $("#selectorUniversityDiv").css('display','none');
            }
        });
        $("input[name=incorporatedAus]").on("change",function(){
            var incorporatedAus = $(this).val();
            if(incorporatedAus == 'Not incorporated in Australia' || incorporatedAus == ''){
                $("#dateInsertDiv").css('display','none');
            }else{
                $("#dateInsertDiv").css('display','block');
            }
        });
        $("input[name=cohortOfEntrepreneurs]").on("change",function(){
            var cohortOfEntrepreneurs = $(this).val();
            if(cohortOfEntrepreneurs === 'Yes'){
                $("#acceleratorProgramme").css('display','block');
            }else{
                $("#acceleratorProgramme").css('display','none');
            }
        });
        $("input[name=rdExpenses]").on("change",function(){
            var RnDValue = $(this).val();
            if(RnDValue === 'Less than 15%'){
                $("#RnD").css('display','block');
            }else{
                $("#RnD").css('display','none');
            }
        });
        $('#addRnDModel').on("click",function(e){
            e.preventDefault();
             $('.RnDModal').show();
        });
        $("#addRnD").on("click",function(){
            var selectRnD = $("#rndname");
            var selectRnDValue = selectRnD.val();
            var RndName = $("#rndname").val();
            
            var IDNumber   = $("#rndIdNumber").val();
            var Address    = $("#rndAddress").val();
            var ANZSRC     = $("#ANZSRC").val();
            if(selectRnDValue.length === 0){
                selectRnD.parents(".form-group").addClass('has-error');
                return false ;
            }else{
                selectRnD.parents(".form-group").removeClass('has-error');
            }
            var RnDCheck='0';
            var RnDFilter = $('#selectRnD option').filter(
                function(){ 
                    if($(this).html().toLowerCase() == selectRnDValue.toLowerCase()){  
                        var valuecheck       = $(this).val();
                        var selectRnD1 = $("#selectRnD").select2();
                        selectRnD1.val(valuecheck).trigger("change");
                        RnDCheck ='1';
                        $('.RnDModal').modal('hide');
                        $('.RnDModal').modal().hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.RnDModal').hide();
                    }
                });
            if(RnDCheck=='0'){
                $.ajax({
                    url: "<?=base_url()?>Reg/addRnD",
                    type:"POST",
                    data:{
                        rndname :RndName,
                        IDNumber:IDNumber,
                        Address :Address,
                        ANZSRC  :ANZSRC
                    },
                    success:function(output){
                            var  data =  output.split('::');
                               if(data[0].split(' ').join('') == 'OK'){
                                    console.log('RndName'+RndName);
                                   var RnDID   = data[1];
                                   var RnDName = data[2];
                                   var newOption = new Option(RnDName,RnDID, true, true);
                                    $("#selectRnD").append(newOption).trigger('change');
                                    $('.RnDModal').modal('hide');
                                    $('.RnDModal').modal().hide();
                                    $('body').removeClass('modal-open');
                                    $('.modal-backdrop').remove();
                                    $('.RnDModal').hide();
                                }else if(data[0].split(' ').join('') =='Existed'){
                                    var InstitutionNameValue = $('#selectRnD option').filter(function (){ 
                                        return $(this).html() == InstitutionValue}).val();
                                    var selectUniversity     = $("#selectRnD").select2();
                                    selectUniversity.val(InstitutionNameValue).trigger("change"); 
                                    $('.RnDModal').modal('hide');
                                    $('.RnDModal').modal().hide();
                                    $('body').removeClass('modal-open');
                                    $('.modal-backdrop').remove();
                                    $('.RnDModal').hide();
                                }
                    }
                });

            }
        });

        $("#addAcceleratorProgramme").on("click",function(){
            var  AcceleratorProgrammeName = $("#AcceleratorProgrammeName");  
            var AcceleratorProgrammeNameValue = AcceleratorProgrammeName.val();
            if(AcceleratorProgrammeNameValue.length === 0){
                AcceleratorProgrammeName.parents(".form-group").addClass('has-error');
                return false ;
            }else{
                AcceleratorProgrammeName.parents(".form-group").removeClass('has-error');
            }
            var Programme_Web_Address   = $("#Programme_Web_Address").val();
            var formData = new FormData();
            formData.append('ProgrammeLogoImage', $('#ProgrammeLogoImage')[0].files[0]);
            formData.append('AcceleratorProgrammeName',AcceleratorProgrammeNameValue);
            formData.append('Programme_Web_Address',Programme_Web_Address);

            var ProgrammeNameCheck = '0';
            var ProgrammeFilter  = $('#selectAcceleratorProgramme option').filter(
                function(){ 
                    if($(this).html() == AcceleratorProgrammeNameValue){
                        var valuecheck      = $(this).val();
                        var selectProgramme = $("#selectAcceleratorProgramme").select2();
                        selectProgramme.val(valuecheck).trigger("change"); 
                        ProgrammeNameCheck  = '1';
                        $('.acceleratorProgrammeModal').modal('hide');
                        $('.acceleratorProgrammeModal').modal().hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    }
                });
            if(ProgrammeNameCheck=='0'){
                //console.log(AcceleratorProgrammeNameValue);
                $.ajax({
                    crossOrigin: true,
                    data: formData,
                    processData: false,
                    contentType: false,
                    type:"POST",
                    url: "<?=base_url()?>Reg/addAcceleratorProgramme",
                    success:function(output){
                        var  data =  output.split('::');
                        if(data[0].split(' ').join('') =='OK'){
                            var programmeId   = data[1];
                            var programmeName = data[2]; 
                            var newOption = new Option(programmeName,programmeId, true, true);
                                $("#selectAcceleratorProgramme").append(newOption).trigger('change');
                                $('.acceleratorProgrammeModal').modal('hide');
                        }else if(data[0].split(' ').join('') =='Existed'){
                            var ProgrammeNameValue = $('#selectAcceleratorProgramme option').filter(function () { return $(this).html() == ProgrammeValue}).val();
                            var valuecheck         = $(this).val();
                            var selectProgramme    = $("#selectAcceleratorProgramme").select2();
                            selectProgramme.val(ProgrammeNameValue).trigger("change");  
                            $('.acceleratorProgrammeModal').modal('hide');
                            $('.acceleratorProgrammeModal').modal().hide();
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();

                        }
                    }
                });
            }
        });

        $("#addInstitution").on("click",function(){
            var Institution = $("#Institution");
            var InstitutionValue = Institution.val();
            if(InstitutionValue.length === 0){
                Institution.parents(".form-group").addClass('has-error');
                return false ;
            }else{
                Institution.parents(".form-group").removeClass('has-error');
            }
            var InstitutionCheck='0';
            var InstitutionFilter = $('#selectorUniversity option').filter(
                function(){ 
                    if($(this).html().toLowerCase() == InstitutionValue.toLowerCase()){  
                        var valuecheck       = $(this).val();
                        var selectUniversity = $("#selectorUniversity").select2();
                        selectUniversity.val(valuecheck).trigger("change");
                        InstitutionCheck ='1';
                        $('.InstitutionModal').modal('hide');
                        $('.InstitutionModal').modal().hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    }
                });
            if(InstitutionCheck=='0'){
                $.ajax({
                    url: "<?=base_url()?>Reg/addInstitution",
                    type:"POST",
                    data:{institution:InstitutionValue},
                    success:function(output){
                            var  data =  output.split('::');
                               if(data[0].split(' ').join('') =='OK'){
                                   var institutionId   = data[1];
                                   var institutionName = data[2];
                                   var newOption = new Option(institutionName,institutionId, true, true);
                                    $("#selectorUniversity").append(newOption).trigger('change');
                                    $('.InstitutionModal').modal('hide');
                                }else if(data[0].split(' ').join('') =='Existed'){
                                    var InstitutionNameValue = $('#selectorUniversity option').filter(function (){ 
                                        return $(this).html() == InstitutionValue}).val();
                                    var selectUniversity     = $("#selectorUniversity").select2();
                                    selectUniversity.val(InstitutionNameValue).trigger("change"); 
                                    $('.InstitutionModal').modal('hide');
                                    $('.InstitutionModal').modal().hide();
                                    $('body').removeClass('modal-open');
                                    $('.modal-backdrop').remove();
                                }
                    }
                });

            }
        });
        $("#addEntrepreneurProgramme").on("click",function(){
            var Member = $("#Member");  
            var MemberValue = Member.val();
            if(MemberValue.length === 0){
                Member.parents(".form-group").addClass('has-error');
                return false ;
            }else{
                Member.parents(".form-group").removeClass('has-error');
            }
            var Web_Address         = $("#Web_Address").val();
            var Project_Title       = $("#Project_Title").val();
            var State_Territory     = $("#State_Territory").val();
            var Project_Summary     = $("#Project_Summary").val();
            var Project_Location    = $("#Project_Location").val();
            var Market              = $("#Market").val();
            var Technology          = $("#Technology").val();
            var ProgrammeNameCheck  = '0';
            var ProgrammeFilter  = $('#selectAcceleration option').filter(
                function(){ 
                    if($(this).html() == MemberValue){
                        var valuecheck      = $(this).val();
                        var selectProgramme = $("#selectAcceleration").select2();
                        selectProgramme.val(valuecheck).trigger("change"); 
                        ProgrammeNameCheck  = '1';
                        $('.EntrepreneurProgrammeModal').modal('hide');
                        $('.EntrepreneurProgrammeModal').modal().hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    }
                });
            if(ProgrammeNameCheck=='0'){
                $.ajax({
                    url: "<?=base_url()?>Reg/addEntrepreneurProgramme",
                    type:"POST",
                    data:{
                        Market:Market,
                        Member:MemberValue,
                        Technology:Technology,
                        Web_Address:Web_Address,
                        Project_Title:Project_Title,
                        State_Territory:State_Territory,
                        Project_Summary:Project_Summary,
                        Project_Location:Project_Location
                    },
                    success:function(output){
                        var  data =  output.split('::');
                        if(data[0].split(' ').join('') =='OK'){
                            var programmeId   = data[1];
                            var programmeName = data[2]; 
                            var newOption = new Option(programmeName,programmeId, true, true);
                                $("#selectAcceleration").append(newOption).trigger('change');
                                $('.EntrepreneurProgrammeModal').modal().hide();
                                $('body').removeClass('modal-open');
                                $('.modal-backdrop').remove();
                        }else if(data[0].split(' ').join('') =='Existed'){
                            var ProgrammeNameValue = $('#selectAcceleration option').filter(function () { return $(this).html() == ProgrammeValue}).val();
                            var valuecheck         = $(this).val();
                            var selectProgramme    = $("#selectAcceleration").select2();
                            selectProgramme.val(ProgrammeNameValue).trigger("change");  
                            $('.EntrepreneurProgrammeModal').modal('hide');
                            $('.EntrepreneurProgrammeModal').modal().hide();
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                        }
                    }
                });
            }
        });
    });
</script>
<script type="text/javascript">
    $(function(){
        $("input[name='incorporatedAus']").on("change",function(){
            if($(this).val() === 'Between six and three years ago'){
                $("#whollyOwned").show();
                console.log("show");
            }else{
                $("#whollyOwned").hide();
            }
        });
    });
      
</script>

<script type="text/javascript">
 var $signupForm = $( '#SignupForm' );
            
    $(document).ready(function() {

    	$('#main-wrap').css('z-index', 'initial');
    	$('#main-content').css('z-index', 'initial');

        var $form = $('#SignupForm');
        $("#SubmitForm").on("click",function(e){
            e.preventDefault();
            $('error-box')
            $('#error-box').remove();
            $('#loading-submit').show();
            var formData = new FormData();
                    $.ajax({
                            crossOrigin: true,
                            type: $form.attr('method'),
                            url: $form.attr('action'),
                            data: $form.serialize()
                        })
                        .done(function (response) {
                            var data = response.split("::");
                            if(data[0].split(' ').join('') === "OK"){
                                //Run another Ajax To Get Another Form.
                               console.log(response);
                                formData.append('logo', $('#Logo')[0].files[0]);
                                formData.append('banner', $('#BannerImage')[0].files[0]);
                                formData.append('product', $('#productImage')[0].files[0]);
                                formData.append('sector', $('#industryClassification').val());
                                formData.append('userID', data[2]);

                                $.ajax({       
                                    crossOrigin: true,
                                    type: $form.attr('method'),
                                    url: "<?=base_url()?>Reg/step2",
                                    data: formData,
                                    processData: false,
                                    contentType: false
                                }).done(function (response) {
                                    var data = response.split("::");
                                    if(data[0].split(' ').join('') === 'OK'){
                                        $("#mainFormDiv").html('<span id="sucess-box" style="background:rgba(0,0,0,0.8); padding: 5px; color: white; font-weight: bold; border: 2px dotted black; width: 100%;display: block;">Thank you, Your Record have been successfully Updated</span>');
                                         $('#loading-submit').hide();
                                    }else if(data[0].split(' ').join('') === 'FAIL'){
                                        $('#loading-submit').hide();
                                    }
                                });
                            }else{
                                console.log(response);
                                $("#mainFormDiv").append('<span id="error-box" style="background: rgba(0,0,0,0.8);padding: 5px;color: white;font-weight: bold; border: 2px dotted black;width: 100%;display: block;">There are Errors, Please Fill All Fields</span>');
                                $('#loading-submit').hide();
                            }

                        });
            
                    });
        $( function() {
        $( "#cop_date" ).datepicker({
            format: 'dd/mm/yyyy'
        });
      });
$("#industryClassification").select2();
        $("#addClassification").on("click",function(){
            var Industry = $("#Industry");
            var IndustryValue = Industry.val();
            
            if(IndustryValue.length === 0){
                Industry.parents(".form-group").addClass('has-error');
                return false ;
            }else{
                Industry.parents(".form-group").removeClass('has-error');
            }
            var IndustryNameCheck = '0';
            var Industryfilter    = $('#industryClassification option').filter(
                function(){ 
                    if($(this).html() == IndustryValue){
                        var valuecheck      = $(this).val();
                        var selectIndustry  = $("#industryClassification").select2();
                        selectIndustry.val(valuecheck).trigger("change"); 
                        IndustryNameCheck='1';
                        $('.IndustryClassificationModal').modal('hide');
                        $('.IndustryClassificationModal').modal().hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    }
                });
            if(IndustryNameCheck=='0'){
                $.ajax({
                    url: "<?=base_url()?>Reg/addIndustryClassification",
                    type:"POST",
                    data:{Industry:IndustryValue},
                    success:function(output){
                        var  data =  output.split('::');    
                        if(data[0].split(' ').join('') =='OK'){
                            var IndustryId   = data[1];
                            var IndustryName = data[2]; 
                            var newOption    = new Option(IndustryName,IndustryId, true, true);
                                $("#industryClassification").append(newOption).trigger('change');
                                $('.IndustryClassificationModal').modal().hide();
                                $('body').removeClass('modal-open');
                                $('.modal-backdrop').remove();
                        }else if(data[0].split(' ').join('') =='Existed'){
                            var IndustryNameValue   = $('#industryClassification option').filter(function () { return $(this).html() == IndustryValue}).val();
                            var valuecheck          = $(this).val();
                            var selectIndustry      = $("#industryClassification").select2();
                            selectIndustry.val(IndustryNameValue).trigger("change"); 
                            $('.IndustryClassificationModal').modal('hide');
                            $('.IndustryClassificationModal').modal().hide();
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();

                        }
                    }
                });
            }
            
        });
    });
</script>
</body>
</html>
