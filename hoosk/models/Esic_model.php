<?php
class Esic_model extends MY_Model{
    private $tableCurrent   = 'esic';
    function __construct(){
        parent::__construct();
        $this->load->library('Datatables');
        
    }
    private function UserIDWhere(){
        $where = $this->getUserWhere();
        $this->db->where($where);
    }
    public function count(){
        $where = $this->getUserWhere();
        return $this->Common_model->count_rows($this->tableCurrent,$where);
    }
    public function getEsicByStatus($status=NULL){
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
    public function record_count(){
        return $this->db->count_all("esic");
    }
    public function getlist($page){
        $offset = 9*$page;
        $pagelimit = 9;
        $total_results = $this->db->count_all("esic");
        if($offset < $total_results){
	        $limit = array();
	         array_push($limit, $pagelimit);
	                array_push($limit,$offset);
	       
	        //Lets make a simple query for Listing.
	        $selectData = array('
	                esic.id as userID,
	                concat(HS.firstName, " ", HS.lastName) as FullName,
	                HS.email as Email,
	                name as Company,
	                business as Business,
	                long_description as BusinessShortDesc,
                    short_description as tinyDescription,
	                score as Score,
	                logo as Logo,
	                website as Web,
                    thumbsUp as thumbsUp,
	                expiry_date as expiry_date,
	                corporate_date as corporate_date,
	                added_date as added_date,
				    CASE WHEN esic.status >0 THEN CONCAT("<span class=\'label\' style=\' background-color:",ES.color,"\'>",ES.status,"</span>")ELSE CONCAT("<span class=\"featured-yellow\">",ES.status,"</span>") END as Status',false);
            $where = "Publish = 1 ";
			$orderBy = array('esic.id','DESC');
	        $joins = array(
                array(
                    'table' => 'hoosk_user HS',
                    'condition' => 'HS.userID = esic.id',
                    'type' => 'LEFT'
                ),
	            array(
	                'table' => 'esic_status ES',
	                'condition' => 'ES.id = esic.status',
	                'type' => 'LEFT'
	            )
	        );
	        $usersResult = $this->Common_model->select_fields_where_like_join('esic',$selectData,$joins,$where,FALSE,'','','',$orderBy,$limit,true);
	     return $usersResult;
		}else{
			 return "NORESULT";
		}
		return "NORESULT";
    }
    public function getfilterlist($page,$search,$secSelect,$comSelect,$OrderSelect,$OrderSelectValue){
        $offset = 9*$page;
        $pagelimit = 9;
        
        $total_results = $this->db->count_all("esic");
        if($offset < $total_results){
	        $limit = array();
	         array_push($limit, $pagelimit);
	                array_push($limit,$offset);
	       
	        //Lets make a simple query for Listing.
	        $selectData = array('
	                esic.id as userID,
	                concat(HS.firstName, " ", HS.lastName) as FullName,
	                HS.email as Email,
	                name as Company,
	                business as Business,
	                long_description as BusinessShortDesc,
                    short_description as tinyDescription,
	                score as Score,
	                logo as Logo,
	                website as Web,
                    thumbsUp as thumbsUp,
	                expiry_date as expiry_date,
	                corporate_date as corporate_date,
	                added_date as added_date,
	                CASE WHEN esic.status = 1 THEN CONCAT("<span class=\"featured-red\">",ES.status,"</span>") WHEN esic.status = 2 THEN CONCAT("<span class=\"featured-yellow\">",ES.status,"</span>") WHEN esic.status = 3 THEN CONCAT("<span class=\"featured-green\">",ES.status,"</span>") ELSE CONCAT("<span class=\"featured-yellow\">",ES.status,"</span>") END as Status
	                ',
	            false
	        );
            $where = "Publish = 1 ";
            if(!empty($secSelect)){
                $where .= " AND esic.sectorID =".$secSelect;
            }
            if(!empty($comSelect)){
                /*if(!empty($where)){
                    $where .=" AND ";
                }*/
                $where .= " AND esic.status =".$comSelect;
               // $where .= " AND esic.company =".$comSelect;
            }
			if(!empty($OrderSelect) && $OrderSelect =='added_date'){
				$where .= " AND esic.address_post_code = '".$OrderSelectValue."'";
			}
            if(!empty($search)){
			     $where .= " AND ( HS.firstName LIKE '%".$search."%'
				        OR HS.lastName LIKE '%".$search."%'
				        OR esic.name LIKE '%".$search."%'
                        OR esic.website LIKE '%".$search."%'
				        OR esic.business LIKE '%".$search."%' )";
			}
			$orderBy='';
			if(!empty($OrderSelect) && $OrderSelect!='added_date'){
				$orderBy = array(
		             $OrderSelect,$OrderSelectValue
		        );
			}
	        $joins = array(
	            array(
	                'table' => 'hoosk_user HS',
	                'condition' => 'HS.userID = esic.id',
	                'type' => 'LEFT'
	            ),
                array(
                    'table' => 'esic_status ES',
                    'condition' => 'ES.id = esic.status',
                    'type' => 'LEFT'
                )
	        );
	        $usersResult = $this->Common_model->select_fields_where_like_join('esic',$selectData,$joins,$where,FALSE,'','','',$orderBy,$limit,true);
	        return $usersResult;
		}else{
			 return "NORESULT";
		}
		return "NORESULT";
    }
    public function getDetails($alias){
            $selectData = array('
                    esic.id as listingID,
                    esic.userID as userID,
                    concat(HS.firstName, " ", HS.lastName) as FullName,
                    esic.email as Email,
                    esic.name as Company,
                    esic.address as address,
                    esic.address_street_name as StreetName,
                    esic.address_street_number as StreetNumber,
                    esic.address_post_code as PostCode,
                    esic.address_town as town,
                    esic.address_state as state,
                    esic.business as Business,
                    esic.long_description as BusinessShortDesc,
                    esic.short_description as tinyDescription,
                    esic.score as Score,
                    esic.logo as Logo,
                    esic.corporate_date as corporate_date,
                    esic.added_date as added_date,
                    esic.expiry_date as expiry_date,
                    esic.showExpDate as ShowExpDate,
                    esic.acn_number as acn_number,                    
                    esic.banner as bannerImage,
                    esic.productImage as productImage,
                    esic.website as Web,
                    esic.thumbsUp as thumbsUp,
                    ERnD.rndname as rndname,
                    ERnD.IDNumber as IDNumber,
                    ERnD.AddressContact as AddressContact,
                    ERnD.ANZSRC as ANZSRC,
                    ERnD.rndLogo as rndLogo,
                    ERnD.AppStatus as RndAppStatus,
                    EAccCo.Member as Member,
                    EAccCo.AppStatus as EAccCoAppStatus,
                    EAccCo.logo as AccCoLogo,
                    EAcc.name as Accname,
                    EAcc.logo as logo,
                    EAcc.website as AccWeb,
                    EAcc.AppStatus as EAccAppStatus,
                    EIn.institution as institution,
                    EIn.logo as logo,
                    EIn.AppStatus as EInAppStatus,
                    ESec.sector as sectorName,
                    ESec.secLogo as secLogo,
                    ESec.AppStatus as ESecAppStatus,
                    CASE WHEN esic.status = 1 THEN CONCAT("<span class=\"featured-red\">",ES.status,"</span>") WHEN esic.status = 2 THEN CONCAT("<span class=\"featured-yellow\">",ES.status,"</span>") WHEN esic.status = 3 THEN CONCAT("<span class=\"featured-green\">",ES.status,"</span>") ELSE CONCAT("<span class=\"featured-yellow\">",ES.status,"</span>") END as Status
                    ',
                false
            );
            $where = "esic.name ='".$alias."' AND Publish = 1";
            $joins = array(
                array(
                    'table' => 'hoosk_user HS',
                    'condition' => 'HS.userID = esic.id',
                    'type' => 'LEFT'
                ),
                array(
                    'table' => 'esic_status ES',
                    'condition' => 'ES.id = esic.status',
                    'type' => 'LEFT'
                ),
                array(
                    'table' => 'esic_rnd ERnD',
                    'condition' => 'ERnD.id = esic.RnDID AND ERnD.trashed != 1',
                    'type' => 'LEFT'
                ),
                array(
                    'table' => 'esic_acceleration EAccCo',
                    'condition' => 'EAccCo.id = esic.AccCoID AND EAccCo.trashed != 1',
                    'type' => 'LEFT'
                ),
                array(
                    'table' => 'esic_accelerators EAcc',
                    'condition' => 'EAcc.id = esic.AccID AND EAcc.trashed != 1',
                    'type' => 'LEFT'
                ),
                array(
                    'table' => 'esic_institution EIn',
                    'condition' => 'EIn.id = esic.inID AND EIn.trashed != 1',
                    'type' => 'LEFT'
                ),
                array(
                    'table' => 'esic_sectors ESec',
                    'condition' => 'ESec.id = esic.sectorID',
                    'type' => 'LEFT'
                )
            );
            $usersResult = $this->Common_model->select_fields_where_like_join('esic',$selectData,$joins,$where,true,'','','','','',true);
			return $usersResult;
    }
    public function getSocialDetail($ListingID){
            $this->db->where('listingID',$ListingID);
            $this->db->from('esic_social');
            $query = $this->db->get();
            return $query->result();
    }
    public function updatethumbs($userID,$thumbs,$newThumbs){
            if(!isset($userID) || empty($userID)){
                echo "FAIL::Something went wrong with the post, Please Contact System Administrator for Further Assistance";
                return;
            }
            //UpdateData
            $updateArray = array();
            $updateArray['thumbsUp'] = $thumbs+1;
            $whereUpdate = array(
                'id' => $userID
            );
            $this->Common_model->update('esic',$whereUpdate,$updateArray);
            echo 'OK::'.$thumbs.'::'.$newThumbs;
    }
    public function get_user_details($alias){	   // use to get socail link for front end 
            $this->db->where('name',$alias);
            $this->db->from('esic_social');
            $query = $this->db->get();
    		return $query->result_array();
    }
    public function  get_user_Social($id=NULL){  // use to get socail link for backend
    	    $this->db->where('userID',$id);
            $this->db->from('esic_social');
            $query = $this->db->get();
    		return $query->result();
    }
    public function update_social($id=NULL,$data=NULL,$data2=NULL){
		$this->db->where('userID',$id);
		$this->db->from('esic_social');
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		  $this->db->where('userID',$id);
          $this->db->update('esic_social',$data);
		  return "ok";
        }else{
		 $this->db->insert('esic_social',$data2);
		  return "ok";
        }
	}	 
    public function get_site_data(){
        $this->db->where('pagePublished',1);
        $query = $this->db->get('hoosk_page_attributes');
            if ($query->num_rows() > 0){
              return $query->result_array();
            }else{
                return false;
            }
    }
    function select_esic_url($tbl = '', $array=false)
    {
        $this->db->where('Publish',1);
        $query = $this->db->get($tbl);

        if($array===true){
            return $query->result_array();
        }
        return $query->result();
    }   
    function get_sessions()    {
      //  $this->db->limit(1000);
        $this->db->order_by("created", "DESC");
        $query = $this->db->get('hoosk_sessions');
        return $query->result_array();
    }
    function count_sessions(){

        $query = $this->db->get('hoosk_sessions');
        return $query->num_rows();
    }
    public function get_invester_url(){
       $query = $this->db->get('esic_investors');
        if ($query->num_rows() > 0){
          return $query->result_array();
        }else{
            return false;
        }
    }
public function get_lawyer_url(){
              $this->db->where('Publish',1);
       $query = $this->db->get('esic_lawyers');
        if ($query->num_rows() > 0){
          return $query->result_array();
        }else{
            return false;
        }
    }
public function get_RndConsultant_url(){
                $this->db->where('Publish',1);
       $query = $this->db->get('esic_rndconsultant');
        if ($query->num_rows() > 0){
          return $query->result_array();
        }else{
            return false;
        }
    }
public function get_GrantConsultant_url(){
                $this->db->where('Publish',1);
       $query = $this->db->get('esic_grantconsultant');
        if ($query->num_rows() > 0){
          return $query->result_array();
        }else{
            return false;
        }
    }
public function get_Accelerator_url(){
                $this->db->where('Publish',1);
       $query = $this->db->get('esic_accelerators');
        if ($query->num_rows() > 0){
          return $query->result_array();
        }else{
            return false;
        }
    }
public function get_blog_url(){
        $this->db->where('status',1);
        $this->db->select('slug,date');
        $query = $this->db->get('esic_blog');
        if ($query->num_rows() > 0){
          return $query->result_array();
        }else{
            return false;
        }
    }    
}
