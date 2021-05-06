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
                Member AS Member,
                Web_Address AS Web_Address,
                Project_Title AS Project_Title,
                Project_Location AS Project_Location,
                State_Territory AS State_Territory,
                logo AS Logo,
                Publish as PublishStatusID,
                CASE WHEN Publish = 1 THEN CONCAT(\'<span class="label label-success">YES</span>\') WHEN Publish = 0 THEN CONCAT(\'<span class="label label-danger">NO</span>\') ELSE "" END AS Publish,
                CASE WHEN trashed = 1 THEN CONCAT(\'<span class="label label-danger">YES</span>\') WHEN trashed = 0 THEN CONCAT(\'<span class="label label-success">NO</span>\') ELSE "" END AS Trashed
                ',false);

                $addColumns = array(
                    'ViewEditActionButtons' => array($Actions.
                        '<a href="'.base_url().$ci->Name.'/Edit/$1"><span data-toggle="tooltip" title="Edit" data-placement="left" aria-hidden="true" class="fa fa-pencil text-blue"></span></a> &nbsp; <a href="#" data-target=".approval-modal" data-toggle="modal"><i data-toggle="tooltip" title="Trash" data-placement="right"  class="fa fa-trash-o text-red"></i></a>','ID')
                );
                $returnedData = $ci->Common_model->select_fields_joined_DT($selectData,$ci->tableName,'',$where,'','','',$addColumns);
                
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
            $Member            = $ci->input->post('Member');
            $slug = getAlias($Member);
            $slug = checkAndChangeIfAlreadyExistSlug($ci,$slug);
            $Web_Address       = $ci->input->post('Web_Address');
            $Project_Title     = $ci->input->post('Project_Title');

            $Project_Location       = $ci->input->post('Project_Location');
            $State_Territory        = $ci->input->post('address_state');
            $postal_code            = $ci->input->post('address_post_code');

            $Project_Summary   = $ci->input->post('Project_Summary');
            $Market            = $ci->input->post('Market');
            $Technology        = $ci->input->post('Technology');
            $short_description = $ci->input->post('short_description');
            $long_description  = $ci->input->post('long_description');

            if(empty($Member)){
                $error = "FAIL::".$ci->NameMessage." Name is a required field::error::Required!!";
                array_push($return, $error);
                return $return;
            }
            /*$NameExist = checkListingExist($ci, $Member, 'Member');
            if($NameExist == true){
                $error =  "FAIL::".$ci->NameMessage." Member Already Exist Cannot Create New Please Contact Administrator::error";
                array_push($return, $error);
                return $return;
            }
            $Web_AddressExist = checkListingExist($ci, $Web_Address ,'Web_Address');
            if($Web_AddressExist == true){
                $error =  "FAIL::".$ci->NameMessage." Website Already Exist Cannot Create New Please Contact Administrator::error";
                array_push($return, $error);
                return $return;
            }*/
            $now = date("Y-m-d H:i:s");
            $insertData = array(
                'Member'            => $Member,
                'slug'              => $slug,
                'Web_Address'       => $Web_Address,
                'Project_Location'  => $Project_Location,
                'State_Territory'   => $State_Territory,
                'postal_code'       => $postal_code,
                'Project_Title'     => $Project_Title,
                'Project_Summary'   => $Project_Summary,
                'Market'            => $Market,
                'Technology'        => $Technology,
                'short_description' => $short_description,
                'long_description'  => $long_description,
                'date_created'      => $now,
                'date_updated'      => $now
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
            $Member = $ci->input->post('Member');
            $slug   = getAlias($Member);
            if(checkSameSlugIsExistForListingID($ci,$slug,$ID) == true){
                $slug = $slug;
            }else{
                $slug = checkAndChangeIfAlreadyExistSlug($ci,$slug);
            }
            $Web_Address       = $ci->input->post('Web_Address');
            $Project_Title     = $ci->input->post('Project_Title');

            $Project_Location  = $ci->input->post('Project_Location');
            $State_Territory   = $ci->input->post('address_state');
            $postal_code       = $ci->input->post('address_post_code');

            $Project_Summary   = $ci->input->post('Project_Summary');
            $Market            = $ci->input->post('Market');
            $Technology        = $ci->input->post('Technology');
            $short_description = $ci->input->post('short_description');
            $long_description  = $ci->input->post('long_description');

            if(empty($Member)){
                $error = "FAIL::".$ci->NameMessage." Name is a required field::error::Required!!";
                array_push($return, $error);
                return $return;
            }
            $NameExist = checkListingExist($ci, $Member, 'Member', $ID);
            if($NameExist == true){
                $error =  "FAIL::".$ci->NameMessage." Member Already Exist Cannot Edit Please Contact Administrator::error";
                array_push($return, $error);
                return $return;
            }
            /*$Web_AddressExist = checkListingExist($ci, $Web_Address ,'Web_Address', $ID);
            if($Web_AddressExist == true){
                $error =  "FAIL::".$ci->NameMessage." Website Already Exist Cannot Edit Please Contact Administrator::error";
                array_push($return, $error);
                return $return;
            }*/
            $now = date("Y-m-d H:i:s");
            $updateData = array(
                'Member'            => $Member,
                'slug'              => $slug,
                'Web_Address'       => $Web_Address,
                'Project_Location'  => $Project_Location,
                'State_Territory'   => $State_Territory,
                'postal_code'       => $postal_code,
                'Project_Title'     => $Project_Title,
                'Project_Summary'   => $Project_Summary,
                'Market'            => $Market,
                'Technology'        => $Technology,
                'short_description' => $short_description,
                'long_description'  => $long_description,
                'date_updated'      => $now
            );

            $where = array('id' => $ID);
            if(!isCurrentUserAdmin($ci)){
                $userID = getCurrentUserID($ci);
                $where['userID'] = $userID;
            }
            $updateResult = $ci->Common_model->update($ci->tableName,$where , $updateData);

            if($updateResult){
                $success =  "OK::Record Successfully Updated ID is ".$ID." ::success::".$ID;
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
           //$postData = $ci->input->post();
        }
        if($postData){
            //Getting Posted Inputs.
            $searchBoxValue = $postData['searchBox'];
            $locationSelect = $postData['locationSelect'];
            $marketSelect = $postData['Market'];
            $projectTitleValue = $postData['projectTitle'];
            $TechnologySelect = $postData['Technology'];
            $orderByFilter = $postData['orderByFilter'];

            $and = false;
            $whereParam = 'Publish = 1';
            if(!empty($searchBoxValue)){
                if ($and === true and !empty($whereParam)) {
                    $whereParam .= ' AND ';
                }
                $whereParam .= '(LOWER('.$ci->tableName.'.`Member`) LIKE "%'.strtolower($searchBoxValue).'%"';
                $whereParam .= ' OR LOWER(`Web_Address`) LIKE "%'.strtolower($searchBoxValue).'%")';
                $and = true;
            } //End of If Search Box Value.

            if(!empty($projectTitleValue)){
                $whereParam .= '(LOWER('.$ci->tableName.'.`Project_Title`) LIKE "%'.strtolower($projectTitleValue).'%"';
                $whereParam .= ' OR LOWER(`Project_Summary`) LIKE "%'.strtolower($projectTitleValue).'%")';
                $and = true;
            } //End of if Not Empty Project Title

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
                        $whereParam .= '( LOWER(Project_Location) LIKE "%'.$location.'%"';
                        $whereParam .= ' OR LOWER(State_Territory) LIKE "%'.$location.'%")';
                    }
                    $count++;
                }//End of Foreach
                $whereParam .=') ';
                $and = true;
            }//End of If Not Empty Statement

            if(!empty($marketSelect)){
                if ($and === true and !empty($whereParam)) {
                    $whereParam .= ' AND ';
                }
                $whereParam .=' (';
                $count = 0;
                foreach($marketSelect as $market){
                    if($count > 0){
                        $whereParam .= ' OR ';
                    }
                    if(!empty($market)){
                        $whereParam .= '( LOWER(Market) LIKE "%'.$market.'%")';
                    }
                    $count++;
                }//End of Foreach
                $whereParam .=') ';
                $and = true;
            } //End of Market Select.

            if(!empty($TechnologySelect)){
                if ($and === true and !empty($whereParam)) {
                    $whereParam .= ' AND ';
                }
                $whereParam .=' (';
                $count = 0;
                foreach($TechnologySelect as $technology){
                    if($count > 0){
                        $whereParam .= ' OR ';
                    }
                    if(!empty($technology)){
                        $whereParam .= '( LOWER(Technology) LIKE "%'.$technology.'%")';
                    }
                    $count++;
                }//End of Foreach
                $whereParam .=') ';
                $and = true;
            } //End of Technology Select.

            if(!empty($orderByFilter)){
                $filterType = $orderByFilter;
                unset($orderByFilter);
                $orderByFilter = [$ci->tableName.'.name', $filterType];
            } //End of Order Filter.
        }//End of If post exist Statement
        $selectData = array('
            '.$ci->tableName.'.*',false);
        $where = 'trashed != 1';
        if($whereParam !== null and !empty($whereParam)){
            $where.= ' And '.$whereParam;
        }
        $joins = array(
            array(
                'table' => 'acceleration_social ACCS',
                'condition' => 'ACCS.listingID = '.$ci->tableName.'.id',
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

    function getListingFilters(){
        $ci =& get_instance();
        $return['Locations'] = [];
        $return['Markets'] = [];
        $return['Technology'] = [];

        //Getting the States.
        $selectFilterData = [
            'State_Territory as name'
        ];
        $whereFilter = 'State_Territory IS NOT NULL';
        $groupBy = 'State_Territory';
        $Territories = $ci->Common_model->select_fields_where($ci->tableName,$selectFilterData,$whereFilter,false, '','','',$groupBy);
        $return['Locations']['Territories'] = $Territories;

        //Getting the Address Town
        $selectFilterData = [
            'Project_Location as name'
        ];
        $whereFilter = 'Project_Location IS NOT NULL';
        $groupBy = 'Project_Location';
        $PLocations = $ci->Common_model->select_fields_where($ci->tableName,$selectFilterData,$whereFilter,false, '','','',$groupBy);
        $return['Locations']['PLocations'] = $PLocations;

        //Getting the Address Town
        $selectFilterData = [
            'Market as name'
        ];
        $whereFilter = 'Market IS NOT NULL';
        $groupBy = 'Market';
        $Markets = $ci->Common_model->select_fields_where($ci->tableName,$selectFilterData,$whereFilter,false, '','','',$groupBy);
        $return['Markets'] = $Markets;

        //Getting the $Technologies
        $selectFilterData = [
            'Technology as name'
        ];
        $whereFilter = 'Technology IS NOT NULL';
        $groupBy = 'Technology';
        $Technologies = $ci->Common_model->select_fields_where($ci->tableName,$selectFilterData,$whereFilter,false, '','','',$groupBy);
        $return['Technologies'] = $Technologies;

        return $return;
    }
    function ViewHelperDetail($alias){
        $ci =& get_instance();
        $selectData = array('
            '.$ci->tableName.'.*',false);
        $where = array(
            'slug' => $alias
        );
        $joins = array(
            array(
                'table' => 'acceleration_social ACCS',
                'condition' => 'ACCS.listingID = '.$ci->tableName.'.id',
                'type' => 'LEFT'
            )
        );
        $returnedData = $ci->Common_model->select_fields_where_like_join($ci->tableName,$selectData,$joins,$where,true);
        return $returnedData;   
    }

?>
