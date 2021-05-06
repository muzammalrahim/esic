<?php
/* view esic helper listings *//* view esic helper listings */
function viewHelperManage($param=NULL){
    $ci =& get_instance();
    if(checkRoleHasPermission($ci,$ci->Name.' Admin Listing') == true){
        $ci->load->model('Common_model');
        $isAdmin = 'no';
        //Now see if the param is of listing
        if($param === 'listing'){
            $where = array('');
            if(!isCurrentUserAdmin($ci)){
                $userID  = getCurrentUserID($ci);
                $where   = array($ci->tableName.'.userID' => $userID);
                $Actions = '';
                $isAdmin = 'no';
            }else{
                $Actions = '<a href="#" data-target=".publish-modal" data-toggle="modal"><i data-toggle="tooltip" title="Publish Status" data-placement="right"  class="fa fa-check text-blue"></i></a> &nbsp;';
                $isAdmin = 'yes';
            }
            $selectData = array('
                '.$ci->tableName.'.website AS Website,
                '.$ci->tableName.'.id AS ID,
                '.$ci->tableName.'.name AS Name,
                '.$ci->tableName.'.is_new_ver AS New_Ver,
                '.$ci->tableName.'.email AS Email,
                '.$ci->tableName.'.logo AS Logo,
                '.$ci->tableName.'.status AS Status_ID,
                vr.website AS vr_Website,
                vr.id AS vr_ID,
                vr.name AS vr_Name,
                vr.email AS vr_Email,
                vr.logo AS vr_Logo,
                vr.status AS vr_Status_ID,
                vr.slug AS slug,
                vr.id AS Ver_Id, 
                vr.not_approve AS Cancel,
                vr.'.$ci->listingField.' AS list_Id,
                ES.color AS color,
                CASE WHEN '.$ci->tableName.'.trashed = 1 THEN CONCAT(\'<span class="label label-danger" data-target=".approval-modal-delete" data-toggle="modal">YES</span>\') WHEN '.$ci->tableName.'.trashed = 0 THEN CONCAT(\'<span class="label label-success" data-target=".approval-modal-delete" data-toggle="modal" >NO</span>\') ELSE "" END AS Trashed,
                '.$ci->tableName.'.Publish as PublishStatusID
               ');
            if($isAdmin == 'yes') {
                $selectData[0] .= ', CASE WHEN '.$ci->tableName.'.Publish = 1 THEN CONCAT(\'<span class="label label-success" data-target=".publish-modal" data-toggle="modal">YES</span>\') WHEN '.$ci->tableName.'.Publish = 0 THEN CONCAT(\'<span class="label label-danger" data-target=".publish-modal" data-toggle="modal">NO</span>\') ELSE "" END AS Publish ';
            } else {
                $selectData[0] .= ',CASE WHEN '.$ci->tableName.'.Publish = 1 THEN CONCAT(\'<span class="label label-success">YES</span>\') WHEN '.$ci->tableName.'.Publish = 0 THEN CONCAT(\'<span class="label label-danger">NO</span>\') ELSE "" END AS Publish ';
            }
            if($isAdmin == 'yes') {
                $selectData[0] .= ', CASE WHEN ES.id > 0 THEN CONCAT("<span class=\'label  fetch_status\' style=\' background-color:",color,"\' data-target=\'.approval-modal\' data-toggle=\'modal\'> ", ES.status," </span>") ELSE CONCAT ("<span class=\'label label-warning\' data-target=\'.approval-modal\' data-toggle=\'modal\'> ", ES.status, " </span>") END AS Status_Label';
            } else {
                $selectData[0] .= ',CASE WHEN ES.id > 0 THEN CONCAT("<span class=\'label \' data-toggle=\'tooltip\' title=\'status is set by the directory, please contact us when you need it updated\' data-placement=\'bottom\'  style=\' background-color:",color,"\'> ", ES.status," </span>") ELSE CONCAT ("<span class=\'label label-warning\'> ", ES.status, " </span>") END AS Status_Label';
            }
            $addColumns = array(
                'isAdmin' => $isAdmin,
                'ViewEditActionButtons' => array($Actions.
                    '<a href="'.base_url().$ci->Name.'/Edit/$1"><span data-toggle="tooltip" title="Edit" data-placement="left" aria-hidden="true" class="fa fa-pencil text-blue"></span></a> &nbsp; <a href="#" data-target=".approval-modal-delete" data-toggle="modal"><i data-toggle="tooltip" title="Trashed" data-placement="right"  class="fa fa-trash-o text-red"></i></a>','ID')
            );
            $joins = array(
                array(
                    'table' => 'esic_status ES',
                    'condition' => 'ES.id = '.$ci->tableName.'.status',
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
        $ci->data['message'] = $ci->pageMessage;
        $ci->data['statusContent'] = $ci->statusText;
        $ci->data['get_status'] = $ci->Common_model->select('esic_status');
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
    $name   = $ci->input->post('name');
    $slug   = getAlias($name);
    $slug   = checkAndChangeIfAlreadyExistSlug($ci,$slug);
    $website        = $ci->input->post('website');
    $email          = $ci->input->post('email');
    $business       = $ci->input->post('business');
    $corporate_date = $ci->input->post('corporate_date');
    $added_date     = $ci->input->post('added_date');
    $expiry_date    = $ci->input->post('expiry_date');
    $corporate_date = $corporate_date ? date("Y-m-d",strtotime($corporate_date)) : $corporate_date = "";
    $added_date     = $added_date     ? date("Y-m-d",strtotime($added_date)): date("Y-m-d") ;
    if(!empty($corporate_date)){
        $corporate_year = explode("-",$corporate_date);
        $corporate_year = $corporate_year[0];
        if( $corporate_date > date("$corporate_year-06-30") && $corporate_date <= date("$corporate_year-12-31") ){
            $corporate_year +=5;
            $expiry_date = date("$corporate_year-06-30");
        }else if($corporate_date < date("$corporate_year-07-01") && $corporate_date >= date("$corporate_year-01-01") ){
            $corporate_year +=4;
            $expiry_date = date("$corporate_year-06-30");
        }
    }
    $acn_number             = $ci->input->post('acn_number');
    $address_street_number  = $ci->input->post('address_street_number');
    $address_street_name    = $ci->input->post('address_street_name');
    $address_town           = $ci->input->post('address_town');
    $address_state          = $ci->input->post('address_state');
    $address_post_code      = $ci->input->post('address_post_code');
    $short_description      = $ci->input->post('short_description');
    //$long_description     = $ci->input->post('long_description');
    $keywords               = $ci->input->post('keywords');
    $ranking_score          = $ci->input->post('ranking_score');
    $TemplateID             = $ci->input->post('template');
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
    //$p_json = '{"data":[{"type":"text","data":{"text":"<p>Well come You can build your profile page using page builder</p>","isHtml":true}}]}';


    $userID = getCurrentUserID($ci);
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
                'userRole'  => json_encode(array("2")),
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
        'email'                 => $email,
        'website'               => $website,
        'address_street_number' => $address_street_number,
        'address_street_name'   => $address_street_name,
        'address_town'          => $address_town,
        'address_state'         => $address_state,
        'address_post_code'     => $address_post_code,
        'business'              => $business,
        'corporate_date'        => $corporate_date,
        'added_date'            => $added_date,
        'expiry_date'           => $expiry_date,
        'acn_number'            => $acn_number,
        'business'              => $business,
        'short_description'     => $short_description,
       // 'long_description'      => $long_description,
        'keywords'              => $keywords,
        'ranking_score'         => $ranking_score,
         'Publish'              => $Publish,
        'template'              => $TemplateID,
        'date_created'          => $now,
        'date_updated'                => $now
       // 'businessShortDescriptionJSON'=> $p_json
    );
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
        $name  = $ci->input->post('name');
        $slug  = getAlias($name);
        if(checkSameSlugIsExistForListingID($ci,$slug,$ID) == true){
            $slug = $slug;
        }else{
            $slug = checkAndChangeIfAlreadyExistSlug($ci,$slug);
        }
        $Phone   = $ci->input->post('Phone');
        $email   = $ci->input->post('email');
        $website = $ci->input->post('website');
        // $Address = $ci->input->post('Address');
        $short_description      = $ci->input->post('short_description');
        //$long_description     = $ci->input->post('long_description');
        $keywords               = $ci->input->post('keywords');
        $ranking_score          = $ci->input->post('ranking_score');
       // $Publish              = $ci->input->post('Publish');
        $address_street_number  = $ci->input->post('address_street_number');
        $address_street_name    = $ci->input->post('address_street_name');
        $address_town           = $ci->input->post('address_town');
        $address_state          = $ci->input->post('address_state');
        $address_post_code      = $ci->input->post('address_post_code');
        $business               = $ci->input->post('business');
        $corporate_date         = $ci->input->post('corporate_date');
        $added_date             = $ci->input->post('added_date');
        $expiry_date            = $ci->input->post('expiry_date');
        $corporate_date         = $corporate_date ? date("Y-m-d",strtotime($corporate_date)) : $corporate_date = "";
        $added_date             = $added_date     ? date("Y-m-d",strtotime($added_date)): date("Y-m-d") ;
       // $expiry_date          = $expiry_date   ? date("Y-m-d",strtotime($expiry_date)): $expiry_date = "" ;
        if(!empty($corporate_date)){
            $corporate_year = explode("-",$corporate_date);
            $corporate_year = $corporate_year[0];
            if( $corporate_date > date("$corporate_year-06-30") && $corporate_date <= date("$corporate_year-12-31") ){
                $corporate_year +=5;
                $expiry_date = date("$corporate_year-06-30");
            }else if($corporate_date < date("$corporate_year-07-01") && $corporate_date >= date("$corporate_year-01-01") ){
                $corporate_year +=4;
                $expiry_date = date("$corporate_year-06-30");
            }
        }
        $acn_number     = $ci->input->post('acn_number');
        $TemplateID     = $ci->input->post('template');
        if(empty($name)){
            $error = "FAIL::".$ci->NameMessage." Name is a required field::error::Required!!";
            array_push($return, $error);
            return $return;
        }
        $showData  = getShowDataJson($ci);
        $now = date("Y-m-d H:i:s");
        $userID = getCurrentUserID($ci);
        $whereid       = array('id' => $ID);
        // Status code
        $prior_year_status      = $ci->Common_model->select_fields_where('esic',"status,prior_year_status,date_updated",$whereid,true);
        $current_year = date('Y');
        $c_date = date('Y-m-d');
        if( $c_date > date("$current_year-06-30") && $c_date <= date("$current_year-12-31") ){
            $current_year +=1;
        }else if($c_date < date("$current_year-07-01") && $c_date >= date("$current_year-01-01") ){
            $current_year = date('Y');
        }
        $append =  array(
            'year'   =>  $current_year,
            'status' => "1", // 1 for pending status
        );
        $prior_array = json_decode($prior_year_status->prior_year_status,true);
        if($prior_year_status->prior_year_status){ // chnage current year status into pending
            $prior_array = json_decode($prior_year_status->prior_year_status,true);
            $last_year   = $prior_array[0]['year'];
            if($current_year == $last_year){
                $prior_array[0]['status'] = 1; // updated current year status

            }else{                            // add new status and year at the start of array
                array_unshift($prior_array,$append); // append new array at 0 index
            }
        }else{
            $date = new DateTime($prior_year_status->date_updated);
            $previous_year =  $date->format('Y');
            if($current_year == $previous_year ){
                $prior_array = array();
                $prior_array =  array(
                    'year'   =>  $current_year,
                    'status' => 1, // 1 for pending status
                );
            }else{
                $prior_array = array(
                    'year'   =>  $previous_year,
                    'status' => $prior_year_status->status, // 1 for pending status
                );
                $prior_array = [$append,$prior_array];
            }
        }
       $myJSON = json_encode($prior_array);
      // Status code End
        $updateData = array(
            'name'                  => $name,
            'slug'                  => $slug,
            'email'                 => $email,
            'website'               => $website,
            'address_street_number' => $address_street_number,
            'address_street_name'   => $address_street_name,
            'address_town'          => $address_town,
            'address_state'         => $address_state,
            'address_post_code'     => $address_post_code,
            'business'              => $business,
            'acn_number'            => $acn_number,
            'business'              => $business,
            'short_description'     => $short_description,
            //'long_description'    => $long_description,
            'keywords'              => $keywords,
            'ranking_score'         => $ranking_score,
            'Publish'               => 1,//$Publish,
            'template'              => $TemplateID,
            'doShowItems'           => $showData,
            'date_updated'          => $now,
            'not_approve'           => 0,
            'prior_year_status'     => $myJSON
        );
        if(!empty($corporate_date)){$updateData['corporate_date'] = $corporate_date;}
        if(!empty($added_date)){$updateData['added_date'] = $added_date; }
        if(!empty($expiry_date)){$updateData['expiry_date'] = $expiry_date;}
        $where = array('id' => $ID);
        if(!isCurrentUserAdmin($ci)){
            $userID = getCurrentUserID($ci);
            $where['userID'] = $userID;
        }
        $updateData[$ci->listingField] = $ID;
        // get current esic version
        $selectField ="version, is_new_ver, logo, banner, productImage, userID, long_description, businessShortDescriptionJSON";
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
        $records = $ci->Common_model->select_fields_where($ci->versionTable, 'count(id) as Total, id, logo, banner, productImage, long_description, businessShortDescriptionJSON', $whereVer, true);
        if($isNewVer != 'Yes'){
            $updateData['logo'] = $version->logo;
            $updateData['banner'] = $version->banner;
            $updateData['productImage'] = $version->productImage;
        } else {
            $updateData['logo'] = $records->logo;
            $updateData['banner'] = $records->banner;
            $updateData['productImage'] = $records->productImage;
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
        else{
            $newVersion = $ci->Common_model->insert_record($ci->versionTable, $updateData);
            $verId = $newVersion;
        }
        // $updateResult = $ci->Common_model->update($ci->tableName,$where , $updateData);
        if($newVersion){
            $success =  "OK::Record Successfully Updated ID is ".$ID." ::success";
            array_push($return, $success);
            $isNewVer = 'Yes';
            // set new version true
            $ci->Common_model->update($ci->tableName, $where, array('is_new_ver'=>'Yes','status'=>'30'));
            //echo $ci->db->last_query();
            //exit;
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
        // $postData = $ci->input->post();
    }
    if($postData){
        //Getting Posted Inputs.
        $searchBoxValue = $postData['searchBox'];
        $locationSelect = $postData['locationSelect'];
        $orderByFilter = $postData['orderByFilter'];

//            $and = false;
        $whereParam = 'Publish = 1';
        $and = true;
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
                    $whereParam .= ' OR LOWER(address_state) LIKE "%'.$location.'%")';
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
            ES.*
            ',false);
    $where = 'trashed != 1';
    if($whereParam !== null and !empty($whereParam)){
        $where.= ' And '.$whereParam;
    }else{
        $whereParam = 'Publish = 1';
        $where.= ' And '.$whereParam;
    }
    $joins = array(
        array(
            'table' => 'esic_social ES',
            'condition' => 'ES.listingID = '.$ci->tableName.'.id',
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
            $orderByFilter  = $postData['orderByFilter'];
            // split search key into pieces, so that we can search related listings
            $searchKeys = str_split($searchBoxValue, 1);
            $searchKey = strtolower($searchBoxValue);
            $whereParam = 'Publish = 1';
            $and = true;
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
                        $whereParam .= ' OR LOWER(address_state) LIKE "%'.$location.'%")';
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
            ES.*
            ',false);
        $where = 'trashed != 1';
        if($whereParam !== null and !empty($whereParam)){
            $where.= ' And '.$whereParam;
        }
        $joins = array(
            array(
                'table' => 'esic_social ES',
                'condition' => 'ES.listingID = '.$ci->tableName.'.id',
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
    // print_r($whereParam); test
    // echo $ci->db->last_query();
    // exit;
    return $returnedData;
}
function ViewHelperDetail($alias, $newVer=''){
    $ci =& get_instance();
    $selectData = array('
            '.$ci->tableName.'.*,
            '.$ci->tableName.'.userID as currentUserID,
            '.$ci->tableName.'.id as ListID,
            states.name As address_state,
            SPC.postcode As address_post_code,
            ES.*
            ',false);
    $where = array(
        'slug' => $alias
    );
    if(!empty($newVer)) $where[$ci->tableName.'.id'] = $newVer;
    $joins = array(
        array(
            'table' => 'esic_social ES',
            'condition' => 'ES.listingID = '.$ci->tableName.'.id',
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
    $returnedData         = $ci->Common_model->select_fields_where_like_join($ci->tableName,$selectData,$joins,$where,true);
    $returnedData->id     = $returnedData->ListID;
    $returnedData->userID = $returnedData->currentUserID;
    return $returnedData;
}
function ViewHelperAdd($ci){ // fornt end form to add ESIC

    $ci->form_validation->set_rules('companyName', 'company Name', 'trim|required');
    $ci->form_validation->set_rules('businessName', 'businessName', 'trim');
    $ci->form_validation->set_rules('website', 'website', 'trim');
    $ci->form_validation->set_rules('address_town', 'Address town', 'trim');
    $ci->form_validation->set_rules('address_state', 'Address_state', 'trim');
    $ci->form_validation->set_rules('address_street_name', 'Address Street Name', 'trim');
    $ci->form_validation->set_rules('address_street_number', 'Address  Street Number', 'trim');
    $ci->form_validation->set_rules('short_description', 'Short Description', 'trim');
    if ($ci->form_validation->run() == FALSE)
    {
        echo 'FAIL::Sorry There has been An Error::error';
        return false;
    }else {
        $userID = $ci->input->post('userID');
        $name = $ci->input->post('companyName');
        $email = $ci->input->post('email');
        $business = $ci->input->post('businessName');
        $acn_number = $ci->input->post('acn_number');
        $website = $ci->input->post('website');
        $address_town = $ci->input->post('address_town');
        $address_state = $ci->input->post('address_state');
        $address_post_code = $ci->input->post('address_post_code');
        $address_street_name = $ci->input->post('address_street_name');
        $address_street_number = $ci->input->post('address_street_number');

        $short_description = $ci->input->post('short_description');

        if (!empty($userID)) {
            $slug = getAlias($name);
            $slug = checkAndChangeIfAlreadyExistSlug($ci, $slug);
            if (empty($email)) {
                $email = getUserCurrentEmail($ci, $userID);
            }
            $listingData = array(
                'userID' => $userID,
                'name' => $name,
                'slug' => $slug
            );
            if (!empty($email)) {
                $listingData['email'] = $email;
            }
            if (!empty($business)) {
                $listingData['business'] = $business;
            }
            if (!empty($website)) {
                $listingData['website'] = $website;
            }
            if (!empty($address_town)) {
                $listingData['address_town'] = $address_town;
            }
            if (!empty($address_state)) {
                $listingData['address_state'] = $address_state;
            }
            if (!empty($address_post_code)) {
                $listingData['address_post_code'] = $address_post_code;
            }
            if (!empty($address_street_name)) {
                $listingData['address_street_name'] = $address_street_name;
            }
            if (!empty($address_street_number)) {
                $listingData['address_street_number'] = $address_street_number;
            }
            if (!empty($short_description)) {
                $listingData['short_description'] = $short_description;
            }
            if (!empty($acn_number)) {
                $listingData['acn_number'] = $acn_number;
            }
            $added_date = date('Y-m-d H:i:s');
            $listingData['added_date'] = $added_date;
            $listingID = createNewListing($ci, $listingData);
            $previewBtn = true;
            if (!empty($listingID)) {
                addRoleToUser($ci);
                echo 'OK::Esic Listing Added::success::' . $listingID . '::' . $previewBtn;
                return false;
            }
            echo 'FAIL::Sorry There has been Error In Esic Listing::error';
            return false;
        }
    }
    echo 'FAIL::Sorry There has been An Error::error';
    return false;
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
    $whereFilter        = 'address_state IS NOT NULL';
    $groupBy            = 'address_town';
    $locationTown       = $ci->Common_model->select_fields_where($ci->tableName,$selectFilterData,$whereFilter,false, '','','',$groupBy);
    $return['Locations']['towns'] = $locationTown;
    return $return;
}
function ViewHelperSaveQuestionsAnswers($ci){
    $userID    = $ci->input->post('userID');
    $listingID = $ci->input->post('listingID');
    SaveUserListingQuestionAnwers($ci, $listingID);
}
function ViewHelperGetPreview($ci,$listingID){
    $where = array('id' => $listingID);
    $data = $ci->Common_model->select_fields_where($ci->tableName,'*',$where,true);
    return $data;
}
// manage previous status
function managePrevStatus($ci){
    $year_post  = $ci->input->post('year');
    if($ci->tableName == 'esic') $listing_type = $ci->QuestionListingID;
    $tbl = 'listing_status';
    //$where = array('listing_type'=>$listing_type);
    $where = 'listing_type = '.$listing_type;
        if(!empty($year_post)){
            $where.= ' AND status_date LIKE "%'.$year_post.'%" ';
        }
    $selectData = array('
                    '.$tbl.'.id AS ID,
                    '.$tbl.'.prev_status AS PrevStatus,
                    '.$tbl.'.status_date AS Date,
                    '.$ci->tableName.'.name AS Name');
    $joins = array(
        array(
            'table' => $ci->tableName,
            'condition' => $ci->tableName.'.id = '.$tbl.'.listing_id',
            'type' => 'LEFT'
        )
    );
    if($ci->tableName == 'esic'){
        array_push($joins, array(
            'table' => 'esic_status ES',
            'condition' => 'ES.id = '.$tbl.'.prev_status',
            'type' => 'LEFT'
        ));
        $selectData[0] = $selectData[0].', ES.status AS Status';
    }
    $addColumns = array(
        'ViewEditActionButtons' => array('<a onclick="restoreStatus(\''.$ci->Name.'\', $1)"><span data-toggle="tooltip" title="Restore Status For This Listing" data-placement="left" aria-hidden="true" class="fa fa-undo text-blue"></span></a> &nbsp; <a href="#" data-target=".confirm-modal" data-toggle="modal" data-id="$1"><i data-toggle="tooltip" title="Trashed" data-placement="right"  class="fa fa-trash-o text-red"></i></a>','ID')
    );
    $result = $ci->Common_model->select_fields_joined_DT($selectData, $tbl, $joins, $where ,'','','',$addColumns);
    printListingResult($result);
    return null;
}
?>
