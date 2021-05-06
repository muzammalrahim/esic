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
                '.$ci->tableName.'.phone AS Phone,
                '.$ci->tableName.'.is_new_ver AS New_Ver,
                '.$ci->tableName.'.website AS Website,
                '.$ci->tableName.'.ANZSRC AS ANZSRC,
                '.$ci->tableName.'.IDNumber AS IDNumber, 
                '.$ci->tableName.'.email AS Email,
                '.$ci->tableName.'.logo AS Logo,
                '.$ci->tableName.'.status_flag_id AS Status_ID,
                vr.slug AS slug,
                vr.name AS vr_Name,
                vr.not_approve AS Cancel,
                vr.name AS vr_Name,
                vr.logo AS vr_Logo,
                vr.website AS vr_Website,
                vr.id AS Ver_Id, vr.'.$ci->listingField.' AS list_Id,
                ESF.Label AS Status_Label,
                '.$ci->tableName.'.Publish as PublishStatusID,
                CASE WHEN '.$ci->tableName.'.trashed = 1 THEN CONCAT(\'<span class="label label-danger" data-target=".approval-modal" data-toggle="modal">YES</span>\') WHEN '.$ci->tableName.'.trashed = 0 THEN CONCAT(\'<span class="label label-success" data-target=".approval-modal" data-toggle="modal">NO</span>\') ELSE "" END AS Trashed
                ',false);
                if($isAdmin == 'yes'){
                    $selectData[0]  .= ', CASE WHEN '.$ci->tableName.'.Publish = 1 THEN CONCAT(\'<span class="label label-success" data-target=".publish-modal" data-toggle="modal">YES</span>\') WHEN '.$ci->tableName.'.Publish = 0 THEN CONCAT(\'<span class="label label-danger" data-target=".publish-modal" data-toggle="modal">NO</span>\') ELSE "" END AS Publish';
                }else{
                    $selectData[0]  .= ', CASE WHEN '.$ci->tableName.'.Publish = 1 THEN CONCAT(\'<span class="label label-success">YES</span>\') WHEN '.$ci->tableName.'.Publish = 0 THEN CONCAT(\'<span class="label label-danger">NO</span>\') ELSE "" END AS Publish';
                }

                $addColumns = array(
                    'isAdmin' => $isAdmin,
                    'ViewEditActionButtons' => array($Actions.
                        '<a href="'.base_url().$ci->Name.'/Edit/$1"><span data-toggle="tooltip" title="Edit" data-placement="left" aria-hidden="true" class="fa fa-pencil text-blue"></span></a> &nbsp; <a href="#" data-target=".approval-modal" data-toggle="modal"><i data-toggle="tooltip" title="Trash" data-placement="right"  class="fa fa-trash-o text-red"></i></a>','ID')
                );
                $joins = array(
                    array(
                        'table' => 'esic_status_flags ESF',
                        'condition' => 'ESF.id = '.$ci->tableName.'.status_flag_id',
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

            $Name    = $ci->input->post('Name');
            $slug = getAlias($Name);
            $slug = checkAndChangeIfAlreadyExistSlug($ci,$slug);
            $phone   = $ci->input->post('phone');
            $email   = $ci->input->post('email');
            $website = $ci->input->post('website');
            $ranking_score = $ci->input->post('ranking_score');
            //Need to have Separate Logic for Address.
            //If Address is a single String then store it as a Single String.
            //Else, We Would Need to Combine multiple Address Fields in to One JSON.

            //Multi Field Address
            $StreetNumber   = $ci->input->post('address_street_number');
            $StreetName     = $ci->input->post('address_street_name');
            $Town           = $ci->input->post('address_town');
            $State          = $ci->input->post('address_state');
            $PostCode       = $ci->input->post('address_post_code');

            $status_flag_id = $ci->input->post('statusFlag');

            $Program_Summary = $ci->input->post('Program_Summary');
            $RndCredentialsSummary = $ci->input->post('RndCredentialsSummary');

            $ProgramName        = $ci->input->post('ProgramName');
            $ProgramStartDate   = $ci->input->post('ProgramStartDate');
            $roleDepartment     = $ci->input->post('roleDepartment');
            $contactName        = $ci->input->post('contactName');
            

            $contactName    = $ci->input->post('contactName');
            $ContactEmail   = $ci->input->post('ContactEmail');
            $roleDepartment = $ci->input->post('roleDepartment');
            $keywords = $ci->input->post('keywords');
            
            //For Rnd Partners Specially
            $IDNumber = $ci->input->post('IDNumber');
            $ANZSRC   = json_encode($ci->input->post('ANZSRC'));

            if(empty($Name)){
                $error = "FAIL::".$ci->NameMessage." Name is a required field::error::Required!!";
                array_push($return, $error);
                return $return;
            }
            /*$NameExist = checkListingExist($ci, $Name, 'name');
            if($NameExist == true){
                $error =  "FAIL::".$ci->NameMessage." Name Already Exist Cannot Create New Please Contact Administrator::error";
                array_push($return, $error);
                return $return;
            }
            $EmailExist = checkListingExist($ci, $Email, 'email');
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
                    'userRole'  => json_encode(array("5")),
                    'userName'  => $Name,
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
                'name'                  => $Name,
                'slug'                  => $slug,
                'phone'                 => $phone,
                'email'                 => $email,
                'website'               => $website,
                'address_street_number' => $StreetNumber,
                'address_street_name'   => $StreetName,
                'address_town'          => $Town,
                'address_state'         => $State,
                'address_post_code'     => $PostCode,
                'keywords'              => $keywords,
                'ranking_score'         => $ranking_score,
                'Program_Summary'       => $Program_Summary,
                'RndCredentialsSummary' => $RndCredentialsSummary,
                'ProgramName'           => $ProgramName,
                'ProgramStartDate'      =>  $ProgramStartDate ? date("Y-m-d",strtotime($ProgramStartDate)) : $ProgramStartDate = "",
                'roleDepartment'        => $roleDepartment,
                'contactName'           => $contactName,
                'IDNumber'              => $IDNumber,
                'ANZSRC'                => $ANZSRC,
                'status_flag_id'        => $status_flag_id,
                'ContactEmail'          => $ContactEmail,
                'date_created'          => $now,
                'date_updated'          => $now,
                'Publish'               => $Publish
            );



            $insertResult = $ci->Common_model->insert_record($ci->tableName,$insertData);

            if($insertResult){
                $success =  "OK::Record Successfully Added ID is ".$insertResult." ::success";
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
            $Name    = $ci->input->post('Name');
            $slug  = getAlias($Name);
            if(checkSameSlugIsExistForListingID($ci,$slug,$ID) == true){
                $slug = $slug;
            }else{
                $slug = checkAndChangeIfAlreadyExistSlug($ci,$slug);
            }
            $phone   = $ci->input->post('phone');
            $email   = $ci->input->post('email');
            $website = $ci->input->post('website');
            $ranking_score = $ci->input->post('ranking_score');
            //Need to have Separate Logic for Address.
            //If Address is a single String then store it as a Single String.
            //Else, We Would Need to Combine multiple Address Fields in to One JSON.

            //Multi Field Address
            $StreetNumber   = $ci->input->post('address_street_number');
            $StreetName     = $ci->input->post('address_street_name');
            $Town           = $ci->input->post('address_town');
            $State          = $ci->input->post('address_state');
            $PostCode       = $ci->input->post('address_post_code');


            $Program_Summary    = $ci->input->post('Program_Summary');
            $RndCredentialsSummary    = $ci->input->post('RndCredentialsSummary');

            $ProgramName        = $ci->input->post('ProgramName');
            $ProgramStartDate   = $ci->input->post('ProgramStartDate');
            $roleDepartment     = $ci->input->post('roleDepartment');
            $contactName        = $ci->input->post('roleDepartment');

            $status_flag_id = $ci->input->post('statusFlag');
            
            $contactName = $ci->input->post('contactName');
            $ContactEmail  = $ci->input->post('ContactEmail');
            $roleDepartment = $ci->input->post('roleDepartment');
            $keywords = $ci->input->post('keywords');

            //For Rnd Partners Specially
            $IDNumber = $ci->input->post('IDNumber');
            $ANZSRC   = json_encode($ci->input->post('ANZSRC'));

            if(empty($Name)){
                $error = "FAIL::".$ci->NameMessage." Name is a required field::error::Required!!";
                array_push($return, $error);
                return $return;
            }
            $now    = date("Y-m-d H:i:s");
            $userID = getCurrentUserID($ci);
            $updateData = array(
                'name'                  => $Name,
                'slug'                  => $slug,
                'phone'                 => $phone,
                'email'                 => $email,
                'website'               => $website,
                'address_street_number' => $StreetNumber,
                'address_street_name'   => $StreetName,
                'address_town'          => $Town,
                'address_state'         => $State,
                'address_post_code'     => $PostCode,
                'keywords'              => $keywords,
                'ranking_score'         => $ranking_score,
                'Program_Summary'       => $Program_Summary,
                'RndCredentialsSummary' => $RndCredentialsSummary,
                'ProgramName'           => $ProgramName,
                'ProgramStartDate'      =>  $ProgramStartDate ? date("Y-m-d",strtotime($ProgramStartDate)) : $ProgramStartDate = "",
                'roleDepartment'        => $roleDepartment,
                'contactName'           => $contactName,
                'IDNumber'              => $IDNumber,
                'ANZSRC'                => $ANZSRC,
                'ContactEmail'          => $ContactEmail,
                'status_flag_id'        => $status_flag_id,
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
            $selectField ="version, is_new_ver, logo, banner, userID, long_description, businessShortDescriptionJSON";
            $version = $ci->Common_model->select_fields_where($ci->tableName, $selectField, $where, true);
            $isNewVer = $version->is_new_ver; // will pass this later to uploadImagesAction method
            $newVer = $version->version + 1;
            // check if already present new version which is not approved yet, then update that version else insert new version
            $whereVer = array(
                $ci->listingField => $ID,
                'version'         => $newVer
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
            if(isCurrentUserAdmin($ci)){
                if(!empty($version->long_description))
                    $updateData['long_description'] = $version->long_description;
                if(!empty($version->businessShortDescriptionJSON))
                    $updateData['businessShortDescriptionJSON'] = $version->businessShortDescriptionJSON;
                if($isNewVer == 'Yes'){
                    if(!empty($records->long_description))
                        $updateData['long_description'] = $records->long_description;
                    if(!empty($records->businessShortDescriptionJSON))
                        $updateData['businessShortDescriptionJSON'] = $records->businessShortDescriptionJSON;
                }
            }
            if($records->Total > 0){
                $newVersion = $ci->Common_model->update($ci->versionTable, array('id'=>$records->id), $updateData);
                $verId = $records->id;
            }
            else {
                $newVersion = $ci->Common_model->insert_record($ci->versionTable, $updateData);
                $verId = $newVersion;
            }
            //$updateResult = $ci->Common_model->update($ci->tableName,$where , $updateData);
            
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
            RPS.*,
            '.$ci->tableName.'.status_flag_id AS Status_ID,
            ESF.Label AS Status_Label
            ',false);
        $where = 'trashed != 1';
        if(isset($whereParam) and $whereParam !== null and !empty($whereParam)){
            $where.= ' And '.$whereParam;
        }else{
            $whereParam = 'Publish = 1';
            $where.= ' And '.$whereParam;
        }
        $joins = array(
            array(
                'table' => 'rndpartner_social RPS',
                'condition' => 'RPS.listingID = '.$ci->tableName.'.id',
                'type' => 'LEFT'
            ),
            array(
                'table' => 'esic_status_flags ESF',
                'condition' => 'ESF.id = '.$ci->tableName.'.status_flag_id',
                'type' => 'LEFT'
            )
        );
        if(isset($orderByFilter) and !empty($orderByFilter)){
            $orderBy = $orderByFilter;
        }else{
            $orderBy ='RAND()';
        }
        $returnedData = $ci->Common_model->select_fields_where_like_join($ci->tableName,$selectData,$joins,$where,false,'','','',$orderBy);
        if(empty($returnedData)){
            if($postData){
                //Getting Posted Inputs.
                $searchBoxValue = $postData['searchBox'];
                $locationSelect = $postData['locationSelect'];
                $orderByFilter = $postData['orderByFilter'];
                // split search key into pieces, so that we can search related listings
                $searchKeys = str_split($searchBoxValue, 1);
                $searchKey = strtolower($searchBoxValue);

                $and = true;
                $whereParam = 'Publish = 1';
                if(!empty($searchBoxValue)){
                    if ($and === true and !empty($whereParam)) {
                        $whereParam .= ' AND (';
                    }
                    if(!empty($searchKeys) && is_array($searchKeys)){
                        $countLoop = 1;
                        foreach($searchKeys as $key){
                            if($countLoop == 1)
                                $whereParam .= 'LOWER('.$ci->tableName.'.`name`) LIKE "%'.strtolower($key).'%"';
                            else
                                $whereParam .= 'OR LOWER('.$ci->tableName.'.`name`) LIKE "%'.strtolower($key).'%"';
                            $whereParam .= ' OR LOWER(`website`) LIKE "%'.strtolower($key).'%"';
                            $countLoop += 1;
                        }
                        $whereParam .= ')';
                    }
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
            RPS.*,
            '.$ci->tableName.'.status_flag_id AS Status_ID,
            ESF.Label AS Status_Label
            ',false);
            $where = 'trashed != 1';
            if(isset($whereParam) and $whereParam !== null and !empty($whereParam)){
                $where.= ' And '.$whereParam;
            }
            $joins = array(
                array(
                    'table' => 'rndpartner_social RPS',
                    'condition' => 'RPS.listingID = '.$ci->tableName.'.id',
                    'type' => 'LEFT'
                ),
                array(
                    'table' => 'esic_status_flags ESF',
                    'condition' => 'ESF.id = '.$ci->tableName.'.status_flag_id',
                    'type' => 'LEFT'
                )
            );
            if(isset($orderByFilter) and !empty($orderByFilter)){
                $orderBy = $orderByFilter;
            }else{
                $orderBy ='RAND()';
            }
            $returnedData = $ci->Common_model->select_fields_where_like_join($ci->tableName,$selectData,$joins,$where,false,'','','',$orderBy);
        }
        return $returnedData;   
    }

    function ViewHelperAdd($ci){
        $userID = $ci->input->post('userID');
        $IDNumber = $ci->input->post('IDNumber');
        $name     = $ci->input->post('rndPartnerName');
        $email    = $ci->input->post('rndPartnerEmail');
        $website  = $ci->input->post('website');
        $address_town  = $ci->input->post('address_town');
        $address_state = $ci->input->post('address_state');
        $address_post_code     = $ci->input->post('address_post_code');
        $address_street_name   = $ci->input->post('address_street_name');
        $address_street_number = $ci->input->post('address_street_number');
        $ANZSRC   = json_encode($ci->input->post('ANZSRC'));
        $RndCredentialsSummary  = $ci->input->post('RndCredentialsSummary');
        //$Program_Start_Date             = date("Y-m-d",strtotime($ci->input->post('Program_Start_Date')));
        $projectnexperience    = $ci->input->post('projectnexperience');
        $work     = $ci->input->post('work');

        $contactName    = $ci->input->post('contactName');
        $roleDepartment = $ci->input->post('roleDepartment');
        $ContactEmail   = $ci->input->post('ContactEmail');
        $phone   = $ci->input->post('phone');

        $Program_Summary   = $ci->input->post('Program_Summary');
        $Program_Application_Method     = $ci->input->post('Program_Application_Method');

            if(!empty($userID)){
               $slug = getAlias($name);
               $slug = checkAndChangeIfAlreadyExistSlug($ci,$slug);
               
               if(empty($email)){
                   $email = getUserCurrentEmail($ci,$userID);
               }

               $listingData = array(
                    'userID'    => $userID,
                    'name'      => $name,
                    'slug'      => $slug
                );

                if(!empty($email)){
                    $listingData['email'] = $email;
                }
                if(!empty($website)){
                    $listingData['website'] = $website;
                }
                if(!empty($address_town)){
                    $listingData['address_town'] = $address_town;
                }
                if(!empty($address_state)){
                    $listingData['address_state'] = $address_state;
                }
                if(!empty($address_post_code)){
                    $listingData['address_post_code'] = $address_post_code;
                }
                if(!empty($address_street_name)){
                    $listingData['address_street_name'] = $address_street_name;
                }
                if(!empty($address_street_number)){
                    $listingData['address_street_number'] = $address_street_number;
                }
                if(!empty($IDNumber)){
                    $listingData['IDNumber'] = $IDNumber;
                }
                if(!empty($ANZSRC)){
                    $listingData['ANZSRC'] = $ANZSRC;
                }
                if(!empty($RndCredentialsSummary)){
                    $listingData['RndCredentialsSummary'] = $RndCredentialsSummary;
                }
                if(!empty($projectnexperience)){
                    $listingData['projectnexperience'] = $projectnexperience;
                }
                if(!empty($work)){
                    $listingData['work'] = $work;
                }
                if(!empty($Program_Application_Method)){
                    $listingData['Program_Application_Method'] = $Program_Application_Method;
                }
                if(!empty($Program_Summary)){
                    $listingData['Program_Summary'] = $Program_Summary;
                }
                if(!empty($contactName)){
                    $listingData['contactName'] = $contactName;
                }
                if(!empty($roleDepartment)){
                    $listingData['roleDepartment'] = $roleDepartment;
                }
                if(!empty($ContactEmail)){
                    $listingData['ContactEmail'] = $ContactEmail;
                }
                if(!empty($phone)){
                    $listingData['phone'] = $phone;
                }
                $listingID = createNewListing($ci,$listingData);
                if(!empty($listingID)){
                    addRoleToUser($ci);
                    echo 'OK::R&D Partner Listing Added::success::'.$listingID;
                    return false;
                }
                echo 'FAIL::Sorry There has been Error In R&D Partner Listing::error';
                return false;
            }
            echo 'FAIL::Sorry There has been An Error::error';
            return false;
    }
 
    function ViewHelperDetail($alias){
        $ci =& get_instance();
        $selectData = array('
            '.$ci->tableName.'.*,
            RPS.facebook,
            pcv.postcode,
            RPS.twitter,
            RPS.google,
            RPS.linkedIn,
            RPS.youTube,
            RPS.vimeo,
            RPS.instagram,
            '.$ci->tableName.'.status_flag_id AS Status_ID,
            ESF.Label AS Status_Label
            ',false);
        $where = array(
            'slug' => $alias
        );
        $joins = array(
            array(
                'table' => 'rndpartner_social RPS',
                'condition' => 'RPS.listingID = '.$ci->tableName.'.id',
                'type' => 'LEFT'
            ),
            array(
                'table' => 'esic_status_flags ESF',
                'condition' => 'ESF.id = '.$ci->tableName.'.status_flag_id',
                'type' => 'LEFT'
            ) ,
            array(
                'table' => 'sys_post_codes pcv',
                'condition' => 'pcv.id = '.$ci->tableName.'.address_post_code',
                'type' => 'LEFT'
            )
        );
        $returnedData = $ci->Common_model->select_fields_where_like_join($ci->tableName,$selectData,$joins,$where,true);
        return $returnedData;
    }

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

        //Getting the Address Street Name
        $selectFilterData = [
            'address_street_name as name'
        ];
        $whereFilter = 'address_street_name IS NOT NULL';
        $groupBy = 'address_street_name';
        $locationStreet = $ci->Common_model->select_fields_where($ci->tableName,$selectFilterData,$whereFilter,false, '','','',$groupBy);
        $return['Locations']['streets'] = $locationStreet;
        return $return;
    }
    function ViewHelperSaveQuestionsAnswers($ci){
        $userID    = $ci->input->post('userID');
        $listingID = $ci->input->post('listingID');
        SaveUserListingQuestionAnwers($ci, $listingID);
    }
    function ViewHelperGetPreview($ci,$listingID){
        $where = array('id' => $listingID);
        $data  = $ci->Common_model->select_fields_where($ci->tableName,'*',$where,true);
        return $data;
    }
?>
