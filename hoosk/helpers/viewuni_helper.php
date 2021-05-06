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
                    $where = array('userID' => $userID);    
                    $Actions = '';  
                }else{
                    $Actions = '<a href="#" data-target=".publish-modal" data-toggle="modal"><i data-toggle="tooltip" title="Publish Status" data-placement="right"  class="fa fa-check text-blue"></i></a> &nbsp;';
                }
                $selectData = array('
                id AS ID,
                institution AS Name,
                phone AS Phone,
                website AS Website,
                email AS email, 
                logo AS Logo,
                Publish as PublishStatusID,
                CASE WHEN Publish = 1 THEN CONCAT(\'<span class="label label-success">YES</span>\') WHEN Publish = 0 THEN CONCAT(\'<span class="label label-danger">NO</span>\') ELSE "" END AS Publish,
                CASE WHEN trashed = 1 THEN CONCAT(\'<span class="label label-danger">YES</span>\') WHEN trashed = 0 THEN CONCAT(\'<span class="label label-success">NO</span>\') ELSE "" END AS Trashed
                ',false);

                $addColumns = array(
                    'ViewEditActionButtons' => array($Actions.
                        '<a href="'.base_url().$ci->Name.'/Edit/$1"><span data-toggle="tooltip" title="Edit" data-placement="left" aria-hidden="true" class="fa fa-pencil text-blue"></span></a> &nbsp; <a href="#" data-target=".approval-modal" data-toggle="modal"><i data-toggle="tooltip" title="Trash" data-placement="right"  class="fa fa-trash-o text-red"></i></a>','ID')
                );
                $returnedData = $ci->Common_model->select_fields_joined_DT($selectData,$ci->tableName,'','','','','',$addColumns);

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
        if(checkRoleHasPermission($ci,$ci->Name.' New') == true){
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
            $Phone   = $ci->input->post('Phone');
            $Email   = $ci->input->post('Email');
            $Website = $ci->input->post('Website');

            $Address            = $ci->input->post('address');
            $Suburb             = $ci->input->post('suburb');
            $State              = $ci->input->post('state');
            $Post_code          = $ci->input->post('post_code');

            $roleDepartment                 = $ci->input->post('roleDepartment');
            $programDescription             = $ci->input->post('programDescription');
            $programEligibilityCriteria     = $ci->input->post('programEligibilityCriteria');
            $ProgramStartDate               = $ci->input->post('ProgramStartDate');

            $contactName        = $ci->input->post('contactName');


            if(empty($Name)){
                $error = "FAIL::".$ci->NameMessage." Name is a required field::error::Required!!";
                array_push($return, $error);
                return $return;
            }
            $NameExist = checkListingExist($ci, $Name, 'institution');
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
            }
            $now = date("Y-m-d H:i:s");
            $insertData = array(
                'institution'           => $Name,
                'slug'                  => $slug,
                'phone'                 => $Phone,
                'email'                 => $Email,
                'website'               => $Website,
                'address'               => $Address,
                'suburb'                => $Suburb,
                'state'                 => $State,
                'post_code'             => $Post_code,
                'roleDepartment'        => $roleDepartment,
                'programDescription'    => $programDescription,
                'programEligibilityCriteria'  => $programEligibilityCriteria,
                'ProgramStartDate'      => date('Y-m-d',strtotime($ProgramStartDate)),
                'contactName'           => $contactName,
                'date_created'          => $now,
                'date_updated'          => $now
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
        return false;
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
            $Phone   = $ci->input->post('Phone');
            $Email   = $ci->input->post('Email');
            $Website = $ci->input->post('Website');

            $Address            = $ci->input->post('address');
            $Suburb             = $ci->input->post('suburb');
            $State              = $ci->input->post('state');
            $Post_code          = $ci->input->post('post_code');

            $roleDepartment                 = $ci->input->post('roleDepartment');
            $programDescription             = $ci->input->post('programDescription');
            $programEligibilityCriteria     = $ci->input->post('programEligibilityCriteria');
            $ProgramStartDate               = $ci->input->post('ProgramStartDate');

            $contactName        = $ci->input->post('contactName');

            if(empty($Name)){
                $error = "FAIL::".$ci->NameMessage." Name is a required field::error::Required!!";
                array_push($return, $error);
                return $return;
            }
            $NameExist = checkListingExist($ci, $Name, 'institution', $ID);
            if($NameExist == true){
                $error =  "FAIL::".$ci->NameMessage." Name Already Exist Cannot Edit, Please Contact Administrator::error";
                array_push($return, $error);
                return $return;
            }
            $EmailExist = checkListingExist($ci, $Email, 'email', $ID);
            if($EmailExist == true){
                $error =  "FAIL::".$ci->NameMessage." Email Already Exist Cannot Edit, Please Contact Administrator::error";
                array_push($return, $error);
                return $return;
            }
            $now = date("Y-m-d H:i:s");
            $updateData = array(
                'institution'           => $Name,
                'slug'                  => $slug,
                'phone'                 => $Phone,
                'email'                 => $Email,
                'website'               => $Website,
                'address'               => $Address,
                'suburb'                => $Suburb,
                'state'                 => $State,
                'post_code'             => $Post_code,
                'roleDepartment'        => $roleDepartment,
                'programDescription'    => $programDescription,
                'programEligibilityCriteria'  => $programEligibilityCriteria,
                'ProgramStartDate'      => date('Y-m-d',strtotime($ProgramStartDate)),
                'contactName'           => $contactName,
                'date_updated'          => $now
            );
           
            $where = array('id' => $ID);
            if(!isCurrentUserAdmin($ci)){
                $userID = getCurrentUserID($ci);
                $where['userID'] = $userID;    
            }
            $updateResult = $ci->Common_model->update($ci->tableName,$where , $updateData);
            
            if($updateResult){
                $success =  "OK::Record Successfully Updated ID is ".$ID." ::success";
                array_push($return, $success);
            }else{
                $error =  "FAIL::Record Not Updated::error";
                array_push($return, $error);
                return $return;
            }

            $notes = uploadImagesAction($ci,$ID);
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
            $roleDepartmentSelectFilter = $postData['roleDepartment_select'];
            $orderByFilter = $postData['orderByFilter'];
            $contactNameFilter = $postData['contactNameFilter'];

            $whereParam = 'Publish = 1';
            $and = true;
            if(!empty($searchBoxValue)){
                if ($and === true and !empty($whereParam)) {
                    $whereParam .= ' AND ';
                }
                $whereParam .= '(LOWER('.$ci->tableName.'.`institution`) LIKE "%'.strtolower($searchBoxValue).'%")';
//                $whereParam .= ' OR LOWER(`website`) LIKE "%'.strtolower($searchBoxValue).'%")';
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
                        $whereParam .= '( LOWER(address) LIKE "%'.$location.'%")';
                    }
                    $count++;
                }//End of Foreach
                $whereParam .=') ';
                $and = true;
            }//End of If Not Empty Statement

            if (!empty($roleDepartmentSelectFilter)) {
                if ($and === true and !empty($whereParam)) {
                    $whereParam .= ' AND ';
                }
                $whereParam .=' (';
                $count = 0;
                foreach($roleDepartmentSelectFilter as $roleDepartment){
                    if($count > 0){
                        $whereParam .= ' OR ';
                    }
                    if(!empty($roleDepartment)){
                        $whereParam .= '( LOWER(roleDepartment) LIKE "%'.$roleDepartment.'%")';
                    }
                    $count++;
                }//End of Foreach
                $whereParam .=') ';
                $and = true;
            }//End of If Not Empty Statement

            if(!empty($contactNameFilter)){
                if ($and === true and !empty($whereParam)) {
                    $whereParam .= ' AND ';
                }
                $whereParam .= '(LOWER('.$ci->tableName.'.`contactName`) LIKE "%'.strtolower($contactNameFilter).'%")';
            }

            if(!empty($orderByFilter)){
                $filterType = $orderByFilter;
                unset($orderByFilter);
                $orderByFilter = [$ci->tableName.'.institution', $filterType];
            }
        }//End of If post exist Statement
        $selectData = array('
            '.$ci->tableName.'.*,
            insS.*
            ',false);
        $where = 'trashed != 1';
        if($whereParam !== null and !empty($whereParam)){
            $where.= ' And '.$whereParam;
        }
        $joins = array(
            array(
                'table' => 'institution_social insS',
                'condition' => 'insS.listingID = '.$ci->tableName.'.id',
                'type' => 'LEFT'
            )
        );
        if(isset($orderByFilter) and !empty($orderByFilter)){
            $orderBy = $orderByFilter;
        }else{
            $orderBy ='RAND()';
        }
        $returnedData = $ci->Common_model->select_fields_where_like_join($ci->tableName,$selectData,$joins,$where,false,'','','',$orderBy);
        return $returnedData;   
    }
    function ViewHelperDetail($alias){
        $ci =& get_instance();
        $selectData = array('
            '.$ci->tableName.'.*,
            insS.*
            ',false);
        $where = array(
            'slug' => $alias
        );
        $joins = array(
            array(
                'table' => 'institution_social insS',
                'condition' => 'insS.listingID = '.$ci->tableName.'.id',
                'type' => 'LEFT'
            )
        );
        $returnedData = $ci->Common_model->select_fields_where_like_join($ci->tableName,$selectData,$joins,$where,true);
        return $returnedData;
    }

    function getListingFilters(){
        $ci =& get_instance();
        $return['Locations'] = [];
        $return['roleDepartment'] = [];
        $return['contactNames'] = [];
        //Getting the States.
        $selectFilterData = [
            'address as name'
        ];
        $whereFilter = 'address IS NOT NULL';
        $groupBy = 'address';
        $locationState = $ci->Common_model->select_fields_where($ci->tableName,$selectFilterData,$whereFilter,false, '','','',$groupBy);
        $return['Locations']['addresses'] = $locationState;


        //Getting the Roles/Departments.
        $selectFilterData = [
            'roleDepartment as name'
        ];
        $whereFilter = 'roleDepartment IS NOT NULL';
        $groupBy = 'roleDepartment';
        $roleDepartments = $ci->Common_model->select_fields_where($ci->tableName,$selectFilterData,$whereFilter,false, '','','',$groupBy);
        $return['roleDepartment'] = $roleDepartments;

        //Getting the Contact Names.
        $selectFilterData = [
            'contactName as name'
        ];
        $whereFilter = 'contactName IS NOT NULL';
        $groupBy = 'contactName';
        $contactNames = $ci->Common_model->select_fields_where($ci->tableName,$selectFilterData,$whereFilter,false, '','','',$groupBy);
        $return['contacts'] = $contactNames;

        return $return;
    }
?>
