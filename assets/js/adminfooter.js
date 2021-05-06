        $(function () {
            //// Need To Work ON New Way Of DataTables..
            oTable = "";
            //Initialize Select2 Elements
            var regTableSelector = $("#regList");
            var url_DT = baseUrl + "admin/assessments_list/listing";
            var aoColumns_DT = [
                /* User ID */ {
                    "mData": "UserID",
                    "bVisible": true,
                    "bSortable": true,
                    "bSearchable": true
                },
                /* Full Name */ {
                    "mData": "FullName"
                },
                /* Email */ {
                    "mData": "Email"
                },
                /* Company */ {
                    "mData": "Company"
                },
                /*  Buisness */ {
                    "mData": "Business"
                },

                /* Last User Login */ {
                    "mData": "Status"
                },
                /* Action Buttons */ {
                    "mData": "ViewEditActionButtons"
                },
                /* Publish Buttons */ {
                    "mData": "Publish",
                    "render": function ( data, type, row ) {
                        if(data!=''){
                            if(data== 0){
                                return '<span class="label publish label-danger" data-target=".publish-modal" data-toggle="modal" >UnPublished</span>';
                            }else if(data == 1){
                                return '<span class="label publish label-success" data-target=".unpublish-modal" data-toggle="modal" >Published</span>';
                            }else{
                                return '<span class="label publish label-success" data-target=".unpublish-modal" data-toggle="modal" >Unknown</span>';
                            }
                        }
                        return '<span class="label publish label-success" data-target=".unpublish-modal" data-toggle="modal" >Unknown</span>';
                    }
                }
            ];
            var HiddenColumnID_DT = "UserID";
            var sDom_DT = '<"H"r>t<"F"<"row"<"col-lg-6 col-xs-12" i> <"col-lg-6 col-xs-12" p>>>';
            var newRowNumber =  localStorage.getItem("pageNumber") * 10;
            if(newRowNumber == undefined || newRowNumber == '' ){
                newRowNumber = 0;
            }
            commonDataTablesPage(regTableSelector, url_DT, aoColumns_DT, sDom_DT, HiddenColumnID_DT,newRowNumber);
            //oTable.fnPageChange(40);
            new $.fn.dataTable.Responsive(oTable, {
                details: true,
            });
            removeWidth(oTable);
            //Code for search box
            $("#search-input").on("keyup", function (e) {
                oTable.fnFilter($(this).val());
            });
		   oTable = $('#regList').DataTable();  // // Search by Title
           $('#Search_by_Name').keyup(function(){
           oTable.column(1).search($(this).val()).draw() ;
           })
		   oTable = $('#regList').DataTable();  //// Search by Author
		   $('#Search_by_Email').keyup(function(){
		   oTable.column(2).search($(this).val()).draw() ;
		   })
		   oTable = $('#regList').DataTable();  ////Search by Tags
		   $('#Search_by_Company').keyup(function(){
		   oTable.column(3).search($(this).val()).draw() ;
		   })

            //Some Action To Perform When Modal Is Shown.
			$(".approval-modal").on("shown.bs.modal", function (e) {
            	 var button = $(e.relatedTarget); // Button that triggered the modal
			     var ID = button.parents("tr").attr("data-id");
			     var modal = $(this);
			     modal.find("input#hiddenUserID").val(ID);
            	$.ajax({
                  url: baseUrl + "admin/manage_status/allvalues",
				   // url: baseUrl + "admin/assessments_list/listing",
                    type: "POST",
                    success: function (output) {
                        var model = $(this);
                        var data = $.parseJSON(output);
                        $('#editStatusTextBox').html('');
	                        $.each(data, function( key, value ) {
							  $('#editStatusTextBox').append('<option value="'+value.id+'">'+value.status+'</option>');
							});
						var StatusText = $.trim(button.parents("tr").find('.status').text());
					    var StatusID = $('#editStatusTextBox option').filter(function () {
					              return $(this).html() == StatusText;
					     }).val();
					    $("#editStatusTextBox").val(StatusID);
                    }
                });

            });

            $("#saveStatus").on("click", function () { /// admin-esic.js code moved
                var hiddenModalUserID = $(this).parents(".modal-content").find("#hiddenUserID").val();
			    var editStatusTextBox = $(this).parents(".modal-content").find("#editStatusTextBox").val();
                if (hiddenModalUserID == '') {
                    hiddenModalUserID = $(this).attr('data-id');
                }
				var postData = {id: hiddenModalUserID, value: "approve", statusValue: editStatusTextBox};
                $.ajax({
                   url: baseUrl + "admin/assessment_list",
                    data: {
                        id: hiddenModalUserID,
                        value: "approve",
                        statusValue :editStatusTextBox
                    },
                    type: "POST",
                    success: function (output) {
                        var data = output.split("::");
                        if (data[0].split(' ').join('') == 'OK') {
                            $('.publish-modal').modal('hide');
                            $Table.draw();
                        }
                    }
                });
            });

            $(".publish-modal").on("shown.bs.modal", function (e) {
                 var button = $(e.relatedTarget); // Button that triggered the modal
                 var ID = button.parents("tr").attr("data-id");
                 var modal = $(this);
                 modal.find("input#hiddenUserID").val(ID);
                 var publishText = $.trim(button.parents("tr").find('.publish').text());
                 $("#editStatusTextBox").val(publishText);


            });

             $("#yesPublish").on("click", function () {
                var hiddenModalUserID = $(this).parents(".modal-content").find("#hiddenUserID").val();
                var editPublishTextBox = $(this).parents(".modal-content").find("#editStatusTextBox").val();
                if (hiddenModalUserID == '') {
                    hiddenModalUserID = $(this).attr('data-id');
                }
                var postData = {id: hiddenModalUserID, value: "publish", statusValue: editPublishTextBox};
                $.ajax({
                    url: baseUrl + "admin/assessment_list",
                    data: {
                        id: hiddenModalUserID,
                        value: "publish",
                        statusValue :editPublishTextBox
                    },
                    type: "POST",
                    success: function (output) {
                        var data = output.split("::");
                        if (data[0].split(' ').join('') == 'OK') {
                            $('.publish-modal').modal('hide');
                            $Table.draw();
                        }
                    }
                });
            });

            $(".unpublish-modal").on("shown.bs.modal", function (e) {
                 var button = $(e.relatedTarget); // Button that triggered the modal
                 var ID = button.parents("tr").attr("data-id");
                 var modal = $(this);
                 modal.find("input#hiddenUserID").val(ID);
                 var publishText = $.trim(button.parents("tr").find('.unpublish').text());
                 $("#editStatusTextBox").val(publishText);


            });

            $("#yesUnPublish").on("click", function () {
                var hiddenModalUserID = $(this).parents(".modal-content").find("#hiddenUserID").val();
                var editPublishTextBox = $(this).parents(".modal-content").find("#editStatusTextBox").val();
                if (hiddenModalUserID == '') {
                    hiddenModalUserID = $(this).attr('data-id');
                }
                var postData = {id: hiddenModalUserID, value: "unpublish", statusValue: editPublishTextBox};
                $.ajax({
                    url: baseUrl + "admin/assessment_list",
                    data: {
                        id: hiddenModalUserID,
                        value: "unpublish",
                        statusValue :editPublishTextBox
                    },
                    type: "POST",
                    success: function (output) {
                        var data = output.split("::");
                        if (data[0].split(' ').join('') == 'OK') {
                            $('.unpublish-modal').modal('hide');
                            $Table.draw();
                        }
                    }
                });
            });

             $(".delete-modal").on("shown.bs.modal", function (e) {
                var button = $(e.relatedTarget); // Button that triggered the modal
                var ID = button.parents("tr").attr("data-id");
                var modal = $(this);
                modal.find("input#hiddenUserID").val(ID);
            });

            $("#yesDelete").on("click", function () {
                var hiddenModalUserID = $(this).parents(".modal-content").find("#hiddenUserID").val();
                if (hiddenModalUserID == '') {
                    hiddenModalUserID = $(this).attr('data-id');
                }
                var postData = {id: hiddenModalUserID, value: "delete"};
                $.ajax({
                    url: baseUrl + "admin/assessment_list",
                    data: {
                        id: hiddenModalUserID,
                        value: "delete"
                    },
                    type: "POST",
                    success: function (output) {
                        var data = output.split("::");
                        if (data[0].split(' ').join('') == 'OK') {
                            $('.delete-modal').modal('hide');
                            $Table.draw();
                        }
                    }
                });
            });
            tinyMCE.init({
                selector: '#short-desc-textarea',
                height: 200,
                plugins: [
                    'hr anchor',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime nonbreaking  directionality paste code'
                ],
                toolbar: 'undo redo preview| styleselect | bold italic |  outdent indent'
            });
            tinyMCE.init({
                selector: '#desc-textarea',
                height: 500,
                automatic_uploads: true,
                images_upload_base_path: baseUrl + 'tinyimage',
                imageupload_url:baseUrl + 'tinyimage',
                images_upload_credentials: true,
                relative_urls: false,
                remove_script_host: false,
                plugins: [
                    'advlist autolink lists link image imagetools jbimages charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking table contextmenu directionality paste code'
                ],
                toolbar: 'undo redo preview| styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages',
                fontsize_formats: "8px 10px 12px 14px 18px 20px 24px 24px 28px 30px 36px 40px",
            });

            $("body").on("click", ".save-desc", function (e) {
                e.preventDefault();
                var userId = $(this).attr('data-user-id');
                var textArea = tinyMCE.get('desc-textarea').getContent();
                var ansDiv = $('.edit-desc');
                var saveBtn = $('#save-desc');
                var descText = $('#desc-text pre');
                var descDataText = $.trim(textArea);
                var postData = {
                    userID: userId,
                    descDataText: descDataText
                };
                saveBtn.parent().remove();
                $.ajax({
                    url: baseUrl + "admin/savedesc",
                    data: postData,
                    type: "POST",
                    success: function(output) {
                        var data = output.split("::");
                        if (data[0].split(' ').join('') === "OK") {
                            descText.html(data[1]);
                            ansDiv.hide();
                            $('#desc-edit').show();
                            descText.show();
                        }
                    }
                });

            });
            $("body").on("click", ".save-short-desc", function (e) {
                e.preventDefault();
                var userId = $(this).attr('data-user-id');
                var textArea = tinyMCE.get('short-desc-textarea').getContent();
                var ansDiv = $('.edit-short-desc');
                var saveBtn = $('#save-short-desc');
                var descText = $('#short-desc-text pre');
                var descDataText = $.trim(textArea);
                var postData = {
                    userID: userId,
                    descDataText: descDataText
                };
                saveBtn.parent().remove();
                $.ajax({
                    url: baseUrl + "admin/saveshortdesc",
                    data: postData,
                    type: "POST",
                    success: function(output) {
                        var data = output.split("::");
                        if (data[0].split(' ').join('') === "OK") {
                            descText.html(data[1]);
                            ansDiv.hide();
                            $('#short-desc-edit').show();
                            descText.show();
                        }
                    }
                });

            });

            $('#showExpDate').on("click",function(){
                var expDateEye = $(this);
                var userId = $(this).parents('#profile-box-container').attr('data-user-id');
                var currentStatus = expDateEye.attr('data-value');
                var update = 'hide';
                if(currentStatus !== 'show'){
                    update = 'show';
                }

                $.ajax({
                    url:baseUrl + "admin/showExpDate",
                    data:{expDate:update,userID:userId},
                    type:'POST',
                    success:function(output){
                        var data = output.split("::");
                        if(data[0].split(' ').join('') === 'OK'){
                            if(update=='show'){
                                expDateEye.removeClass('fa-eye-slash');
                                expDateEye.addClass('fa-eye');
                                expDateEye.attr('data-value','show');
                                //Changing Colors
                                expDateEye.removeClass('text-warning');
                                expDateEye.addClass('text-success');
                            }else{
                                expDateEye.removeClass('fa-eye');
                                expDateEye.addClass('fa-eye-slash');
                                expDateEye.attr('data-value','hide');
                                //Changing Colors
                                expDateEye.removeClass('text-success');
                                expDateEye.addClass('text-warning');

                            }

                        }
                    }
                })
            });
            $("body").on("click", ".save-answer", function (e) {

                e.preventDefault();
                var id = $(this).attr('data-id');
                var Answervalue = $('.' + id + ' select.answer-solution').val();
                var SpAnswervalue = $('.' + id + ' .edit-category.sp-question select').val();
                var tableName = $('.' + id + ' .edit-category.sp-question').attr('data-tablename');
                var tableUpdateID = $('.' + id + ' .edit-category.sp-question').attr('data-tableUpdateID');
                var ansDiv = $('.' + id + ' .edit-question');
                var dataQuestionId = $(this).attr('data-question-id');
                var userID = $('#profile-box-container').attr('data-user-id');
                var answerDiv = $('.' + id + ' .answer-solution');
                var scoreDiv = $('.' + id + ' .question-points');
                var barDiv = $('.progress .question-bar span');
                var oldScore = scoreDiv.attr('data-score');

                var postData = {
                    id: id,
                    userID: userID,
                    dataQuestionId: dataQuestionId,
                    Answervalue: Answervalue,
                    SpAnswervalue: SpAnswervalue,
                    tableName: tableName,
                    tableUpdateID:tableUpdateID,
                    oldScore: oldScore
                };
                $.ajax({
                    url: baseUrl + "admin/saveanswer",
                    data: postData,
                    type: "POST",
                    success: function (output) {
                        var data = output.split("::");
                        if (data[0].split(' ').join('') === "OK") {
                            ansDiv.hide();
                            answerDiv.text(Answervalue);
                            scoreDiv.text(data[1]);
                            barDiv.text(data[2]);
                            barDiv.parent().css('width', data[2] + '%');
                        }
                    }
                });
            });

            $(".question-edit").on("click", function (event) {
                event.preventDefault();
                var id = $(this).attr('data-id');
                var select = $('.' + id + ' select.answer-solution');
                var ansDiv = $('.' + id + ' .edit-question');
                var dataQuestionId = $(this).attr('data-question-id');
                var saveBtn = $('.' + id + ' .save-answer');


                var postData = {
                    id: id,
                    dataQuestionId: dataQuestionId
                };
                saveBtn.parent().remove();
                $.ajax({
                    url: baseUrl + "admin/getanswers",
                    data: postData,
                    type: "POST",
                    success: function (output) {
                        var data = $.parseJSON(output);
                        select.html('');
                        $.each(data, function (index, value) {
                            select.append('<option value="' + value.solution + '">' + value.solution + '</option>');
                        });
                        select.parent().append('<div class="question-action-buttons"><button class="save-answer" data-question-id="' + dataQuestionId + '" data-id="' + id + '">Save</button></div>');
                        ansDiv.show();
                    }
                });
            });
            $("#desc-edit").on("click", function (event) {
                event.preventDefault();
                var userId = $(this).attr('data-user-id');
                var textArea = $('#desc-textarea');
                var ansDiv = $('.edit-desc');
                var saveBtn = $('#save-desc');
                var descText = $('#desc-text pre');
                ansDiv.show();
                descText.hide();
                var descDataText = descText.text();
                descText.text('');
                textArea.val($.trim(descDataText));
                ansDiv.children('.form-group').append('<div class="question-action-buttons"><button id="save-desc" data-user-id="'+userId+'" class="save-desc">Save</button></div>');
                $(this).hide();


            });
            $("#short-desc-edit").on("click", function (event) {
                 
                event.preventDefault();
                var userId = $(this).attr('data-user-id');
                var textArea = $('#short-desc-textarea');
                var ansDiv = $('.edit-short-desc');
                var saveBtn = $('#save-short-desc');
                var descText = $('#short-desc-text pre');
                ansDiv.show();
                descText.hide();
                var descDataText = descText.text();
                descText.text('');
                textArea.val($.trim(descDataText));
                ansDiv.children('.form-group').append('<div class="question-action-buttons"><button id="save-short-desc" data-user-id="'+userId+'" class="save-short-desc">Save</button></div>');
                $(this).hide();


            });
            $("body").on("click", ".date-edit", function (e) {
                e.preventDefault();
                var userId = $('#profile-box-container').attr('data-user-id');
                var dateType = $(this).attr('data-date-type');
                var dateValue = $(this).attr('data-date-value');
                // DateEditModal


            });

            $('.DateEditModal').on('shown.bs.modal',function(e){
                var relatedPencil = e.relatedTarget;
                var userId = $('#profile-box-container').attr('data-user-id');
                var dateType = $(relatedPencil).attr('data-date-type');
                var dateTitle = $(relatedPencil).attr('data-date-title');
                var dateValue = $(relatedPencil).attr('data-date-value');
                $(this).find('#myModalLabel').text(dateTitle);
                $(this).find('#dateType').val(dateType);
                $(this).find('#edit_date').val(dateValue);
                //$('#edit_date').datepicker("setDate", new Date(dateValue));

            });
            $("body").on("click", "#saveDate", function (e) {
                e.preventDefault();
                var EditedDate = $(this).parents('.modal-content').find('#edit_date').val();
                var dateType = $(this).parents('.modal-content').find('#dateType').val();
                var userId = $('#profile-box-container').attr('data-user-id');
                var postData = {
                    userID: userId,
                    dateType: dateType,
                    EditedDate: EditedDate
                };
                $.ajax({
                    url: baseUrl + "admin/savedate",
                    data: postData,
                    type: "POST",
                    success: function(output) {
                       var data = output.split("::");
                       if(data[0].split(' ').join('') === "OK") {
                             location.reload();
                        }
                    }
                });

            });
            $("body").on("click", "#full-edit", function (e) {
                e.preventDefault();
               $('.profile-username').hide();
               $('.editable.fullname').show();
               $('.editable.fullname input').focus();

            });
            $( ".fullname" ).focusout(function() {
               var userId = $('#profile-box-container').attr('data-user-id');
               $('.profile-username').show();
               $('.editable.fullname').hide();
               var NewFullName = $('.editable.fullname input').val();
                var postData = {
                    userID: userId,
                    fullName: NewFullName
                };
                $.ajax({
                    url: baseUrl + "admin/updatename",
                    data: postData,
                    type: "POST",
                    success: function(output) {
                       var data = output.split("::");
                       if(data[0].split(' ').join('') === "OK") {
                           $('.profile-username b').text(NewFullName);
                        }
                    }
                });
            });
            $("body").on("click", "#web-edit", function (e) {
                e.preventDefault();
               $('.website-text').hide();
               $('.editable.website').show()
               $('#web-edit').hide();
               $('.editable.website input').focus();

            });
            $( "#web-input" ).focusout(function() {
               var userId = $('#profile-box-container').attr('data-user-id');
               $('.website-text').show();
               $('#web-edit').show();
               $('.editable.website').hide();
               var website = $('.editable.website input').val();
                var postData = {
                    userID: userId,
                    website: website
                };
                $.ajax({
                    url: baseUrl + "admin/updatewebsite",
                    data: postData,
                    type: "POST",
                    success: function(output) {
                       var data = output.split("::");
                       if(data[0].split(' ').join('') === "OK") {
                           $('.website-text').text(website);
                           $('.website-text').attr('href','http://'+website);
                        }
                    }
                });
            });
            $("body").on("click", "#company-edit", function (e) {
                e.preventDefault();
               $('.company-text').hide();
               $('.editable.company').show()
               $('.editable.company input').focus();

            });
            $("#company-input").focusout(function() {
               var userId = $('#profile-box-container').attr('data-user-id');
               $('.company-text').show();
               $('.editable.company').hide();
               var company = $('.editable.company input').val();
                var postData = {
                    userID: userId,
                    company: company
                };
                $.ajax({
                    url: baseUrl + "admin/updatecompany",
                    data: postData,
                    type: "POST",
                    success: function(output) {
                       var data = output.split("::");
                       if(data[0].split(' ').join('') === "OK") {
                           $('.company-text p').text(company);
                        }
                    }
                });
            });
            $("body").on("click", "#email-edit", function (e) {
                e.preventDefault();
               $('.email-text').hide();
               $('.editable.email').show()
               $('.editable.email input').focus();

            });
            $("#email-input").focusout(function() {
               var userId = $('#profile-box-container').attr('data-user-id');
               $('.email-text').show();
               $('.editable.email').hide();
               var email = $('.editable.email input').val();
                var postData = {
                    userID: userId,
                    email: email
                };
                $.ajax({
                    url: baseUrl + "admin/updateemail",
                    data: postData,
                    type: "POST",
                    success: function(output) {
                       var data = output.split("::");
                       if(data[0].split(' ').join('') === "OK") {
                           $('.email-text p').text(email);
                        }
                    }
                });
            });
            $("body").on("click", "#acn-edit", function (e) {
                e.preventDefault();
               $('.acn-text').hide();
               $('.editable.acn').show()
               $('.editable.acn input').focus();

            });
            $("#acn-input").focusout(function() {
               var userId = $('#profile-box-container').attr('data-user-id');
               $('.acn-text').show();
               $('.editable.acn').hide();
               var acn = $('.editable.acn input').val();
                var postData = {
                    userID: userId,
                    acn: acn
                };
                $.ajax({
                    url: baseUrl + "admin/updateacn",
                    data: postData,
                    type: "POST",
                    success: function(output) {
                       var data = output.split("::");
                       if(data[0].split(' ').join('') === "OK") {
                           $('.acn-text p').text(acn);
                        }
                    }
                });
            });
            $("body").on("click", "#ipAddress-edit", function (e) {
                e.preventDefault();
               $('.ipAddress-text').hide();
               $('.editable.ipAddress').show()
               $('.editable.ipAddress input').focus();
               var oldIpAddress = $(this).parents('.ipAddress-text').find('.text-muted').text();
                $('.editable.ipAddress input').val(oldIpAddress);

            });
            $("#ipAddress-input").focusout(function() {
               var userId = $('#profile-box-container').attr('data-user-id');
               $('.ipAddress-text').show();
               $('.editable.ipAddress').hide();
               var ipAddress = $('.editable.ipAddress input').val();
                var postData = {
                    userID: userId,
                    ipAddress: ipAddress
                };
                $.ajax({
                    url: baseUrl + "admin/updateip",
                    data: postData,
                    type: "POST",
                    success: function(output) {
                       var data = output.split("::");
                       if(data[0].split(' ').join('') === "OK") {
                           $('.ipAddress-text p').text(ipAddress);
                        }
                    }
                });
            });
            $("body").on("click", "#address-edit", function (e) {
                e.preventDefault();
               $('.address-text').hide();
               $('.editable.address').show()
                var streetNumber = $('.address-text span.street_number').text();
                var streetName   = $('.address-text span.street_name').text();
                var town         = $('.address-text span.town').text();
                var state        = $('.address-text span.state').text();
                var postCode     = $('.address-text span.post_code').text();
                $('.editable.address #street-number').val(streetNumber);
                $('.editable.address #street-name').val(streetName);
                $('.editable.address #town-input').val(town);
                $('.editable.address #state-input').val(state);
                $('.editable.address #post-input').val(postCode);

            });
            $("body").on("click", "#address-save", function (e) {
               var userId = $('#profile-box-container').attr('data-user-id');
               $('.address-text').show();
               $('.editable.address').hide();
                var address =  '';
                var streetNumber = $('.editable.address #street-number').val();
                var streetName   = $('.editable.address #street-name').val();
                var town         = $('.editable.address #town-input').val();
                var state        = $('.editable.address #state-input').val();
                var postCode     = $('.editable.address #post-input').val();
                var postData = {
                    userID: userId,
                    address: address,
                    address_street_number: streetNumber,
                    address_street_name: streetName,
                    address_town: town,
                    address_state: state,
                    address_post_code : postCode
                };
                $.ajax({
                    url: baseUrl + "admin/updateAddress",
                    data: postData,
                    type: "POST",
                    success: function(output) {
                       var data = output.split("::");
                       if(data[0].split(' ').join('') === "OK") {
                           $('.address-text .street').text(street);
                           $('.address-text .town').text(town);
                           $('.address-text .state').text(state);
                        }
                    }
                });
            });
            $("body").on("click", "#bsName-edit", function (e) {
                e.preventDefault();
               $('.bsName-text').hide();
               $('.editable.bsName').show()
               $('.editable.bsName input').focus();

            });
            $("#bsName-input").focusout(function() {
               var userId = $('#profile-box-container').attr('data-user-id');
               $('.bsName-text').show();
               $('.editable.bsName').hide();
               var bsName = $('.editable.bsName input').val();
                var postData = {
                    userID: userId,
                    bsName: bsName
                };
                $.ajax({
                    url: baseUrl + "admin/updatebsName",
                    data: postData,
                    type: "POST",
                    success: function(output) {
                       var data = output.split("::");
                       if(data[0].split(' ').join('') === "OK") {
                           $('.bsName-text p').text(bsName);
                        }
                    }
                });
            });

            $("body").on("click", ".save-sector", function (e) {
                e.preventDefault();
                var userId  = $('#profile-box-container').attr('data-user-id');
                var select  = $('.edit-sector select');
                var ansDiv  = $('.edit-sector');
                var answer  = $('.edit-sector select').val();
                var editText= $('.sector-text p');

                var postData = {
                    userID: userId,
                    answer: answer
                };
                $.ajax({
                    url: baseUrl + "admin/savesector",
                    data: postData,
                    type: "POST",
                    success: function (output) {
                        var data = output.split("::");
                        if (data[0].split(' ').join('') === "OK") {
                            ansDiv.slideUp('slow');
                            var newanswer  = $(".edit-sector select option:selected").text();
                            editText.text(newanswer);

                        }
                    }
                });
            });
            $("#resetThumbsUp").on("click", function () {
                var userId  = $('#profile-box-container').attr('data-user-id');
                var postData = {
                    userID: userId
                };
                $.ajax({
                    url: baseUrl + "admin/resetThumbsUp",
                    data: postData,
                    type: "POST",
                    success: function (output) {
                       var data = output.split("::");
                        if(data[0].split(' ').join('') === 'OK'){
                          $('.thumbsUp-container').find('p').text(0);
                        }
                    }
                });
            });
            $("#sector-edit").on("click", function (event) {
                event.preventDefault();
                var saveBtn = $('.save-sector');
                var userId  = $('#profile-box-container').attr('data-user-id');
                var select  = $('.edit-sector select');
                var ansDiv  = $('.edit-sector');
                var postData = {
                    userID: userId
                };
                saveBtn.parent().remove();
                $.ajax({
                    url: baseUrl + "admin/getsectors",
                    data: postData,
                    type: "POST",
                    success: function (output) {
                        var data = $.parseJSON(output);
                        select.html('');
                        $.each(data, function (index, value) {
                            select.append('<option value="' + value.id + '">' + value.sector + '</option>');
                        });
                        select.parent().append('<div class="sector-action-buttons"><button class="save-sector">Save</button></div>');
                        ansDiv.slideDown('slow');
                    }
                });
            });

            $('#edit-logo').change(function(event) {
                var input = $(this)[0];
                var userId  = $('#profile-box-container').attr('data-user-id');
                $('#loading-image-logo').show();
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var formData = new FormData();
                        formData.append('logo', input.files[0]);
                        formData.append('userID', userId);
                        $.ajax({
                                crossOrigin: true,
                                type: 'POST',
                                url: baseUrl + "admin/savelogo",
                                data: formData,
                                processData: false,
                                contentType: false
                        }).done(function (response) {
                            var data = response.split("::");
                            if(data[0].split(' ').join('') === 'OK'){
                                $('#loading-image-logo').hide();
                                $('#User-Logo').attr('src', e.target.result);
                            }else if(data[0].split(' ').join('') === 'FAIL'){
                                $('#loading-image-logo').hide();
                            }
                       });

                     };
                    reader.readAsDataURL(input.files[0]);
                }else{
                    $('#loading-image').hide();
                }
            });
            $('#edit-banner').change(function(event) {
                var input = $(this)[0];
                var userId  = $('#profile-box-container').attr('data-user-id');
                $('#loading-image-banner').show();
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var formData = new FormData();
                        formData.append('banner', input.files[0]);
                        formData.append('userID', userId);
                        $.ajax({
                                crossOrigin: true,
                                type: 'POST',
                                url: baseUrl + "admin/saveBannerImage",
                                data: formData,
                                processData: false,
                                contentType: false
                        }).done(function (response) {
                            var data = response.split("::");
                            if(data[0].split(' ').join('') === 'OK'){
                                $('#loading-image-banner').hide();
                                $('#User-banner').attr('src', e.target.result);
                            }else if(data[0].split(' ').join('') === 'FAIL'){
                                $('#loading-image-banner').hide();
                            }
                       });

                     }
                    reader.readAsDataURL(input.files[0]);
                }else{
                    $('#loading-image').hide();
                }
            });
            $('#edit-product').change(function(event) {
                var input = $(this)[0];
                var userId  = $('#profile-box-container').attr('data-user-id');
                $('#loading-image-product').show();
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var formData = new FormData();
                        formData.append('productImage', input.files[0]);
                        formData.append('userID', userId);
                        $.ajax({
                                crossOrigin: true,
                                type: 'POST',
                                url: baseUrl + "admin/saveProductImage",
                                data: formData,
                                processData: false,
                                contentType: false
                        }).done(function (response) {
                            var data = response.split("::");
                            if(data[0].split(' ').join('') === 'OK'){
                                $('#loading-image-product').hide();
                                $('#User-product').attr('src', e.target.result);
                            }else if(data[0].split(' ').join('') === 'FAIL'){
                                $('#loading-image-product').hide();
                            }
                       });

                     }
                    reader.readAsDataURL(input.files[0]);
                }else{
                    $('#loading-image').hide();
                }
            });

            $("#edit_date").daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'DD-MM-YYYY',
                }
            });
        });
