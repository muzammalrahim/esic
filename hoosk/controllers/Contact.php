<?php
class Contact extends MY_Controller{
    public $ControllerRouteManage = 'manage_contact';
    public function __construct(){
        parent::__construct();

    }
    public function index(){

        $data['Count_contact_message'] = $this->Common_model->Count_Tottle_Rows('esic_contact');
        $data['Count_email_message'] = $this->Common_model->Count_Tottle_Rows('esic_email');
        $data['subscriptions'] = $this->Common_model->Count_Tottle_Rows('subscriptions');
        $this->show_admin('contact/manage_contact',$data);
        return NULL;
    }

    public function contact_us($data='NULL'){

        $this->load->view('structure/header',$this->data);
        $this->load->view("contact/contact",$this->data);
        $this->load->view('structure/footer');
    }

    public function submit(){
           $response = $this->input->post('g-recaptcha-response');
            if (!$response || empty($response) || !isset($response)) {
                $this->session->set_userdata('msg', 'Please check the captcha form');
                header('Location:' . base_url() . 'contact');
            }
            $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeX-IgUAAAAAE9BMwpzVCx23MiB0outAOYajRRn&response=" . $response . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);
            if ($response['success'] == false) {
                $this->session->set_userdata('msg', 'You are spammer');
                header('Location:' . base_url() . 'contact');
            }else {
                $firstName = $this->input->post('firstName');
                $lastName  = $this->input->post('lastName');
                $email     = $this->input->post('email');
                $comment   = $this->input->post('comment');
                $contactarray = array(
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'email' => $email,
                    'comment' => $comment,
                    'send_date' => date('d/m/Y H:i:s')
                );
                $insertedID = $this->Common_model->insert_contact_data('esic_contact', $contactarray);
                $settings = $this->Hoosk_model->getSettings();
                $siteEmail = $settings[0]['siteEmail'];
                //$siteEmail = 'hamidraza715@gmail.com';
                //Email send to the Admin
                $subject = $firstName . " " . $lastName . "   " . "Sent From Esic Directory";
                $this->load->library('email');
                /*$config = array();
                $config['useragent']   = "CodeIgniter";
                $config['protocol']    = "smtp";
                $config['smtp_host']   = "gator3083";
                $config['smtp_port']   = "25";
                $config['mailtype']    = 'html';
                $config['charset']     = 'utf-8';
                $config['newline']     = "\r\n";
                $config['wordwrap']    = TRUE;*/
                $config = getEmailConfig();

                $this->email->initialize($config);
                $this->email->from($email, 'From: Esic Directory Contact Us ');
                $this->email->to($siteEmail);
                $this->email->subject($subject);
                $this->email->message("<h4>Message:</h4><br>" . $comment);
                $this->email->set_mailtype("html");
                $rers = $this->email->send();
                // matthew@esic.directory
                // hamid.creativetech@gmail.com
                if ($rers) {
                    //Email send to the User
                    $subject = 'Thank you. Your information has been submitted';
                    $this->email->from($siteEmail, 'From: Esic Directory');
                    $this->email->to($email);
                    $this->email->subject($subject);
                    $this->email->message("<h4>Your Message:</h4><br>" . $comment);
                    $this->email->set_mailtype("html");
                    if ($this->email->send()) {
                        $this->session->set_userdata('msg', 'Thank you. Your information has been submitted');
                        header('Location:' . base_url() . 'contact');
                    }
                }else{
                    $this->session->set_userdata('msg', 'Thank you. Your information has been submitted');
                    header('Location:' . base_url() . 'contact');
                }
            }

    }
    public function manage_contact($param = NULL){
        if($param === 'listing'){
            $selectData = array('
           id AS ID,
           firstName AS FirstName,
           send_date AS send_date,
		   email AS Email,
		   ',false);
            $addColumns = array(
                'ViewEditActionButtons' => array('<a href="'.base_url().'admin/contact/view_contact/$1"><i data-toggle="tooltip" title="View Email" class=" ml-fa fa fa-eye fa-6 " text-success></i></a><a href="#" data-target=".approval-modal" data-toggle="modal"><i data-toggle="tooltip" title="Trash" data-placement="right"  class="fa fa-trash-o text-red ml-fa"></i></a>','ID')
            );
            $returnedData = $this->Common_model->select_fields_joined_DT($selectData,'esic_contact','','','','','',$addColumns);
            print_r($returnedData);
            return NULL;
        }
        if($param === 'allvalues'){
            $returnedData = $this->Common_model->select('esic_contact');
            echo json_encode($returnedData);
            return NULL;
        }
        if($param === 'delete'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }
            $id = $this->input->post('id');
            $value = $this->input->post('value');
            if(empty($id) or !is_numeric($id)){
                echo "FAIL::Posted values are not VALID::error::Failed";
                return NULL;
            }
            if(empty($value)){
                echo "FAIL::Posted values are not VALID::error::Failed";
                return NULL;
            }
            $data='';
            if($value == 'delete'){
                $whereUpdate = array(
                    'id' => $id
                );
                $returnedData = $this->Common_model->delete('esic_contact',$whereUpdate);
                echo "OK::Record Deleted Successfully::success::Deleted";
            }else{
                echo "FAIL::Record Not Deleted::error::Failed";
            }
            return NULL;
        }
        if($param === 'update'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }
            $id = $this->input->post('id');
            $value = $this->input->post('status');
            if(empty($id) or !is_numeric($id)){
                echo "FAIL::Posted values are not VALID";
                return NULL;
            }
            if(empty($value)){
                echo "FAIL::Value Must Be Entered";
                return NULL;
            }
            $updateData = array(
                'status' => $value
            );
            $whereUpdate = array(
                'id' => $id
            );
            $updateResult = $this->Common_model->update('esic_contact',$whereUpdate,$updateData);
            if($updateResult === true){
                echo "OK::Record Successfully Updated";
            }else{
                if($updateResult['code'] == 0){
                    echo "OK::Record Already Exist";
                }else{
                    echo $updateResult['message'];
                }
            }
            return NULL;
        }
        if($param === 'new'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }
            $value = $this->input->post('status');
            if(empty($value)){
                echo "FAIL::Value Must Be Entered";
                return NULL;
            }
            $insertData = array(
                'status' => $value
            );
            $insertResult = $this->Common_model->insert_record('esic_contact',$insertData);
            if($insertResult){
                echo "OK::Record Successfully Entered";
            }else{
                echo "FAIL::Record Failed Entered";
            }
            return NULL;
        }
        $this->show_admin('contact/index');
        return NULL;
    }
    public function view_contact($id=NULL){   // View single contact Email
        Admincontrol_helper::is_logged_in($this->session->userdata('userName'));
        $this->load->helper('form');
        $this->data['users_data'] = $this->Common_model->select('esic');
        $this->data['Count_email_message'] = $this->Common_model->Count_Tottle_Rows('esic_email');
        $this->data['Count_contact_message'] = $this->Common_model->Count_Tottle_Rows('esic_contact');
        $this->data['subscriptions'] = $this->Common_model->Count_Tottle_Rows('subscriptions');
        $this->data['sent_message'] = $this->Common_model->get_contact_messages($id);
        $this->data['header'] = $this->load->view('admin/header', $this->data, true);
        $this->data['footer'] = $this->load->view('admin/footer', '', true);
        $this->load->view('contact/view_email', $this->data);
    }
    public function single_email_content ($id=NULL){ // Contact message view update div using AJAX
        $ajaxid = $this->input->post('ids');
        $value  = $this->input->post('value');
        $this->data['sent_message'] = $this->Common_model->get_contact_single_messages_div($ajaxid,$value);
        echo json_encode($this->data['sent_message']);
    }
}