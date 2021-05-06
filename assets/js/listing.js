jQuery(document).ready(function($) {
    if($("select.select2-active").length > 0){
        $("select").select2();
    }
    if($(".date_picker").length > 0){
        $('.date_picker').datepicker({
             //format: 'yyyy-mm-dd'
             format: 'dd-mm-yyyy'
        });
    }
    if($("select.customSelect2").length > 0){
        $('.customSelect2').select2();
    }
    if($("select.isDynamic").length > 0){
        $('.isDynamic').select2({
            tags:true
        });
    }
    if($("js-example-basic-multiple").length > 0){
        $(".js-example-basic-multiple").select2();
    }
    if($(".action-button-sticky-bar").length > 0){
        //console.log('action-button-sticky-bar');
        var wrap = $(".action-button-sticky-bar");
         $(window).on("scroll", function() {
            //var fromTop = $("body").scrollTop();
             var fromTop = document.documentElement.scrollTop || document.body.scrollTop;
            $('.action-button-sticky-bar').toggleClass("show-stickybar", (fromTop > 200));
         });  
}
    
});
$(function(){
	if($("textarea.tinymce-active").length > 0){
	  	tinymce.init({
			  selector: 'textarea',
			  height : 100,
              max_height: 200,
              theme_advanced_resizing: false,
              theme_advanced_resizing_use_cookie : false,
			  menubar: false,
			  browser_spellcheck : true,
			  contextmenu: false,
			  spellchecker_rpc_url: base_url+'assets/tinymce/js/tinymce/plugins/spellchecker/spellchecker.php',
			  plugins: [
			    ' spellchecker advlist autolink lists link image charmap print preview anchor code',
			    'searchreplace visualblocks code fullscreen',
			    'insertdatetime media jbimages table contextmenu paste code'
			  ],
			  toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | jbimages | media | code |',
            fontsize_formats: "8px 10px 12px 14px 18px 20px 24px 24px 28px 30px 36px 40px",
            content_css: '//www.tinymce.com/css/codepen.min.css',
			  relative_urls: false
		});
	}

	//Functions for Approving the Trash through Modal
	//When Approval Modal Shows Up
	$(".approval-modal").on("shown.bs.modal", function (e) {
	    var button  = $(e.relatedTarget); // Button that triggered the modal
        var ButtonParent = button.parents("tr");
        if(ButtonParent.hasClass('row')){
            ButtonParent = ButtonParent;
        }else if(ButtonParent.hasClass('child')){
            ButtonParent = button.parents("tr").prev("tr");
        }
	    var ID      = ButtonParent.attr("data-id");
	    var Name    = ButtonParent.find('td').eq(1).text();
	    var modal   = $(this);
	    var Message = 'Are you sure you want to trash record of: <strong>'+Name+'</strong>';
	    modal.find("input#hiddenUserID").val(ID);
	    modal.find(".modal-body").find('p').html(Message);
	    modal.find('.modal-header').find('h4').html('Trash <strong>'+Name+'</strong>');
	});
    $(".approval-modal-delete").on("shown.bs.modal", function (e) { //added by Hamid raza
         var button  = $(e.relatedTarget); // Button that triggered the modal
        var ButtonParent = button.parents("tr");
        if(ButtonParent.hasClass('row')){
            ButtonParent = ButtonParent;
        }else if(ButtonParent.hasClass('child')){
            ButtonParent = button.parents("tr").prev("tr");
        }
        var ID      = ButtonParent.attr("data-id");
        var Name    = ButtonParent.find('td').eq(1).text();
        var modal   = $(this);
        var Message = 'Are you sure you want to trash record of: <strong>'+Name+'</strong>';
        modal.find("input#hiddenUserID").val(ID);
        modal.find(".modal-body").find('p').html(Message);
        modal.find('.modal-header').find('h4').html('Trash <strong>'+Name+'</strong>');
    });
    //When Yes has been Selected on Approval Modal, Just Trash the Selected Data.
    $("#yesApprove").on("click", function () {
        var hiddenModalID = $(this).parents(".modal-content").find("#hiddenUserID").val();
        var postData = {id: hiddenModalID, value: "trash"};
        $.ajax({
            url: baseUrl + "admin/"+ControllerRouteManage+"/trash",
            data: postData,
            type: "POST",
            success: function (output) {
                var data = output.trim().split("::");
                if (data[0].split(' ').join('') == 'OK') {
                    $(".approval-modal").modal('hide');
                    $(".approval-modal-delete").modal('hide');
                    //oTable.fnDraw();
                    var mytable = $('#'+ControllerClassName+'List').dataTable();
                    mytable.fnDraw(false);
                }
                if(data[3]){
                    Haider.notification(data[1],data[2],data[3]);
                }else{
                    Haider.notification(data[1],data[2]);
                }
            }
        });
    }); //End of Yes Approve Function

    //When No has been Selected on Approval Modal, Just Un-Trash the Selected Data.
    $("#nodelete").on("click", function () {
        var hiddenModalUserID = $(this).parents(".modal-content").find("#hiddenUserID").val();
        var postData = {id: hiddenModalUserID, value: "untrash"};
        $.ajax({
            url: baseUrl + "admin/"+ControllerRouteManage+"/trash",
            data: postData,
            type: "POST",
            success: function (output) {
                var data = output.trim().split("::");
                if (data[0].split(' ').join('') == 'OK') {
                    $('.approval-modal').modal('hide');
                    $(".approval-modal-delete").modal('hide');
                    //oTable.fnDraw();
                    var mytable = $('#'+ControllerClassName+'List').dataTable();
                    mytable.fnDraw(false);
                }

                if(data[3]){
                    Haider.notification(data[1],data[2],data[3]);
                }else{
                    Haider.notification(data[1],data[2]);
                }
            }
        });
    });
    $("#nodeleteit").on("click", function () {
        var hiddenModalUserID = $(this).parents(".modal-content").find("#hiddenUserID").val();
        var postData = {id: hiddenModalUserID, value: "untrash"};
        $.ajax({
            url: baseUrl + "admin/"+ControllerRouteManage+"/trash",
            data: postData,
            type: "POST",
            success: function (output) {
                var data = output.trim().split("::");
                if (data[0].split(' ').join('') == 'OK') {
                    $('.approval-modal').modal('hide');
                    $(".approval-modal-delete").modal('hide');
                    //oTable.fnDraw();
                    var mytable = $('#'+ControllerClassName+'List').dataTable();
                    mytable.fnDraw(false);
                }

                if(data[3]){
                    Haider.notification(data[1],data[2],data[3]);
                }else{
                    Haider.notification(data[1],data[2]);
                }
            }
        });
    });
    $("#permanentDelete").on("click", function () {
        var hiddenModalUserID = $(this).parents(".modal-content").find("#hiddenUserID").val();
        var postData = {id: hiddenModalUserID, value: "delete"};
        $.ajax({
            url: baseUrl + "admin/"+ControllerRouteManage+"/delete",
            data: postData,
            type: "POST",
            success: function (output) {
                var data = output.trim().split("::");
                if (data[0].split(' ').join('') == 'OK') {
                    $('.approval-modal').modal('hide');
                    $(".approval-modal-delete").modal('hide'); // use for esic
                    var mytable = $('#'+ControllerClassName+'List').dataTable();
                    mytable.fnDraw(false);
                }

                if(data[3]){
                    Haider.notification(data[1],data[2],data[3]);
                }else{
                    Haider.notification(data[1],data[2]);
                }
            }
        });
    });

/*--------LOGO JOB---------*/
//    When Modal is Opened
    $(".logo-edit-modal").on("shown.bs.modal", function (e) {
        var button  = $(e.relatedTarget); // Button that triggered the modal
        var ButtonParent = button.parents("tr");
        if(ButtonParent.hasClass('row')){
            ButtonParent = ButtonParent;
        }else if(ButtonParent.hasClass('child')){
            ButtonParent = button.parents("tr").prev("tr");
        }
        var ID      = ButtonParent.attr("data-id");
        var name    = ButtonParent.find('td').eq(1).text();
        var src     = button.attr('src');
        var modal   = $(this);
        modal.find("input#hiddenUserID").val(ID);
        modal.find("img#logo-show").attr('src', src);
        modal.find(".modal-body").find('p > strong').text(' "' + name + '"');
    });

    $(".image-edit-modal").on("shown.bs.modal", function (e) {
        var button  = $(e.relatedTarget);
        var ID      = $("#hiddenListID").val();
        var type    = button.attr('data-type');
        var src     = button.attr('src');
        var modal   = $(this);
        modal.find("input#hiddenID").val(ID);
        modal.find("img#image-show").attr('src', src);
        modal.find(".modal-header").find('h4 > span').text(' "' + type + '"');
        modal.find(".modal-footer").find('#updateImage').attr('data-type',type);
    });

    $(".publish-modal").on("shown.bs.modal", function (e) {
        console.log('publish-modal Here');
        var button = $(e.relatedTarget); // Button that triggered the modal
        var ButtonParent = button.parents("tr");
        if(ButtonParent.hasClass('row')){
            ButtonParent = ButtonParent;
        }else if(ButtonParent.hasClass('child')){
            ButtonParent = button.parents("tr").prev("tr");
        }
        var ID = ButtonParent.attr("data-id");
        var esicName = ButtonParent.find(".esicName").text();
        var currentPublishStatusID = ButtonParent.find(".Publish-Status").attr("data-publishstatusid");
        console.log(currentPublishStatusID);
        var modal = $(this);
        modal.find("input#hiddenUserID").val(ID);
        var publishText = 'Publish';
        if(currentPublishStatusID == 1){
            publishText = 'UnPublish';
        }
        $("#publishStatusID").val(currentPublishStatusID);
        $("#EsicNameTextBox").text(esicName);
        $("#publishStatusTextBox").text(publishText);
    });

//    When New Logo is Selected
    $("#update-logo-file").change(function(){
        readURL(this,'#logo-show');
    });
    $("#update-image-file").change(function(){
        readURL(this,'#image-show');
    });
    $("#product-file").change(function(){
        readURL(this,'#product-show');
    });
    $("#banner-file").change(function(){
        readURL(this,'#banner-show');
    });
    $("body #Logo-file").change(function(){
        console.log(this);
        readURL(this,'body #Logo-show');
    });
    $("#update-logo-file").change(function(){
        readURL(this,'#logo-show');
    });

    //Finally Update the logo when Update btn is pressed
    $("#updateLogo").on("click", function () {
        var hiddenModalID = $(this).parents(".modal-content").find("#hiddenUserID").val();
        var input = $(this).parents(".modal-content").find("#update-logo-file")[0];
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var formData = new FormData();
                formData.append('logo', input.files[0]);
                formData.append('id', hiddenModalID);
                $.ajax({
                    crossOrigin: true,
                    type: 'POST',
                    url: baseUrl + "admin/"+ControllerRouteManage+"/updateLogo",
                    data: formData,
                    processData: false,
                    contentType: false
                }).done(function (response) {
                    var data = response.trim().split("::");
                    if (data[0].split(' ').join('') == 'OK') {
                        $(".logo-edit-modal").modal('hide');
                        oTable.fnDraw();
                    }
                    if(data[3]){
                        Haider.notification(data[1],data[2],data[3]);
                    }else{
                        Haider.notification(data[1],data[2]);
                    }
                });

            };
            reader.readAsDataURL(input.files[0]);
        }
    });


    $("#updateImage").on("click", function () {
        var hiddenModalID   = $(this).parents(".modal-content").find("#hiddenID").val();
        var hiddenTypeImage = $(this).parents(".modal-content").find("#hiddenTypeImage").val();
        var input = $(this).parents(".modal-content").find("#update-image-file")[0];
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var formData = new FormData();
                formData.append('image', input.files[0]);
                formData.append('id', hiddenModalID);
                formData.append('type', hiddenTypeImage);
                $.ajax({
                    crossOrigin: true,
                    type: 'POST',
                    url: baseUrl + "admin/"+ControllerRouteManage+"/updateImage",
                    data: formData,
                    processData: false,
                    contentType: false
                }).done(function (response) {
                    var data = response.trim().split("::");
                    if (data[0].split(' ').join('') == 'OK') {
                        $(".image-edit-modal").modal('hide');
                        oTable.fnDraw();
                    }
                    if(data[3]){
                        Haider.notification(data[1],data[2],data[3]);
                    }else{
                        Haider.notification(data[1],data[2]);
                    }
                });

            };
            reader.readAsDataURL(input.files[0]);
        }
    });


    $("#yesPublish").on("click", function () {
        var hiddenModalUserID   = $(this).parents(".modal-content").find("#hiddenUserID").val();
        var publishStatusID     = $(this).parents(".modal-content").find("#publishStatusID").val();
        if (hiddenModalUserID == '') {
            hiddenModalUserID = $(this).attr('data-id');
        }
         var actionToPerform = "publish";
        if(publishStatusID == 1){
            actionToPerform = "unpublish";
        }
        var postData = {
            id: hiddenModalUserID, 
            actionPerform: actionToPerform, 
            currentValue: publishStatusID
        };
        $.ajax({
            url: baseUrl + "admin/"+ControllerRouteManage+"/PublishAction",
            data: postData,
            type: "POST",
            success: function (output) {
                var data = output.split("::");
                var datas = data[0].split(' ').join('');
                 if(datas == 'OK') {
                    $('.publish-modal').modal('hide');
                    var mytable = $('#'+ControllerClassName+'List').dataTable();
                    bResetDisplay = false; /* override default behaviour */
                    mytable.fnDraw( false );
                }
                if(data[3]){
                    Haider.notification(data[1],data[2],data[3]);
                }else{
                    Haider.notification(data[1],data[2]);
                }
            }
        });

    });
    $(".preview-button").click(function(event){
        event.preventDefault();
        var PreviewForm  = $(this).parents('form');
        var formData    = PreviewForm.serialize();

        var logo    = getbase64Image(PreviewForm.find('input[type=file]#Logo-file'));
        var banner  = getbase64Image(PreviewForm.find('input[type=file]#banner-file'));
        $.ajax({
            url: baseUrl + "admin/"+ControllerRouteManage+"/PreviewContent",
            data: formData,
            type: "GET",
            success: function (output) {
                var data = output.split("::");
                if (data[0].split(' ').join('') == 'OK') {
                    oTable.fnDraw();
                    $('.publish-modal').modal('hide');
                }
                if(data[3]){
                    Haider.notification(data[1],data[2],data[3]);
                }else{
                    Haider.notification(data[1],data[2]);
                }
            }
        });          
    });
    var count = 0;
    var withHeaders = true;
    var width = window.innerWidth / 1.5 ;
    var height =  window.innerHeights;

    var win;
    $("#previewSubmit").click(function(event){
        //added on 30-08-2017
        if(count > 1){
            win.close();
        }
        win = window.open('', 'newwindow', 'width=' + width + ', height=' + height + ', top=' + ((window.innerHeight - height) / 2) + ', left=' + ((window.innerWidth - width) / 2));
        event.preventDefault();
        var PreviewForm  = $(this).parents('form');
        formPreviewSubmit();
        var formData    = PreviewForm.serializeArray();

        var obFormData = new FormData();

        $.each(formData,function(index,data){
            obFormData.append(data.name,data.value);
        });
        if($('#Logo-file')[0].files[0] == undefined){
            var logoUrl = $('#Logo-show').attr('src');
             obFormData.append('logo', logoUrl);
        }else{
            obFormData.append('logo', $('#Logo-file')[0].files[0]);
        }
        if($('#banner-file')[0].files[0] == undefined){
            var logoUrl = $('#banner-show').attr('src');
             obFormData.append('banner', logoUrl);
        }else{
            obFormData.append('banner', $('#banner-file')[0].files[0]);
        }
        //if(count == 0){
            obFormData.append('withHeaders',true);
            withHeaders = true;
        //}else{
        //    obFormData.append('withHeaders',false);
        //    withHeaders = false;
       // }
       if($('#desc-content').length > 0){
            obFormData.append('desc-content', $('#desc-content').val());
       }
       
        obFormData.append('showPreview', true);
        obFormData.append('PreviewBackEnd', true);
        count++;
        $.ajax({
            url: baseUrl + "admin/"+ControllerRouteManage+"/PreviewSubmitContent",
            data: obFormData,
            processData: false,
            contentType: false,
            type: "post",
            success: function (output) {
                //if(!win2.closed)
                //win2.location.reload()
                /* if(count > 1){
                    win.close();
                }*/
                //win = window.open('', 'newwindow', 'width=' + width + ', height=' + height + ', top=' + ((window.innerHeight - height) / 2) + ', left=' + ((window.innerWidth - width) / 2));
                if(withHeaders == false){
                    win.document.body.innerHTML = output;
                }else{
                    win.document.write(output);
                }
                win.focus();
                // Write some text in the new window
            }
        });          
    });
    $("#previewSubmitWOPB").click(function(event){
        event.preventDefault();
        if(count > 1){
            win.close();
        }
        win = window.open('', 'newwindow', 'width=' + width + ', height=' + height + ', top=' + ((window.innerHeight - height) / 4) + ', left=' + ((window.innerWidth - width) / 4));
        var PreviewForm  = $(this).parents('form');
        var formData    = PreviewForm.serializeArray();
        var obFormData = new FormData();
        $.each(formData,function(index,data){
            obFormData.append(data.name,data.value);
        });
        if($('#Logo-file')[0].files[0] == undefined){
            var logoUrl =$('#Logo-show').attr('src');
             obFormData.append('logo', logoUrl);
        }else{
            obFormData.append('logo', $('#Logo-file')[0].files[0]);
        }
        if($('#banner-file')[0].files[0] == undefined){
            var logoUrl =$('#banner-show').attr('src');
            obFormData.append('banner', logoUrl);
        }else{
            obFormData.append('banner', $('#banner-file')[0].files[0]);
        }
        if(count == 0){
            obFormData.append('withHeaders',true);
            withHeaders = true;
        }else{
            obFormData.append('withHeaders',false);
            withHeaders = false;
        }
        count++;
        $.ajax({
            url: baseUrl + "admin/"+ControllerRouteManage+"/PreviewSubmitContentWOPB",
            data: obFormData,
            processData: false,
            contentType: false,
            type: "post",
            success: function (output) {
                //win = window.open('', 'newwindow', 'width=' + width + ', height=' + height + ', top=' + ((window.innerHeight - height) / 2) + ', left=' + ((window.innerWidth - width) / 2));
                if(withHeaders == false){
                    win.document.body.innerHTML = output;
                }else{
                    win.document.write(output);
                }
                win.focus();
                // Write some text in the new window
            }
        });          
    });

    //Front Questionnaire Related
    $('input').change(function(event){
        //Now show it, only if the id exists.
        var id       = $(this).attr('id');
        var Parentid = $(this).attr('name');
        id       = '.'+id+'_s';
        Parentid = '.'+Parentid+'_s';
        $(Parentid).hide();
        $(id).show();
    });
    $('input[type="checkbox"]').on('change',function(){
        if($(this).is(':checked')){
            $(this).attr('checked', true); 
        }else{
            $(this).attr('checked', false); 
        } 
    });
    $('#saveQuestionnaire').click(function(event){
            event.preventDefault();
                var userID = $('input[name="userID"]').val();
                var listingID = $('input[name="listingID"]').val();
                saveQuestionnaire(userID,listingID);
    });

    // on question tab change hide year filter
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href") // activated tab
        if(target == '#questions')
            $('.year-filter').show();
        else $('.year-filter').hide();
    });
});

//Function for Rendering Image
    function readURL(input,selector) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(selector).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    function readBackgroudURL(input,selector) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(selector).css('background-image', 'url('+e.target.result+')');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function getbase64Image(input) {
        var returnBase64 = '';
        if(input[0].files && input[0].files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                returnBase64 =  e.target.result;
            }
            reader.readAsDataURL(input[0].files[0]);
        }
        return returnBase64;
    }

    function srcImage(dbData,elem) {
        var defaultImage = baseUrl+"assets/img/lawyer.png";
        if(!dbData){
            return defaultImage
        }
        var imagePath = baseUrl+'/'+dbData;

        var http = new XMLHttpRequest();
        http.open('HEAD', imagePath, false);
        http.send();

        if(http.status!=404){
            return imagePath;
        }else{
            return defaultImage;
        }
    }
    function saveQuestionnaire(userID,listingID){
        var FormDataToSent = {};
                var QuestionElements = $('#form-questions').find('fieldset.questions');
                var QuestionAnwsersToSent = {};
                $.each(QuestionElements,function(index, el) {
                    var QuestionID   = $(el).attr('data-question-id');
                    var QuestionType = $(el).attr('data-question-type');
                    var SelectedID ;   
                    var Answer = '';
                    switch(QuestionType){
                        case 'radios':
                            var AnwserSelected = $(el).find('input[type="radio"]:checked');
                            Answer = AnwserSelected.val();
                            SelectedID = AnwserSelected.attr('id');    
                            break;
                        case 'textBoxes':
                            var AnwserSelected = $(el).find('input[type="text"]');
                            Answer = AnwserSelected.val();
                            SelectedID = AnwserSelected.attr('id'); 
                            break;
                        case 'CheckBoxes':
                            var allCheckBoxes = $(el).find('input[type="checkbox"]');
                            var CheckBoxAnswers = {};
                            var CheckBoxSelectedIDs = {};
                                var countIndex = 0;
                                    $.each(allCheckBoxes,function(index, el){
                                        if($(el).is(':checked')){
                                            var CheckBoxJson = {};
                                            var checkboxID = $(el).attr('id');
                                            var checkboxvalue = $(el).attr('value');
                                            CheckBoxJson['checkBoxID'] = checkboxID;
                                            CheckBoxJson['checkBoxValue'] = checkboxvalue;
                                            CheckBoxAnswers[countIndex] = CheckBoxJson;
                                            CheckBoxSelectedIDs[countIndex] = checkboxID;
                                            countIndex++;
                                        }
                                    });
                            if($.isEmptyObject(CheckBoxAnswers)){
                                CheckBoxAnswers = null;
                            }
                            Answer = CheckBoxAnswers;
                            SelectedID = CheckBoxSelectedIDs;
                            break;
                        case 'SelectBox':
                            var AnwserSelected = $(el).find('select')
                            Answer = AnwserSelected.val();
                            SelectedID = AnwserSelected.attr('id'); 
                            break;
                    }
                    var QuestionAnwsers = {};
                    if(SelectedID != undefined){
                        if($.isEmptyObject(SelectedID)){
                        }else{
                            var SubQuestionAnwsersToSave = getSubQuestionAnswers(SelectedID);
                            if($.isEmptyObject(SubQuestionAnwsersToSave) == false){
                                QuestionAnwsers['SubQuestionAnswer'] = SubQuestionAnwsersToSave;
                            }
                        }
                    }
                    if(Answer === undefined || Answer === null || Answer === '') {
                    }else{
                            QuestionAnwsers['QuestionID']        = QuestionID;
                            QuestionAnwsers['QuestionType']      = QuestionType;
                            QuestionAnwsers['QuestionAnswer']    = Answer;
                            QuestionAnwsers['QuestionAnswerSelectedID'] = SelectedID;   
                            QuestionAnwsersToSent[QuestionID]    = QuestionAnwsers;
                    }
                });
                if($.isEmptyObject(QuestionAnwsersToSent) == false){
                    FormDataToSent['QuestionAnwsers'] = QuestionAnwsersToSent;
                }else{
                    Haider.notification('No Questions Has Been Answered','error');
                    return null;
                }
                if(userID == null || userID == undefined || userID == ''){
                    Haider.notification('No User','error');
                    return null;
                }
                if(listingID == null || listingID == undefined || listingID == ''){
                    Haider.notification('No Listing','error');
                    return null;
                }
                FormDataToSent['userID']    = userID;
                FormDataToSent['listingID'] = listingID;
               $.ajax({
                     url: base_url+ControllerName+'/QuestionAnwsers/Save',
                     type: 'POST',
                     data: FormDataToSent,
                     success:function(output){
                        var data=output.trim().split('::');
                        if(data[0].split(' ').join('') === 'OK'){
                            $('.steps').slideUp('slow');
                            $('.steps-layout a').removeClass('active');
                            $('#step-cho').addClass('active');
                            $('#step-choose').slideDown('slow');
                            $('#getPageBuilder').addClass('active');
                            $('.check-your-email').css('color','red');
                            Haider.notification(data[1],data[2]);
                        }else if(data[0].split(' ').join('') === 'FAIL'){
                            Haider.notification(data[1],data[2]);
                        }
                    }
                 });
    }
    function getSubQuestionAnswers(SelectedID){
            var SubQuestionAnwsersToMake = {};
            if($.isEmptyObject(SelectedID)){
                return null;
            }
            if(SelectedID.isArray || $.isPlainObject(SelectedID)){
                var countIndex = 0;
                $.each(SelectedID,function(index, el) {
                    var subAnswerObject =  makeSubQuestionArray(el);
                    if(subAnswerObject != null){
                        SubQuestionAnwsersToMake[countIndex] = subAnswerObject;
                    }
                    countIndex++;
                });
            }else{
                var subAnswerObject =  makeSubQuestionArray(SelectedID);
                if(subAnswerObject != null){
                     SubQuestionAnwsersToMake = subAnswerObject;
                } 
            }
            if($.isEmptyObject(SubQuestionAnwsersToMake)){
                 return null;
            }
            return SubQuestionAnwsersToMake;     
    }
    function makeSubQuestionArray(SelectedID){
            var SelectedIDCheckSubQuestion = '.'+SelectedID+'_s.subQuestion';
            if($('#form-questions').find(SelectedIDCheckSubQuestion).length){
                var SubQuestionElements = $('#form-questions').find(SelectedIDCheckSubQuestion);
                var SubQuestionAnwsersToSent = {};
                    $.each(SubQuestionElements,function(index, el) {
                        var SubParentQuestionID = $(el).attr('data-questionid');
                        var SubQuestionType     = $(el).attr('data-type');
                        var SubAnswer = '';
                        var SubQuestionAnwsers = {};
                            switch(SubQuestionType){
                                    case 'pre-populatedList':
                                        SubAnswer = $(el).find('select').val();
                                        SubIsMutli = $(el).find('select').attr('multiple');
                                        var listTypeID = $(el).attr('data-id');
                                        SubQuestionAnwsers['SubIsMutli'] = SubIsMutli;
                                        SubQuestionAnwsers['listTypeID'] = listTypeID;

                                    SubQuestionAnwsers['SubParentQuestionID']   = SubParentQuestionID;
                                    SubQuestionAnwsers['SubAnswer']             = SubAnswer;
                                    SubQuestionAnwsers['SubQuestionType']       = SubQuestionType;
                                    SubQuestionAnwsersToSent['pre-populatedList_'+listTypeID] = SubQuestionAnwsers;
                                        break;
                                    case 'subQuestion':
                                        var SubQuestionInnerType = $(el).attr('data-subtype'); 
                                        var SubQuestionID        = $(el).attr('data-questionid');
                                        switch(SubQuestionInnerType){
                                            case 'radios':
                                                SubAnswer = $(el).find('input[type="radio"]:checked').val();
                                                break;
                                            case 'textBoxes':
                                                SubAnswer = $(el).find('input[type="text"]').val();
                                                break;
                                            case 'CheckBoxes':

                                                var allSubCheckBoxes = $(el).find('input[type="checkbox"]');
                                                var CheckBoxSubAnswers = {};
                                                //var CheckBoxSubSelectedIDs = {};
                                                var countIndex = 0;
                                                    $.each(allSubCheckBoxes,function(index, el){
                                                        if($(el).is(':checked')){
                                                            var CheckBoxSubJson = {};
                                                            var checkboxSubID = $(el).attr('id');
                                                            var checkboxSubValue = $(el).attr('value');
                                                            CheckBoxSubJson['checkBoxID'] = checkboxSubID;
                                                            CheckBoxSubJson['checkBoxValue'] = checkboxSubValue;
                                                            CheckBoxSubAnswers[countIndex] = CheckBoxSubJson;
                                                            //CheckBoxSubSelectedIDs[countIndex] = checkboxSubID;
                                                            countIndex++;
                                                        }
                                                    });
                                                    if($.isEmptyObject(CheckBoxSubAnswers)){
                                                        CheckBoxSubAnswers = null;
                                                    }
                                                SubAnswer = CheckBoxSubAnswers;
                                                break;
                                            case 'SelectBox':
                                                SubAnswer = $(el).find('select').val();
                                                break;

                                        }
                                        if(SubAnswer === undefined || SubAnswer === null || SubAnswer === '') {
                                            
                                        }else{
                                            SubQuestionAnwsers['SubQuestionInnerType'] = SubQuestionInnerType;
                                            SubQuestionAnwsers['SubQuestionID']        = SubQuestionID;
                                            SubQuestionAnwsers['SubParentQuestionID']  = SubParentQuestionID;
                                            SubQuestionAnwsers['SubAnswer']            = SubAnswer;
                                            SubQuestionAnwsers['SubQuestionType']      = SubQuestionType;
                                            SubQuestionAnwsersToSent['subQuestion_'+SubQuestionID] = SubQuestionAnwsers;
                                        }
                                    break; 
                            } 
                                    
                    });
                return SubQuestionAnwsersToSent;
            }
            return null;
    }
    function validatedEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
    }
     function commonSelect2New(selector,url,minInputLength,placeholder){
         // console.log(selector);
         // console.log('url : '+url);
         // console.log('minInputLength : '+minInputLength);
         // console.log('placeholder : '+placeholder);
        selector.select2({
            minimumInputLength:minInputLength,
            placeholder:placeholder,
            ajax: {
                url: url,
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        state:$('#address_state option:selected').attr('value')
                    };
                },
                processResults: function (data,params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.items, function(obj) {
                            return { id: obj.ID, text: obj.TEXT };
                        }),
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            templateSelection:formatData,
            debug:false
        });
     }

function formatData(data) { 
    if (data.loading) return data.text;
    var text = data.text.trim().split(' - ');
    //Add the Town to town input.
    $('#address_town').val(text[1]);
    return text[0];
}


// approve new version modal
function showApproveModal(ele){
    // check if version is already disapprove then don't show disapprove btn
    if($(ele).attr('data-id') == 'disapprove')
        $('.disapprove-btn').hide();
    else $('.disapprove-btn').show();
    var $company = $(ele).parents('td').find('.list-name').html();
    var $slug = $(ele).attr('data-slug');
    var $verId = $(ele).attr('data-ver-id');
    var $listId = $(ele).attr('data-list-id');
    var approveModal = $('.approve-modal');
    approveModal.find('input[name="slug_val"]').val($slug);
    approveModal.find('input[name="ver_val"]').val($verId);
    approveModal.find('input[name="list_val"]').val($listId);
    approveModal.find('.modal-body').find('p').html('New Version of '+$company+' has been came.');
    approveModal.modal('toggle');
    // set href for new version view
    //   $('#verViewFront').attr('href',base_url+'admin/Esic/'+$slug);

}



// get the new version data
function getVersionView(){
    var newWindow = window.open("", "new window", "width='"+w+", height="+h);
    var approveModal = $('.approve-modal');
    var $slug   =  approveModal.find('input[name="slug_val"]').val();
    var $verId  =  approveModal.find('input[name="ver_val"]').val();
    var $route  =  approveModal.find('input[name="route"]').val();
    var h = $(window).height();
    var w = $(window).width();
    $.ajax({
        type:"POST",
        url:base_url+$route+'/'+$slug,
        data:{tbl:'new_ver', verId:$verId},
        success:function(data){
            //var newWindow = window.open("", "new window", "width='"+w+", height="+h);

            //write the data to the document of the newWindow
            newWindow.document.write(data);
        }
    })
}
// approve the new version
function approveVersion(){
    var approveModal = $('.approve-modal');
    var $verId  =  approveModal.find('input[name="ver_val"]').val();
    var $listId  =  approveModal.find('input[name="list_val"]').val();
    var $route  =  approveModal.find('input[name="route"]').val();
    $.ajax({
        type:"POST",
        url:base_url+$route+'/ApproveVersion',
        data:{verId:$verId, listId:$listId },
        success:function(data){
            var data = data.split("::");
            if(data[0].split(' ').join('')== 'OK'){
                Haider.notification(data[1],data[2],data[3]);
                approveModal.modal('toggle');
                var mytable = $('#'+ControllerClassName+'List').dataTable();
                mytable.fnDraw(false);
            } else{
                Haider.notification('Unknown Error','error','Not Approved');
            }
        }
    })
}
// on year filter change event



function ShowQuestion(){ // callled when listing year change
    $('.answer-solution').each(function(index){
        if($(this).contents().length === 0 || $(this).text().replace(/\s+/g, '') == 'Sub'){
            $(this).parents('.question-post').find('.edit-question').show();
        }else{
            $(this).parents('.question-post').find('.edit-question').hide();
        }
    });
};

jQuery(document).ready(function(){
    ShowQuestion(); // called when Page loded
});

function listQuestionByYear(element){
    var $year = $(element).val();
    var id = $(element).attr('data-id');
    var $route  =  $('.approve-modal').find('input[name="route"]').val();
    $.ajax({
        url:base_url+'admin/'+$route+'/view/'+id,
        type:"POST",
        data:{year:$year},
        success:function(data){
            if(typeof data =='object'){
                $('#questions').html(data.showUserQuestionAnswers);
                ShowQuestion();
            }
        }
    })
}

// disapprove version by admin
function disapproveVersion(ele){
    $operation = $(ele).attr('data-id');
    if($operation == 'disapprove'){
        disapproveVer(ele);
    } else {
        submitDisapprovalMsg(ele);
    }
    oTable.fnDraw(false);
}

// disapprove version
function disapproveVer(ele){
    var approveModal = $('.approve-modal');
    var $verId  =  approveModal.find('input[name="ver_val"]').val();
    var $route  =  approveModal.find('input[name="route"]').val();
    $.ajax({
        type:"POST",
        url:base_url+$route+'/DisapproveVersion',
        data:{verId:$verId},
        success:function(data){
           var data = data.split("::");
            if(data[0].split(' ').join('') == 'OK'){
                $(ele).parents('.modal-footer').find('.approve').hide();
                $(ele).attr('data-id','submit_msg').html('Submit Message');
                Haider.notification(data[1],data[2],data[3]);
                var mytable = $('#'+ControllerClassName+'List').dataTable();
                mytable.fnDraw(false);
                $(ele).parents('.modal-footer').find('.approve').show();
            } else{
                Haider.notification('Unknown Error','error','Error');
            }
        }
    })
}

// submit reason for disapproving version
function submitDisapprovalMsg(ele){
    var $disapprovalMsg = $('.disapproval-msg').val();
    if($disapprovalMsg == ''){
        Haider.notification('Please Write Something To Submit', 'error', 'Error');
    } else {
        var approveModal = $('.approve-modal');
        var $verId  =  approveModal.find('input[name="ver_val"]').val();
        var $route  =  approveModal.find('input[name="route"]').val();
        $.ajax({
            type:"POST",
            url:base_url+$route+'/disapprovalMsg',
            data:{verId:$verId, msg: $disapprovalMsg},
            success:function(data){
                var data = data.split("::");
                if(data[0].split(' ').join('')== 'OK'){
                    Haider.notification(data[1],data[2],data[3]);
                    $(ele).attr('data-id','disapproved').html('Disapproved').hide();
                    var mytable = $('#'+ControllerClassName+'List').dataTable();
                    mytable.fnDraw(false);
                    $(".disapproval-msg").val("");
                    $(ele).parents('.modal-footer').find('.approve').show();
                    $(ele).attr('data-id','disapprove').hide();
                } else{
                    Haider.notification('Unknown Error','error','Error');
                }
            }
        })
    }
}
// user roll back from listing new version, which's not approve yet
function rollBack(ele){
    var $verId = $(ele).attr('data-id');
    var $listId = $(ele).attr('data-list-id');
    if($verId == '' || $listId == ''){
        Haider.notification('Unknown Error','error','Error');
        return false;
    }
    var approveModal = $('.approve-modal');
    var $route  =  approveModal.find('input[name="route"]').val();
    $.ajax({
        type:"POST",
        url:base_url+$route+'/rollBack',
        data:{verId:$verId, listId:$listId},
        success:function(data){
            var data = data.split("::");
            if(data[0].split(' ').join('')== 'OK'){
                location.assign(base_url+$route+'/Edit/'+$listId);
            } else{
                Haider.notification(data[1],data[2],data[3]);
            }
        }
    })
}

function getPostCodes(selector,postCodesURL,state){ // listing.js
    selector.empty();
    $.ajax({
        url:postCodesURL,
        type:"GET",
        data:{state:state},
        success:function(data){
            var $result = JSON.parse(data);
            var $options = '';
            var postCodes = [];
            var towns = '';
            $.each($result.items, function(i, val){
                if($.inArray( val.TEXT, postCodes ) == -1){
                    $options += '<option value="'+val.ID+'">'+val.TEXT+'</option>';
                    postCodes.push(val.TEXT);
                }
                if($.inArray( val.Place_Name, postCodes ) == -1){
                    towns += '<option value="'+val.ID+'">'+val.Place_Name+'</option>';
                    postCodes.push(val.Place_Name);
                }
            })
            selector.append($options);
            $('#address_town').append(towns);
        }
    });
}
// reset listing status
function resetListingStatus($listing){
    $.ajax({
        url:base_url+'Admin/'+$listing+'/resetStatus',
        type:"POST",
        beforeSend:function(){
        },
        success:function(data){
            var data = data.split("::");
            if(data[0].split(' ').join('') == 'OK'){
                Haider.notification(data[1],data[2],data[3]);
                $('#'+$listing+'Status').DataTable().draw(false);
                $('#'+$listing+'List').DataTable().draw(false);
            } else {
                Haider.notification('Not Reset. Try Again','error','Error')
            }
        }
    });
}

// restore listing status
function restoreStatus($listing, $prevStatusId){
    $.ajax({
        url:base_url+'Admin/'+$listing+'/restore',
        type:"POST",
        data:{prevStatusId: $prevStatusId},
        beforeSend:function(){
        },
        success:function(data){
            var data = data.split("::");
            if(data[0].split(' ').join('') == 'OK'){
                Haider.notification(data[1],data[2],data[3]);
                $('#'+$listing+'Status').DataTable().draw(false);
                $('#'+$listing+'List').DataTable().draw(false);
            } else {
                Haider.notification('Not Restored. Try Again','error','Error')
            }
        }
    });
}

$(document).ready(function(ev){
    $('.confirm-modal').on('show.bs.modal', function(e){
        var $statusId = $(e.relatedTarget).attr('data-id');
        $('.prevStatusId').val($statusId);
    });

    $(document).on('click','.delete-prev-status', function(e){
        var controller = $(this).parents('.confirm-modal').find('.delete-status-url').val();
        var $statusId = $('.prevStatusId').val();
        if($statusId!=''){
            $.ajax({
                url:base_url+'Admin/'+controller+'/deleteStatus',
                type:"POST",
                data:{prevStatusId: $statusId},
                beforeSend:function(){
                    $('.confirm-modal').modal('toggle');
                },
                success:function(data){
                    var data = data.split("::");
                    if(data[0].split(' ').join('') == 'OK'){
                        Haider.notification(data[1],data[2],data[3]);
                        $('#'+controller+'Status').DataTable().draw(false);
                    } else {
                        Haider.notification('Not Deleted. Try Again','error','Error')
                    }
                }
            });
        }
    })

    // on tab change, hide reset
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var id = $(e.target).attr("id") // activated tab
        if(id=='list_tab'){
            $('.reset-status').show();
            $('.status-year').addClass(' hide');
        } else if(id=='status_tab'){
            $('.reset-status').hide();
            $('.status-year').removeClass('hide');
        }
    });
})

// added by hamid raza for multiple functionality
$(document).ready(function(ev){
    var Controller = $('.sub').attr('id');
    $('.sub').click(function(){
        var favorite = [];
        $.each($("input[name='ids']:checked"), function(){
            favorite.push($(this).val());
        });
        var ids = favorite.join(", ");
        var bulk_status = $('#bulk_status').find(":selected").val();
        if(ids !='' && bulk_status != '' ){
            $( "#dialog-confirm" ).dialog({
                resizable: false,
                height: "auto",
                width: 400,
                modal: true,
                buttons: {
                    "Ok": function() {
                        $( this ).dialog( "close" );
                        $.ajax({
                            url:base_url+Controller+'/bulk_actions_processings',
                            type:"POST",
                            data:{ids:ids, bulk_status: bulk_status},
                            success:function(data){
                                var data = data.split("::");
                                console.log(data[0].split(' ').join(''));
                                if(data[0].split(' ').join('') == 'OK'){
                                    Haider.notification(data[1],data[2],data[3]);
                                    sTable.draw(false);
                                    $('.select_all').prop('checked', false); // Unchecks it
                                }else {
                                    Haider.notification('Something went wrong. Try Again','error','Error')
                                }
                            }
                        });
                    },
                    Cancel: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }
        else{
            $('.alert-modal3').modal('toggle');
        }
    });
});
$(document).ready(function(){ // Ranking score must be < 101 and > -1 all add and edit listing page

    $("#ranking_score").focusout(function(){
    var va = $("#ranking_score").val();
        if(va > 100 ){
            $("#ranking_score").val('100');
        }else if( va < 0 ){
            $("#ranking_score").val('0');
        }
    });
     $( ".DateBox" ).blur(function() {
         var date_formate = $(this).val().split("-");
         var currentDate = new Date()
         var day = currentDate.getDate()
         var month = currentDate.getMonth() + 1
         var year = currentDate.getFullYear()
         if(date_formate.length > 1){
             if(date_formate[2].length < 4 && date_formate[2].length != 0){
                 Haider.notification('Please Enter Date like '+day+"-"+month+"-"+year+'','error','Error');
             }else if(date_formate[1] > 12){
                 Haider.notification('Please Enter Date like '+day+"-"+month+"-"+year+'','error','Error');
             }
         }

    })
    $( ".DateBox" ).change(function() {
        var date_formate = $(this).val().split("-");
        var currentDate = new Date()
        var day = currentDate.getDate()
        var month = currentDate.getMonth() + 1
        var year = currentDate.getFullYear()
        if(date_formate[1] > 12){
            Haider.notification('Please Enter Date like '+day+"-"+month+"-"+year+'','error','Error');
        }
    });


// For ESIC backend  Calculator Questions answers

    function save_user_ans(Qid,ans,Cuserid,listing_id) {
        if(ans =='' && ans == 'undefined' && ans == 'null' ) return false;
        if(Number.isInteger(Qid) === false ) return false;
        $.ajax({
            url: baseUrl + "estimator/save_answers",
            data: {Qid:Qid,ans:ans,Cuserid:Cuserid,listing_id:listing_id},
            type: "POST",
            success: function (output) {
                if(output){
                    var outputT = output.trim();
                    var splittedOutcome = outputT.split('::');

                    if(splittedOutcome[0] == 'OK') {
                        Haider.notification('Record SuccessFully Updated','success','Success');
                    } else {
                        Haider.notification('Something happened wrong','error','Error');
                    }
                }
            }
        });
    }
    jQuery(document).on('click','#CalculatorQuestions input[type=checkbox]',function(e){
        var Qid = $(this).parents('.Questions').data('id');
        var Cuserid = $('#userIDd').val();
        var ans = $(this).prop("checked") ? $(this).val() : 0;
        var listing_id = $('#profile-box-container').data('user-id');
        save_user_ans(Qid,ans,Cuserid,listing_id);
    });

    jQuery(document).on('click','#CalculatorQuestions input[type=radio]',function(e){
        var Qid = $(this).parents('.Questions').data('id');
        var Cuserid = $('#userIDd').val();
        var listing_id = $('#profile-box-container').data('user-id');
        var ans = $(this).val();
        save_user_ans(Qid,ans,Cuserid,listing_id);
    });

    $('#CalculatorQuestions .date_picker').on('changeDate', function(e) {
        if($(this).parent().closest('div').find('.errors').length > 0){
            $(this).parent().closest('div').find('.errors').remove();
        }
        var listing_id = $('#profile-box-container').data('user-id');
        var Qid = $(this).parents('.Questions').data('id');
        var corporate_date = $(this).val();
        var Cuserid = $('#userIDd').val();
        if(corporate_date.length < 10 ) return false;
        $.ajax({
            url: baseUrl + "estimator/incorporated",
            data: {'corporate_date':corporate_date},
            type: "POST",
            success: function (output) {
                if(output){
                    var data = JSON.parse(output);
                    save_user_ans(Qid,corporate_date,Cuserid,listing_id);
                    $('.datepicker').hide();
                    if(data == 'fail' ){
                        $('.q21').removeClass('hidden');
                        $('.result_content').text(' ');
                        $('.result_content').html("This company is too old to be considered an ESIC.");
                        $('#result_modal').modal('show');
                        return false;
                    }else if(data == 'middle'){
                        $('.result_content').text(' ');
                        $('.result_content').html("As an older ESIC you must aggregate <br> expenditure for the prior 3 years to pass the $1 million expenditure test.");
                        $('#result_modal').modal('show');
                        $('.q21').addClass('hidden');
                    }else{
                        $('.q21').addClass('hidden');
                    }
                }
            }
        });
    });

    // Show Result model ESIC calculator Questions page backend
    function early_stage_fail_message(){
        $('.result_content').text(' ');
        var contactus = baseUrl + "contact.html"
        $('.result_content').html("Please <a href="+contactus+" target='_blank' style='font-size: 14px'><b> contact us</b> </a> for assistance.");
        $('#result_modal').modal('show');
    }
    $('.nextquestions').change(function(){
        var value = $( this ).val();
        if(value == 0){
            $('.printest').removeClass('hidden');
            $('.innotest').addClass('hidden');
        }else{
            $('.printest').addClass('hidden');
            $('.innotest').removeClass('hidden');
        }
    });
    $('.innovalue').change(function(){
        var total = 0;
        $.each($(".innovalue:checked"), function(){
            total  += parseFloat($(this).val());
        });
        if(total > 0){
            $('.inno9').addClass(' hidden');
        }else{
            $('.inno9').removeClass(' hidden');
        }
        Haider.notification(total, 'success','Total Points');
    });

    
    var scrolls ='' ;
    function showerror(question){
        if(scrolls !='stop' ) $('html, body').animate({scrollTop: ($('.'+scrolls+'').offset().top-50)}, 1000);
        if($('.'+question+' .errors').length < 1 ){
            $('.'+question+' h5:first-child').after("<div class='errors'>Please select answer</div>");
        }
        return false;
    }
    $('input:radio').change(function() {
        if($(this).parent().closest('div').find('.errors').length > 0){
            $(this).parent().closest('div').find('.errors').remove();
        }
    });

    function validateit(){
        var res = true;
        scrolls ='stop' ;
        var q1 = $("input[name='q1']:checked").val();
        var q2 = $("#date-picker-example").val();
        var q3 = $("input[name='q3']:checked").val();
        var q4 = $("input[name='q4']:checked").val();
        var q5 = $("input[name='q5']:checked").val();

        if(q1 == undefined){
            var question =  'q1';
            scrolls =  ( scrolls == 'stop'  )  ? question : "stop";
            res =showerror(question,scrolls);
        }
        if(q2 == ''){
            var question = 'q2';
            scrolls =  ( scrolls == 'stop'  )  ? question : scrolls;
            res =showerror(question,scrolls);
        }
        if(q3 == undefined){
            var question = 'q3';
            scrolls =  ( scrolls == 'stop'  )  ? question : scrolls;
            res =showerror(question,scrolls);
        } if(q4 == undefined){
            var question = 'q4';
            showerror(question,scrolls);
        } if(q5 == undefined){
            var question = 'q5';
            scrolls =  ( scrolls == 'stop'  )  ? question : scrolls;
            res = showerror(question,scrolls);
        }
        if($(".nexttest.hidden").length < 1 ){
            var nextquestion = $("input[name='nextquestion']:checked").val();
            if(nextquestion == undefined){
                var question = 'nexttest';
                scrolls =  ( scrolls == 'stop'  )  ? question : scrolls;
                if($('.nextquestion .errors').length < 1 ){
                    $('.nextquestion').prepend("<div class='errors'>Please select next test</div>");
                }
                showerror(question,scrolls);
            }
        }
        if($(".printest.hidden").length < 1 ){

            var q7 = $("input[name='q7']:checked").val();
            var q8 = $("input[name='q8']:checked").val();
            var q9 = $("input[name='q9']:checked").val();
            var q10 = $("input[name='q10']:checked").val();
            var q11 = $("input[name='q11']:checked").val();
            if(q7 == undefined){
                var question =  'q7';
                scrolls =  ( scrolls == 'stop'  )  ? question : "stop";
                res =showerror(question,scrolls);
            }
            if(q8 == undefined){
                var question =  'q8';
                scrolls =  ( scrolls == 'stop'  )  ? question : "stop";
                res =showerror(question,scrolls);
            }
            if(q9 == undefined){
                var question =  'q9';
                scrolls =  ( scrolls == 'stop'  )  ? question : "stop";
                res =showerror(question,scrolls);
            }if(q10 == undefined){
                var question =  'q10';
                scrolls =  ( scrolls == 'stop'  )  ? question : "stop";
                res =showerror(question,scrolls);
            } if(q11 == undefined){
                var question =  'q11';
                scrolls =  ( scrolls == 'stop'  )  ? question : "stop";
                res =showerror(question,scrolls);
            }
        }
        if(res == false) return false;
    }


    var interval = '';

    $(document).on('click','.closed',function (){
        $('.countertext').text(' ');
        clearInterval(interval);
    });

    $(document).on('click','.closedbtn',function (){
        $('.countertext').text(' ');
        clearInterval(interval);
        window.location.href =  baseUrl + "search";

    });

    $(document).on('click','#continue',function (){
        clearInterval(interval);
        redirect_function();
    });
    function redirect_function(){
        window.location.href =  baseUrl + "esic";
    }


    jQuery(document).on('click','.show_result',function(e){
        $('.countertext').text(' ');
        var invoresult = 'pending';
        var prinresult = 'pending';
        var q3 = $("input[name='q3']:checked").val();
        var q4 = $("input[name='q4']:checked").val();
        var q5 = $("input[name='q5']:checked").val();

        // validation work
        if( validateit() === false){
            early_stage_fail_message();
            return false;
        }

        if(q3 == 1 && q4 == 1 && q5 == 1 ){
            $('.nexttest').removeClass('hidden');
        }
        if(q3 == 0 || q4 == 0 || q5 == 0){
            early_stage_fail_message();
            return false;
        }
        var total = 0;
        var test = '';
        $.each($(".innovalue:checked"), function(){
            total  += parseFloat($(this).val());
            if($(this).prop("checked") == true){
                test = 'ok';
            }
        });
        if((test == 'ok' && total < 100 ) && prinresult !== 'pending' ) { //100-point innovation test required
            $('.result_content').text(' ');
            $('.result_content').text('The company does not qualify as an ESIC under the 100 point test at this time,'+
                ' you may consider practical ways to gain points prior to investment or consider'+
                'if it qualifies as an ESIC under the principals based test. Points must be accrued prior to the investment (the relevant time).');
            $('#result_modal').modal('show');
            invoresult = 'fail';
            return false;
        }
        if(test == 'ok' && total >= 100 ) {
            $('.printest').removeClass('hidden');
            $('html, body').animate({scrollTop: ($('.printest').offset().top-50)}, 1000);
            invoresult = 'pass';
        }
        if($('.printest.hidden').length == 0  ){ // has opened but  part b fail principal based test

            var q7 = $("input[name='q7']:checked").val();
            var q8 = $("input[name='q8']:checked").val();
            var q9 = $("input[name='q9']:checked").val();
            var q10 = $("input[name='q10']:checked").val();
            var q11 = $("input[name='q11']:checked").val();
            console.log(invoresult);
            if(q7 == 0 || q8 == 0 || q9 == 0 || q10 == 0 || q11 == 0 ){    // if Principles-based test  Fail
                $('.result_content').text(' ');
                $('.result_content').text('The company is unlikely to qualify as an ESIC under the principles-based innovation test at this time, and must correct this prior to the investment (the relevant time). If you have not already done so, you may wish to consider if it qualifies as an ESIC under the 100 point innovation test.');
                $('#result_modal').modal('show');
                result = 'fail';
                prinresult = 'fail';
            }else{ // got to points test
                $('.innotest').removeClass('hidden');
                prinresult = 'pass';
                if( invoresult == "pending"){
                    $('.result_content').text(' ');
                    $('.result_content').text('Complete 100-points innovation test');
                    $('#result_modal').modal('show')
                    $('html, body').animate({
                        scrollTop: $(".nexttest").offset().top
                    }, 2000);
                }
            }
        }
        if( prinresult == 'pass' || invoresult == 'pass'){
            $('.result_content').text(' ');
            $('.timers').html(' ');
            $('.result_content').html('<p>Well done, the company may be considered an ESIC</p><p>Feel Free To Carry On</p><p>With A Free Listing To Help Your Investors</p>');
            $('#result_modal').find('.modal-footer').append("<div class='timers'><h4 clas='countertext'>You will redirected to further account flow after <p id='timer'></p></h4><div class='row'><div class='col-md-6'><button id='continue' class='btn btn-primary pull-right'>Continue</button></div><div class='col-md-6'><button  class=' closed btn btn-danger pull-left closedbtn '   data-dismiss='modal'>View Listings</button></div></div></div>")
            // redirect to add listing page
            var url = base_url+'esic';
            var counter = 30;
            interval = setInterval(function() {
                counter--;
                if (counter <= 0) {
                    clearInterval(interval);
                    $('#result_modal').find('.countertext').text(' ');
                    redirect_function();
                }else{
                    $('#timer').text(counter+' Seconds');
                }
            }, 1000);

            $('#result_modal').modal('show')
        }
        if( prinresult == 'fail' && invoresult == 'fail'){
            $('.result_content').text(' ');
            $('.result_content').text('The company will not qualify as an ESIC as it will not meet all aspects of the early stage test.');
            $('#result_modal').modal('show')
        }
        if(($('.printest.hidden').length == 1 || $('.innotest.hidden').length == 1 ) &&  $('.nextquestions').prop("checked") == true ){ // for incomplete unclear
            $('.result_content').text(' ');
            $('.result_content').text('It is unclear if the company qualify as an ESIC at this time.Please reconsider the tests if you not already done so, contact our office, or request a private binding ruling from the ATO.');
            $('#result_modal').modal('show');
            return false;
        }
    });

});