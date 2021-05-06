<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Investor extends Listing{

    public $data                = array('');
    public $CurrentID           = 0;
    public $LogoDbField         = 'logo';
    public $BannerDbField       = 'banner';
    public $tableName           = 'esic_investors';
    public $tableFID            = 'investorID';
    public $tableNameSocial     = 'investor_social';
    public $BannerNamePrefix    = 'InvestorBanner';
    public $LogoNamePrefix      = 'InvestorLogo';
    public $Name                = 'Investor';
    public $NameMessage         = 'Investor';
    public $ImagesFolderName    = 'investor';
    public $ViewFolderName      = 'investor';
    public $ListFileName        = 'investor';
    public $ControllerName      = 'Investor';
    public $ControllerRouteName = 'Investor';
    public $ControllerRouteManage = 'manage_investor';

    public $QuestionsView       = 'investor_questions';
    public $QuestionListingID   = 2; //This is the Listing Type ID. which is investor in our case.
    public $hasQuestionaire     = false;
    public $versionTable        = 'esic_investors_ver';
    public $listingField        = 'investor_id';
    public $listingDatabase     = 'investor_database';


    function __construct(){
        parent::__construct();
        $this->load->helper('viewinvestor');
        $this->data['industires']        = $this->Common_model->select('esic_sectors');
        $this->data['esicStatues']       = $this->Common_model->select('esic_status');
        $this->data['investorTypes']     = $this->Common_model->select('investor_types');
        $this->data['investmentAmounts'] = $this->Common_model->select('investors_preferred_investment_amounts');
        $this->load->model('Investor_model');

        //Validate the Views that needs the Redirect to Login Page if User is Not Logged In.
        $this->validate_login(['Manage','View','Edit']);
    }
    public function Certificate(){
        $userID    = $this->input->post('userID');
        $ListingID = $this->input->post('listingID');
        $return = array();
        $allowedExt = array('pdf','txt','doc','docx','jpeg','jpg','png','gif');
        if(!empty($userID) && !empty($ListingID)){
            $CertificateDbField= 'certificate';
            $uploadPath        = './certificate/'.$this->ImagesFolderName.'/'.$userID.'/'.$ListingID;
            $uploadDirectory   = './certificate/'.$this->ImagesFolderName.'/'.$userID.'/'.$ListingID;
            $uploadDBPath      = 'certificate/'.$this->ImagesFolderName.'/'.$userID.'/'.$ListingID;
            $insertDataArray   = array();

            if(isset($_FILES['certificate']['name']) && !empty($_FILES['certificate']['name'])){
                $FileName           = $_FILES['certificate']['name'];
                $explodedFileName   = explode('.',$FileName);
                $ext                = end($explodedFileName);
                if(!in_array(strtolower($ext),$allowedExt)){
                    $error =  "FAIL:: Certificate -- Only Image JPEG, PNG, GIF Images And Docs or PDF Allowed, No Other Extensions Are Allowed::error";
                    array_push($return, $error);
                }else{

                    $FileName = 'Certificate'.$userID.'_'.$ListingID.'_'.time().'.'.$ext;
                    if(!is_dir($uploadDirectory)){
                        mkdir($uploadDirectory, 0755, true);
                    }
                    move_uploaded_file($_FILES['certificate']['tmp_name'],$uploadPath.'/'.$FileName);
                    $insertDataArray[$CertificateDbField] = $uploadDBPath.'/'.$FileName;
                    $selectData = array(
                        $CertificateDbField.' AS certificate',
                        false);
                    $where = array( 'id' => $ListingID );
                    $returnedData = $this->Common_model->select_fields_where($this->tableName,$selectData, $where, false, '', '', '','','',false);
                    $certificate = $returnedData[0]->certificate;
                    if(!empty($certificate) && is_file(FCPATH.'/'.$certificate)){
                        unlink('./'.$certificate);
                    }
                    $resultUpdate = $this->Common_model->update($this->tableName,$where,$insertDataArray);
                    if($resultUpdate === true){
                        $success = "OK::Certificate Uploaded::success";
                        array_push($return, $success);
                    }else{
                        $error = "FAIL::Certificate -- Something went wrong during Update, Please Contact System Administrator::error";
                        array_push($return, $error);
                    }
                }
            }else{
                 $error = "FAIL::Certificate File Not Given::error";
                 array_push($return, $error);
            }
        }else{
           $error = "FAIL::UserID and InvestorID Not Given ::error";
           array_push($return, $error);
        }
        echo $return[0];
        return Null;
    }
    /**From Old Controller **/
    public function index(){
        $selectData = array('score AS score',false);

        $where = array(
            'trashed !=' => 1,
            'insertionType !=' => 2
        );

        $selectData ='*';
        $data['userID'] = $this->input->get('id');
        $data['statusApp'] = $this->Common_model->select('esic_appstatus');
        $data['RnDs'] = $this->Common_model->select_fields_where('esic_rnd',$selectData, $where);
        $data['institutions'] = $this->Common_model->select_fields_where('esic_institution',$selectData, $where, false, '', '', '','','',false);
        $data['accelerationCommercials'] = $this->Common_model->select_fields_where('esic_acceleration',$selectData, $where, false, '', '', '','','',false);
        $data['acceleratorProgramme'] = $this->Common_model->select_fields_where('esic_accelerators',$selectData, $where, false, '', '', '','','',false);
        $data['sectors'] = $this->Common_model->select_fields_where('esic_sectors',$selectData, $where, false, '', '', '','','',false);
        $data['company'] = $this->Common_model->select('esic');

        $this->load->view('structure/header', $data);
        $this->load->view('regForm/reg_form_bootstrap2', $data);
        $this->load->view('structure/footer');
    }  //not in use
    public function investor_search(){

        $resultsFor = $this->input->post('resultsFor');
        $keyword    = $this->input->post('keyword');

        $filterStartDate  = $this->input->post('filterStartDate');
        $filterEndDate    = $this->input->post('filterEndDate');

        $statusFilter     = $this->input->post('statusFilter');

        $selectData = '*';
        $where = '';
        if(!empty($keyword)){
            $where = 'email LIKE "%' .$keyword.'%" OR company_name LIKE "%' .$keyword.'%" OR firstName LIKE "%' .$keyword.'%" OR lastName LIKE "%' .$keyword.'%"';
        }

        if(!empty($filterStartDate) && !empty($filterEndDate) ){
            $where = '( email LIKE "%' .$keyword.'%" OR company_name LIKE "%' .$keyword.'%" OR firstName LIKE "%' .$keyword.'%" OR lastName LIKE "%' .$keyword.'%" )';
            $where .=' AND ( added_date BETWEEN "'.$filterStartDate.'" AND "'.$filterEndDate.'" )';
        }
        if(!empty($statusFilter)){
            if(!empty($keyword) || !empty($filterStartDate)){
                $where .=  ' AND';
            }
             $where .=  'status = '.$statusFilter.' ';
        }



        $joins = array(
            array(
                'table'     => 'esic_investor EI',
                'condition' => 'EI.fk_investor_ID = hoosk_user.userID',
                'type'      => 'RIGHT'
            ),
            array(
                'table'     => 'investor_social EIS',
                'condition' => 'EIS.fk_user_ID = hoosk_user.userID',
                'type'      => 'LEFT'
            )
        );

        $data['list'] = $this->Common_model->select_fields_where_like_join('hoosk_user',$selectData,$joins,$where);
        //$data['Query'] = $this->db->last_query();
        $data['filterStartDate']    =  $filterStartDate;
        $data['filterEndDate']      =  $filterEndDate;
        $data['keyword']            =  $keyword;

        $this->load->view('structure/header');
        $data['Title'] = 'Investors';
        $this->load->view('structure/header',$this->data);
        $this->load->view('templates/listing',$data);
        $this->load->view('structure/footer');
    }
    public function innovator_search(){
        $keyword    = $this->input->post('keyword');
        $page        =  0;
        $secSelect   =  '';
        $comSelect   =  '';
        $searchInput =  $keyword ;
        $orderSelect =  '';
        $orderSelectValue = '';
        $this->load->model('Esic_model');
        $data['list'] = $this->Esic_model->getfilterlist($page,$searchInput,$secSelect,$comSelect,$orderSelect,$orderSelectValue);
        $this->load->view('structure/header',$this->data);
        $this->load->view("box_listing/getlist",$data);
        $this->load->view('structure/footer');
    }
    public function investor_list($param=NULL){


        Admincontrol_helper::is_logged_in($this->session->userdata('userID'));
        $userRole = $this->session->userdata('userRole');
        if($param === 'listing'){
                $selectData = array('
            userID as UserID,
            CONCAT(`firstName`," ",`lastName`) AS FullName,
            email AS Email, 
            CASE WHEN EI.status = 0 THEN CONCAT("<span class=\'label status label-danger\'>Pending</span>") ELSE CONCAT("<span class=\'label status label-success\'>Published</span>") END AS Status ',false);
                $joins = array(
                    array(
                        'table'     => 'esic_investor EI',
                        'condition' => 'EI.fk_investor_ID = hoosk_user.userID',
                        'type'      => 'RIGHT'
                    )
                );


                $addColumns = array(
                    'ViewEditActionButtons' => array('<a href="#" data-target=".change-status" data-toggle="modal"><i data-toggle="tooltip" title="Change Status" data-placement="left" class="fa fa-check"></i></a><a href="'.BASE_URL.'/admin/investor/edit_profile/$1" id="edit"><i data-toggle="tooltip" title="Edit Investor" data-placement="left"  class="fa fa-pencil ml-fa"></i></a><a href="#" data-target=".approval-modal" data-toggle="modal"><i data-toggle="tooltip" title="Trash" data-placement="left"  class="fa fa-trash-o text-red ml-fa"></i></a>','UserID')
                );
                $returnedData = $this->Common_model->select_fields_joined_DT($selectData,'hoosk_user',$joins,'','','','',$addColumns);
                print_r($returnedData);
                return NULL;
            }
            if($param === 'allvalues'){

                $returnedData = $this->Common_model->select('esic_investor');

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

                    echo "FAIL::Posted values are not VALID";

                    return NULL;

                }



                if(empty($value)){

                    echo "FAIL::Posted values are not VALID";

                    return NULL;

                }

                $data='';

                if($value == 'delete'){

                    $returnedData = $this->Investor_model->delete_Investor($id);

                    echo "OK::Record Deleted";

                }else{

                    echo "FAIL::Record Not Deleted";

                }

                return NULL;

            }
            if($param === 'status'){

                if(!$this->input->post()){

                    echo "FAIL::No Value Posted";

                    return false;

                }



                $id = $this->input->post('id');

                $value = $this->input->post('value');



                if(empty($id) or !is_numeric($id)){

                    echo "FAIL::Posted values are not VALID";

                    return NULL;

                }



                if(empty($value)){

                    echo "FAIL::Posted values are not VALID";

                    return NULL;

                }

                $data='';

                if($value == 'status'){

                    $returnedData = $this->Investor_model->update_Investor_status('esic_investor',$id);

                    echo "OK::Status Change";

                }else{

                    echo "FAIL::Status Not Change";

                }

                return NULL;

            }
        $this->show_admin("investor/investor_list",$data);
    }

    public function investor_form(){
        $this->load->view('structure/header',$this->data);
        $this->load->view('templates/'.$this->data['page']['pageTemplate'], $this->data);
        $this->load->view('investor/investor-form',$this->data);
        $this->load->view('structure/footer');
    }
    public function submit(){             // Insert investor form

        $firstName = strip_tags($this->input->post('firstName'));
        $lastName  = strip_tags($this->input->post('lastName'));
        $email     = strip_tags($this->input->post('email'));
        $early_stage_investor = $this->input->post('early_stage_investor');
        $rebate          = $this->input->post('rebate');
        $al_fd_company   = $this->input->post('al_fd_company');
        $company_name    = $this->input->post('company_name');
        $company_email   = $this->input->post('company_email');
        $hold_investment = $this->input->post('hold_investment');
        $affiliate_ESIC  = $this->input->post('affiliate_ESIC');
        $ent_con_ESIC    = $this->input->post('ent_con_ESIC');
        $widely_held_company = $this->input->post('widely_held_company');
        $situation1 = $this->input->post('situation1');
        $situation2 = $this->input->post('situation2');
        $situation3 = $this->input->post('situation3');
        $Act_2001   = $this->input->post('Act_2001');
        $info_ESICs = $this->input->post('info_ESICs');
        $added_date = date('Y-m-d');

        // upload certificate image
        if (!empty($_FILES['certificate']['name'])) {
            $config['allowed_types'] = "gif|jpg|png|jpeg|pdf|doc|docx|ppt|pptx|pps|ppsx";
            $config['upload_path'] = 'uploads/investor/';
            $config['file_name'] = $_FILES['certificate']['name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('certificate')) {
            } else {
                echo $this->upload->display_errors();
                exit;
            }

            $image_name = str_replace(" ", "_", $_FILES['certificate']['name']);
            //  echo   $filepath        = base_url().'uploads/investor/'.$name;
        }
        //end imgae code

        if (empty($firstName) || empty($lastName)) {
            echo "FAIL::Please Enter Complete Name";
            exit;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            echo "FAIL::Please Enter a valid Email Address";
            exit;
        }

        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < 10; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        $Send_password = $result;
        $password = md5($result . SALT);

        $userName = $firstName . $lastName;
        $userName = str_replace(" ", "_", $userName);
        $userInsertArray = array(
            'userName' => $userName,
            'firstName'=> $firstName,
            'lastName' => $lastName,
            'email'    => $email,
            'password' => $password,
            'userRole' => 3,
            // 'RS'       => $Send_password // temprerry save password just for testing remove it
        );
        $fk_investor_ID = $this->Common_model->insert_record('hoosk_user', $userInsertArray);
        $userInvestorArray = array(
            'fk_investor_ID' => $fk_investor_ID,
            'e_st_investor'  => $early_stage_investor,
            'rebate'         => $rebate,
            'al_fd_company'  => $al_fd_company,
            'company_name'   => $company_name,
            'company_email'  => $company_email,
            'hold_investment'=> $hold_investment,
            'affiliate_ESIC' => $affiliate_ESIC,
            'ent_con_ESIC'   => $ent_con_ESIC,
            'widely_held_company' => $widely_held_company,
            'situation1'     => $situation1,
            'situation2'     => $situation2,
            'situation3'     => $situation3,
            'Act_2001'       => $Act_2001,
            'info_ESICs'     => $info_ESICs,
            'added_date'     => $added_date,
            'certificate'    => $image_name,
            'status'         => 0
        );
        $add_fk_user_id = array(
            'fk_user_id' => $fk_investor_ID
        );
        $this->Common_model->insert_record('investor_social', $add_fk_user_id);
        $insertID = $this->Common_model->insert_record('esic_investor', $userInvestorArray);
        if ($insertID > 0) {
            //email
            $settings = $this->Hoosk_model->getSettings();
            $siteEmail = $settings[0]['siteEmail'];
            $subject = "Esic Directory User Name  And Password";
            $message = "<h4>Hi</h4><h5>". "  " . $firstName . " " . $lastName  . "  </h5> You can login and update your info <br>";
            $message .= "<h4>Your User name:   </h4>" . $userName . "    " . "<br><h4>Your Password:   </h4>" . $Send_password;
            $this->load->library('email');
            $config = array();
            $config['useragent'] = "CodeIgniter";
            $config['protocol'] = "smtp";
            $config['smtp_host'] = "gator3083";
            $config['smtp_port'] = "25";
            $config['mailtype'] = 'html';
            $config['charset'] = 'utf-8';
            $config['newline'] = "\r\n";
            $config['wordwrap'] = TRUE;
            $this->email->initialize($config);
            $this->email->from($siteEmail, 'From: Esic Directory');
            $this->email->to($email);
            $this->email->subject($subject);
            $this->email->message($message."<br><br>".base_url()."/admin");
            $this->email->send();
            //email end
            $this->session->set_userdata('msg', 'Thank you. Your Information has been added Successfully');
            header('Location:' . base_url() . 'investor_pre_assessment');
        } elseif (empty($insertID) || !is_numeric($insertID)) {
            echo $this->db->last_query();
            $this->db->trans_rollback();
            die("FAIL::Something Went wrong, Could Not Insert");
        }
        else
        {
            $this->load->view('structure/header');
            $this->load->view('investor/investor-form');
            $this->load->view('structure/footer');
        }
    }
    public function email_check(){
        if($this->input->is_ajax_request())
        {
            $email = $this->input->post('email');
            if(!$this->form_validation->is_unique($email, 'hoosk_user.email'))
            {
                $this->output->set_content_type('application/json')->set_output(json_encode(array('message' => '
                The email is already taken, choose another one')));
            }
        }
    }
    public function password_check(){
        $id   = $this->input->post('id');
        $pass = md5($this->input->post('password').SALT);
        $ok   = $this->Investor_model->password_check($id,$pass);
        echo $ok;
    }

    public function view_profile($id=NULL){
        $data['User_data']  =$this->Investor_model->get_investor_data('esic_investor',$id);
        $data['User_social']=$this->Investor_model->get_investor_social($id);
        $this->load->view('admin/header');
        $this->load->view('investor/view_profile',$data);
        $this->load->view('admin/footer');
    }
    public function edit_profile($id=NULL){
        Admincontrol_helper::is_logged_in($this->session->userdata('userID'));
        $userRole = $this->session->userdata('userRole');
        $userID = $this->session->userdata('userID');
        if($userRole != 1 && $userID == $id){      //other user can not update profile by changing url id
            $data['User_data']  =$this->Investor_model->get_investor_data('esic_investor',$id);
            $data['User_social']=$this->Investor_model->get_investor_social($id);
            $this->load->view('admin/header');
            $this->load->view('investor/edit_profile',$data);
            $this->load->view('admin/footer');
        }
        elseif(isCurrentUserAdmin($this)){                   // for super admin
            $data['User_data']  =$this->Investor_model->get_investor_data('esic_investor',$id);
            $data['User_social']=$this->Investor_model->get_investor_social($id);
            $this->load->view('admin/header');
            $this->load->view('investor/edit_profile',$data);
            $this->load->view('admin/footer');
        }
        else{
            $this->load->view('admin/page_not_found');
        }
    }
    public function edit_investor_profile($para=NULL){
        Admincontrol_helper::is_logged_in($this->session->userdata('userID'));
        if($para == 'security'){
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[hoosk_user.email]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            if ($this->form_validation->run() != FAlSE) {
                $id = $this->input->post('id');
                $email = $this->input->post('email');
                $pass  = md5($this->input->post('password').SALT); //new password
                $cpass = md5($this->input->post('cpassword').SALT);//Current password
                $ok = $this->Investor_model->update_security($id, $email, $pass, $cpass);
                echo $ok;
            }
        }
        elseif($para == "social"){
            $id       = $this->input->post('id');
            $facebook = $this->input->post('facebook');
            $twitter  = $this->input->post('twitter');
            $google   = $this->input->post('google');
            $linkedIn = $this->input->post('linkedIn');
            $youTube  = $this->input->post('youTube');
            $vimeo    = $this->input->post('vimeo');
            $data     = array(
                'facebook' => $facebook,
                'twitter'  => $twitter,
                'google'   => $google,
                'linkedIn' => $linkedIn,
                'youTube'  => $youTube,
                'vimeo'    => $vimeo
            );
            $ok       = $this->Investor_model->update_social($id,$data);
            echo $ok;
        }
        elseif($para == "question"){
            $id       = $this->input->post('id');
            $qno      = $this->input->post('qno');
            $value    = $this->input->post('value');
            $data     = array(
                $qno => $value
            );
            //insert data into colum qno and add value
            $ok       = $this->Investor_model->update_question($id,$data);
            echo $ok;
        }
        elseif($para == "company_detail"){
            $id       = $this->input->post('id');
            $c_name   = strip_tags( $this->input->post('c_name'));
            $c_email  = $this->input->post('c_email');
            $data     = array(
                'company_name'  => $c_name,
                'company_email' => $c_email,
            );
            $ok        = $this->Investor_model->update_company_detail($id,$data);
            echo $ok;

        }
        elseif($para == "situation"){
            $id       = $this->input->post('id');
            $situation1   = $this->input->post('situation1');
            $situation2  = $this->input->post('situation2');
            $situation3  = $this->input->post('situation3');
            $data     = array(
                'situation1' => $situation1,
                'situation2' => $situation2,
                'situation3' => $situation3,
            );
            $ok        = $this->Investor_model->update_company_situation($id,$data);
            echo $ok;
        }
        elseif($para == "about"){                                            //update first name and last name  and about
            $id           = $this->input->post('id');
            $value        = $this->input->post('value');
            $input_id     = $this->input->post('input_id');
            if($input_id == '1'){
                $value    = strip_tags($value);
                $data     = array('firstName' => $value);
            }
            elseif($input_id == '2'){
                $value    = strip_tags($value);
                $data      = array('lastName'  => $value);
            }
            elseif($input_id == '3'){
                $data      = array('about'  => $value);
            }
            $ok        = $this->Investor_model->update_user_about($id,$data,$input_id);
            echo $ok;
        }
        elseif($para == "address"){
            $id       = $this->input->post('id');
            $address  = strip_tags($this->input->post('address'));
            $data     = array(
                'address' => $address,
            );
            $ok       = $this->Investor_model->update_company_detail($id,$data);  //use same function in model
            echo $ok;
        }
    }
    public function edit_certificate_picture($id=NULL)
    {
        $id  = $id;
        if(!empty($_FILES['certificate']['name'])){
            $config['allowed_types'] = "gif|jpg|png|jpeg|pdf|pdf|doc|docx";
            $config['upload_path']  = 'uploads/investor/';
            $config['file_name']    = $_FILES['certificate']['name'];
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            if($this->upload->do_upload('certificate'))
            {
            }
            else{
                echo $this->upload->display_errors();
                exit;
            }
            $image_name = str_replace(" ","_",$_FILES['certificate']['name']);
            //  echo   $filepath        = base_url().'uploads/investor/'.$name; 
        }
        //end imgae code
        $data     = array(
            'certificate' => $image_name,
        );
        if($image_name){
            $ok       = $this->Investor_model->update_certificate($id,$data);
        }
        else{
            $ok = "ok";
        }
        echo $image_name;
    }
    public function edit_profile_picture($id=NULL)
    {
        $id  = $id;
        if(!empty($_FILES['image']['name'])){
            $config['allowed_types'] = "gif|jpg|png|jpeg";
            $config['upload_path']  = 'uploads/investor/';
            $config['file_name']    = $_FILES['image']['name'];
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            if($this->upload->do_upload('image'))
            {
            }
            else{
                echo $this->upload->display_errors();
                exit;
            }
            $image_name = str_replace(" ","_",$_FILES['image']['name']);
            //  echo   $filepath        = base_url().'uploads/investor/'.$name; 
        }
        //end imgae code
        $data     = array(
            'image' => $image_name,
        );
        if($image_name){
            $ok       = $this->Investor_model->update_certificate($id,$data);
        }
        else{
            $ok = "ok";
        }
        echo $image_name;
    }
}
