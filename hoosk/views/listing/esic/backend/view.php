<?php
if(isset($id) && !empty($id)){
    $id = $id;
}else{
    return 'Sorry No ID Set';
}


if(isset($data) && !empty($data)){
    $name       = $data->name;
    $slug       = $data->slug;
    $phone      = $data->phone;
    $website    = $data->website;
    $email      = $data->email;
    $userIDd     = $data->userID;

    $status_flag_id = $data->status_flag_id;

    //Address Fields
    $address_streetNumber = $data->address_street_number;
    $address_streetName = $data->address_street_name;
    $address_town = $data->address_town;
    $address_state = $data->address_state;
    $address_postCode = $data->address_post_code;
    //Default Address Block set to false, Not To Show.
    $address = false;

    $address_arguments = [
        $address_streetNumber,
        $address_streetName,
        $address_town,
        $address_state,
        $address_postCode,
    ];

    //This Function will only work in PHP 5.6 and above :)
    if(!( $result = m_empty(...$address_arguments))){
        //If any of the value in array is not empty should be considered not empty address and address box should show up.
        //Not Empty
        $address = true;
    }else{
        //If All the address fields are empty, then box does not need to be shown.
        //If Empty
        $address = false;
    }

    $keywords   = $data->keywords;
    $banner     = $data->banner;
    $logo       = $data->logo;

    $short_description  = $data->short_description;
    $long_description   = $data->long_description;


    $Business = $data->business;
    $IncorporateDate = $data->corporate_date;
    $ExpiryDate = $data->expiry_date;
    $AddedDate = $data->added_date;
    $productImage = $data->productImage;
    $acn_number = $data->acn_number;

}else{

    $name       = '';
    $slug       = '';
    $phone      = '';
    $website    = '';
    $email      = '';
    $address    = '';
    $keywords   = '';
    $banner     = '';
    $logo       = '';

    $status_flag_id = '';

    $short_description  = '';
    $long_description   = '';
    $Business = '';
    $IncorporateDat = '';
    $ExpiryDate = '';
    $AddedDate = '';
    $acn_number = '';
    $productImage = '';
}
$StatusName = '';
if(isset($itemStatuses) && !empty($itemStatuses)){
    foreach ($itemStatuses as $key => $itemStatus){
        $StatusDbID   = $itemStatus->id;
        $StatusDbName = $itemStatus->name;
        if($status_flag_id == $StatusDbID){
            $StatusName = $StatusDbName;
        }
    }

}

?>
    <div class="row">
        <div class="col-md-12">
            <div class="text-right" style="margin-bottom: 5px;">
                <a href="<?= base_url().$ControllerRouteName.'/Listing'?>" class="btn addNewBtn btn-primary">All listings</a>
                <a href="<?= base_url().$ControllerRouteName.'/Edit/'.$id;?>" class="btn addNewBtn btn-primary">Edit</a>
                <a href="<?= base_url().$ControllerRouteName.'/'.$slug;?>" class="btn addNewBtn btn-primary" target="_blank">View</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body box-profile" id="profile-box-container" data-user-id="<?= $id;?>" data-img="<?= FCPATH.$logo?>">
                    <?php
                    if(!empty($logo) and is_file(FCPATH.$logo)){
                        $logoImage = base_url().'/'.$logo;
                    }else{
                        $logoImage = base_url('pictures/defaultLogo.png');
                    }

                    ?>
                    <div class="user-logo-container">
                        <img id="User-Logo" class="profile-user-img img-responsive" src="<?= $logoImage; ?>" alt="User profile picture">
                    </div>
                    <h3 class="profile-username text-center">
                        <b><?= $name;?></b>
                    </h3>
                    <input type="hidden" id="userIDd" value="<?=$userIDd?>">
                    <div class="text-center">
                        <?php if($ver_status) {
                            if($ver_status == 'Pending' ) {
                                echo '<label class="label label-warning">'.$ver_status.'</label>';
                            } else {
                                echo '<label data-trigger="hover" data-toggle="popover" title="Reason!" class="label label-danger" data-content="'.$data->cancel_msg.'">'.$ver_status.'</label>';
                            } } ?>
                    </div>
                    <?php if(!empty($website)){ ?>
                        <div class="web-container">
                            <label for="">Website:</label>
                            <?php
                            $findme   = 'http';
                            $pos = strpos($website, $findme);
                            if ($pos === false) {
                                $website = 'http://'.$website;
                            }
                            ?>
                            <a href="<?= $website ?>" class="btn btn-primary btn-block" target="_blank">
                                <?= $website; ?>
                            </a>
                        </div>
                    <?php } ?>
                    <?php if(!empty($email)){ ?>
                        <div class="email-container">
                            <label for="">Email:</label>
                            <p class=""><?= $email; ?></p>
                        </div>
                    <?php } ?>
                    <?php if(!empty($phone)){ ?>
                        <div class="phone-container">
                            <label for="">phone:</label>
                            <p class=""><?= $phone; ?></p>
                        </div>
                    <?php } ?>
                    <?php if(!empty($StatusName)){ ?>
                        <div class="statusFlag-container">
                            <label for="">Status:</label>
                            <p class=""><?= $StatusName; ?></p>
                        </div>
                    <?php } ?>
                    <?php if($address){ ?>
                        <div class="address-container">
                            <div class="address-text">
                                <strong><i class="fa fa-globe margin-r-5"></i>Address</strong>
                                <?php if(!empty($address_streetNumber)){?>
                                    <div class="text-muted">Street Number: <span class="street_number"><?=$address_streetNumber;?></span></div>
                                <?php } ?>
                                <?php if(!empty($address_streetName)){?>
                                    <div class="text-muted">Street Name: <span class="street_name"><?=$address_streetName;?></span></div>
                                <?php } ?>
                                <?php if(!empty($address_town)){?>
                                    <div class="text-muted">Town: <span class="town"><?=$address_town?></span></div>
                                <?php } ?>
                                <?php if(!empty($address_state)){?>
                                    <div class="text-muted">State: <span class="state"> <?=$address_state?> </span></div>
                                <?php } ?>
                                <?php if(!empty($address_postCode)){?>
                                    <div class="text-muted">Post Code: <span class="post_code"><?=$address_postCode?></span></div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="BusinessBox">Business Name:</label>
                        <p> <?= $Business;?> </p>
                    </div>
                    <div class="form-group">
                        <label for="IncorporateDate">Incorporation Date:</label>
                        <p> <?= date("d-m-Y",strtotime($IncorporateDate)) ;?> </p>
                    </div>
                    <div class="form-group">
                        <label for="AddedDate">Added Date:</label>
                        <p> <?= validate_date($AddedDate)? date("d-m-Y",strtotime($AddedDate)):' - ';?> </p>
                    </div>
                    <div class="form-group">
                        <label for="ExpiryDate">Expiry Date:</label>
                        <p> <?=  validate_date($ExpiryDate)? date("d-m-Y",strtotime($ExpiryDate)):' - ';?> </p>
                    </div>
                    <div class="form-group">
                        <label for="acn_number">ACN #:</label>
                        <p> <?= $acn_number;?> </p>
                    </div>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#questions" data-toggle="tab">Questions</a></li>
                    <li><a href="#CalculatorQuestions" data-toggle="tab">ESIC Calculator Questions</a></li>
                    <li><a href="#description" data-toggle="tab">Description</a></li>
                    <!-- Year filter-->

                    <select class="form-control year-filter pull-right"  data-toggle="tooltip" title="Prior Year Status" data-placement="bottom" name="year" data-id="<?= $id;?>" id="filter_by_year" data-placeholder="Filter By Year" onchange="listQuestionByYear(this)">
                        <?php
                        if(!empty($yearsList)){
                            $c_date = date('Y-m-d');
                            $c_Year = date('Y');
                            if( $c_date > date("$c_Year-06-30") && $c_date <= date("$c_Year-12-31") ){
                                $c_Year +=1; // 2019 Questions
                            }else if($c_date < date("$c_Year-07-01") && $c_date >= date("$c_Year-01-01") ){
                                $c_Year = date('Y'); // 2018 Questions
                            }
                            //echo "<option>".$c_Year."</option>";

                            foreach($yearsList as $year){
                                $year = explode('-',$year);
                                ?> <option <?php if($c_Year == $year[0] ){echo "selected"; }?>> <?= $year[0] ?></option>
                            <?php   }
                        }?>
                    </select>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="questions">
                        <?= $showUserQuestionAnswers;?>
                    </div>
                    <div class="tab-pane" id="CalculatorQuestions">
                        <div id="result_modal" class="modal fade CalculatorQuestionsresult_modal" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="closed pull-right" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" style="text-align: center;">  ESIC Calculator Result  </h4>
                                    </div>
                                    <div class="modal-footer" style="text-align: center;">
                                        <h5 class="result_content CalQuestion" >
                                            It is unclear if the company qualify as an ESIC at this time.
                                            Please reconsider the tests if you not already done so, contact our office, or request a private binding ruling from the ATO.
                                        </h5>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <?php
                        $arr = array();
                        if(!empty($calculator_questions_answers) && is_array($calculator_questions_answers)){
                            foreach($calculator_questions_answers as $cqas ) {
                                $cqa[$cqas->questionID] =  $cqas->ans;
                            }
                        }
                        ?>
                        <div class="q1 earlystage  Questions  " data-id="1">
                            <h5 class="CalQuestion" data-toggle="tooltip" title="The Company cannot be listed in Australia or Overseas" >Are any of the company's equity interests listed on a stock exchange? <strong>*</strong></h5>

                            <label class="containers">Yes
                                <input type="radio" name="q1" <?= $cqa[1] == 1 ? 'checked' : '' ;?> value="1" class="early" >
                                <span class="checkmark"></span>
                            </label>
                            <label class="containers">No
                                <input type="radio" name="q1" <?= ($cqa[1] !== null && $cqa[1] ==="0") ? 'checked' : '' ;?>  value="0">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="q2 earlystage  Questions  " data-id="2">
                            <h5 class="CalQuestion">Is the company early stage? When was the company incorporated in Australia? <strong>*</strong></h5>
                            <input placeholder="From" type="text" id="date-picker-example" class="form-control date_picker"
                                   data-placement="right" data-toggle="tooltip" data- title="Companies who have had more than 6 tax years are ineligible"
                                   value="<?=$cqa[2]?>">
                        </div>

                        <div class="q21 hidden  Questions  " data-id="3" > <!--   its a question 2.1  wiill be visible when q2 fail  -->
                            <h5 class="CalQuestion" data-toggle="tooltip" title="You can check this on the Australian Business Registe" >
                                Did the company register for GST and ABN within the last three income tax years? <strong>*</strong></h5>
                            <label class="containers">Yes
                                <input type="radio" name="q21" value="1" <?= $cqa[3] == 1 ? 'checked' : '' ;?>>
                                <span class="checkmark"></span>
                            </label>
                            <label class="containers">No
                                <input type="radio" name="q21" value="0" <?= ($cqa[3] !== null && $cqa[3] ==="0") ? 'checked' : '' ;?>>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="q3 earlystage  Questions  " data-id="4">
                            <h5 class="CalQuestion" data-toggle="tooltip" title="Previous tax year is typically ends on 30 June" >
                                The incentive is for underfunded early stage businesses.
                                Were the total tax expenses incurred by the company and its 100% subsidiaries $1 million or less in the previous income year?<strong>*</strong></h5>
                            <label class="containers">Yes
                                <input type="radio" name="q3" value="1"  <?= $cqa[4] == 1 ? 'checked' : '' ;?>>
                                <span class="checkmark"></span>
                            </label>
                            <label class="containers">No
                                <input type="radio" name="q3" value="0"  <?= ($cqa[4] !== null && $cqa[4] ==="0") ? 'checked' : '' ;?>>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="q4 earlystage  Questions  " data-id="5">
                            <h5 class="CalQuestion" data-toggle="tooltip" title="Find this figure on the last company tax return" >
                                The incentive is for early revenue businesses.
                                Did the company and its 100% subsidiaries have total assessable income of $200,000 or less in the previous tax year? <strong>*</strong></h5>
                            <label class="containers">Yes
                                <input type="radio" name="q4" value="1" <?= $cqa[5] == 1 ? 'checked' : '' ;?>>
                                <span class="checkmark"></span>
                            </label>
                            <label class="containers">No
                                <input type="radio" name="q4" value="0" <?= ($cqa[5] !== null && $cqa[5] ==="0") ? 'checked' : '' ;?>>
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="q5 earlystage  Questions  " data-id="6">
                            <h5 class="CalQuestion" data-toggle="tooltip" title="Group companies or associates complicate qualification" >
                                The incentives may not apply to sophisticated structured ventures.
                                Is the company undertaking innovation activities solely on its own?<strong>*</strong></h5>
                            <label class="containers">Yes
                                <input type="radio" name="q5" value="1" class="lastq" <?= $cqa[6] == 1 ? 'checked' : '' ;?>>
                                <span class="checkmark"></span>
                            </label>
                            <label class="containers">No
                                <input type="radio" name="q5" value="0" class="lastq" <?= ($cqa[6] ==="0"&& $cqa[6] !== null) ? 'checked' : '' ;?>>
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <!--Next test -->
                        <div class="nexttest hidden">
                            <p class="nexttestheading"><strong><span style=" color: #656565;" data-mce-style="color: #656565;">Now that you’ve passed the early stage criteria the company can qualify via either the 100-point Innovation test or the Principals-based test</span></strong>&nbsp;&nbsp;</p>

                            <div class="nextquestion">
                                <label class="containers">Innovation test?
                                    <input type="radio" name="nextquestion" value="1" class="nextquestions">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="containers">Principles-based test?
                                    <input type="radio" name="nextquestion" value="0" class="nextquestions">
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                        </div>


                        <!-----A.	100-point innovation test ------>
                        <div class="innotest hidden" >
                            <p style="padding-top: 25px;"><strong><span style="font-size: 24px; color: #656565;" data-mce-style="font-size: 24px; color: #656565;">100-point innovation test</span></strong>&nbsp;&nbsp;</p>
                            <p data-toggle="tooltip" title="Refer to the FAQ table for applicable points and further details"><span style="font-size: 14px;" data-mce-style="font-size: 14px;">Select any or all of the following that applies to the company: * </span></p>



                            <div class="inno1  Questions  " data-id="7">
                                <label class="checkboxcontainer">
                                    <h5 class="CalQuestion" data-toggle="tooltip" title="Only the AC grant provides points, other awards or state programs do not qualify">
                                        Received an Accelerating Commercialisation Grant
                                    </h5>
                                    <input type="checkbox"  name="inno1" value="75" class="innovalue"  <?= $cqa[7] > 0 ? 'checked' : '' ;?>>
                                    <span class="checkboxcheckmark"></span>
                                </label>
                            </div>
                            <div class="inno2  Questions  " data-id="8">
                                <label class="checkboxcontainer">
                                    <h5 class="CalQuestion" data-toggle="tooltip" title="See the prior year company tax return for the R&D and Expense figures">
                                        Greater than 50% of the company's total expenses in the previous tax year are eligible R&D expenses
                                    </h5>
                                    <input type="checkbox"  name="inno2" value="75" class="innovalue"  <?= $cqa[8] > 0 ? 'checked' : '' ;?>>
                                    <span class="checkboxcheckmark"></span>
                                </label>
                            </div>
                            <div class="inno3  Questions  " data-id="9">
                                <label class="checkboxcontainer">
                                    <h5 class="CalQuestion" data-toggle="tooltip" title="See the prior year company tax return for the R&D and Expense figures">
                                        Between 15% and 50% of the company's total tax expenses in the previous income year are eligible R&D expenses
                                    </h5>
                                    <input type="checkbox"  name="inno3"  value="50" class="innovalue"  <?= $cqa[9] > 0 ? 'checked' : '' ;?>>
                                    <span class="checkboxcheckmark"></span>
                                </label>
                            </div>
                            <div class="inno4  Questions  " data-id="10">
                                <label class="checkboxcontainer">
                                    <h5 class="CalQuestion" data-toggle="tooltip" title="Not all accelerator programs are eligible">
                                        The company is undertaking or has completed an eligible accelerator program
                                    </h5>
                                    <input type="checkbox"  name="inno4"  value="50" class="innovalue"  <?= $cqa[10] > 0 ? 'checked' : '' ;?>>
                                    <span class="checkboxcheckmark"></span>
                                </label>
                            </div>
                            <div class="inno5  Questions  " data-id="11">
                                <label class="checkboxcontainer">
                                    <h5 class="CalQuestion" data-toggle="tooltip" title="Only independent share investment qualifies">
                                        At least $50,000 has been paid for new shares, prior to this new investment
                                    </h5>
                                    <input type="checkbox"  name="inno5" value="50" class="innovalue"  <?= $cqa[11] > 0 ? 'checked' : '' ;?>>
                                    <span class="checkboxcheckmark"></span>
                                </label>
                            </div>
                            <div class="inno6  Questions  " data-id="12">
                                <label class="checkboxcontainer">
                                    <h5 class="CalQuestion" data-toggle="tooltip" title="Provisional lodgement is not eligible">
                                        The company owns or has licenced rights to commercialise a standard patent or plant breeder's right granted in the last 5 years
                                    </h5>
                                    <input type="checkbox"  name="inno6" value="50" class="innovalue"  <?= $cqa[12] > 0 ? 'checked' : '' ;?>>
                                    <span class="checkboxcheckmark"></span>
                                </label>
                            </div>
                            <div class="inno7  Questions  " data-id="13">
                                <label class="checkboxcontainer">
                                    <h5 class="CalQuestion" data-toggle="tooltip" title="Provisional lodgement is not eligible">
                                        The company owns or has licenced rights to commercialise an innovation patent or design right granted in the last 5 years
                                    </h5>
                                    <input type="checkbox"  name="inno7" value="25" class="innovalue"  <?= $cqa[13] > 0 ? 'checked' : '' ;?>>
                                    <span class="checkboxcheckmark"></span>
                                </label>
                            </div>
                            <div class="inno8  Questions  " data-id="14">
                                <label class="checkboxcontainer">
                                    <h5 class="CalQuestion" data-toggle="tooltip" title="Please see our list and contact your research partner to confirm">
                                        The company has a written agreement to co-develop and commercialise an innovation with a research organisation or university
                                    </h5>
                                    <input type="checkbox"  name="inno8" value="25" class="innovalue"  <?= $cqa[14] > 0 ? 'checked' : '' ;?>>
                                    <span class="checkboxcheckmark"></span>
                                </label>
                            </div>

                        </div>



                        <!-----B	Principles-based test  ------>
                        <div class="printest hidden">
                            <p style="padding-top: 25px;"><strong><span style="font-size: 24px; color: #656565;" data-mce-style="font-size: 24px; color: #656565;">Principles-based test </span></strong>&nbsp;&nbsp;</p>


                            <div class="q7  Questions  " data-id="16">
                                <h5 class="CalQuestion">
                                    Is the company genuinely
                                    focussed on
                                    <span data-toggle="tooltip" title="substantial further development is required" >developing </span>
                                    an
                                    <span data-toggle="tooltip" title="is developing, a new or significantly improved product, service, process or marketing method" >innovation </span>
                                    for commercialisation? <strong>*</strong>
                                </h5>
                                <label class="containers">Yes
                                    <input type="radio" name="q7" value="1"  <?= $cqa[16] == 1 ? 'checked' : '' ;?>>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="containers">No
                                    <input type="radio" name="q7" value="0" <?= ($cqa[16] !== null && $cqa[16] ==="0") ? 'checked' : '' ;?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="q8  Questions  " data-id="17">
                                <h5 class="CalQuestion">
                                    Does the business relating to the innovation have
                                    <span data-toggle="tooltip" title="Will not include business that have inherently local supply, such as a café" >high growth potential? </span>
                                    <strong>*</strong></h5>
                                <label class="containers">Yes
                                    <input type="radio" name="q8" value="1" <?= $cqa[17] == 1 ? 'checked' : '' ;?>>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="containers">No
                                    <input type="radio" name="q8" value="0" <?= ($cqa[17] !== null && $cqa[17] ==="0") ? 'checked' : '' ;?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="q9  Questions  " data-id="18">
                                <h5 class="CalQuestion">
                                    Can the company demonstrate it has the potential to successfully
                                    <span data-toggle="tooltip" title="The company can demonstrate operating leverage or cost per unit advantage" > scale </span>
                                    up that  <span data-toggle="tooltip" title="A typical business, such as a dentist, who’s operating expenses are similar, despite scale would not qualify" > business </span> ?
                                    <strong>*</strong></h5>
                                <label class="containers">Yes
                                    <input type="radio" name="q9" value="1" <?= $cqa[18] == 1 ? 'checked' : '' ;?>>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="containers">No
                                    <input type="radio" name="q9" value="0" <?= ($cqa[18] !== null && $cqa[18] ==="0") ? 'checked' : '' ;?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="q10  Questions  " data-id="19">
                                <h5 class="CalQuestion">
                                    Can the company demonstrate it has the potential to address a
                                    <span data-toggle="tooltip" title="Multi State or International" > broader </span>
                                    than local market through that business?
                                    <strong>*</strong></h5>
                                <label class="containers">Yes
                                    <input type="radio" name="q10" value="1" <?= $cqa[19] == 1 ? 'checked' : '' ;?>>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="containers">No
                                    <input type="radio" name="q10" value="0" <?= ($cqa[19] !== null && $cqa[19] ==="0") ? 'checked' : '' ;?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="q11   Questions  " data-id="20">
                                <h5 class="CalQuestion">
                                    Can the company demonstrate it has the potential to have a
                                    <span data-toggle="tooltip" title="What sets you apart? Unique customer benefits, Cost differential, Measure of value to the customer, Rarity v availability of substitutes" > competitive advantage </span>
                                    for that business?
                                    <strong>*</strong></h5>
                                <label class="containers">Yes
                                    <input type="radio" name="q11" value="1" <?= $cqa[20] == 1 ? 'checked' : '' ;?>>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="containers">No
                                    <input type="radio" name="q11" value="0" <?= ($cqa[20] !== null && $cqa[20] ==="0") ? 'checked' : '' ;?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                        </div>

                        <button class="btn  show_result" value=""> Show Result</button>
                    </div>








                    <div class="tab-pane" id="description">
                        <ul class="timeline timeline-inverse">
                            <?php if(!empty($banner)){ ?>
                                <li>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header">Banner:</h3>
                                        <div class="form-group">
                                            <div class="img-reponsive">
                                                <div class="img-container img-logo img-responsive">
                                                    <img src="<?= base_url().$banner;?>" class="banner-show" id="banner-show" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                            <?php if(!empty($productImage)){ ?>
                                <li>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header">Product Image:</h3>
                                        <div class="form-group">
                                            <div class="img-reponsive">
                                                <div class="img-container img-logo img-responsive">
                                                    <img src="<?= base_url().$productImage;?>" class="productImage-show" id="productImage-show" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                            <li>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">Short Description:</h3>
                                    <div id="short-desc-text" class="timeline-body">
                                        <pre><?= trim(urldecode($short_description));?></pre>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="timeline timeline-inverse">
                            <li>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">Detail Description:</h3>
                                    <div id="short-desc-text" class="timeline-body">
                                        <pre><?= trim(urldecode($long_description));?></pre>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>

    <div class="box">
        <div class="box-footer">
            <div class="button-container action-button-sticky-bar">
                <a href="<?= base_url().$ControllerRouteName.'/Listing'?>" class="btn addNewBtn btn-primary">All listings</a>
                <a href="<?= base_url().$ControllerRouteName.'/Edit/'.$id;?>" class="btn addNewBtn btn-primary">Edit</a>
                <a href="<?= base_url().$ControllerRouteName.'/'.$slug;?>" class="btn addNewBtn btn-primary">View</a>
            </div>
        </div>
    </div>
<?= $viewFooter;?>