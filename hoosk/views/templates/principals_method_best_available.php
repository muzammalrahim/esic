<?php echo $header; ?>
    <style>
        .container-fluid {
            background: #fff;
        }

        .mainFormDiv {
            /*background-color: #424242;*/
            background-color: #ffffff; /*added by Hamid Raza*/
            box-shadow: 0 0 9px rgba(0, 0, 0, 0.3);
        }

        .btn-dark {
            float: left;
        }

        .formwrap {
            max-width: 980px;
            margin: 12px auto;
        }

        .button-container {
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
            background-color: #9999998c;
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

        .questionwrap {

            max-width: 980px;
            margin: 12px auto;
        }

        .questionwrap h5 {
            padding-left: 5px;
            font-weight: 600;
            color: #656565;
            padding-top: 10px;
        }

        .datepicker table {
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

        p.nexttestheading {
            margin-top: 20px;
        }

        .nexttestheading span {
            font-size: 16px;
            color: #656565;
            line-height: 1.5em;
            text-align: center;;
        }
        .nextquestion .containers {
            width: 250px;
            width: 330px;
            margin: 0 auto;
        }
        .nexttest {
            text-align: center;
        }
        button#continue, .closedbtn {
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
            margin: 10px 0 0 5px;
            font-size: 16px;
            color: #fff;
            background-color: #494949bf;
            border-color: #494949bf;
            text-decoration: none !important;
        }
        .show_result:hover {
            color: #fff;
            background: #171717;
            outline: none;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.4);
        }
        button#continue:hover, .closedbtn:hover {
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
        #noty_topRight_layout_container li {
            background-color: rgba(241, 241, 241, 0.74) !important;
            border-color: rgba(241, 241, 241, 0.74) !important;
            height: auto !important;
            margin: 5px 0 0 0 !important;
        }
        #noty_topRight_layout_container li {
            color: #656565 !important;
        }
        tr:nth-child(odd) {
            background-color: #cececeed;
        }
        tr:nth-child(even) {
            background-color: rgb(241, 240, 240);
        }
        td:not(:last-child){
            border-right: 2px solid #fff9;
        }
        td {
            padding: 8px;
        }
        table.test {
            margin-bottom: 30px !important;
            border-block-end: 2px solid rgb(131, 161, 187);
        }
        label.containers {
            text-align: left;
        }
        .wizard > .content > .body label {
            display: block !important;
            margin-bottom: 0.5em;
        }
        .wizard > .content > .body {
            /*padding: 0 0 0 2.5% !important;*/
            position: initial !important;
            width: 100% !important;
        }
        .wizard > .content {
            min-height: 30em !important;
            margin: 0 !important;
        }
        .tabcontrols {
            margin-top: 25px;
        }
        .wrap {
            margin: 20px auto 0;
        }


        /*Display none*/
        .actions ul li:nth-child(3) a {
            display: none !important;
        }

        @media (max-width: 1024px) {
            .datepicker thead tr {
                position: relative;
                top: -9999px;
                left: -9999px;

            }

            .datepicker thead, tbody {
                display: auto;
            }

            .datepicker table td {
                width: auto !important;
            }

            input#date-picker-example {
                width: 50%;
            }

        }

        @media (max-width: 448px) {
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
        ul[role="tablist"] {
            display: none;
        }
        #esic-audit-assistant-wiz div.content {
            background:transparent !important;
        }
        #TimedPopupWarning .modal-content {
            border-radius: 5px;
        }


    </style>
    <div class="container">
        <?php echo $page['pageContentHTML']; ?>

        <!--Early Stage Test  Best-->
        <?php include( APPPATH . 'views/partials/audit_assistant_tools/buttons.php'); ?>
        
        <table style="width: 920px;" class="test estbest">
            <tbody>
            <tr style="background-color: #83a1bb;">
                <td style="width: 439px;" colspan="2">
                    <p><span><strong style="font-size: 20px; color: #00396b;line-height: 40px;font-weight: 800;"> Early Stage Test</strong><br>
                                    <strong  style="font-size: 18px; color: #f3f3f3">Typically applies immediately after the shares were issued</strong>
                            </strong><!--EndFragment--></span></p>
                </td>
            </tr>
            <tr>
                <td style="width: 439px; text-align: left;">Records that the company was not listed on an official stock exchange in Australia or a foreign country.
                </td>
                <td style="width: 480px; text-align: left;">
                    ATO Private Ruling or company certification and independent search records of exchanges.

                </td>
            </tr>
            <tr>
                <td style="width: 439px;">Record of the issue date of the shares
                </td>
                <td style="width: 480px;">
                    Copy of ASIC lodgement, Detailed ASIC Extract and Original Share Certificates

                </td>
            </tr>
            <tr>
                <td style="width: 439px;">The company’s and its 100% subsidiaries financial records previous financial year reports (show $1 million or less expenses and $200,000 or less in income)
                </td>
                <td style="width: 480px;">
                    Up to 6 years signed prior year taxation returns and consolidated company financial statements

                </td>
            </tr>
            <tr>
                <td style="width: 439px;">Independent records for ASIC Incorporation or registration on the ABR
                </td>
                <td style="width: 480px;">
                    ASIC and ABR Extract

                </td>
            </tr>
            <tr>
                <td style="width: 439px;">Proof that company was undertaking innovation activities solely on its own, or that the ownership structure did not defeat the purpose of ESIC concessions. The incentives may not apply to sophisticated structured ventures
                </td>
                <td style="width: 480px;">
                    Illustrated Company Structure Chart and independent relational company extract and corporate structure report.

                </td>
            </tr>
            </tbody>
        </table>

        <!---Principals (Innovation) Based Test  Best-->

        <table style="width: 920px;" class="test prbtbest">
            <tbody>
            <tr style="background-color: #83a1bb;">
                <td style="width: 439px;" colspan="2">
                    <p><span><strong style="font-size: 20px; color: #00396b;line-height: 40px;font-weight: 800;"> Principals (Innovation) Based Test </strong><br>
                                    <strong  style="font-size: 18px; color: #f3f3f3">You have the following proof immediately after the shares were issued </strong>
                            </strong><!--EndFragment--></span></p>
                </td>
            </tr>
            <tr>
                <td style="width: 439px; text-align: left;">Pt1:The company genuinely focussed on developing, a new or significantly improved product, service,
                    process or marketing method for commercialisation?
                </td>
                <td style="width: 480px; text-align: left;">
                    Favourable ATO Private that confirms genuine focus on developing for commercialisation.

                </td>
            </tr>
            <tr>
                <td style="width: 439px;">Pt2:The company genuinely focussed on developing, a new or significantly improved product,
                    service, process or marketing method for commercialisation?
                </td>
                <td style="width: 480px;">
                    Favourable ATO Private that confirms New or Significantly improved

                </td>
            </tr>
            <tr>
                <td style="width: 439px;"> The innovation has high growth potential
                </td>
                <td style="width: 480px;">
                    Favourable ATO Private
                </td>
            </tr>
            <tr>
                <td style="width: 439px;">Demonstrated ability to scale
                </td>
                <td style="width: 480px;">
                    Favourable ATO Private
                </td>
            </tr>
            <tr>
                <td style="width: 439px;">Demonstrated access to wide markets
                </td>
                <td style="width: 480px;">
                    Favourable ATO Private
                </td>
            </tr>
            <tr>
                <td style="width: 439px;">Competitive advantage</td>
                <td style="width: 480px;">
                    Favourable ATO Private *<br>
                    *Matched ATO ruling reference number would be sufficient.

                </td>
            </tr>
            </tbody>
        </table>

    </div>
<?php echo $footer; ?>