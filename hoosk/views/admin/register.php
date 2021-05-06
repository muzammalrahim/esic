<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="google-site-verification" content="zGSppNJw32j9csHV6Gud68Zu2XFMTmC4iJAmWp4jnAE" />
    <meta name="google-site-verification" content="_vy9LJ9ApadtjgIHkHAi3jC5N3bLE3xY3wEcNy4T0vU" />
    <meta name="msvalidate.01" content="A4D0420422D7D432385D8B3F3B04D7DD" />
    <meta name="google-site-verification" content="4miCnvPw5bak9jdkCsQXhsU4rLeMrKWKUdSZ7nsXCCc" />
    <meta name="google-site-verification" content="r7NkuHK_4mdpYFPGhp4psqU3ywNxHOVb7xYSKfyYCCg" />
    <meta name="google-site-verification" content="4miCnvPw5bak9jdkCsQXhsU4rLeMrKWKUdSZ7nsXCCc" />


    <title>Sign up</title>
    <meta name="description"    content="<?= $page['pageDescription']; ?> " />
    <meta name="keywords"       content="<?= $page['pageKeywords']; ?>" />
    <meta name="viewport"       content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<?php //echo // $header; ?>
<?php
$userName  = '';
$FirstName = '';
$LastName  = '';
$Email     = '';
$Phone     = '';
if(isset($userData) && !empty($userData)) {
    $userName   = $userData['Username'];
    $FirstName  = $userData['FirstName'];
    $LastName   = $userData['LastName'];
    $Email      = $userData['Email'];
    $Phone      = $userData['Phone'];
}



?>
<style>
    .container .checkbox {
        /* float: left; */
        -ms-transform: scale(1);
        -moz-transform: scale(1);
        -webkit-transform: scale(1);
        -o-transform: scale(1);
        padding: 0px 15px;
    }
    .register-box .register-logo {
    }
    .register-box-body , .register-box-body form {
        margin-bottom:0px;
    }
    body {
        background: #d2d6de !important;
    }
    body .form-control-feedback {
        right: 10px;
    }
    .has-feedback .form-control {
        font-size: 12px;
    }
    .message-response li, .message-response p{
        color:red;
    }
    body .register-box {
        max-width: 550px;
        width: 100%;
    }
    .login-box-msg{
        font-size:17px;
    }

    @media (max-width: 768px){
        body a.btn , body button.btn{
            margin:5px 0px;
        }
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
        width: 130px !important;
    }
    div#gSignInWrapper {
        text-align: center !important;
        margin-left: 50px;
    }
    @media (max-width: 992px){
        .btn-block {
            display: inline-block !important;
        }
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendors/bootstrap/css/bootstrap.min.css">
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
            <div class="register-box">
                <div class="login-logo register-logo">
                    <a href="<?= BASE_URL; ?>">
                        <img src="<?= BASE_URL; ?>/images/EsicLogoIcon.png" class="login_logo"
                             style="max-width: 350px;"/> Esic Directory
                    </a>
                </div>
                <div class="register-box-body">
                    <p class="login-box-msg">One account to manage all your Esic Directory services</p>
                    <div class="message-response">
                        <?php if(isset($messages) && !empty($messages)){
                            echo '<ul>';
                            foreach($messages as $message){
                                echo '<li>'.$message.'</li>';
                            }
                            echo '</ul>';
                        } ?>
                        <?php echo validation_errors(); ?>
                        <?php // show login link if email already exist
                        if($login_link) echo '<a style="margin:3px 0" href="'.BASE_URL.'/login" class="btn btn-primary btn-flat">Login</a>';
                        ?>
                    </div>
                    <form action="<?= base_url().'Register/createmember';?>" method="post">
                        <div class="row">
                            <!--div class="form-group has-feedback col-md-12">
                                <input type="text" class="form-control" name="Username" placeholder="Username" value="<?=$userName;?>">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div-->
                            <div class="form-group has-feedback col-md-6">
                                <input type="text" class="form-control" name="FirstName" placeholder="First Name" value="<?=$FirstName;?>">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <!--div class="form-group has-feedback col-md-6">
                                <input type="text" class="form-control" name="LastName" placeholder="Last Name" value="<?=$LastName;?>">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div-->
                            <div class="form-group has-feedback col-md-6">
                                <input type="email" class="form-control" name="Email" placeholder="Email" value="<?=$Email;?>">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                            <!--div class="form-group has-feedback col-md-6">
                                <input type="number" class="form-control" name="Phone" placeholder="Phone" value="<?=$Phone;?>">
                                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                            </div-->
                            <!--div class="form-group has-feedback col-md-6">
                                <input type="password" class="form-control" name="Password" placeholder="Password">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback col-md-6">
                                <input type="password" class="form-control" name="Repassword" placeholder="Retype password">
                                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                            </div-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="6LeX-IgUAAAAABvHQ0LIZ-vhQ6Gw5uOMSnZL2MAv"></div>
                                    <p id="emprecpcha" class="text-danger"></p>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <div class="checkbox icheck">
                                        <label>
                                            <input type="checkbox" name="terms" checked> I agree to the <a target="_blank" href="<?= BASE_URL; ?>/terms-of-uses">terms & conditions</a>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <button type="submit" id="ajax-sign-up" class="btn btn-primary btn-block btn-flat">Register</button>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <a href="<?= BASE_URL; ?>/login" class="btn btn-primary btn-block btn-flat text-center">
                                        Have An Account ?
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="social-auth-links text-center">
                        <p>- OR Sign up using - </p>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-6">
                                <fb:login-button class="fb_button"  style="width:100px" length="long" size="large" scope="public_profile,email" onlogin="checkLoginState()">
                                    <span>Facebook</span>
                                </fb:login-button>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-6">
                                <div id="gSignInWrapper">
                                    <div id="customBtn" class="customGPlusSignIn">
                                      <span class=" btn btn-block btn-social btn-google btn-flat">
                                          <i class="fa fa-google-plus"></i> Google+
                                      </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="<?php echo ADMIN_THEME; ?>/js/jquery.js">
</script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo ADMIN_THEME; ?>/js/bootstrap.min.js">
</script>
<script src="https://apis.google.com/js/api:client.js"></script>
<script type="text/javascript">



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
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        function testAPI() {
            FB.api('/me', {locale: 'en_US', fields: 'first_name,last_name, email'}, function (response) {
                var user_data = JSON.stringify(response);
                $.ajax({
                    url: "<?= base_url() . 'login/fbook';?>",
                    data: {data: user_data},
                    type: "POST",
                    success: function (output) {
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
        var startApp = function () {
            gapi.load('auth2', function () {
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
                function (googleUser) {
                    var postDatas = {
                        'f_name': googleUser.getBasicProfile().getName(),
                        'l_name': googleUser.getBasicProfile().getFamilyName(),
                        'email': googleUser.getBasicProfile().getEmail()
                    }
                    $.ajax({
                        url: "<?= base_url() . 'login/googlejslogins';?>",
                        data: postDatas,
                        type: "POST",
                        success: function (output) {
                            var data = output.trim().split("::");
                            if (data[0].split(' ').join('') == 'OK') {
                                location.href = data[1];
                            }
                        }
                    });
                }, function (error) {
                    // alert(JSON.stringify(error, undefined, 2));
                    console.log(JSON.stringify(error, undefined, 2));
                });
        }

        startApp();
        /********************** Google Code End ************************/

</script>
</body>
</html>