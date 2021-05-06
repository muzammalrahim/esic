<?php 

/**
 * @function loadDefautParamActions 
 */
if(!function_exists('loadDefautParamActions')){
    function loadDefautParamActions($ci,$param){
        if($param === 'trash'){
            if(!$ci->input->post()){
                echo "FAIL::No Value Posted::error";
                return false;
            }

            $id     = $ci->input->post('id');
            $value  = $ci->input->post('value');

            if(empty($id) or !is_numeric($id)){
                echo "FAIL::Posted values are not VALID::error::Invalid POST Values";
                return NULL;
            }

            if(empty($value)){
                echo "FAIL::Posted values are not VALID::error::Invalid POST Values";
                return NULL;
            }
            $data='';
            if($value == 'trash'){
                $data = 1;
                $trashedMessageSuccess = "Record has been successfully Trashed";
                $trashedMessageDuplicate = "Record Has Already Been Trashed";
            }else if($value == 'untrash'){
                $data = 0;
                $trashedMessageSuccess = "Record has been successfully Un-Trashed";
                $trashedMessageDuplicate = "Record Has Already Been Un-Trashed";
            }else{
                $data = 2;
                $trashedMessageSuccess = "Record has been successfully Processed";
            }

            $updateData = array(
                'trashed' => $data
            );

            $whereUpdate = array(
                'id' => $id
            );

            $returnedData = $ci->Common_model->update($ci->tableName,$whereUpdate,$updateData);
            if($returnedData === true){
                echo "OK::".$trashedMessageSuccess."::success::SUCCESS!!";
            }else{
                if($returnedData['code'] === 0){
                    echo "OK::".$trashedMessageDuplicate."::warning::QUERY FAILED";
                    return false;
                }else{
                    echo "FAIL::".$returnedData['message']."::error::DB Message";
                }

            }
            return NULL;
        }
        if($param === 'delete'){
            if(!$ci->input->post()){
                echo "FAIL::No Value Posted";
                return false;
            }

            $id = $ci->input->post('id');
            $value = $ci->input->post('value');

            if(empty($id) or !is_numeric($id)){
                echo "FAIL::Posted values are not VALID";
                return NULL;
            }

            if(empty($value)){
                echo "FAIL::Posted values are not VALID";
                return NULL;
            }
            if($value == 'delete'){

                $whereListingDelete = array(
                    'id' => $id
                );
                $whereSocialDelete = array(
                    'listingID' => $id
                );
                $ci->Common_model->delete($ci->tableName,$whereListingDelete);
                $ci->Common_model->delete($ci->tableNameSocial,$whereSocialDelete);
                echo "OK::Record Deleted::success";
            }else{
                echo "FAIL::Record Not Deleted::error";
            }
            return NULL;
        }
        if($param === 'updateLogo'){
            $LogoDbField       = $ci->LogoDbField;
            $LogoNamePrefix    = $ci->LogoNamePrefix;
            $ID                = $ci->input->post('id');
            $allowedExt        = array('jpeg','jpg','png','gif');
            $uploadPath        = './pictures/logos/'.$ci->ImagesFolderName.'/'.$ID;
            $uploadDirectory   = './pictures/logos/'.$ci->ImagesFolderName.'/'.$ID;
            $uploadDBPath      = 'pictures/logos/'.$ci->ImagesFolderName.'/'.$ID;
            $insertDataArray   = array();
            //For Logo Upload
            if(isset($_FILES['logo']['name'])){
                $FileName           = $_FILES['logo']['name'];
                $explodedFileName   = explode('.',$FileName);
                $ext                = end($explodedFileName);

                if(!in_array(strtolower($ext),$allowedExt)){
                    echo "FAIL:: Only Image JPEG, PNG and GIF Images Allowed, No Other Extensions Are Allowed::error";
                    return;
                }else{

                    $FileName = $LogoNamePrefix.'_'.$ID.'_'.time().'.'.$ext;
                    if(!is_dir($uploadDirectory)){
                        mkdir($uploadDirectory, 0755, true);
                    }

                    move_uploaded_file($_FILES['logo']['tmp_name'],$uploadPath.'/'.$FileName);
                    $insertDataArray[$LogoDbField] = $uploadDBPath.'/'.$FileName;
                }
            }else{
                echo "FAIL::Logo Image Is Required::error";
                return;
            }

            if(empty($ID)){
                echo "FAIL::Something went wrong with the Post, Please Contact System Administrator For Further Assistance (Error Code: 10115)::error";
                exit;
            }

                $selectData = array(
                    $LogoDbField.' AS logo'
                    ,false);
                $where = array( 'id' => $ID );
                $returnedData = $ci->Common_model->select_fields_where($ci->tableName,$selectData, $where, true, '', '', '','','',false);
                $logo = $returnedData->logo;
            if(!empty($logo) && is_file(FCPATH.'/'.$logo)){
                unlink('./'.$logo);
            }
                $resultUpdate = $ci->Common_model->update($ci->tableName,$where,$insertDataArray);
            if($resultUpdate === true){
                echo "OK::Logo Updated Successfully::success";
                $ci->load->model('Imagecreate_model');
                //Create the Respective Images.
                $ci->Imagecreate_model->createimage($insertDataArray[$LogoDbField]);
            }else{
                echo "FAIL::Something went wrong during Update, Please Contact System Administrator (Error Code: 10115)::error";
            }
            return NULL;
        }
        if($param === 'updateBanner'){
            $BannerDbField     = $ci->BannerDbField;
            $BannerNamePrefix    = $ci->BannerNamePrefix;
            $ID                = $ci->input->post('id');
            $allowedExt        = array('jpeg','jpg','png','gif');
            $uploadPath        = './pictures/logos/'.$ci->ImagesFolderName.'/'.$ID;
            $uploadDirectory   = './pictures/logos/'.$ci->ImagesFolderName.'/'.$ID;
            $uploadDBPath      = 'pictures/logos/'.$ci->ImagesFolderName.'/'.$ID;
            $insertDataArray   = array();
            //For Logo Upload
            if(isset($_FILES['banner']['name'])){
                $FileName           = $_FILES['banner']['name'];
                $explodedFileName   = explode('.',$FileName);
                $ext                = end($explodedFileName);

                if(!in_array(strtolower($ext),$allowedExt)){
                    echo "FAIL:: Only Image JPEG, PNG and GIF Images Allowed, No Other Extensions Are Allowed::error";
                    return;
                }else{

                    $FileName = $BannerNamePrefix.'_'.$ID.'_'.time().'.'.$ext;
                    if(!is_dir($uploadDirectory)){
                        mkdir($uploadDirectory, 0755, true);
                    }

                    move_uploaded_file($_FILES['banner']['tmp_name'],$uploadPath.'/'.$FileName);
                    $insertDataArray[$BannerDbField] = $uploadDBPath.'/'.$FileName;
                }
            }else{
                echo "FAIL::Banner Image Is Required::error";
                return;
            }

            if(empty($ID)){
                echo "FAIL::Something went wrong with the Post, Please Contact System Administrator For Further Assistance (Error Code: 10115)::error";
                exit;
            }
                $selectData = array(
                    $BannerDbField.' AS banner'
                    ,false);
                $where = array( 'id' => $ID );
                $returnedData = $ci->Common_model->select_fields_where($ci->tableName,$selectData, $where, false, '', '', '','','',false);
                $banner = $returnedData[0]->banner;
            if(!empty($banner) && is_file(FCPATH.'/'.$banner)){
                unlink('./'.$banner);
            }
                $resultUpdate = $ci->Common_model->update($ci->tableName,$where,$insertDataArray);
            if($resultUpdate === true){
                echo "OK::Banner Updated Successfully::success";
            }else{
                echo "FAIL::Something went wrong during Update, Please Contact System Administrator (Error Code: 10115)::error";
            }
            return NULL;
        }
        if($param === 'PublishAction'){
            if(!$ci->input->post()){
                echo "FAIL::Oops Something Went Wrong (Error Code: 10404)::error";
                return false;
            }
            $id     = $ci->input->post('id');
            $actionPerform  = $ci->input->post('actionPerform');
            $currentValue  = $ci->input->post('currentValue');
            $publishValue = '0';
            if($actionPerform == 'publish'){
                $publishValue = 1;
            }
            $whereUpdate = array('id' => $id);
            $updateData  = array('Publish' => $publishValue);
            $returnedData = $ci->Common_model->update($ci->tableName,$whereUpdate,$updateData);
            if($returnedData === true){
                echo "OK:: Publish Status Changed ::success::SUCCESS!!";
            }else{
                if($returnedData['code'] === 0){
                    echo "OK::Its is Already Same ::warning::QUERY FAILED";
                    return false;
                }else{
                    echo "FAIL:: Publish Status Cannot Change Due To".$returnedData['message']."::error::DB Message";
                }

            }
            return NULL;
        }
        if($param === 'PreviewContent'){
                $postData['post'] = $ci->input->get();
                $postData['file'] = $_FILES;
                echo json_encode($postData);
            return NULL;
        }
        if($param === 'PreviewSubmitContent'){

                $withHeaders = $ci->input->post('withHeaders');
                $ci->data['detail'] = json_decode(json_encode($ci->input->post()));
                $ci->data['file'] = $_FILES;
                $ci->data['PageBuilderContent'] = $ci->Hoosk_model->ShowPageDescriptionPreview();
                if(empty($ci->data['detail']->long_description)){
                    $ci->data['detail']->long_description =  $ci->data['PageBuilderContent']['long_description'];
                }
            $ci->data['detail']->showPreview = true;
                $ci->data['bodyClasses'] .= ' database-listing listing-detail pageBuilder';
                if(!empty($ci->data['detail']->template)){
                    $templateFileName = getTemplateFileName($ci,$ci->data['detail']->template);
                    if(!empty($templateFileName)){
                        if($withHeaders == false){
                            $ci->show_view_without_head('listing/default/frontend/templates/'.$templateFileName,$ci->data);
                        }else{
                             $ci->show_view('listing/default/frontend/templates/'.$templateFileName,$ci->data);
                        }
                    }else{
                        if($withHeaders == false){
                            $ci->show_view_without_head('listing/'.$ci->ViewFolderName.'/frontend/templates/default',$ci->data);
                        }else{
                            $ci->show_view('listing/'.$ci->ViewFolderName.'/frontend/templates/default',$ci->data);
                        }
                    }
                }
            return NULL;
        }
        if($param === 'PreviewSubmitContentWOPB'){
                $withHeaders = $ci->input->post('withHeaders');
                $ci->data['detail'] = json_decode(json_encode($ci->input->post()));
                $ci->data['file'] = $_FILES;
                $ci->data['PageBuilderContent'] = $ci->Hoosk_model->ShowPageDescriptionPreview();
                $ci->data['bodyClasses'] .= ' database-listing listing-detail pagebuilder';
                $ci->data['detail']->showPreview = true;
                if(!empty($ci->data['detail']->template)){
                    $templateFileName = getTemplateFileName($ci,$ci->data['detail']->template);
                    if(!empty($templateFileName)){

                         $ci->show_view('listing/default/frontend/templates/'.$templateFileName,$ci->data);
                    }else{
                        if($withHeaders == false){

                            $ci->show_view_without_head('listing/'.$ci->ViewFolderName.'/frontend/templates/default',$ci->data);
                        }else{

                            $ci->show_view('listing/'.$ci->ViewFolderName.'/frontend/templates/default',$ci->data);
                        }
                    }
                }

            return NULL;
        }
        return true;
    }
}

/**
 * @function uploadImagesAction 
 */
if(!function_exists('uploadImagesAction')){
    function uploadImagesAction($ci,$ID, $isNewVer = null){
        $return = array();
        $allowedExt = array('jpeg','jpg','png','gif');
        if(is_numeric($ID)){
            $LogoDbField       = $ci->LogoDbField;
            $BannerDbField     = $ci->BannerDbField;
            $uploadPath        = './pictures/logos/'.$ci->ImagesFolderName.'/'.$ID;
            $uploadDirectory   = './pictures/logos/'.$ci->ImagesFolderName.'/'.$ID;
            $uploadDBPath      = 'pictures/logos/'.$ci->ImagesFolderName.'/'.$ID;
            $insertDataArray   = array();
            if(isset($_FILES['Logoimage']['name']) && !empty($_FILES['Logoimage']['name'])){
                $FileName           = $_FILES['Logoimage']['name'];
                $explodedFileName   = explode('.',$FileName);
                $ext                = end($explodedFileName);
                if(!in_array(strtolower($ext),$allowedExt)){
                    $error =  "FAIL:: Logo -- Only Image JPEG, PNG and GIF Images Allowed, No Other Extensions Are Allowed::error";
                    array_push($return, $error);
                }else{
                    $FileName = $ci->LogoNamePrefix.'_'.$ID.'_'.time().'.'.$ext;

                    if(!is_dir($uploadDirectory)){
                        mkdir($uploadDirectory, 0755, true);
                    }
                    move_uploaded_file($_FILES['Logoimage']['tmp_name'],$uploadPath.'/'.$FileName);
                    $insertDataArray[$LogoDbField] = $uploadDBPath.'/'.$FileName;
                    $selectData = $LogoDbField.' AS logo, id';
                    if($isNewVer == null){
                        $where = array( 'id' => $ID );
                        $returnedData = $ci->Common_model->select_fields_where($ci->tableName,$selectData, $where, true);
                        $resultUpdate = $ci->Common_model->update($ci->tableName,$where,$insertDataArray);
                    }
                    else { // for edit case, when already present new version which's not approved yet

                        $where = array( $ci->listingField => $ID );
                        $orderBy = array('id', 'desc');
                        $returnedData = $ci->Common_model->select_fields_where($ci->versionTable,$selectData, $where, true, '', '', '','', $orderBy);
                        $where = array('id'=>$returnedData->id);
                        $resultUpdate = $ci->Common_model->update($ci->versionTable,$where,$insertDataArray);
                    }

                    $logo = $returnedData->logo;
                    if(!empty($logo) && is_file(FCPATH.'/'.$logo)){
                        unlink('./'.$logo);
                    }

                    if($resultUpdate === true){
                        //$success = "OK::Logo Uploaded::success";
                        //array_push($return, $success);

                        //If Update is of Success, Then Just Generate more Files.
                        //Load Model First
                        $ci->load->model('Imagecreate_model');
                       // unlinkLogos($logo, $ci);
                        $ext = $ci->Imagecreate_model->Get_file_extension($logo);
                        $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $logo);
                        // here unlink logo with different sizes
                        $sizes = ['_big_1024','_norml_512','_thumbnail_300','_thumb_small_100','_icon_60'];
                        foreach($sizes as $size){
                            if(!empty($withoutExt.$size.'.'.$ext) && is_file(FCPATH.'/'.$withoutExt.$size.'.'.$ext)){
                                unlink('./'.$withoutExt.$size.'.'.$ext);
                            }
                        }
                        //Create the Respective Images.
                        $ci->Imagecreate_model->createimage($insertDataArray[$LogoDbField]);
                    }else{
                        //$error = "FAIL::Logo -- Something went wrong during Update, Please Contact System Administrator::error";
                        //array_push($return, $error);
                    }
                }

            }else{
                //$error = "FAIL::Logo Image Not Provided::warning";
               // array_push($return, $error);
            } 
            $insertDataArray    = array();

            if(isset($_FILES['Bannerimage']['name']) && !empty($_FILES['Bannerimage']['name'])){
                $FileName           = $_FILES['Bannerimage']['name'];
                $explodedFileName   = explode('.',$FileName);
                $ext                = end($explodedFileName);

                if(!in_array(strtolower($ext),$allowedExt)){
                    //$error =  "FAIL:: Banner -- Only Image JPEG, PNG and GIF Images Allowed, No Other Extensions Are Allowed::error";
                    //array_push($return, $error);
                }else{

                    $FileName = $ci->BannerNamePrefix.'_'.$ID.'_'.time().'.'.$ext;
                    if(!is_dir($uploadDirectory)){
                        mkdir($uploadDirectory, 0755, true);
                    }

                    move_uploaded_file($_FILES['Bannerimage']['tmp_name'],$uploadPath.'/'.$FileName);
                    $insertDataArray[$BannerDbField] = $uploadDBPath.'/'.$FileName;

                    $selectData = $BannerDbField.' AS banner, id';
                    if($isNewVer == null){
                        $where = array( 'id' => $ID );
                        $returnedData = $ci->Common_model->select_fields_where($ci->tableName,$selectData, $where, false, '', '', '','','',false);
                        $resultUpdate = $ci->Common_model->update($ci->tableName,$where,$insertDataArray);
                    } else {
                        $where = array( $ci->listingField => $ID );
                        $orderBy = array('id', 'desc');
                        $returnedData = $ci->Common_model->select_fields_where($ci->versionTable,$selectData, $where, true, '', '', '','', $orderBy);
                        $where = array('id'=>$returnedData->id);
                        $resultUpdate = $ci->Common_model->update($ci->versionTable,$where,$insertDataArray);
                    }
                     $banner = $returnedData->banner;

                    if(!empty($banner) && is_file(FCPATH.'/'.$banner)){
                        unlink('./'.$banner);
                    }
                    if($resultUpdate === true){
                        //$success = "OK::Banner Uploaded::success";
                        //array_push($return, $success);
                    }else{
                        //$error = "FAIL::Banner -- Something went wrong during Update, Please Contact System Administrator::error";
                        //array_push($return, $error);
                    }
                }
            }else{
                //$error = "FAIL::Banner Image Not Provided::warning";
                //array_push($return, $error);
            }

            if(isset($_FILES['productImage']['name']) && !empty($_FILES['productImage']['name'])){
                $FileName           = $_FILES['productImage']['name'];
                $explodedFileName   = explode('.',$FileName);
                $ext                = end($explodedFileName);
                $prodImgDbField     = $ci->prodImageDbField;
                if(!in_array(strtolower($ext),$allowedExt)){
                    //$error =  "FAIL:: Product -- Only Image JPEG, PNG and GIF Images Allowed, No Other Extensions Are Allowed::error";
                    //array_push($return, $error);
                }else{

                    $FileName = $ci->ProdNamePrefix.'_'.$ID.'_'.time().'.'.$ext;
                    if(!is_dir($uploadDirectory)){
                        mkdir($uploadDirectory, 0755, true);
                    }

                    move_uploaded_file($_FILES['productImage']['tmp_name'],$uploadPath.'/'.$FileName);
                    $insertDataArray[$prodImgDbField] = $uploadDBPath.'/'.$FileName;

                    $selectData = $prodImgDbField.' AS product, id';
                    if($isNewVer == null){
                        $where = array( 'id' => $ID );
                        $returnedData = $ci->Common_model->select_fields_where($ci->tableName,$selectData, $where, false, '', '', '','','',false);
                        $resultUpdate = $ci->Common_model->update($ci->tableName,$where,$insertDataArray);
                    } else {
                        $where = array( $ci->listingField => $ID );
                        $orderBy = array('id', 'desc');
                        $returnedData = $ci->Common_model->select_fields_where($ci->versionTable,$selectData, $where, true, '', '', '','', $orderBy);
                        $where = array('id'=>$returnedData->id);
                        $resultUpdate = $ci->Common_model->update($ci->versionTable,$where,$insertDataArray);
                    }
                    $product = $returnedData->product;


                    if(!empty($product) && is_file(FCPATH.'/'.$product)){
                        unlink('./'.$product);
                    }

                    if($resultUpdate === true){
                        $success = "OK::Product Uploaded::success";
                        array_push($return, $success);
                    }else{
                        //$error = "FAIL::Product Image -- Something went wrong during Update, Please Contact System Administrator::error";
                        //array_push($return, $error);
                    }
                }

            }

        }else{
            $error = "FAIL::ID is Not Valid or Not Numeric ::error";
            array_push($return, $error);
        }
        return $return;
    }
}

/**
 * @function checkListingExist 
 */
if(!function_exists('checkListingExist')){
    function checkListingExist($ci, $value, $FieldName, $ID = NULL){
        $where = array($FieldName => $value);
        if($ID != NULL){
            $where['id'] = ' != '.$ID;
        }
        $data = $ci->Common_model->select_fields_where($ci->tableName,$FieldName,$where);
        if($data > 1){
            return true;
        }
        return false;
    }
}

/**
 * @function CountListing 
 */
if(!function_exists('CountListing')){
    function CountListing($ci){
        return $ci->Common_model->select($ci->tableName);
    }
} 

/**
 * @function InsertEsicUser 
 */                                                                                      
if(!function_exists('InsertEsicUser')){
    function InsertEsicUser($ci, $UserData){
        // Create the user account
        $ci->db->insert($ci->tableNameUser, $UserData);
        $userID =  $ci->db->insert_id();
        if($userID > 1){
            return $userID;
        }
        return false;
    }
}

/**
 * @function saveSocialLinks 
 */  
if(!function_exists('saveSocialLinks')){
    function saveSocialLinks($ci,$ID,$action){


        $return = array();
        if(!$ci->input->post()){
            $error = "FAIL::No Value Posted::error";
            array_push($return, $error);
            return $return;
        }
        if(empty($ID)){
            $error = "FAIL::No ID Set::error";
            array_push($return, $error);
            return $return;
        }

        $facebook   = $ci->input->post('facebook');
        $twitter    = $ci->input->post('twitter');
        $google     = $ci->input->post('google');
        $linkedIn   = $ci->input->post('linkedIn');
        $youTube    = $ci->input->post('youTube');
        $vimeo      = $ci->input->post('vimeo');
        $instagram  = $ci->input->post('instagram');

        
        $inputData = array(
                'facebook'    => $facebook,
                'twitter'     => $twitter,
                'google'      => $google,
                'linkedIn'    => $linkedIn,
                'youTube'     => $youTube,
                'vimeo'       => $vimeo,
                'instagram'   => $instagram
        );
        $notes = array();
        if(!empty($action)){
             $notes = EditSocialLink($ci,$ID,$inputData);
        }
        if(is_array($notes) && !empty($notes)){
            foreach ($notes as $key => $note){
                array_push($return, $note);
            }
        }
        
         return $return;

    }
}


/**
 * @function EditSocialLink 
 */
if(!function_exists('EditSocialLink')){
    function EditSocialLink($ci,$ID,$inputData){
        $return = array();
        $where['listingID'] = $ID;
        //$where['userID'] = getCurrentUserID($ci);
        $now = date("Y-m-d H:i:s");
        $inputData['date_updated'] = $now;
        $dataInDB = $ci->Common_model->select_fields_where($ci->tableNameSocial,'count(*) as Total',$where,true);
        if($dataInDB->Total < 1){
            $inputData['listingID'] = $ID;
            $inputData['userID'] = getCurrentUserID($ci);
            $inputData['date_created'] = $now;
            $updateResult = $ci->Common_model->insert_record($ci->tableNameSocial,$inputData);
        }else{
            $updateResult = $ci->Common_model->update($ci->tableNameSocial,$where ,$inputData);
        }
       // if($updateResult){
           //$success =  "OK::Socail Links Updated ::success";
            //array_push($return, $success);
        //}else{
           // $error =  "FAIL::Socail Links Update Failed ::error";
           // array_push($return, $error);
           
        //}
        return $return;
    }
}

/**
 * @function getList 
 */
if(!function_exists('getList')){
    function getList($ci,$ListingType){
        $tableName = '';
        switch ($ListingType) {
            case 'Esic':
                $tableName = 'esic';
                $FieldID  = 'id';
                $FieldName = 'name';
                break;
            default:
               return false;
                break;
        }
        $where = 'trashed != 1';
        $result = $ci->Common_model->select_fields_where($tableName ,$FieldID.' as id,'.$FieldName.' as name',$where);
        return $result;
    }
}

/**
 * @function getPageBuilderContentJson 
 */
if(!function_exists('getPageBuilderContentJson')){
    function getPageBuilderContentJson($ci,$listingID){
        
        $where = array('id' => $listingID);
        $fields = array(
            'businessShortDescriptionJSON As ContentJson,
            long_description As Content
            ',
            false
            );
        $result = $ci->Common_model->select_fields_where($ci->tableName,$fields,$where,true);
        return $result;
    }
}

/**
 * @function logoCheckNReplace 
 */
if(!function_exists('logoCheckNReplace')){
    function logoCheckNReplace($returnedData){
        
        //Lets Do some fun changes.
        //We Will change the Logo to Default Logo , only if the logo does not exist in the system. So there is no Need to set the render thingy in the javascript of datatables.
        if(!empty($returnedData)){
            $returnedDataArray = json_decode($returnedData,true);
            foreach($returnedDataArray['aaData'] as $key=>$subArray){
                    //First unset the old value.
                    unset($returnedDataArray['aaData'][$key]['Logo']);
                    //Assign back the new value.
                    $filePath = srcImage($subArray['Logo']);
                    //Assign it back to the position where it did belong to.
                    $returnedDataArray['aaData'][$key]['Logo'] = $filePath;
                    // do above step for vr_logo
                    if(isset($subArray['vr_Logo'])){
                        unset($returnedDataArray['aaData'][$key]['vr_Logo']);
                        //Assign back the new value.
                        $filePath = srcImage($subArray['vr_Logo']);
                        //Assign it back to the position where it did belong to.
                        $returnedDataArray['aaData'][$key]['vr_Logo'] = $filePath;
                    }
            }//End of Foreach Statement.
            return $returnedDataArray;
        }
        return false;

    }
}

/**
 * @function printListingResult 
 */
if(!function_exists('printListingResult')){
    function printListingResult($returnedData){
        $returnedData = logoCheckNReplace($returnedData);
        $returnedData = json_encode($returnedData);
        print_r($returnedData);
        return NULL;
    }
}

/**
 * @function getShowDataJson 
 */
if(!function_exists('getShowDataJson')){
    function getShowDataJson($ci){
//Need to Setup the Show JSON
            $showData = [];
            //Banner and Logo Placeholders or Images will Show Up if True.
            $showLogo = $ci->input->post('doShowLogo');
            $showBanner = $ci->input->post('doShowBanner');
            $doShowShortDescriptionOnDetails = $ci->input->post('doShowShortDescriptionOnDetails');

            //True if Checked, else false
            $showData['showLogo'] = (!empty($showLogo) and $showLogo === 'on')?'Yes':'No';
            $showData['showBanner'] = (!empty($showBanner) and $showBanner === 'on')?'Yes':'No';
            $showData['doShowShortDescriptionOnDetails'] = (!empty($doShowShortDescriptionOnDetails) and $doShowShortDescriptionOnDetails === 'on')?'Yes':'No';

            //Finally Encode the Array and Save it in DB.
            $showData = json_encode($showData);
            return $showData;
    }
}

// delete all sizes of logo
/*if(!function_exists('unlinkLogos')){
    function unlinkLogos($logo, $ci){
        $ext = $ci->Imagecreate_model->Get_file_extension($logo);
        $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $logo);
        // here unlink logo with different sizes
        $sizes = ['_big_1024','_norml_512','_thumbnail_300','_thumb_small_100','_icon_60'];
        foreach($sizes as $size){
            if(!empty($withoutExt.$size.'.'.$ext) && is_file(FCPATH.'/'.$withoutExt.$size.'.'.$ext)){
                unlink('./'.$withoutExt.$size.'.'.$ext);
            }
        }
    }
}*/
?>
