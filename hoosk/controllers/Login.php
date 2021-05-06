<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends MY_Controller {
    function __construct(){
        parent::__construct();
        session_start();
        $this->load->library('session');
        $this->load->model('Hoosk_model');
        $class  = $this->router->fetch_class();
        $method = $this->router->fetch_method();
        if($method != 'logout' && $method != 'reset_session'){
            if(isCurrentUserLoggedIn($this)){
                if(!empty($_SERVER['HTTP_REFERER'])){
                    redirect($_SERVER['HTTP_REFERER'],'refresh');
                }else{
                    redirect('/','refresh');
                }
            }
        }
        $lastUrl = $_SERVER['HTTP_REFERER'];
        if($lastUrl !== 'https://www.facebook.com/'){
            $this->DefaultRedirectUrl = $lastUrl;
        }
        $currentUrl = $_SERVER['HTTP_REFERER'];
        if(
            $currentUrl != base_url().'login/checked'  &&
            $currentUrl != base_url().'login/checked/' &&
            $currentUrl != base_url().'login'  &&
            $currentUrl != base_url().'login/'
        ){
            $this->session->set_userdata('currentUrl',$currentUrl);
            $this->lastUrl = $currentUrl;
        }else{
            $currentUrl = '';
        }
        if(!empty($this->session->userdata('DefaultRedirectUrl'))){
            $this->DefaultRedirectUrl = $this->session->userdata('DefaultRedirectUrl');
        }else{
            if($this->session->userdata('currentUrl')){
                $currentUrl = $this->session->userdata('currentUrl');
                // $this->session->unset_userdata('currentUrl');
            }else{
                $currentUrl = '';
            }
            if(!empty($currentUrl)
                && $currentUrl != base_url().'login/checked'
                && $currentUrl != base_url().'login/checked/'
                && $currentUrl != base_url().'login'
                && $currentUrl != base_url().'login/'
            ){
                $this->DefaultRedirectUrl = $currentUrl;
            }else{
                $this->DefaultRedirectUrl = 'admin';
            }
        }
    }
    public function login(){
        $this->load->helper('form');
        $this->data['settings'] = $this->Hoosk_model->getSettings();
        $lastUrl = $_SERVER['HTTP_REFERER'];
        $lastUrl = base_url();
        if($lastUrl !== 'https://www.facebook.com/'){
            $this->DefaultRedirectUrl = $lastUrl;
        }
        $this->session->set_userdata('lastUrl',$lastUrl);

        $this->data['header'] = $this->load->view('admin/headerlog', '', true);
        $this->data['footer'] = $this->load->view('admin/footer', '', true);
        $this->load->view('admin/login',$this->data);
    }

    public function loginCheckeds(){ //  after registrations

        if( !empty($this->input->post('username')) && !empty($this->input->post('password'))){
            $username          = $this->input->post('username');
            $password          = $this->input->post('password');
            $passwordEncrypted = getEncryptedPassword($password);
            $result            = $this->Hoosk_model->login($username,$passwordEncrypted);
            if($result === false){
                echo 'invalid_user::'."Invalid Username Or Password";
                exit;
            }
            $checkuser         = isCurrentUserAdmin($this);
            $lastUrl           = $this->session->userdata('lastUrl');
            if($checkuser == 1){ //  if user is a admin then redirect to dashboard
                $lastUrl = base_url().'admin';
            }
            if(
                $lastUrl == base_url().'login/checked'  ||
                $lastUrl == base_url().'login/checked/' ||
                $lastUrl == base_url().'login'  ||
                $lastUrl == base_url().'login/' ||
                empty($lastUrl)
            ){
                $lastUrl = base_url();
            }
            if($result) {
                $userID = $this->session->userdata('userID');  // use for after registeration on add listing page
                echo 'OK::'.$lastUrl.'::success'.'::'.$userID;
                exit;
            }
            $passwordRS = $this->Hoosk_model->getPasswordByRs($username,$password); //Consider Password As RS
            if($passwordRS){
                $resultRS  = $this->Hoosk_model->loginByRs($username,$passwordRS);
                if($resultRS) {
                    echo 'OK::'.$lastUrl.'::success';
                    exit;
                }
            }
        }else{
            echo 'empty_fields::'."Please enter User Name and Password.";
            exit;
        }
    }
    public function loginChecked(){
        if(isset($_POST['g_cap_res'])){
            $captcha=$_POST['g_cap_res'];
            if(!$captcha || empty($captcha) || !isset($captcha)){
                echo 'emprecpcha::'."Please check the captcha form.";
                exit;
            }
            $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeX-IgUAAAAAE9BMwpzVCx23MiB0outAOYajRRn&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
            if($response['success'] == false){
                echo 'spammer::'."You are spammer";
                exit;
            }else{
                if( !empty($this->input->post('username')) && !empty($this->input->post('password'))){
                    $username          = $this->input->post('username');
                    $password          = $this->input->post('password');
                    $passwordEncrypted = getEncryptedPassword($password);
                    $result            = $this->Hoosk_model->login($username,$passwordEncrypted);
                    if($result === false){
                        echo 'invalid_user::'."Invalid Username Or Password";
                        exit;
                    }
                    $checkuser         = isCurrentUserAdmin($this);
                    $lastUrl           = $this->session->userdata('lastUrl');
                    if($checkuser == 1){ //  if user is a admin then redirect to dashboard
                        $lastUrl = base_url().'admin';
                    }
                    if(
                        $lastUrl == base_url().'login/checked'  ||
                        $lastUrl == base_url().'login/checked/' ||
                        $lastUrl == base_url().'login'  ||
                        $lastUrl == base_url().'login/' ||
                        empty($lastUrl)
                    ){
                        $lastUrl = base_url();
                    }
                if($result) {
                    $userID = $this->session->userdata('userID');  // use for after registeration on add listing page
                    echo 'OK::'.$lastUrl.'::success'.'::'.$userID;
                    exit;
                }
                $passwordRS = $this->Hoosk_model->getPasswordByRs($username,$password); //Consider Password As RS
                if($passwordRS){
                    $resultRS  = $this->Hoosk_model->loginByRs($username,$passwordRS);
                    if($resultRS) {
                        echo 'OK::'.$lastUrl.'::success';
                        exit;
                    }
                }
            }else{
                    echo 'empty_fields::'."Please enter User Name and Password.";
                    exit;
                }
            }
        }
    }
    public function logout(){
        $data = array(
            'userID'    => '',
            'userName'  => '',
            'firstName' => '',
            'lastName'  => '',
            'Email'     => '',
            'phone'     => '',
            'p_image'   => '',
            'userRole'  => '',
            'loginType' => '',
            'logged_in' =>  FALSE,
        );
        $this->session->unset_userdata($data);
        $this->session->unset_userdata('DefaultRedirectUrl');
        $this->session->unset_userdata('lastUrl');
        $this->session->unset_userdata('guide_popups');
        $this->session->sess_destroy();
        redirect('/', 'refresh');
    }
    public function fbook(){
        $data        = $this->input->post('data');
        $data        = json_decode($data, TRUE);
        $first_name  = $data['first_name'];
        $lastname    = $data['last_name'];
        $email       = $data['email'];
        $data        = array(
            'userName'  => $email,
            'firstName' => $first_name,
            'lastName'  => $lastname,
            'email'     => $email,
            'loginType' => 'facebook',
            'userRole'  => json_encode(array("9")),
        );
        $result = $this->Hoosk_model->social_login($email,$data);
        if($result) {
            echo 'OK::'. base_url().'::success';exit;
        }
        else{
            echo 'error::'. base_url().'login'.'::error';exit;
        }
    }
    public function googlejslogins(){
        $first_name  = $this->input->post('f_name');
        $lastname    = $this->input->post('l_name');
        $email       = $this->input->post('email');
        $data        = array(
            'userName'  => $email,
            'firstName' => $first_name,
            'lastName'  => $lastname,
            'email'     => $email,
            'loginType' => 'google',
            'userRole'  => json_encode(array("9")),
        );
        $result = $this->Hoosk_model->social_login($email,$data);
        if($result) {
            echo 'OK::'. base_url().'::success';
            exit;
        }
        else{
            echo 'error::'. base_url().'login'.'::success';
            exit;
        }
    }
    // twitter login
//    public function twitterLogin(){
//        $this->load->library('twitterlib');
//        $this->load->library('twitteroauths');
//        if($this->session->userdata('twitter_access_token') && $this->session->userdata('twitter_token_secret')){
//            $oauth_token =  $this->session->userdata('twitter_access_token');
//            $oauth_token_secret = $this->session->userdata('twitter_token_secret');
//            $this->twitter_login($oauth_token,$oauth_token_secret);
//        }else{
//            $request_token = $this->connection->getRequestToken(base_url('/login/twitterCallback'));
//            $this->session->set_userdata('request_token', $request_token['oauth_token']);
//            $this->session->set_userdata('request_token_secret', $request_token['oauth_token_secret']);
//            if($this->connection->http_code == 200){
//                $url = $this->connection->getAuthorizeURL($request_token);
//                redirect($url);
//            }else{
//                print_r($this->connection->http_code);
//            }
//        }
//    }

    // twitter call back function
//    public function twitterCallback(){
//        if($this->input->get('oauth_token') && $this->session->userdata('request_token') !== $this->input->get('oauth_token')){
//            $this->reset_session();
//            redirect(base_url('/login/twitterLogin'));
//        }else{
//            $access_token = $this->connection->getAccessToken($this->input->get('oauth_verifier'));
//            if ($this->connection->http_code == 200){
//                $this->session->set_userdata('twitter_access_token', $access_token['oauth_token']);
//                $this->session->set_userdata('twitter_token_secret', $access_token['oauth_token_secret']);
//                $this->session->set_userdata('twitter_user_id', $access_token['user_id']);
//                $this->session->set_userdata('twitter_screen_name', $access_token['screen_name']);
//                $this->session->unset_userdata('request_token');
//                $this->session->unset_userdata('request_token_secret');
//                $this->twitter_login($access_token['oauth_token'],$access_token['oauth_token_secret']);
//            }else{
//                // An error occured. Add your notification code here.
//                //redirect(base_url('/'));
//                $this->login();
//            }
//        }
//    }
//    private function twitter_login($oauth_token,$oauth_token_secret){
//        $params = array('include_email' => 'true', 'include_entities' => 'false', 'skip_status' => 'true');
//        $content = $this->connection->get('account/verify_credentials', ['include_email'=>'true','skip_status'=>'true',]);
//        $this->session->set_userdata('tw_connection','connected'); // set status for twitter connection
//        // check if user is already logged in and want to connect twitter, then just save token in db and redirect to main page
//        if($this->session->userdata('userID')){
//            $this->saveToken($oauth_token, $oauth_token_secret, 'twitter', $this->session->userdata('userID')
//            );
//            //echo 'User Saved';
//            $this->reset_session();
//            redirect(base_url('/login/twitterLogin'));
//
//        }
//        $name  = $content->name;
//        $email = $content->email;
//        $data  = array(
//            'userName'  => $email,
//            'firstName' => $name,
//            'email'     => $email,
//            'loginType' => 'twitter',
//            'userRole'  => json_encode(array("9")),
//        );
//        $result = $this->Hoosk_model->social_login($email,$data);
//        if($result){
//            $currentUrl = $this->DefaultRedirectUrl;
//            if(
//                $currentUrl != base_url().'login/check'  &&
//                $currentUrl != base_url().'login/check/' &&
//                $currentUrl != base_url().'login'  &&
//                $currentUrl != base_url().'login/' &&
//                !empty($currentUrl)
//            ){
//                redirect($this->DefaultRedirectUrl, 'refresh');
//            }else{
//                redirect(base_url(), 'refresh');
//            }
//        }else{
//            echo '<pre>';
//            print_r($data);
//            print_r($result);
//            print_r($content);
//            echo '</pre>';
//        }
//    }
    private function reset_session()
    {
        $this->session->sess_destroy();
        $this->session->unset_userdata('access_token');
        $this->session->unset_userdata('access_token_secret');
        $this->session->unset_userdata('request_token');
        $this->session->unset_userdata('request_token_secret');
        $this->session->unset_userdata('twitter_user_id');
        $this->session->unset_userdata('twitter_screen_name');
        $this->session->unset_userdata('loginType');
        $this->session->unset_userdata('DefaultRedirectUrl');
        $this->session->unset_userdata('lastUrl');
    }
    private function saveToken($oauth_token,$oauth_token_secret,$social_platform,$userID){

    }
}
