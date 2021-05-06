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
        <?php include( APPPATH . 'views/partials/audit_assistant_tools/buttons.php'); ?>

        <!--- Early Stage Test  Alternate-->

        <table style="width: 920px;" class="test estalternate">
            <tbody>
            <tr style="background-color: #83a1bb;">
                <td style="width: 439px;" colspan="2">
                    <p><span><strong style="font-size: 20px; color: #00396b;line-height: 40px;font-weight: 800;"> Early Stage Test
                            </strong><br>
                                    <strong  style="font-size: 18px; color: #f3f3f3">Typically applies immediately after the shares were issued.</strong>
                            </strong><!--EndFragment--></span></p>
                </td>
            </tr>
            <tr>
                <td style="width: 439px; text-align: left;">Records that the company was not listed on an official stock exchange in Australia or a foreign country.
                </td>
                <td style="width: 480px; text-align: left;">Front page of a favourable ATO ruling, or Exchange search lookup.
                </td>
            </tr>
            <tr>
                <td style="width: 439px;">Record of the issue date of the shares
                </td>
                <td style="width: 480px;">ASIC Company Search
                </td>
            </tr>
            <tr>
                <td style="width: 439px;">The company’s and its 100% subsidiaries financial records previous financial year reports
                    (show $1 million or less expenses and $200,000 or less in income).
                </td>
                <td style="width: 480px;">
                    Extracts of prior year taxation returns or consolidated company financial statements showing total income and total expenses
                </td>
            </tr>
            <tr>
                <td style="width: 439px;">Independent records for ASIC Incorporation or registration on the ABR
                </td>
                <td style="width: 480px;">Free ASIC and ABR lookup
                </td>
            </tr>
            <tr>
                <td style="width: 439px;">Proof that company was undertaking innovation activities solely on its own,
                    or that the ownership structure did not defeat the purpose of ESIC concessions.
                    The incentives may not apply to sophisticated structured ventures.
                </td>
                <td style="width: 480px;">Illustrated Company Structure Chart or equivalent disclosure from ASIC registered agent.
                </td>
            </tr>
            </tbody>

        </table>

        <!--- Points Based Test  Alternate -->

        <table style="width: 920px;" class="test pobtalternate">

            <tbody>
            <tr style="background-color: #83a1bb;">
                <td style="width: 439px;" colspan="3">
                    <p><span><strong style="font-size: 20px; color: #00396b;line-height: 40px;font-weight: 800;"> Points Based Test  </strong><br>
                                    <strong  style="font-size: 18px; color: #f3f3f3">You have the following proof immediately after the shares were issued</strong>
                            </strong><!--EndFragment--></span></p>
                </td>
            </tr>
            <tr>
                <td style="width: 439px; text-align: left;">Accelerating Commercialisation Grant under the Accelerating
                    Commercialisation element of the Commonwealth’s Entrepreneur’s programme
                </td>
                <td style="width: 100px; text-align: center;">75 Points</td>
                <td style="width: 480px; text-align: left;">
                    Full Company Name listed in a signed confirmation letter from the Department of Industry, Innovation and Science.
                </td>
            </tr>
            <tr>
                <td style="width: 439px;">At least 50 per cent of the company’s total expenses for the previous income year
                    constitute expenses which are eligible for the tax offset for R&D activities provided under Division 355
                </td>
                <td style="width: 100px; text-align: center;">75 Points
                </td>
                <td style="width: 480px;">Tax Return Extract showing total expenses and R&D
                </td>
            </tr>
            <tr>
                <td style="width: 439px;">The company is undertaking or has completed an eligible accelerator programme
                </td>
                <td style="width: 100px; text-align: center;">
                    50 Points
                </td>
                <td style="width: 480px;">
                    Accelerator graduates have ATO Private Ruling of points status and the company that issued the shares has a certificate of completion in its name (not an individuals or another companies name).
                    Legal opinion letter in favour of the eligibility of the program.
                </td>
            </tr>
            <tr>
                <td style="width: 439px;">At least 15 and less than 50 per cent of the company’s total expenses for the previous income
                    year constitute expenses which are eligible for the tax offset for R&D activities provided under Division 355
                </td>
                <td style="width: 100px; text-align: center;">
                    50 Points
                </td>
                <td style="width: 480px;">Tax Return Extract showing total expenses and R&D
                </td>
            </tr>
            <tr>
                <td style="width: 439px;">The company has issued at least $50,000 of shares to a third party
                </td>
                <td style="width: 100px; text-align: center;">
                    50 Points
                </td>
                <td style="width: 480px;">Non-associate and ‘not for tax advantage’ assertions by the company and initial seed investor(s).
                    ASIC records and company/investor correspondence.
                </td>
            </tr>
            <tr>
                <td style="width: 439px;">Within the last five years, the company has one or more enforceable rights on an innovation through
                    a standard patent or plant breeder’s right that has been granted in Australia
                    or an equivalent intellectual property right granted in another country
                </td>
                <td style="width: 100px; text-align: center;">
                    50 Points
                </td>
                <td style="width: 480px;">
                    Standard Patent search in the name of the company. Plant Breeder’s Rights search in the name of the company.
                </td>
            </tr>
            <tr>
                <td style="width: 439px;">Within the last five years, the company has one or more enforceable rights on an innovation through an innovation patent or design right or an equivalent intellectual property right granted in another country
                </td>
                <td style="width: 100px; text-align: center;">
                    25 Points
                </td>
                <td style="width: 480px;">
                    Innovation Patent search in the name of the company. Design Rights search in the name of the company.
                </td>
            </tr>
            <tr>
                <td style="width: 439px;">The company has a written agreement to co-develop and commercialise an innovation with a research organization or a university
                </td>
                <td style="width: 100px; text-align: center;">
                    25 Points
                </td>
                <td style="width: 480px;">
                    Copy of signature page of co-development agreement with a registered research organization or university. Or copy of the agreement and published public announcement records.
                </td>
            </tr>
            </tbody>
        </table>


    </div>
<?php echo $footer; ?>