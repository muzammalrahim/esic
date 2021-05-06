<?php echo $header; ?>

<style>
    .container-fluid {
        background: #fff;
    }
    .mainFormDiv {
        /*background-color: #424242;*/
        background-color:#ffffff;/*added by Hamid Raza*/
        box-shadow: 0 0 9px rgba(0,0,0,0.3);
    }
    .btn-dark{
        float: left;
    }
    .formwrap {
        max-width: 980px;
        margin: 12px auto;
    }
    .button-container{
        margin: 2px 0;
    }
    .containers {

        display: block;
        position: relative;
        border: 2px solid lightgray;
        width: 200px;
        padding: 8px;
        padding-left: 40px;
        cursor: pointer;
        font-size: 14px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* 100 points ccss */

    /* The container */
    .checkboxcontainer {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .checkboxcontainer input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkboxcheckmark {
        position: absolute;
        top: 6px;
        left: 0;
        height: 25px;
        width: 25px;
        border: 2px solid #000000b5;
        background-color:#9999998c;
    }

    /* On mouse-over, add a grey background color */
    .checkboxcontainer:hover input ~ .checkboxcheckmark {
        background-color: #333;
    }

    /* When the checkbox is checked, add a blue background */
    .checkboxcontainer input:checked ~ .checkboxcheckmark {
        background-color: #656565;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkboxcheckmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .checkboxcontainer input:checked ~ .checkboxcheckmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .checkboxcontainer .checkboxcheckmark:after {
        left: 8px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    /*100 points css end */

    /* Hide the browser's default radio button */
    .containers input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        top: 8px;
        left: 10px;
        height: 20px;
        width: 20px;
        background-color: #eee;
        border-radius: 50%;
        border: 2px solid #00000029;
    }

    /* On mouse-over, add a grey background color */
    .containers:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .containers input:checked ~ .checkmark {
        background-color: #656565;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .containers input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .containers .checkmark:after {
        top: 4px;
        left: 4px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }
    .questionwrap{
        display: none;
        max-width: 980px;
        margin: 12px auto;
    }
    .questionwrap h5 {
        padding-left:5px;
        font-weight: 600;
        color: #656565;
        padding-top: 10px;
    }
    .datepicker table{
        background-color: #fff;
        margin: 0 !important;
    }
    .datepicker td, .datepicker th {
        width: auto;
    }
    input#date-picker-example {
        width: 200px;
        margin-left: 5px;
    }
    .questionwrap {
        padding-top: 0px;
        margin-top: 0;
    }
    .questionwrap .q1 h5 {
        padding-top: 0px;
        margin-top: 0;
    }

    .btn-blue:hover{
        font-size: 16px;
    }
    p.nexttestheading {
        margin-top: 20px;
    }
    .nexttestheading span{
        font-size: 20px;
        color: #656565;
        line-height: 1.5em;
    }
    .nextquestion .containers{
        width: 250px;
    }

    button#continue , .closedbtn {
        color: #fff;
        background: #494949bf;
        text-decoration: none;
        min-width: 160px;
        transition: all 0.4s;
        line-height: normal;
        padding: 10px 20px;
        border: none;
        margin-top: 20px;
        font-family: 'Raleway', sans-serif;
        text-transform: uppercase;
    }
    .show_result {
        margin:10px 0 0 5px;
        font-size: 16px;
        color: #fff;
        background-color: #494949bf;
        border-color: #494949bf;
        text-decoration: none !important;
    }
    .show_result:hover{
        color: #fff;
        background: #171717;
        outline: none;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.4);
    }
    button#continue:hover , .closedbtn:hover{
        background: #171717;
        outline: none;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.4);

    }
    .modal-title {
        color: #000;
        text-align: center;
        font-family: 'Raleway', sans-serif;
        font-weight: 800;
        font-size: 25px;
        margin: 0;
        text-transform: uppercase;
        margin: 0;
        line-height: 1.42857143;
    }
    .errors {
        color: #b33;
        font-size: 14px;
        font-weight: 600;
        padding: 0 0 5px 5px;
    }
    #noty_topRight_layout_container{
        background-color: rgba(241, 241, 241, 0.74) !important;
        height:auto !important;

    }
    #noty_topRight_layout_container li {
        background-color: rgba(241, 241, 241, 0.74) !important;
        border-color:rgba(241, 241, 241, 0.74) !important;
        height:auto !important;
        margin: 5px 0 0 0  !important;
    }

    #noty_topRight_layout_container li {
        color: #656565 !important;
    }
    @media(max-width:1024px) {
        .datepicker thead tr {
            position: relative;
            top: -9999px;
            left: -9999px;

        }
        .datepicker thead ,tbody {
            display: auto;
        }
        .datepicker table td {
            width: auto!important;
        }
        input#date-picker-example {
            width: 50%;
        }

    }
    @media(max-width:448px) {
        .questionwrap h5 {            
            padding-top: 3px;
        }
        .containers {
            width: 250px;
        }
        input#date-picker-example {
            width: 250px;
        }
    }
</style>

<!-- Page CONTENT
=================================-->
    <div id="result_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="closed pull-right" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="text-align: center;">  ESIC Calculator Result  </h4>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <h5 class="result_content" >
                        It is unclear if the company qualify as an ESIC at this time.
                        Please reconsider the tests if you not already done so, contact our office, or request a private binding ruling from the ATO.
                    </h5>

                </div>
            </div>
        </div>
    </div>
<div class="container-fluid">
    <div class="container">
        <div class="clear"></div>
        <div class="row wrap">
             <?= $page['pageContentHTML']; ?>
        </div>
        <div class="row formwrap">
            <?php
            if($this->session->userdata('msg')){?>
                <div class="alert alert-success " style="position:relative">
                    <?php echo $this->session->userdata('msg');
                    $this->session->unset_userdata('msg');
                    ?>
                </div>
            <?php } ?>
            <div class="col-lg-12 mainFormDiv" id="estimatorbtnform">

            <form>
                <div id="form1">
                    <fieldset>
                        <label for="Name">Name<span class="required-fields">*</span></label>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <input id="fname"  type="text"  name="FirstName" placeholder="First" class="form-control" value="<?= $user->firstName?>" <?= $user->firstName ? 'disabled': '' ?>/>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <input id="lname"  name="LastName" type="text" placeholder="Last" class="form-control" value="<?= $user->lastName?>" <?= $user->lastName ? 'disabled': '' ?>/>
                                </div>
                            </div>
                        </div>
                        <label for="Email">Email <span class="required-fields">*</span></label>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                    <input id="Email" name="email" type="email" class="form-control" placeholder="xyz@example.com" value="<?= $user->email?> " <?= $user->email ? 'disabled': '' ?>/>
                                    <input id="Email2" name="email2" type="hidden"  value=""/>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="button-container">
                                        <input type="submit" class="btn btn-dark estimatorbtn" value="Go"  <?= $user->email ? 'disabled': '' ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
            </form>
        </div>
        </div>

        <div class="row questionwrap">

            <div class="q1 earlystage  Questions  " data-id="<?= $question[0]->id; ?>">
                <h5 data-toggle="tooltip" title="The Company cannot be listed in Australia or Overseas" >Are any of the company's equity interests listed on a stock exchange? <strong>*</strong></h5>
                <label class="containers">Yes
                    <input type="radio" name="q1" value="1" class="early">
                    <span class="checkmark"></span>
                </label>
                <label class="containers">No
                    <input type="radio" name="q1" value="0">
                    <span class="checkmark"></span>
                </label>
            </div>

            <div class="q2 earlystage  Questions  " data-id="<?= $question[1]->id; ?>">
                <h5>Is the company early stage? When was the company incorporated in Australia? <strong>*</strong></h5>
                    <input placeholder="From" type="text" id="date-picker-example" class="form-control date_picker"
                           data-placement="right" data-toggle="tooltip" data- title="Companies who have had more than 6 tax years are ineligible">
            </div>

          <div class="q21 hidden  Questions  " data-id="<?= $question[2]->id; ?>" > <!--   its a question 2.1  wiill be visible when q2 fail  -->
                <h5 data-toggle="tooltip" title="You can check this on the Australian Business Registe" >
                    Did the company register for GST and ABN within the last three income tax years? <strong>*</strong></h5>
                <label class="containers">Yes
                    <input type="radio" name="q21" value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="containers">No
                    <input type="radio" name="q21" value="0">
                    <span class="checkmark"></span>
                </label>
            </div>

            <div class="q3 earlystage  Questions  " data-id="<?= $question[3]->id; ?>">
                <h5 data-toggle="tooltip" title="Previous tax year is typically ends on 30 June" >
                    The incentive is for underfunded early stage businesses.
                    Were the total tax expenses incurred by the company and its 100% subsidiaries $1 million or less in the previous income year?<strong>*</strong></h5>
                <label class="containers">Yes
                    <input type="radio" name="q3" value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="containers">No
                    <input type="radio" name="q3" value="0">
                    <span class="checkmark"></span>
                </label>
            </div>
            <div class="q4 earlystage  Questions  " data-id="<?= $question[4]->id; ?>">
                <h5 data-toggle="tooltip" title="Find this figure on the last company tax return" >
                    The incentive is for early revenue businesses.
                    Did the company and its 100% subsidiaries have total assessable income of $200,000 or less in the previous tax year? <strong>*</strong></h5>
                <label class="containers">Yes
                    <input type="radio" name="q4" value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="containers">No
                    <input type="radio" name="q4" value="0">
                    <span class="checkmark"></span>
                </label>
            </div>

            <div class="q5 earlystage  Questions  " data-id="<?= $question[5]->id; ?>">
                <h5 data-toggle="tooltip" title="Group companies or associates complicate qualification" >
                    The incentives may not apply to sophisticated structured ventures.
                    Is the company undertaking innovation activities solely on its own?<strong>*</strong></h5>
                <label class="containers">Yes
                    <input type="radio" name="q5" value="1" class="lastq">
                    <span class="checkmark"></span>
                </label>
                <label class="containers">No
                    <input type="radio" name="q5" value="0" class="lastq">
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



                <div class="inno1  Questions  " data-id="<?= $question[6]->id; ?>">
                    <label class="checkboxcontainer">
                        <h5 data-toggle="tooltip" title="Only the AC grant provides points, other awards or state programs do not qualify">
                            Received an Accelerating Commercialisation Grant
                        </h5>
                        <input type="checkbox"  name="inno1" value="75" class="innovalue">
                        <span class="checkboxcheckmark"></span>
                    </label>
                </div>
                <div class="inno2  Questions  " data-id="<?= $question[7]->id; ?>">
                    <label class="checkboxcontainer">
                        <h5 data-toggle="tooltip" title="See the prior year company tax return for the R&D and Expense figures">
                            Greater than 50% of the company's total expenses in the previous tax year are eligible R&D expenses
                        </h5>
                        <input type="checkbox"  name="inno2" value="75" class="innovalue RandD" data-type="RandD"">
                        <span class="checkboxcheckmark"></span>
                    </label>
                </div>
                <div class="inno3  Questions  " data-id="<?= $question[8]->id; ?>">
                    <label class="checkboxcontainer">
                        <h5 data-toggle="tooltip" title="See the prior year company tax return for the R&D and Expense figures">
                            Between 15% and 50% of the company's total tax expenses in the previous income year are eligible R&D expenses
                        </h5>
                        <input type="checkbox"  name="inno3"  value="50" class="innovalue RandD" data-type="RandD">
                        <span class="checkboxcheckmark"></span>
                    </label>
                </div>
                <div class="inno4  Questions  " data-id="<?= $question[9]->id; ?>">
                    <label class="checkboxcontainer">
                        <h5 data-toggle="tooltip" title="Not all accelerator programs are eligible">
                            The company is undertaking or has completed an eligible accelerator program
                        </h5>
                        <input type="checkbox"  name="inno4"  value="50" class="innovalue">
                        <span class="checkboxcheckmark"></span>
                    </label>
                </div>
                <div class="inno5  Questions  " data-id="<?= $question[10]->id; ?>">
                    <label class="checkboxcontainer">
                        <h5 data-toggle="tooltip" title="Only independent share investment qualifies">
                            At least $50,000 has been paid for new shares, prior to this new investment
                        </h5>
                        <input type="checkbox"  name="inno5" value="50" class="innovalue">
                        <span class="checkboxcheckmark"></span>
                    </label>
                </div>
                <div class="inno6  Questions  " data-id="<?= $question[11]->id; ?>">
                    <label class="checkboxcontainer">
                        <h5 data-toggle="tooltip" title="Provisional lodgement is not eligible">
                            The company owns or has licenced rights to commercialise a standard patent or plant breeder's right granted in the last 5 years
                        </h5>
                        <input type="checkbox"  name="inno6" value="50" class="innovalue IP" data-type="IP">
                        <span class="checkboxcheckmark"></span>
                    </label>
                </div>
                <div class="inno7  Questions  " data-id="<?= $question[12]->id; ?>">
                    <label class="checkboxcontainer">
                        <h5 data-toggle="tooltip" title="Provisional lodgement is not eligible">
                            The company owns or has licenced rights to commercialise an innovation patent or design right granted in the last 5 years
                        </h5>
                        <input type="checkbox"  name="inno7" value="25" class="innovalue IP" data-type="IP">
                        <span class="checkboxcheckmark"></span>
                    </label>
                </div>
                <div class="inno8  Questions  " data-id="<?= $question[13]->id; ?>">
                    <label class="checkboxcontainer">
                        <h5 data-toggle="tooltip" title="Please see our list and contact your research partner to confirm">
                            The company has a written agreement to co-develop and commercialise an innovation with a research organisation or university
                        </h5>
                        <input type="checkbox"  name="inno8" value="25" class="innovalue">
                        <span class="checkboxcheckmark"></span>
                    </label>
                </div>
                <div class="inno9  Questions  " data-id="<?= $question[14]->id; ?>">
                    <label class="checkboxcontainer">
                        <h5>
                            None of the above
                        </h5>
                        <input type="checkbox"  name="inno9" value="0" class="Noneoftheabove">
                        <span class="checkboxcheckmark"></span>
                    </label>
                </div>
            </div>



            <!-----B	Principles-based test  ------>
            <div class="printest hidden">
                <p style="padding-top: 25px;"><strong><span style="font-size: 24px; color: #656565;" data-mce-style="font-size: 24px; color: #656565;">Principles-based test </span></strong>&nbsp;&nbsp;</p>


                <div class="q7  Questions  " data-id="<?= $question[15]->id; ?>">
                    <h5>
                        Is the company genuinely
                        focussed on
                        <span data-toggle="tooltip" title="substantial further development is required" >developing </span>
                        an
                        <span data-toggle="tooltip" title="is developing, a new or significantly improved product, service, process or marketing method" >innovation </span>
                          for commercialisation? <strong>*</strong>
                    </h5>
                    <label class="containers">Yes
                        <input type="radio" name="q7" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="containers">No
                        <input type="radio" name="q7" value="0">
                        <span class="checkmark"></span>
                    </label>
                </div>

                <div class="q8  Questions  " data-id="<?= $question[16]->id; ?>">
                    <h5>
                        Does the business relating to the innovation have
                        <span data-toggle="tooltip" title="Will not include business that have inherently local supply, such as a café" >high growth potential? </span>
                         <strong>*</strong></h5>
                    <label class="containers">Yes
                        <input type="radio" name="q8" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="containers">No
                        <input type="radio" name="q8" value="0">
                        <span class="checkmark"></span>
                    </label>
                </div>

                <div class="q9  Questions  " data-id="<?= $question[17]->id; ?>">
                    <h5>
                        Can the company demonstrate it has the potential to successfully
                        <span data-toggle="tooltip" title="The company can demonstrate operating leverage or cost per unit advantage" > scale </span>
                         up that  <span data-toggle="tooltip" title="A typical business, such as a dentist, who’s operating expenses are similar, despite scale would not qualify" > business </span> ?
                        <strong>*</strong></h5>
                    <label class="containers">Yes
                        <input type="radio" name="q9" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="containers">No
                        <input type="radio" name="q9" value="0">
                        <span class="checkmark"></span>
                    </label>
                </div>

                <div class="q10  Questions  " data-id="<?= $question[18]->id; ?>">
                    <h5>
                        Can the company demonstrate it has the potential to address a
                        <span data-toggle="tooltip" title="Multi State or International" > broader </span>
                         than local market through that business?
                        <strong>*</strong></h5>
                    <label class="containers">Yes
                        <input type="radio" name="q10" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="containers">No
                        <input type="radio" name="q10" value="0">
                        <span class="checkmark"></span>
                    </label>
                </div>

                <div class="q11   Questions  " data-id="<?= $question[19]->id; ?>">
                <h5>
                    Can the company demonstrate it has the potential to have a
                    <span data-toggle="tooltip" title="What sets you apart? Unique customer benefits, Cost differential, Measure of value to the customer, Rarity v availability of substitutes" > competitive advantage </span>
                     for that business?
                    <strong>*</strong></h5>
                <label class="containers">Yes
                    <input type="radio" name="q11" value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="containers">No
                    <input type="radio" name="q11" value="0">
                    <span class="checkmark"></span>
                </label>
            </div>

             </div>

            <button class="btn  show_result" value=""> Show Result</button>
        </div>
        <hr>



</div>
</div>

    </div>
<!-- /CONTENT ============-->
<?php echo $footer; ?>