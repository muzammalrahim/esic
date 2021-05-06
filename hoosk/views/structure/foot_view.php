<link rel="stylesheet" href="<?=base_url('assets/css/questions.css')?>">
<style type="text/css">
    div.checkbox{
        margin:0;
        padding:0;
        float: none;
    }
</style>
<script type="text/javascript">
    $(function () {
        $(document).on('click','.question-edit',function(){
           $(this).parents('.question-post').find('.edit-question').show();
        });

        $('body').on('click','.add_customInPrePopulated',function(){
            var form = $(this).parents('form');
            var modalID = form.parents('.modal').attr('id');
            var tempID = modalID.split('Modal');
            var tempID = tempID[0];
            var selectBox = $('#'+tempID+'_DivID').parent().find('select');
            var postData = form.serializeArray();
            postData.push({name:'modalID',value:modalID});
            $.ajax({
                url:"<?=base_url() . $this->ControllerName; ?>/storeInPrePopulated",
                type:"POST",
                data:postData,
                success:function(output){
                    try{
                        var data = output.trim().split('::');
                        if(data[0].split(' ').join('') == 'OK'){
                            console.log(selectBox);
                            selectBox.append("<option value='"+data[3]+"' selected>"+data[4]+"</option>");
                            selectBox.trigger('change');
/*                            var newState = new Option(data[4], data[4], true, true);
                            // Append it to the select
                            selectBox.append(newState).trigger('change');*/
                            form.parents('.modal').modal('hide');
                        }
                        Haider.notification(data[1],data[2]);
                    }catch(ex){
                        console.log(ex);
                    }
                }
            })
        });

        $(document).on('change','div.question-post input[type="radio"], div.question-post input[type="checkbox"], div.question-post input[type="text"], div.question-post select', function(){
            var changedElement = $(this);
            var userID = "<?=$this->uri->segment(4);?>";

            //Before Moving to Further, First need to check if this is the a sub-question change or the main question Change.
            var subQuestions = changedElement.parents('.subQuestionListingDiv').length;
            if(subQuestions>0){
                var subSelectedQuestionID = changedElement.parents('.subQuestion').attr('data-id');
                var subSelectedParentQuestionID = changedElement.parents('.question-post').attr('data-id');
                subSelectedParentQuestionID = subSelectedParentQuestionID.split('-');
                var postData = {
                    qID:subSelectedQuestionID,
                    parentQID:subSelectedParentQuestionID[1],
                    userID:userID,
                    listingID: '<?= $this->QuestionListingID;?>'
                }
                if($(this).prop('type') === 'radio'){
                    var selectedRadio = changedElement.val();
                    postData.selectedRadioValue = selectedRadio;
                    postData.type='radio';
                    postData.radioID = $(this).attr('id');
                }
                else if($(this).prop('type') === 'checkbox'){
                    if($(this).is(':checked')){
                        postData.hasCheck = 'Yes';
                    }else{
                        postData.hasCheck = 'No';
                    };
                    postData.type = 'checkbox';
                    postData.checkBoxID = $(this).attr('id');
                    postData.checkBoxValue = $(this).attr('name');
                }
                else if($(this).prop('tagName') === 'SELECT'){
                    if($(this).parents('.subQuestion').hasClass('prePopulated')){
                        var selectedQuestionID = $(this).parents('div.question-post').find('.question-edit').attr('data-question-id');
                        postData.selectedItemID = $(this).val();
                        postData.MainQuestionID = selectedQuestionID;
                        $.ajax({
                            url:"<?=base_url()?>admin/question/updatePrePopulatedUserAnswer",
                            type:"POST",
                            data:postData,
                            success:function(output){
                                console.log(output);
                                var data = output.trim().split('::');
                                Haider.notification(data[1],data[2]);
                            }
                        });
                    }else{
                        var selectedSelectValue = $(this).val();
                        postData.type='select';
                        postData.selectedValue = selectedSelectValue;
                    }
                }else if($(this).prop('type') === 'text'){
                    //Lets Update All the fields at once.
                    var textBoxes = [];
                    var inputTextBoxes = $(this).parents('.subQuestion').find('input[type="text"]');
                    $.each(inputTextBoxes,function ($key, $textBox) {
                        var textBox = {};
                        textBox.changedValue = $($textBox).val();
                        textBox.textBoxID = $($textBox).attr('id');
                        textBoxes.push(textBox);
                    });
                    postData.type='text';
                    postData.textBoxes = JSON.stringify(textBoxes);
                }
                //Finally Update the Answer.
                updateUserAnswer(postData);
                return false;
            }
            var selectedQuestionID = $(this).parents('div.question-post').find('.question-edit').attr('data-question-id');
            var type = '';
            var postData = {
                qID:selectedQuestionID,
                userID:userID,
                listingID: '<?= $this->QuestionListingID;?>'
            };
            if($(this).parents('div.question-post').find('.radio').length > 0){
                var selectedRadio = changedElement.val();
                postData.selectedRadioValue = selectedRadio;
                postData.type='radio';
                postData.radioID = $(this).attr('id');
            }else if ($(this).parents('div.question-post').find('.checkbox').length > 0){
                if($(this).is(':checked')){
                    postData.hasCheck = 'Yes';
                }else{
                    //console.log('checkbox check has been Removed');
                    postData.hasCheck = 'No';
                };
                postData.type = 'checkbox';
                postData.checkBoxID = $(this).attr('id');
                postData.checkBoxValue = $(this).attr('name');
            }else if($(this).prop('tagName') === 'SELECT'){
                var selectedSelectValue = $(this).val();
                postData.type='select';
                postData.selectedValue = selectedSelectValue;
            }
            else if($(this).prop('type') === 'text'){
                //Lets Update All the fields at once.
                var textBoxes = [];
                var inputTextBoxes = $(this).parents('.edit-question').find('input[type="text"]');
                $.each(inputTextBoxes,function ($key, $textBox) {
                    var textBox = {};
                    textBox.changedValue = $($textBox).val();
                    textBox.textBoxID = $($textBox).attr('id');
                    textBoxes.push(textBox);
                });
                postData.type='text';
                postData.textBoxes = JSON.stringify(textBoxes);
            }

            $.ajax({
                url:"<?=base_url();?>admin/question/updateUserAnswer",
                data:postData,
                type:"POST",
                success:function(output){
                    var data=output.trim().split('::');
                    if(data[0].split(' ').join('') === 'OK'){
                        Haider.notification(data[1],data[2]);
                    }else if(data[0].split(' ').join('') === 'FAIL'){
                        Haider.notification(data[1],data[2]);
                    }
                }
            });

        });
    });
    function updateUserAnswer(postData){
        $.ajax({
            url:"<?=base_url();?>admin/question/updateUserAnswer",
            data:postData,
            type:"POST",
            success:function(output){
                var data=output.trim().split('::');
                if(data[0].split(' ').join('') === 'OK'){
                    Haider.notification(data[1],data[2]);
                }else if(data[0].split(' ').join('') === 'FAIL'){
                    Haider.notification(data[1],data[2]);
                }
            }
        });
    }
</script>