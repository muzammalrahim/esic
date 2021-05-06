<?php 
	function viewHelperManage($param=NULL){
		$ci =& get_instance();
        if(checkRoleHasPermission($ci,$ci->Name.' Admin Listing') == true){
            $ci->load->model('Common_model');
    	    
            //Now see if the param is of listing
            if($param === 'listing'){
                $where = array('');
                if(!isCurrentUserAdmin($ci)){
                    $userID = getCurrentUserID($ci);
                    $where = array($ci->tableName.'.userID' => $userID);
                    $Actions = '';
                    $isAdmin = 'no';
                }else{
                    $isAdmin = 'yes';
                    $Actions = '<a href="#" data-target=".publish-modal" data-toggle="modal"><i data-toggle="tooltip" title="Publish Status" data-placement="right"  class="fa fa-check text-blue"></i></a> &nbsp;';
                }
                $selectData = array('
                '.$ci->tableName.'.id AS ID,
                '.$ci->tableName.'.name AS Name,
                '.$ci->tableName.'.is_new_ver AS New_Ver,
                '.$ci->tableName.'.phone AS Phone,
                '.$ci->tableName.'.website AS Website,
                '.$ci->tableName.'.email AS Email,
                '.$ci->tableName.'.logo AS Logo,
                '.$ci->tableName.'.investor_type_id AS Type_ID,
                vr.slug AS slug,
                vr.id AS Ver_Id, 
                vr.'.$ci->listingField.' AS list_Id,
                vr.not_approve AS Cancel,
                vr.name AS vr_Name, 
                vr.phone AS vr_Phone, 
                vr.email AS vr_Email, 
                vr.logo AS vr_Logo,
                vr.website AS vr_Website, 
                IT.label AS Type_Label,
                IT.name AS Type_Name,
                 '.$ci->tableName.'.Publish as PublishStatusID,
                CASE WHEN '.$ci->tableName.'.trashed = 1 THEN CONCAT(\'<span class="label label-danger" data-target=".approval-modal" data-toggle="modal">YES</span>\') WHEN '.$ci->tableName.'.trashed = 0 THEN CONCAT(\'<span class="label label-success" data-target=".approval-modal" data-toggle="modal">NO</span>\') ELSE "" END AS Trashed
                ',false);
                if( $isAdmin == 'yes' ){
                     $selectData[0] .= ' , CASE WHEN '.$ci->tableName.'.Publish = 1 THEN CONCAT(\'<span class="label label-success" data-target=".publish-modal" data-toggle="modal">YES</span>\') WHEN '.$ci->tableName.'.Publish = 0 THEN CONCAT(\'<span class="label label-danger" data-target=".publish-modal" data-toggle="modal">NO</span>\') ELSE "" END AS Publish';
                }else{
                    $selectData[0] .= ' , CASE WHEN '.$ci->tableName.'.Publish = 1 THEN CONCAT(\'<span class="label label-success">YES</span>\') WHEN '.$ci->tableName.'.Publish = 0 THEN CONCAT(\'<span class="label label-danger">NO</span>\') ELSE "" END AS Publish';
                }
                $addColumns = array(
                    'isAdmin' => $isAdmin,
                    'ViewEditActionButtons' => array($Actions.
                        '<a href="'.base_url().$ci->Name.'/Edit/$1"><span data-toggle="tooltip" title="Edit" data-placement="left" aria-hidden="true" class="fa fa-pencil text-blue"></span></a> &nbsp; <a href="#" data-target=".approval-modal" data-toggle="modal"><i data-toggle="tooltip" title="Trash" data-placement="right"  class="fa fa-trash-o text-red"></i></a>','ID')
                );
                $joins = array(
                    array(
                        'table' => 'investor_types IT',
                        'condition' => 'IT.id = '.$ci->tableName.'.investor_type_id',
                        'type' => 'LEFT'
                    ),
                    array(
                        'table'=> $ci->versionTable.' vr',
                        'condition'=>'vr.'.$ci->listingField.' ='.$ci->tableName.'.id AND vr.version > '.$ci->tableName.'.version',
                        'type'=> 'LEFT'
                    )
                );
                $returnedData = $ci->Common_model->select_fields_joined_DT($selectData,$ci->tableName,$joins,$where,'','','',$addColumns);
                
                printListingResult($returnedData);
                return null;
            }   
        }
        if(loadDefautParamActions($ci,$param) == true){
            if(isset($ci->pageMessage) && !empty($ci->pageMessage)){
                $ci->data['message'] = $ci->pageMessage;
            }
            $ci->show_admin_listing('listing/'.$ci->ViewFolderName.'/backend/listing',$ci->data);
        }
	}

    function ViewHelperNewSave(){
        $ci =& get_instance();
        if(checkRoleHasPermission($ci,$ci->Name.' New') != true){
            if(assignAllRolesToUser($ci) != true){
                return false;
            }
        }
        $ci->load->model('Common_model');
    
            $return = array();
            if(!$ci->input->post()){
                $error = "FAIL::No Value Posted::error";
                array_push($return, $error);
                return $return;
            }


            $name = $ci->input->post('name');
            $slug = getAlias($name);
            $slug = checkAndChangeIfAlreadyExistSlug($ci,$slug);
            $phone   = $ci->input->post('phone');
            $email   = $ci->input->post('email');
            $website = $ci->input->post('website');

            $company_name   = $ci->input->post('company_name');
            $company_email  = $ci->input->post('company_email');

            $address_street_number   = $ci->input->post('address_street_number');
            $address_street_name     = $ci->input->post('address_street_name');
            $address_town            = $ci->input->post('address_town');
            $address_state           = $ci->input->post('address_state');
            $address_post_code       = $ci->input->post('address_post_code');
            $ranking_score           = $ci->input->post('ranking_score');

            $about            = $ci->input->post('about');
            $investor_type_id = $ci->input->post('investor_type_id');
            $preferred_investment_amount      = $ci->input->post('preferred_investment_amount');
            $preferred_investment_industires  = json_encode($ci->input->post('preferred_investment_industires'));
            $preferred_esic_status_ids        = json_encode($ci->input->post('preferred_esic_status_ids'));

            $TemplateID         = $ci->input->post('template');

            if(empty($name)){
                $error = "FAIL::".$ci->NameMessage." Name is a required field::error::Required!!";
                array_push($return, $error);
                return $return;
            }
            /*$NameExist = checkListingExist($ci, $name, 'name');
            if($NameExist == true){
                $error =  "FAIL::".$ci->NameMessage." Name Already Exist Cannot Create New Please Contact Administrator::error";
                array_push($return, $error);
                return $return;
            }
            $EmailExist = checkListingExist($ci, $email, 'email');
            if($EmailExist == true){
                $error =  "FAIL::".$ci->NameMessage." Email Already Exist Cannot Create New Please Contact Administrator::error";
                array_push($return, $error);
                return $return;
            }*/


        /*new code 10/17/2018 */

        if(!isCurrentUserAdmin($ci)){ // if not admin
            $userID = getCurrentUserID($ci);
            $Publish  = 0 ;
        }else{                         // when listing added by admin
            $where = array('email' => $email);
            $check_user_email = $ci->Common_model->select_fields_where('hoosk_user','userID,email',$where,true);
            if($check_user_email){
                $userID = $check_user_email->userID;
            }else{
                $insert_hoosk_user = array(
                    'email'     => $email,
                    'userRole'  => json_encode(array("3")),
                    'userName'  => $name,
                );
                $insertResult = $ci->Common_model->insert_record('hoosk_user',$insert_hoosk_user);
                $userID  = $insertResult;
            }
            $Publish  = 1 ;
        }
        /* end */


            $now = date("Y-m-d H:i:s");
            $insertData = array(
                'userID'                => $userID,
                'name'                  => $name,
                'slug'                  => $slug,
                'phone'                 => $phone,
                'email'                 => $email,
                'website'               => $website,
                'company_name'          => $company_name,
                'company_email'         => $company_email,
                'address_street_number' => $address_street_number,
                'address_street_name'   => $address_street_name,
                'address_town'          => $address_town,
                'address_state'         => $address_state,
                'address_post_code'     => $address_post_code,
                'template'              => $TemplateID,
                'date_created'          => $now,
                'date_updated'          => $now,
                'Publish'               => $Publish,
                'ranking_score'         => $ranking_score
            );
            if(!empty($preferred_investment_amount)){
                $insertData['preferred_investment_amount'] = $preferred_investment_amount;
            }
            if(!empty($preferred_investment_industires)){
                $insertData['preferred_investment_industires'] = $preferred_investment_industires;
            }
            if(!empty($preferred_esic_status_ids)){
                $insertData['preferred_esic_status_ids'] = $preferred_esic_status_ids;
            }
            if(!empty($investor_type_id)){
                $insertData['investor_type_id'] = $investor_type_id;
            }
            if(!empty($about)){
                $insertData['about'] = $about;
            }
            $insertResult = $ci->Common_model->insert_record($ci->tableName,$insertData);

            if($insertResult){
                $success =  "OK::Record Successfully Added ID is ".$insertResult." ::success::".$insertResult;
                array_push($return, $success);
            }else{
                $error =  "FAIL::Record Not Added::error";
                array_push($return, $error);
                return $return;
            }

            $notes = uploadImagesAction($ci,$insertResult);
            if(is_array($notes) && !empty($notes)){
                foreach ($notes as $key => $note){
                    array_push($return, $note);
                }
            }
            $notes = saveSocialLinks($ci,$insertResult,'New');
            if(is_array($notes) && !empty($notes)){
                foreach ($notes as $key => $note){
                    array_push($return, $note);
                }
             }
            return $return;
    }
    function ViewHelperEditSave(){
        $ci =& get_instance();
        if(checkRoleHasPermission($ci,$ci->Name.' Edit') == true){
            $ci->load->model('Common_model');
            $return = array();
            if(!$ci->input->post()){
                $error = "FAIL::No Value Posted::error";
                array_push($return, $error);
                return $return;
            }
            $ID = $ci->input->post('id');
            if(empty($ID)){
                $error = "FAIL::No ID Set::error";
                array_push($return, $error);
                return $return;
            }

            $name    = $ci->input->post('name');
            $slug    = getAlias($name);
            if(checkSameSlugIsExistForListingID($ci,$slug,$ID) == true){
                $slug = $slug;
            }else{
                $slug    = checkAndChangeIfAlreadyExistSlug($ci,$slug);
            }
            $phone   = $ci->input->post('phone');
            $email   = $ci->input->post('email');
            $website = $ci->input->post('website');
            $company_name   = $ci->input->post('company_name');
            $company_email  = $ci->input->post('company_email');
            $address_street_number   = $ci->input->post('address_street_number');
            $address_street_name     = $ci->input->post('address_street_name');
            $address_town            = $ci->input->post('address_town');
            $address_state           = $ci->input->post('address_state');
            $address_post_code       = $ci->input->post('address_post_code');
            $ranking_score           = $ci->input->post('ranking_score');
            $about                   = $ci->input->post('about');
            $investor_type_id        = $ci->input->post('investor_type_id');
            $preferred_investment_amount      = $ci->input->post('preferred_investment_amount');
            $preferred_investment_industires  = json_encode($ci->input->post('preferred_investment_industires'));
            $preferred_esic_status_ids        = json_encode($ci->input->post('preferred_esic_status_ids'));
            $TemplateID                       = $ci->input->post('template');
            if(empty($name)){
                $error = "FAIL::".$ci->NameMessage." Name is a required field::error::Required!!";
                array_push($return, $error);
                return $return;
            }
            $NameExist = checkListingExist($ci, $name, 'name', $ID);
            if($NameExist == true){
                $error =  "FAIL::".$ci->NameMessage." Name Already Exist Cannot Edit Please Contact Administrator::error";
                array_push($return, $error);
                return $return;
            }
            $EmailExist = checkListingExist($ci, $email, 'email', $ID);
            if($EmailExist == true){
                $error =  "FAIL::".$ci->NameMessage." Email Already Exist Cannot Edit Please Contact Administrator::error";
                array_push($return, $error);
                return $return;
            }
            $showData   = getShowDataJson($ci);
            $now        = date("Y-m-d H:i:s");
            $userID     = getCurrentUserID($ci);
            $updateData = array(
                'name'                  => $name,
                'slug'                  => $slug,
                'phone'                 => $phone,
                'email'                 => $email,
                'website'               => $website,
                'company_name'          => $company_name,
                'company_email'         => $company_email,
                'address_street_number' => $address_street_number,
                'address_street_name'   => $address_street_name,
                'address_town'          => $address_town,
                'address_state'         => $address_state,
                'address_post_code'     => $address_post_code,
                'about'                 => $about,
                'ranking_score'         => $ranking_score,
                'investor_type_id'      => $investor_type_id,
                'preferred_investment_amount'      => $preferred_investment_amount,
                'preferred_investment_industires'  => $preferred_investment_industires,
                'preferred_esic_status_ids'        => $preferred_esic_status_ids,
                'template'              => $TemplateID,
                'doShowItems'           => $showData,
                'date_updated'          => $now,
                'not_approve'           => 0
            );
            $where = array('id' => $ID);
            if(!isCurrentUserAdmin($ci)){
                $userID = getCurrentUserID($ci);
                $where['userID'] = $userID;    
            }
            $updateData[$ci->listingField] = $ID;
            // get current esic version
            $selectField ="version, is_new_ver, logo, banner, userID";
            $version = $ci->Common_model->select_fields_where($ci->tableName, $selectField, $where, true);
            $isNewVer = $version->is_new_ver; // will pass this later to uploadImagesAction method
            $newVer = $version->version + 1;
            // check if already present new version which is not approved yet, then update that version else insert new version
            $whereVer = array(
                $ci->listingField=>$ID,
                'version'=>$newVer
            );
            $updateData['version'] = $newVer;
            $updateData['userID'] = $version->userID;
            $records = $ci->Common_model->select_fields_where($ci->versionTable, 'count(id) as Total, id, logo, banner', $whereVer, true);
            if($isNewVer != 'Yes'){
                $updateData['logo'] = $version->logo;
                $updateData['banner'] = $version->banner;
            } else {
                $updateData['logo'] = $records->logo;
                $updateData['banner'] = $records->banner;
            }
            if($records->Total > 0){
                $newVersion = $ci->Common_model->update($ci->versionTable, array('id'=>$records->id), $updateData);
                $verId = $records->id;
            }
            else {
                $newVersion = $ci->Common_model->insert_record($ci->versionTable, $updateData);
                $verId = $newVersion;
            }
            // $updateResult = $ci->Common_model->update($ci->tableName,$where , $updateData);
            if($newVersion){
                $success =  "OK::Record Successfully Updated ID is ".$ID." ::success";
                array_push($return, $success);
                $isNewVer = 'Yes';
                // set new version true
                $ci->Common_model->update($ci->tableName, $where, array('is_new_ver'=>'Yes'));
            }else{
                $error =  "FAIL::Record Not Updated::error";
                array_push($return, $error);
                return $return;
            }
            $notes = uploadImagesAction($ci,$ID,$isNewVer);
            if(is_array($notes) && !empty($notes)){
                foreach ($notes as $key => $note){
                    array_push($return, $note);
                }
            }
            $notes = saveSocialLinks($ci,$ID,'Edit');
            if(is_array($notes) && !empty($notes)){
                foreach ($notes as $key => $note){
                    array_push($return, $note);
                }
            }
            // check if user was admin, then approve the changes
            if(isCurrentUserAdmin($ci)){
                approveNewVersion($verId, $ID ,$ci);
            }
            return $return;
        }
        return false;
    }
    function ViewHelperListing($postData = array()){
        $ci =& get_instance();
        if(empty($postData)){
           //$postData = $ci->input->post();
        }
        if($postData){
            //Getting Posted Inputs.
            $searchBoxValue = $postData['searchBox'];
            $locationSelect = $postData['locationSelect'];
            $orderByFilter = $postData['orderByFilter'];

            $and = true;
            $whereParam = 'Publish = 1';
            if(!empty($searchBoxValue)){
                if ($and === true and !empty($whereParam)) {
                    $whereParam .= ' AND ';
                }
                $whereParam .= '(LOWER('.$ci->tableName.'.`name`) LIKE "%'.strtolower($searchBoxValue).'%"';
                $whereParam .= ' OR LOWER(`company_name`) LIKE "%'.strtolower($searchBoxValue).'%"';
                $whereParam .= ' OR LOWER(`website`) LIKE "%'.strtolower($searchBoxValue).'%")';
                $and = true;
            }
            if (!empty($locationSelect)) {
                if ($and === true and !empty($whereParam)) {
                    $whereParam .= ' AND ';
                }
                $whereParam .=' (';
                $count = 0;
                foreach($locationSelect as $location){
                    if($count > 0){
                        $whereParam .= ' OR ';
                    }
                    if(!empty($location)){
                        $whereParam .= '( LOWER(address_town) LIKE "%'.$location.'%"';
                        $whereParam .= ' OR LOWER(address_state) LIKE "%'.$location.'%"';
                        $whereParam .= ' OR LOWER(address_street_name) LIKE "%'.$location.'%")';
                    }
                    $count++;
                }//End of Foreach
                $whereParam .=') ';
                $and = true;
            }//End of If Not Empty Statement
            if(!empty($orderByFilter)){
                $filterType = $orderByFilter;
                unset($orderByFilter);
                $orderByFilter = [$ci->tableName.'.name', $filterType];
            }
        }//End of If post exist Statement
        $selectData = array('
            '.$ci->tableName.'.*,
            ES.*,
            InTypes.label as investorType,
            PIA.label as preferredInvestmentAmount
            ',false);
        $where = 'trashed != 1';
        if($whereParam !== null and !empty($whereParam)){
            $where.= ' And '.$whereParam;
        }
        if(!empty($newVer)) $where[$ci->tableName.'.id'] = $newVer;
        $joins = array(
            array(
                'table' => 'investor_social ES',
                'condition' => 'ES.listingID = '.$ci->tableName.'.id',
                'type' => 'LEFT'
            ),
            array(
                'table' => 'investor_types InTypes',
                'condition' => 'InTypes.id = '.$ci->tableName.'.investor_type_id',
                'type' => 'LEFT'
            ),
            array(
                'table' => 'investors_preferred_investment_amounts PIA',
                'condition' => 'PIA.id = '.$ci->tableName.'.preferred_investment_amount',
                'type' => 'LEFT'
            ),

        );
        if(isset($orderByFilter) and !empty($orderByFilter)){
            $orderBy = $orderByFilter;
        }else{
            $orderBy ='RAND()';
        }
        $returnedData = $ci->Common_model->select_fields_where_like_join($ci->tableName,$selectData,$joins,$where,false,'','','',$orderBy);
        return $returnedData;   
    }
     function ViewHelperDetail($alias, $newVer=''){
        $ci =& get_instance();
        $selectData = array('
            '.$ci->tableName.'.*,
            '.$ci->tableName.'.id as ListID,
            states.name As address_state,
            SPC.postcode As address_post_code,
            ES.*,
            IPIA.label as AmountLabel,
            IPIA.label as AmountFROM,
            IPIA.label as AmountTO,
            InTypes.label as TypeLabel,
            InTypes.name as TypeName
            ',false);
        $where = array(
            'slug' => $alias
        );
        $joins = array(
            array(
                'table' => 'investor_social ES',
                'condition' => 'ES.listingID = '.$ci->tableName.'.id',
                'type' => 'LEFT'
            ),
            array(
                'table' => 'investor_types InTypes',
                'condition' => 'InTypes.id = '.$ci->tableName.'.investor_type_id',
                'type' => 'LEFT'
            ),
            array(
                'table' => 'investors_preferred_investment_amounts IPIA',
                'condition' => 'IPIA.id = '.$ci->tableName.'.preferred_investment_amount',
                'type' => 'LEFT'
            ),
            array(
                'table' => 'states',
                'condition' => 'states.abbreviation = '.$ci->tableName.'.address_state',
                'type' => 'LEFT'
            ),
            array(
                'table' => 'sys_post_codes SPC',
                'condition' => 'SPC.id = '.$ci->tableName.'.address_post_code',
                'type' => 'LEFT'
            )

        );
        $returnedData = $ci->Common_model->select_fields_where_like_join($ci->tableName,$selectData,$joins,$where,true);
        return $returnedData;
    }
    function ViewHelperAdd($ci){
        $firstName = $ci->input->post('name');
        $email     = $ci->input->post('email');
        if(validateEmail($email) == true){
            $preferred_investment_amount_id  = $ci->input->post('preferred_investment_amount');
            $industires_ids_Array            = $ci->input->post('preferred_investment_industires');
            $investor_type_id  = $ci->input->post('investor_type_id');
            $Act_2001          = $ci->input->post('Act_2001');//if i get certificate also if provided
            $userData = array(
                'userName'      => $email,
                'firstName'     => $firstName,
                'email'         => $email
            );
            $userID = '';
            $CurrentUserLoggedInCheck = isCurrentUserLoggedIn($ci);
            if($CurrentUserLoggedInCheck == false){
                $userID = createNewUser($ci,$userData);
            }else{
                $userID = getCurrentUserID($ci);
            }
            if(!empty($userID)){
               $slug = getAlias($firstName);
               $slug = checkAndChangeIfAlreadyExistSlug($ci,$slug);
               $listingData = array(
                    'userID'    => $userID,
                    'name'      => $firstName,
                    'slug'      => $slug,
                    'email'     => $email,
                    'Act_2001'  => $Act_2001,
                    'preferred_investment_industires'   => json_encode($industires_ids_Array)
                );
                if(!empty($investor_type_id)){
                    $listingData['investor_type_id'] = $investor_type_id;
                }
                if(!empty($preferred_investment_amount_id)){
                    $listingData['preferred_investment_amount'] = $preferred_investment_amount_id;
                }
                $listingID = createNewListing($ci,$listingData);
                if(!empty($listingID)){
                    addRoleToUser($ci);
                    echo 'OK::User and Its Investor Listing Created::success::'.$userID.'::'.$listingID;
                    return false;
                }
               /* $subject = 'Investor Listing Error';
                $message ='Sorry There has been Error Investor Listing Cannot Be Created But User Has Been Created Please Login Into Esic Directory To Add Listing Thanks';
                customEmail($ci,$subject,$email,$message);*/
                echo 'FAIL::Sorry There has been Error Investor Listing Cannot Be Created But User Has Been Created::error';
                return false;
            }
            /*$subject = 'User Error';
            $message ='Sorry There has been Error User Cannot Be Created. Thanks';
            customEmail($ci,$subject,$email,$message);*/
            echo 'FAIL::Sorry There has been Error User Cannot Be Created::error';
            return false;
        }
    }
//Investor Filters shall be different from the Default Filters.
function getListingFilters(){
    $ci =& get_instance();
    $return['Locations'] = [];
    //Getting the States.
    $selectFilterData = [
        'address_state as name'
    ];
    $whereFilter = 'address_state IS NOT NULL';
    $groupBy = 'address_state';
    $locationState = $ci->Common_model->select_fields_where($ci->tableName,$selectFilterData,$whereFilter,false, '','','',$groupBy);
    $return['Locations']['states'] = $locationState;

    //Getting the Address Town
    $selectFilterData = [
        'address_town as name'
    ];
    $whereFilter = 'address_state IS NOT NULL';
    $groupBy = 'address_town';
    $locationTown = $ci->Common_model->select_fields_where($ci->tableName,$selectFilterData,$whereFilter,false, '','','',$groupBy);
    $return['Locations']['towns'] = $locationTown;

    //Getting the Address Street
    $selectFilterData = [
        'address_street_name as name'
    ];
    $whereFilter = 'address_street_name IS NOT NULL';
    $groupBy = 'address_street_name';
    $locationTown = $ci->Common_model->select_fields_where($ci->tableName,$selectFilterData,$whereFilter,false, '','','',$groupBy);
    $return['Locations']['streets'] = $locationTown;
    return $return;
}
    function ViewHelperSaveQuestionsAnswers($ci){
        $userID    = $ci->input->post('userID');
        $listingID = $ci->input->post('listingID');
        SaveUserListingQuestionAnwers($ci, $listingID);
    }
?>
