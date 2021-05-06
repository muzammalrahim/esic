<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller{
  public $ControllerRouteManage = 'users';

  function __construct(){
    parent::__construct();

  }
  public function index(){
    Admincontrol_helper::is_logged_in($this->session->userdata('userName'));
    if (isCurrentUserAdmin($this)) {
      $config['base_url'] = BASE_URL . '/admin/users/';
      $config['total_rows'] = $this->Hoosk_model->countUsers();
      $config['full_tag_open'] = '<div class="form-actions">';
      $config['full_tag_close'] = '</div>';

      // Get users from database

      $this->data['users'] = $this->Hoosk_model->getUsers();
      $this->data['roles'] = $this->Hoosk_model->getRoles();

      // Load the view

      $this->data['header'] = $this->load->view('admin/header', $this->data, true);
      $this->data['footer'] = $this->load->view('admin/footer', '', true);
      $this->load->view('admin/users', $this->data);
    }
    else {
      $this->load->view('admin/page_not_found');
    }
  }

  public function newUser(){
      if(isset($_POST['g_cap_res'])) {
          if(CheckUserEmail($this)=== false){
              echo 'FAIL:: Email Already Exit Please Login! ::error';
              return false;
          }else{
              $captcha = $_POST['g_cap_res'];
              if (!$captcha || empty($captcha) || !isset($captcha)) {
                  echo '::emprecpcha::' . "Please check the captcha form.";
                  return false;
              }else{
                    $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeX-IgUAAAAAE9BMwpzVCx23MiB0outAOYajRRn&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);
                    if ($response['success'] == false) {
                        echo '::spammer::' . "You are spammer";
                        return false;
                    }else{
                        if(!isCurrentUserLoggedIn($this)){
                            $userID = NewUserRegister($this);
                            if (!empty($userID) && is_numeric($userID)){
                                echo '::OK:: User Successfully register::success::' . $userID;
                            }else{
                                echo '::FAIL:: Some Error Occur ! ::error';
                                return false;
                            }
                        }else{
                            $userID = getCurrentUserID($this);
                            if (isCurrentUserLoginTypeSocial($this)) {
                                $email = $this->input->post('email');
                                $where = array('userID' => $userID);
                                $newData = array('email' => $email);
                                $this->Common_model->update($this->tableNameUser, $where, $newData);
                            }
                            if (!empty($userID)) {
                                echo '::OK:: You Are already LoggedIn::success::' . $userID;
                            } else {
                                echo '::FAIL::Some Error Occur::error';
                               return false;
                            }
                        }
                    return null;
                    }

              }
          }
      }
  }
  public function addUser()
  {
    Admincontrol_helper::is_logged_in($this->session->userdata('userName'));

    // Load the form helper

    $userRole = $this->session->userdata('userRole');
    if (isCurrentUserAdmin($this)) {
      $this->load->helper('form');

      // Load the view

      $this->data['roles'] = $this->Hoosk_model->getRoles();
      $this->data['header'] = $this->load->view('admin/header', $this->data, true);
      $this->data['footer'] = $this->load->view('admin/footer', '', true);
      $this->load->view('admin/user_new', $this->data);
    }
    else {
      $this->load->view('admin/page_not_found');
    }
  }

  public function confirm()
  {
    Admincontrol_helper::is_logged_in($this->session->userdata('userName'));

    // Load the form validation library

    $this->load->library('form_validation');

    // Set validation rules

    $this->form_validation->set_rules('username', 'username', 'trim|alpha_dash|required|is_unique[hoosk_user.userName]');
    $this->form_validation->set_rules('email', 'email address', 'trim|required|valid_email|is_unique[hoosk_user.email]');
    $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[4]|max_length[32]');
    $this->form_validation->set_rules('con_password', 'confirm password', 'trim|required|matches[password]');
    if ($this->form_validation->run() == FALSE) {
      // Validation failed
      $this->addUser();
    }
    else {

      // Validation passed
      // Add the user

      $this->Hoosk_model->createUser();

      // Return to user list

      redirect('/admin/users', 'refresh');
    }
  }

  public function editUser()
  {
    Admincontrol_helper::is_logged_in($this->session->userdata('userName'));

    // Load the form helper

    $this->load->helper('form');
    $UrlUserID = 0;
    if (isCurrentUserAdmin($this)) {
      $UrlUserID = $this->uri->segment(4);

      // Get user details from database

      $this->data['users'] = $this->Hoosk_model->getUser($UrlUserID);
      $this->data['roles'] = $this->Hoosk_model->getRoles();

      // Load the view

      $this->data['header'] = $this->load->view('admin/header', $this->data, true);
      $this->data['footer'] = $this->load->view('admin/footer', '', true);
      $this->load->view('admin/user_edit', $this->data);
    }
    else {
      $UrlUserID = $this->session->userdata('userID');
      if ($this->session->userdata('userID') != $this->uri->segment(4)) {
        $this->load->view('admin/header');
        $this->load->view('admin/NoPermission', $this->data);
        $this->load->view('admin/footer');
      }else {
        $this->data['users'] = $this->Hoosk_model->getUser($UrlUserID);
        $this->data['roles'] = $this->Hoosk_model->getRoles();
        $this->data['header'] = $this->load->view('admin/header', $this->data, true);
        $this->data['footer'] = $this->load->view('admin/footer', '', true);
        $this->load->view('admin/user_edit', $this->data);
      }
    }
  }

  public function edited(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('email', 'email address', 'trim|required|valid_email|is_unique[hoosk_user.email.userID.' . $this->uri->segment(4) . ']');
    if(!isCurrentUserAdmin($this)){
      $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[4]|max_length[32]');
      $this->form_validation->set_rules('con_password', 'confirm password', 'trim|required|matches[password]');
    }
    if ($this->form_validation->run() == FALSE) {
      $this->editUser();
    }else {
      $this->Hoosk_model->updateUser($this->uri->segment(4));
      redirect('/admin/users', 'refresh');
    }
  }

  public function edit_profile_picture($id = NULL)
  {
    $id = $id;
    if (!empty($_FILES['image']['name'])) {
      $config['allowed_types'] = "gif|jpg|png|jpeg";
      $config['upload_path'] = 'uploads/investor/';
      $config['file_name'] = $_FILES['image']['name'];
      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      if ($this->upload->do_upload('image')) {
      }
      else {
        echo $this->upload->display_errors();
        exit;
      }

      $image_name = str_replace(" ", "_", $_FILES['image']['name']);

      // echo   $filepath        = base_url().'uploads/investor/'.$name;

    }

    // end imgae code

    $data = array(
      'P_image' => $image_name,
      );
    $id = $this->input->post("id");
    if ($image_name) {
      $ok = $this->Hoosk_model->update_p_image($id, $data);
    }
    else {
      $ok = "ok";
    }

    echo $image_name;
  }

  function delete()
  {
    Admincontrol_helper::is_logged_in($this->session->userdata('userName'));
    if ($this->input->post('deleteid')):
      $this->Hoosk_model->removeUser($this->input->post('deleteid'));
    redirect('/admin/users');
    else:
      $this->data['form'] = $this->Hoosk_model->getUser($this->uri->segment(4));
    $this->load->view('admin/user_delete.php', $this->data);
    endif;
  }

  public function email_check($str)
  {
    $query = $this->db->get_where('hoosk_user', array(
      'email' => $str
      ) , 1);
    if ($query->num_rows() == 1) {
      return true;
    }
    else {
      $this->form_validation->set_message('email_check', $this->lang->line('email_check'));
      return false;
    }
  }

  public function getPassword()
  {
    $rs = $this->uri->segment(3);
    $query = $this->db->get_where('hoosk_user', array(
      'rs' => $rs
      ) , 1);
    if ($query->num_rows() == 0) {
      $this->data['header'] = $this->load->view('admin/headerlog', $this->data, true);
      $this->data['footer'] = $this->load->view('admin/footer', '', true);
      $this->load->view('admin/error', $this->data);
    }
    else {
      $this->load->database();
      $this->load->helper(array(
        'form',
        'url'
        ));
      $this->load->library('form_validation');
      $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[20]|matches[con_password]');
      $this->form_validation->set_rules('con_password', 'Password Confirmation', 'trim|required');
      if ($this->form_validation->run() == FALSE) {
        echo form_open();
        $this->data['header'] = $this->load->view('admin/headerlog', $this->data, true);
        $this->data['footer'] = $this->load->view('admin/footer', '', true);
        $this->load->view('admin/resetform', $this->data);
      }
      else {
        $query = $this->db->get_where('hoosk_user', array(
          'rs' => $rs
          ) , 1);
        if ($query->num_rows() == 0) {
          show_error('Sorry!!! Invalid Request!');
        }
        else {
          $data = array(
            'password' => md5($this->input->post('password') . SALT) ,
            'rs' => ''
            );
          $where = $this->db->where('rs', $rs);
          $where->update('hoosk_user', $data);
          $this->data['header'] = $this->load->view('admin/headerlog', $this->data, true);
          $this->data['footer'] = $this->load->view('admin/footer', '', true);
          $this->load->view('admin/reset', $this->data);
        }
      }
    }
  }

  public function email()
  { //Email form
    Admincontrol_helper::is_logged_in($this->session->userdata('userName'));
    $userRole = $this->session->userdata('userRole');
    if (isCurrentUserAdmin($this)) {
      $this->load->helper('form');
      $this->data['users_data'] = $this->Common_model->select('esic');
      $this->data['Count_email_message'] = $this->Common_model->Count_Tottle_Rows('esic_email');
      $this->data['Count_contact_message'] = $this->Common_model->Count_Tottle_Rows('esic_contact');
      $this->data['subscriptions'] = $this->Common_model->Count_Tottle_Rows('subscriptions');
      $this->data['header'] = $this->load->view('admin/header', $this->data, true);
      $this->data['footer'] = $this->load->view('admin/footer', '', true);
      $this->load->view('admin/emails/email', $this->data);
    }
    else {
      $this->load->view('admin/page_not_found');
    }
  }
  public function send_email() //compose email
  {
    $to = implode(",", $this->input->post('to')); //array to string conversion
    $subject = $this->input->post('subject');
    $attachment = $this->input->post('attachment');
    $message = $this->input->post('message');
    $siteEmail = $this->data['settings'] = $this->Hoosk_model->getSettings();
    $from_email = $siteEmail[0]['siteEmail'];
    $this->load->library('email');
    /* $config['useragent'] = "CodeIgniter";
    $config['protocol'] = "smtp";
    $config['smtp_host'] = "gator3083";
    $config['smtp_port'] = "25";
    $config['mailtype'] = 'html';
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['wordwrap'] = TRUE;*/
    $config = getEmailConfig();
    $config['upload_path'] = 'uploads';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size'] = '1000';
    $config['max_width'] = '1024';
    $config['max_height'] = '768';
    $config['encrypt_name'] = true;
    $this->load->library('upload', $config);
    $this->email->initialize($config);
    $this->email->from($from_email, 'From: Esic Directory');
    $this->email->to($to);
    $this->email->subject($subject);
    $this->email->message("<h4>Message : </h4><br />" . $message . "<br />" . base_url());
    if (!$this->upload->do_upload('attachment')) // files will be input attachment field name
    {
      echo $this->upload->display_errors();
    }
    else {
      $image_data = $this->upload->data();
      $fname = $image_data['file_name'];
      $fpath = $image_data['file_path'] . $fname;
      $this->email->attach($fpath);
    }
    if ($this->email->send()) {
      $insert = array(
        'sendto' => $to,
        'subject' => $subject,
        'message' => $message,
        'date' => date("F j, Y, g:i a")
        );
      $this->Common_model->insert_email_data('esic_email', $insert);
      $this->session->set_userdata('msg', 'Thank you. Your information has been submitted');
      header('Location:' . base_url() . 'admin/users/sent');
    }
    else {
      $this->session->set_userdata('errormsg', 'Error. Some Thing Happend Wrong Please Try Again');
      header('Location:' . base_url() . 'admin/users/email');
    }
  }
  public function sent($param = NULL)
  {
    //Mange Sent Emails
    Admincontrol_helper::is_logged_in($this->session->userdata('userName'));
    $userRole = $this->session->userdata('userRole');
    if (isCurrentUserAdmin($this)) {
      if ($param === 'listing') {
        $selectData = array(
          '
          id AS ID,
          sendto AS sendto,
          subject AS Subject,
          date AS Date,
          ',
          false
          );
        $addColumns = array(
          'ViewEditActionButtons' => array(
            '<a href="' . base_url() . 'admin/users/single_email/$1"><i data-toggle="tooltip" title="View Email" class=" ml-fa fa fa-eye fa-6 " text-success></i></a><a href="#" data-target=".approval-modal" data-toggle="modal"><i data-toggle="tooltip" title="Trash" data-placement="left"  class="fa fa-trash-o text-red ml-fa"></i></a>',
            'ID'
            )
          );
        $returnedData = $this->Common_model->select_fields_joined_DT($selectData, 'esic_email', '', '', '', '', '', $addColumns);
        print_r($returnedData);
        return NULL;
      }
      if ($param === 'allvalues') {
        $returnedData = $this->Common_model->select('esic_email');
        echo json_encode($returnedData);
        return NULL;
      }
      if ($param === 'delete') {
        if (!$this->input->post()) {
          echo "FAIL::No Value Posted";
          return false;
        }
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        if (empty($id) or !is_numeric($id)) {
          echo "FAIL::Posted values are not VALID";
          return NULL;
        }
        if (empty($value)) {
          echo "FAIL::Posted values are not VALID";
          return NULL;
        }
        $data = '';
        if ($value == 'delete') {
          $whereUpdate = array(
            'id' => $id
            );
          $returnedData = $this->Common_model->delete('esic_email', $whereUpdate);
          echo "OK::Record has been Deleted::success::Deleted";
        }
        else {
          echo "FAIL::Record Not Deleted::error::Not Deleted";
        }
        return NULL;
      }
      $data['Count_contact_message'] = $this->Common_model->Count_Tottle_Rows('esic_contact');
      $data['Count_email_message'] = $this->Common_model->Count_Tottle_Rows('esic_email');
      $data['subscriptions'] = $this->Common_model->Count_Tottle_Rows('subscriptions');
      $this->show_admin('admin/emails/sent_email_list', $data);
      return NULL;
    }
    else {
      $this->load->view('admin/page_not_found');
    }
  }

  public function single_email($id = NULL)
  { // View Sent Email
    Admincontrol_helper::is_logged_in($this->session->userdata('userName'));
    $this->load->helper('form');
    $this->data['users_data'] = $this->Common_model->select('esic');
    $this->data['Count_email_message'] = $this->Common_model->Count_Tottle_Rows('esic_email');
    $this->data['Count_contact_message'] = $this->Common_model->Count_Tottle_Rows('esic_contact');
    $this->data['subscriptions'] = $this->Common_model->Count_Tottle_Rows('subscriptions');
    $this->data['sent_message'] = $this->Common_model->get_sent_single_messages($id);
    $this->data['header'] = $this->load->view('admin/header', $this->data, true);
    $this->data['footer'] = $this->load->view('admin/footer', '', true);
    $this->load->view('admin/emails/view_sent_email', $this->data);
  }

  public function single_email_content($id = NULL)
  { // sent email view update div using AJAX
    $ajaxid = $this->input->post('ids');
    $value = $this->input->post('value');
    $this->data['sent_message'] = $this->Common_model->get_sent_single_messages_div($ajaxid, $value);
    echo json_encode($this->data['sent_message']);
  }
  public function subscribe_add(){
    $email2 = $this->input->post('email2');
    if($email2==''){
        $email = $this->input->post('email');
        $where = array('email' => $email);
        $result = $this->Common_model->select_fields_where('subscriptions','email',$where,true);
        if(empty($result)){
          $data['email'] = $email;
          $this->Common_model->insert_record('subscriptions',$data);
          echo "OK::For Joining our newsletter to receive the latest news!";
          return true;
        }else{
          echo "OK::You are already subscribed user!";
          return true;
        }

    }
  }
  public function subscribe_list($param = NULL){
    Admincontrol_helper::is_logged_in($this->session->userdata('userName'));
    if (isCurrentUserAdmin($this)) {
      if ($param === 'listing') {
        $selectData = array(
            'id AS ID,email AS Email,updated_date AS Date,',false
        );
        $addColumns = array(
            'ViewEditActionButtons' => array(
                '<a href="#" data-target=".approval-modal" data-toggle="modal"><i data-toggle="tooltip" title="Trash" data-placement="left"  class="fa fa-trash-o text-red ml-fa"></i></a>',
                'ID'
            )
        );
        $returnedData = $this->Common_model->select_fields_joined_DT($selectData, 'subscriptions', '', '', '', '', '', $addColumns);
        print_r($returnedData);
        return NULL;
      }
      if ($param === 'delete') {
        if (!$this->input->post()) {
          echo "FAIL::No Value Posted";
          return false;
        }
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        if (empty($id) or !is_numeric($id)) {
          echo "FAIL::Posted values are not VALID";
          return NULL;
        }
        if (empty($value)) {
          echo "FAIL::Posted values are not VALID";
          return NULL;
        }
        $data = '';
        if ($value == 'delete') {
          $whereUpdate = array(
              'id' => $id
          );
          $returnedData = $this->Common_model->delete('subscriptions', $whereUpdate);
          echo "OK::Record has been Deleted::success::Deleted";
        }
        else {
          echo "FAIL::Record Not Deleted::error::Not Deleted";
        }
        return NULL;
      }
      $this->data['Count_email_message'] = $this->Common_model->Count_Tottle_Rows('esic_email');
      $this->data['Count_contact_message'] = $this->Common_model->Count_Tottle_Rows('esic_contact');
      $this->data['subscriptions'] = $this->Common_model->Count_Tottle_Rows('subscriptions');
      $this->show_admin('admin/emails/subscriptions/list',$this->data);
      return NULL;
    }
    else {
      $this->load->view('admin/page_not_found');
    }
  }
    public function upload(){
    $attachment   = $this->input->post('attachment');
    $uploadedFile = $_FILES['attachment']['tmp_name']['file'];

        //explode to get only folder name
     $path = DoucmentUrl.'/images';//change it
        // $path = BASE_URL.'/images';
    $url = BASE_URL.'/images';
    // create an image name
    $fileName = $attachment['name'];
    // upload the image
    move_uploaded_file($uploadedFile, $path.'/'.$fileName);
    $this->output->set_output(json_encode(array('file' => array(
    'url' => $url . '/' . $fileName,
    'filename' => $fileName
    ))),

    200,
    array('Content-Type' => 'application/json')
    );
  }
}