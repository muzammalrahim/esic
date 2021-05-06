<?php

/**
 * @function getListingTypeColor 
 */
if(!function_exists('getListingTypeColor')){
    function getListingTypeColor($ci,$DBFieldName,$DBFieldValue){
        $where = array($DBFieldName => $DBFieldValue);
        $result = $ci->Common_model->select_fields_where('esic_listings','color',$where,true);
        if(!empty($result)){
            return $result->color;
        }
        return false;
    }
}

/**
 * @function HeadLessArrayCustom 
 */
if(!function_exists('HeadLessArrayCustom')){
    function HeadLessArrayCustom($returnArray){
        $keyArray = array();
        $result = array();
        if(!empty($returnArray)){
            foreach($returnArray as $key => $nameArray){

                foreach($nameArray as $key2 => $innerNameArry){

                    if(!in_array($key2, $keyArray)){
                        array_push($keyArray, $key2);
                    }
                    
                    if(is_object($innerNameArry)){

                        array_push($result, $innerNameArry);

                    }else if(is_array($innerNameArry)){

                        foreach($innerNameArry as $key3 => $value3){

                            if(is_object($value3)){
                                array_push($result, $value3);
                            }

                        }
                    }
                }
            }
        }
        return $result;
    }
}


/**
 * @function recursiveArrayMakingCustom 
 */
if(!function_exists('recursiveArrayMakingCustom')){
    function recursiveArrayMakingCustom($returnArray){
        $keyArray = array();
        $result = array();

        foreach($returnArray as $key => $nameArray){

            foreach($nameArray as $key2 => $innerNameArry){

                if(!in_array($key2, $keyArray)){
                    array_push($keyArray, $key2);
                    $result[$key2] = array();
                }
                
                if(is_object($innerNameArry)){

                    array_push($result[$key2], $innerNameArry);

                }else if(is_array($innerNameArry)){

                    foreach($innerNameArry as $key3 => $value3){

                        if(is_object($value3)){
                            array_push($result[$key2], $value3);
                        }

                    }
                }
            }
        }
        return $result;
    }
}

/**
 * @function checkAdminRole 
 */
if(!function_exists('checkAdminRole')){
    function checkAdminRole($ci){
        Admincontrol_helper::is_logged_in($ci->session->userdata('userID'));
        $userRole = $ci->session->userdata('userRole');
        //We Don't want un authorized access
        if($userRole != 1){
            $ci->load->view('admin/page_not_found');
            return false;
        }
        return true;
    }
}

/**
 * @function checkRoleHasPermission 
 */
if(!function_exists('checkRoleHasPermission')){
    function checkRoleHasPermission($ci, $PermissionName){ 
        //We Don't want unauthorized access
        $userID   = $ci->session->userdata('userID');
        //$userRole = $ci->session->userdata('userRole');
        $where = array(
            'userID'   => $userID
        );
        $UserRoleDB = $ci->Common_model->select_fields_where($ci->tableNameUser,'userRole',$where,true);
        $ci->session->set_userData(array('userRole' => $UserRoleDB->userRole));
        //if($UserRoleDB->userRole == $userRole){
            $permissons = getCurrentUserPermissions($ci);
            foreach ($permissons as $key => $permisson) {
                if($permisson == "All Permissions"){
                    return true; // Super User Permissions
                }
                if($permisson == $PermissionName){
                    return true;
                }
            }
        //}
        //$ci->data['PermissionName'] = $PermissionName;
        //$ci->load->view('admin/header' , $data);
        //$ci->load->view('admin/NoPermission' , $data);
       // $ci->load->view('admin/footer' , $data);
        return false;
    }
}


/**
 * @function checkUserHasRole
 */
if(!function_exists('checkUserHasRole')){
    function checkUserHasRole($ci, $RoleName = Null){
        //We Don't want unauthorized access
        $userID   = $ci->session->userdata('userID');
        $userRole = $ci->session->userdata('userRole');
        $allUserRoles =  getAllUserRoles($ci);
        foreach ($allUserRoles as $key => $UserRole){
            if($RoleName == $UserRole || $UserRole == 'Admin'){
                return true;
            }
        }
        return false;
    }
}


/**
 * @function isCurrentUserAdmin
 */
if(!function_exists('isCurrentUserAdmin')){
    function isCurrentUserAdmin($ci) {
        //We Don't want unauthorized access
        $userID   = $ci->session->userdata('userID');
        $userRole = $ci->session->userdata('userRole');
        $allUserRoles =  getAllUserRoles($ci);
        foreach ($allUserRoles as $key => $UserRole){
            if($UserRole == 'Admin'){
                return true;
            }
        }
        return false;
    }
}
/**
 * @function isCurrentListingBelongToThisUser
 */
if(!function_exists('isCurrentListingBelongToThisUser')){
    function isCurrentListingBelongToThisUser($ci,$id) {
        //We Don't want unauthorized access
        $userID   = $ci->session->userdata('userID');
        $userRole = $ci->session->userdata('userRole');
        $allUserRoles =  getAllUserRoles($ci);
        foreach($allUserRoles as $key => $UserRole){
            if($UserRole == 'Admin'){ //every thing belong to admin
                return true;
            }
        }
        $where = array(
            'id' => $id,
            'userID' => $userID,
        );
        $result = $ci->Common_model->select_fields_where($ci->tableName ,'*' ,$where,true);
        if(!empty($result)){
            return true;
        }
        return false;
    }
}

/**
 * @function isCurrentUserLoggedIN
 */
if(!function_exists('isCurrentUserLoggedIn')){
    function isCurrentUserLoggedIn($ci) {
        $userID = $ci->session->userdata('userID');
        if(strlen($userID) <= 0){
            return false;
        }
        return true;
    }
}

/**
 * @function getCurrentUserID
 */
if(!function_exists('getCurrentUserID')){
    function getCurrentUserID($ci) {
        $userID   = $ci->session->userdata('userID');
        return $userID;
    }
}

/**
 * @function getCurrentUserLoginType
 */
if(!function_exists('getCurrentUserLoginType')){
    function getCurrentUserLoginType($ci) {
        $loginType = $ci->session->userdata('loginType');
        return $loginType;
    }
}

/**
 * @function isCurrentUserLoginTypeSocial
 */
if(!function_exists('isCurrentUserLoginTypeSocial')){
    function isCurrentUserLoginTypeSocial($ci) {
        $loginType = $ci->session->userdata('loginType');
        if(!empty($loginType)){
            return true;
        }else{
            return false;
        }
    }
}


/**
 * @function checkPostExist 
 */
if(!function_exists('checkPostExist')){
    function checkPostExist($ci){
        Admincontrol_helper::is_logged_in($ci->session->userdata('userID'));
        $userRole = $ci->session->userdata('userRole');
        //We Don't want un authorized access
        if($userRole != 1){
            $ci->load->view('admin/page_not_found');
            return false;
        }
        return true;
    }
}
/**
 * @function previousURL return URL
 */
if(!function_exists('previousURL')){
    function previousURL(){
        if (isset($_SERVER['HTTP_REFERER']))
        {
            return $_SERVER['HTTP_REFERER'];
        }
        else
        {
            return base_url();
        }
    }
}
//Found This Function on
//http://php.net/manual/en/function.date-diff.php
if(!function_exists('dateDifference')){
    function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);

    }
}

if(!function_exists('getExpiryDate')){
   function getExpiryDate($added_date){
        return date("Y-06-30", strtotime(date("Y-m-d", strtotime($added_date)) . " + 5 year"));
    }
}
//Found This Function on
//http://php.net/manual/en/function.date-diff.php
if(!function_exists('validateDate')){
    function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}

//Found This Function on
//http://stackoverflow.com/questions/1727077/generating-a-drop-down-list-of-timezones-with-php
if(!function_exists("generate_timezone_list")){
    function generate_timezone_list()
    {
        static $regions = array(
            DateTimeZone::AFRICA,
            DateTimeZone::AMERICA,
            DateTimeZone::ANTARCTICA,
            DateTimeZone::ASIA,
            DateTimeZone::ATLANTIC,
            DateTimeZone::AUSTRALIA,
            DateTimeZone::EUROPE,
            DateTimeZone::INDIAN,
            DateTimeZone::PACIFIC,
        );

        $timezones = array();
        foreach( $regions as $region )
        {
            $timezones = array_merge( $timezones, DateTimeZone::listIdentifiers( $region ) );
        }

        $timezone_offsets = array();
        foreach( $timezones as $timezone )
        {
            $tz = new DateTimeZone($timezone);
            $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
        }

        // sort timezone by offset
        asort($timezone_offsets);

        $timezone_list = array();
        foreach( $timezone_offsets as $timezone => $offset )
        {
            $offset_prefix = $offset < 0 ? '-' : '+';
            $offset_formatted = gmdate( 'H:i', abs($offset) );

            $pretty_offset = "UTC${offset_prefix}${offset_formatted}";

            $timezone_list[$timezone] = "(${pretty_offset}) $timezone";
        }

        return $timezone_list;
    }
}

//Will Return Number in Human Readable Format.
if(!function_exists("number_readable")){
    function number_readable($number,$desiNumber=FALSE){
        if(!is_numeric($number)){
            return false;
        }
        if($desiNumber === TRUE){
            $num = $number;
            $nums = explode(".",$num);
            if(count($nums)>2){
                return "0";
            }else{
                if(count($nums)==1){
                    $nums[1]="00";
                }
                $num = $nums[0];
                $explrestunits = "" ;
                if(strlen($num)>3){
                    $lastthree = substr($num, strlen($num)-3, strlen($num));
                    $restunits = substr($num, 0, strlen($num)-3);
                    $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits;
                    $expunit = str_split($restunits, 2);
                    for($i=0; $i<sizeof($expunit); $i++){

                        if($i==0)
                        {
                            $explrestunits .= (int)$expunit[$i].",";
                        }else{
                            $explrestunits .= $expunit[$i].",";
                        }
                    }
                    $thecash = $explrestunits.$lastthree;
                } else {
                    $thecash = $num;
                }
                return $thecash.".".$nums[1];
            }
        }
        return number_format($number, 2, '.', ',');
    }
}

if(!function_exists("convert_number_to_words")){
    function convert_number_to_words($inputNumber,$desiNumber = FALSE){
        if(!is_numeric($inputNumber)){
            return false;
        }
        if($desiNumber === TRUE){
            $no = round($inputNumber);
            $point = round($inputNumber - $no, 2) * 100;
            $hundred = null;
            $digits_1 = strlen($no);
            $i = 0;
            $str = array();
            $words = array(
                0 => '',
                1 => 'one',
                2 => 'two',
                3 => 'three',
                4 => 'four',
                5 => 'five',
                6 => 'six',
                7 => 'seven',
                8 => 'eight',
                9 => 'nine',
                10 => 'ten',
                11 => 'eleven',
                12 => 'twelve',
                13 => 'thirteen',
                14 => 'fourteen',
                15 => 'fifteen',
                16 => 'sixteen',
                17 => 'seventeen',
                18 => 'eighteen',
                19 =>'nineteen',
                20 => 'twenty',
                30 => 'thirty',
                40 => 'forty',
                50 => 'fifty',
                60 => 'sixty',
                70 => 'seventy',
                80 => 'eighty',
                90 => 'ninety');
            $digits = array('', 'hundred', 'thousand', 'lakh', 'crore', 'arab', 'kharab');
            $strKey = 0;
            while ($i < $digits_1) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += ($divider == 10) ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;

                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [$strKey] = ($number < 21) ? $words[fix_number($number)] .
                        " " . $digits[$counter] . $plural . " " . $hundred
                        :
                        $words[floor($number / 10) * 10]
                        . " " . $words[$number % 10] . " "
                        . $digits[$counter] . $plural . " " . $hundred;
                    $strKey++;
                } else $str[] = null;
            }
            $str = array_reverse($str);

            $result = implode('', $str);

            $points = ($point) ?
                "." . $words[$point / 10] . " " .
                $words[$point = $point % 10] : '';
            return $result . "Rupees  " .(!empty($points)?$points. " Paise":"");
        }

        $formatNumber = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return $formatNumber->format($inputNumber);
    }
}


//it will return a base number e-g if 56 then return 50 if 67 ten return 60
if(!function_exists("fix_number")){
    function fix_number($number){
        if($number > 20){
            $strNumber = strval($number);
            $removedLastDigit = substr($strNumber, 0, -1); // remove last character
            $newNumber = $removedLastDigit . '0';
            return intval($newNumber);
        }else{
            return intval($number);
        }
    }
}


if(!function_exists("getWidth")) {
    function getWidth($image)
    {
        $sizes = getimagesize($image);
        $width = $sizes[0];
        return $width;
    }
}
if(!function_exists("getHeight")) {
    function getHeight($image) {
        $sizes = getimagesize($image);
        $height = $sizes[1];
        return $height;
    }
}
if(!function_exists("resizeImage")) {
    function resizeImage($image,$width,$height,$scale) {
        $newImageWidth = ceil($width * $scale);
        $newImageHeight = ceil($height * $scale);
        $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
        $source = imagecreatefromjpeg($image);
        imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
        imagejpeg($newImage,$image,90);
        chmod($image, 0777);
        return $image;
    }
}

if(!function_exists("render_slider")){
    function render_slider($pageData){

        $ci =& get_instance();
        $ci->load->model('Common_model');
        $ci->load->helper('layouts');
        $selectData = ['
                renderCode as shortCode,
                table_name as joinTable
                ',
            false
        ];
        $sliderTables = $ci->Common_model->select_fields('esic_slider_table', $selectData, false, '' ,'',true);
        //we would get array of elements in $text array representing the short codes



        $text = [];
        if(!empty($sliderTables)){
            foreach($sliderTables as $key => $layout){
                $text[$layout['shortCode']] = $layout;
            }
        }

        //replacing values and assigning to pageContent variable.

        $pageContent = preg_replace_callback('/{{([^}]+)}}/', function ($m) use ($text,$ci) {
            //Now what we need to do is get the layout first.
            $_SESSION['pageHasSlider'] = true;
            $stripped = array_map(function($v){
            
                return trim(strip_tags($v));
            }, $m);
            $stripped[1] = str_replace('&nbsp;',' ', $stripped[1]);
            $stripped = explode(' ', $stripped[1]);
            $OptionArray = array();
            foreach ($stripped as $key => $value) {
                 
                if(!empty($value)){
                    if(strpos($value, '=')){
                        $OptionSettingArray = explode('=', $value);
                        $OptionArray[$OptionSettingArray[0]] = $OptionSettingArray[1];
                    }else{
                        $OptionArray['shortCode'] = $value;
                    }
                }

            }

            if(empty($OptionArray['layout'])){
                $OptionArray['layout'] = 1;
            }

            $neededSlider = $text[$OptionArray['shortCode']];

            $ImagePath = '';

            //exit;
            //now need to get the slider join.
            $where = '1=1';
            switch($neededSlider['joinTable']){
                case 'esic':
                    $selectJoinData = [
                        '
                            logo as Image,
                            slug as link,
                            name as name
                        ',
                        false
                    ];
                    $where = array('Publish' => 1,'trashed' => 0);
                    $action = 'esic_database';
                    $base_link = '';
                    $ImagePath = false;
                    break;
                case 'esic_investor':
                    $selectJoinData = [
                        '
                            image as Image,
                            slug as link,
                            "" as name
                        ',
                        false
                    ];
                    $where = array('Publish' => 1,'trashed' => 0);
                    $action = 'investor_database';
                    $ImagePath = 'uploads/investor/';
                    $base_link = '';
                    break;
                case 'esic_accelerators':
                    $selectJoinData = [
                        '
                            logo as Image,
                            slug as link,
                            name as name
                        ',
                        false
                    ];
                    $where = array('Publish' => 1,'trashed' => 0);
                    $action = 'accelerator_database';
                    $ImagePath = '';
                    $base_link = '';
                    break;
                case 'esic_institution':
                    $selectJoinData = [
                        '
                            logo as Image,
                            slug as link,
                            institution as name
                        ',
                        false
                    ];
                    $where = array('Publish' => 1,'trashed' => 0);
                    $action = 'university_database';
                    $ImagePath = '';
                    $base_link =  base_url().'University/';
                    break;
                case 'esic_rndpartner':
                    $selectJoinData = [
                        '
                            logo as Image,
                            slug as link,
                            name as name
                        ',
                        false
                    ];
                    $where = array('Publish' => 1,'trashed' => 0);
                    $action = 'rndpartner_database';
                    $ImagePath = '';
                    $base_link = '';
                    break;
                case 'esic_rndconsultant':
                    $selectJoinData = [
                        '
                            logo as Image,
                            slug as link,
                            name as name
                        ',
                        false
                    ];
                    $where = array('Publish' => 1,'trashed' => 0);
                    $action = 'rndconsultant_database';
                    $ImagePath = '';
                    $base_link = base_url().'RndConsultant/';
                    break;
                case 'esic_lawyers':
                    $selectJoinData = [
                        '
                            logo as Image,
                            slug as link,
                            name as name
                        ',
                        false
                    ];
                    $where = array('Publish' => 1,'trashed' => 0);
                    $action = 'lawyer_database';
                    $ImagePath = '';
                   $base_link = base_url().'Lawyer/';
                    break;
                case 'esic_acceleration':
                // /ACCELERATING COMMERCIALISATION
                    $selectJoinData = [
                        '
                            logo as Image,
                            slug as link,
                            Member as name
                        ',
                        false
                    ];
                    $where = array('Publish' => 1,'trashed' => 0);
                    $action = 'acceleratingcommercialisation_database';
                    $ImagePath = '';
                    $base_link =  base_url().'Accelerator/';
                    break;
                default:
                    break;
            }

            if(!empty($selectJoinData) && !empty($neededSlider['joinTable'])){
                //$sliderData = $ci->Common_model->select_fields($neededSlider['joinTable'],$selectJoinData,false,'','',true);
                $sliderData = $ci->Common_model->select_fields_where($neededSlider['joinTable'],$selectJoinData, $where,false,'','','','','',true);
               // echo '<pre>';
               // print_r($sliderData);
              //  exit;
                $items = array(
                        'desktop'   => intval($OptionArray['Desktop']),
                        'tablet'    => intval($OptionArray['Tablet']),
                        'mobile'    => intval($OptionArray['Mobile'])
                    )

                ;
                //echo $OptionArray['layout'];
                 $selectData = ['
                    name as name,
                    htmlCode as functionName
                    ',
                    false
                ];

                $where = array('id' => intval($OptionArray['layout']));
                $sliderFunction = $ci->Common_model->select_fields_where('esic_slider_layouts', $selectData, $where, true,'','','','','',true);

                if(!empty($sliderFunction['functionName'])){

                    $renderedHTML = $sliderFunction['functionName']($sliderData, $ImagePath, $items, $action, $base_link);
                }else{
                    $renderedHTML = '';
                }
            }
            return $renderedHTML;
//            return $text[$m[1]];
        }, $pageData['pageContentHTML']);
        //replacing the original content with the updated one.
        $pageData['pageContentHTML'] = $pageContent;
        //finally returning the replaced content.
        return $pageData;
    }
}


function get_user_image($userRole,$userID){
    $ci =& get_instance();
    $ci->load->model('Common_model');
    if(empty($userRole) || empty($userID)){
        echo 'Invalid Parameters';
        return false;
    }
    $defaultUserImage = base_url()."assets/img/user2-160x160.jpg";
        $selectData = [
          'p_image as avatar',
            false
        ];
        $where = array('userID' => $userID);
        $basePath = base_url(). 'uploads/users/';
    $userProfileImage = $ci->Common_model->select_fields_where($ci->tableNameUser,$selectData,$where,true);
    if(!empty($userProfileImage)){
        $path = $basePath.$userProfileImage->avatar;
        if(file_exists($path) and is_file($path)){
            return $path;
        }else{
            return $defaultUserImage;
        }
    }else{
        return $defaultUserImage;
    }
}
/* view esic helper listings */

//Gives the complete Path for Lawyer Image if only Exists, If Not then default Image will be rendered.
function lawyerImage($dbData=false){
    $defaultUserImage = base_url()."assets/img/lawyer.jpg";
    //If No Parameter has been Passed or if is empty then just return the default.
    if(empty($dbData)){
        return $defaultUserImage;
    }

    $imagePath = base_url().$dbData;

    if(file_exists($imagePath) and is_file($imagePath)){
        return $imagePath;
    }else{
        return $dbData;
    }
}

//Validate if its a Valid JSON String.
if(!function_exists('isJson')){
    function isJson($string) {
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }
}

//Check if Provided Items in Arguments are actually empty or not,
//If anyone of them are empty return true. else return false if none is empty
if(!function_exists('m_empty')){
    function m_empty()
    {
        foreach(func_get_args() as $arg)
            if(empty($arg))
                continue;
            else
                return false;
        return true;
    }
}
if(!function_exists('esic_random_password_generator')) {
    function esic_random_password_generator($length = 8)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }
}

if(!function_exists('getEncryptedPassword')) {
    function getEncryptedPassword($password){
        $password = md5($password.SALT);
        return $password;
    }
}

function findWhere($array, $matching) {
    foreach ($array as $item) {
        $is_match = true;
        foreach ($matching as $key => $value) {

            if (is_object($item)) {
                if (! isset($item->$key)) {
                    $is_match = false;
                    break;
                }
            } else {
                if (! isset($item[$key])) {
                    $is_match = false;
                    break;
                }
            }

            if (is_object($item)) {
                if ($item->$key != $value) {
                    $is_match = false;
                    break;
                }
            } else {
                if ($item[$key] != $value) {
                    $is_match = false;
                    break;
                }
            }
        }

        if ($is_match) {
            return $item;
        }
    }

    return false;
}
/**
 * @function in_array_r
 */
if(!function_exists('in_array_r')){
    function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }
}

function fetchQuestionAnswers($questionID){
    if(empty($questionID) || !is_numeric($questionID)){
        return false;
    }
    $ci =& get_instance();
    $ci->load->model('Common_model');

    $selectData = [
        'Q.id as QuestionID, Q.Question as Question, QA.Solution as Solution, QA.type AS Type, QA.id AS AnswerID',false
    ];
    $joins = [
        [
            'table' => 'esic_questions_answers QA',
            'condition' => 'QA.questionID = Q.id',
            'type' => 'INNER'
        ]
    ];

    $where = [
        'Q.id' => $questionID
    ];

    return $ci->Common_model->select_fields_where_like_join('esic_questions Q',$selectData,$joins,$where,true);
}
function fetchUserQuestionProvidedAnswer($answerID,$userID,$listingID){
    $selectData = '*';
    if(empty($answerID) || !is_numeric($answerID)){
        return false;
    }
    $ci =& get_instance();
    $ci->load->model('Common_model');
    $where =[
        'answer_id' => $answerID,
        'listing_id' => $listingID,
        'user_id' => $userID
    ];
    return $ci->Common_model->select_fields_where('esic_question_users_answers',$selectData,$where,true);
}

function fetchPrePopulatedSubQuestion($listingID){
    if(empty($listingID) || !is_numeric($listingID)){
        return false;
    }
    //get the table name for the listingID
    $ci =& get_instance();
    $ci->load->model('Common_model');
    $selectData = ['id,listName,tableName,slug',false];
    $whereData = [
        'id' => $listingID
    ];
    $result =  $ci->Common_model->select_fields_where('esic_listings',$selectData,$whereData,true);


    if(empty($result)){
        return false;
    }

    $tableName = $result->tableName;
    $slug = $result->tableName;
    switch($slug){
        case 'esic_accelerators': //Universities
            $selectData = ['id as ID, name AS Name',false];
            break;
        case 'esic_institution':
            $selectData = ['id as ID, institution AS Name',false];
            break;
        case 'esic_rndpartner':
            $selectData = ['id as ID, name AS Name',false];
            break;
        case 'esic_acceleration':
            $selectData = ['id as ID, Member as Name',false];
            break;
        case 'esic':
            $selectData = ['id as ID, name as Name',false];
            break;
    }
    $resultData =  $ci->Common_model->select_fields($tableName,$selectData,false);
    $label = $result->listName;
    return [
        'listingID' => $listingID,
        'label' => $label,
        'data' => $resultData
    ];
}

function FrontEndPrePopulatedItemsView($ci,$data){
   $prePopulated  = $data['prePopulated'];
   $subItemID     = $data['subItemID'];
   $ItemID        = $data['ItemID'];
   $Multi         = $data['Multi'];
   $subQuestionID = $data['subQuestionID'];
   $gridDesktop   = $data['gridDesktop'];
   $questionID    = $data['questionID'];
   $type          = $data['type'];
    if(!empty($prePopulated)){ 
?>
   <div class="col-blocks col-xs-12 col-sm-6 <?=$gridDesktop;?> subquestions username question-statement subQuestion prePopulated <?=$subItemID?>_s <?=$ItemID?>_s" 
        data-id= "<?= $prePopulated['listingID'];?>"
        data-questionID= "<?= $questionID; ?>" 
        data-subquestionID= "<?= $subQuestionID; ?>" 
        data-type= "<?= $type; ?>" 
         style="display:none">
            <div class="from-group">
                <?php
                    if(isset($prePopulated['providedSolution']) and !empty($prePopulated['providedSolution'])){
                        //Only then just loop it.
                        $providedSolution = $prePopulated['providedSolution'];
                        $listingTypesIDs = array_column($providedSolution,'listTypeID');
                    }
                    if(!empty($prePopulated['data'])){
                       // echo '<label>Select from '. $prePopulated['label'] .'</label>';
                        if(!empty($listingTypesIDs) and in_array($prePopulated['listingID'],$listingTypesIDs)){
                            $hasInList = true;
                        }
                         
                          if($Multi == 'true'){ // Why the hell i have to check true like that
                              $MultiClass = "select2-active js-example-basic-multiple"; 
                              $Multiple = 'Multiple';
                          }else{
                             $MultiClass = '';
                             $Multiple   = '';
                          }
                      ?>
                         <select class="form-control <?=$MultiClass;?>" <?=$Multiple;?> name="" style="width:100%;" data-placeholder="<?= 'Select from '. $prePopulated['label'];?>" >
                        <?php
                        echo '<option value="0">Select</option>';
                        foreach($prePopulated['data'] as $key=>$row){
                            if(isset($hasInList) and $hasInList===true){
                                $where = [
                                    'selectedItemID'=>$row->ID,
                                    'listTypeID'=>$prePopulated['listingID']
                                ];
                                if(!empty($returned = findWhere($providedSolution,$where))){
                                    $selected = 'selected="selected"';
                                } else {
                                    $selected = '';
                                }
                            }
                            echo '<option value="'.$row->ID.'" '.$selected.'>'.$row->Name.'</option>';
                        }//End of foreach
                        ?>
                        </select>
                    <?php
                    }
                ?>
            </div>
</div>
<?php
    }
}

function BackEndPrePopulatedItemsView($ci,$data){
   $prePopulated = $data['prePopulated'];
   $Multi = $data['Multi'];
   $customEntry = $data['customEntry'];
   $listTypeID = $data['listTypeID'];


    if($customEntry == 'true'){
        //This Option will be setup when needed.
        $customEntryClass = 'col-md-10';
    }else{
        $customEntryClass = 'col-md-12';
    }

    if(!empty($prePopulated)){?>
    <div class="box-body">
        <div class="username question-statement subQuestion prePopulated <?=$customEntryClass?>" data-id="<?=$prePopulated['listingID']?>">
            <div class="from-group">
                <?php
                    if(isset($prePopulated['providedSolution']) and !empty($prePopulated['providedSolution'])){
                        //Only then just loop it.
                        $providedSolution = $prePopulated['providedSolution'];
                        $listingTypesIDs = array_column($providedSolution,'listTypeID');
                    }
                    if(!empty($prePopulated['data'])){
                        echo '<label>Select from '. $prePopulated['label'] .'</label>';
                        if(!empty($listingTypesIDs) and in_array($prePopulated['listingID'],$listingTypesIDs)){
                            $hasInList = true;
                        }
                         if($Multi == 'true'){ // Why the hell i have to check true like that
                              $MultiClass = "select2-active js-example-basic-multiple"; 
                              $Multiple = 'Multiple';
                          }else{
                             $MultiClass = '';
                             $Multiple   = '';
                          }

                        $SelectedAnswers = array();
                        if(!empty($providedSolution)){
                          foreach ($providedSolution as $providedSolutionArray) {
                            if(isset($providedSolutionArray['selectedItemID'])){
                              $SelectedAnswersArray = $providedSolutionArray['selectedItemID'];
                                if(is_array($SelectedAnswersArray)){
                                  foreach ($SelectedAnswersArray as $SelectedAnswer){
                                    array_push($SelectedAnswers, $SelectedAnswer);
                                  }
                                }else{
                                  array_push($SelectedAnswers,$SelectedAnswersArray);
                                }
                             } 
                           }
                         }
                        echo '<select class="form-control '.$MultiClass.'" '.$Multiple.' name="customSelect2">';
                        foreach($prePopulated['data'] as $key=>$row){
                            if(isset($hasInList) and $hasInList===true){
                              if(in_array($row->ID,$SelectedAnswers)){
                                    $selected = 'selected="selected"';
                              } else {
                                    $selected = '';
                              }
                            }
                            echo '<option value="'.$row->ID.'" '.$selected.'>'.$row->Name.'</option>';
                        }//End of foreach
                        echo '</select>';
                    }
                ?>
            </div>
        </div>
        <?php
        if ($customEntry == 'true') {
            $selectModalID = 'slug as modalID';
            $ResultRow = $ci->Common_model->select_fields_where('esic_listings', $selectModalID, ['id'=> $listTypeID], true);
            ?>
            <div class="col-md-2" style="margin-top: 25px;" id="<?=(isset($ResultRow) && !empty($ResultRow))?$ResultRow->modalID.'_DivID':''?>">
                <button type="button" class="btn btn-info btn-block addCustomEntry" data-toggle="modal" data-target="#<?=(isset($ResultRow) && !empty($ResultRow))?$ResultRow->modalID.'Modal':''?>"><i class="fa fa-plus"></i></button>
            </div>
            <?php
        }
        ?>
    </div>
<?php 
    } 
}

function FrontEndSubQuestionView($ci,$data){
    $subItemID = $data['subItemID'];
    $ItemID = $data['ItemID'];
    $subQuestionID = $data['subQuestionID'];
    $questionID = $data['questionID'];
    $type = $data['type'];
    $subQuestion = $data['subQuestion'];

    if(!empty($subQuestion)){
    $questionID = $subQuestion->QuestionID;
    $Question   = $subQuestion->Question;
    $Solution   = $subQuestion->Solution;
    $answerID   = $subQuestion->AnswerID;
    if(!empty($Solution)){
      $solutionArray = json_decode($Solution,true);
      $subtype = $solutionArray['type'];
    }

    //Also Lets fetch the Provided Solution for the SubQuestion as well. if there is any.
    $listID = $ci->uri->segment(4); //Previous it was a userID, so its been kept same as its not effecting the code. only the logic has been changed.
    $providedSolution = fetchUserQuestionProvidedAnswer($answerID,$listID,1); // 1 is for ESIC
    if(!empty($providedSolution)){
        $providedAnswer = json_decode($providedSolution->answer,true);
    }
  ?>
    <div class="col-blocks col-xs-12 col-sm-12 col-md-12 subquestions username question-statement subQuestion <?=$subItemID?>_s <?=$ItemID?>_s" data-item-id=""  data-id="<?= $questionID ?>"
        data-questionID= "<?= $questionID; ?>" 
        data-type= "<?= $type; ?>" 
        data-subquestionID= "<?= $subQuestionID; ?>"  
        data-subtype= "<?= $subtype; ?>" 
         style="display:none">
            <div class="form-group bg-shaded clearfix">
                <div class="col-blocks col-xs-12 col-sm-12 col-md-6">
                  <label for="">
                    <?= $Question ?>
                  </label>
                </div>
                <span class="subQuestionPossibleSolutions">
                <?php
                    if(!empty($Solution) ){
                        $solutionArray = json_decode($Solution,true);
                        switch ($solutionArray['type']){
                            case 'radios':
                               $data = $solutionArray['data'];
                              if (!empty($data)) {
                                  foreach ($data as $key => $radio) {
                                      $radioID  = $radio['id'];
                                      $radioValue = $radio['value'];
                                      $radioText = $radio['text'];
                                      $radioName = explode('_', $radioID);
                                      //Remove the last item.
                                      $answserID = $radioName[2];
                                      unset($radioName[2]);
                                      //Join back the items
                                      $radioName  = implode('_', $radioName);
                                      $ItemNameID = $radioName;
                                     
                                ?>
                                  <div class="col-blocks col-xs-3 col-sm-2 col-md-1 questions" data-id="<?= $radioID;?>" data-type="radios">
                                      <div class="radio">
                                          <label for="<?= $radioID;?>">
                                            <input id="<?= $radioID; ?>" data-answer-id="<?=$answserID;?>" type="radio" value="<?= $radioValue;?>" name="<?= $radioName;?>">
                                              <?= $radioText;?>
                                          </label>
                                       </div>
                                  </div>
                              <?php
                                } 
                              } //End of If (If not empty possible solutions for a question)
                              break;
                            case 'CheckBoxes':
                                if(isset($providedAnswer) and !empty($providedAnswer) and $providedAnswer['type']==='checkbox'){
                                    $selectedCheckBoxes = $providedAnswer['selectedCheckBoxes'];
                                }
                               // echo '<br /><label>Please Select Answer</label>';
                                $data = $solutionArray['data'];
                                echo '<div class="form-group">';
                                foreach($data as $checkbox){
                                    if(isset($selectedCheckBoxes) and in_array_r($checkbox['id'],$selectedCheckBoxes) and in_array_r($checkbox['name'],$selectedCheckBoxes)){
                                        $checked = 'checked="checked"';
                                    }else{
                                        $checked = '';
                                    }
                                    ?>
                                    <div class="checkbox">
                                          <label>
                                            <input type="checkbox" name="<?=$checkbox['id']?>" id="<?=$checkbox['id']?>" <?=$checked?> value="<?= $checkbox['text'];?>">
                                                  <?=$checkbox['text']?>
                                          </label>
                                      </div>
                                    <?php
                                }
                                break;
                            case 'textBoxes':
                                 $data = $solutionArray['data'];

                                 echo '<div class=row>';
                                 $providedText = $providedAnswer['textboxes'];
                                 foreach($data as $key=>$textBox) {
                                     ?>
                                     <div class="col-blocks col-xs-3 col-sm-6 col-md-6" data-id="<?= $textBoxID;?>" data-type="textBoxes">
                                       <div class="form-group <?= $textBox['grid']['grid_size'] ?>">
                                           <label for="<?= $textBox['labelTextBox']['textBoxID'] ?>"><?= $textBox['labelTextBox']['label']?>
                                           </label>
                                           <input type="text" id="<?= $textBox['labelTextBox']['textBoxName'] ?>" 
                                                  name="<?= $textBox['labelTextBox']['textBoxName'] ?>" class="form-control"
                                                  value="<?= (!empty($providedText[$key]['changedValue']) ? $providedText[$key]['changedValue'] : '') ?>">
                                        </div>
                                     </div>
                                     <?php
                                 }//End of Foreach Loop
                                echo '</div>'; //end of row div.
                                break;
                            case 'SelectBox':
                                $label ='';
                                if(!empty($solutionArray['textBoxText'])){
                                    $label = '<label>'.$solutionArray['textBoxText'].'</label>';
                                }
                                if( isset($solutionArray['isDynamic'])
                                   && !empty($solutionArray['isDynamic']) 
                                   && $solutionArray['isDynamic'] === 'Yes'){
                                          $class='isDynamic';
                                }elseif( isset($solutionArray['isMulti']) 
                                  && !empty($solutionArray['isMulti'])
                                  && $solutionArray['isMulti'] === 'Yes'){
                                          $class='customSelect2';
                                }else{
                                    $class='';
                                }
                                $data = $solutionArray['data'];

                                ?>
                                 <div class="col-blocks col-xs-3 col-sm-8 col-md-8 SelectBox" data-id="<?= $questionID;?>" data-type="SelectBox">
                                <?= $label; ?>
                                <select class="form-control <?= $class;?> <?=((isset($solutionArray['isMulti']) && $solutionArray['isMulti'] === 'Yes')?'customSelect2':'')?>" <?=((isset($solutionArray['isMulti']) && $solutionArray['isMulti'] === 'Yes')?'multiple="multiple"':'')?> style="width:100%">
                                      <?php
                                      if(!empty($data)){
                                          foreach($data as $key => $selectOption){
                                            $selected = '';
                                            if(!empty($providedAnswer['selectedSelectValue'])){
                                              if(in_array($selectOption['value'],$providedAnswer['selectedSelectValue'])){
                                                  $selected='selected="selected"';
                                              }
                                            }
                                              echo '<option value="'.$selectOption['value'].'" '.(isset($selected)?$selected:'').'>'.$selectOption['text'].'</option>';
                                          }
                                      }
                                      ?>
                                  </select>
                                  </div>
                                <?php
                                break;
                        }//End of Switch
                    }//If Not Empty Solution.
                ?>
            </span>
          </div>
    </div>

<?php 
    }
}


function BackEndSubQuestionView($ci,$data){
    $subQuestion = $data['subQuestion'];
    $parentQuestionID = $data['parentQuestionID'];
    $listingTypeID = $data['listingTypeID'];
    if(!empty($subQuestion)){
    $questionID = $subQuestion->QuestionID;
    $Question = $subQuestion->Question;
    $Solution = $subQuestion->Solution;
    $type = $subQuestion->Type;
    $answerID = $subQuestion->AnswerID;

    //Also Lets fetch the Provided Solution for the SubQuestion as well. if there is any.
    $listID = $ci->uri->segment(4); //Previous it was a userID, so its been kept same as its not effecting the code. only the logic has been changed.
    $providedSolution = fetchUserQuestionProvidedAnswer($answerID,$listID,(isset($listingTypeID))?$listingTypeID:1); // 1 is for ESIC

    if(!empty($providedSolution)){
        $providedAnswer = json_decode($providedSolution->answer,true);
    }

    ?>

    <div class="box-body">
        <div class="username question-statement subQuestion" data-id="<?= $questionID ?>">
            <a href="#"><?= $Question ?></a>
            <span class="subQuestionPossibleSolutions">
                <?php
                    if(!empty($Solution) ){
                        $solutionArray = json_decode($Solution,true);
                        switch ($solutionArray['type']){
                            case 'radios':
                                break;
                            case 'CheckBoxes':
                                if(isset($providedAnswer) and !empty($providedAnswer) and $providedAnswer['type']==='checkbox'){
                                    $selectedCheckBoxes = $providedAnswer['selectedCheckBoxes'];
                                }
                                echo '<br /><label>Please Select Answer</label>';
                                $data = $solutionArray['data'];
                                echo '<div class="form-group">';
                                foreach($data as $checkbox){
                                    if(isset($selectedCheckBoxes) and in_array_r($checkbox['id'],$selectedCheckBoxes) and in_array_r($checkbox['name'],$selectedCheckBoxes)){
                                        $checked = 'checked="checked"';
                                    }else{
                                        $checked = '';
                                    }
                                    ?>
                                    <div class="checkbox">
                                              <label>
                                                  <input type="checkbox" name="<?=$checkbox['name']?>" id="<?=$checkbox['id']?>" <?=$checked?>>
                                                  <?=$checkbox['text']?>
                                              </label>
                                          </div>
                                    <?php
                                }
                                echo '</div>';
                                break;
                            case 'textBoxes':
                                 $data = $solutionArray['data'];

                                 echo '<div class=row>';
                                 $providedText = $providedAnswer['textboxes'];
                                 foreach($data as $key=>$textBox) {
                                     ?>
                                     <div class="form-group <?= isset($textBox['grid']['grid_size'])?'col-md-'.$textBox['grid']['grid_size'] :''?>">
                                         <label for="<?= $textBox['labelTextBox']['textBoxID'] ?>"><?= $textBox['labelTextBox']['label']?></label>
                                         <input type="text" id="<?= $textBox['labelTextBox']['textBoxName'] ?>"
                                                name="<?= $textBox['labelTextBox']['textBoxName'] ?>" class="form-control"
                                                value="<?= (!empty($providedText[$key]['changedValue']) ? $providedText[$key]['changedValue'] : '') ?>">
                                     </div>
                                     <?php
                                 }//End of Foreach Loop
                                echo '</div>'; //end of row div.
                                break;
                            case 'SelectBox':
                                if(empty($solutionArray['textBoxText'])){
                                    echo '<br/><label>Please Select Answer</label>';
                                }else{
                                    echo '<br/><label>'.$solutionArray['textBoxText'].'</label>';
                                }
                                $data = $solutionArray['data'];

                                if(isset($solutionArray['isDynamic']) and !empty($solutionArray['isDynamic']) and  $solutionArray['isDynamic'] === 'Yes'){
                                    $class='isDynamic';
                                }elseif(isset($solutionArray['isMulti']) and !empty($solutionArray['isMulti']) and  $solutionArray['isMulti']=== 'Yes'){
                                    $class='customSelect2';
                                }else{
                                    $class='';
                                }
                                ?>
                                <select class="form-control <?=$class?>" <?=((isset($solutionArray['isMulti']) && $solutionArray['isMulti'] === 'Yes')?'multiple="multiple"':'')?> style="width:100%">
                                      <?php

                                      if ($class === 'isDynamic' and isset($providedAnswer['selectedSelectValue']) and !empty($providedAnswer['selectedSelectValue'])) {


                                          //There was a little Issue with my previous code, where answer of 1 sub-question was same parent Question of all.
                                          //But Now. Answer of a single subQuestion assigned to multiple parent questions will hold different answers respective to their parent question IDs

                                          //For This We need to check if there is a solution for this question or not.
                                          $providedUpdatedAnswer = array_filter($providedAnswer['selectedSelectValue'],function($providedSolutionArray) use($parentQuestionID){
                                              if(intval($providedSolutionArray['parentQID']) === intval($parentQuestionID)){
                                                return true;
                                              }
                                          });

                                          if(!empty($providedUpdatedAnswer)){
                                              //As Now we have gotten our selected Solution. We Just Need to Get the Values to Continue working with Old Code.
                                              $providedAnswer['selectedSelectValue'] = array_values($providedUpdatedAnswer)[0]['selectedValues'];
                                          }else{
                                              $providedAnswer['selectedSelectValue'] = [];
                                          }



                                          if(!empty($providedAnswer['selectedSelectValue'])){
                                              $possibleValuesDataArray = array_column($data,'value');
                                              foreach($providedAnswer['selectedSelectValue'] as $key=> $value){
                                                  if(!in_array($value,$possibleValuesDataArray)){
                                                      //push if not exist.
                                                      $arrayToPush = [
                                                          'value' => $value,
                                                          'text' => $value
                                                      ];
                                                      array_push($data,$arrayToPush);
                                                  }//End of If Statement/ If Not in Array.
                                              }//End of Foreach Statement
                                          }
                                      }//End of If type is Dynamic

                                      if(!empty($data)){
                                          foreach($data as $key => $selectOption){
                                              if(in_array($selectOption['value'],$providedAnswer['selectedSelectValue'])){
                                                  $selected='selected="selected"';
                                              }else{
                                                  $selected = '';
                                              }
                                              echo '<option value="'.$selectOption['value'].'" '.(isset($selected)?$selected:'').'>'.$selectOption['text'].'</option>';
                                          }
                                      }
                                      ?>
                                  </select>
                                <?php
                                break;
                        }//End of Switch
                    }//If Not Empty Solution.
                ?>
            </span>
        </div>
    </div>

<?php 
    }
}
/**
 * @function trimString
 */
 if(!function_exists('trimString')){
    function trimString($str) {
      truncateString(strip_tags($str),200, false);
       return $str;
    }
}

/**
 * @function truncateString
 */
if(!function_exists('truncateString')){
    function truncateString($str, $chars, $to_space, $replacement="...") {
       if($chars > strlen($str)) return $str;

       $str = substr($str, 0, $chars);
       $space_pos = strrpos($str, " ");
       if($to_space && $space_pos >= 0)
           $str = substr($str, 0, strrpos($str, " "));

       return($str . $replacement);
    }
}

/**
 * @function getAlias
 */
if(!function_exists('getAlias')){
    function getAlias($name,$spaceReplacement = '_'){
        $alias = str_replace(' ',$spaceReplacement ,$name);
        $alias = strtolower($alias);
        $alias = preg_replace('/[^A-Za-z0-9\_]/', '', $alias); // Removes special chars.
        return $alias;
    }
}

/**
 * @function checkSameSlugIsExistForListingID
 */
if(!function_exists('checkSameSlugIsExistForListingID')){
    function checkSameSlugIsExistForListingID($ci, $Slug,$listingID){
        $where = array('id' => $listingID,);
        $selectData = array('slug',false);
        $slugs = $ci->Common_model->select_fields_where($ci->tableName,$selectData,$where,true);
        $slugDB = '';
        if(!empty($slugs)){
            $slugDB = $slugs->slug;
        }
        if($slugDB == $Slug){
            return true;
        }
         return false;
     }
}

/**
 * @function checkAndChangeIfAlreadyExistSlug
 */
if(!function_exists('checkAndChangeIfAlreadyExistSlug')){
    function checkAndChangeIfAlreadyExistSlug($ci, $Slug){
        $where = array('slug' => $Slug);
        $selectData = array('slug',false);
        $slugCheckArray = array();
        $slugs = $ci->Common_model->select_fields_where($ci->tableName,$selectData,$where);
        $slugCheckArray = array();
            if(!empty($slugs)){
                $slugs = $ci->Common_model->select_fields($ci->tableName,$selectData);
                foreach ($slugs as $key => $slug) {
                    array_push($slugCheckArray, $slug->slug);
                }
            }else{
                return $Slug;
            }
            $Slug = changeSlug($Slug,$slugCheckArray);
        return $Slug;
    }
}

/**
 * @function changeSlug
 */
if(!function_exists('changeSlug')){
    function changeSlug($Slug,$CheckArray){
        if(!in_array($Slug,$CheckArray)){
            return $Slug;
        }else{
            $name = $Slug; 
            $unique = false;
            $max_limit = 200;
            $count = 0;
            while($unique == false){
                $count++;
                $result = checkSlug($name,$CheckArray);
                if($result['duplicate'] == false){
                    $unique = true;
                    $Slug = $result['unique'];
                }else{
                    $name = $result['unique'];
                }
                if($count > $max_limit){
                    $Slug = rand(100,10000);
                    break;
                }
            }
            return $Slug;
        }
    }
}

/**
 * @function checkSlug
 */
if(!function_exists('checkSlug')){
    function checkSlug($name,$CheckArray){
        $returnArray = array();
        $Check   = checkForDuplicated($name,$CheckArray);  
        if($Check){
            $pos = strrpos($name,'_',-1);
            if($pos){
                $parts = explode("_",$name);
                $lastPart = end($parts);
                $lastPartKey = key($parts);
                    if(is_numeric($lastPart)){
                        $int = intval($lastPart);  
                        $int = $int + 1;
                        unset($parts[$lastPartKey]);
                        $parts[$lastPartKey] = $int;
                        $parts = implode('_', $parts);
                        $Check = checkForDuplicated($parts,$CheckArray);
                        $returnArray['unique'] = $parts;

                    }else{
                        $returnArray['unique'] = $parts[0].'_1';
                    }
            }else{
                $returnArray['unique'] = $name.'_1';
                $Check = checkForDuplicated($returnArray['unique'],$CheckArray);
            }
        }else{
            $returnArray['unique'] = $name;       
        }
        $returnArray['duplicate'] = $Check;
        return $returnArray;
    }
}
/**
 * @function checkForDuplicated
 */
if(!function_exists('checkForDuplicated')){
    function checkForDuplicated($name,$CheckArray){
        if(in_array($name, $CheckArray)){
            return true; 
        }else{
            return false;
        }
    }
}


/**
 * @function convertAlias
 */
if(!function_exists('convertAlias')){
    function convertAlias($name,$spaceReplacement = '_'){
        $alias = str_replace($spaceReplacement,' ',$name);
        $alias = strtolower($alias);
        $alias = preg_replace('/[^A-Za-z0-9\_]/', '', $alias); // Removes special chars.
        return $alias;
    }
}

/**
 * @function getDefaultBannerUrl
 */
if(!function_exists('getDefaultBannerUrl')){
    function getDefaultBannerUrl(){
        return base_url().'pictures/defaultBanner.jpg';
    }
}

/**
 * @function getDefaultLogoUrl
 */
if(!function_exists('getDefaultLogoUrl')){
    function getDefaultLogoUrl(){
        return base_url().'pictures/defaultLogo2.jpg';
    }
}

/**
 * @function getTemplateFileName
 */
if(!function_exists('getTemplateFileName')){
    function getTemplateFileName($ci,$templateID){
        $where = array('id' => $templateID);
        $results = $ci->Common_model->select_fields_where($ci->tableNameTemplates,'file_name as TemplateFileName',$where,true);
        if(!empty($results)){
            return $results->TemplateFileName;
        }
        return false;
    }
}


/**
 * @function srcImage
 */
if(!function_exists('srcImage')){
    function srcImage($dbData) {
        $defaultImage = base_url() . "assets/img/logo-placeholder.png";
        if (empty($dbData)) {
            return $defaultImage;
        }
        $imagePath = base_url().$dbData;

        //Will look in to this later.
        $fileExists = file_exists($dbData);

        if($fileExists){
            return $imagePath;
        }else{
            return $defaultImage;
        }


    }
}

/**
 * @function srcListingBannerImage
 */
function srcListingBannerImage($dbData){
    $defaultImage = base_url() . "assets/img/backgroundImage.jpg";
    if (empty($dbData)) {
        return $defaultImage;
    }
    $imagePath = base_url().$dbData;

    //Will look in to this later.
    $fileExists = file_exists($dbData);

    if($fileExists){
        return $imagePath;
    }else{
        return $defaultImage;
    }
}

/**
 * @function getSlugURL
 */
function getSlugURL($slug,$listType){
    switch ($listType){
        case 'Acceleration':
            return base_url('AcceleratingCommercialisation/'.$slug);
            break;
        case 'Esic':
            //return base_url('esic_database/company/'.$slug);
            return base_url('Esic/'.$slug);
            break;
        case 'Accelerators':
            return base_url('Accelerator/'.$slug);
            break;
        case 'R&D Partners':
            return base_url('RndPartner/'.$slug);
            break;
        case 'Institution':
            return base_url('University/'.$slug);
            break;
        case 'Investor':
            return base_url('Investor/'.$slug);
            break;
        case 'R&D Consultant':
            return base_url('RndConsultant/'.$slug);
            break;
        case 'Lawyer':
            return base_url('Lawyer/'.$slug);
            break;
        case 'GrantConsultant':
            return base_url('GrantConsultant/'.$slug);
            break;

    }
}


/**
 * @function array_orderBy
 */
if(!function_exists('array_orderBy')) {
    function array_orderBy(){
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {

                //Check if is Date.
                if (strpos($field, ':::') !== false) {
                    $explodedField = explode(":::",$field);
                    $dateCol=true;
                    $field = $explodedField[0];
                }else{
                    $dateCol=false;
                }

                $tmp = array();
                foreach ($data as $key => $row)
                    if($dateCol){
                        $tmp[$key] = strtotime($row[$field]);
                    }else{
                        $tmp[$key] = $row[$field];
                    }
                $args[$n] = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }
}

/**
 * @function date_compare
 */
if(!function_exists('date_compare')){
    function date_compare($a, $b){
        $t1 = strtotime($a['datetime']);
        $t2 = strtotime($b['datetime']);
        return $t1 - $t2;
    }
}

/**
 * @function getBlogs
 */
if(!function_exists('getBlogs')){
    function getBlogs($ci,$number = 10){
        $where = array('status' => 1 );
        return $ci->Common_model->select_fields_where('esic_blog','*',$where);
    }
}

/**
 * @function getBlogSlug
 */
if(!function_exists('getBlogSlug')){
    function getBlogSlug($id, $title){
        $links = str_replace(" ","_",$title);
        $links = str_replace("'","",$links);
        return base_url().'blog/'.$id."/".$links; 
    }
}


if(!function_exists('loadModals')){
    function loadPrePopulatedSelectModals($ci, $neededModals){
        if(empty($neededModals) || !is_array($neededModals)){
            return false;
        }

        foreach($neededModals as $neededModal){
            //name, email, website
            if($neededModal === '1'){
                ?>
                <div id="esicModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <form method="POST" action="<?=base_url()?>">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Esic</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="companyName">Company Name</label>
                                    <input class="form-control" type="text" name="name" id="companyName">
                                </div>
                                <div class="form-group">
                                    <label for="companyEmail">Company Email</label>
                                    <input class="form-control" type="text" name="email" id="companyEmail">
                                </div>
                                <div class="form-group">
                                    <label for="companyEmail">Company Website</label>
                                    <input class="form-control" type="text" name="website" id="companyEmail">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success add_customInPrePopulated">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }

            if($neededModal === '2'){
                ?>
                <div id="esic_investorModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <form method="POST" action="<?=base_url()?>">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Investor</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="companyName">First Name</label>
                                    <input class="form-control" type="text" name="name" id="companyName">
                                </div>
                                <div class="form-group">
                                    <label for="companyEmail">Email</label>
                                    <input class="form-control" type="text" name="email" id="companyEmail">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success add_customInPrePopulated">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }

            if($neededModal === '3'){
                ?>
                <div id="esic_acceleratorsModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <form method="POST" action="<?=base_url()?>">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Accelerator</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input class="form-control" type="text" name="name" id="firstName">
                                </div>
                                <div class="form-group">
                                    <label for="acceleratorEmail">Email</label>
                                    <input class="form-control" type="text" name="email" id="acceleratorEmail">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success add_customInPrePopulated">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                            </form>
                        </div>

                    </div>
                </div>
                <?php
            }

            if($neededModal === '4'){
                ?>
                <!-- Modal -->
                <div id="esic_institutionModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <form method="POST" action="<?=base_url()?>">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add University</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="universityName">University Name</label>
                                    <input class="form-control" type="text" name="institution" id="universityName">
                                </div>
                                <div class="form-group">
                                    <label for="universityWebsite">Website</label>
                                    <input class="form-control" type="text" name="website" id="universityWebsite">
                                </div>
                                <div class="form-group">
                                    <label for="universityEmail">Email</label>
                                    <input class="form-control" type="text" name="email" id="universityEmail">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success add_customInPrePopulated">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }

            if($neededModal === '5'){
                ?>
                <!-- Modal -->
                <div id="esic_rndpartnerModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <form method="POST" action="<?=base_url()?>">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add R&D Partner</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="rndIdNumber">ID Number</label>
                                    <input class="form-control" type="text" name="IDNumber" id="rndIdNumber">
                                </div>
                                <div class="form-group">
                                    <label for="rndName">Name</label>
                                    <input class="form-control" type="text" name="name" id="rndName">
                                </div>
                                <div class="form-group">
                                    <label for="rndWebsite">Website</label>
                                    <input class="form-control" type="text" name="website" id="rndWebsite">
                                </div>
                                <div class="form-group">
                                    <label for="rndEmail">Email</label>
                                    <input class="form-control" type="text" name="email" id="rndEmail">
                                </div>
                                <div class="form-group">
                                    <label for="ANZSRC">ANZSRC</label>
                                    <input class="form-control" type="text" name="ANZSRC" id="ANZSRC">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success add_customInPrePopulated">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }

            if($neededModal === '6'){
                ?>
                <!-- Modal -->
                <div id="esic_accelerationModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <form method="POST" action="<?=base_url()?>">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Acceleration</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="accelerationName">Name</label>
                                    <input class="form-control" type="text" name="Member" id="accelerationName">
                                </div>
                                <div class="form-group">
                                    <label for="accelerationWebsite">Website</label>
                                    <input class="form-control" type="text" name="Web_Address" id="accelerationWebsite">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success add_customInPrePopulated">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }

            if($neededModal === '7'){
                ?>
                <!-- Modal -->
                <div id="esic_lawyersModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <form method="POST" action="<?=base_url()?>">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Lawyer</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="lawerName">Name</label>
                                    <input class="form-control" type="text" name="name" id="lawerName">
                                </div>
                                <div class="form-group">
                                    <label for="lawyerPhone">Phone</label>
                                    <input class="form-control" type="text" name="phone" id="lawyerPhone">
                                </div>
                                <div class="form-group">
                                    <label for="LawyerEmail">Email</label>
                                    <input class="form-control" type="text" name="email" id="LawyerEmail">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success add_customInPrePopulated">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }

            if($neededModal === '8'){
                ?>
                <!-- Modal -->
                <div id="esic_grantconsultantModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Grant Consultant</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="lawerName">Name</label>
                                    <input class="form-control" type="text" name="name" id="grantConsultantName">
                                </div>
                                <div class="form-group">
                                    <label for="lawyerPhone">Website</label>
                                    <input class="form-control" type="text" name="website" id="grantConsultantWebsite">
                                </div>
                                <div class="form-group">
                                    <label for="universityEmail">Email</label>
                                    <input class="form-control" type="text" name="email" id="grantConsultantEmail">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success add_customInPrePopulated">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
                <?php
            }

            if($neededModal === '9'){
                ?>
                <!-- Modal -->
                <div id="esic_rndconsultantModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add R&D Consultant</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="lawerName">Name</label>
                                    <input class="form-control" type="text" name="name" id="rndConsultantName">
                                </div>
                                <div class="form-group">
                                    <label for="rndConsultantEmail">Email</label>
                                    <input class="form-control" type="text" name="email" id="rndConsultantEmail">
                                </div>
                                <div class="form-group">
                                    <label for="rndConsultantWebsite">Website</label>
                                    <input class="form-control" type="text" name="website" id="rndConsultantWebsite">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
                <?php
            }
        }
    }
}
if(!function_exists('validate_date')){
    function validate_date($date){
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
}
if(!function_exists('methods')){
    function methods($ci, $array){
        $methodName = $ci->router->fetch_method();
        if(in_array($methodName,$array)){
            return true;
        }
    }
}

if(!function_exists('get_listings_fields')){
    function get_listings_fields($listingTableName){
        //We Need Extra Columns from these Listings that are different in different tables.
        $columns = [];
        switch($listingTableName){
            case 'esic':
                $columns[] = ['column' => 'corporate_date','alias'=>'Corporate Date','editable' => true];
                $columns[] = ['column' => 'expiry_date','alias'=>'Expiry Date','editable'=>true];
                $columns[] = ['column' => 'added_date','alias'=>'Added Date','editable'=>false];
                break;
            case 'esic_lawyers':
                break;
            case 'esic_grantconsultant':
                break;
            case 'esic_accelerators':
                break;
            case 'esic_acceleration':
                break;
            case 'esic_investors':
                break;
            case 'esic_rndconsultant':
                break;
            case 'esic_rndpartner':
                $columns[] = ['column' => 'ANZSRC','alias'=>'ANZSRC'];
                $columns[] = ['column' => 'programName','alias'=>'Program'];
                $columns[] = ['column' => 'programStartDate','alias'=>'Program Start Date'];
                $columns[] = ['column' => 'work','alias'=>'What he does'];
                break;
            case 'esic_institution':
                break;
        }
        return $columns;
    }
}

if(!function_exists('page_message')){
    function page_message($ci, $message){
        $langMessage = $ci->lang->line($message);
        if(!empty($langMessage)){
            $ci->data['message'] = $langMessage;
        }elseif(!empty($message)){
            $ci->data['message'] = $message;
        }else{
            return false;
        }
        $ci->load->view('admin/components/notification',$ci->data);
    }
}

if(!function_exists('getListingSocialInfo')){
    function getListingSocialInfo($ci,$listingID,$userID){
        if(empty($listingID) || !is_numeric($listingID)){
            return false;
        }

        //Fetch Records from Social.
        $table = $ci->tableNameSocial;
        $where = ['listingID'=>$listingID];
        if(!empty($userID) and is_numeric($userID)){
            $where['userID'] = $userID;
        }
        return $ci->Common_model->select_fields_where($table,'*',$where,true);
    }
}

if(!function_exists('assignRoleToUser')){
    function assignAllRolesToUser($ci){
        $userID   = $ci->session->userdata('userID');
        //$userRole = $ci->session->userdata('userRole');
        $where = array(
            'userID'   => $userID
        );
        $roles = '["2","3","4","5","6","7","8"]';
        $result = $ci->Common_model->update($ci->tableNameUser, $where, array('userRole'=>$roles));
        if($result){
            return true;
        } else
            return false;
    }
}

// approve version
if(!function_exists('approveNewVersion')){
    function approveNewVersion($verId, $listId, $ci){
      
    $where = array(
        'id'=>$verId
    );
    $result = $ci->Common_model->select_fields_where($ci->versionTable, '*', $where, true);
    $result->is_new_ver = 'No';
    $field = $ci->listingField;
    $where = array('id' => $result->$field);
    // this are some additional columns in version table, remove them from array and then update
    $unsetAttr = [$field, 'id', 'Publish', 'not_approve', 'cancel_msg'];
    foreach($unsetAttr as $attr)
        unset($result->$attr);

    // update active table
    $response = $ci->Common_model->update($ci->tableName, $where, $result);
    if($response){
        // set not_approve to zero in version table
        $ci->Common_model->update($ci->versionTable, ['id'=>$verId], ['not_approve'=>0]);
        return 'OK::New Version of '.$result->name.' has been approved::success::Version Approved';
    } else {
        return 'OK::Error! New version has not approved::error::Not Approved';
    }
}
}