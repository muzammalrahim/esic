<?php 

/**
 * @function checkifSessionExist 
 */
if(!function_exists('checkifSessionExist')){
    function checkifSessionExist($ci){
        $Userdata = $ci->session->userdata();
        $user_id = $ci->session->userdata('userID');
        if(strlen($user_id) <= 0) {
            // No Login Information Found in the session Object
            // So now we will check if we have in cookies
        }else{
            if(!checkIfUserIDExistInDB($ci,$user_id)){
                $data = array(
                    'userID'    => '',
                    'userName'  => '',
                    'firstName' => '',
                    'lastName'  => '',
                    'Email'     => '',
                    'phone'     => '',
                    'p_image'   => '',
                    'userRole'  => '',
                    'loginType' => '',
                    'logged_in' =>  FALSE,
                );
                $ci->session->unset_userdata($data);
                $ci->session->unset_userdata('DefaultRedirectUrl');
                $ci->session->sess_destroy();
                redirect('home', 'refresh');
                exit;
            }
        }
        return null;
    }
}

/**
 * @function checkIfUserIDExistInDB 
 */
if(!function_exists('checkIfUserIDExistInDB')){
    function checkIfUserIDExistInDB($ci,$userID){
        $where = array('userID' => $userID);
        $result = $ci->Common_model->select_fields_where('hoosk_user','userID',$where,true);
        if(!empty($result) && strlen($result->userID) > 0){
            return true;
        }
        return false;
    }
}


/**
 * @function wordlimit 
 */
if (function_exists('wordlimit')) {
	 function wordlimit($string, $length = 40, $ellipsis = "..."){
		$string = strip_tags($string, '<div>');
		$string = strip_tags($string, '<p>');
		$words = explode(' ', $string);
		if (count($words) > $length)
			return implode(' ', array_slice($words, 0, $length)) . $ellipsis;
		else
			return $string.$ellipsis;
	}
	 
}
/**
 * @function isUserLoggedIn 
 */
if(!function_exists('isUserLoggedIn')){
    function isUserLoggedIn($ci){
    	$Userdata = $ci->session->userdata();
        $user_id = $ci->session->userdata('userID');
        if (strlen($user_id) <= 0) {
            // No Login Information Found in the session Object
            // So now we will check if we have in cookies
            if (get_cookie('Username')==true&& get_cookie('Password')==true) {
                $ci->authenticate("USE_COOKIES");
            }else
                // nothing found in cookies
                //Store Current Url to Session For Later Use.
                $ci->session->set_userdata('last_page', current_url());
            return false;
        }
        return true;
    }
}

/**
 * @function getCurrentUserData 
 */
if(!function_exists('getCurrentUserData')){
    function getCurrentUserData($ci){
        $Userdata = $ci->session->userdata();
        return $Userdata;
    }
}

/**
 * @function getCurrentUserPermissions 
 */
if(!function_exists('getCurrentUserPermissions')){
    function getCurrentUserPermissions($ci) {
        $permissionsArray = array();
        if(isUserLoggedIn($ci)){
            $roles = $ci->session->userdata('userRole');
            $allPermissionIDs = getAllPermissionsIDs($ci,$roles);
            if(is_array($allPermissionIDs) && !empty($allPermissionIDs)){
                $permissionsArray = getAllPermissions($ci,$allPermissionIDs);
            }

        }
        return $permissionsArray;
    }
}

/**
 * @function getAllPermissionsIDs 
 */
if(!function_exists('getAllPermissionsIDs')){
    function getAllPermissionsIDs($ci,$rolesJson) {
        $permissionIdsArray = array();
        $roles = json_decode($rolesJson);

        if(is_array($roles) && !empty($roles)){
            foreach($roles as $key => $role){
                $where = array('id' => $role);
                $permissionIds = $ci->Common_model->select_fields_where($ci->tableNameRoles,'permission_id',$where,true);
                $permissionIdsJson = json_decode($permissionIds->permission_id);
                if(is_array($permissionIdsJson) && !empty($permissionIdsJson)){
                    foreach ($permissionIdsJson as $key => $permissionId) {
                        if(!in_array($permissionId,$permissionIdsArray) && !empty($permissionId)){
                            array_push($permissionIdsArray, $permissionId);
                        }
                    }
                }
            }
        }
        return $permissionIdsArray;
    }
}


/**
 * @function getAllPermissions 
 */
if(!function_exists('getAllPermissions')){
    function getAllPermissions($ci,$PermissionIds) {
        $permissionsArray = array();
        if(is_array($PermissionIds) && !empty($PermissionIds)){
            foreach($PermissionIds as $key => $PermissionId){
                $where = array('id' => $PermissionId);
                $permissions = $ci->Common_model->select_fields_where($ci->tableNamePermission,'label,rights',$where,true);
                $permissionLabel = $permissions->label;
                $permissionRight = $permissions->right;
                if(!in_array($permissionLabel, $permissionsArray) && !empty($permissionLabel) ){
                    array_push($permissionsArray, $permissionLabel);
                }
            }
        }
        return $permissionsArray;
    }
}

/**
 * @function getAllUserRoles 
 */
if(!function_exists('getAllUserRoles')){
    function getAllUserRoles($ci,$userID = NULL) {
        $rolesArray = array();
        if($userID != NULL){
            $where = array('userID' => $role);
            $userRoleDB = $ci->Common_model->select_fields_where($ci->tableNameUser,'userRole',$where,true);
            $rolesJson  = $userRoleDB->userRole;
        }else{
             $rolesJson = $ci->session->userdata('userRole');
        }
       
        $roles = json_decode($rolesJson);
        if(is_array($roles) && !empty($roles)){
            foreach($roles as $key => $role){
                $where = array('id' => $role);
                $RolesDB = $ci->Common_model->select_fields_where($ci->tableNameRoles,'Slug',$where,true);
                $RolesSlug = $RolesDB->Slug;
                if(!empty($RolesSlug)){
                    if(!in_array($RolesSlug,$rolesArray)){
                        array_push($rolesArray, $RolesSlug);
                    }
                }
            }
        }
        return $rolesArray;
    }
}

/**
 * @function getAllUserRolesLabels 
 */
if(!function_exists('getAllUserRolesLabels')){
    function getAllUserRolesLabels($ci,$userID = NULL) {
        $rolesArray = array();
        if($userID != NULL){
            $where = array('userID' => $userID);
            $userRoleDB = $ci->Common_model->select_fields_where($ci->tableNameUser,'userRole',$where,true);
            $rolesJson  = $userRoleDB->userRole;
        }else{
             $rolesJson = $ci->session->userdata('userRole');
        }
        $roles = json_decode($rolesJson);
        if(is_array($roles) && !empty($roles)){
            foreach($roles as $key => $role){
                $where = array('id' => $role);
                $RolesDB = $ci->Common_model->select_fields_where($ci->tableNameRoles,'Label',$where,true);
                $RolesLabel = $RolesDB->Label;
                if(!empty($RolesLabel)){
                    if(!in_array($RolesLabel,$rolesArray)){
                        array_push($rolesArray, $RolesLabel);
                    }
                }
            }
        }
        return $rolesArray;
    }
}

/**
 * @function getUserRoleIDByLabel 
 */
if(!function_exists('getUserRoleIDByLabel')){
    function getUserRoleIDByLabel($ci,$Label) {
        if($Label != NULL){
            $where = array('Slug' => $Label);
            $userRoleDB = $ci->Common_model->select_fields_where($ci->tableNameRoles,'id',$where,true);
            return $userRoleDB->id;
        }   
        return false;
    }
}

/**
 * @function addRoleToUser 
 */
if(!function_exists('addRoleToUser')){
    function addRoleToUser($ci) {
        $RoleToGetByName = '';
        if(isset($ci->Name) && !empty($ci->Name)){
            $RoleToGetByName = $ci->Name;
        }else{
            $RoleToGetByName = $ci->input->post('ControllerName');   
        }
        $roleID = getUserRoleIDByLabel($ci,$RoleToGetByName);
        $userID = getCurrentUserID($ci);
        if($userID != NULL){
            $where = array('userID' => $userID);
            $userRoleDB = $ci->Common_model->select_fields_where($ci->tableNameUser,'userRole',$where,true);
            $rolesJson  = $userRoleDB->userRole;
        }else{
            $rolesJson = $ci->session->userdata('userRole');
        }
        if(!empty($rolesJson)){
            $roles = json_decode($rolesJson);
            if(is_array($roles) && !empty($roles)){
                if(!in_array($roleID,$roles)){
                    array_push($roles, $roleID);
                }
                sort($roles);
                $roles = json_encode($roles);
                $data['userRole'] = $roles;
                $ci->session->set_userdata($data);
                $where = array('userID' => $userID);
                $ci->Common_model->update($ci->tableNameUser,$where,$data); 
            }else{
                $data['userRole'] = '["'.$roleID.'"]';
                $where = array('userID' => $userID);
                $ci->Common_model->update($ci->tableNameUser,$where,$data); 
            }
        }else{
            $data['userRole'] = '["'.$roleID.'"]';
            $where = array('userID' => $userID);
            $ci->Common_model->update($ci->tableNameUser,$where,$data); 
        }
        return false;
    }
}

/**
 * @function NewUserRegister 
 */
if(!function_exists('NewUserRegister')){
    function NewUserRegister($ci){
        //Required Fields
        $firstName = $ci->input->post('FirstName');
        $email     = $ci->input->post('email');


        //Not Required Fields
        $userName  = $ci->input->post('userName');
        $lastName  = $ci->input->post('LastName');
        $phone     = $ci->input->post('phone');

        if(validateEmail($email) == true){
            if(empty($userName)){
                //if username is empty we can set email as username
                $userName = $email;
            }
            $userData = array(
                'userName'      => $userName,
                'firstName'     => $firstName,
                'email'         => $email
            );
            if(!empty($lastName)){
                $userData['lastName'] = $lastName;
            }
            if(!empty($phone)){
                $userData['phone'] = $phone;
            }
            $userID = '';
            $CurrentUserLoggedInCheck = isCurrentUserLoggedIn($ci);
            if($CurrentUserLoggedInCheck == false){
                $userID = createNewUser($ci,$userData);
            }else{
                $userID = getCurrentUserID($ci);
                if(isCurrentUserLoginTypeSocial($ci)){
                    $where = array('userID' => $userID);
                    $newData = array('email' => $email);
                    $ci->Common_model->update($ci->tableNameUser,$where,$newData);
                }
            }
            return $userID;
        }
    }
}

/**
 * @function createNewUser 
 */
if(!function_exists('createNewUser')){
    function createNewUser($ci,$data){
        $password = esic_random_password_generator(8);
        if(isset($ci->Name) && !empty($ci->Name)){
            $RoleToGetByName = $ci->Name;
        }else{
            $RoleToGetByName = $ci->input->post('ControllerName');   
        }
        $roleID   = getUserRoleIDByLabel($ci,$RoleToGetByName);
        $data['password'] = getEncryptedPassword($password);
        $data['userRole'] = '["'.$roleID.'"]';
        $userID = $ci->Common_model->insert_record($ci->tableNameUser,$data);
        newUserEmail($ci,$data['firstName'],$data['email'], $password); 
        return $userID;
    }
}

/**
 * @function createNewListing 
 */
if(!function_exists('createNewListing')){
    function createNewListing($ci,$data){
        $data['date_created'] = date( 'Y-m-d H:i:s');
        $data['date_updated'] = date( 'Y-m-d H:i:s');
        $listingID = $ci->Common_model->insert_record($ci->tableName,$data);
        return $listingID;
    }
}

/**
 * @function getUserCurrentEmail 
 */
if(!function_exists('getUserCurrentEmail')){
    function getUserCurrentEmail($ci, $id) {
        // Get the user email address
        $ci->db->select("email");
        $ci->db->where("userID", $id);
        $query = $ci->db->get('hoosk_user');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $email = $rows->email;
                return $email;
            }
        }
    }
}

/**
 * @function SaveUserListingQuestionAnwers 
 */
if(!function_exists('SaveUserListingQuestionAnwers')){ // front end form
    function SaveUserListingQuestionAnwers($ci,$listingID){
        $ParentQuestionArray = array();
        $QuestionAnwsers = $ci->input->post('QuestionAnwsers');
        if(!empty($QuestionAnwsers)){
            foreach($QuestionAnwsers as $key => $QuestionAnwser){
                $JsonToSave   = array();
                $QuestionID   = $QuestionAnwser['QuestionID'];
                $QuestionType = $QuestionAnwser['QuestionType'];
                $QuestionAnswerSelectedID = $QuestionAnwser['QuestionAnswerSelectedID'];
                $JsonToSave['type'] = $QuestionType;
                if(isset($QuestionAnwser['QuestionAnswer'])){
                    $QuestionAnswer     = $QuestionAnwser['QuestionAnswer'];
                        switch ($QuestionType) {
                            case 'radios':
                                $JsonToSave['type'] = 'radio';
                                $JsonToSave['selectedValue']    = $QuestionAnswer;
                                $JsonToSave['selectedRadioID']  = $QuestionAnswerSelectedID;
                                break;
                            case 'SelectBox':
                                $JsonToSave['type'] = 'select';
                                $JsonToSave['selectedSelectValue'] = $QuestionAnswer;
                                break;
                            case 'CheckBoxes':
                                $JsonToSave['type'] = 'checkbox';
                                $JsonToSave['selectedCheckBoxes'] = $QuestionAnswer;
                                break;
                             case 'textBoxes':
                                $dateUpdated = date('Y-m-d');
                                $JsonToSave['type'] = 'text';
                                $JsonToSave['textboxes'][0]['changedValue'] = $QuestionAnswer;
                                $JsonToSave['textboxes'][0]['textBoxID']    = $QuestionAnswerSelectedID;
                                $JsonToSave['dateUpdated']               = $dateUpdated;
                                break;   
                        }
                        if(isset($QuestionAnwser['SubQuestionAnswer'])){
                            $SubQuestionAnswers  = $QuestionAnwser['SubQuestionAnswer'];
                            foreach ($SubQuestionAnswers as $key => $SubQuestionAnswer){
                                if($SubQuestionAnswer != false){
                                    if(isset($SubQuestionAnswer['SubQuestionType'])){
                                        $SubQuestionType = $SubQuestionAnswer['SubQuestionType'];
                                        switch ($SubQuestionType){
                                            case 'pre-populatedList':
                                                $listTypeID = $SubQuestionAnswer['listTypeID'];
                                                $JsonToSave['prePopulatedItems'][0]['listTypeID'] = $listTypeID;
                                                $SubAnswer = $SubQuestionAnswer['SubAnswer'];
                                                $JsonToSave['prePopulatedItems'][0]['selectedItemID'] = $SubAnswer;
                                                break;
                                            case 'subQuestion':
                                                $SubAnswer     = $SubQuestionAnswer['SubAnswer']; 
                                                $SubQuestionID = $SubQuestionAnswer['SubQuestionID'];
                                                $SubQuestionInnerType = $SubQuestionAnswer['SubQuestionInnerType'];  
                                                $JsonToSaveSub   = array();
                                                switch ($SubQuestionInnerType){
                                                    case 'radios':
                                                        $JsonToSaveSub['type'] = 'radio';
                                                        $JsonToSaveSub['selectedValue']    = $SubAnswer;
                                                        $JsonToSaveSub['selectedRadioID']  = $QuestionAnswerSelectedID;
                                                        break;
                                                    case 'SelectBox':
                                                        $ParentQuestionArray1['parentQID'] = $QuestionID;
                                                        $ParentQuestionArray1['selectedValues'] = $SubAnswer;
                                                        $JsonToSaveSub['type'] = 'select';
                                                        //$JsonToSaveSub['selectedSelectValue'] = $SubAnswer;
                                                        array_push($ParentQuestionArray, $ParentQuestionArray1);
                                                        $JsonToSaveSub['selectedSelectValue'] = $ParentQuestionArray;
                                                        // ParentQuestionArray1[]
                                                        // $JsonToSaveSub['selectedSelectValue'][$ParentQuestionArray]['parentQID'] = $QuestionID;
                                                        // $JsonToSaveSub['selectedSelectValue'][$ParentQuestionArray]['selectedValues'] = $SubAnswer;
                                                        // $ParentQuestionArray++;
                                                        break;
                                                    case 'CheckBoxes':
                                                        $JsonToSaveSub['type'] = 'checkbox';
                                                        $JsonToSaveSub['selectedCheckBoxes'] = $SubAnswer;
                                                        break;
                                                    case 'textBoxes':
                                                        $dateUpdated = date('Y-m-d');
                                                        $JsonToSaveSub['type'] = 'text';
                                                        $JsonToSaveSub['textboxes'][0]['changedValue'] = $SubAnswer;
                                                        $JsonToSaveSub['textboxes'][0]['textBoxID']    = $QuestionAnswerSelectedID;
                                                        $JsonToSaveSub['dateUpdated']               = $dateUpdated;
                                                        break;  
                                                    default:
                                                        break;
                                                }
                                                $JsonToSaveSub = json_encode($JsonToSaveSub);
                                                InsertUserListingQuestionAnswerJson($ci, $SubQuestionID, $listingID, $JsonToSaveSub);

                                                break;
                                            default:
                                                break;
                                        }
                                    }
                                }
                            }
                        }
                        $JsonToSave = json_encode($JsonToSave);
                InsertUserListingQuestionAnswerJson($ci, $QuestionID, $listingID, $JsonToSave);
                }
            }
            echo 'OK::Questions Answer Submitted For Review::success';
        }else{
            echo 'FAIL::Please Answer Some Questions::error';
        }
       
        return false;
    }
}
/**
 * @function InsertUserListingQuestionAnswerJson 
 */
if(!function_exists('InsertUserListingQuestionAnswerJson')){ // from front end
    function InsertUserListingQuestionAnswerJson($ci, $QuestionID, $userID, $Json){

        $listingID = $ci->QuestionListingID;
        if(empty($QuestionID) || empty($userID) || empty($listingID)){
            return false;
        }
        // getting answer Id from esic_question_answers
        //We Need to Store the Answer for the User Against his/her question.
        //For That first We Need to fetch the Possible Answers for that question and match it.
        $selectAnswerData = [
            'id,Solution,type',false
        ];
        $whereSelectAnswer = [
            'questionID' => $QuestionID
        ];
        $resultAnswer = $ci->Common_model->select_fields_where($ci->answersTable,$selectAnswerData,$whereSelectAnswer,true);

        //We Can Only Update the Ansewr In Database for the User if we have the available answer/solution for the question.
        if(empty($resultAnswer)){
            return false;
        }
        $Solution = $resultAnswer->Solution;

        if(empty($Solution)){
            return false;
        }else{
            $Solution       = json_decode($Solution,true);
            $SolutionData   = $Solution['data'];
        }
        $answer_id = $resultAnswer->id;

        //First Check Answer of that question in that listing ID exist 
        $whereUserAnswer = [
            'answer_id'     => $answer_id,
            'user_id'       => $userID,
            'listing_id'    => $listingID
        ];
        $resultCheck = $ci->Common_model->select_fields_where($ci->userAnswersTable,'count(*) As Total',$whereUserAnswer,true);
        if(!empty($resultCheck) && $resultCheck->Total > 0){
            //That Already Exist so update that 
            $updateUserAnswerData = [
                'answer_id'  => $answer_id,
                'user_id'    => $userID, //This is Listing ID basically
                'listing_id' => $listingID, // this is listing type ID
                'answer'     => $Json,
                'year'       => date('Y-m-d'),// when user answer it
            ];
            $ci->Common_model->update($ci->userAnswersTable,$whereUserAnswer,$updateUserAnswerData);
        }else{
            //Not Exist so Insert that 
            $insertUserAnswerData = [
                'answer_id'  => $answer_id,
                'user_id'    => $userID,
                'listing_id' => $listingID,
                'answer'     => $Json,
                'year'       => date('Y-m-d'),// when user answer it
            ];
            $ci->Common_model->insert_record($ci->userAnswersTable,$insertUserAnswerData);
        }
    }
}

/**
 * @function validateEmail 
 */
if(!function_exists('validateEmail')){
    function validateEmail($email){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           echo 'FAIL:: Email Not Valid ::error';
           return null;
        }
        return true;
    }
}

/**
 * @function CheckUserEmail 
 */
if(!function_exists('CheckUserEmail')){
     function CheckUserEmail($ci){
        $email  = $ci->input->post('email');
        if(validateEmail($email) == true){
            $result = CheckUserFieldExist($ci,$email,'email');
            $CurrentUserLoggedInCheck = isCurrentUserLoggedIn($ci);
            if($CurrentUserLoggedInCheck == false){
                if($result == false){
                    echo 'OK:: Email Available '.$email.' ::success';
                    return true;
                }else{
                    echo 'FAIL:: Sorry You Cannot Use this Email Already Exist ! : '.$email.' <br /> If this is your email address please <a href="'.base_url().'login" style="color:blue;font-size:18px"><strong>Login</strong></a> first.::error';
                    return false;
                }
            }elseif($CurrentUserLoggedInCheck == true){
                $currentEmail = getCurrentUserField($ci,'email');
                if($currentEmail == $email && $result == true){
                    echo 'OK:: That is Your Email & it will save as Investor email too '.$email.' ::success';
                    return true;
                }elseif($result == true){
                        echo 'FAIL:: That Email is already in use '.$email.' ::error ::estmator';
                        return false;
                }else{
                    echo 'OK::That is not your current user email but that is fine it will save as '.$ci->NameMessage.' email '.$email.' ::success';
                        return true;
                }
            }
        }
    }
}

/**
 * @function CheckUserEsic
 */
if(!function_exists('CheckUserEsic')){
    function CheckUserEsicUser($ci, $value, $FieldName, $ID = NULL){
        $where = array($FieldName => $value);
        if($ID != NULL){
            $where['userID'] = ' != '.$ID;
        }
        $data = $ci->Common_model->select_fields_where($ci->tableNameUser,$FieldName,$where);
        if($data > 1){
            return true;
        }
        return false;
    }
}

/**
 * @function CheckUserFieldExist
 */
if(!function_exists('CheckUserFieldExist')){
    function CheckUserFieldExist($ci, $value, $FieldName){
        $where = array($FieldName => $value);
        $data = $ci->Common_model->select_fields_where($ci->tableNameUser,$FieldName,$where);
        if($data > 1){
            return true;
        }
        return false;
    }
}

/**
 * @function getCurrentUserField
 */
if(!function_exists('getCurrentUserField')){
    function getCurrentUserField($ci, $FieldName){
        $userID = $ci->session->userdata('userID');
        $where = array('userID' => $userID);
        $data = $ci->Common_model->select_fields_where($ci->tableNameUser,$FieldName,$where,true);
        if($data->$FieldName){
            return $data->$FieldName;
        }
        return false;
    }
}

/**
 * @function UserList
 */
if(!function_exists('UserList')){
    function UserList($ci){
        return $ci->Common_model->select($ci->tableNameUser);
    }
}

?>
