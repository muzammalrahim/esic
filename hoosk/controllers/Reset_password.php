<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reset_password extends MY_Controller {

    function __construct(){
        parent::__construct();
       
        $this->data['settings']=$this->Hoosk_page_model->getSettings();// use for header title
    }
    public function forgot(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if($this->form_validation->run() == FALSE){
            $this->data['header'] = $this->load->view('admin/headerlog', $this->data, true);
            $this->data['footer'] = $this->load->view('admin/footer', '', true);
            $this->load->view('admin/email_check', $this->data);
        }else{
            $email = $this->input->post('email');
            if(CheckUserFieldExist($this,$email,'email') == true){
                $this->load->helper('string');
                $rs = random_string('alnum', 12);
                $data = array(
                        'rs' => $rs,
                        'password'=> getEncryptedPassword($rs)
                );
                $this->db->where('email', $email);
                $this->db->update($this->tableNameUser, $data);               
                $subject = "Esic Directory: Password Forget Request";
                $message = "Hi, You Have Sent Us Forget Password Request <br>";
                $message .= "<a href='".BASE_URL."/login'>Click Here To Login</a><br>";
                $message .= "Now You Can Login From This Password:  " . $rs;
                $emailSendResult = sendEmail($this,$subject,$email,$message);
                if($emailSendResult){
                    $this->data['header'] = $this->load->view('admin/headerlog', $this->data, true);
                    $this->data['footer'] = $this->load->view('admin/footer', '', true);
                    $this->load->view('admin/check', $this->data);
                }else{
                    $this->data['header'] = $this->load->view('admin/headerlog', $this->data, true);
                    $this->data['footer'] = $this->load->view('admin/footer', '', true);
                    $this->load->view('admin/email_check', $this->data);
                }
            }else{
                $this->data['error'] = "Sorry, That Email Does Not Exist In Our System!! ";
                $this->data['header'] = $this->load->view('admin/headerlog', $this->data, true);
                $this->data['footer'] = $this->load->view('admin/footer', '', true);
                $this->load->view('admin/email_check', $this->data);
            }
        }
    }
}