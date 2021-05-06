<?php

class Estimator extends MY_Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index($data='NULL')
    {
        $where = array('status' => 1);
        $this->data['question']  = $this->Common_model->select_fields_where('calculator_questions','*',$where,FALSE);
        $userID = $this->session->userdata('userID');
        if($userID)
            $this->data['user']  = $this->Common_model->select_fields_where('hoosk_user','email,firstName,lastName',array('userid' => $userID),True);
        else{
            $this->data['user'] = False;
        }
        $this->load->view('structure/header',$this->data);
        $this->load->view("templates/estimator",$this->data);
        $this->load->view('structure/footer',$this->data);
    }
    public function submit(){
        if(isset($_POST['email']) && !isset($_POST['email2'])) {
            $CheckUserEmail = CheckUserEmail($this);
            if($CheckUserEmail === false){
                $email = $this->input->post('email');
                $where = array('email' => $email);
                $data  = $this->Common_model->select_fields_where('hoosk_user','userID,firstName,lastName,email',$where,True);
                $userID = $data->userID;
                $where = array('userID' => $userID);
                $esic_data  = $this->Common_model->select_fields_where('esic','userID',$where,True);
                if(empty($esic_data->userID)){
                    $slug = getAlias($data->firstName .$data->lastName);
                    $slug = str_replace(' ','_' ,$slug);
                    $slug = strtolower($slug);
                    $slug = preg_replace('/[^A-Za-z0-9\_]/', '', $slug);
                    $data = array(
                        'userID' => $userID,
                        'email' => $data->email ,
                        'slug' => $slug,
                        'name' => $data->firstName.' '.$data->lastName,
                    );
                    $this->Common_model->insert_record('esic',$data);
                    $esic_id =  $this->db->insert_id();
                }
                $this->session->set_userdata('cal_user_id', $userID); // save user id to save ESIC Calculators Questions And Answers
                $this->session->set_userdata('esic_id', $esic_id); // save user id to save ESIC Calculators Questions And Answers
                if (strpos($CheckUserEmail, 'FAIL') !== false) {
                    echo 'FAIL:: Sorry You Cannot Use this Email Already Exist ! If this is your email address please Login first';
                }
                return false;
            }else{
                if(!isCurrentUserLoggedIn($this)){
                    $userID = NewUserRegister($this);
                    $slug = getAlias($this->input->post('FirstName').$this->input->post('LastName'));
                    $slug = str_replace(' ','_' ,$slug);
                    $slug = strtolower($slug);
                    $slug = preg_replace('/[^A-Za-z0-9\_]/', '', $slug);
                    $data = array(
                        'userID' => $userID,
                        'email' => $this->input->post('email'),
                        'slug' => $slug,
                        'name' => $this->input->post('FirstName').' '.$this->input->post('LastName'),
                    );
                    $this->Common_model->insert_record('esic',$data);
                    $esic_id =  $this->db->insert_id();
                    if (!empty($userID) && is_numeric($userID)){
                        $this->session->set_userdata('cal_user_id', $userID);
                        $this->session->set_userdata('esic_id', $esic_id); // save user id to save ESIC Calculators Questions And Answers
                        echo 'OK:: User Successfully register';
                    }else{
                        echo 'Error:: Some Error Occur !';
                        return false;
                    }
                }else{
                    $userID = getCurrentUserID($this);
                    if (!empty($userID)) {
                        $this->session->set_userdata('cal_user_id', $userID); // save user id to save ESIC Calculators Questions And Answers
                        echo 'OK:: You Are already LoggedIn';
                    }else {
                        echo 'Error::Some Error Occur';
                        return false;
                    }
                }
            }
        }
    }
    public function incorporated(){
        $corporate_date = $this->input->post('corporate_date');
        if(!empty($corporate_date)){
            $corporate_year = explode("-",$corporate_date);
            $corporate_year = $corporate_year[2];
            if( strtotime($corporate_date) > strtotime("$corporate_year-06-30") && strtotime($corporate_date) <= strtotime("$corporate_year-12-31") ) {
                $corporate_year +=1;
            }
            $today = date('Y-m-d');
            $year  = date('Y');
            if( strtotime($today) > strtotime("$year-06-30") && strtotime($today) <= strtotime("$year-12-31") ) {
                $year +=1;
            }
            $diff = $year - $corporate_year;


            if($diff >= 6){
                echo json_encode('fail');
                return NULL;
            }
            elseif($diff > 3){ //f the company is between 3 and 6 tax years in age, a new message should arrive:
                echo json_encode('middle');
                return NULL;
            }else{
                echo json_encode('pass');
                return NULL;
            }
        }
    }

    public function save_questions_answers(){
        if($this->input->post('Cuserid')){ // Save Questions from Back end
            $UserID = $this->input->post('Cuserid');
            $listing_id = $this->input->post('listing_id');
        }else{
            $UserID     = $this->session->userdata('cal_user_id');// Save Questions from front end
            $listing_id = $this->session->userdata('esic_id');// Save Questions from front end
        }
        $Qid   = $this->input->post('Qid');
        $ans  = $this->input->post('ans');
        $where =  array(
            'user_id'    => $UserID,
            'questionID' => $Qid,
            'listing_id' => $listing_id,
        );
        $selectedQuestionAnswerObj  = $this->Common_model->select_fields_where('calculator_questions_answers','id',$where,true);
        $selectedQuestionID = $selectedQuestionAnswerObj->id;

        if(!empty($selectedQuestionAnswerObj) && is_numeric($selectedQuestionID)) {
            $data = array(
                'ans'          => $ans,
                'updated_at'   => date('Y-m-d'),
            );
            $where =  array(
                'id'    => $selectedQuestionID
            );
            $response = $this->Common_model->update('calculator_questions_answers',$where,$data); //returns boolean if successfully updated.
        }else{
            $data = array(
                'user_id'      => $UserID,
                'questionID'   => $Qid,
                'listing_type' => 1, // 1 for  esic listing table
                'listing_id'   => $listing_id,
                'ans'          => $ans,
                'created_at'   =>  date('Y-m-d'),
                'updated_at'   => date('Y-m-d'),
            );
            $response = $this->Common_model->insert_record('calculator_questions_answers',$data);
        }
        if($response){
            echo 'OK::Record Successfully Added::success';
            return true;
        }

    }
}