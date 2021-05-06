<?php echo $header; ?>
<style>
    /* added by */
    .btn-signin{
        background-color: #2c3e50;
        border-color: #2c3e50;
    }
    .btn-fb-signin a {
        color: #fff8f8;
    }
    .fa-facebook {
        margin-right: 10px;
    }
    body.login .panel-default>.panel-heading {
        background: #fff;
    }
    .panel-default {
        border-color: cornflowerblue;
    }
    .btn-success.active, .btn-success:active, .btn-success:hover, .open>.dropdown-toggle.btn-success {
        color: #fff;
        background-color: #1a242f;
        border-color: #161f29;
    }
    .login_logo{
        display: inline-block;
    }
    body .login-box-msg{
        padding:10px 0px;
    }
    body .login-box {
        max-width: 450px;
        width: 100%;
    }

    .btn-social i{
        width: 25px !important;
        line-height: 28px !important;
        font-size: 18px !important;
    }
    .btn-social {
        position: relative;
        padding-left: 44px;
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 3px 32px !important;
        border-radius: 3px !important;
        width: 116px !important;
        padding: 4px 0 0 44px!important; /*225*/
        margin-left: 37px;
    }
    /*span.btn.btn-block.btn-social.btn-google.btn-flat {*/
        /*margin: 0;*/
        /*width: 100% !important;*/
        /*text-align: center;*/
    /*}*/
    /*.btn-social>:first-child {*/
        /*position: absolute;*/
        /*left: 14px;*/
        /*top: 0;*/
        /*bottom: 0;*/
        /*width: 32px;*/
        /*line-height: 34px;*/
        /*font-size: 1.6em;*/
        /*text-align: center;*/
        /*border-right: 1px solid rgba(0,0,0,0.2);*/
    /*}*/
    /*.fb_css{*/
        /*width: 66% !important;*/
        /*padding: 2px  !important;*/
    /*}*/
    /*.fb_css2   {*/
        /*padding: 1px 0 0 40px !important;*/
    /*}*/
    @media (max-width: 768px){
        .btn-social {
            padding: 2px 26px !important;
            width: 107px !important;
        }
    }
    @media (max-width: 468px){
        .btn-social {
            padding: 2px 26px !important;
            width: 100px !important;
        }
    }
    @media (max-width: 430px){  /* custom css */
        .social-auth-links .col-xs-4  {
            width: 100%  !important;
        }
        .btn-block {
            display: inline-table !important;
        }
        .btn-social {
            padding: 2px 26px !important;
            width: 100px !important;
            margin-top: 15px;
        }
    }
</style>
<div class="container">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/AdminLTE.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?= base_url(); ?>assets/vendors/bootstrap/js/bootstrap.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="login-box">
                <div class="login-logo">
                    <a href="<?= BASE_URL; ?>"><img src="<?= BASE_URL; ?>/images/EsicLogoIcon.png" class="login_logo"
                                                    style="max-width: 350px;"/> ESIC Directory</a>
                </div><!-- /.login-logo -->
                <div class="login-box-body">
                    <div class="panel-heading">
                        <p class="login-box-msg">Sign in to start your session</p>
                        <p class="text-danger" id="invalid_user"></p>
                    </div>
                    <div class="panel-body">
                        <?php
                        if (isset($error)){
                            if ($error == "1"){
                                echo "<div class='alert alert-danger'>".$this->lang->line('login_incorrect')."</div>";
                            }
                        }
                        ?>
                        <form action="<?= base_url().'login/checked';?>" method="post">
                            <div class="row">
                                <div class="form-group">
                                    <label for="username">
                                        Username or Email
                                    </label>
                                    <?php
                                    $data = array(
                                        'name'        => 'username',
                                        'id'          => 'username',
                                        'class'       => 'form-control',
                                        'value'       => '',
                                        'placeholder' => $this->lang->line('login_username')
                                    );
                                    echo form_input($data); ?>
                                </div>
                                <div class="form-group">
                                    <label for="password">
                                        <?= $this->lang->line('login_password'); ?>:
                                    </label>
                                    <?php
                                    $data = array(
                                        'name'        => 'password',
                                        'id'          => 'password',
                                        'class'       => 'form-control',
                                        'value'       =>'',
                                        'placeholder' => $this->lang->line('login_password')
                                    );
                                    echo form_password($data);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="6LeX-IgUAAAAABvHQ0LIZ-vhQ6Gw5uOMSnZL2MAv"></div>
                                    <p id="emprecpcha" class="text-danger"></p>
                                </div>

                                <div class="form-group">
                                    <!--input type="submit" class="btn btn-primary btn-block btn-flat btn-signin" value="<?php echo $this->lang->line('login_signin'); ?>"-->
                                    <input type="button" id="ajax-sign-in" class="btn btn-primary btn-block btn-flat btn-signin"    value="<?php echo $this->lang->line('login_signin'); ?>">
                                </div>
                                <div class="form-group social-auth-links text-center">
                                    <p>- OR Sign In using </p>
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 " id="status" onclick="checkLoginState()">
                                            <fb:login-button class="fb_button"  style="width:100px" length="long" size="large" scope="public_profile,email" onlogin="checkLoginState()">
                                                <span>Facebook</span>
                                            </fb:login-button>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div id="gSignInWrapper">
                                                <div id="customBtn" class="customGPlusSignIn">
                                                      <span class=" btn btn-block btn-social btn-google btn-flat">
                                                          <i class="fa fa-google-plus"></i> Google+
                                                      </span>
                                                </div>
                                            </div>
                                            <div id="name"></div>
                                        </div>
<!--                                        <div class="col-xs-4 col-sm-4 col-md-4">-->
<!--                                            <a href="--><?//=base_url('login/twitterLogin')?><!--" class="btn btn-block btn-social btn-twitter btn-flat">-->
<!--                                                <i class="fa fa-twitter"></i> Twitter-->
<!--                                            </a>-->
<!--                                        </div>-->
                                    </div>
                                </div>
                                <div class="form-group other-actions">
                                    <a href="<?= BASE_URL; ?>/admin/reset_password/forgot" class="text-info">
                                        <?php echo $this->lang->line('login_reset'); ?>
                                    </a>
                                    <br>
                                    <a href="<?= BASE_URL; ?>/register" class="text-info">
                                        Don’t have an Account? Register Now
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div><!--Panel body -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?= ADMIN_THEME; ?>/js/jquery.js"></script>
<script src="<?= ADMIN_THEME; ?>/js/bootstrap.min.js"></script>
<script src="https://apis.google.com/js/api:client.js"></script>
<script type="text/javascript">

    $(document).ready(function($) {
//        window.setTimeout(function(){
//            $('body').find('._4z_b').addClass('fb_css');
//            $('body').find('._4z_6').addClass('fb_css2');
//            alert('css added');
//        },6000);

        $("#ajax-sign-in").on("click", function () {
            userLoginProcess();
        }); //End of Yes Approve Function
        $(document).on('keyup','#password', function(e){
            if(e.which == 13)
                userLoginProcess();
        })
        function userLoginProcess(){
            var username = $('#username').val();
            var password = $('#password').val();
            var g_cap_res = $('#g-recaptcha-response').val();
            var postData = {
                'username':username,
                'password':password,
                'g_cap_res':g_cap_res,
            }
            $.ajax({
                url: "<?= base_url().'login/checked';?>",
                data: postData,
                type: "POST",
                success: function (output){
                    var data = output.trim().split("::");
                    if (data[0].split(' ').join('') == 'OK') {
                        location.href = data[1];
                    }else if(data[0].split(' ').join('') == 'emprecpcha'){
                        grecaptcha.reset();
                        $("#emprecpcha").text(data[1]).fadeOut(7000);
                    }else if(data[0].split(' ').join('') == 'empty_fields'){
                        grecaptcha.reset();
                        $("#emprecpcha").text(data[1]).fadeOut(7000);
                    }else if(data[0].split(' ').join('') == 'invalid_user'){
                        grecaptcha.reset();
                        $("#emprecpcha").text(data[1]).fadeOut(7000);
                    }else if(data[0].split(' ').join('') == 'spammer'){
                        grecaptcha.reset();
                        $("#emprecpcha").text(data[1]).fadeOut(7000);
                    }
                }
            });
        }
    });
    /*********************************** Facebook login **********************************************/
    function statusChangeCallback(response) {
        if (response.status === 'connected') {
            testAPI();
        }
    }
    function checkLoginState() {
        FB.getLoginStatus(function (response) {
            statusChangeCallback(response);
        });
    }
    window.fbAsyncInit = function () {
        FB.init({
            appId: '292099794717258',
            cookie: true,
            xfbml: true,  // parse social plugins on this page
            version: 'v2.8' // use graph api version 2.8
        });
    };
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    function testAPI() {
        FB.api('/me',{ locale: 'en_US', fields: 'first_name,last_name, email' },function(response) {
            var user_data = JSON.stringify(response);
            $.ajax({
                url: "<?= base_url().'login/fbook';?>",
                data: {data:user_data},
                type: "POST",
                success: function (output){
                    var data = output.trim().split("::");
                    if (data[0].split(' ').join('') == 'OK') {
                        location.href = data[1];
                    }
                }
            });
        });
    }
    /*********************************** Google Login **********************************************/
    var googleUser = {};
    var startApp = function() {
        gapi.load('auth2', function(){
            auth2 = gapi.auth2.init({
                client_id: '434743946171-eh881rjhb4frhq5jkkk0gbtscb6vi7er.apps.googleusercontent.com',
                cookiepolicy: 'single_host_origin',
                //scope: 'additional_scope'
            });
            attachSignin(document.getElementById('customBtn'));
        });
    };
    function attachSignin(element) {
        auth2.attachClickHandler(element, {},
            function(googleUser) {
                var postDatas = {
                    'f_name': googleUser.getBasicProfile().getName(),
                    'l_name': googleUser.getBasicProfile().getFamilyName(),
                    'email':  googleUser.getBasicProfile().getEmail()
                }
                $.ajax({
                    url: "<?= base_url().'login/googlejslogins';?>",
                    data: postDatas,
                    type: "POST",
                    success: function (output){
                        var data = output.trim().split("::");
                        if (data[0].split(' ').join('') == 'OK') {
                            location.href = data[1];
                        }
                    }
                });
            }, function(error) {
                // alert(JSON.stringify(error, undefined, 2));
                console.log(JSON.stringify(error, undefined, 2));
            });
    }
    startApp();
    /********************** Google Code End ************************/
    

</script>


