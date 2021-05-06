<div class="modal preeeeeeeeeeeeeeeeee" id="PreeeView">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-primary mright" data-dismiss="modal" aria-label="Close">Close</button>
            </div>

        </div>
    </div>

</div>

<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function() { //Load after the page is fully loaded.
        $(document).ready(function ($) {
            $('#step-reg').click(function (event) {
                event.preventDefault();
                $('.steps').slideUp('slow');
                $('.steps-layout a').removeClass('active');
                $(this).addClass('active');
                $('#step-registration').slideDown('slow');
            });
            $('#step-sub').click(function (event) {
                event.preventDefault();
                $('.steps').slideUp('slow');
                $('.steps-layout a').removeClass('active');
                $(this).addClass('active');
                $('#step-submission').slideDown('slow');
            });
            $('#step-sub-after-login').click(function (event) {
                event.preventDefault();
                $('.steps').slideUp('slow');
                $('.steps-layout a').removeClass('active');
                $(this).addClass('active');
                $('#step-submission').slideDown('slow');
            });
            $('#step-cho').click(function (event) {
                event.preventDefault();
                $('.steps').slideUp('slow');
                $('.steps-layout a').removeClass('active');
                $(this).addClass('active');
                $('#step-choose').slideDown('slow');
            });
            $('#backToShow').click(function (event) {
                event.preventDefault();
                $('.steps').slideUp('slow');
                $('.steps-layout a').removeClass('active');
                $('#step-cho').addClass('active');
                $('#step-choose').slideDown('slow');
            });
            $('#step-page').click(function (event) {
                event.preventDefault();
                var listID = $('#listingIDHidden').val();
                //listID = 225;
                var win;
                var dataPost = {listingID: listID};
                $.ajax({
                    url: base_url + '<?= $ControllerRouteName;?>/OpenPageBuilder',
                    type: 'POST',
                    async: false,
                    data: dataPost,
                    success: function (output) {
                        var data = output.trim().split('::');
                        if (data[0].split(' ').join('') === 'OK') {
                            var urlRe = base_url + '<?= $ControllerRouteName;?>/OpenPageBuilder/' + listID;
                            var width = window.innerWidth * 0.88;
                            // define the height in
                            var height = width * window.innerHeight / window.innerWidth;
                            // Ratio the hight to the width as the user screen ratio
                            win = window.open(urlRe, 'Page Builder <?= $ControllerRouteName;?>', 'width=' + width + ', height=' + height + ', top=' + ((window.innerHeight - height) / 2) + ', left=' + ((window.innerWidth - width) / 2));
                            win.focus();
                            // Write some text in the new window

                        } else if (data[0].split(' ').join('') === 'FAIL') {
                            Haider.notification(data[1], data[2]);
                        }
                    }
                });
                $('.steps-layout a').removeClass('active');
                $(this).addClass('active');
            });
            /*$('#step-page2').click(function(event){
             event.preventDefault();
             //  $('.steps').slideUp('slow');
             $('.steps-layout a').removeClass('active');
             $(this).addClass('active');
             // $('#step-pageBuilder').slideDown('slow');
             });*/
            $('#step-question').click(function (event) {
                event.preventDefault();
                $('.steps').slideUp('slow');
                $('.steps-layout a').removeClass('active');
                $(this).addClass('active');
                $('#step-questionnaire').slideDown('slow');
            });

            $('#getQuestionnaire').click(function (event) {
                event.preventDefault();
                $('.steps').slideUp('slow');
                $('.steps-layout a').removeClass('active');
                $('#step-question').addClass('active');
                $('#step-questionnaire').slideDown('slow');
            });
            var width = window.innerWidth * 0.88;
            var height = width * window.innerHeight / window.innerWidth;

            $('#getPageBuilder').click(function (event) {
                var listID = $('#listingIDHidden').val();
                var dataPost = {listingID: listID};
                $.ajax({
                    url: base_url + '<?= $ControllerRouteName;?>/OpenPageBuilder',
                    type: 'POST',
                    async: false,
                    data: dataPost,
                    success: function (output) {
                        var data = output.trim().split('::');
                        if (data[0].split(' ').join('') === 'OK') {
                            var urlRe = base_url + '<?= $ControllerRouteName;?>/OpenPageBuilder/' + listID;
                            var win = window.open(urlRe, 'newwindow', 'width=' + width + ', height=' + height + ', top=' + ((window.innerHeight - height) / 2) + ', left=' + ((window.innerWidth - width) / 2));
                            win.focus();
                        } else if (data[0].split(' ').join('') === 'FAIL') {
                            Haider.notification(data[1], data[2]);
                        }
                    }
                });
                $('.steps-layout a').removeClass('active');
                $(this).addClass('active');
            });

            $('#getUserAccountSection').click(function (event) {
                event.preventDefault();
                $('.steps').slideUp('slow');
                $('.steps-layout a').removeClass('active');
                $('#step-reg').addClass('active');
                $('#step-registration').slideDown('slow');
            });
            $(document).on('click', '#preview-content, #quickPreview', function (event) {
                event.preventDefault();
                if($(this).attr('id') == 'preview-content'){
                    formSubmit();
                    var uID = $('#listingPageContentID').val();
                    var descContent = $('#desc-content').val();
                } else {
                    var secondid = $(this).attr('id');
                    var uID = $('#listingIDHidden').val();
                    var descContent = JSON.stringify({"data": new Array()});
                }
                var dataPost = {listingID: uID, 'desc-content': descContent, template: 1};
                $.ajax({
                    url: base_url + 'admin/<?= $ControllerRouteName;?>/getPreview',
                    type: 'POST',
                    data: dataPost,
                    success: function (output) {
                        if(secondid =='quickPreview'){
                            $('#PreeeView .modal-body').html(output);
                            $('#PreeeView').modal('show');
                            // set inner modal an additional class for close button, so it will not close the outer modal when click
                            $('#PreeeView').find('#addressEditModal').find('button[data-dismiss="modal"]').removeAttr('data-dismiss').addClass('inner-close');
                        }else {
                            output = jQuery.parseJSON(output);
                            $('#page-builder-preview-content').html(output.long_description);
                            $('#desc-edit-modal').modal('hide');
                            $('#content-modal').modal('show');
                        }
                    }
                });
            });
            $('.close-preview').click(function (event) {
                event.preventDefault();
                $('#content-modal').modal('hide');
                $('#desc-edit-modal').modal('show');
            });
            $('#save-content').click(function (event) {
                event.preventDefault();
                formSubmit();
                var uID = $('#listingPageContentID').val();
                var descContent = $('#desc-content').val();
                var dataPost = {
                    listingID: uID,
                    'desc-content': descContent
                };
                $.ajax({
                    url: base_url + 'admin/<?= $ControllerRouteName;?>/savedesc',
                    type: 'POST',
                    data: dataPost,
                    success: function (output) {
                        var data = output.trim().split('::');
                        if (data[0].split(' ').join('') === 'OK') {
                            Haider.notification(data[1], data[2]);
                            $('#desc-edit-modal').modal('hide');
                            $('.steps').slideUp('slow');
                            $('.steps-layout a').removeClass('active');
                            $('#step-cho').addClass('active');
                            $('#step-choose').slideDown('slow');
                            $('#getPageBuilder').addClass('active');
                            $('.check-your-email').css('color', 'red');
                        } else if (data[0].split(' ').join('') === 'FAIL') {
                            Haider.notification(data[1], data[2]);
                        }
                    }
                });
            });

            $('#getRegister').click(function (event) {
                event.preventDefault();
                var FormDataToSent = {};
                var $g_cap_res = $('#g-recaptcha-response').val();
                var FirstName = $('input[name="FirstName"]').val();
                var LastName = $('input[name="LastName"]').val();
                //var Phone       = $('input[name="UserPhone"]').val();
                var email = $('input[name="email"]').val();
                if (FirstName.length > 2 && email.length > 2) {
                    FormDataToSent['g_cap_res'] = $g_cap_res;
                    FormDataToSent['FirstName'] = FirstName;
                    FormDataToSent['LastName'] = LastName;
                    //FormDataToSent['Phone']     = Phone;
                    FormDataToSent['email'] = email;
                    <?php if(!empty($ControllerRouteName)){ ?>
                    FormDataToSent['ControllerName'] = '<?= $ControllerRouteName;?>';
                    <?php } ?>
                    $.ajax({
                        url: base_url + 'User/New',
                        type: 'POST',
                        data: FormDataToSent,
                        success: function (output) {
                            var data = output.trim().split('::');                           
                            if (data[0].split(' ').join('') === 'OK' && data[3].split(' ').join('') === 'OK') {
                                Haider.notification(data[4],data[5]);                                
                                var userID = data[6];
                                $('#userIDHidden').val(userID);
                                $('.steps').slideUp('slow');
                                $('.steps-layout a').removeClass('active');
                                $('#step-sub').addClass('active');
                                $('#step-submission').slideDown('slow');
                            }else if(data[3].split(' ').join('') == 'emprecpcha'){
                                grecaptcha.reset();
                                $("#emprecpcha").text(data[4]).fadeOut(7000);
                            }else if(data[3].split(' ').join('') == 'spammer'){
                                grecaptcha.reset();
                                $("#emprecpcha").text(data[4]).fadeOut(7000);
                            }else if (data[0].split(' ').join('') === 'FAIL') {
                                Haider.notification(data[1], 'Error','error');
                                if(data[3] === "estmatorFAIL"){
                                    $('#EmailBox').attr("readonly",false);
                                }
                            }
                        }
                    });
                } else {
                    Haider.notification('Please Fill Required Fields', 'error');
                    return null;
                }
            });
            $('#SaveListing').click(function (event) {
                event.preventDefault();
                var FormDataToSent = getFieldValuesForJson();
                if (typeof FormDataToSent == 'object' && FormDataToSent != null) {
                    $.ajax({
                        url: base_url + '<?= $ControllerRouteName;?>/New',
                        type: 'POST',
                        data: FormDataToSent,
                        success: function (output) {
                            var data = output.trim().split('::');
                            if (data[0].split(' ').join('') === 'OK') { console.log('here we go');
                                Haider.notification(data[1], data[2]);
                                var listingID = data[3];
                                $('#listingIDHidden').val(listingID);
                                $('#listingPageContentID').val(listingID);
                                $('.steps').slideUp('slow');
                                $('.steps-layout a').removeClass('active');
                                $('#step-cho').addClass('active');
                                $('#step-choose').slideDown('slow');
                                // preview button
                                if(typeof data[4] != 'undefined'){
                                    $('.previewList').html('<a href="#" id="quickPreview" class="btn btn-block btn-flat btn-primary">Preview</a>')
                                }
                            } else if (data[0].split(' ').join('') === 'FAIL') {
                                Haider.notification(data[1], data[2]);
                            }
                        }
                    });
                }
            });

            $('input[name="email"]').on('change', function () {
                var email = this.value;
                var $this = $('input[name="email"]');
                var postData = {
                    email: email
                }
                if (validatedEmail(email)) {
                    $.ajax({
                        url: base_url + 'admin/<?=$ControllerRouteName;?>/emailcheck',
                        type: 'POST',
                        data: postData,
                        success: function (output) {
                            var data = output.trim().split('::');
                            if (data[0].split(' ').join('') === 'OK') {
                                $this.removeClass('error');
                                $this.parent().parent().children('label').removeClass('error');
                                Haider.notification(data[1], data[2]);
                            } else if (data[0].split(' ').join('') === 'FAIL') {
                                $this.addClass('error');
                                $this.parent().parent().children('label').addClass('error');
                                Haider.notification(data[1], data[2]);
                            }
                        }
                    });
                } else {
                    Haider.notification('Email Not Valid', 'error');
                }
            });
        });
    });
        function parentWindowConfigurations() {
            $('.steps').slideUp('slow');
            $('.steps-layout a').removeClass('active');
            $('#step-cho').addClass('active');
            $('#step-choose').slideDown('slow');
            $('#getPageBuilder').addClass('active');
            $('.check-your-email').css('color', 'red');
        }

    // when click on inner modal close button
    $(document).on('click','.inner-close', function(e){
        e.preventDefault();
        $('#addressEditModal').modal('toggle');
        $('#PreeeView').css('overflow-y','scroll');
    })

</script>

