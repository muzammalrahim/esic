<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends MY_Controller {
	function __construct(){
		parent::__construct();
        Admincontrol_helper::is_logged_in($this->session->userdata('userName'));        ;
	}
	public function index($status=NULL){
			$this->data['current']               = $this->uri->segment(2);

            if(checkUserHasRole($this,'Esic') == true){
    			$this->data['TotalEsic']   = $this->Esic_model->count();
                $this->data['Esic_By_status']        = $this->Esic_model->getEsicByStatus($status);
                 $this->data['status']                = $this->Common_model->select('esic_status');
            }
            if(checkUserHasRole($this,'Investor') == true){
                $this->data['TotalInvestors']        = $this->Investor_model->count();
            }
            if(checkUserHasRole($this,'Accelerator') == true){
                $this->data['TotalAccelerators']     = $this->Accelerator_model->count();
            }
            if(checkUserHasRole($this,'RndPartner') == true){
                $this->data['TotalRndPartners']      = $this->Rndpartner_model->count();
            }
            if(checkUserHasRole($this,'RndConsultant') == true){
                $this->data['TotalRndConsultants']   = $this->Rndconsultant_model->count();
            }
            if(checkUserHasRole($this,'TaxAdvisors') == true){
                $this->data['Total_Tax_Advisers']   = $this->Common_model->count_rows('esic_taxadvisors',array());
            }
            if(checkUserHasRole($this,'Lawyer') == true){
                $this->data['TotalLawyers']          = $this->Lawyer_model->count();
            }
            if(checkUserHasRole($this,'GrantConsultant') == true){
                $this->data['TotalGrantConsultants'] = $this->Grantconsultant_model->count();
            }
            if(checkUserHasRole($this) == true){
                $this->data['TotalUniversities']     = $this->University_model->count();
                $this->data['TotalUsers']            = $this->User_model->count();
               
            }

		    $this->data['header']                = $this->load->view('admin/header', $this->data, true);
		    $this->data['footer']                = $this->load->view('admin/footer', '', true);  
		 	$this->load->view('admin/home', $this->data);
	}
	public function esicDashBoardListing(){ 
	   $status = $this->input->post('status');
       $where = $this->User_model->getUserWhere('h_user');
	   $selectData = array('
            esic.id as ID,
			esic.name AS Name,
            esic.website AS Website,
			esic.score AS Score,
            ES.id as StatusID, 
            ES.color AS color,
             CASE WHEN ES.id > 0 THEN CONCAT("<span class=\'label \' style=\' background-color:",color,"\'> ", ES.status," </span>") ELSE CONCAT ("<span class=\'label label-warning\'> ", ES.status, " </span>") END AS Status 
            ',false);
			 
       $joins = array(
                array(
                    'table' 	=> 'esic_status ES',
                    'condition' => 'ES.id = esic.status',
                    'type' 		=> 'LEFT'
                ),
				 array(
                    'table' 	=> 'hoosk_user h_user',
                    'condition' => 'h_user.userID = esic.userID',
                    'type' 		=> 'LEFT'
                ),
				
			 );

       $whereUser = array('hoosk_user.userID' => $userID);
        if(!empty($status)){ 
		    $where['esic.status'] = $status;
		}
        $addColumns = array(
            'ViewEditActionButtons' => array('<a href="'.base_url("admin/Esic/view/$1").'"><span aria-hidden="true" class="glyphicon glyphicon-edit text-green "></span></a>','ID')
        );
        $returnedData = $this->Common_model->select_fields_joined_DT($selectData,'esic',$joins,$where,'','','',$addColumns);
		   
		if(!empty($status)){ 
			return print_r($returnedData);
		}else{
			print_r($returnedData);
		}
    return NULL;
	}
    public function allDashBoardListing($offset = 0){
        if(isCurrentUserAdmin($this)) {
           /* $result = $this->Hoosk_model->countAllListings();
            $this->load->library('pagination');
            if($offset != 0) $offset = $offset/6;
            $limit = 2;
            $searchText = $this->input->post('searchText');
            $searchType = $this->input->post('searchType');
            $listType = $this->input->post('listType');
            if($searchType == 'list_type' && $searchText != '')
                $data['tbl']  = $searchText;
            else if($listType != '')
                $data['tbl'] = $listType;
            $data['listings'] = $this->Hoosk_model->getAllListings($offset, $limit, $searchText, $searchType, $listType);
            $config['base_url'] = '#';
            $config['total_rows'] = $result[0]->ids;
            $config['per_page'] = 12;
            $config['num_links'] = 6;
            $config['attributes'] = array('class' => 'customLinks');
            $this->pagination->initialize($config);*/
            $data['listings'] = $this->Hoosk_model->getAllListings();
            $htmlResponse = $this->load->view('admin/allListings', $data, true);
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('listings' => $htmlResponse)));
        }
    }
    public function settings(){
		if(isCurrentUserAdmin($this)){
			//Load the form helper
			$this->load->helper('form');
			$this->load->helper('directory');

			$this->data['themesdir'] = directory_map(DoucmentUrl.'/templates/', 1);
			$this->data['langdir'] = directory_map(APPPATH.'/language/', 1);

			$this->data['settings'] = $this->Hoosk_model->getSettings();
			$this->data['current'] = $this->uri->segment(2);
			$this->data['header'] = $this->load->view('admin/header', $this->data, true);
			$this->data['footer'] = $this->load->view('admin/footer', '', true);
			$this->load->view('admin/settings', $this->data);
		}else{
			$this->load->view('admin/page_not_found');
		}
	}
	public function updateSettings(){
		if ($this->input->post('siteLogo') != ""){
			//path to save the image
			$path_upload = DoucmentUrl.'/uploads/';
			$path_images = DoucmentUrl.'/images/';
			//moving temporary file to images folder
			if(rename($path_upload . $this->input->post('siteLogo'), $path_images . $this->input->post('siteLogo'))){
				//if the file was uploaded then update settings
				$this->Hoosk_model->updateSettings();
				redirect('/admin/settings', 'refresh');
			}else{
				//return to settings
				$this->settings();
			}
		}else{
			$this->Hoosk_model->updateSettings();
			redirect('/admin/settings', 'refresh');
		}
	}
	public function uploadLogo(){
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'gif|jpg|png';
		$this->load->library('upload', $config);
		foreach ($_FILES as $key => $value) {
			if ( ! $this->upload->do_upload($key)){
					$error = array('error' => $this->upload->display_errors());
					echo 0;
			}else{
					echo '"'.$this->upload->data('file_name').'"';
			}
		}
	}
	public function social(){
		if(isCurrentUserAdmin($this)){
	    	//Load the form helper
			$this->load->helper('form');

			$this->data['social'] = $this->Hoosk_model->getSocial();
            $this->data['fb_data'] = $this->Hoosk_model->getSocial_creaditional();
            $this->data['current'] = $this->uri->segment(2);
			$this->data['header'] = $this->load->view('admin/header', $this->data, true);
			$this->data['footer'] = $this->load->view('admin/footer', '', true);
			$this->load->view('admin/social', $this->data);
	    }else{
			  $this->load->view('admin/page_not_found');
			 }
	}
    public function updateSocial(){
		$this->Hoosk_model->updateSocial();
		redirect('/admin', 'refresh');
	}
    public function social_creaditional(){

           $fb_id  = $this->input->post('id');
           $fb_sec = $this->input->post('fb_sec');
           $this->Hoosk_model->social_creaditional($fb_id,$fb_sec);
            echo "ok";
    }
 public function assessments_list($list=NULL){
	 if(isCurrentUserAdmin($this)){
        if($list === 'listing'){
            $selectData = array('
            h_user.userID as UserID,
			CONCAT(`h_user`.`firstName`," ",`h_user`.`lastName`) AS FullName,
            h_user.email AS Email,
			name AS Company,
            esic.business AS Business,
            esic.score AS Score,
            esic.thumbsUp as thumbsUp,
            ES.id as StatusID, 
            esic.Publish as Publish,
			ES.color AS color,
             CASE WHEN ES.id > 0 THEN CONCAT("<span class=\'label \' style=\' background-color:",color,"\'> ", ES.status," </span>") ELSE CONCAT ("<span class=\'label label-warning\'> ", ES.status, " </span>") END AS Status 
            ',false);
            $joins = array(
                array(
                    'table' 	=> 'esic_status ES',
                    'condition' => 'ES.id = esic.status',
                    'type' 		=> 'LEFT'
                ),
				 array(
                    'table' 	=> 'hoosk_user h_user',
                    'condition' => 'h_user.userID = esic.userID',
                    'type' 		=> 'LEFT'
                )
            );
            $addColumns = array(
                'ViewEditActionButtons' => array('<a href="'.base_url("admin/details/$1").'"><span aria-hidden="true" class="glyphicon glyphicon-edit text-green "></span></a> &nbsp; <a href="#" data-target=".approval-modal" data-toggle="modal"><i class="fa fa-check"></i></a> &nbsp; <a href="#" data-target=".delete-modal" data-toggle="modal"><i class="fa fa-trash-o"></i></a>','UserID')
            );
            $returnedData = $this->Common_model->select_fields_joined_DT($selectData,'esic',$joins,'','','','',$addColumns);
            print_r($returnedData);
            return NULL;
        }

        $data['title'] = 'Pre-assessment List';
        $this->show_admin("admin/reg_list",$data);
    }
	else{
		$this->load->view('admin/page_not_found');
		}
 }
    public function esic_sessions(){        
        $this->data['header'] = $this->load->view('admin/header', $this->data, true);
        $this->data['get_sessions'] = $this->Esic_model->get_sessions();
        $this->data['total'] = $this->Esic_model->count_sessions();
        $this->data['footer'] = $this->load->view('admin/footer', $this->data, true);
        $this->load->view('admin/configuration/sessions', $this->data);

    }
    public function barcode(){
        $this->load->view('admin/configuration/barcode');
    }

    public function fetch_esic_status(){
        $ID          = $this->input->post('id');
        $where       = array('id' => $ID);
        $result      = $this->Common_model->select_fields_where('esic','prior_year_status',$where,true);
        $esic_status = $this->Common_model->select('esic_status');
        $json        = json_decode($result->prior_year_status, true);
        $array       = array();
        if($json) {
            foreach ($json as $status) {
                foreach ($esic_status as $esicstatus) {
                    if ($esicstatus->id == $status['status']) {
                        $arrays = array(
                            'year' => $status['year'],
                            'status_id' => $status['status'],
                            'status' => $esicstatus->status,
                            'color' => $esicstatus->color,
                        );
                        array_push($array, $arrays);
                    }
                }
            }
        }
        echo  $data = json_encode($array);
        return $data;
    }
    public function assessment_list(){
	    $userID = $this->input->post('id');
	    $status = $this->input->post('value');
        $statusValue = $this->input->post('statusValue');
        $myJSON = json_encode($statusValue);
        $statusValue = $statusValue[0]['status'];
        if(!isset($userID) || empty($userID)){
            echo "FAIL::Something went wrong with the post, Please Contact System Administrator for Further Assistance";
            return;
        }
        if($status === 'delete'){
            $whereUpdate = array( 'id' 	=> $userID);
            $where2 = array( 'id'  => $userID);
            //$this->Common_model->delete('hoosk_user',$whereUpdate);
            $this->Common_model->delete('esic',$whereUpdate);
            $this->Common_model->delete('esic_questions_answers',$where2);
            echo 'OK::';
            return NULL;
        }
        //UpdateData
        $updateArray = array();
        if($status === 'approve'){
            $updateArray['status'] = empty($statusValue) ? 1 : $statusValue;
            $updateArray['prior_year_status'] = $myJSON;
        }

        if($status === 'publish'){
               $updateArray['Publish'] = 1;
           // $this->Common_model->update_user_data($userID);
        }

        if($status === 'unpublish'){
            $updateArray['Publish'] = 0;
        }
        $whereUpdate = array(
            'id' => $userID,
         );

        $this->Common_model->update('esic',$whereUpdate,$updateArray);
        echo 'OK::';
    }

    public function details($listingID){
        $userRole = $this->session->userdata('userRole');
        $userID = $this->session->userdata('userID');
        $status = $this->input->post('value');
        $where = "h_user.userID =".$userID;
        $data = array();
        $selectData = array('
                    CONCAT(`h_user`.`firstName`," ",`h_user`.`lastName`) AS FullName,
                    h_user.email as Email,
                    esic.name as Company,
                    esic.business as Business,
                    esic.long_description as BusinessShortDesc,
                    esic.businessShortDescriptionJSON as BusinessShortDescJSON,
                    esic.short_description as short_description,
                    esic.score as Score,
                    esic.logo as Logo,
                    esic.productImage as productImage,
                    esic.banner as banner,
                    esic.website as Web,
                    esic.thumbsUp as thumbsUp,
                    esic.business as business,
                    esic.address as address,
                    esic.address_street_name as address_street_name,
                    esic.address_street_number as address_street_number,
                    esic.address_post_code as address_post_code,
                    esic.address_town as address_town,
                    esic.address_state as address_state,
                    esic.acn_number as acn_number,
                    esic.expiry_date as expiry_date,
                    esic.showExpDate as ShowExpiryDate,
                    esic.corporate_date as corporate_date,
                    esic.added_date as added_date,
                    esic.ipAddress as ipAddress,
                    esic.sectorID as sectorID,
                    esic.RnDID as RnDID,
                    esic.AccCoID as AccCoID,
                    esic.AccID as AccID,
                    esic.inID as inID,
                    ESEC.sector as sector,
                    esic.Publish as Publish
                   ',false);

        $joins = array(
            array(
                'table'     => 'esic_status ES',
                'condition' => 'ES.id = esic.status',
                'type'      => 'LEFT'
            ),
            array(
                'table'     => 'esic_sectors ESEC',
                'condition' => 'ESEC.id = esic.sectorID',
                'type'      => 'LEFT'
            ),
             array(
                'table'     => 'hoosk_user h_user',
                'condition' => 'h_user.userID = esic.userID',
                'type'      => 'LEFT'
            )
        );

        $returnedData = $this->Common_model->select_fields_where_like_join('esic',$selectData,$joins,$where,FALSE,'','');
        $returnedData2 =  $this->_getUserQAnswers($listingID,1); //1 is for ESIC Pre Assessments
        if(!empty($returnedData) and is_array($returnedData)){
            if($returnedData[0]->Score>0){
                $TotalPoints = $this->db->query('SELECT SUM(MaxPoints) AS TotalPoints FROM (SELECT id, questionID, MAX(Points) AS MaxPoints FROM esic_questions_score GROUP BY questionID) Points')->row()->TotalPoints;
                $ScorePercentage = $returnedData[0]->Score/$TotalPoints*100;
            }else{
                $TotalPoints = '';
                $ScorePercentage='';
            }
            $date1 = new DateTime(date('Y-m-d H:i:s'));
            $date2 = new DateTime($returnedData[0]->expiry_date);
            $diff = $date2->diff($date1)->format("%a");
            $data['userProfile'] = array(
                'userID'            => $listingID,
                'ScorePercentage'   => $ScorePercentage,
                'Web'               => $returnedData[0]->Web,
                'Logo'              => $returnedData[0]->Logo,
                'thumbsUp'          => $returnedData[0]->thumbsUp,
                'banner'       => $returnedData[0]->banner,
                'productImage'      => $returnedData[0]->productImage,
                'Email'             => $returnedData[0]->Email,
                'Score'             => $returnedData[0]->Score,
                'sector'            => $returnedData[0]->sector,
                'Company'           => $returnedData[0]->Company,
                'business'          => $returnedData[0]->business,
                'FullName'          => $returnedData[0]->FullName,
                'ipAddress'         => $returnedData[0]->ipAddress,
                'address'           => $returnedData[0]->address,
                'address_street_name'     => $returnedData[0]->address_street_name,
                'address_street_number'     => $returnedData[0]->address_street_number,
                'address_post_code'         => $returnedData[0]->address_post_code,
                'address_town'              => $returnedData[0]->address_town,
                'address_state'             => $returnedData[0]->address_state,
                'acn_number'        => $returnedData[0]->acn_number,
                'sectorID'          => $returnedData[0]->sectorID,
                'RnDID'             => $returnedData[0]->RnDID,
                'AccCoID'           => $returnedData[0]->AccCoID,
                'AccID'             => $returnedData[0]->AccID,
                'inID'              => $returnedData[0]->inID,
                'Publish'           => $returnedData[0]->Publish,
                'dateDiff'          => $diff,
                'added_date'        => date("d-M-Y", strtotime($returnedData[0]->added_date)),
                'expiry_date'       => date("d-M-Y", strtotime($returnedData[0]->expiry_date)),
                'corporate_date'    => date("d-M-Y", strtotime($returnedData[0]->corporate_date)),
                'added_date_value'        => date("d-m-Y", strtotime($returnedData[0]->added_date)),
                'expiry_date_value'       => date("d-m-Y", strtotime($returnedData[0]->expiry_date)),
                'corporate_date_value'    => date("d-m-Y", strtotime($returnedData[0]->corporate_date)),
                'BusinessShortDesc' => $returnedData[0]->BusinessShortDesc,
                'BusinessShortDescJSON' => $returnedData[0]->BusinessShortDescJSON,
                'short_description' => $returnedData[0]->short_description,
                'ShowExpiryDate' => $returnedData[0]->ShowExpiryDate
            );
            $QuestionNotAnswered = array();
            $QuestionAnswered = array();
            $QuestionAll = array();
            $QuestionsFirstArray = $this->Common_model->select('esic_questions');
            if(!empty($QuestionsFirstArray) and is_array($QuestionsFirstArray)){
                foreach($QuestionsFirstArray as $key=>$questionsObj){
                    $QuestionAll = array(
                        'questionID'    => $questionsObj->id,
                        'Question'      => $questionsObj->Question
                    );
                }
            }
            if(!empty($returnedData2) and is_array($returnedData2)){
                $data['usersQuestionsAnswers'] = array();
                foreach($returnedData2 as $key=>$obj){
                    $arrayToInsert = array(
                        'Question'          => $obj->Question,
                        'possibleSolutions' => $obj->PossibleSolution,
                        'questionID'        => $obj->questionID,
                        'providedSolution'  => $obj->ProvidedSolution
                    );
                    array_push($data['usersQuestionsAnswers'],$arrayToInsert);
                }
            }
        }
            $data['social'] = $this->Esic_model->get_user_Social($listingID);
            $data['uID'] = base64_encode($listingID);
            $this->show_admin("admin/reg_details",$data);
    }
    public function details_old($userID){   // edit pre asssessment page
		
		$userRole = $this->session->userdata('userRole');
		$id = $this->session->userdata('userID');
        $status = $this->input->post('value');

        $where = "h_user.userID =".$userID;
        $data = array();

		if(!isCurrentUserAdmin($this) && $userID == $id){  
            $selectData = array('
                    CONCAT(`h_user`.`firstName`," ",`h_user`.`lastName`) AS FullName,
                    h_user.email as Email,
                    user_draft.name as Company,
                    user_draft.business as Business,
                    user_draft.long_description as BusinessShortDesc,
                    user_draft.businessShortDescriptionJSON as BusinessShortDescJSON,
                    user_draft.short_description as short_description,
                    user_draft.score as Score,
                    user_draft.logo as Logo,
                    user_draft.productImage as productImage,
                    user_draft.banner as banner,
                    user_draft.website as Web,
                    user_draft.thumbsUp as thumbsUp,
                    user_draft.business as business,
                    user_draft.address as address,
					user_draft.address_street_number as address_street_number,
					user_draft.address_post_code as address_post_code,
                    user_draft.address_town as address_town,
                    user_draft.address_state as address_state,
                    user_draft.acn_number as acn_number,
                    user_draft.expiry_date as expiry_date,
                    user_draft.showExpDate as ShowExpiryDate,
                    user_draft.corporate_date as corporate_date,
                    user_draft.added_date as added_date,
                    user_draft.ipAddress as ipAddress,
                    user_draft.sectorID as sectorID,
                    user_draft.RnDID as RnDID,
                    user_draft.AccCoID as AccCoID,
                    user_draft.AccID as AccID,
                    user_draft.inID as inID,
                    ESEC.sector as sector,
                    user_draft.Publish as Publish
				   ',false);

            $joins = array(
                array(
                    'table' 	=> 'esic_status ES',
                    'condition' => 'ES.id = user_draft.status',
                    'type' 		=> 'LEFT'
                ),
                array(
                    'table' 	=> 'esic_sectors ESEC',
                    'condition' => 'ESEC.id = user_draft.sectorID',
                    'type' 		=> 'LEFT'
                ),
                array(
                    'table' 	=> 'hoosk_user h_user',
                    'condition' => 'h_user.userID = user_draft.userID',
                    'type' 		=> 'LEFT'
                )
            );

        $returnedData = $this->Common_model->select_fields_where_like_join('user_draft',$selectData,$joins,$where,FALSE,'','');
        $returnedData2 =     $this->_getUserQAnswers($userID,1); //1 is for ESIC Pre Assessments


        if(!empty($returnedData) and is_array($returnedData)){
            if($returnedData[0]->Score>0){
                $TotalPoints = $this->db->query('SELECT SUM(MaxPoints) AS TotalPoints FROM (SELECT id, questionID, MAX(Points) AS MaxPoints FROM esic_questions_score GROUP BY questionID) Points')->row()->TotalPoints;
                $ScorePercentage = $returnedData[0]->Score/$TotalPoints*100;
            }else{
                $TotalPoints = '';
                $ScorePercentage='';
            }
            // $date1 = new DateTime($returnedData[0]->corporate_date);
            $date1 = new DateTime(date('Y-m-d H:i:s'));
            $date2 = new DateTime($returnedData[0]->expiry_date);
            $diff = $date2->diff($date1)->format("%a");
            // if($diff> 60){
            //     $diff = '';
            //}
            $data['userProfile'] = array(
                'userID' 			=> $userID,
                'ScorePercentage' 	=> $ScorePercentage,
                'Web' 				=> $returnedData[0]->Web,
                'Logo' 				=> $returnedData[0]->Logo,
                'thumbsUp'          => $returnedData[0]->thumbsUp,
                'banner'       => $returnedData[0]->banner,
                'productImage'      => $returnedData[0]->productImage,
                'Email' 			=> $returnedData[0]->Email,
                'Score' 			=> $returnedData[0]->Score,
                'sector' 			=> $returnedData[0]->sector,
                //'Status' 			=> $returnedData[0]->Status,
                'Company'			=> $returnedData[0]->Company,
                'business' 			=> $returnedData[0]->business,
                'FullName' 			=> $returnedData[0]->FullName,
                'ipAddress'         => $returnedData[0]->ipAddress,
                'address'           => $returnedData[0]->address,
                'address_street_number'     => $returnedData[0]->address_street_number,
                'address_post_code'         => $returnedData[0]->address_post_code,
                'address_town'              => $returnedData[0]->address_town,
                'address_state'             => $returnedData[0]->address_state,
                'acn_number'        => $returnedData[0]->acn_number,
                'sectorID'          => $returnedData[0]->sectorID,
                'RnDID'             => $returnedData[0]->RnDID,
                'AccCoID'           => $returnedData[0]->AccCoID,
                'AccID'             => $returnedData[0]->AccID,
                'inID'              => $returnedData[0]->inID,
                'Publish'           => $returnedData[0]->Publish,
			    'dateDiff'          => $diff,
                'added_date' 		=> date("d-M-Y", strtotime($returnedData[0]->added_date)),
                'expiry_date' 		=> date("d-M-Y", strtotime($returnedData[0]->expiry_date)),
                'corporate_date' 	=> date("d-M-Y", strtotime($returnedData[0]->corporate_date)),
                'added_date_value'        => date("d-m-Y", strtotime($returnedData[0]->added_date)),
                'expiry_date_value'       => date("d-m-Y", strtotime($returnedData[0]->expiry_date)),
                'corporate_date_value'    => date("d-m-Y", strtotime($returnedData[0]->corporate_date)),
                'BusinessShortDesc' => $returnedData[0]->BusinessShortDesc,
                'BusinessShortDescJSON' => $returnedData[0]->BusinessShortDescJSON,
                'short_description' => $returnedData[0]->short_description,
                'ShowExpiryDate' => $returnedData[0]->ShowExpiryDate
            );
            $QuestionNotAnswered = array();
            $QuestionAnswered = array();
            $QuestionAll = array();
            $QuestionsFirstArray = $this->Common_model->select('esic_questions');
            if(!empty($QuestionsFirstArray) and is_array($QuestionsFirstArray)){
                foreach($QuestionsFirstArray as $key=>$questionsObj){
                    $QuestionAll = array(
                        'questionID'    => $questionsObj->id,
                        'Question'      => $questionsObj->Question
                    );
                }
            }
            if(!empty($returnedData2) and is_array($returnedData2)){
                $data['usersQuestionsAnswers'] = array();
                foreach($returnedData2 as $key=>$obj){
                    $arrayToInsert = array(
                        'points' 		=> $obj->score,
                        'Question' 		=> $obj->Question,
                        'TableName'     => $obj->tablenames,
                        'solution' 		=> $obj->solution,
                        'questionID' 	=> $obj->questionID
                    );
                    array_push($data['usersQuestionsAnswers'],$arrayToInsert);
                    if(!in_array($obj->questionID, $QuestionAnswered)){
                        array_push($QuestionAnswered,$obj->questionID);
                    }
                }
            }
            if(is_array($QuestionAnswered)){
                $QuestionsArray = $this->Common_model->select('esic_questions');
                $data['usersQuestionsNotAnswers'] = array();
                if(!empty($QuestionsArray) and is_array($QuestionsArray)){
                    foreach($QuestionsArray as $key=>$questionsObj){
                        if(!in_array($questionsObj->id, $QuestionAnswered)){
                            $QuestionNotAnswered = array(
                                'questionID'    => $questionsObj->id,
                                'Question'      => $questionsObj->Question,
                                'TableName'     => $questionsObj->tablename
                            );
                            array_push($data['usersQuestionsNotAnswers'],$QuestionNotAnswered);
                        }

                    }
                }
            }

        }
		$data['social'] = $this->Esic_model->get_user_Social($userID);
        $data['uID'] = base64_encode($userID);
        $this->show_admin("admin/reg_details",$data);
    }elseif(isCurrentUserAdmin($this)){
           $selectData = array('
                    CONCAT(`h_user`.`firstName`," ",`h_user`.`lastName`) AS FullName,
                    h_user.email as Email,
                    esic.name as Company,
                    esic.business as Business,
                    esic.long_description as BusinessShortDesc,
                    esic.businessShortDescriptionJSON as BusinessShortDescJSON,
                    esic.short_description as short_description,
                    esic.score as Score,
                    esic.logo as Logo,
                    esic.productImage as productImage,
                    esic.banner as banner,
                    esic.website as Web,
                    esic.thumbsUp as thumbsUp,
                    esic.business as business,
                    esic.address as address,
                    esic.address_street_name as address_street_name,
					esic.address_street_number as address_street_number,
					esic.address_post_code as address_post_code,
                    esic.address_town as address_town,
                    esic.address_state as address_state,
                    esic.acn_number as acn_number,
                    esic.expiry_date as expiry_date,
                    esic.showExpDate as ShowExpiryDate,
                    esic.corporate_date as corporate_date,
                    esic.added_date as added_date,
                    esic.ipAddress as ipAddress,
                    esic.sectorID as sectorID,
                    esic.RnDID as RnDID,
                    esic.AccCoID as AccCoID,
                    esic.AccID as AccID,
                    esic.inID as inID,
                    ESEC.sector as sector,
                    esic.Publish as Publish
				   ',false);

        $joins = array(
            array(
                'table' 	=> 'esic_status ES',
                'condition' => 'ES.id = esic.status',
                'type' 		=> 'LEFT'
            ),
            array(
                'table' 	=> 'esic_sectors ESEC',
                'condition' => 'ESEC.id = esic.sectorID',
                'type' 		=> 'LEFT'
            ),
			 array(
                'table' 	=> 'hoosk_user h_user',
                'condition' => 'h_user.userID = esic.userID',
                'type' 		=> 'LEFT'
            )
        );

        $returnedData = $this->Common_model->select_fields_where_like_join('esic',$selectData,$joins,$where,FALSE,'','');

        $returnedData2 =  $this->_getUserQAnswers($userID,1); //1 is for ESIC Pre Assessments
/*        echo '<pre>';
        var_dump($this->db->last_query());
        echo '</pre>';*/

        if(!empty($returnedData) and is_array($returnedData)){
            if($returnedData[0]->Score>0){
                $TotalPoints = $this->db->query('SELECT SUM(MaxPoints) AS TotalPoints FROM (SELECT id, questionID, MAX(Points) AS MaxPoints FROM esic_questions_score GROUP BY questionID) Points')->row()->TotalPoints;
                $ScorePercentage = $returnedData[0]->Score/$TotalPoints*100;
            }else{
                $TotalPoints = '';
                $ScorePercentage='';
            }
            // $date1 = new DateTime($returnedData[0]->corporate_date);
            $date1 = new DateTime(date('Y-m-d H:i:s'));
            $date2 = new DateTime($returnedData[0]->expiry_date);
            $diff = $date2->diff($date1)->format("%a");
            // if($diff> 60){
            //     $diff = '';
            //}
            $data['userProfile'] = array(
                'userID' 			=> $userID,
                'ScorePercentage' 	=> $ScorePercentage,
                'Web' 				=> $returnedData[0]->Web,
                'Logo' 				=> $returnedData[0]->Logo,
                'thumbsUp'          => $returnedData[0]->thumbsUp,
                'banner'       => $returnedData[0]->banner,
                'productImage'      => $returnedData[0]->productImage,
                'Email' 			=> $returnedData[0]->Email,
                'Score' 			=> $returnedData[0]->Score,
                'sector' 			=> $returnedData[0]->sector,
                //'Status' 			=> $returnedData[0]->Status,
                'Company'			=> $returnedData[0]->Company,
                'business' 			=> $returnedData[0]->business,
                'FullName' 			=> $returnedData[0]->FullName,
                'ipAddress'         => $returnedData[0]->ipAddress,
                'address'           => $returnedData[0]->address,
                'address_street_name'     => $returnedData[0]->address_street_name,
                'address_street_number'     => $returnedData[0]->address_street_number,
                'address_post_code'         => $returnedData[0]->address_post_code,
                'address_town'              => $returnedData[0]->address_town,
                'address_state'             => $returnedData[0]->address_state,
                'acn_number'        => $returnedData[0]->acn_number,
                'sectorID'          => $returnedData[0]->sectorID,
                'RnDID'             => $returnedData[0]->RnDID,
                'AccCoID'           => $returnedData[0]->AccCoID,
                'AccID'             => $returnedData[0]->AccID,
                'inID'              => $returnedData[0]->inID,
                'Publish'           => $returnedData[0]->Publish,
			    'dateDiff'          => $diff,
                'added_date' 		=> date("d-M-Y", strtotime($returnedData[0]->added_date)),
                'expiry_date' 		=> date("d-M-Y", strtotime($returnedData[0]->expiry_date)),
                'corporate_date' 	=> date("d-M-Y", strtotime($returnedData[0]->corporate_date)),
                'added_date_value'        => date("d-m-Y", strtotime($returnedData[0]->added_date)),
                'expiry_date_value'       => date("d-m-Y", strtotime($returnedData[0]->expiry_date)),
                'corporate_date_value'    => date("d-m-Y", strtotime($returnedData[0]->corporate_date)),
                'BusinessShortDesc' => $returnedData[0]->BusinessShortDesc,
                'BusinessShortDescJSON' => $returnedData[0]->BusinessShortDescJSON,
                'short_description' => $returnedData[0]->short_description,
                'ShowExpiryDate' => $returnedData[0]->ShowExpiryDate
            );
            $QuestionNotAnswered = array();
            $QuestionAnswered = array();
            $QuestionAll = array();
            $QuestionsFirstArray = $this->Common_model->select('esic_questions');
            if(!empty($QuestionsFirstArray) and is_array($QuestionsFirstArray)){
                foreach($QuestionsFirstArray as $key=>$questionsObj){
                    $QuestionAll = array(
                        'questionID'    => $questionsObj->id,
                        'Question'      => $questionsObj->Question
                    );
                }
            }
            if(!empty($returnedData2) and is_array($returnedData2)){
                $data['usersQuestionsAnswers'] = array();
                foreach($returnedData2 as $key=>$obj){
                    $arrayToInsert = array(
                        'Question' 		    => $obj->Question,
                        'possibleSolutions' => $obj->PossibleSolution,
                        'questionID' 	    => $obj->questionID,
                        'providedSolution'  => $obj->ProvidedSolution
                    );
                    array_push($data['usersQuestionsAnswers'],$arrayToInsert);
                }
            }
        }
		$data['social'] = $this->Esic_model->get_user_Social($userID);
		$data['uID'] = base64_encode($userID);
        $this->show_admin("admin/reg_details",$data);
		}
    }
    public function getanswers(){
        $questionID 	= $this->input->post('dataQuestionId');
        $where 			= "questionID =".$questionID;
        $data  			= array();
        $selectData 	= array('Solution as solution',false);
        $returnedData 	= $this->Common_model->select_fields_where_like_join('esic_solutions',$selectData,'',$where,FALSE,'','');
        echo json_encode($returnedData );
        exit();
    }
    public function saveanswer(){
        $id 			= $this->input->post('id');
        $userID 		= $this->input->post('userID');
        $oldScore 		= $this->input->post('oldScore');
        $Answervalue 	= $this->input->post('Answervalue');
        $tableName      = $this->input->post('tableName');
        $tableUpdateID  = $this->input->post('tableUpdateID');
        $SpAnswervalue  = $this->input->post('SpAnswervalue');
        $dataQuestionId = $this->input->post('dataQuestionId');
        if(!isset($userID) || empty($userID) || !isset($Answervalue) || empty($Answervalue) || !isset($dataQuestionId) || empty($dataQuestionId)){
            echo "FAIL::Something went wrong with the post, Please Contact System Administrator for Further Assistance";
            return;
        }
        $where= array("userID"=>$userID);
        $updateData = array("status"=>1);
        $this->Common_model->update('esic',$where,$updateData);
        $selectData = array('score AS score',false);
        $where = array(
            'questionID' => $dataQuestionId,
            'solution' 	 => $Answervalue
        );
        $returnedData = $this->Common_model->select_fields_where('esic_solutions',$selectData, $where, false, '', '', '','','',false);
        $score = $returnedData[0]->score;
        $updateArray = array();
        $updateArray['Solution'] = $Answervalue;
        $whereUpdate = array(
            'userID' => $userID,
            'questionID' => $dataQuestionId
        );
        $this->Common_model->update('esic_questions_answers',$whereUpdate,$updateArray);
        if($this->db->affected_rows() < 1){
            $insertArray = array(
                'userID' => $userID,
                'questionID' => $dataQuestionId,
                'Solution' =>  $Answervalue
            );
            $insertResult = $this->Common_model->insert_record('esic_questions_answers',$insertArray);
            //if($insertResult){
            //    echo "OK::Record Successfully Entered";
            //}else{
            //    echo "FAIL::Record Failed Entered";
            //}
        }
        $selectData2 = array('score AS score',false);
        $where2 = array('id' => $userID);
        $returnedData2 = $this->Common_model->select_fields_where('esic',$selectData2, $where2, false, '', '', '','','',false);
        $TotalOldscore =  $returnedData[0]->score;
        $Totalscore    = ($returnedData[0]->score-$oldScore)+$score;
        if($Totalscore > 0){
            $TotalPoints   = $this->db->query('SELECT SUM(MaxPoints) AS TotalPoints FROM (SELECT id, questionID, MAX(Points) AS MaxPoints FROM esic_questions_score GROUP BY questionID) Points')->row()->TotalPoints;
            $ScorePercentage = $Totalscore/$TotalPoints*100;
        }else{
            $Totalscore = 0;
            $ScorePercentage = 0;
        }
        if($score<=0){
            $score ='';
        }else{
            $score ='('.$score.')';
        }
        $updateArray2 = array();
        $updateArray2['score'] = $Totalscore;
        $whereUpdate2 = array('id' => $userID);
        $this->Common_model->update('esic',$whereUpdate2,$updateArray2);
        echo 'OK::'.$score.'::'.$ScorePercentage.'::'.$TotalOldscore.'::'.$Totalscore;
        if(isset($tableName) && !empty($tableName) && isset($SpAnswervalue) && !empty($SpAnswervalue) && isset($tableUpdateID) && !empty($tableUpdateID)){
            $updateArray3 = array();
            $updateArray3[$tableUpdateID] = $SpAnswervalue;
            $whereUpdate3 = array('id' => $userID);
            $this->Common_model->update('esic',$whereUpdate3,$updateArray3);
        }
        $this->Common_model->save_darft($userID);
        exit();
    }
    public function savedate(){
        $userID    = $this->input->post('userID');
        $dateType  = $this->input->post('dateType');
        $EditedDate= $this->input->post('EditedDate');
        if(!isset($userID) || empty($userID) || !isset($EditedDate) || empty($EditedDate)){
            echo "FAIL::Something went wrong with the post, Please Contact System Administrator for Further Assistance";
            return;
        }
        $EditedDate = date("Y-m-d",strtotime($EditedDate));
        $updateArray = array();
        $updateArray[$dateType] = $EditedDate;
        $whereUpdate = array('userID' => $userID);
        $this->Common_model->save_darft($userID);
        $this->Common_model->update('user_draft',$whereUpdate,$updateArray);
        echo 'OK::'.$EditedDate.'';
        exit();
    }
    public function savedesc(){
		$uID_encoded = $this->input->post('uID');
        if(!empty($uID_encoded))
		$uID = base64_decode($uID_encoded);
		//Haider COde. Changed for Editor.
		$this->load->library('Sioen');
		$this->Hoosk_model->UpdateEsicPageDescription($uID);
		//Return to page list
		redirect('/admin/details/'.$uID, 'refresh');
    }
	public function save_desc_editor(){
		echo 'Hello WOrld';
	}
    public function saveshortdesc(){
        $userID        = $this->input->post('userID');
        $descDataText  = $this->input->post('descDataText');
        if(!isset($userID) || empty($userID) || !isset($descDataText) || empty($descDataText)){
            echo "FAIL::Something went wrong with the post, Please Contact System Administrator for Further Assistance";
            return;
        }

        $updateArray = array();
        $updateArray['short_description'] = $descDataText;
        $updateArray['status'] = 1;
        $whereUpdate = array('userID' => $userID);
        $this->Common_model->save_darft($userID);
        $this->Common_model->update('user_draft',$whereUpdate,$updateArray);
        echo 'OK::'.urldecode($descDataText).'';
        exit();
    }
    public function savelogo(){
    	$userRole = $this->session->userdata('userRole');
    	$user_table = 'user_draft';
 		if($userRole == 1){
 			//admin
 			$user_table = 'esic';
 		}
        $userID = $this->input->post('userID');
        $allowedExt = array('jpeg','jpg','png','gif');
        $uploadPath = './uploads/users/'.$userID.'/';
        $uploadDirectory = './uploads/users/'.$userID;
        $uploadDBPath = 'uploads/users/'.$userID.'/';
        $insertDataArray = array();

        //For Logo Upload
        if(isset($_FILES['logo']['name']))
        {
            $FileName = $_FILES['logo']['name'];
            $explodedFileName = explode('.',$FileName);
            $ext = end($explodedFileName);
            if(!in_array(strtolower($ext),$allowedExt))
            {
                echo "FAIL:: Only Image JPEG, PNG and GIF Images Allowed, No Other Extensions Are Allowed::error";
                return;
            }else
            {

                $FileName = "Logo_".$userID."_".time().".".$ext;
                if(!is_dir($uploadDirectory)){
                    mkdir($uploadDirectory, 0755, true);
                }

                move_uploaded_file($_FILES['logo']['tmp_name'],$uploadPath.$FileName);
                $insertDataArray['logo'] = $uploadDBPath.$FileName;
                $fileToCreateThumbnail   = $uploadDBPath.$FileName;
                $this->Imagecreate_model->createimage($fileToCreateThumbnail);
            }
        }else{
            echo "FAIL::Logo Image Is Required";
            return;
        }

        if(empty($userID)){
            echo "FAIL::Something went wrong with the Post, Please Contact System Administrator For Further Assistance.";
            exit;
        }
        $selectData = array('logo AS logo',false);
        $where = array(
            'userID' => $userID
        );
        $returnedData = $this->Common_model->select_fields_where($user_table,$selectData, $where, false, '', '', '','','',false);
        $logo = $returnedData[0]->logo;
        if(!empty($logo) && is_file(FCPATH.$logo)){
            unlink('./'.$logo);
        }
        $this->Common_model->save_darft($userID);
        $resultUpdate = $this->Common_model->update($user_table,$where,$insertDataArray);
        if($resultUpdate === true){

            echo "OK::Record Updated Successfully";
            echo $this->db->last_query();
        }else{
            echo "FAIL::Something went wrong during Update, Please Contact System Administrator";
        }
    }
    public function saveBannerImage(){
        $userID = $this->input->post('userID');
        $allowedExt = array('jpeg','jpg','png','gif');
        $uploadPath = './uploads/users/'.$userID.'/';
        $uploadDirectory = './uploads/users/'.$userID;
        $uploadDBPath = 'uploads/users/'.$userID.'/';
        $insertDataArray = array();

        //For Logo Upload
        if(isset($_FILES['banner']['name']))
        {
            $FileName = $_FILES['banner']['name'];
            $explodedFileName = explode('.',$FileName);
            $ext = end($explodedFileName);
            if(!in_array(strtolower($ext),$allowedExt))
            {
                echo "FAIL:: Only Image JPEG, PNG and GIF Images Allowed, No Other Extensions Are Allowed::error";
                return;
            }else
            {

                $FileName = "banner".$userID."_".time().".".$ext;
                if(!is_dir($uploadDirectory)){
                    mkdir($uploadDirectory, 0755, true);
                }

                move_uploaded_file($_FILES['banner']['tmp_name'],$uploadPath.$FileName);
                $insertDataArray['banner'] = $uploadDBPath.$FileName;
            }
        }else{
            echo "FAIL::Banner Image Is Required";
            return;
        }

        if(empty($userID)){
            echo "FAIL::Something went wrong with the Post, Please Contact System Administrator For Further Assistance.";
            exit;
        }
        $selectData = array('banner AS banner',false);
        $where = array(
            'userID' => $userID
        );
        $returnedData = $this->Common_model->select_fields_where('user_draft',$selectData, $where, false, '', '', '','','',false);
        $banner = $returnedData[0]->banner;
        if(!empty($banner) && is_file(FCPATH.'/'.$banner)){
            unlink('./'.$banner);
        }
        $this->Common_model->save_darft($userID);
        $resultUpdate = $this->Common_model->update('user_draft',$where,$insertDataArray);
        if($resultUpdate === true){
            echo "OK::Record Updated Successfully";
        }else{
            echo "FAIL::Something went wrong during Update, Please Contact System Administrator";
        }
    }
    public function saveProductImage(){
        $userID = $this->input->post('userID');
        $allowedExt = array('jpeg','jpg','png','gif');
        $uploadPath = './uploads/users/'.$userID.'/';
        $uploadDirectory = './uploads/users/'.$userID;
        $uploadDBPath = 'uploads/users/'.$userID.'/';
        $insertDataArray = array();

        //For Logo Upload
        if(isset($_FILES['productImage']['name']))
        {
            $FileName = $_FILES['productImage']['name'];
            $explodedFileName = explode('.',$FileName);
            $ext = end($explodedFileName);
            if(!in_array(strtolower($ext),$allowedExt))
            {
                echo "FAIL:: Only Image JPEG, PNG and GIF Images Allowed, No Other Extensions Are Allowed::error";
                return;
            }else
            {

                $FileName = "productImage".$userID."_".time().".".$ext;
                if(!is_dir($uploadDirectory)){
                    mkdir($uploadDirectory, 0755, true);
                }

                move_uploaded_file($_FILES['productImage']['tmp_name'],$uploadPath.$FileName);
                $insertDataArray['productImage'] = $uploadDBPath.$FileName;
            }
        }else{
            echo "FAIL::Product Image Is Required";
            return;
        }

        if(empty($userID)){
            echo "FAIL::Something went wrong with the Post, Please Contact System Administrator For Further Assistance.";
            exit;
        }
        $selectData = array('productImage AS productImage',false);
        $where = array(
            'userID' => $userID
        );
        $returnedData = $this->Common_model->select_fields_where('user_draft',$selectData, $where, false, '', '', '','','',false);
        $productImage = $returnedData[0]->productImage;
        if(!empty($productImage) && is_file(FCPATH.'/'.$productImage)){
            unlink('./'.$productImage);
        }
        $this->Common_model->save_darft($userID);
        $resultUpdate = $this->Common_model->update('user_draft',$where,$insertDataArray);
        if($resultUpdate === true){
            echo "OK::Record Updated Successfully";
        }else{
            echo "FAIL::Something went wrong during Update, Please Contact System Administrator";
        }
    }
    public function resetThumbsUp(){
        $userID    = $this->input->post('userID');
        if(!isset($userID) || empty($userID)){
            echo "FAIL::Something went wrong with the post, Please Contact System Administrator for Further Assistance";
            return;
        }

        $updateArray = array();
        $updateArray['thumbsUp'] = 0;
        $whereUpdate = array('id' => $userID);
        $this->Common_model->save_darft($userID);
        $this->Common_model->update('user_draft',$whereUpdate,$updateArray);
        echo 'OK::';
        exit();
    }
    public function updatewebsite(){
        $userID    = $this->input->post('userID');
        $website  = $this->input->post('website');
        if(!isset($userID) || empty($userID) || !isset($website) || empty($website)){
            echo "FAIL::Something went wrong with the post, Please Contact System Administrator for Further Assistance";
            return;
        }

        $updateArray = array();
        $updateArray['website'] = $website;
        $whereUpdate = array('userID' => $userID);
        $this->Common_model->save_darft($userID);
        $this->Common_model->update('user_draft',$whereUpdate,$updateArray);
        echo 'OK::'.$website.'';
        exit();
    }
    public function updatename(){
        $userID    = $this->input->post('userID');
        $name  = $this->input->post('name');
        if(!isset($userID) || empty($userID) || !isset($name) || empty($name)){
            echo "FAIL::Something went wrong with the post, Please Contact System Administrator for Further Assistance";
            return;
        }

        $updateArray = array();
        $updateArray['Company'] = $name;
        $updateArray['status'] = 1;
        $whereUpdate = array('id' => $userID);
        $this->Common_model->save_darft($userID);
        $this->Common_model->update('user_draft',$whereUpdate,$updateArray);
        echo 'OK::'.$name.'';
        exit();
    }
    public function updateemail(){
        $userID    = $this->input->post('userID');
        $email  = $this->input->post('email');
        if(!isset($userID) || empty($userID) || !isset($email) || empty($email)){
            echo "FAIL::Something went wrong with the post, Please Contact System Administrator for Further Assistance";
            return;
        }

        $updateArray = array();
        $updateArray['Email'] = $email;
        $whereUpdate = array('userID' => $userID);
        $this->Common_model->update('hoosk_user',$whereUpdate,$updateArray);
        echo 'OK::'.$email.'';
        exit();
    }
    public function updateip(){
        $userID    = $this->input->post('userID');
        $ip = $this->input->post('ipAddress');
        if(!isset($userID) || empty($userID) || !isset($ip) || empty($ip)){
            echo "FAIL::Something went wrong with the post, Please Contact System Administrator for Further Assistance";
            return;
        }

        $updateArray = array();
        $updateArray['ipAddress'] = $ip;
        $whereUpdate = array('userID' => $userID);
        $this->Common_model->save_darft($userID);
        $this->Common_model->update('user_draft',$whereUpdate,$updateArray);
        echo 'OK::'.$ip.'';
        exit();
    }
    public function updateacn(){
        $userID    = $this->input->post('userID');
        $acn  = $this->input->post('acn');
        if(!isset($userID) || empty($userID) || !isset($acn) || empty($acn)){
            echo "FAIL::Something went wrong with the post, Please Contact System Administrator for Further Assistance";
            return;
        }

        $updateArray = array();
        $updateArray['acn_number'] = $acn;
        $whereUpdate = array('userID' => $userID);
        $this->Common_model->save_darft($userID);
        $this->Common_model->update('user_draft',$whereUpdate,$updateArray);
        echo 'OK::'.$acn.'';
        exit();
    }
    public function updateAddress(){
        $userID         		= $this->input->post('userID');
        $address  				= $this->input->post('address');
        $address_street_number  = $this->input->post('address_street_number');
	    $address_street_name    = $this->input->post('address_street_name');
        $address_town           = $this->input->post('address_town');
        $address_state          = $this->input->post('address_state');
		$address_post_code      = $this->input->post('address_post_code');
        if(!isset($userID) || empty($userID)){
            echo "FAIL::Something went wrong with the post, Please Contact System Administrator for Further Assistance";
            return;
        }

        $updateArray = array();
		$updateArray['address']       = $address;
        $updateArray['address_street_number'] = $streetnumber;
		$updateArray['address_town']          = $address_town;
        $updateArray['address_state']         = $address_state;
		$updateArray['address_post_code']     = $post_input;

        $whereUpdate = array('userID' => $userID);
        $this->Common_model->save_darft($userID);
        $this->Common_model->update('user_draft',$whereUpdate,$updateArray);
        echo 'OK::'.$address_street_number.'::'.$street_name.''.'::'.$address_town.''.'::'.$address_state.''.'::'.$post_input.'';
        exit();
    }
    public function updatebsName(){
        $userID    = $this->input->post('userID');
        $bsName  = $this->input->post('bsName');
        if(!isset($userID) || empty($userID) || !isset($bsName) || empty($bsName)){
            echo "FAIL::Something went wrong with the post, Please Contact System Administrator for Further Assistance";
            return;
        }

        $updateArray = array();
        $updateArray['business'] = $bsName;
        $whereUpdate = array('userID' => $userID);
        $this->Common_model->save_darft($userID);
        $this->Common_model->update('user_draft',$whereUpdate,$updateArray);


        echo 'OK::'.$bsName.'';
        exit();
    }
    public function getsectors(){
        $userID     = $this->input->post('userID');
        $where = 'id != 0';
        $data           = array();
        $selectData     = array('id as id, sector as sector',false);
        $returnedData   = $this->Common_model->select_fields_where_like_join('esic_sectors',$selectData,'',$where,FALSE,'','');
        echo json_encode($returnedData );
        exit();
    }
    public function savesector(){
        $userID    = $this->input->post('userID');
        $sectorID  = $this->input->post('answer');
        if(!isset($userID) || empty($userID) || !isset($sectorID) || empty($sectorID)){
            echo "FAIL::Something went wrong with the post, Please Contact System Administrator for Further Assistance";
            return;
        }

        $updateArray = array();
        $updateArray['sectorID'] = $sectorID;
        $whereUpdate = array('userID' => $userID);
        $this->Common_model->save_darft($userID);
        $this->Common_model->update('user_draft',$whereUpdate,$updateArray);
        echo 'OK::'.$sectorID.'';
    }
	public function manage_status($param = NULL){
		$userRole = $this->session->userdata('userRole');
 	if(isCurrentUserAdmin($this)){


        if($param === 'listing'){
		 
            $selectData = array('
            id AS ID,
			color AS Color,
            CASE WHEN id>0 THEN CONCAT("<span class=\'label \' style=\' background-color:",color,"\'> ", status," </span>")  ELSE CONCAT ("<span class=\'label label-warning\'> ", status, " </span>") END AS Status
            ',false); 
            $addColumns = array(
                'ViewEditActionButtons' => array('<a href="#" data-target="#editStatusModal" data-toggle="modal"><span data-toggle="tooltip" title="Edit" data-placement="left" aria-hidden="true" class="fa fa-pencil text-blue"></span></a> &nbsp; <a href="#" data-target=".approval-modal" data-toggle="modal"><i data-toggle="tooltip" title="Trash" data-placement="right"  class="fa fa-trash-o text-red"></i></a>','ID')
            );
            $returnedData = $this->Common_model->select_fields_joined_DT($selectData,'esic_status','','','','','',$addColumns);
            print_r($returnedData);
            return NULL;
        }
        if($param === 'allvalues'){
            $returnedData = $this->Common_model->select('esic_status');
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

                $whereUpdate = array(
                    'id' => $id
                );

                $returnedData = $this->Common_model->delete('esic_status',$whereUpdate);
                echo "OK::Record Deleted";
            }else{
                echo "FAIL::Record Not Deleted";
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
			$color = $this->input->post('color');

            if(empty($id) or !is_numeric($id)){
                echo "FAIL::Posted values are not VALID";
                return NULL;
            }

            if(empty($value)){
                echo "FAIL::Value Must Be Entered";
                return NULL;
            }
			if(empty($color)){
                echo "FAIL::Color Value Must Be Entered";
                return NULL;
            }

            $updateData = array(
                'status' => $value,
				'color' => $color
            );

            $whereUpdate = array(
                'id' => $id
            );

            $updateResult = $this->Common_model->update('esic_status',$whereUpdate,$updateData);
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
                echo "FAIL::Status Value Must Be Entered";
                return NULL;
            }
			$color = $this->input->post('color');

            if(empty($color)){
                echo "FAIL::Color Value Must Be Entered";
                return NULL;
            }

            $insertData = array(
                'status' => $value,
				'color' => $color
            );

            $insertResult = $this->Common_model->insert_record('esic_status',$insertData);
            if($insertResult){
                echo "OK::Record Successfully Entered";
            }else{
                echo "FAIL::Record Failed Entered";
            }
            return NULL;
        }
        $this->show_admin('admin/configuration/status');
        return NULL;
 }else{
		 $this->load->view('admin/page_not_found'); 
	  }
    }
public function manage_appstatus($param = NULL){
    if(isCurrentUserAdmin($this)){
       if($param === 'listing'){
            $selectData = array('
            id AS ID,
            CASE WHEN id = 2 THEN CONCAT("<span class=\'label label-danger\'> ", status," </span>") WHEN id = 1 THEN CONCAT ("<span class=\'label label-success\'> ", status, " </span>") ELSE CONCAT ("<span class=\'label label-warning\'> ", status, " </span>") END AS Status
            ',false);
            $addColumns = array(
                'ViewEditActionButtons' => array('<a href="#" data-target="#editStatusModal" data-toggle="modal"><span data-toggle="tooltip" title="Edit" data-placement="left" aria-hidden="true" class="fa fa-pencil text-blue"></span></a> &nbsp; <a href="#" data-target=".approval-modal" data-toggle="modal"><i data-toggle="tooltip" title="Trash" data-placement="right"  class="fa fa-trash-o text-red"></i></a>','ID')
            );
            $returnedData = $this->Common_model->select_fields_joined_DT($selectData,'esic_appstatus','','','','','',$addColumns);
            print_r($returnedData);
            return NULL;
        }
        if($param === 'allvalues'){
            $returnedData = $this->Common_model->select('esic_appstatus');
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

                $whereUpdate = array(
                    'id' => $id
                );

                $returnedData = $this->Common_model->delete('esic_appstatus',$whereUpdate);
                echo "OK::Record Deleted";
            }else{
                echo "FAIL::Record Not Deleted";
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

            $updateResult = $this->Common_model->update('esic_appstatus',$whereUpdate,$updateData);
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

            $insertResult = $this->Common_model->insert_record('esic_appstatus',$insertData);
            if($insertResult){
                echo "OK::Record Successfully Entered";
            }else{
                echo "FAIL::Record Failed Entered";
            }
            return NULL;
        }
        $this->show_admin('admin/configuration/appstatus');
        return NULL;
     }else{
          $this->load->view('admin/page_not_found');
		 }

  
    }
public function manage_universities($param = NULL){ 
	 $userRole = $this->session->userdata('userRole');
	 if(isCurrentUserAdmin($this)){
			
        if($param === 'listing'){


            $selectData = array('
            id AS ID,
            institution AS University,
            logo AS Logo,
			address AS Address,
                CASE WHEN AppStatus = 2 THEN CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-danger">No</span>\') WHEN AppStatus = 3 THEN CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-success">Lodged</span>\') WHEN AppStatus = 1 THEN CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-success">Yes</span>\') ELSE 
                CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-success">No</span>\') END AS ABR,
            CASE WHEN insertionType = 1 THEN CONCAT(\'<span data-target="#permanent-modal" data-toggle="modal" class="label label-danger">YES</span>\') WHEN insertionType = 2 THEN CONCAT(\'<span data-target="#permanent-modal" data-toggle="modal" class="label label-success">NO</span>\') ELSE "" END AS Permanent,
            CASE WHEN trashed = 1 THEN CONCAT(\'<span class="label label-danger">YES</span>\') WHEN trashed = 0 THEN CONCAT(\'<span class="label label-success">NO</span>\') ELSE "" END AS Trashed
            ',false);
            $addColumns = array(
                'ViewEditActionButtons' => array('<a href="#" data-target="#editUniversitiesModal" data-toggle="modal"><span data-toggle="tooltip" title="Edit" data-placement="left" aria-hidden="true" class="fa fa-pencil text-blue"></span></a> &nbsp; <a href="#" data-target=".approval-modal" data-toggle="modal"><i data-toggle="tooltip" title="Trash" data-placement="right"  class="fa fa-trash-o text-red"></i></a>','ID')
            );
            $returnedData = $this->Common_model->select_fields_joined_DT($selectData,'esic_institution','','','','','',$addColumns);
            print_r($returnedData);
            return NULL;
        }
        if($param === 'trash'){
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
            if($value == 'trash'){
                $data = 1;
            }else if($value == 'untrash'){
                $data = 0;
            }else{
                $data = 2;
            }

            $updateData = array(
                'trashed' => $data
            );

            $whereUpdate = array(
                'id' => $id
            );

            $returnedData = $this->Common_model->update('esic_institution',$whereUpdate,$updateData);
            if($returnedData === true){
                echo "OK::Record Successfully";
            }else{
                echo "FAIL::".$returnedData['message'];
            }
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

                $whereUpdate = array(
                    'id' => $id
                );

                $returnedData = $this->Common_model->delete('esic_institution',$whereUpdate);
                echo "OK::Record Deleted";
            }else{
                echo "FAIL::Record Not Deleted";
            }
            return NULL;
        }
        if($param === 'update'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }

            $id = $this->input->post('id');
            $value = $this->input->post('University');

            if(empty($id) or !is_numeric($id)){
                echo "FAIL::Posted values are not VALID";
                return NULL;
            }

            if(empty($value)){
                echo "FAIL::Value Must Be Entered";
                return NULL;
            }

            $updateData = array(
                'institution' => $value,
                'insertionType' => 1
            );

            $whereUpdate = array(
                'id' => $id
            );

            $updateResult = $this->Common_model->update('esic_institution',$whereUpdate,$updateData);
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
        if($param === 'permanent'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }

            $id = $this->input->post('id');
            $value = $this->input->post('value');

            if(empty($id)){
                echo "FAIL::Posted values are not VALID 1";
                return NULL;
            }

            if(empty($value)){
                echo "FAIL::Posted values are not VALID 2";
                return NULL;
            }
            $data='';
            if($value == 'Permanent'){
                $data = 1;
            }else if($value == 'noPermanent'){
                $data = 2;
            }else{
                $data = 0;
            }

            $updateData = array(
                'insertionType' => $data
            );

            $whereUpdate = array(
                'id' => $id
            );

            $returnedData = $this->Common_model->update('esic_institution',$whereUpdate,$updateData);
            if($returnedData === true){
                echo "OK::Record Successfully";
            }else{
                echo "OK::FAIL::".$returnedData['message'];
            }
            return NULL;
        }
        if($param === 'abr'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }

            $id = $this->input->post('id');
            $value = $this->input->post('value');

            if(empty($id)){
                echo "FAIL::Posted values are not VALID 1";
                return NULL;
            }

            if(empty($value)){
                echo "FAIL::Posted values are not VALID 2";
                return NULL;
            }
            $data=$value;
            $updateData = array(
                'AppStatus' => $data
            );

            $whereUpdate = array(
                'id' => $id
            );

            $returnedData = $this->Common_model->update('esic_institution',$whereUpdate,$updateData);
            if($returnedData === true){
                echo "OK::Record Successfully";
            }else{
                echo "OK::FAIL::".$returnedData['message'];
            }
            return NULL;
        }
        if($param === 'new'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }
            $value = $this->input->post('University');

            if(empty($value)){
                echo "FAIL::Value Must Be Entered";
                return NULL;
            }

            $insertData = array(
                'institution' => $value,
                'insertionType' => 1
            );

            $insertResult = $this->Common_model->insert_record('esic_institution',$insertData);
            if($insertResult){
                echo "OK::Record Successfully Entered";
            }else{
                echo "FAIL::Record Failed Entered";
            }
            return NULL;
        }
        if($param === 'updateLogo'){
            $uniID = $this->input->post('id');
            $allowedExt = array('jpeg','jpg','png','gif');
            $uploadPath = './pictures/logos/';
            $uploadDirectory = './pictures/logos/';
            $uploadDBPath = 'pictures/logos/';
            $insertDataArray = array();
            //For Logo Upload
            if(isset($_FILES['logo']['name']))
            {
                $FileName = $_FILES['logo']['name'];
                $explodedFileName = explode('.',$FileName);
                $ext = end($explodedFileName);
                if(!in_array(strtolower($ext),$allowedExt))
                {
                    echo "FAIL:: Only Image JPEG, PNG and GIF Images Allowed, No Other Extensions Are Allowed::error";
                    return;
                }else
                {

                    $FileName = "uniLogo".$uniID."_".time().".".$ext;
                    if(!is_dir($uploadDirectory)){
                        mkdir($uploadDirectory, 0755, true);
                    }

                    move_uploaded_file($_FILES['logo']['tmp_name'],$uploadPath.$FileName);
                    $insertDataArray['logo'] = $uploadDBPath.$FileName;
                }
            }else{
                echo "FAIL::Logo Image Is Required";
                return;
            }

            if(empty($uniID)){
                echo "FAIL::Something went wrong with the Post, Please Contact System Administrator For Further Assistance.";
                exit;
            }
            $selectData = array('logo AS logo',false);
            $where = array(
                'id' => $uniID
            );
            $returnedData = $this->Common_model->select_fields_where('esic_institution',$selectData, $where, false, '', '', '','','',false);
            $logo = $returnedData[0]->logo;
            if(!empty($logo) && is_file(FCPATH.'/'.$logo)){
                unlink('./'.$logo);
            }
            $resultUpdate = $this->Common_model->update('esic_institution',$where,$insertDataArray);
            if($resultUpdate === true){
                echo "OK::Record Updated Successfully";
            }else{
                echo "FAIL::Something went wrong during Update, Please Contact System Administrator";
            }
            return NULL;
        }
        $this->show_admin('admin/configuration/universities');
        return NULL;
	 }
	 else{
		 $this->load->view('admin/page_not_found');
		 }
    }


public function manage_sectors($param = NULL){  
	$userRole = $this->session->userdata('userRole');
	if(isCurrentUserAdmin($this)){
        if($param === 'listing'){
            $selectData = array('
            id AS ID,
            sector AS Sector,
            CASE WHEN AppStatus = 2 THEN CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-danger">No</span>\') WHEN AppStatus = 3 THEN CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-success">Lodged</span>\') WHEN AppStatus = 1 THEN CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-success">Yes</span>\') ELSE 
                CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-success">No</span>\') END AS ABR,
            CASE WHEN insertionType = 1 THEN CONCAT(\'<span data-target="#permanent-modal" data-toggle="modal" class="label label-danger">YES</span>\') WHEN insertionType = 2 THEN CONCAT(\'<span data-target="#permanent-modal" data-toggle="modal" class="label label-success">NO</span>\') ELSE "" END AS Permanent,
            CASE WHEN trashed = 1 THEN CONCAT(\'<span class="label label-danger">YES</span>\') WHEN trashed = 0 THEN CONCAT(\'<span class="label label-success">NO</span>\') ELSE "" END AS Trashed
            ',false);

            $addColumns = array(
                'ViewEditActionButtons' => array('<a href="#" data-target="#editSectorModal" data-toggle="modal"><span data-toggle="tooltip" title="Edit" data-placement="left" aria-hidden="true" class="fa fa-pencil text-blue"></span></a> &nbsp; <a href="#" data-target=".approval-modal" data-toggle="modal"><i data-toggle="tooltip" title="Trash" data-placement="right"  class="fa fa-trash-o text-red"></i></a>','UserID')
            );
            $returnedData = $this->Common_model->select_fields_joined_DT($selectData,'esic_sectors','','','','','',$addColumns);
            print_r($returnedData);
            return NULL;
        }
        if($param === 'trash'){
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
            if($value == 'trash'){
                $data = 1;
            }else if($value == 'untrash'){
                $data = 0;
            }else{
                $data = 2;
            }

            $updateData = array(
                'trashed' => $data
            );

            $whereUpdate = array(
                'id' => $id
            );

            $returnedData = $this->Common_model->update('esic_sectors',$whereUpdate,$updateData);
            if($returnedData === true){
                echo "OK::Record Successfully";
            }else{
                echo "OK::FAIL::".$returnedData['message'];
            }
            return NULL;
        }
        if($param === 'update'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }

            $id = $this->input->post('id');
            $value = $this->input->post('sector');

            if(empty($id) or !is_numeric($id)){
                echo "FAIL::Posted values are not VALID";
                return NULL;
            }

            if(empty($value)){
                echo "FAIL::Value Must Be Entered";
                return NULL;
            }

            $updateData = array(
                'sector' => $value,
                'insertionType' => 1
            );

            $whereUpdate = array(
                'id' => $id
            );

            $updateResult = $this->Common_model->update('esic_sectors',$whereUpdate,$updateData);
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

                $whereUpdate = array(
                    'id' => $id
                );

                $returnedData = $this->Common_model->delete('esic_sectors',$whereUpdate);
                echo "OK::Record Deleted";
            }else{
                echo "FAIL::Record Not Deleted";
            }
            return NULL;
        }
        if($param === 'permanent'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }

            $id = $this->input->post('id');
            $value = $this->input->post('value');

            if(empty($id)){
                echo "FAIL::Posted values are not VALID 1";
                return NULL;
            }

            if(empty($value)){
                echo "FAIL::Posted values are not VALID 2";
                return NULL;
            }
            $data='';
            if($value == 'Permanent'){
                $data = 1;
            }else if($value == 'noPermanent'){
                $data = 2;
            }else{
                $data = 0;
            }

            $updateData = array(
                'insertionType' => $data
            );

            $whereUpdate = array(
                'id' => $id
            );

            $returnedData = $this->Common_model->update('esic_sectors',$whereUpdate,$updateData);
            if($returnedData === true){
                echo "OK::Record Successfully";
            }else{
                echo "OK::FAIL::".$returnedData['message'];
            }
            return NULL;
        }
        if($param === 'abr'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }

            $id = $this->input->post('id');
            $value = $this->input->post('value');

            if(empty($id)){
                echo "FAIL::Posted values are not VALID 1";
                return NULL;
            }

            if(empty($value)){
                echo "FAIL::Posted values are not VALID 2";
                return NULL;
            }
            $data=$value;
            $updateData = array(
                'AppStatus' => $data
            );

            $whereUpdate = array(
                'id' => $id
            );

            $returnedData = $this->Common_model->update('esic_sectors',$whereUpdate,$updateData);
            if($returnedData === true){
                echo "OK::Record Successfully";
            }else{
                echo "OK::FAIL::".$returnedData['message'];
            }
            return NULL;
        }
        if($param === 'new'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }
            $value = $this->input->post('sector');

            if(empty($value)){
                echo "FAIL::Value Must Be Entered";
                return NULL;
            }

            $insertData = array(
                'sector' => $value,
                'insertionType' => 1
            );

            $insertResult = $this->Common_model->insert_record('esic_sectors',$insertData);
            if($insertResult){
                echo "OK::Record Successfully Entered";
            }else{
                echo "FAIL::Record Failed Entered";
            }
            return NULL;
        }
        $this->show_admin('admin/configuration/sectors');
        return NULL;
	}else{
		 $this->load->view('admin/page_not_found');
		 }

    }
    //R&D
public function manage_rd($param = NULL){
  $userRole = $this->session->userdata('userRole');
  if(isCurrentUserAdmin($this)){ 
        if($param === 'listing'){
            $selectData = array('
            id AS ID,
            rndname AS rndname,
            IDNumber AS IDNumber,
            AddressContact AS AddressContact,
            ANZSRC AS ANZSRC,
            rndLogo AS Logo,
            CASE WHEN AppStatus = 2 THEN CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-danger">No</span>\') WHEN AppStatus = 3 THEN CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-success">Lodged</span>\') WHEN AppStatus = 1 THEN CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-success">Yes</span>\') ELSE 
                CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-success">No</span>\') END AS ABR,
            CASE WHEN insertionType = 1 THEN CONCAT(\'<span data-target="#permanent-modal" data-toggle="modal" class="label label-danger">YES</span>\') WHEN insertionType = 2 THEN CONCAT(\'<span data-target="#permanent-modal" data-toggle="modal" class="label label-success">NO</span>\') ELSE "" END AS Permanent,
            CASE WHEN trashed = 1 THEN CONCAT(\'<span class="label label-danger">YES</span>\') WHEN trashed = 0 THEN CONCAT(\'<span class="label label-success">NO</span>\') ELSE "" END AS Trashed
            ',false);

            $addColumns = array(
                'ViewEditActionButtons' => array('<a href="#" data-target="#editRndModal" data-toggle="modal"><span data-toggle="tooltip" title="Edit" data-placement="left" aria-hidden="true" class="fa fa-pencil text-blue"></span></a> &nbsp; <a href="#" data-target=".approval-modal" data-toggle="modal"><i data-toggle="tooltip" title="Trash" data-placement="right"  class="fa fa-trash-o text-red"></i></a>','UserID')
            );
            $returnedData = $this->Common_model->select_fields_joined_DT($selectData,'esic_rnd','','','','','',$addColumns);
            print_r($returnedData);
            return NULL;
        }
        if($param === 'update'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }

            $id             = $this->input->post('id');
            $rndname        = $this->input->post('rndname');
            $IDNumber       = $this->input->post('IDNumber');
            $AddressContact = $this->input->post('AddressContact');
            $ANZSRC         = $this->input->post('ANZSRC');

            if(empty($rndname) && empty($id)){
                echo "FAIL::Value Must Be Entered";
                return NULL;
            }

            $updateData = array(
                'rndname'        => $rndname,
                'IDNumber'      => $IDNumber,
                'AddressContact'=> $AddressContact,
                'ANZSRC'        => $ANZSRC,
                'insertionType' => 1
            );

            $whereUpdate = array(
                'id' => $id
            );

            $updateResult = $this->Common_model->update('esic_rnd',$whereUpdate,$updateData);
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
        if($param === 'trash'){
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
            if($value == 'trash'){
                $data = 1;
            }else if($value == 'untrash'){
                $data = 0;
            }else{
                $data = 2;
            }

            $updateData = array(
                'trashed' => $data
            );

            $whereUpdate = array(
                'id' => $id
            );

            $returnedData = $this->Common_model->update('esic_rnd',$whereUpdate,$updateData);
            if($returnedData === true){
                echo "OK::Record Successfully";
            }else{
                echo "FAIL::".$returnedData['message'];
            }
            return NULL;
        }
        if($param === 'permanent'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }

            $id = $this->input->post('id');
            $value = $this->input->post('value');

            if(empty($id)){
                echo "FAIL::Posted values are not VALID 1";
                return NULL;
            }

            if(empty($value)){
                echo "FAIL::Posted values are not VALID 2";
                return NULL;
            }
            $data='';
            if($value == 'Permanent'){
                $data = 1;
            }else if($value == 'noPermanent'){
                $data = 2;
            }else{
                $data = 0;
            }

            $updateData = array(
                'insertionType' => $data
            );

            $whereUpdate = array(
                'id' => $id
            );

            $returnedData = $this->Common_model->update('esic_rnd',$whereUpdate,$updateData);
            if($returnedData === true){
                echo "OK::Record Successfully";
            }else{
                echo "OK::FAIL::".$returnedData['message'];
            }
            return NULL;
        }
        if($param === 'abr'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }

            $id = $this->input->post('id');
            $value = $this->input->post('value');

            if(empty($id)){
                echo "FAIL::Posted values are not VALID 1";
                return NULL;
            }

            if(empty($value)){
                echo "FAIL::Posted values are not VALID 2";
                return NULL;
            }
            $data=$value;
            $updateData = array(
                'AppStatus' => $data
            );

            $whereUpdate = array(
                'id' => $id
            );

            $returnedData = $this->Common_model->update('esic_rnd',$whereUpdate,$updateData);
            if($returnedData === true){
                echo "OK::Record Successfully";
            }else{
                echo "OK::FAIL::".$returnedData['message'];
            }
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

                $whereUpdate = array(
                    'id' => $id
                );

                $returnedData = $this->Common_model->delete('esic_rnd',$whereUpdate);
                echo "OK::Record Deleted";
            }else{
                echo "FAIL::Record Not Deleted";
            }
            return NULL;
        }
        if($param === 'new'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }
            $rndname        = $this->input->post('Rnd');
            $IDNumber       = $this->input->post('IDNumber');
            $AddressContact = $this->input->post('AddressContact');
            $ANZSRC         = $this->input->post('ANZSRC');

            if(empty($rndname)){
                echo "FAIL::Value Must Be Entered";
                return NULL;
            }

            $insertData = array(
                'rndname'       => $rndname,
                'IDNumber'      => $IDNumber,
                'AddressContact'=> $AddressContact,
                'ANZSRC'        => $ANZSRC,
                'insertionType' => 1
            );

            $insertResult = $this->Common_model->insert_record('esic_rnd',$insertData);
            echo "OK::Record Successfully Entered";
            return NULL;
        }
        if($param === 'updateLogo'){
            $accID = $this->input->post('id');
            $allowedExt = array('jpeg','jpg','png','gif');
            $uploadPath = './pictures/logos/';
            $uploadDirectory = './pictures/logos/';
            $uploadDBPath = 'pictures/logos/';
            $insertDataArray = array();
            //For Logo Upload
            if(isset($_FILES['logo']['name']))
            {
                $FileName = $_FILES['logo']['name'];
                $explodedFileName = explode('.',$FileName);
                $ext = end($explodedFileName);
                if(!in_array(strtolower($ext),$allowedExt))
                {
                    echo "FAIL:: Only Image JPEG, PNG and GIF Images Allowed, No Other Extensions Are Allowed::error";
                    return;
                }else
                {

                    $FileName = "rndLogo".$accID."_".time().".".$ext;
                    if(!is_dir($uploadDirectory)){
                        mkdir($uploadDirectory, 0755, true);
                    }

                    move_uploaded_file($_FILES['logo']['tmp_name'],$uploadPath.$FileName);
                    $insertDataArray['rndLogo'] = $uploadDBPath.$FileName;
                }
            }else{
                echo "FAIL::Logo Image Is Required";
                return;
            }

            if(empty($accID)){
                echo "FAIL::Something went wrong with the Post, Please Contact System Administrator For Further Assistance.";
                exit;
            }
            $selectData = array('rndLogo AS logo',false);
            $where = array(
                'id' => $accID
            );
            $returnedData = $this->Common_model->select_fields_where('esic_rnd',$selectData, $where, false, '', '', '','','',false);
            $logo = $returnedData[0]->logo;
            if(!empty($logo) && is_file(FCPATH.'/'.$logo)){
                unlink('./'.$logo);
            }
            $resultUpdate = $this->Common_model->update('esic_rnd',$where,$insertDataArray);
            // if($resultUpdate === true){
            echo "OK::Record Updated Successfully";
            //}else{
            //    echo "FAIL::Something went wrong during Update, Please Contact System Administrator";
            //}
            return NULL;
        }
        $this->show_admin('admin/configuration/rd');
        return NULL;
  }
  else{
	   $this->load->view('admin/page_not_found');
	  }
}

public function manage_acc_commercials($param= Null){
   $userRole = $this->session->userdata('userRole');
   if(isCurrentUserAdmin($this)){
			  
        if($param === 'listing'){
            $selectData = array('
            id AS ID,
            Member AS Member,
			Project_Location AS Project_Location,
            Web_Address AS Web_Address,
            address_state_Territory AS address_state_Territory,
            Project_Location AS Project_Location,
            Project_Title AS Project_Title,
            Project_Summary AS Project_Summary,
            Project_Success AS Project_Success,
            Market AS Market,
            Technology AS Technology,
            logo AS Logo,
            Type AS Type,
            CASE WHEN AppStatus = 2 THEN CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-danger">No</span>\') WHEN AppStatus = 3 THEN CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-success">Lodged</span>\') WHEN AppStatus = 1 THEN CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-success">Yes</span>\') ELSE 
                CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-success">No</span>\') END AS ABR,
            CASE WHEN insertionType = 1 THEN CONCAT(\'<span data-target="#permanent-modal" data-toggle="modal" class="label label-danger">YES</span>\') WHEN insertionType = 2 THEN CONCAT(\'<span data-target="#permanent-modal" data-toggle="modal" class="label label-success">NO</span>\') ELSE "" END AS Permanent,
            CASE WHEN trashed = 1 THEN CONCAT(\'<span class="label label-danger">YES</span>\') WHEN trashed = 0 THEN CONCAT(\'<span class="label label-success">NO</span>\') ELSE "" END AS Trashed
            ',false);

            $addColumns = array(
                'ViewEditActionButtons' => array('<a href="#" data-target="#editAccelerationModal" data-toggle="modal"><span data-toggle="tooltip" title="Edit" data-placement="left" aria-hidden="true" class="fa fa-pencil text-blue"></span></a> &nbsp; <a href="#" data-target=".approval-modal" data-toggle="modal"><i data-toggle="tooltip" title="Trash" data-placement="right"  class="fa fa-trash-o text-red"></i></a>','UserID')
            );
            $returnedData = $this->Common_model->select_fields_joined_DT($selectData,'esic_acceleration','','','','','',$addColumns);
            print_r($returnedData);
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
            if(empty($id) or !is_numeric($id)){
                echo "FAIL::Posted values are not VALID";
                return NULL;
            }
            if($value=='permanentDelete'){
                $whereUpdate = array(
                    'id' => $id
                );
                $this->Common_model->delete('esic_acceleration',$whereUpdate);
                echo "OK::Record Deleted Successfully";
            }else{

                $updateData = array(
                    'trashed' => 1
                );

                $whereUpdate = array(
                    'id' => $id
                );

                $returnedData = $this->Common_model->update('esic_acceleration',$whereUpdate,$updateData);
                // if($returnedData === true){
                echo "OK::Record Successfully Trashed";
                // }else{
                echo "FAIL::".$returnedData['message'];
                // }
            }
            return NULL;
        }
        if($param === 'trash'){
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
            if($value == 'trash'){
                $data = 1;
            }else if($value == 'untrash'){
                $data = 0;
            }else{
                $data = 2;
            }

            $updateData = array(
                'trashed' => $data
            );

            $whereUpdate = array(
                'id' => $id
            );

            $returnedData = $this->Common_model->update('esic_acceleration',$whereUpdate,$updateData);
            //if($returnedData === true){
            echo "OK::Record Successfully";
            //}else{
            // echo "FAIL::".$returnedData['message'];
            // }
            return NULL;
        }
        if($param === 'permanent'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }

            $id = $this->input->post('id');
            $value = $this->input->post('value');

            if(empty($id)){
                echo "FAIL::Posted values are not VALID 1";
                return NULL;
            }

            if(empty($value)){
                echo "FAIL::Posted values are not VALID 2";
                return NULL;
            }
            $data='';
            if($value == 'Permanent'){
                $data = 1;
            }else if($value == 'noPermanent'){
                $data = 2;
            }else{
                $data = 0;
            }

            $updateData = array(
                'insertionType' => $data
            );

            $whereUpdate = array(
                'id' => $id
            );

            $returnedData = $this->Common_model->update('esic_acceleration',$whereUpdate,$updateData);
            if($returnedData === true){
                echo "OK::Record Successfully";
            }else{
                echo "OK::FAIL::".$returnedData['message'];
            }
            return NULL;
        }
        if($param === 'abr'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }

            $id = $this->input->post('id');
            $value = $this->input->post('value');

            if(empty($id)){
                echo "FAIL::Posted values are not VALID 1";
                return NULL;
            }

            if(empty($value)){
                echo "FAIL::Posted values are not VALID 2";
                return NULL;
            }
            $data=$value;
            $updateData = array(
                'AppStatus' => $data
            );

            $whereUpdate = array(
                'id' => $id
            );

            $returnedData = $this->Common_model->update('esic_acceleration',$whereUpdate,$updateData);
            if($returnedData === true){
                echo "OK::Record Successfully";
            }else{
                echo "OK::FAIL::".$returnedData['message'];
            }
            return NULL;
        }
        if($param === 'update'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }

            $id                 = $this->input->post('id');
            $Member             = $this->input->post('Member');
            $Web_Address        = $this->input->post('webaddress');
            //$address_state_Territory    = $this->input->post('address_state_Territory');
            //$Project_Location   = $this->input->post('Project_Location');
            $Project_Title      = $this->input->post('projecttitle');
            //$Project_Summary    = $this->input->post('Project_Summary');
            //$Project_Success    = $this->input->post('Project_Success');
            //$Market             = $this->input->post('Market');
            //$Technology         = $this->input->post('Technology');
            //$Type               = $this->input->post('Type');*/

            if(empty($id) or !is_numeric($id)){
                echo "FAIL::Posted values are not VALID";
                return NULL;
            }

            if(empty($Member)){
                echo "FAIL::Value Must Be Entered";
                return NULL;
            }

            $updateData = array(
                'Member'            => $Member,
                'Web_Address'       => $Web_Address,
                //'address_state_Territory'   => $address_state_Territory,
                //'Project_Location'  => $Project_Location,
                'Project_Title'     => $Project_Title,
                //'Project_Summary'   => $Project_Summary,
                //'Project_Success'   => $Project_Success,
                //'Market'            => $Market,
                //'Technology'        => $Technology,
                //'Type'              => $Type,
                'insertionType' => 1
            );

            $whereUpdate = array(
                'id' => $id
            );

            $updateResult = $this->Common_model->update('esic_acceleration',$whereUpdate,$updateData);
            // if($updateResult === true){
            echo "OK::Record Successfully Updated";
            /* }else{
                 if($updateResult['code'] == 0){
                     echo "OK::Record Already Exist";
                 }else{
                     echo $updateResult['message'];
                 }
             }*/
            return NULL;
        }
        if($param === 'updateLogo'){
            $accID = $this->input->post('id');
            $allowedExt = array('jpeg','jpg','png','gif');
            $uploadPath = './pictures/logos/';
            $uploadDirectory = './pictures/logos/';
            $uploadDBPath = 'pictures/logos/';
            $insertDataArray = array();
            //For Logo Upload
            if(isset($_FILES['logo']['name']))
            {
                $FileName = $_FILES['logo']['name'];
                $explodedFileName = explode('.',$FileName);
                $ext = end($explodedFileName);
                if(!in_array(strtolower($ext),$allowedExt))
                {
                    echo "FAIL:: Only Image JPEG, PNG and GIF Images Allowed, No Other Extensions Are Allowed::error";
                    return;
                }else
                {

                    $FileName = "logo".$accID."_".time().".".$ext;
                    if(!is_dir($uploadDirectory)){
                        mkdir($uploadDirectory, 0755, true);
                    }

                    move_uploaded_file($_FILES['logo']['tmp_name'],$uploadPath.$FileName);
                    $insertDataArray['logo'] = $uploadDBPath.$FileName;
                }
            }else{
                echo "FAIL::Logo Image Is Required";
                return;
            }

            if(empty($accID)){
                echo "FAIL::Something went wrong with the Post, Please Contact System Administrator For Further Assistance.";
                exit;
            }
            $selectData = array('logo AS logo',false);
            $where = array(
                'id' => $accID
            );
            $returnedData = $this->Common_model->select_fields_where('esic_acceleration',$selectData, $where, false, '', '', '','','',false);
            $logo = $returnedData[0]->logo;
            if(!empty($logo) && is_file(FCPATH.'/'.$logo)){
                unlink('./'.$logo);
            }
            $resultUpdate = $this->Common_model->update('esic_acceleration',$where,$insertDataArray);
            if($resultUpdate === true){
                echo "OK::Record Updated Successfully";
            }else{
                echo "FAIL::Something went wrong during Update, Please Contact System Administrator";
            }
            return NULL;
        }
        if($param === 'new'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }
            $value  = $this->input->post('Acceleration');
            $WA     = $this->input->post('webaddress');
            $PT     = $this->input->post('projecttitle');

            if(empty($value)){
                echo "FAIL::Value Must Be Entered";
                return NULL;
            }

            $insertData = array(
                'Member' => $value,
                'Web_Address' => $WA,
                'Project_Title' => $PT,
                'insertionType' => 1
            );

            $insertResult = $this->Common_model->insert_record('esic_acceleration',$insertData);
            //if($insertResult){
            echo "OK::Record Successfully Entered";
            //}else{
            //echo "FAIL::Record Failed Entered";
            //}
            return NULL;
        }
        $this->show_admin('admin/configuration/acc_commercials');
        return NULL;
    }
	else{
		$this->load->view('admin/page_not_found');
		}
}
public function manage_accelerators($param= Null){
  $userRole = $this->session->userdata('userRole');
  if(isCurrentUserAdmin($this)){		
		
        if($param === 'listing'){
            $selectData = array('
            id AS ID,
            name AS Name,
			address AS Address,
            website AS Website,
            logo AS Logo,
            CASE WHEN AppStatus = 2 THEN CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-danger">No</span>\') WHEN AppStatus = 3 THEN CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-success">Lodged</span>\') WHEN AppStatus = 1 THEN CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-success">Yes</span>\') ELSE 
                CONCAT(\'<span data-target="#abr-modal" data-toggle="modal" class="label label-success">No</span>\') END AS ABR,
            CASE WHEN insertionType = 1 THEN CONCAT(\'<span data-target="#permanent-modal" data-toggle="modal" class="label label-danger">YES</span>\') WHEN insertionType = 2 THEN CONCAT(\'<span data-target="#permanent-modal" data-toggle="modal" class="label label-success">NO</span>\') ELSE "" END AS Permanent,
            CASE WHEN trashed = 1 THEN CONCAT(\'<span class="label label-danger">YES</span>\') WHEN trashed = 0 THEN CONCAT(\'<span class="label label-success">NO</span>\') ELSE "" END AS Trashed
            ',false);

            $addColumns = array(
                'ViewEditActionButtons' => array('<a href="#" data-target="#editAccelerationModal" data-toggle="modal"><span data-toggle="tooltip" title="Edit" data-placement="left" aria-hidden="true" class="fa fa-pencil text-blue"></span></a> &nbsp; <a href="#" data-target=".approval-modal" data-toggle="modal"><i data-toggle="tooltip" title="Trash" data-placement="right"  class="fa fa-trash-o text-red"></i></a>','UserID')
            );
            $returnedData = $this->Common_model->select_fields_joined_DT($selectData,'esic_accelerators','','','','','',$addColumns);
            print_r($returnedData);
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

            //if(empty($value) or $value !== 'approve'){
            //echo "FAIL::Posted values are not VALID";
            //return NULL;
            //  }
            if($value=='permanentDelete'){
                $whereUpdate = array(
                    'id' => $id
                );

                $this->Common_model->delete('esic_accelerators',$whereUpdate);
                echo "OK::Record Deleted Successfully";
            }else{

                $updateData = array(
                    'trashed' => 1
                );

                $whereUpdate = array(
                    'id' => $id
                );

                $returnedData = $this->Common_model->update('esic_accelerators',$whereUpdate,$updateData);
                if($returnedData === true){
                    echo "OK::Record Successfully Trashed";
                }else{
                    echo "FAIL::".$returnedData['message'];
                }
            }
            return NULL;
        }
        if($param === 'trash'){
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
            if($value == 'trash'){
                $data = 1;
            }else if($value == 'untrash'){
                $data = 0;
            }else{
                $data = 2;
            }

            $updateData = array(
                'trashed' => $data
            );

            $whereUpdate = array(
                'id' => $id
            );

            $returnedData = $this->Common_model->update('esic_accelerators',$whereUpdate,$updateData);
            if($returnedData === true){
                echo "OK::Record Successfully";
            }else{
                echo "FAIL::".$returnedData['message'];
            }
            return NULL;
        }
        if($param === 'permanent'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }

            $id = $this->input->post('id');
            $value = $this->input->post('value');

            if(empty($id)){
                echo "FAIL::Posted values are not VALID 1";
                return NULL;
            }

            if(empty($value)){
                echo "FAIL::Posted values are not VALID 2";
                return NULL;
            }
            $data='';
            if($value == 'Permanent'){
                $data = 1;
            }else if($value == 'noPermanent'){
                $data = 2;
            }else{
                $data = 0;
            }

            $updateData = array(
                'insertionType' => $data
            );

            $whereUpdate = array(
                'id' => $id
            );

            $returnedData = $this->Common_model->update('esic_accelerators',$whereUpdate,$updateData);
            if($returnedData === true){
                echo "OK::Record Successfully";
            }else{
                echo "OK::FAIL::".$returnedData['message'];
            }
            return NULL;
        }
        if($param === 'update'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }

            $id   = $this->input->post('id');
            $name = $this->input->post('name');
            $Web  = $this->input->post('web');
            if(empty($id) or !is_numeric($id)){
                echo "FAIL::Posted values are not VALID";
                return NULL;
            }

            if(empty($name)){
                echo "FAIL::Value Must Be Entered";
                return NULL;
            }

            $updateData = array(
                'name'    => $name,
                'website' => $Web,
                'insertionType' => 1
            );

            $whereUpdate = array(
                'id' => $id
            );

            $updateResult = $this->Common_model->update('esic_accelerators',$whereUpdate,$updateData);
            if($updateResult === true){
                echo "OK::Record Successfully Updated";
            }else{
                if($updateResult['code'] == 0){
                    echo "OK::Record Already Exist::".$updateResult['message'];
                }else{
                    echo $updateResult['message'];
                }
            }
            return NULL;
        }
        if($param === 'abr'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }

            $id = $this->input->post('id');
            $value = $this->input->post('value');

            if(empty($id)){
                echo "FAIL::Posted values are not VALID 1";
                return NULL;
            }

            if(empty($value)){
                echo "FAIL::Posted values are not VALID 2";
                return NULL;
            }
            $data=$value;
            $updateData = array(
                'AppStatus' => $data
            );

            $whereUpdate = array(
                'id' => $id
            );

            $returnedData = $this->Common_model->update('esic_accelerators',$whereUpdate,$updateData);
            if($returnedData === true){
                echo "OK::Record Successfully";
            }else{
                echo "OK::FAIL::".$returnedData['message'];
            }
            return NULL;
        }
        if($param === 'new'){
            if(!$this->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }
            $value = $this->input->post('Acceleration');

            if(empty($value)){
                echo "FAIL::Value Must Be Entered";
                return NULL;
            }

            $insertData = array(
                'name' => $value,
                'insertionType' => 1
            );

            $insertResult = $this->Common_model->insert_record('esic_accelerators',$insertData);
            if($insertResult){
                echo "OK::Record Successfully Entered";
            }else{
                echo "FAIL::Record Failed Entered";
            }
            return NULL;
        }
        if($param === 'updateLogo'){
            $accID = $this->input->post('id');
            $allowedExt = array('jpeg','jpg','png','gif');
            $uploadPath = './pictures/logos/';
            $uploadDirectory = './pictures/logos/';
            $uploadDBPath = 'pictures/logos/';
            $insertDataArray = array();
            //For Logo Upload
            if(isset($_FILES['logo']['name']))
            {
                $FileName = $_FILES['logo']['name'];
                $explodedFileName = explode('.',$FileName);
                $ext = end($explodedFileName);
                if(!in_array(strtolower($ext),$allowedExt))
                {
                    echo "FAIL:: Only Image JPEG, PNG and GIF Images Allowed, No Other Extensions Are Allowed::error";
                    return;
                }else
                {

                    $FileName = "logo".$accID."_".time().".".$ext;
                    if(!is_dir($uploadDirectory)){
                        mkdir($uploadDirectory, 0755, true);
                    }

                    move_uploaded_file($_FILES['logo']['tmp_name'],$uploadPath.$FileName);
                    $insertDataArray['logo'] = $uploadDBPath.$FileName;
                }
            }else{
                echo "FAIL::Logo Image Is Required";
                return;
        }

      if(empty($accID)){
          echo "FAIL::Something went wrong with the Post, Please Contact System Administrator For Further Assistance.";
          exit;
      }
      $selectData = array('logo AS logo',false);
      $where = array(
          'id' => $accID
      );
      $returnedData = $this->Common_model->select_fields_where('esic_accelerators',$selectData, $where, false, '', '', '','','',false);
      $logo = $returnedData[0]->logo;
      if(!empty($logo) && is_file(FCPATH.'/'.$logo)){
          unlink('./'.$logo);
      }
      $resultUpdate = $this->Common_model->update('esic_accelerators',$where,$insertDataArray);
            if($resultUpdate === true){
                echo "OK::Record Updated Successfully";
            }else{
                echo "FAIL::Something went wrong during Update, Please Contact System Administrator";
            }
            return NULL;
        }
        $this->show_admin('admin/configuration/accelerators');
        return NULL;
    } else{
		   $this->load->view('admin/page_not_found');
		  } 
}
    //Show or HIde Exp Date for the Front.
    public function showExpDate(){
        $update = $this->input->post('expDate');
        $userID = $this->input->post('userID');

        if($update === 'show'){
            $showExpDate = 1;
        }else{
            $showExpDate = 0;
        }
        $whereUpdate = array(
            'id' =>  $userID
        );
        $updateData = array(
            'showExpDate' => $showExpDate
        );

        $updateResult = $this->Common_model->update('esic',$whereUpdate,$updateData);

        if($updateResult === true){
            echo "OK::Successfully Updated";
        }else{
            echo "FAIL::".$updateResult['message'];
        }

        var_dump($updateResult);

        echo $this->db->last_query();

    }
public function  UpDateSocials(){ 
              $id        = $this->input->post('id');
			  $facebook  = $this->input->post('facebook');
			  $twitter   = $this->input->post('twitter');
		      $google    = $this->input->post('google');
			  $linkedIn  = $this->input->post('linkedIn');
			  $instagram  = $this->input->post('instagram');
			  
			  $data     = array(
						  'facebook' => $facebook,
						  'twitter'  => $twitter,
						  'google'   => $google,
						  'linked_in' => $linkedIn,
						  'instagram'=> $instagram 
						 );
			 $data2     = array(
			              'userID'=> $id,
						  'facebook' => $facebook,
						  'twitter'  => $twitter,
						  'google'   => $google,
						  'linked_in' => $linkedIn,
						  'instagram'=> $instagram 
						 );			 
			 			 
		    $ok       = $this->Esic_model->update_social($id,$data,$data2);
		    echo $ok;  
		}		
	//for manage assessment user profile
    public function manage_profile($list=NULL){
        $userID = $this->session->userdata('userID');
          if($list === 'listing'){
          $selectData = array('
            h_user.userID as UserID,
			CONCAT(`h_user`.`firstName`," ",`h_user`.`lastName`) AS FullName,
            h_user.email AS Email,
			name AS Company,
            ES.id as StatusID, 
            CASE WHEN user_draft.Publish = 1 THEN CONCAT("<span class=\'label status label-success pub\'> Published </span>") WHEN user_draft.Publish = 0 THEN CONCAT ("<span class=\'label status label-danger\'>Draft</span>") ELSE CONCAT ("<span class=\'label status label-warning\'> ", Publish, " </span>") END AS  Publish,
            ES.color AS color,
             CASE WHEN ES.id > 0 THEN CONCAT("<span class=\'label \' style=\' background-color:",color,"\'> ", ES.status," </span>") ELSE CONCAT ("<span class=\'label label-warning\'> ", ES.status, " </span>") END AS Status 
            ',false);

                $joins = array(
                  array(
                      'table' 	=> 'esic_status ES',
                      'condition' => 'ES.id = user_draft.status',
                      'type' 		=> 'LEFT'
                  ),
                  array(
                      'table' 	=> 'hoosk_user h_user',
                      'condition' => 'h_user.userID = user_draft.userID',
                      'type' 		=> 'LEFT'
                  )
                );

                $where = array(

                    "h_user.userID" => $userID
                );
                $addColumns = array(
                    'ViewEditActionButtons' => array('<a href="'.base_url("admin/details/$1").'"><span aria-hidden="true" class="glyphicon glyphicon-edit text-green "></span></a> &nbsp; <a href="#" data-target=".change-status" data-toggle="modal"><i data-toggle="tooltip" title="Publish" data-placement="left" class="fa fa-check ml-fa"></i></a> &nbsp; <a href="#" data-target=".delete-modal" data-toggle="modal"><i class="fa fa-trash-o"></i></a>','UserID')
                );
                $returnedData = $this->Common_model->select_fields_joined_DT($selectData,'user_draft',$joins,$where,'','','',$addColumns);
                print_r($returnedData);
                return NULL;
            }

            $data['title'] = 'Pre-assessment List';
            $this->show_admin("admin/manage_profile",$data);

    }
    public function publish_assessment_list(){
        $id = $this->input->post('id');
        $this->Common_model->publish_assessment_list($id);
        echo "OK::Your Profile is successfully published";
    }
    public function fb(){
        $data['esic'] = array();

        // Check if user is logged in
        if ($this->facebook->is_authenticated())
        {

            $user = $this->facebook->request('get', '/me?fields=id,name,email,gender,first_name,last_name,locale,timezone,location');

           $id          = $user['id'];
           $first_name  = $user['first_name'];
           $lastname    = $user['last_name'];
           $email       = $user['email'];

             

            $result=$this->Hoosk_model->facebook_login($email);
            if($result) {
                redirect('/admin', 'refresh');
            }
            else
            {
                $this->data['error'] = "1";
                $this->login();
            }
        }
    }

    private function _getUserQAnswers($userID,$listingID){
        if(empty($userID) || !is_numeric($userID)){
            return false;
        }

        if(empty($listingID) and !is_numeric($listingID)){
            $listingID = 1;
        }

        $selectData2 = array('        
                    EQ.Question as Question,
                    EQ.id as questionID,
                    QPS.Solution as PossibleSolution,
                    UA.answer as ProvidedSolution
                    -- ES.score as score
            ',false);//ES.Score as points
//        $where2 = "EQ.isPublished = 1";
        $where = [
            'EQ.`isPublished`' => 1,
             'QL.listing_id' => $listingID
        ];
        $joins2 = array(
            array(
                'table' => 'esic_questions_listings QL',
                'condition' => 'QL.question_id = EQ.id',
                'type' => 'LEFT'
            ),
            array(
                'table' => 'esic_questions_answers QPS',
                'condition' => 'QPS.questionID = EQ.id',
                'type' => 'LEFT'
            ),
            array(
                'table' => 'esic_question_users_answers UA',
                'condition' => 'UA.answer_id = QPS.id AND user_id = '.$userID,
                'type' => 'LEFT'
            )

        );
        $groupBy = ['EQ.id'];
        $orderBy = ['QL.order'];
        $result = $this->Common_model->select_fields_where_like_join('esic_questions EQ',$selectData2,$joins2,$where,FALSE,'','',$groupBy,$orderBy);
        return $result;
    }

    public function updateDB(){
        //Update the States.
        //Get the States from Api Frist.
        $StatesJSON = file_get_contents('http://v0.postcodeapi.com.au/states.json');
        if(!empty($StatesJSON)){
            $States = json_decode($StatesJSON);
        }
        $statesTable = 'states';
        if(isset($States) and !empty($States)){
            //First Empty the Whole DB.
            $this->db->truncate($statesTable);

            $extrasStates = [
                [
                    'name' => 'Other',
                    'abbreviation' => 'OS' //Over Seas
                ]
            ];

            $States = array_merge($States,$extrasStates);

            //Now Just Add the new Entries.
            $this->Common_model->insert_multiple($statesTable,$States);
            if ($this->db->affected_rows() > 0) {
                echo '<pre>';
                echo 'States Updated';
                echo '</pre>';
            }
        }

        //Update the PostCodes for States.
        //Get the PostCodes from online Frist.
        $PostCodesJSON = file_get_contents('https://raw.githubusercontent.com/Elkfox/Australian-Postcode-Data/master/au_postcodes.json');
        if(!empty($PostCodesJSON)){
            $PostCodes = json_decode($PostCodesJSON,true);
        }

        $postCodesTable = 'sys_post_codes';
        if(isset($PostCodes) and !empty($PostCodes)){

            //First Empty the Whole DB.
            $this->db->truncate($postCodesTable);

            //unset the columns that are not in mysql table.
            foreach($PostCodes as $key=>$postCode){
                unset($PostCodes[$key]['state_name']);
            }

            //Now Just Add the new Entries.
            $this->Common_model->insert_multiple($postCodesTable,$PostCodes);
            if ($this->db->affected_rows() > 0) {
                echo '<pre>';
                echo 'PostCodes Updated';
                echo '</pre>';
            }
        }
    }

}
