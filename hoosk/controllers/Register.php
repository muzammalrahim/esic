<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MY_Controller {

    function __construct(){
    parent::__construct();
        $class  = $this->router->fetch_class();
        $method = $this->router->fetch_method();
        //if($method != 'logout' && $method != 'reset_session'){
            if(isCurrentUserLoggedIn($this)){
                if(!empty($_SERVER['HTTP_REFERER'])){
                    redirect($_SERVER['HTTP_REFERER'],'refresh');
                }else{
                    redirect('/','refresh');
                }
            }
       // }
    }
    public function index(){
        $data=array();
        $user_id = $this->session->userdata('UserID');
        $Username = $this->session->userdata('Username');
        if (empty($user_id) || strlen($user_id) <= 0) {
            $this->load->view('admin/register',$data);
        }else{
            echo 'Already A Member and Logged IN as '.$Username.' !!!.';
        }
    }

    public function signup(){
        $this->load->library('form_validation');
        $data = array();
        if(isset($_POST['g-recaptcha-response'])) {
            $captcha = $_POST['g-recaptcha-response'];
            if (!$captcha || empty($captcha) || !isset($captcha)) {
                $data['messages'][0] = '<p class="text-red">Please check the captcha form!!';
                $this->load->view('admin/register', $data);
                return null;
                exit;
            }
            $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeX-IgUAAAAAE9BMwpzVCx23MiB0outAOYajRRn&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);
            if ($response['success'] == false) {
                $data['messages'][0] = '<p class="text-red">You are spammer!';
                $this->load->view('admin/register', $data);
                return null;
                exit;
            } else {
                if (!$this->input->post()) {
                    $data['messages'][0] = '<p class="text-red">All Fields Are Required !!';
                    $this->load->view('admin/register', $data);
                    return null;
                }
                $this->form_validation->set_rules('terms', 'Terms', 'required', array(
                    'required' => 'You Must Agree With Our Terms & Conditions.',
                ));
                $Username = $this->input->post('Username');
                $FirstName = $this->input->post('FirstName');
                $LastName = $this->input->post('LastName');
                $Email = $this->input->post('Email');
                $Phone = $this->input->post('Phone');
                $Password = esic_random_password_generator();
                if (empty($Username)) {
                    $Username = $Email;
                }
                $userInputData = array(
                    'Username' => $Username,
                    'FirstName' => $FirstName,
                    'LastName' => $LastName,
                    'Email' => $Email,
                    'Phone' => $Phone,
                    'userRole' => json_encode(array("9")), // As Guest First
                    'Password' => getEncryptedPassword($Password)
                );
                $data['userData'] = $userInputData;
                $this->form_validation->set_rules('FirstName', 'First Name', 'trim|required|min_length[3]|max_length[50]');
                $this->form_validation->set_rules('Email', 'Email', 'trim|required|min_length[5]|max_length[50]|strtolower');
                if ($this->form_validation->run($this) == FALSE) {
                    $this->load->view('admin/register', $data);
                } else {
                    $Message = $this->User_model->CreateNewUser($userInputData);
                    $Message = explode('::', $Message);
                    // check if email exist, then show login link
                    if (isset($Message[3]) && $Message[3] == 'login') {
                        $data['login_link'] = true;
                    }
                    $data['messages'][0] = $Message[1];
                    if ($Message[0] == 'Success') {
                        newUserEmail($this, $FirstName, $Email, $Password); // Sending Email To New User
                        $this->load->view('admin/register/success', $data);
                    } else {
                        $this->load->view('admin/register', $data);
                    }
                }
            }
        }else{
            $this->load->view('admin/register');
            return null;
        }
    }
    public function getAccountDetailsFromFB(){
        // Check if user is logged infacebook_login
        if($this->facebook->is_authenticated()){
            $user = $this->facebook->request('get', '/me?fields=id,name,email,gender,first_name,last_name,locale,timezone,location');

            $id          = $user['id'];
            $first_name  = $user['first_name'];
            $last_name    = $user['last_name'];
            $email       = $user['email'];
            $data = array(
                'userName'  => $email,
                'firstName' => $first_name,
                'lastName'  => $last_name,
                'email'     => $email,
                'userRole'  => json_encode(9),
                );

            $result = $this->Hoosk_model->social_login($email,$data);
        }
         redirect('/esic', 'refresh');
    }

    public function getAccountDetailsFromGoogle(){ 
        
        if($this->input->get('code')) {
            $this->googleplus->getAuthenticate();
            $this->session->set_userdata('gplus_token',$this->googleplus->getAccessToken());

            $user      =  $this->googleplus->getUserInfo();
            $firstName =  $user['given_name'];
            $lastName  =  $user['family_name'];
            $email     =  $user['email'];
            $imgUrl    =  $user['picture'];
            $id        =  $user['id'];
            $details = array(
                'firstName' => $firstName,
                'lastName'  => $lastName,
                'email'     => $email
            );
          return $details;
        }
        echo 'Fail';
    }

    public function getAccountDetailsFromTwitter(){
       
        if($this->input->get('oauth_token') && $this->session->userdata('request_token') !== $this->input->get('oauth_token')){
            $this->reset_session();
            redirect(base_url('/login/twitterLogin'));
        }else{ 
            $access_token = $this->connection->getAccessToken($this->input->get('oauth_verifier'));
            if ($this->connection->http_code == 200){
                $this->session->set_userdata('twitter_access_token', $access_token['oauth_token']);
                $this->session->set_userdata('twitter_token_secret', $access_token['oauth_token_secret']);
                $this->session->set_userdata('twitter_user_id', $access_token['user_id']);
                $this->session->set_userdata('twitter_screen_name', $access_token['screen_name']);
                $this->session->unset_userdata('request_token');
                $this->session->unset_userdata('request_token_secret');
                $params = array(
                    'include_email'    => 'true',
                    'include_entities' => 'false',
                    'skip_status'      => 'true'
                );
                $content = $this->connection->get('account/verify_credentials', ['include_email'=>'true','skip_status'=>'true',]);
                $user_name = $content->email;
                    $this->session->set_userdata('tw_connection','connected'); // set status for twitter connection
  
                $name = $content->name;
                if(isset($name)){
                        $name=explode(' ', $name);
                }
                $email = $content->email;
                $details  = array(
                    'firstName' => $name[0],
                    'lastName'  => $name[1],
                    'email'     => $content->email
                );
                 return $details;
            }
        }
       echo 'Fail';
    }      
}