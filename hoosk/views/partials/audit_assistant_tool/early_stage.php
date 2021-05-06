<div class="row questionwrap">

    <p style="padding-top: 25px;"><strong><span style="font-size: 24px; color: #656565;"
                                                data-mce-style="font-size: 24px; color: #656565;">Early Stage Test</span></strong>&nbsp;&nbsp;
    </p>

    <div class="q1 earlystage  Questions  " data-id="1">
        <h5>Were any of the company's equity interests listed on a stock exchange at the test time?</h5>
        <label class="containers">Yes
            <input type="radio" name="q1" value="1" class="early">
            <span class="checkmark"></span>
        </label>
        <label class="containers">No
            <input type="radio" name="q1" value="0">
            <span class="checkmark"></span>
        </label>
    </div>


    <div class="q2  Questions  " data-id="2">
        <!--   its a question 2.1  wiill be visible when q2 fail  -->
        <h5>Was the company early stage at the time of investment (taken from incorporation date and the date of investment)</h5>
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
        <h5>Total assessable income of $200,000</h5>
        <label class="containers">Yes
            <input type="radio" name="q3" value="1">
            <span class="checkmark"></span>
        </label>
        <label class="containers">No
            <input type="radio" name="q3" value="0">
            <span class="checkmark"></span>
        </label>
    </div>

    <div class="q3 earlystage  Questions  " data-id="<?= $question[3]->id; ?>">
        <h5>Show that the total tax expenses incurred by the company and its 100% subsidiaries was less than $1,000,000</h5>
        <label class="containers">Yes
            <input type="radio" name="q3" value="1">
            <span class="checkmark"></span>
        </label>
        <label class="containers">No
            <input type="radio" name="q3" value="0">
            <span class="checkmark"></span>
        </label>
    </div>

    <div class="q3 earlystage  Questions  " data-id="<?= $question[3]->id; ?>">
        <h5>The incentives may not apply to sophisticated structured ventures. Show that the company was undertaking innovation activities solely on its own, or that the ownership structure did not defeat the purpose of ESIC concessions.</h5>
        <label class="containers">Yes
            <input type="radio" name="q3" value="1">
            <span class="checkmark"></span>
        </label>
        <label class="containers">No
            <input type="radio" name="q3" value="0">
            <span class="checkmark"></span>
        </label>
    </div>
</div>