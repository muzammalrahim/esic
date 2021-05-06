<section class="content">
    <div class="row">
    <div class="col-md-12">
        <form action="<?= base_url().'admin/question/store';?>" method="post" class="form" enctype="multipart/form-data">
            <input type="hidden" id="hiddenQuestionID" value="">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Add Question</h3>
                    <div class="add-New-container">
                        <a href="<?= base_url().'admin/questions/index';?>" class="addNewBtn"><i class="fa fa-angle-double-left"></i> Listing</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <input type="hidden" id="hiddenListID" value="">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="questionTextBox">Question:</label>
                                <input type="text" name="question" id="questionTextBox" class="form-control" />
                            </div>
                            <div class="form-group clearfix">
                                <div class="checkbox">
                                    <label for="is_subQuestion">
                                        <input type="checkbox" id="is_subQuestion" name="is_subQuestion">
                                        Is Type SubQuestion
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="roleAssignedSelector">Assign To:</label>
                                <select class="form-control" name="roleAssigned[]" id="roleAssignedSelector" multiple="multiple">
                                    <?php
                                    $listingIDsArray = array();
                                    if(!empty($listings) and is_array($listings)){
                                        if(isset($questionListings) and !empty($questionListings)){
                                            $listingIDsArray = array_column($questionListings,'listing_id');
                                       }
                                        foreach ($listings as $listing){
                                            if(in_array($listing->id,$listingIDsArray)){
                                                $selected=true;
                                            }
                                            else{
                                                $selected=false;
                                            }
                                            echo '<option value="'.$listing->id.'" '. (($selected===true)?"selected='selected'":"") .' >'.$listing->listName.'</option>';
                                        }
                                   }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="select_year">Assign To Year:</label>
                                <select class="form-control" name="select_year" id="select_year">
                                    <option value="0">Select Year</option>
                                    <?php
                                    for($i = 2010 ; $i < 2050; $i++){
                                        ?>
                                        <option value ="<?= $i;?>" <?php if($i == date('Y')){ echo "Selected=selected";} ?>><?= $i; ?></option>
                                        <?php
                                    }
                                    ?>


                                </select>
                            </div>
                            <div class="form-group">
                                <label for="answerType">Answer Type:</label>
                                <select class="form-control" name="answerType" id="answerType">
                                    <option value="0">Select Type</option>
                                    <?php
                                    if(isset($answer_types) and is_array($answer_types)){
                                        foreach ($answer_types as $key=>$answer_type){
                                            echo '<option value="'.$answer_type->id.'" '.((intval($answer_type->id)=== intval($question->AnswerType))?"selected='selected'":"").'>'.$answer_type->name.'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="from-group" id="answerBox">
                            </div>
                        </div>
                    </div>
                </div> <!-- /.box-body -->
                <div class="box-footer">
<!--                    <div class="button-container">
                        <input type="submit" class="btn btn-primary" value="Save" />
                    </div>-->
                </div>
            </div>
        </form>
    </div>
    <!-- /.col -->
</div>
</section>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/questions.css">
<script type="text/javascript">
    $(function () {

        $('#roleAssignedSelector').select2({
            multiple:true
        });


        $('#roleAssignedSelector').on('change',function(){
            var assignedRoles = $(this).val();
            var qID = $('#hiddenQuestionID').val();
            if(!qID){
                return false;
            }

            //Assign the Roles.
            updateRoles(qID,assignedRoles);
        });

        //Create a Question First.
        $('#questionTextBox').on('change',function(){
            //Well Lets create or update the question.
            var question = $(this).val();
            var qID = $('#hiddenQuestionID').val();
            if(question.length < 3){
                Haider.notification('Please add a valid question first.', 'warning');
                return false;
            }

            var postData = {
                question: question
            }

            if(qID){
                postData.qID = qID;
            }

            var url = "<?=base_url()?>admin/question/store";

            $.ajax({
                url:url,
                data:postData,
                type:"POST",
                success:function (output) {
                    var data = output.trim().split('::');
                    if(data[0].split(' ').join('') === 'OK'){
                        if(data[3]){
                            var questionID = data[3];
                            $('#hiddenQuestionID').val(questionID);

                            //If there is subQuestion then call the function.
                            updateQuestionType();


                            //Assign the Roles if Exist.
                            var assignedRoles = $('#roleAssignedSelector').val();
                            if(assignedRoles && assignedRoles.length > 0){
                                updateRoles(questionID,assignedRoles);
                            }
                        }
                        //Check if Layout is previous selected before adding the question.
                        var answerType = $('#answerType').val();
                        if(answerType && data[3] && parseInt(answerType) > 0 ){
                            updateAnswerType(data[3],answerType);
                            fetchLayoutAnswers(answerType,$('#hiddenQuestionID').val());
                        }
                    }//end of If Statement
                    Haider.notification(data[1],data[2]);
                }
            })
        });

        //Question Type on change
        $('#is_subQuestion').on('change',updateQuestionType);

        //Call the Layout Function on Change of Type.
        $('#answerType').on('change',function(){
            //Select Template Based on Changed AnswerType.
            //Currently The Following Answer Types are given.
            // 1. Checkbox, 2. SelectBox, 3.Radio Buttons
            var selectedLayoutID = $(this).val();
            var qID = $('#hiddenQuestionID').val();

            //Lets update on the server as well.
            //Only if Question ID Exists.
            if(qID){
                updateAnswerType(qID,selectedLayoutID);
                //Call the Function
                fetchLayoutAnswers(selectedLayoutID,qID);
            }
        });
        $('#select_year').on('change',function(){
            //Select Template Based on Changed AnswerType.
            //Currently The Following Answer Types are given.
            // 1. Checkbox, 2. SelectBox, 3.Radio Buttons
            var year = $(this).val();
            var qID = $('#hiddenQuestionID').val();

            //Lets update on the server as well.
            //Only if Question ID Exists.
            if(qID){
                updateyears(qID,year);
             }
        });


    });

    //For the Radio
    $(function(){
        $('body').on('click','#addNewRadio',function(event){
            var obj = $(this);

            if(!event.detail || event.detail == 1){ //Preventing the Double Click Problem
                obj.attr('disabled','disabled');

                //Send the New Record to the Database through Ajax if valid record.
                var hiddenRadio = $(this).parents('form').find('#hiddenRadioID');
                var valueTextBox = $(this).parents('#newRadioRow').find('#value');
                var textTextBox = $(this).parents('#newRadioRow').find('#text');
                var value = valueTextBox.val();
                var text =textTextBox.val();
                var qID = $(this).parents('form').find('#hiddenQuestionID').val();
                var radioID = hiddenRadio.val();

                if(!value || !text){
                    Haider.notification('Text Boxes can not be left empty while creating a new radio option.','error','Required');
                    return false;
                }

                var postData = {
                    v:value,
                    t:text,
                    q:qID,
                    rID:radioID
                };

                $.ajax({
                    url:"<?=base_url()?>admin/questions/update_answer_radio",
                    data:postData,
                    type:'POST',
                    success:function (output) {
                        var data = output.trim().split('::');
                        if(data[0].split(' ').join('') === 'OK'){
                            //Add that Radio to the List As Well on front end.
                            var html = "<div class='radio'>" +
                                "<label for='"+radioID+"'>" +
                                "<input type='radio' name='radio_"+qID+"' id='"+radioID+"' value='"+value+"'>" +
                                text +
                                "</label>" +
                                "<span class='actions pull-right'>" +
                                "<a href='javascript:void(0);' class='btn btn-default subQuestionRadio'><i class='fa fa-plus'></i></a>" +
                                "<a href='javascript:void(0);' class='btn btn-default trashRadio'><i class='fa fa-trash text-red'></i></a>" +
                                "</span></div>";
                            //Add the New Added Record to the Page.
                            $('#radios').append(html);

                            //Update the Radio ID.
                            var radioIDArray = radioID.split('_');
                            radioIDArray[2] = parseInt(radioIDArray[2]) + 1;
                            //Join and assign it back to hidden field.
                            radioID = radioIDArray.join('_');
                            hiddenRadio.val(radioID);

                            //Finally Just Empty the Fields.
                            valueTextBox.val('');
                            textTextBox.val('');
                        }//End of If OK
                        Haider.notification(data[1],data[2]);
                        obj.removeAttr('disabled');
                    }
                });
            }//Need to Prevent the Damn Double Click paradox

        }); //When Clicked on Add New Radio..
        $('body').on('click','.trashRadio',function(){
            var obj = $(this);
            var questionID = $('#hiddenQuestionID').val();
            var radioID = $(this).parents('div.radio').find('input[type="radio"]').attr('id');
            var postData = {
                qID:questionID,
                rID:radioID
            };
            $.ajax({
                url: "<?=base_url()?>admin/questions/removeRadio",
                data: postData,
                type: "POST",
                success: function (output) {
                    var data = output.trim().split('::');
                    Haider.notification(data[1],data[2],data[3]);

                    if(data[0].split(' ').join('') === 'OK'){
                        obj.parents('.radio').remove();
                    }
                }
            });
        }); //End of Clicked Trash Icon on Radio.
    });
    //Work For Checkboxes
    $(function () {
        $('body').on('click','#addNewCheckbox',function(){

            var obj = $(this);

            if(!event.detail || event.detail == 1){ //Preventing the Double Click Problem
                obj.attr('disabled','disabled');

                //Send the New Record to the Database through Ajax if valid record.
                var hiddenCheckbox = obj.parents('form').find('#hiddenCheckboxID');
                var valueTextBox = obj.parents('#newCheckboxRow').find('#value');
                var textTextBox = obj.parents('#newCheckboxRow').find('#text');
                var value = valueTextBox.val();
                var text =textTextBox.val();
                var qID = obj.parents('form').find('#hiddenQuestionID').val();
                var checkBoxID = hiddenCheckbox.val();

                if(!value || !text){
                    Haider.notification('Text Boxes can not be left empty while creating a new radio option.','error','Required');
                    return false;
                }

                var postData = {
                    n:value,
                    t:text,
                    q:qID,
                    cID:checkBoxID
                };
                $.ajax({
                    url:"<?=base_url()?>admin/questions/update_answer_checkbox",
                    data:postData,
                    type:'POST',
                    success:function (output) {
                        var data = output.trim().split('::');
                        if(data[0].split(' ').join('') === 'OK'){
                            //Add that Radio to the List As Well on front end.
                            var html = "<div class='checkbox'>" +
                                "<label for='"+checkBoxID+"'>" +
                                "<input type='checkbox' name='checkbox_"+qID+"' id='"+checkBoxID+"' value='"+value+"'>" +
                                text +
                                "</label>" +
                                "<span class='actions pull-right'>" +
                                "<a href='javascript:void(0);' class='btn btn-default subQuestionCheckbox'><i class='fa fa-plus'></i></a>" +
                                "<a href='javascript:void(0);' class='btn btn-default trashCheckbox'><i class='fa fa-trash text-red'></i></a>" +
                                "</span></div>";
                            //Add the New Added Record to the Page.
                            $('#CheckBoxes').append(html);

                            //Update the Radio ID.
                            var radioIDArray = checkBoxID.split('_');
                            radioIDArray[2] = parseInt(radioIDArray[2]) + 1;
                            //Join and assign it back to hidden field.
                            checkBoxID = radioIDArray.join('_');
                            hiddenCheckbox.val(checkBoxID);

                            //Finally Just Empty the Fields.
                            valueTextBox.val('');
                            textTextBox.val('');
                        }//End of If OK
                        Haider.notification(data[1],data[2]);
                        obj.removeAttr('disabled');
                    }
                });
            }//Need to Prevent the Damn Double Click paradox
        }); //End of Add New Checkbox
        $('body').on('click','.trashCheckbox',function(){
            console.log('trash icon clicked');
            var obj = $(this);
            var questionID = $('#hiddenQuestionID').val();
            var checkboxID = $(this).parents('div.checkbox').find('input[type="checkbox"]').attr('id');
            var postData = {
                qID:questionID,
                cID:checkboxID
            };
            $.ajax({
                url: "<?=base_url()?>admin/questions/removeCheckbox",
                data: postData,
                type: "POST",
                success: function (output) {
                    var data = output.trim().split('::');
                    Haider.notification(data[1],data[2],data[3]);

                    if(data[0].split(' ').join('') === 'OK'){
                        obj.parents('.checkbox').remove();
                    }
                }
            });
        });
    });
    //For Select Box
    $(function(){
        $('body').on('change','#selectBoxItems',function () {
            var itemsList = $(this).val();
            var questionID = $(this).parents('form').find('#hiddenQuestionID').val();

            if(itemsList && itemsList.length > 0){

                var postData={
                    items:itemsList,
                    qID:questionID,
                    type:'list'
                }

                $.ajax({
                    url:"<?=base_url()?>admin/questions/updateSelect",
                    data:postData,
                    type:"POST",
                    success:function (output) {
                        var data = output.trim().split('::');
                        Haider.notification(data[1],data[2]);
                    }
                });
            }
        });
        $('body').on('change','#selectBoxText',function(){
            var selectBoxText = $(this).val();
            var questionID = $(this).parents('form').find('#hiddenQuestionID').val();

            if(selectBoxText && selectBoxText.length > 0){
                var postData={
                    'qID'   :questionID,
                    'text'  : selectBoxText,
                    'type'  :'text'
                }
                $.ajax({
                    url:"<?=base_url()?>admin/questions/updateSelect",
                    data:postData,
                    type:"POST",
                    success:function(output){
                        console.log(output);
                    }
                });
            }
        });
        $('body').on('change','#is_multi',function () {
            var isMulti = $(this);
            var questionID = $(this).parents('form').find('#hiddenQuestionID').val();

            if(!questionID || !(questionID.length > 0)){
                return false;
            }

            var postData = {
                qID: questionID,
                type: 'checkbox'
            }

            if(isMulti.is(':checked')){
                postData.isMulti = 'Yes';
            }else{
                postData.isMulti = 'No';
            }

            $.ajax({
                url: "<?=base_url()?>admin/questions/updateSelect",
                data:postData,
                type:"POST",
                success:function (output) {
                    console.log(output);
                    var data = output.trim().split('::');
                    //Notifications..
                    Haider.notification(data[1],data[2]);
                }
            })

        });
        $('body').on('change','#is_dynamic',function(){
            var isDynamic = $(this);
            var questionID = $('#hiddenQuestionID').val();

            if(!questionID || !(questionID.length > 0)){
                return false;
            }

            var postData = {
                qID: questionID,
                type: 'checkbox'
            }

            if(isDynamic.is(':checked')){
                postData.isDynamic = 'Yes';
            }else{
                postData.isDynamic = 'No';
            }

            $.ajax({
                url: "<?=base_url()?>admin/questions/updateSelect",
                data:postData,
                type:"POST",
                success:function (output) {
                    var data = output.trim().split('::');
                    //Notifications..
                    Haider.notification(data[1],data[2]);
                }
            })

        });
    });
        //Work for TextBoxes
        $(function () {
            $('body').on('click','#addMoreTextBox', function () {
                var clickedButton = $(this);
                var questionID = $('#hiddenQuestionID').val();
                var totalTextBoxes = clickedButton.parents('div#answerBox').find('div.textBoxDiv').length; //Was Ruining my day. cuz of wrong value :(

                var postData = {
                    qID:questionID,
                    total:totalTextBoxes
                };
                var trashHTMLbutton = '<a style="margin-top: 25px;" href="javascript:void(0)" class="btn btn-danger btn-block trashTextBox"><i class="fa fa-trash"></i></a>';
                $.ajax({
                    url:"<?=base_url()?>admin/question/getTextboxTemplate",
                    data:postData,
                    type:'POST',
                    success:function (output) {
                        var outputLength = output.trim().length;
                        if(outputLength>0){
                            clickedButton.hide();
                            clickedButton.parent().append(trashHTMLbutton);
                            $('#answerBox').append(output);
                        }else{
                            console.log(output);
                        }
                    }
                }); //End of Ajax
            }); // End of OnClick

            $('body').on('click','.trashTextBox',function (output) {
                var clickedButton = $(this);
                var divID = clickedButton.parents('div.textBoxDiv').attr('data-id');
                if(divID && divID.length>0){
                    var postData = {
                        divID:divID
                    }
                    $.ajax({
                        url:"<?=base_url()?>admin/question/trashTextBox",
                        data:postData,
                        type:"POST",
                        success:function (output) {
                            var data = output.trim().split('::');
                            console.log(data[0]);
                            if(data[0].split(' ').join('') === 'OK'){ //If Record Removed from the DB, Then Just update the screen as well.
//                            var totalCurrentDivs = clickedButton.parents('#answerBox').find('div.textBoxDiv').length;

                                //Remove the CurrentDiv.
//                            clickedButton.parents('.textBoxDiv').remove();

                                //Unfortunately we also need to update the key or divID key.
                                //For that just refresh the page for now. Will make it dynamic later if i get some more time.
                                setTimeout(location.reload.bind(location), 500);
                            }
                            Haider.notification(data[1],data[2]);
                        }//End of a success function
                    }); //End of an ajax call
                }// End of an If Statement.


            });

            $('body').on('change','.tBox',function(){
                var textBoxID = $(this).attr('id');
                var divID = $(this).parents('.textBoxDiv').attr('data-id');
                var textBoxType = textBoxID.trim().split('_');
                var changedValue = $(this).val();
                var postData = {
                    'textBoxID': textBoxID,
                    'dID': divID,
                    'value' : changedValue,
                    'type' : textBoxType[0]
                };

                $.ajax({
                    url:"<?=base_url()?>admin/question/updateTextBox",
                    data:postData,
                    type:"POST",
                    success:function(output){
                        var data = output.trim().split('::');
                        Haider.notification(data[1],data[2]);
                    }

                });
            });
        });


    function updateQuestionType() {
        //Lets check if we have the type checkbox or not set.
        var checkbox;
        if($(this).attr('type') === 'checkbox'){
            checkbox = $(this);
        }else{
            checkbox = $('#is_subQuestion');
        }
        var qID = $('#hiddenQuestionID').val();

        if(qID){
            var postData = {
                qID:qID
            }
            if(checkbox.is(':checked')){
                postData.isSub = '1';
            }else{
                postData.isSub = '0';
            }

            //Call ajax
            $.ajax({
                url:"<?=base_url()?>admin/question/updateQuestionType",
                data:postData,
                type:"POST",
                success:function(output){
                    var data = output.trim().split("::");
                    Haider.notification(data[1],data[2]);
                }
            })
        }//End of If Question ID exists.

    }//End of Function.

    //Work For SubQuestions
    $(function(){
        $('#subQuestionType').on('change',function(){
            var selectedQuestionTypeID = $(this).val();
            var qID = $('#hiddenQuestionID').val();

            fetchSubQuestionLayout(selectedQuestionTypeID,qID);
        });

        $('#subQuestionRadioModal').on('shown.bs.modal',function(e){
            var PressedButton = e.relatedTarget;
            var radioID = $(PressedButton).parents('div.radio').find('label').attr('for');
            //Assign the Radio ID to the Modal As Well.
            $('#hiddenItemID').val(radioID);
        });
        $('#saveSubQuestion').on('click',function(){
            var questionID  = $('#hiddenQuestionID').val();
            var answerType  = $('#answerType').val();
            var itemID      = $('#hiddenItemID').val();

            var postData = {
                qID:questionID,
                aType:answerType,
                itemID: itemID
            };
            if($(this).parents('form').find('#pre_populatedListingTypes').length > 0){
                //Means Pre-populated Listing has been added.
                postData.prePopulated = $('#pre_populatedListingTypes').val();
                if($('#pre_populatedListingTypesMulti').prop('checked') === true){
                    postData.prePopulatedMulti = true;
                }else{
                    postData.prePopulatedMulti = false;
                }

                if($('#pre_populatedListingTypesCanCustomEntry').prop('checked') === true){
                    postData.prePopulatedCustomEntry = true;
                }else{
                    postData.prePopulatedCustomEntry = false;
                }

            }else{
                postData.subQuestionID = $('#questionSelector').val()
            }

            $.ajax({
                url:"<?=base_url()?>admin/question/updateChild",
                data:postData,
                type:"POST",
                success:function (output) {
                    var data = output.trim().split('::');
                    if(data[0].split(' ').join('') === 'OK'){
                        //If Result is OK. Just Update the Layout.
                        //Also Just Close this dialog box.
                        $('#subQuestionRadioModal').modal('hide');
                        location.reload();
                    }
                    Haider.notification(data[1],data[2]);
                }
            });
        });

        $('body').on('click','.trashSubQuestion',function(){
            //First We Need to Check what is the Type of this.
            var pressedButton = $(this);
            var questionID = $('#hiddenQuestionID').val();
            var subQuestion = $(this).parents('.subQuestion');
            var subID = subQuestion.attr('data-id');
            //SubQuestionType
            var span = subQuestion.find('span strong').text();
            var questionType = span.trim().split(' :');
            questionType = questionType[0];

            //Need to know the type as well.
            var answerType = $('#answerType option:selected').text();

            var postData ={
                qID: questionID,
                subID: subID,
                questionType: questionType,
                action:'remove'
//                itemID:
            };
            switch(answerType){
                case 'RadioButtons':
                    var radioDiv = $(this).parents('.radio');
                    var radioID = radioDiv.find('label').attr('for');
                    postData.itemID = radioID;
                    break;
                case 'CheckBoxes':
                    break;
                case 'SelectBox':
                    break;
                case 'TextBox':
                    break;
            }

            console.log(answerType);

            console.log(postData);

            $.ajax({
                url:"<?=base_url()?>admin/question/trashSubQuestion",
                data:postData,
                type:"POST",
                success:function(output){
                    var data = output.trim().split('::');
                    if(data[0].split(' ').join('') === 'OK'){
                        //Remove the SubQuestionBox.
                        pressedButton.parents('.subQuestion').remove();
                    }
                    //Display output on notification.
                    Haider.notification(data[1],data[2]);
                }
            })
        });
    });
    function fetchLayoutAnswers(selectedLayoutID,qID) {
        var url = '<?=base_url()?>admin/questions/layout/'+selectedLayoutID;
        var data = {
            'layout' : selectedLayoutID,
            'qID': qID
        };


        //Send an ajax request.
        $.ajax({
            url:url,
            data:data,
            type:'POST',
            success:function(output){
                $('#answerBox').html(output);
                $('#answerBox').find('.actions').remove();
            }
        });
    }
    function updateRoles(qID,assignedRoles){

        var postData =
            {
                'qID'   : qID,
                'roles' : assignedRoles
            }

        $.ajax({
            url:"<?=base_url()?>admin/question/updateRoles",
            type:"POST",
            data:postData,
            success:function (output) {
                var data = output.trim().split('::');
                //Update the Notification.
                Haider.notification(data[1],data[2]);
            }
        });
    }
    function updateAnswerType(questionID,answerType) {
        var postData = {
            qID  : questionID,
            type :answerType
        }
        $.ajax({
            url:"<?=base_url()?>admin/question/updateAnswerType",
            type:"POST",
            data:postData,
            success:function (output) {
                var data = output.trim().split("::");
                Haider.notification(data[1],data[2]);
            }
        })
    }
    function fetchSubQuestionLayout(selectedLayoutID, qID) {
        var url = '<?=base_url()?>admin/questions/SubQuestionLayout/'+selectedLayoutID;
        var data = {
            'layout' : selectedLayoutID,
            'qID': qID
        };


        //Send an ajax request.
        $.ajax({
            url:url,
            data:data,
            type:'POST',
            success:function(output){
                $('.secondarySubQuestionDiv').html(output);
            }
        });
    }
    function updateyears(qID,year){

        var postData =
            {
                'qID'   : qID,
                'year' : year
            }

        $.ajax({
            url:"<?=base_url()?>admin/question/updateYears",
            type:"POST",
            data:postData,
            success:function (output) {
                var data = output.trim().split('::');
                //Update the Notification.
                Haider.notification(data[1],data[2]);
            }
        });
    }
</script>
