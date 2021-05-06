

// footer code
jQuery("#demo-2").on('submit', function (e) {
    e.preventDefault();
    form_submit = jQuery("#demo-2");
    displayTOS(form_submit);
});
jQuery("#investor_header_search").on('submit', function (e) {
    e.preventDefault();
    form_submit = jQuery("#investor_header_search");
    displayTOS(form_submit);
});
function displayTOS(){
    jQuery(function($) {          //added for search header and searchliseting page pop up
        if (typeof(tosJSON) != "undefined" && tosJSON !== null) {
            var data_array = JSON.parse(tosJSON);
        } else {
            var data_array = '';
        }
        $.each(data_array, function(key, value) {
            var tos   = value.text;
            var modal = $('#tosModal');
            modal.find('#tosContent').html(tos);
            $('#tosModal').modal('show');
            var sec = 25;
            var timer = setInterval(function() {
                $('#timerFooter strong').text(sec--);
                if (sec == -1) {
                    modal.modal('hide');
                    clearInterval(timer);
                }
            }, 1000);
            modal.find('#agreeAndAccept').on('click', function(e) {
                e.stopPropagation();
                form_submit.off('submit').submit();
            });
        });
    });
}
$(".dropdown").on("click", function (e) {
    if($(this).parents().hasClass("header_search"))
    {
        jQuery('.header_search').find('.dropdown').toggleClass('open');
    }
});
$(".navbar-toggle.right-button").on("click", function () {
    jQuery('.navbar-collapse.right_sidebar').toggleClass(' c_collapsing');
});
$(".fa-angle-custom").on("click", function () {
    if(jQuery(this).parent('.dropdown').find('.collapse_open').length ) {
        jQuery(this).parent('.dropdown').find('.dropdown-menu').removeClass(' collapse_open');
        jQuery(this).parent('.dropdown').find('.dropdown-menu').addClass(' collapsing');
    }else{
        jQuery(this).parent('.dropdown').find('.dropdown-menu').addClass(' collapse_open');
        jQuery(this).parent('.dropdown').find('.dropdown-menu').removeClass(' collapsing');
    }
});
$(".panel-heading").on("click", function (e) {
    e.preventDefault();
    if(jQuery(this).parent('.panel.panel-default.bootstrap-accordion').find('.in').length ){
        jQuery(this).parent('.panel.panel-default.bootstrap-accordion').find('.panel-collapse').toggleClass(' accordion_c_collapsing');
    }
});

jQuery(document).ready(function($){ // subscription code
//        setTimeout(function(){
//            $('.ytp-title').css('display','none important');
//            alert('haahh');
//
//        }, 8000);

    function setCookie(key, value) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (5 * 24 * 60 * 60 * 1000));
        document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
    }
    function getCookie(key) {
        var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
        return keyValue ? keyValue[2] : null;
    }
    if(getCookie('visted') != 'yes' ){
        setTimeout(function(){
            jQuery('#subscribe').modal('show');
            jQuery('#subscribe').css({'display': 'block','opacity': '1' });
        }, 40000);
    }
    $(document).on('click','.SUBSCRIBE',function(){//when user click on subscribe button
        jQuery('#subscribe').modal('show');
        jQuery('#subscribe').css({'display': 'block','opacity': '1' });
    });
    $(document).on('click','.close_subscribe', function(e){
        jQuery('#subscribe').modal('hide');
        jQuery('#subscribe').css({'display': 'none','opacity': '0' });
        setCookie('visted','yes');
    });
    $(document).on('click','.subscribe', function(e){//when user submit form
        e.preventDefault();
        var email = $(this).siblings('#sub_email').val();
        var email2 = $(this).siblings('#email').val();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(regex.test(email)===false){
            Haider.notification('Please enter a valid email address','error','Something Wrong ');
        }else{
            if(email!='' && email2==''){
                $.ajax({
                    url:base_url+'Admin/subscribe/add',
                    type:"POST",
                    data:{email: email,email2:email2},
                    success:function(output){
                        setCookie('visted','yes');
                        jQuery('#subscribe').modal('hide');
                        var data = output.split("::");
                        Haider.notification(data[1],'success','Thank You ');
                    }
                });
            }
        }
    });
    var user_name_pop =  jQuery('.user_name_pop').text();
    if(user_name_pop == 'ok'){
        var hi_name = jQuery('.user_name_pop').attr('id');
        //jQuery('#user_guide_Modal').find('.modal-title').text('Hi '+hi_name+'!  Welcome Back');
        jQuery('#user_guide_Modal').find('.modal-title').text('Hi!  Welcome Back');
        jQuery('#user_guide_Modal').css({'opacity':5,"display":"block","background": "rgba(0,0,0,0.5)"});
        jQuery('#user_guide_Modal').modal('show');
    }

});
jQuery(document).on('click','.close',function(){
    jQuery('.closed').modal('hide');
});
jQuery(document).on('click','.closed',function(){
    jQuery('#user_guide_Modal').modal('hide');
});
jQuery(document).ready(function($){ // change layout search page
    $("#gridviews").click(function(e){
        e.preventDefault();
        $(".change_layout").addClass('col-md-4');
        $(".change_layout").removeClass('col-md-12');
    });
    $("#listviews").click(function(e){
        e.preventDefault();
        $(".change_layout").addClass('col-md-12');
        $(".change_layout").removeClass('col-md-4');
    });

    $('[data-toggle="tooltip"]').tooltip();
});

// lazy image load script   added by hamid.creativetech@gmail.com

document.addEventListener("DOMContentLoaded", function() {
    var lazyloadImages = document.querySelectorAll("img.lazy");
    var lazyloadThrottleTimeout;

    function lazyload () {
        if(lazyloadThrottleTimeout) {
            clearTimeout(lazyloadThrottleTimeout);
        }

        lazyloadThrottleTimeout = setTimeout(function() {
            var scrollTop = window.pageYOffset;
            lazyloadImages.forEach(function(img) {
                if(img.offsetTop < (window.innerHeight + scrollTop)) {
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                }
            });
            if(lazyloadImages.length == 0) {
                document.removeEventListener("scroll", lazyload);
                window.removeEventListener("resize", lazyload);
                window.removeEventListener("orientationChange", lazyload);
            }
        }, 20);
    }

    document.addEventListener("scroll", lazyload);
    window.addEventListener("resize", lazyload);
    window.addEventListener("orientationChange", lazyload);
});


<!-- BEGIN JIVOSITE CODE {literal}  by Fahad Bahi -->
(function(){ var widget_id = 'fI9fhdBvJg';var d=document;var w=window;function l(){
    var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;
    s.src = '//code.jivosite.com/script/widget/'+widget_id
    ; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}
    if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}
    else{w.addEventListener('load',l,false);}}})();
<!-- {/literal} END JIVOSITE CODE -->

function init() {
    var vidDefer = document.getElementsByTagName('iframe');
    for (var i=0; i<vidDefer.length; i++) {
        if(vidDefer[i].getAttribute('data-src')) {
            vidDefer[i].setAttribute('src',vidDefer[i].getAttribute('data-src'));
        } } }
window.onload = init;

//code estimator page
function IsEmail(email) {
    var re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    if(!re.test(email)) {
        return false;
    }else{
        return true;
    }
}
jQuery(document).on('click','.estimatorbtn',function(e){
    e.preventDefault();
    var Email2 = $('#Email2').val();
    if(Email2){
        Haider.notification('You are a robot', 'error','Error');
        return false;
    }
    var fname  = $('#fname').val();     
    if(fname===''){
        Haider.notification('Please enter First Name', 'error','Error');
        return false;
    }
    var NameLast = $('#lname').val();
    var email = $('#Email').val();
    if(email==='' || IsEmail(email)===false){
        Haider.notification('Please enter a valid email', 'error','Error');
        return false;
    }
    $.ajax({
        url: baseUrl + "estimator/submit",
        data: {'FirstName':fname,'LastName':NameLast,'email':email,'ControllerName':'Esic'},
        type: "POST",
        success: function (output) {

            if(output.indexOf('FAIL') !== -1){
                $('.modal-title').html("Email Already Exist");
                $('.result_content').html("Sorry You Cannot Use this Email!<br>" +
                    "If this is your email address please <a href='"+baseUrl+"login' style='color:blue;font-size:18px'><strong>Login</strong></a>");
                $('#result_modal').modal('show');
                return false;
            }
            $('#estimatorbtnform').remove();
            $('.row.wrap p').last().text();
            $('.row.wrap p').last().html("<span style='font-size: 14px;' data-mce-style='font-size: 14px;'> All fields marked with * are mandatory.</span>");
            $('.questionwrap').css({"display":"block"});
        }
    });
});

$(document).ready(function(){
    if($(".date_picker").length>0){$('.date_picker').datepicker({format:'dd-mm-yyyy',autoclose: true,});}
    //$('.questionwrap').css({"display":"block"}); // remove this line after completing Questions test
});

// Create Estimator result


function early_stage_fail_message(){
    $('.result_content').text(' ');
    var contactus = baseUrl + "contact.html"
    $('.result_content').html("Please <a href="+contactus+" target='_blank' style='font-size: 14px'><b> contact us</b> </a> for assistance.");
    $('#result_modal').modal('show');
}

// save users answers

function save_user_ans(Qid,ans){
    if(ans =='' && ans == 'undefined' && ans == 'null' ) return false;
    if(Number.isInteger(Qid) === false ) return false;
    $.ajax({
        url: baseUrl + "estimator/save_answers",
        data: {Qid:Qid,ans:ans},
        type: "POST",
        success: function (output) {
            if(output){
               // var data = JSON.parse(output);
               //  if(data == 'ok' ){
               //  }else{
               //  }
            }
        }
    });
}
jQuery(document).on('click','input',function(e){
    var Qid = $(this).parents('.Questions').data('id');
    if($(this).attr('type') == 'checkbox'){
        var ans = $(this).prop("checked") ? $(this).val() : 0;
    }else{
        var ans = $(this).val();
    }
    save_user_ans(Qid,ans);
});


//$('.date_picker').focusout( function(ev){
$('.date_picker').on('changeDate', function(e) {
    if($(this).parent().closest('div').find('.errors').length > 0){
        $(this).parent().closest('div').find('.errors').remove();
    }
    var Qid = $(this).parents('.Questions').data('id');
    var corporate_date = $(this).val();
    if(corporate_date.length < 10 ) return false;
    $.ajax({
        url: baseUrl + "estimator/incorporated",
        data: {'corporate_date':corporate_date},
        type: "POST",
        success: function (output) {
            if(output){
                var data = JSON.parse(output);
                save_user_ans(Qid,corporate_date);
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
$('.innovalue').change(function(){
    var total = 0;
    if($(this).attr('data-type') == "RandD"){
        $('input.RandD').not(this).prop('checked', false);
    }
    if($(this).attr('data-type')=="IP"){
        $('input.IP').not(this).prop('checked', false);
    }
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









//End  estimator page Code

//started code for Audit Assistant Tool 

function appraisal(){
    var alternate ='';
    var method ='';
    alternate = $('input[name="alternate"]:checked').val();
    method = $('input[name="method"]:checked').val();
    $('.test').addClass('hidden');
    if(alternate == 'best'){
        $('.estbest').removeClass('hidden');
        if(method =='points'){
            $('.pobtbest').removeClass('hidden')
        }else if(method =='principal'){
            $('.prbtbest').removeClass('hidden')
        }
    }else if(alternate == 'alternate'){
        $('.estalternate').removeClass('hidden');
        if(method =='points'){
            $('.pobtalternate').removeClass('hidden')
        }else if(method =='principal'){
            $('.prbtalternate').removeClass('hidden')
        }
    }else if(alternate == 'fall'){
        $('.estfall').removeClass('hidden');
        if(method =='points'){
            $('.pobtfall').removeClass('hidden')
        }else if(method =='principal'){
            $('.prbtfall').removeClass('hidden')
        }
    }
}
function redirect_to(method,alternate){
    if(method =='points' && alternate == 'best' ){
        window.location.href =  baseUrl + "points-method-best-available.html";
    }else if(method =='points' && alternate == 'alternate' ){
        window.location.href =  baseUrl + "points-method-alternate.html";
    }else if(method =='points' && alternate == 'fall' ){
        window.location.href =  baseUrl + "points-method-fall.html";
    }else if(method =='principal' && alternate == 'best' ){
        window.location.href =  baseUrl + "principal-method-best-available.html";
    }else if(method =='principal' && alternate == 'alternate' ){
        window.location.href =  baseUrl + "principal-method-alternate.html";
    }else if(method =='principal' && alternate == 'fall' ){
        window.location.href =  baseUrl + "principal-method-fall.html";
    }else{

    }
}
$(document).on("click",'.proceeds_btn',function(){
    var alternate = $('input[name="alternate"]:checked').val();
    if(alternate){
        var method = $('input[name="method"]:checked').val();
        redirect_to(method,alternate);
    }
})
$(document).on("click",'.toogle_me',function(e){
    e.preventDefault();
    var alternate = $(this).attr('data-id');
    var method    = $('input[name="selected_options"]:checked').val();
    redirect_to(method,alternate);

});


function ReDirecttoPage(){
    var alternate = $('input[name="alternate"]:checked').val();
    if(alternate){
        var method = $('input[name="method"]:checked').val();
        setTimeout(function(){
            redirect_to(method,alternate);
        },25000);
    }
}

$(document).ready(function(){
    //$('.actions').addClass('hidden');
   // $('.alternative').addClass('hidden');
    // if(!window.popupShown) {
    //     setTimeout(function(){
    //         $('#TimedPopupWarning ').modal('show');
    //         window.popupShown = true;
    //     },20000);
    // }
});
$(document).on('change','input[name="method"]',function(){
    $('.alternative').removeClass('hidden');
    //appraisal();
    ReDirecttoPage();
});
$(document).on('change','input[name="alternate"]',function(){
    $('.testheading').removeClass('hidden');
    $('.proceeds_btn').removeClass('hidden');
    
   // $('.actions').removeClass('hidden');
    //$('.actions ul li:nth-child(2)').removeClass('hidden');
   // appraisal();
    ReDirecttoPage();
});

// $(document).on('click','.actions ul li:nth-child(2)',function() {
//     // var alternate = $('input[name="alternate"]:checked').val();
//     // if(alternate){
//     //     $('.actions ul li:nth-child(2)').removeClass('hidden');
//     // }else{
//     //     $('.actions ul li:nth-child(2)').addClass('hidden');
//     // }
//
//     // if(!window.popupShown) {
//     //     setTimeout(function(){
//     //         $('#TimedPopupWarning ').modal('show');
//     //         window.popupShown = true;
//     //     },10000);
//     // }
// });
// $(document).on('click','.actions ul li:nth-child(1)',function(){
//     $('.actions ul li:nth-child(2)').removeClass('hidden');
// });










