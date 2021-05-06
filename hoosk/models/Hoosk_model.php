<?php
class Hoosk_model extends MY_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->dbforge();
    }
	
	/*     * *************************** */
    /*     * ** Dash Querys ************ */
    /*     * *************************** */
	function getSiteName() {
        // Get Theme
        $this->db->select("*");
       	$this->db->where("siteID", 0);
		$query = $this->db->get('hoosk_settings');
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
        	foreach ($results as $u): 
				return $u['siteTitle'];			
			endforeach; 
		}
        return array();
    }
	
	function getTheme() {
        // Get Theme
        $this->db->select("*");
       	$this->db->where("siteID", 0);
		$query = $this->db->get('hoosk_settings');
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
        	foreach ($results as $u): 
				return $u['siteTheme'];			
			endforeach; 
		}
        return array();
    }
	function getLang() {
        // Get Theme
        $this->db->select("*");
       	$this->db->where("siteID", 0);
		$query = $this->db->get('hoosk_settings');
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
        	foreach ($results as $u): 
				return $u['siteLang'];			
			endforeach; 
		}
        return array();
    }
    function getUpdatedPages() {
        // Get most recently updated pages
        $this->db->select("pageTitle, hoosk_page_attributes.pageID, pageUpdated, pageContentHTML");
        $this->db->join('hoosk_page_content', 'hoosk_page_content.pageID = hoosk_page_attributes.pageID');
        $this->db->join('hoosk_page_meta', 'hoosk_page_meta.pageID = hoosk_page_attributes.pageID');
		$this->db->order_by("pageUpdated", "desc");
		$this->db->limit(5);
        $query = $this->db->get('hoosk_page_attributes');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
    /*     * *************************** */
    /*     * ** User Querys ************ */
    /*     * *************************** */
    function countUsers(){
          return $this->db->count_all('hoosk_user');
 	}
                 /* Dashboard */
	
	function get_ass_status($id=NULL){
        $this->db->where('status', $id);
		$this->db->from('esic');
		return $this->db->count_all_results();
 	}
    function get_user_esic_status($id = NULL){
        $where = $this->getUserWhere();
        $where['status'] = $id;
        $this->db->where($where);
        $this->db->from('esic');
        return $this->db->count_all_results();
    }			 
	function counttUsers(){
          return $this->db->count_all('esic');
 	}
	function institution(){
          return $this->db->count_all('esic_institution');
 	}
	function esic_rnd(){
          return $this->db->count_all('esic_rnd');
 	}
	function c_acceleration_c(){
          return $this->db->count_all('esic_acceleration');
 	}
	
	/*function get_Users_Pending(){
		$this->db->where('status', 1);
		$this->db->from('esic');
		return $this->db->count_all_results();
	}
	function get_Users_In_assessment(){
		$this->db->where('status', 2);
		$this->db->from('esic');
		return $this->db->count_all_results();
	}
	function get_Users_Self_assessed(){
		$this->db->where('status', 3);
		$this->db->from('esic');
		return $this->db->count_all_results();
	}
	function get_Users_Later_stage(){
		$this->db->where('status', 4);
		$this->db->from('esic');
		return $this->db->count_all_results();
	}
	function get_Users_confirm_RD_ratio(){
		$this->db->where('status', 5);
		$this->db->from('esic');
		return $this->db->count_all_results();
	}
	function get_Users_confirm_RD_Investment(){
		$this->db->where('status', 6);
		$this->db->from('esic');
		return $this->db->count_all_results();
	}
	function approved(){
		$this->db->where('status', 7);
		$this->db->from('esic');
		return $this->db->count_all_results();
	}*/
	
 function get_All_Users($status=NULL) {
        // Get a list of all user accounts
        $this->db->select("name,name, added_date, logo");
		$this->db->order_by("id", "DESC");
		if($status){
		     $this->db->where('status',$status);   
		}
		 $query = $this->db->get('esic');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
	function get_tUsers() {
        // Get a list of all user accounts
        $this->db->select("name,name, added_date, logo");
		
		 $this->db->order_by("id", "DESC");
		  $this->db->limit(8);
		 $query = $this->db->get('esic');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
 
           /* Dashboard  End  */
	
    function getUsers($limit=0, $offset=0,$search=NULL) {
        // Get a list of all user accounts
        $this->db->select("*");
        if($limit > 0){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by("userID", "asc");
        $query = $this->db->get('hoosk_user');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
    function getUser($id) {
        // Get the user details
        $this->db->select("*");
        $this->db->where("userID", $id);
        $query = $this->db->get('hoosk_user');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
    public function  update_p_image	($id=NULL,$data=NULL) // use to udate both user profile and certificate
    {
        $this->db->where('userID',$id);
        $this->db->update('hoosk_user',$data);
        return "ok";
    }
    function getUserEmail($id) {
        // Get the user email address
        $this->db->select("email");
        $this->db->where("userID", $id);
        $query = $this->db->get('hoosk_user');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $email = $rows->email;
                return $email;
            }
        }
    }
    function createUser() {
        // Create the user account
        $role = $this->input->post('role');
        $data = array(
            'userName' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'userRole' => json_encode($role),
            'password' => md5($this->input->post('password').SALT) 
        );
        $this->db->insert('hoosk_user', $data);
    }
   function updateUser($id) {
        // update the user account
        $role = $this->input->post('role');
        $data = array(
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'userRole' => json_encode($role),
            //'password' => md5($this->input->post('password').SALT),
            'password_recovery_question' => $this->input->post('password_recovery_question'),
            'password_recovery_answer' => $this->input->post('password_recovery_answer'),
        );
        $boolean = isCurrentUserAdmin($this);
        if(($boolean && !empty($this->input->post('password'))) || !$boolean){
            $data['password'] = md5($this->input->post('password').SALT);
        }
        $this->db->where('userID', $id);
        $this->db->update('hoosk_user', $data);
		
		//added by hamid raza 
		
		if($role == "2")
		{
		   $this->db->where('userID', $id);
           $query = $this->db->get('esic');
           if ($query->num_rows() > 0)  //if user exist then termonate else add user id into assessment table
		      {
               return true;
              }
		    	$data = array('userID' => $id );
	    	    $this->db->insert('esic', $data);  
         }
		elseif($role == "3")
		 {
		    $this->db->where('fk_investor_ID', $id);
            $query = $this->db->get('esic_investor');
           if ($query->num_rows() > 0)  //if user exist then termonate else add user id into Investor  table
		      {
               return true;
              }
		    	$data = array('fk_investor_ID' => $id );
	    	    $this->db->insert('esic_investor', $data);  
		 } 
    }
    function removeUser($id) {
        // Delete a user account
        $this->db->delete('hoosk_user', array('userID' => $id));
    }
    function getRoles() {
        $this->db->select("*");
        $query = $this->db->get('users_role');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
    function social_login($email,$post_data) {    // use for  google plus , facebook and twitter login
        if($email){
            $this->db->select("*");
            $this->db->where("email", $email);
            $query = $this->db->get("hoosk_user");
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                     $data = array(
                        'userID'    => $rows->userID,
                        'userName'  => $rows->userName,
                        'firstName' => $rows->firstName,
                        'lastName'  => $rows->lastName,
                        'Email'     => $rows->email,
                        'phone'     => $rows->phone,
                        'p_image'   => $rows->p_image,
                        'userRole'  => $rows->userRole,
                        'logged_in' => TRUE,
                    );
                    if(isset($post_data['loginType']) && !empty($post_data['loginType'])){
                        $loginType = $post_data['loginType'];
                        $data['loginType'] = $loginType;
                        $Newdata = array('loginType' => $loginType);
                        $this->db->where("email", $email);
                        $this->db->update('hoosk_user',$Newdata);
                    }
                    $this->session->set_userdata($data);
                    return true;
                }
            } else {
                    
                    $this->db->insert('hoosk_user',$post_data);
                    $userID  = $this->db->insert_id();
                    $this->session->set_userdata('userID',$userID);
                
                     if($userID){
                        $data = array(
                            'userName'  => $post_data['userName'],
                            'firstName' => $post_data['firstName'],
                            'lastName'  => $post_data['lastName'],
                            'Email'     => $post_data['email'],
                            'userRole'  => $post_data['userRole'],
                            'logged_in' => TRUE,
                        );

                        if(isset($post_data['loginType']) && !empty($post_data['loginType'])){
                            $loginType = $post_data['loginType'];
                            $data['loginType'] = $loginType;
                        }
                           $this->session->set_userdata($data);
                           return true;
                       }else{
                             return false;
                            }
                       
            }
       }else{
            return false;
            }
    }
    function login($username, $password) {
        $this->db->select("*");
        //$password = 'b899ebc7cc30af3a862d3b5c2b4f9b96';
        $where = '`password` = "'.$password.'" AND ( `email` =  "'.$username.'" OR `userName` = "'.$username.'")';
        $this->db->where($where,NULL,FALSE);
        $query = $this->db->get("hoosk_user");
        if($query->num_rows() > 0){
            foreach ($query->result() as $rows) {
                $data = array(
                    'userID'    => $rows->userID,
                    'userName'  => $rows->userName,
                    'firstName' => $rows->firstName,
                    'lastName'  => $rows->lastName,
                    'Email'     => $rows->email,
                    'phone'     => $rows->phone,
                    'p_image'   => $rows->p_image,
                    'userRole'  => $rows->userRole,
                    'logged_in' => TRUE,
                );
                $this->session->set_userdata($data);
                return true;
            }
        } else {
            return false;
        }
    }
    function loginByRs($username, $password) {
        $this->db->select("*");
        $where = '`RS` = "'.$password.'" AND ( `email` =  "'.$username.'" OR `userName` = "'.$username.'")';
        $this->db->where($where,NULL,FALSE);
        $query = $this->db->get("hoosk_user");
        if($query->num_rows() > 0){
            foreach ($query->result() as $rows) {
                $data = array(
                    'userID'    => $rows->userID,
                    'userName'  => $rows->userName,
                    'firstName' => $rows->firstName,
                    'lastName'  => $rows->lastName,
                    'Email'     => $rows->email,
                    'phone'     => $rows->phone,
                    'p_image'   => $rows->p_image,
                    'userRole'  => $rows->userRole,
                    'logged_in' => TRUE,
                );
                $this->session->set_userdata($data);
                return true;
            }
        } else {
            return false;
        }
    }

    function getPasswordByRs($username,$password){
        $this->db->select("RS");
        $where = '`RS` = "'.$password.'" AND ( `email` =  "'.$username.'" OR `userName` = "'.$username.'")';
        $this->db->where($where,NULL,FALSE);
        $query = $this->db->get("hoosk_user");
        if($query->num_rows() > 0){
            $rows = $query->row();
            if(isset($rows->RS)){
                return $rows->RS;
            }else{
                return false;
            } 
        }else{
            return false;
        }
    }


    /*     * *************************** */
    /*     * ** Page Querys ************ */
    /*     * *************************** */
	function countPages(){
        return $this->db->count_all('hoosk_page_attributes');
    }
    function getPages($limit, $offset=0,$search=NULL) {  
        // Get a list of all pages
        $this->db->select("*");
        $this->db->join('hoosk_page_content', 'hoosk_page_content.pageID = hoosk_page_attributes.pageID');
        $this->db->join('hoosk_page_meta', 'hoosk_page_meta.pageID = hoosk_page_attributes.pageID');
        if($limit > 0){
    		$this->db->limit($limit, $offset);
        }       
	  if(!empty($search)){
	   $this->db->like('pageTitle',$search);
	   }
	    $query =  $this->db->get('hoosk_page_attributes'); 
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
    function update_search_widget_status($id,$value){
        $this->db->where('pageID',$id);
        $query = $this->db->update('hoosk_page_content',array('search_widget' => $value));
        return $query == 1 ? 'Success' : 'Error';
    }
    function getPagesAll() {  
        // Get a list of all pages
        $this->db->select("*");
        $this->db->join('hoosk_page_content', 'hoosk_page_content.pageID = hoosk_page_attributes.pageID');
        $this->db->join('hoosk_page_meta', 'hoosk_page_meta.pageID = hoosk_page_attributes.pageID');
         $query = $this->db->get('hoosk_page_attributes');		
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
    function createPage() {
        // Create the page
        $data = array(
            'pagePublished' => $this->input->post('pagePublished'),
			'pageTemplate' => $this->input->post('pageTemplate'),
            'pageURL' => $this->input->post('pageURL'),
        );
        $this->db->insert('hoosk_page_attributes', $data);
		if ($this->input->post('content') != ""){
        $sirTrevorInput = $this->input->post('content');
        $converter = new Converter();
        $HTMLContent = $converter->toHtml($sirTrevorInput);} else {
		$HTMLContent = "";	
		}
        $this->db->select("*");
        $this->db->where("pageURL", $this->input->post('pageURL'));
        $query = $this->db->get("hoosk_page_attributes");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $contentdata = array(
                    'pageID' => $rows->pageID,
                    'pageTitle' => $this->input->post('pageTitle'),
            		'navTitle' => $this->input->post('navTitle'),
                    'pageContent' => $this->input->post('content'),
                    'pageContentHTML' => $HTMLContent,
                );
                $this->db->insert('hoosk_page_content', $contentdata);
                $metadata = array(
                    'pageID' => $rows->pageID,
                    'pageKeywords' => $this->input->post('pageKeywords'),
                    'pageDescription' => $this->input->post('pageDescription'),
                );
                $this->db->insert('hoosk_page_meta', $metadata);
            }
        }
    }
    function getPage($id) {
        // Get the page details
        $this->db->select("*");
        $this->db->where("hoosk_page_attributes.pageID", $id);
        $this->db->join('hoosk_page_content', 'hoosk_page_content.pageID = hoosk_page_attributes.pageID');
        $this->db->join('hoosk_page_meta', 'hoosk_page_meta.pageID = hoosk_page_attributes.pageID');
		$query = $this->db->get('hoosk_page_attributes');
         //echo "<pre>";
        //print_r($query);
       // echo "<pre>";
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
	function getPageBanners($id) {
        // Get the page banners
        $this->db->select("*");
        $this->db->where("pageID", $id);
        $this->db->order_by("slideOrder ASC");
       	$query = $this->db->get('hoosk_banner');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
	
    function removePage($id) {
        // Delete a page
        $this->db->delete('hoosk_page_content', array('pageID' => $id));
        $this->db->delete('hoosk_page_meta', array('pageID' => $id));
        $this->db->delete('hoosk_page_attributes', array('pageID' => $id));
    }
    function getPageURL($id) {
        // Get the page URL
        $this->db->select("pageURL");
        $this->db->where("pageID", $id);
        $query = $this->db->get('hoosk_page_attributes');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $pageURL = $rows->pageURL;
                return $pageURL;
            }
        }
    }
    function updatePage($id) {   // use to add 'page data into database
        if ($this->input->post('content') != ""){
        $sirTrevorInput = $this->input->post('content');
	    $converter = new Converter();
      $HTMLContent = $converter->toHtml($sirTrevorInput);
       	}
        else {
		$HTMLContent = "";	
		}
		
		if ($id != 1){
        	$data = array(
            'pagePublished' => $this->input->post('pagePublished'),
            'pageURL' => $this->input->post('pageURL'),
			'pageTemplate' => $this->input->post('pageTemplate'),
        );
		} else {
			$data = array(
            'pagePublished' => $this->input->post('pagePublished'),
			'pageTemplate' => $this->input->post('pageTemplate'),
       		);			
		}
        $this->db->where("pageID", $id);
        $this->db->update('hoosk_page_attributes', $data);
        $contentdata = array(
            'pageTitle' => $this->input->post('pageTitle'),
            'navTitle' => $this->input->post('navTitle'),
            'pageContent' => $this->input->post('content'),
            'pageContentHTML' => $HTMLContent,
        );
        $this->db->where("pageID", $id);
        $this->db->update('hoosk_page_content', $contentdata);
        $metadata = array(
            'pageKeywords' => $this->input->post('pageKeywords'),
            'pageDescription' => $this->input->post('pageDescription'),
        );
        $this->db->where("pageID", $id);
        $this->db->update('hoosk_page_meta', $metadata);
    }
    function UpdateEsicPageDescription($id) {
        // use to add 'page data into database
        $sirTrevorInput = $this->input->post('desc-content');
	   	if ($sirTrevorInput != ""){
	    $converter = new Converter();
            $HTMLContent = $converter->toHtml($sirTrevorInput);
       	} else {
		  $HTMLContent = "";
		}
        //Update in User Table the Buisness Description where User ID is ------
        $contentdata = array(
            'businessShortDescriptionJSON' => $sirTrevorInput,
            'long_description'             => $HTMLContent
        );
        $this->db->where("id", $id);
        $this->db->update('esic');
    }
    function UpdatePageDescription($id,$actionToPerform = '') {
        // use to add 'page data into database
        $sirTrevorInput = $this->input->post('desc-content');
        $sirTrevorInput =  str_replace("<p><br></p>"," ",$sirTrevorInput);
        if ($sirTrevorInput != ""){
        $converter = new Converter();
            $HTMLContent = $converter->toHtml($sirTrevorInput);
        } else {
          $HTMLContent = "";
        }
        //Update in User Table the Buisness Description where User ID is ------
        $contentdata = array(
            'businessShortDescriptionJSON' => $sirTrevorInput,
            'long_description'             => $HTMLContent
        );
        if($actionToPerform != '' && !isCurrentUserAdmin($this)){
            $row = $this->db->from($this->tableName)->select('version')->where("id", $id)->get()->row();
            $newVer = $row->version + 1;
            $whereVer = array(
                $this->listingField => $id,
                'version'           => $newVer
            );
            $row = $this->db->from($this->versionTable)->select('count(id) as Total, id')->where($whereVer)->get()->row();
            if($row->Total == 1){
                $this->db->where("id", $row->id);
                $this->db->update($this->versionTable, $contentdata);
            }
            else {
                $result = $this->db->get_where($this->tableName, ['id'=>$id])->row();
                $listingField = $this->listingField;
                $result->$listingField = $result->id;
                unset($result->id);
                unset($result->is_new_ver);
                $result->businessShortDescriptionJSON = $contentdata['businessShortDescriptionJSON'];
                $result->long_description = $contentdata['long_description'];
                $result->version = $newVer;
                $this->db->insert($this->versionTable, $result);

                // set new version
                $this->db->where("id", $id);
                $this->db->update($this->tableName, ['is_new_ver'=>'Yes']);
            }
        }else{
            $this->db->where("id", $id);
            $this->db->update($this->tableName, $contentdata);
        }
    }
    function ChangeHtmlToJson($id,$table,$descHtml){
        if (!empty($descHtml)){
            $converter = new Converter();
            $Json = $converter->toJson($descHtml);
        }else{
            return false;
        }
        $contentdata = array(
            'businessShortDescriptionJSON' => $Json
        );
        $this->db->where("id", $id);
        $this->db->update($table, $contentdata);
        return $id.'Changed ';
    }
    function ChangeJsonToHtml($id,$table,$descJson) {
        if (!empty($descJson)){
            $converter = new Converter();
            $html = $converter->toHtml($descJson);
        }else{
            return false;
        }
        $contentdata = array(
            'long_description' => $html
        );
        $this->db->where("id", $id);
        $this->db->update($table, $contentdata);
    }
    function ShowEsicPageDescription() {
        // use to add 'page data into database
        $sirTrevorInput = $this->input->post('desc-content');
        if ($sirTrevorInput != ""){
        $converter = new Converter();
            $HTMLContent = $converter->toHtml($sirTrevorInput);
        } else {
          $HTMLContent = "";
        }
        //Update in User Table the Buisness Description where User ID is ------
        $contentdata = array(
            'businessShortDescriptionJSON' => $sirTrevorInput,
            'long_description'             => $HTMLContent
        );
        return $contentdata;
    }
    function ShowPageDescriptionPreview() {
        $this->load->library('Sioen');
        // use to add 'page data into database
        $sirTrevorInput = $this->input->post('desc-content');

        if($sirTrevorInput != ""){
        $converter = new Converter();
            $HTMLContent = $converter->toHtml($sirTrevorInput);
        }else{
          $HTMLContent = "";
        }
        //Update in User Table the Buisness Description where User ID is ------
        $contentdata = array(
            'businessShortDescriptionJSON' => $sirTrevorInput,
            'long_description'             => $HTMLContent
        );
        return $contentdata;
    }
	 function updateJumbotron($id) {
        // Update the jumbotron
		if ($this->input->post('jumbotron') != ""){
        $sirTrevorInput = $this->input->post('jumbotron');
        $converter = new Converter();
        $HTMLContent = $converter->toHtml($sirTrevorInput);} else {
		$HTMLContent = "";	
		}
		$data = array(
		'enableJumbotron' => $this->input->post('enableJumbotron'),
		'enableSlider' => $this->input->post('enableSlider'),
       	);			
		
        $this->db->where("pageID", $id);
        $this->db->update('hoosk_page_attributes', $data);
        $contentdata = array(
			'jumbotron' => $this->input->post('jumbotron'),
			'jumbotronHTML' => $HTMLContent,
        );
        $this->db->where("pageID", $id);
        $this->db->update('hoosk_page_content', $contentdata);
	  	// Clear the sliders
		$this->db->delete('hoosk_banner', array('pageID' => $id));
		$sliders = explode('{', $this->input->post('pics'));
		
		for($i=1;$i<count($sliders);$i++)
		{
			$div = explode('|', $sliders[$i]);
			
			$slidedata = array(
				'pageID' => $id,
				'slideImage' => $div[0],
				'slideLink' => $div[1],
				'slideAlt' => substr($div[2],0,-1),
				'slideOrder' => $i-1,
			);
			
			$this->db->insert('hoosk_banner', $slidedata);
		}
    }
	
    /*     * *************************** */
    /*     * ** Navigation Querys ****** */
    /*     * *************************** */
	function countNavigation(){
        return $this->db->count_all('hoosk_navigation');
    }
    function countSliders(){
        return $this->db->count_all('esic_slider');
    }
    function getAllNav($limit, $offset=0) {
        // Get a list of all pages
        $this->db->select("*");
		$this->db->limit($limit, $offset);
        $query = $this->db->get('hoosk_navigation');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
    function getAllSliders($limit, $offset=0) {
        // Get a list of all pages
        $this->db->select("*");
		$this->db->limit($limit, $offset);
        $query = $this->db->get('esic_slider');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
	
    function getNav($id) {
        // Get a list of all pages
        $this->db->select("*");
		$this->db->where("navSlug", $id);
        $query = $this->db->get('hoosk_navigation');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }	
    //Get page details for building nav
    function getPageNav($url) {
        // Get the page details
        $this->db->select("*");
        $this->db->where("hoosk_page_attributes.pageURL", $url);
        $this->db->join('hoosk_page_content', 'hoosk_page_content.pageID = hoosk_page_attributes.pageID');
        $this->db->join('hoosk_page_meta', 'hoosk_page_meta.pageID = hoosk_page_attributes.pageID');
        $query = $this->db->get('hoosk_page_attributes');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
	
	function insertNav() {
	  
	    $navigationHTML = $this->input->post('convertedNav');
        $navigationHTML = str_replace("<ul></ul>", "", $navigationHTML);
		  $navigationEdit = $this->input->post('seriaNav');
		$navigationEdit = str_replace('<button data-action="collapse" type="button">Collapse</button><button style="display: none;" data-action="expand" type="button">Expand</button>', "", $navigationEdit);
        //$navigationEdit = 'esic_directory/'.$navigationEdit;
        $data = array(
            'navSlug'  => $this->input->post('navSlug'),
            'navTitle' => $this->input->post('navTitle'),
            'navEdit'  => $navigationEdit,
            'navHTML'  => $navigationHTML,
        );
        $this->db->insert('hoosk_navigation', $data); 
	}
	
	function updateNav($id) {
	     $navigationHTML = $this->input->post('convertedNav');
         $navigationHTML = str_replace("<ul></ul>", "", $navigationHTML);
         $navigationEdit = $this->input->post('seriaNav');
         $navigationEdit = str_replace('<button data-action="collapse" type="button">Collapse</button><button style="display: none;" data-action="expand" type="button">Expand</button>', "", $navigationEdit);
         $data = array(
            'navTitle' => $this->input->post('navTitle'),
            'navEdit' => $navigationEdit,
            'navHTML' => $navigationHTML,
        );
		$this->db->where("navSlug", $id);
        $this->db->update('hoosk_navigation', $data);
		}
	
	function removeNav($id) {
        // Delete a nav
        $this->db->delete('hoosk_navigation', array('navSlug' => $id));
    }
	
	
	
	function getSettings() {
        // Get the settings
        $this->db->select("*");
        $this->db->where("siteID", 0);
        $query = $this->db->get('hoosk_settings');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
	
	
	function updateSettings() {
		$data = array(
			//'siteTheme' => $this->input->post('siteTheme'),
			'siteLang' => $this->input->post('siteLang'),
			'siteEmail' => $this->input->post('siteEmail'),
			
			'siteFooter' => $this->input->post('siteFooter'),
			
			'contact' => $this->input->post('contact'),
			
			'footer_text' => $this->input->post('footer_text'),
			'footer_bottom_text' => $this->input->post('footer_bottom_text')
			
			
		);
		
		if ($this->input->post('siteTitle') != "")
				 $data['siteTitle'] = $this->input->post('siteTitle');
	
			if ($this->input->post('siteLogo') != ""){
				$data['siteLogo'] = $this->input->post('siteLogo');
			}	
			$this->db->where("siteID", 0);
			$this->db->update('hoosk_settings', $data);
	}
	
	
	/*     * *************************** */
    /*     * ** Post Querys ************ */
    /*     * *************************** */
	
		function countPosts(){
			return $this->db->count_all('hoosk_post');
		}    
		function getPosts($limit, $offset=0) { 	
        // Get a list of all posts
        $this->db->select("*");
        $this->db->join('hoosk_post_category', 'hoosk_post_category.categoryID = hoosk_post.categoryID');
		$this->db->order_by("unixStamp", "desc");
		$this->db->limit($limit, $offset);
        $query = $this->db->get('hoosk_post');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
    function createPost() {
        // Create the post
		if ($this->input->post('content') != ""){
        $sirTrevorInput = $this->input->post('content');
        $converter = new Converter();
        $HTMLContent = $converter->toHtml($sirTrevorInput);} else {
		$HTMLContent = "";	
		}
        $data = array(
		    'postTitle' => $this->input->post('postTitle'),
			'categoryID' => $this->input->post('categoryID'),
            'postURL' => $this->input->post('postURL'),
			'postContent' => $this->input->post('content'),
            'postContentHTML' => $HTMLContent,
			'postExcerpt' => $this->input->post('postExcerpt'),
			'datePosted' => $this->input->post('datePosted'),
			'unixStamp' => $this->input->post('unixStamp'),
        );
		if ($this->input->post('postImage') != ""){
				$data['postImage'] = $this->input->post('postImage');
		}	
        $this->db->insert('hoosk_post', $data);
    }
    function getPost($id) {
        // Get the post details
        $this->db->select("*");
        $this->db->where("postID", $id);
        $this->db->join('hoosk_post_category', 'hoosk_post_category.categoryID = hoosk_post.categoryID');
        $query = $this->db->get('hoosk_post');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
    function removePost($id) {
        // Delete a post
        $this->db->delete('hoosk_post', array('postID' => $id));
    }
    function updatePost($id) {
        // Update the post
       	if ($this->input->post('content') != ""){
        $sirTrevorInput = $this->input->post('content');
        $converter = new Converter();
        $HTMLContent = $converter->toHtml($sirTrevorInput);} else {
		$HTMLContent = "";	
		}
	 	$data = array(
		    'postTitle' => $this->input->post('postTitle'),
			'categoryID' => $this->input->post('categoryID'),
            'postURL' => $this->input->post('postURL'),
			'postContent' => $this->input->post('content'),
            'postContentHTML' => $HTMLContent,
			'postExcerpt' => $this->input->post('postExcerpt'),
			'datePosted' => $this->input->post('datePosted'),
			'unixStamp' => $this->input->post('unixStamp'),
        );
		if ($this->input->post('postImage') != ""){
				$data['postImage'] = $this->input->post('postImage');
		}	
		$this->db->where("postID", $id);
        $this->db->update('hoosk_post', $data);
    }
	
	
	/*     * *************************** */
    /*     * ** Category Querys ******** */
    /*     * *************************** */
		function countCategories(){
        return $this->db->count_all('hoosk_post_category');
   		 }
	    function getCategories() {
        // Get a list of all categories
        $this->db->select("*");
        $query = $this->db->get('hoosk_post_category');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
	
		
		 function getCategoriesAll($limit, $offset=0) {
        // Get a list of all categories
        $this->db->select("*");
		$this->db->limit($limit, $offset);
        $query = $this->db->get('hoosk_post_category');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
	function createCategory() {
        // Create the category
        $data = array(
		    'categoryTitle' => $this->input->post('categoryTitle'),
			'categorySlug' => $this->input->post('categorySlug'),
            'categoryDescription' => $this->input->post('categoryDescription')
        );
        $this->db->insert('hoosk_post_category', $data);
    }
    function getCategory($id) {
        // Get the category details
        $this->db->select("*");
        $this->db->where("categoryID", $id);
        $query = $this->db->get('hoosk_post_category');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
    function removeCategory($id) {
        // Delete a category
        $this->db->delete('hoosk_post_category', array('categoryID' => $id));
    }
    function updateCategory($id) {
        // Update the category
	 	$data = array(
		    'categoryTitle' => $this->input->post('categoryTitle'),
			'categorySlug' => $this->input->post('categorySlug'),
            'categoryDescription' => $this->input->post('categoryDescription')
        );
		$this->db->where("categoryID", $id);
        $this->db->update('hoosk_post_category', $data);
    }
	
	/*     * *************************** */
    /*     * ** Social Querys ********** */
    /*     * *************************** */
	function getSocial(){
		$this->db->select("*");
        $query = $this->db->get('hoosk_social');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
	}
    function getSocial_creaditional(){
        $this->db->select("*");
        $query = $this->db->get('hoosk_social_setting');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
	
	
	function updateSocial() {
		$this->db->select("*");
        $query = $this->db->get("hoosk_social");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
				$data = array();
				$data['socialLink'] = $this->input->post($rows->socialName);
				if (isset($_POST['checkbox'.$rows->socialName])){
					$data['socialEnabled'] = $this->input->post('checkbox'.$rows->socialName);
				} else {
					$data['socialEnabled'] = 0;
				}
				$this->db->where("socialName", $rows->socialName);
        		$this->db->update('hoosk_social', $data);
			}
		}
	}
	public function social_creaditional($fb_id,$fb_sec){
	    $this->db->where('pk_id',1);
        $data = array(
            'api_id'  =>$fb_id,
            'api_key' =>$fb_sec
           );
        $ok = $this->db->update('hoosk_social_setting',$data);
        return;
    }
    public function SaveTemplateForListing($ci, $id,$templateID){
        $this->db->where('id',$id);
        $data = array(
            'template'  =>$templateID
        );
        $this->db->update($ci->tableName,$data);
    }
    
    public function duplicateTable($tableName, $new_name){
        $this->dbforge->rename_table($tableName, $new_name);
        $this->db->query("CREATE TABLE ".$tableName." LIKE ".$new_name);
    }

   /* // get union of all listings
    public function getAllListings($offset, $limit, $searchText, $searchType, $listType=null){
        if($searchType == 'list_type' && $searchText != '')
            $tables = [$searchText];
        else if($listType != null) {
            $tables = [$listType];
        }
        else{
            $tables = ['esic_investors','esic_accelerators','esic_grantconsultant','esic_lawyers','esic_rndconsultant','esic_rndpartner'];
        }
        $union = '';
        foreach($tables as $tbl){
            if(!empty($union)) $union .= ') UNION ALL (';
            else $union .= '(';
            $this->db->select("id as ID, name as Name, website as Website, '$tbl' ");
            $this->db->from($tbl);
            if($searchType == 'name')
                $this->db->like('name', $searchText);
            if(empty($searchText) && empty($listType))
                $this->db->limit($limit,$offset);
            $union .= $this->db->get_compiled_select();
        }
        $union .= ')';
        $query = $this->db->query($union);
        return $query->result();
    }*/
    public function getAllListings(){
        $tables = ['esic_investors','esic_accelerators','esic_grantconsultant','esic_lawyers','esic_rndconsultant','esic_rndpartner','esic_taxadvisors'];
        $union = '';
        foreach($tables as $tbl){
            if(!empty($union)) $union .= ' UNION ';
            $this->db->select("id as ID, name as Name, website as Website, '$tbl'");
            $this->db->from($tbl);
            $union .= $this->db->get_compiled_select();
        }
        $query = $this->db->query($union);
        return $query->result();
    }
    public function countAllListings(){
        $tables = ['esic_investors','esic_accelerators','esic_grantconsultant','esic_lawyers','esic_rndconsultant','esic_rndpartner','esic_taxadvisors'];
        $union = '';
        foreach($tables as $tbl){
            if(!empty($union)) $union .= ' UNION ALL ';
            else $union .= 'SELECT count(id) as ids FROM (';
            $this->db->select("id");
            $this->db->from($tbl);
            $union .= $this->db->get_compiled_select();
        }
        $union .= ') AS total';
        $query = $this->db->query($union);
        return $query->result();
    }
}
?>
