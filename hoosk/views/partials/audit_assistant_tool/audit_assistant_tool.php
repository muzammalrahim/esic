<div class="row questionwrap">

    <p style="padding-top: 25px;"><strong><span style="font-size: 24px; color: #656565;"
                                                data-mce-style="font-size: 24px; color: #656565;">Audit Assistant Tool</span></strong>&nbsp;&nbsp;
    </p>

    <div class="q1 earlystage  Questions  " data-id="1">
        <h5>The company is/was early stage at the time of investment in new shares?
            <strong>*</strong></h5>
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
        <h5>
            The company passed on the Innovation Test (Points)? <strong>*</strong></h5>
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
        <h5>
            The company passed on the ESIC Principals Test?<strong>*</strong></h5>
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