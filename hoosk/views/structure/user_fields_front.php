
<?php

if(isset($CurrentUserData) && !empty($CurrentUserData)){
    $ReadyOnlyFlag   = 'readonly';
    $userRole        = $CurrentUserData['userRole'];
    $Username        = $CurrentUserData['userName'];
    $UserEmail       = $CurrentUserData['Email'];
    $FirstName       = $CurrentUserData['firstName'];
    $LastName        = $CurrentUserData['lastName'];
    $UserPhone       = $CurrentUserData['phone'];
    if(isset($CurrentUserData['loginType'])){
        $loginType = $CurrentUserData['loginType'];
    }else{
        $loginType = '';
    }
}else{
    $ReadyOnlyFlag = '';
    $Username   = '';
    $UserEmail  = '';
    $FirstName  = '';
    $LastName   = '';
    $UserPhone  = '';
    $loginType = '';
}
?>
<style>
    .g-recaptcha {
        margin-left: 20px;
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
        width: 122px !important;
    }
    

</style>
<script src='https://www.google.com/recaptcha/api.js'></script>
<?php

$RegButtonLabel = 'Register';
if(isUserLoggedIn($this)){
    $RegButtonLabel = 'Next';
}
$HTTP_REFERER = $_SERVER['HTTP_REFERER'];
$HTTP_REFERER = str_replace(base_url(),'',$HTTP_REFERER);
if($HTTP_REFERER === 'Register/createmember' && !isUserLoggedIn($this)) { // when user access this page after sign up
    ?>

    <div class="row">
        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
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
        </div>
        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
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
        </div>
    </div>
    <div clss="row">
        <div class="col-blocks col-xs-12 col-sm-6 col-md-12">
            <div class="register-button col-xs-12 col-sm-4 col-md-3">

                <!--input type="submit" class="btn btn-primary btn-block btn-flat btn-signin" value="<?php echo $this->lang->line('login_signin'); ?>"-->
                <input type="button" id="ajax-sign-in" class="btn btn-primary btn-block btn-flat btn-signin" value="<?php echo $this->lang->line('login_signin'); ?>">
                <input type="button" id="step-sub-after-login" class="btn btn-primary btn-block btn-flat btn-signin next-bnutton" value="Next" >


            </div>
        </div>
    </div>

    <style>
        .next-bnutton {
            display:none;
        }
        #step-registration{
            padding:0% 4%;
        }
    </style>

<?php } else {  ?>



    <div class="col-blocks col-xs-12 col-sm-12">
        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
            <label for="NameTextBox">
                First Name <span class="required-fields">*</span>
            </label>
            <div class="form-group bg-shaded">
                <?php
                if(empty($FirstName == '')){
                    $ReadyOnlyFlagFirstName = 'readonly';
                }
                if(!empty($this->session->userdata('esname'))){
                    $FirstName = $this->session->userdata('esname');
                    $this->session->unset_userdata('esname');
                }
                if(!empty($this->session->userdata('esemail'))){
                    $UserEmail = $this->session->userdata('esemail');
                    $this->session->unset_userdata('esemail');
                }
                ?>
                <input type="text" name="FirstName" id="firstNameTextBox" class="form-control" placeholder="First Name" <?=$ReadyOnlyFlagFirstName; ?> value="<?= $FirstName;?>"/>
            </div>
        </div>
        <!--div class="col-blocks col-xs-12 col-sm-6 col-md-6">
        <label for="LastNameTextBox">
            Last Name
        </label>
        <div class="form-group bg-shaded">
            <?php
        if(empty($LastName == '')){
            $ReadyOnlyFlagLastName = 'readonly';
        }
        ?>
            <input type="text" name="LastName" id="LastNameTextBox" class="form-control" <?=$ReadyOnlyFlagLastName; ?> value="<?= $LastName;?>" />
        </div>
    </div-->
        <!--/div>
        <div class="col-blocks col-xs-12 col-sm-12"-->
        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
            <label for="EmailBox">
                Email <span class="required-fields">*</span>
            </label>
            <div class="form-group bg-shaded">
                <?php
                if(empty($UserEmail == '')){
                    $ReadyOnlyFlagUserEmail = 'readonly';
                }
                if(!empty($loginType)){
                    $DataUserEmail = $UserEmail;
                    // $UserEmail = '';
                    //$ReadyOnlyFlagUserEmail = '';
                }else{
                    $DataUserEmail = '';
                }

                ?>
                <input type="text" name="email" id="EmailBox" class="form-control" placeholder="Email" <?=$ReadyOnlyFlagUserEmail; ?> value="<?= $UserEmail;?>" data-email-value="<?= $DataUserEmail;?>"/>
            </div>
        </div>
        <!--div class="col-blocks col-xs-12 col-sm-6 col-md-6">
        <label for="UserPhoneTextBox">
            Phone <span class="required-fields">*</span>
        </label>
        <div class="form-group bg-shaded">

            <input type="text" name="UserPhone" id="UserPhoneTextBox" class="form-control" placeholder="Phone"   value=" " />
        </div>
    </div-->



    </div>
    <div class="row">
        <div class="col-blocks col-xs-12 col-sm-12">
            <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                <div class="g-recaptcha" data-sitekey="6LeX-IgUAAAAABvHQ0LIZ-vhQ6Gw5uOMSnZL2MAv"></div>
                <p id="emprecpcha" class="text-danger"></p>
            </div>
            <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-sm-2 col-md-2">
    </div>
    <div class="col-blocks col-xs-12 col-sm-8 col-md-8">
        <div class="register-button col-xs-6 col-sm-4 col-md-4">
            <a href="#" id="getRegister" class="btn btn-block btn-flat btn-primary"><?=$RegButtonLabel;?></a>
        </div>
    </div>
<?php } ?>

<div class="col-sm-0 col-md-2">
</div>
</div>
<div class="col-blocks col-xs-12 col-sm-12 col-md-12">



    <?php if(!isUserLoggedIn($this)){ ?>
        <div class="social-auth-links text-center col-xs-12 col-sm-12 col-md-12">

        <span>

            <?php if( $HTTP_REFERER == 'Register/createmember'){ ?>
                - OR Sign in using - <?php } else{ ?>
                - OR Sign up using -
            <?php } ?>
         </span>
            <div class="row">
                <div class="col-sm-0 col-md-4">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2 " id="status" onclick="checkLoginState()">
                    <fb:login-button class="fb_button"  style="width:100px" length="long" size="large" scope="public_profile,email" onlogin="checkLoginState()">
                        <span>Facebook</span>
                    </fb:login-button>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2">
                    <div id="gSignInWrapper">
                        <div id="customBtn" class="customGPlusSignIn">
                                      <span class=" btn btn-block btn-social btn-google btn-flat">
                                          <i class="fa fa-google-plus"></i> Google+
                                      </span>
                        </div>
                    </div>
                </div>
                <!--div class=" col-xs-4 col-sm-4 col-md-2">
                    <a href="<?php //  base_url('login/twitterLogin')?>" class="btn btn-block btn-social btn-twitter btn-flat">
                        <i class="fa fa-twitter"></i> Twitter
                    </a>
                </div -->

                <div class="col-sm-0 col-md-3">
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<div class="col-sm-0 col-md-2">
</div>
<script> /*********************************** Facebook login **********************************************/
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
                        location.reload();
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
                            location.reload();
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