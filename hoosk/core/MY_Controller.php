<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property Common_model $Common_model It resides all the methods which can be used in most of the controllers.
 * @property Hoosk_model $Hoosk_model It resides all the methods which can be used in most of the controllers.
 */
class MY_Controller extends CI_Controller{

	public $base_url;
    public $DefaultRedirectUrl  = 'home';
    public $tableNameUser       = 'hoosk_user';
    public $tableNameRoles      = 'users_role';
    public $tableNamePermission = 'users_permisson';

    public $answersTable        = 'esic_questions_answers';
    public $listingsTable       = 'esic_listings';
    public $questionsTable      = 'esic_questions';
    public $userAnswersTable    = 'esic_question_users_answers';
    public $questionListingTable = 'esic_questions_listings';

    //Listing Tables
    public $RND_Partners       = 'esic_rnd';
    public $accelerators       = 'esic_accelerators';
    public $universitiesTable  = 'esic_institution';
    public $acceleratingCommercialisation = 'esic_acceleration';

    public $tableNameTemplates  = 'esic_templates';
    protected $statesTable;
    protected $postCodesTable;

    //To Minify it use "structureFooterJS" as paramenter
    protected $structureFooterJSFiles = [
        "theme/admin/js/jquery-1.12.4.min.js",
        "assets/js/jquery-ui.js",
        "assets/js/bootstrap.min.js",
        "assets/js/jasny-bootstrap.min.js",
        "assets/js/moment.js",
        "assets/js/bootstrap-datepicker.js",
        "assets/js/daterangepicker.js",
       "assets/js/templateScripts/structure_footer.js",
        //Extra Files That Was Used After Owl Carosel, but now will be executed before Owl Carousel Slider.
        "assets/js/widgets.js",
        "assets/js/jquery.redirect.min.js",
        "theme/admin/js/noty/packaged/jquery.noty.packaged.min.js",
        "theme/admin/js/Haider.js",
        "assets/vendors/select2/dist/js/select2.full.min.js",
    ];
    //structureHeaderCSS
    protected $structureHeaderCSSFiles = [];
    protected $previewTemplateFooterJSFiles = [];

	/**
	 * Class constructor
	 */
	public function __construct(){
	parent::__construct();
        date_default_timezone_set('Australia/Sydney');
		$this->base_url = BASE_URL;
		define("HOOSK_ADMIN",1);
		$this->load->helper(array('admincontrol','hoosk_admin','url','hoosk_page','email_helper','form','active_menu_helper'));
        $this->load->library('twitteroauths');
        $this->load->model(array('Hoosk_model','User_model','Esic_model','Investor_model','Accelerator_model','Rndpartner_model','Rndconsultant_model','Lawyer_model','Grantconsultant_model','University_model','Common_model','Imagecreate_model'));
        checkifSessionExist($this);
		define ('LANG', $this->Hoosk_model->getLang());
		$this->lang->load('admin', LANG);
		define ('SITE_NAME', $this->Hoosk_model->getSiteName());
		define('THEME', $this->Hoosk_model->getTheme());
		define ('THEME_FOLDER', BASE_URL.'/theme/'.THEME);


		//For Minification
        $this->structureHeaderCSSFiles = [
            "theme/".THEME."/css/bootstrap.min.css",
            "assets/css/jasny-bootstrap.min.css",
            "assets/css/bootstrap-datepicker.min.css",
            "assets/css/AdminLTE.min.css",
            "theme/".THEME."/css/styles.css",
            "assets/css/daterangepicker.css",
            "assets/vendors/select2/dist/css/select2.min.css",
//            "theme/".THEME."/css/socicon.css",
            "theme/".THEME."/css/jquery-ui.css",
        ];
        $this->previewTemplateFooterJSFiles = [
            'assets/vendors/select2/dist/js/select2.full.js',
            'assets/js/listing.js'
        ];

        //We Need Some Settings from Database.
        //Load Values from DB
        $config = $this->db->get('hoosk_social_setting')->result();
        //Assign Values to Config File.
        if(isUserLoggedIn($this)){
            $this->data['CurrentUserData'] =  getCurrentUserData($this);
            $this->data['UserLoggedIn']    = true;
        }else{
            $this->data['UserLoggedIn']    = false;
        }

        $url = str_replace($_SERVER["HTTP_HOST"], '', BASE_URL);
        $url = $_SERVER["DOCUMENT_ROOT"].''.$url;
        $url = str_replace('http://', '', $url);
        $url = str_replace('https://', '', $url);
        define ('DoucmentUrl', $url);
        $this->data['current'] = $this->uri->segment(2);
        $totSegments = $this->uri->total_segments();
        if(!is_numeric($this->uri->segment($totSegments))){
            $pageURL = $this->uri->segment($totSegments);
        }else if(is_numeric($this->uri->segment($totSegments))){
            $pageURL = $this->uri->segment($totSegments-1);
        }
        if ($pageURL == ""){ $pageURL = "home"; }
        $this->load->model('Hoosk_page_model');
        $this->data['page']             = $this->Hoosk_page_model->getPage($pageURL);
        $this->data['settings']         = $this->Hoosk_page_model->getSettings();
        $this->data['settings_footer']  = $this->Hoosk_model->getSettings();
        $this->data['permissions'] = getCurrentUserPermissions($this);
        $this->data['bodyClasses'] = 'body-class ';

        $this->config->load('twitter');
        if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret')){
            // If user already logged in
            $this->connection = $this->twitteroauths->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('access_token'),  $this->session->userdata('access_token_secret'));
        }elseif($this->session->userdata('request_token') && $this->session->userdata('request_token_secret')){
            // If user in process of authentication
            $this->connection = $this->twitteroauths->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('request_token'), $this->session->userdata('request_token_secret'));
        }else{
            // Unknown user
            $this->connection = $this->twitteroauths->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'));
        }

         //Values
        $this->statesTable = 'states';
        $this->postCodesTable = 'sys_post_codes';

      // Admincontrol_helper::SavePreviousStatus($this);
	}
        /**
     * Class destructor 
     */
    public function __destructor(){
        parent::__destructor();
        $this->session->unset_userdata('DefaultRedirectUrl');
    }
    public function __setMagic($name, $value){
        $this->session->set_userdata($name,$value);
    }
    public function __getMagic($name){
        if($this->session->userdata($name)){
            $value = $this->session->userdata($name);
            $this->session->unset_userdata($name);
            return $value;
        }
        return 0;
    }
    public function show_front($viewPath, $data = NULL, $bool = false){
        $this->load->view('structure/header',$data, $bool);
        $this->load->view($viewPath, $data, $bool);
        $this->load->view('structure/footer',$data, $bool);
    }
    public function show_front_listing_form($viewPath, $data = NULL, $bool = false){
        $this->load->view('structure/head_front' ,$this->data);
        $this->load->view('structure/head_block_front' ,$this->data);
        $this->load->view($viewPath, $data, $bool);
        $this->load->view('structure/foot_block_front' ,$this->data);
        $this->load->view('structure/foot_front' ,$this->data);
    }
	public function show_admin($viewPath, $data = NULL, $bool = false){
	    $this->load->view('admin/header',$data, $bool);
	    $this->load->view($viewPath, $data, $bool);
	    $this->load->view('admin/footer',$data, $bool);
	}
	public function show_admin_configuration($viewPath, $data = NULL, $bool = false){
	    $this->load->view('admin/header',$data, $bool);
	    $this->load->view('structure/head',$data, $bool);
	    $this->load->view($viewPath, $data, $bool);
	    $this->load->view('structure/foot',$data, $bool);
	    $this->load->view('admin/footer',$data, $bool);
	}
	public function show_admin_listing($viewPath, $data = NULL, $bool = false){
	    $this->load->view('admin/header',$data, $bool);
	    $this->load->view('structure/head',$data, $bool);
	    $this->load->view('structure/listing-top',$data, $bool);

//        echo "<pre>";
//        print_r($data);
//        var_dump($bool);
//        exit;

	    $this->load->view($viewPath, $data, $bool);
        if($this->statusText && isCurrentUserAdmin($this)){
            $this->load->view('structure/confirm_modal');
        }
	   	$this->load->view('structure/foot',$data, $bool);
	    $this->load->view('structure/listing-bottom',$data, $bool);
	    $this->load->view('admin/footer',$data, $bool);
	}
	public function show_configuration($viewPath, $data = NULL, $bool = false){
	    $this->load->view('structure/head_front',$data, $bool);
	    $this->load->view($viewPath, $data, $bool);
	    $this->load->view('structure/foot_front',$data, $bool);
	}
    public function show_view($viewPath, $data = NULL, $bool = false){
        $this->load->view('structure/preview_head',$data, $bool);
        $this->load->view('structure/head_front',$data, $bool);
        $this->load->view($viewPath, $data, $bool);
        $this->load->view('structure/foot_front',$data, $bool);
        $this->load->view('structure/preview_foot',$data, $bool);
    }
    public function show_view_without_head($viewPath, $data = NULL, $bool = false){
        $this->load->view('structure/head_front',$data, $bool);
        $this->load->view($viewPath, $data, $bool);
        $this->load->view('structure/foot_front',$data, $bool);
    }
    public function getQAnswers($listingID = NULL, $all=false){

        if($listingID === NULL || !is_numeric($listingID)){
            $listingID = 1;
        }

        $selectData2 = array('        
                    EQ.Question as Question,
                    EQ.id as questionID,
                    QPS.Solution as PossibleSolutions,
                    QL.order as QuestionOrder,
                    QL.id as ListItemID,
                    QL.isRequired
            ',false);//ES.Score as points

        $where = [
            'EQ.`isPublished`' => 1,
            'QL.listing_id' => $listingID,
            '`EQ`.`isSub` !='=> 1,
            'EQ.`isTrashed`' => 0,
        ];
        if(!empty($year)){
            $where['EQ.`year` ='] = $year;
        }else{
            $c_date = date('Y-m-d');
            $c_Year = date('Y');
            if( $c_date > date("$c_Year-06-30") && $c_date <= date("$c_Year-12-31") ){
                $c_Year +=1; // 2019 questions
                $where['EQ.`year` ='] = $c_Year;
            }else if($c_date < date("$c_Year-07-01") && $c_date >= date("$c_Year-01-01") ){
                $c_Year = date('Y'); //2018 Questions
                $where['EQ.`year` ='] = $c_Year;
            }
        }
        if($all===false){
            $where['QL.isPublished'] = 1;
        }
        $joins2 = array(
            array(
                'table' => 'esic_questions_listings QL',
                'condition' => 'QL.question_id = EQ.id',
                'type' => 'LEFT'
            ),
            array(
                'table' => 'esic_questions_answers QPS',
                'condition' => 'QPS.questionID = EQ.id',
                'type' => 'LEFT'
            ),
            array(
                'table' => 'esic_question_users_answers UA',
                'condition' => 'UA.answer_id = QPS.id',
                'type' => 'LEFT'
            )
        );
        $groupBy = ['EQ.id'];
        $orderBy = 'QL.order';
        $result =  $this->Common_model->select_fields_where_like_join('esic_questions EQ',$selectData2,$joins2,$where,FALSE,'','',$groupBy,$orderBy);
        return $result;

    }
    public function EmailCheck(){
        CheckUserEmail($this);
        return null;
    }
    protected function _getStates(){
        $selectData = [
            '
            `name` as `State`,
             abbreviation as `Value`
            ',
            false
        ];
        $states = $this->Common_model->select_fields($this->statesTable,$selectData,false,'','',true);
        return $states;
    }
    protected function _getState($StateAbbreviation){
        $where = array('abbreviation' => $StateAbbreviation);
        $states = $this->Common_model->select_fields_where($this->statesTable,'name',$where,true);
        return $states->name;
    }
    protected function _getSelectedPostCodes($selected=NULL){
        $selectData = [
            '
            `id` as `ID`,
             CONCAT(postcode) as `TEXT`
            ',
            false
        ];
        $multipleBool = true;
        if(!empty($selected) and is_array($selected)){
            $selectedPostIDs = implode(',',$selected);
            $where = 'id IN('.$selectedPostIDs.')';
        }elseif(!empty($selected) and is_string($selected)){
            $where = ['id'=>$selected];
        }else{
            return false;
        }
        $postCodes = $this->Common_model->select_fields_where($this->postCodesTable,$selectData,$where,false,'','','','','',$multipleBool);
        return json_encode($postCodes);
    }
    protected function _getPostCode($postCodeID){
       // $selectData = ['CONCAT(postcode," - ",place_name) as `TEXT`',
        $selectData = ['CONCAT(postcode) as `TEXT`',
            false
        ];
        $where = array('id' => $postCodeID);
        $PostCode = $this->Common_model->select_fields_where($this->postCodesTable,$selectData,$where,true);
        return $PostCode->TEXT;
    }
    public function getListingValues($getListing,$listingTypeID, $listID){
        $returnArray  = array();
        //This id will differentiate the type of listing for which we need the preselected answer.
        if(empty($listingTypeID)){
            return false;
        }else{
            $listingID = $listingTypeID;
        }
        //This User ID will be the Listing ID. listing can be of esic/university etc..
        if(empty($listID)){
            return false;
        }else{
            $userID = $listID;
        }

        if(!empty($getListing)){
            switch($getListing){
                case 'esic':
                    $prePopulatedListTypeID = 1;
                    break;
                case 'investor':
                    $prePopulatedListTypeID = 2;
                    break;
                case 'accelerator':
                    $prePopulatedListTypeID = 3;
                    break;
                case 'uni':
                    $prePopulatedListTypeID = 4;
                    break;
                case 'rnd_partner':
                    $prePopulatedListTypeID = 5;
                    break;
                case 'acc_commercial':
                    $prePopulatedListTypeID = 6;
                    break;
                case 'lawyer':
                    $prePopulatedListTypeID = 7;
                    break;
                case 'grant_consultant':
                    $prePopulatedListTypeID = 8;
                    break;
                case 'rnd_consultant':
                    $prePopulatedListTypeID = 9;
                    break;
            }
            $returnArray =  $this->getListingPrePopulatedList($prePopulatedListTypeID, $listingID, $userID);

        }else{
            for($i = 1; $i <= 9; $i++){
                $ListingData = $this->getListingPrePopulatedList($i, $listingID, $userID);
                if(!empty($ListingData)){
                    $returnArray = array_merge($returnArray, $ListingData);
                }
            }
        }
        //$result = recursiveArrayMakingCustom($returnArray);
        $result = HeadLessArrayCustom($returnArray);
        return $result;
    }
    public function getListingPrePopulatedList($prePopulatedListTypeID,$listingID, $userID){

        //Need to make a logic to get the user's Listing.
        $selectData = ['answer',false];
        $where = [
            'user_id' => $userID,
            'listing_id' => $listingID
        ];

        $result = $this->Common_model->select_fields_where_like('esic_question_users_answers',$selectData,$where,FALSE,'answer','prePopulatedItems');

        //$result = json_decode(json_encode($result),true);
        //we need to fetch the record for with the request has been generated.
        if(!empty($result)){
            $allListings = array_filter($result,function($prePopulatedAnswerJson) use($prePopulatedListTypeID){
                if(strpos($prePopulatedAnswerJson->answer,'"listTypeID":"'.$prePopulatedListTypeID.'"')){
                    return $prePopulatedAnswerJson;
                }
            });

            //Map the IDs With Values.
            $Listings =  array_map(function($prePopulatedListItems) use($prePopulatedListTypeID){
                $answer = json_decode($prePopulatedListItems->answer,true);
                $prePopulatedItems = $answer['prePopulatedItems'];
                $listItems = [];
                foreach($prePopulatedItems as $prePopulatedItem){
                    if($prePopulatedItem['listTypeID'] == $prePopulatedListTypeID){
                        $selectData = ['tableName',false];
                        $where = ['id' => $prePopulatedListTypeID];
                        $result = $this->Common_model->select_fields_where('esic_listings',$selectData,$where,true);
                        if(!empty($result)){
                            $listingTable = $result->tableName;
                        }
                        if($listingTable){
                            switch($listingTable){
                                case 'esic':
                                    $selectListingData = ['id as ID, name as Name, logo as Logo, slug, "Esic" as label, "Esic" as type',false];
                                    $listIs = 'esic';
                                break;
                                case 'esic_investor':
                                    $selectListingData = ['id as ID, name as Name, logo as Logo, slug, "Investor" as label, "Investor" as type',false];
                                    $listIs = 'investor';
                                break;
                                case 'esic_accelerators':
                                    $selectListingData = ['id as ID, name as Name, logo as Logo, slug, "Accelerator" as label, "Accelerator" as type',false];
                                    $listIs = 'accelerator';
                                break;
                                case 'esic_institution':
                                    $selectListingData = ['id as ID, institution as Name, logo as Logo, slug, "University" as label, "University" as type',false];
                                    $listIs = 'university';
                                break;
                                case 'esic_rndpartner':
                                    $selectListingData = ['id as ID, name as Name, logo as Logo, slug, "R&D Partner" as label, "RndPartner" as type',false];
                                    $listIs = 'rndpartner';
                                break;
                                case 'esic_acceleration':
                                    $selectListingData = ['id as ID, Member as Name, logo as Logo, slug, "Accelerating Commercialisation" as label, "AcceleratingCommercialisation" as type',false];
                                    $listIs = 'acceleration';
                                break;
                                case 'esic_lawyers':
                                    $selectListingData = ['id as ID, name as Name, logo as Logo, slug, "Lawyer" as label, "Lawyer" as type',false];
                                    $listIs = 'lawyer';
                                break;
                                case 'esic_grantconsultant':
                                    $selectListingData = ['id as ID, name as Name, logo as Logo, slug, "Grant Consultant" as label, "GrantConsultant" as type',false];
                                    $listIs = 'grantconsultant';
                                break;
                                case 'esic_rndconsultant':
                                    $selectListingData = ['id as ID, name as Name, logo as Logo, slug, "R&D Consultant" as label, "RndConsultant" as type',false];
                                    $listIs = 'rndconsultant';
                                break;
                            }
                            if(!empty($selectListingData[0])){
                                $color = getListingTypeColor($this,'slug',$listingTable);
                                $selectListingData[0].= ' , "'.$color.'" as color';
                            }      
                        }
                        if(is_array($prePopulatedItem['selectedItemID'])){
                            foreach($prePopulatedItem['selectedItemID'] as $key => $selectedPrePopulatedItems){
                              $listItems[$listIs][$key] = $this->getListingPrePopulatedListValueFromDB($listIs, $listingTable, $selectListingData, $selectedPrePopulatedItems);
                            }
                        }else{
                            $listItems[$listIs] = $this->getListingPrePopulatedListValueFromDB($listIs, $listingTable, $selectListingData, $prePopulatedItem['selectedItemID'
                                ]);
                        }
                    }
                }
                return $listItems;
            },$allListings);
        }
        /*$NewListing = [];
        foreach ($Listings as $key => $Listing){
            $NewListing = array_merge($NewListing,$Listing);

        }*/
        return $Listings;
    }
    public function getListingPrePopulatedListValueFromDB($listIs, $listingTable, $selectListingData, $selectedPrePopulatedItems){
        $whereListingID = 'id = '.$selectedPrePopulatedItems;
        $listItems = $this->Common_model->select_fields_where($listingTable,$selectListingData,$whereListingID,true,'','','','','',false);
        
        return $listItems;
    }
    public function getpreviouslistingyears(){ // added by hamid for previous years  listing
        $result = $this->Common_model->select_distinct('listing_status','status_date');
        return $result;
    }
    public function storeInPrePopulated(){
        $modalID = $this->input->post('modalID');
        if(empty($modalID)){
            return false;
        }//End of if Empty

        $insertData = $this->input->post();
        unset($insertData['modalID']);

        if(isset($insertData['name'])){
            $name = $insertData['name'];
        }elseif(isset($insertData['Member'])){
            $name = $insertData['Member'];
        }elseif(isset($insertData['institution'])){
            $name = $insertData['institution'];
        }

        //Get Slug And Assign it back to the InsertData.
        $insertData['slug'] = checkAndChangeIfAlreadyExistSlug($this,getAlias($name));

        $table = str_replace('Modal','',$modalID);
        $result = $this->Common_model->insert_record($table,$insertData);
        if($result>0){
            echo 'OK::Record Successfully Added To Database::success::'.$result.'::'.$name;
        }else{
            echo 'FAIL::Record Could Not be Added To Database::error';
        }

    }
    protected function validate_login($mehods=null,$string='on'){
        if($mehods !== null){
            if(in_array('Manage',$mehods) and ($this->uri->segment(3) === 'updateLogo' || $this->uri->segment(3) === 'updateBanner')){
                return true;
            }
            if($string==='on'){
                if(methods($this,$mehods)){
                        Admincontrol_helper::is_logged_in($this->session->userdata('userName'));
                }
            }elseif($string === 'except'){
                if(!methods($this,$mehods)){
                    Admincontrol_helper::is_logged_in($this->session->userdata('userName'));
                }
            }//Else If Except.
        } //End of If Methods !== null
    }
    //Update the Combined JS and CSS files
    public function updateAssets($filesGroupName=Null){
        $filesGroup=[
            'structureFooterJS' => [
                'outputFilePath' => 'assets/js/structureFooter.js',
                'files' => $this->structureFooterJSFiles
            ],
            'structureHeaderCSS'   => [
                'outputFilePath' => 'assets/css/structureHeader.css',
                'files' => $this->structureHeaderCSSFiles
            ],
            'previewTemplateFooterJS'   => [
                'outputFilePath' => 'assets/js/previewTemplateFooter.js',
                'files' => $this->previewTemplateFooterJSFiles
            ],
        ];

        $this->load->driver('minify');
        if(!empty($filesGroupName) and is_string($filesGroupName)){
            if(array_key_exists($filesGroupName,$filesGroup)){
                $selectedGroupArray = $filesGroup[$filesGroupName];
                //Minify and Combine the File
                $allJSContent = $this->minify->combine_files($selectedGroupArray['files']);
                //Save that to some file
                $result = $this->minify->save_file($allJSContent, $selectedGroupArray['outputFilePath']);
                if($result === true){
                    echo 'File\'s have been successfully compressed and combined for group "'.$filesGroupName.'"';
                    return true; //as files generated.
                }else{
                    echo 'ERROR';
                    return false;
                }
            }
            return false;
        }
        //If reached up to here, means code not executed on top. and shall be responeded with false.

        if(empty($filesGroupName)){ //Means we need to compress all the files groups.
            foreach($filesGroup as $key => $group){
                $allAssetsContent = $this->minify->combine_files($group['files']);
                $result = $this->minify->save_file($allAssetsContent, $group['outputFilePath']);
                if($result !== true){ ///Means we have some error here.
                    echo 'ERROR in "'.$key.'"';
                    return false;
                }
            }
            //If Reached Here, Assuming all the files have been successfully compressed and combined, we should show the message to front.
            echo 'File\'s have been successfully compressed and combined for Following Groups';
            echo '<ol>';
            foreach($filesGroup as $key => $value){
                echo '<li>'.$key.'</li>';
            }
            echo '</ol>';
            return true; //as files generated.

        }


        return false;
    }

    //Resize the Existing Images.
    function resizeImage($ControllerFile = NULL){
        //Load the image resize model
        $this->load->model('Imagecreate_model');

        //We need to get the file paths to resize the images and upload them back to the server.
        $listings = $this->Common_model->select_fields('esic_listings',['tableName',false]);

        foreach($listings as $listing){
            $listingTable = $listing->tableName;
            $listingData =  $this->Common_model->select_fields($listingTable,['logo',false],false,'','',true);
            if(!empty($listingData) and is_array($listingData)){
                foreach($listingData as $listingRow){
                    $listingLogoPath = $listingRow['logo'];
                    if(!empty($listingLogoPath) and is_file($listingLogoPath)){
                        $this->Imagecreate_model->createimage($listingLogoPath);
                    }
                }//End of foreach
            }//End of if Not Empty $listingData.
        }

    } //End of Resize image function.
}

class Listing extends MY_Controller{

    protected $CurrentID;
    public function __construct(){
    parent::__construct();

        $this->load->helper(array('form','viewdefault'));
        $this->load->library('form_validation');

        $this->data['PageType']               = 'Summary';
        $this->data['LogoDbField']            = $this->LogoDbField;
        $this->data['BannerDbField']          = $this->BannerDbField;
        $this->data['ListingName']            = $this->Name;
        $this->data['ListingLabel']           = $this->NameMessage;
        $this->data['ControllerName']         = $this->ControllerName;
        $this->data['ControllerRouteName']    = $this->ControllerRouteName;
        $this->data['ControllerRouteManage']  = $this->ControllerRouteManage;
        $this->data['itemStatuses']           = $this->Common_model->select('esic_status_flags');
        $this->data['userFieldsView']         =  $this->load->view('structure/user_fields_front', $this->data , true);
        $this->data['bodyClasses'] .= ' listing-router';
        $this->data['templates']  = $this->Common_model->select('esic_templates');


    }
    public function Manage($param=NULL){
        viewHelperManage($param);
        return NULL;
    }
    // previous status listing
    public function prevStatusListing(){
        managePrevStatus($this);
        return NULL;
    }
	public function Add(){
        $this->data['PageType'] = 'Add';
        $selectors = [
            'postCodes' => $this->_getSelectedPostCodes(),
            'states' => $this->_getStates(),
        ];
        $this->data['selectors'] = $selectors;
        if($this->Name == 'RndPartner'){
            $anzrcCodes = $this->Common_model->select('anzsrc');
            $this->data['anzsrc'] = $anzrcCodes;
        }
        $this->show_admin_configuration('listing/'.$this->ViewFolderName.'/backend/add', $this->data);
        return NULL;
    }
    public function AddSave(){
        $this->data['PageType'] = 'Summary';
        $this->data['return'] = ViewHelperNewSave();
        if(!empty($this->data['return']) ){
            foreach ($this->data['return'] as $key => $message){
                $IDCheckArray = explode('::', $message);
                if(isset($IDCheckArray[3]) && !empty($IDCheckArray[3])){
                    $ID = $IDCheckArray[3];
                    $this->View($ID);
                    //$this->Edit($ID);
                    return Null;
                }

            }
        }
        redirect('/admin/'.$this->ControllerRouteManage, 'refresh');
       // $this->show_admin_listing('listing/'.$this->ViewFolderName.'/backend/listing' , $this->data);
        return Null;
    }
    public function Edit($id){
        if(isCurrentListingBelongToThisUser($this,$id)){
            // check if new version available then load data from version table
            $version = $this->Common_model->select_fields_where($this->tableName, '*', array('id'=>$id), true);
            $this->CurrentID = $id;

            if($version->is_new_ver == 'Yes' && $version->userID == $this->session->userdata('userID')) {
                $listingField = $this->listingField;
                $where = array($listingField => $id);
                $order_by = array('id', 'desc');
                $this->data['data'] = $this->Common_model->select_fields_where($this->versionTable ,'*' ,$where,true,'',
                    '', '', '',$order_by);
                $this->data['roll_back'] = true; // provide roll back option until version not approve
                // get approved version slug
                if($this->data['data']->$listingField){
                    $listId = $this->data['data']->$listingField;
                    $this->data['slug'] = $this->Common_model->select_fields_where($this->tableName, 'slug', ['id'=>$listId], true);
                }
            } else {
                $where = array('id' => $id);
                $this->data['data'] = $this->Common_model->select_fields_where($this->tableName ,'*' ,$where,true);
             }
            $this->data['id'] = $id;
            $userID = $this->data['data']->userID;
            $whereUser = array('userID' => $userID);
            $this->data['UserData'] = $this->Common_model->select_fields_where($this->tableNameUser ,'*' ,$whereUser,true);
            $whereSocial = array('listingID'=> $id);
            $this->data['SocialLinks'] = $this->Common_model->select_fields_where($this->tableNameSocial ,'*' ,$whereSocial,true);
            $this->data['PageType'] = 'Edit';

            $postcode = $this->data['data']->address_post_code;
            if(!empty($postcode)){
                $post_code = array($postcode);
            }else{
                $post_code = NULL;
            }
            $selectors = [
                'postCodes' => $this->_getSelectedPostCodes($post_code),
                'states' => $this->_getStates(),
            ];

            if($this->Name == 'RndPartner'){
                $anzrcCodes = $this->Common_model->select('anzsrc');
                $this->data['anzsrc'] = $anzrcCodes;
            }
            if(empty($this->data['data']->businessShortDescriptionJSON)) {
               $this->data['data']->businessShortDescriptionJSON = '{"data":[{"type":"text","data":{"text":"<p>Well come You can Build/Design your Profile page using page builder</p>","isHtml":true}}]}';
            }
            if(empty($this->data['UserData']->businessShortDescriptionJSON)) {
                $myUserData = (array) $this->data['UserData'];
                $myUserData['businessShortDescriptionJSON'] = '{"data":[{"type":"text","data":{"text":"<p>Well come You can Build/Design your Profile Page using page builder</p>","isHtml":true}}]}';
                $this->data['UserData'] = (object) $myUserData;
            }
            $this->data['selectors'] = $selectors;          
            $this->show_admin_configuration('listing/'.$this->ViewFolderName.'/backend/edit',$this->data);
        }
        return NULL;
    }
    public function EditSave(){
        $this->data['return'] = ViewHelperEditSave();
        $this->Edit($this->input->post('id'));
        return Null;
    }
    public function View($ID){ // backend lisitng detail page
        if(isCurrentListingBelongToThisUser($this,$ID)){
            $this->data['id'] = $ID;
            $where = array('id' => $ID);
            // check if year set, send from ajax
            if($this->input->post('year') && !empty($this->input->post('year'))){
                $year = $this->input->post('year');
            }
            // check if new version available and viewer is user then load data from version table
            $version = $this->Common_model->select_fields_where($this->tableName, '*', array('id'=>$ID), true);
            if($version->is_new_ver == 'Yes' && $version->userID == $this->session->userdata('userID')) {
                $where = array($this->listingField => $ID);
                $order_by = array('id', 'desc');
                $this->data['data'] = $this->Common_model->select_fields_where($this->versionTable ,'*' ,$where,true,'',
                    '', '', '',$order_by);
                $where = array('id' => $ID);
                $this->data['datas'] = $this->Common_model->select_fields_where($this->tableName ,'*' ,$where,true);
                $this->data['data']->slug = $this->data['datas']->slug;
                if($this->data['data']->not_approve == 1)
                    $this->data['ver_status'] = 'Disapproved';
                else
                    $this->data['ver_status'] = 'Pending';
            } else {
                $where = array('id' => $ID);
                $this->data['data'] = $this->Common_model->select_fields_where($this->tableName ,'*' ,$where,true);
             }
           // $this->data['data'] = $this->Common_model->select_fields_where($this->tableName ,'*' ,$where,true);
            if(!empty($this->data['data']->address_state)){
              $this->data['data']->address_state = $this->_getState($this->data['data']->address_state); 
            }
            if(!empty($this->data['data']->address_post_code)){
              $this->data['data']->address_post_code = $this->_getPostCode($this->data['data']->address_post_code); 
            }
            $this->data['PageType'] = 'Page Details';
            $this->getListingValues(' ',$this->QuestionListingID,$ID);
            $this->data['usersQuestionsAnswers'] = $this->_getUserQAnswers($ID,$this->QuestionListingID, $year);
            if(isset($year)) {
                $showUserQuestionAnswers    = $this->load->view('structure/userquestionanswers', $this->data,true);
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array('showUserQuestionAnswers'=> $showUserQuestionAnswers)));
                return;
            }

            $this->data['showUserQuestionAnswers'] = $this->load->view('structure/userquestionanswers', $this->data,true);
            $this->data['viewFooter'] = $this->load->view('structure/foot_view', $this->data,true);
            $where = array(
                'isTrashed'   => "0",
                'isPublished' => "1"
            );
            $yearsList =  $this->Common_model->select_fields_where('esic_questions' ,'year' ,$where);
            if(!empty($yearsList)){
                 $years = [];
                 foreach($yearsList as $year){
                     $year = $year->year;
                     if(!in_array($year, $years))
                         array_push($years, $year);
                }
            }
            rsort($years);
            // insert previous year question into new year
            $c_date = date('Y-m-d');
            $c_Year = date('Y');
            if( $c_date > date("$c_Year-06-30") && $c_date <= date("$c_Year-12-31") ){
                $c_Year +=1; // 2020 Questions
            }else if($c_date < date("$c_Year-07-01") && $c_date >= date("$c_Year-01-01") ){
                $c_Year = date('Y'); // 2019 Questions
            }
            if($c_Year > $years[0]){  // if next year question is added manually than following code did not work 
                $where = array('year' => $years[0]); // last year questions 
                $esic_questions = $this->Common_model->select_fields_where('esic_questions','*',$where,false);
                foreach($esic_questions as $data) {
                    $insertIntoesic_questions = [
                        'Question' => $data->Question,
                        'QuestionPostedName' => $data->QuestionPostedName,
                        'tablename' => $data->tablename,
                        'isPublished' => $data->isPublished,
                        'isRequired' => $data->isRequired,
                        'isSub' => $data->isSub,
                        'isTrashed' => $data->isTrashed,
                        'year' => $c_Year
                    ];
                    $insertID = $this->Common_model->insert_record('esic_questions', $insertIntoesic_questions);
                    $where = array('question_id' => $data->id);
                    $questions_listings = $this->Common_model->select_fields_where('esic_questions_listings', '*', $where, true);
                    $arrayToInsert = [
                        'question_id' => $insertID, // last inserted  question id
                        'listing_id' => $questions_listings->listing_id, //for example esic etc
                        'order' => $questions_listings->order,
                        'isRequired' => $questions_listings->isRequired,
                        'isPublished' => $questions_listings->isPublished,
                    ];
                    $this->Common_model->insert_record('esic_questions_listings', $arrayToInsert);
                    $where = array('questionID' => $data->id);
                    $questions_answers = $this->Common_model->select_fields_where('esic_questions_answers', '*', $where, true);
                    $insertData = [
                        'questionID' => $insertID,
                        'Solution' => $questions_answers->Solution,
                        'type' => $questions_answers->type
                    ];
                    $this->Common_model->insert_record('esic_questions_answers', $insertData);
                }
                array_unshift($years , $c_Year); //add new inserted year into options
            }
            // END  insert previous year question into new year
            $this->data['yearsList'] = $years;
            $where = array('listing_id' => $ID );
            $this->data['calculator_questions_answers'] = $this->Common_model->select_fields_where('calculator_questions_answers', '*', $where, false);
            $this->show_admin_configuration('listing/'.$this->ViewFolderName.'/backend/view' , $this->data);
        }else{
            redirect(base_url(),'refresh');
        }
        return Null;
    }
    public function FrontForm(){
        //$this->data['bodyClasses'] .= json_encode($this->input->post());
        $this->data['bodyClasses'] .= ' bg-alabaster front-form-listing';
        $this->data['EsicList']  = getList($this, 'Esic');
        $this->data['userID'] = getCurrentUserID($this);
        $selectors = [
            'postCodes' => $this->_getSelectedPostCodes(),
            'states' => $this->_getStates(),
        ];

        if($this->Name == 'RndPartner'){
            $anzrcCodes = $this->Common_model->select('anzsrc');
            $this->data['anzsrc'] = $anzrcCodes;
        }

        $this->data['selectors'] = $selectors;
        $this->load->view('structure/header',$this->data);
        $this->data['QuestionsAnswers'] = $this->getQAnswers($this->QuestionListingID);

        $this->data['AddressFields'] = $this->load->view('structure/addressfields' ,$this->data,true);
        if(!empty($this->data['page']['pageTemplate'])){
            $this->load->view('templates/'.$this->data['page']['pageTemplate'], $this->data);
        }
         
        $this->data['questions'] =  $this->load->view('structure/'.$this->QuestionsView, $this->data , true);
        if($this->Name != 'Investor'){ 
            $this->show_front_listing_form('listing/'.$this->ViewFolderName.'/frontend/front' ,$this->data);
            $this->load->view('structure/js_block_front' ,$this->data);
        }else{
             $this->show_configuration('listing/'.$this->ViewFolderName.'/frontend/front' ,$this->data);
        }
        $this->load->view('structure/footer');
    }
    public function Create(){
        $this->data['PageType'] = 'Message';
        $this->data['return']   = ViewHelperNewSave();
        $this->load->view('structure/header',$this->data);
        $this->show_configuration('structure/message' , $this->data);
        $this->load->view('structure/footer');
        return Null;
    }
    public function Listing(){
        $this->session->set_userdata('searchDatabaseListing', $this->input->post());
        redirect(base_url($this->listingDatabase.'/'.$this->listingDatabaseSearch));
    }
    public function listingDatabase(){
        $searchDatabaseListing = $this->session->userdata('searchDatabaseListing');
        $this->session->unset_userdata('searchDatabaseListing');
        $_POST = $searchDatabaseListing;
        $selectors = [
            'postCodes' => $this->_getSelectedPostCodes(((isset($filters['postCodesSelect']) and !empty($filters['postCodesSelect']))?$filters['postCodesSelect']:NULL)),
            'states' => $this->_getStates(),
        ];
        $this->data['selectors']  = $selectors;
        //Let Get the Filters As Well.
        $this->data['filters'] = getListingFilters();
        $this->data['PageType'] = 'Summary';
        $this->data['return'] = ViewHelperListing($_POST);
        $this->data['postedValues'] = $_POST;//$this->input->post();
        $this->data['postedValues']['orderBy'] = $_POST['orderByFilter'];// $this->input->post('orderByFilter');
        $this->data['bodyClasses'] .= ' database-listing';
        if(!empty($this->data['ListingName']) && $this->data['ListingName']=="Esic"){
            $this->data['esic_status'] = $this->Common_model->select('esic_status');
        }
        $this->load->view('structure/header', $this->data);
        if (!empty($this->data['page']['pageTemplate'])) {
            $this->load->view('templates/' . $this->data['page']['pageTemplate'], $this->data);
        }
        $this->show_configuration('listing/' . $this->ViewFolderName . '/frontend/listing', $this->data);
        $this->load->view('structure/footer');
    }

    public function Details($alias = Null){
        if($this->input->post('tbl') && $this->input->post('tbl')=='new_ver') {
            $this->tableName = $this->versionTable;
            $newVer = $this->input->post('verId');
        }
        $this->data['PageType'] = 'Details';
        //$alias is the slug in url for that details page.
        if($alias != Null){
            // if new version
            if($newVer)
                $this->data['detail']   = ViewHelperDetail($alias, $newVer);
            else
                $this->data['detail']   = ViewHelperDetail($alias);

            if(empty($this->data['detail']->email)){
               //$this->data['detail']->email = getUserCurrentEmail($this,$this->data['detail']->userID);
            }
           // $this->data['page'] = $this->data['detail']->ListID;
        }
        if( $this->data['ControllerName'] === 'Esic' ){
            $e_status = $this->data['detail']->status;
            $where    = array('id' => $e_status);
            $this->data['esic_status']   = $this->Common_model->get_record_where('esic_status',$where);
            $this->data['esic_status_all']   = $this->Common_model->select('esic_status');
        }

        $this->data['bodyClasses'] .= ' database-listing listing-detail front-listing';
        $this->data['bodyClasses'] .= ' live-detail-listing';
        $this->data['ListingValues'] =  $this->getListingValues('',$this->QuestionListingID,$this->data['detail']->ListID);
        $this->load->view('structure/header',$this->data);
        $templateFileName = getTemplateFileName($this,$this->data['detail']->template);
        if(!empty($templateFileName)){        
            $this->show_configuration('listing/default/frontend/templates/'.$templateFileName,$this->data);
        }else{
            $this->show_configuration('listing/'.$this->ViewFolderName.'/frontend/templates/default',$this->data);
        }
        $this->load->view('structure/footer');
    }
    public function DetailByTemplate($alias,$templateID){
        $this->data['PageType'] = 'Details';
        //$alias is the slug in url for that details page.
        if($alias != Null){
            $this->data['detail']   = ViewHelperDetail($alias);
           // $this->data['page'] = $this->data['detail']->ListID;
        }
        $this->data['bodyClasses'] .= ' database-listing listing-detail';
        $this->data['ListingValues'] =  $this->getListingValues('',$this->QuestionListingID,$this->data['detail']->ListID);
        $this->load->view('structure/header',$this->data);
        $templateFileName = getTemplateFileName($this,$templateID);
        if(!empty($templateFileName)){
            $this->show_configuration('listing/default/frontend/templates/'.$templateFileName,$this->data);
        }else{
            $this->show_configuration('listing/'.$this->ViewFolderName.'/frontend/templates/default',$this->data);
        }
        $this->load->view('structure/footer');
    }
    public function NewListing(){
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->data['return']   = ViewHelperAdd($this);
    }
    public function SavePageBuilderContent(){
        $uID = $this->input->post('uID');
        $actionToPerform = '';
        if($this->input->post('action_vl'))
            $actionToPerform = $this->input->post('action_vl');
        $redirect = true;        
        if(empty($uID)){
            $uID = $this->input->post('listingID');
            $redirect = false;    
        }
        if(!empty($uID)){
            $this->load->library('Sioen');
            $this->Hoosk_model->UpdatePageDescription($uID, $actionToPerform);
            if(!empty($actionToPerform)){
                echo 'OK::Content Saved Successfully::success';
                return null;
            }
            if($redirect == true){
                redirect('/'.$this->ControllerName.'/Edit/'.$uID, 'refresh');
            }else{
                $template = $this->input->post('template');
                $this->Hoosk_model->SaveTemplateForListing($this,$uID,$template);
                // check if user is logged in then send true, else false
                if($this->session->userdata('userID')){
                    $message = $this->lang->line('listing_process_complete_user');
                    $login = 1;
                }
                else {
                    $message = $this->lang->line('listing_process_complete_guest');
                    $login = 0;
                }
                echo 'OK::Your Page is Saved::success::'.$uID.'::'.$login.'::'.$message;

            }
        }
        return null;
    }

    public function ShowPreview(){
        $this->load->library('Sioen');
        $dataReturn = $this->Hoosk_model->ShowEsicPageDescription();
        $listingID  = $this->input->post('listingID');
        $template   = $this->input->post('template');
        $showPreview = true;
        $PreviewFrontEnd = true;
        $where = array('id' => $listingID);
        $data = $this->Common_model->select_fields_where($this->tableName,'*',$where,true);
        if(empty($data)){
            $data = new stdClass();
        }
            if(!empty($dataReturn['long_description'])){
                $data->long_description = $dataReturn['long_description'];
            }
            if(!empty($dataReturn['businessShortDescriptionJSON'])){
                $data->businessShortDescriptionJSON = $dataReturn['businessShortDescriptionJSON'];
            }

        $templateFileName = getTemplateFileName($this,$template);
        $this->data['detail'] = $data;
        $this->data['detail']->showPreview = $showPreview;
        $this->data['detail']->PreviewFrontEnd = $PreviewFrontEnd;
        //Need Address Fields if Edit is Required.

        //As now i have only id of the Postcode, i need to fetch the value for that post code as well :(
        $this->data['detail']->address_post_code_value = $this->_getSelectedPostCodes($this->data['detail']->address_post_code); //This Address PostCode is Actually the Id of the post code which ahsan didnt cared to get the value for.. :(

        $selectors = [
            'postCodes' => $this->data['detail']->address_post_code_value,
            'states' => $this->_getStates(),
        ];

        if(!empty($this->data['detail']->address_post_code_value)){
            $this->data['detail']->address_post_code_value = (json_decode($this->data['detail']->address_post_code_value,true));
            if(!empty($this->data['detail']->address_post_code_value[0]['TEXT'])){
                $this->data['detail']->address_post_code_value = explode(' - ',$this->data['detail']->address_post_code_value[0]['TEXT']);
                $this->data['detail']->address_post_code_value = $this->data['detail']->address_post_code_value[0];
            }
        }
        if($this->Name == 'RndPartner'){
            $anzrcCodes = $this->Common_model->select('anzsrc');
            $this->data['anzsrc'] = $anzrcCodes;
        }

        $this->data['selectors'] = $selectors;

        if(!empty($templateFileName)){
          $pageResult = $this->load->view('listing/default/frontend/templates/'.$templateFileName,$this->data);
        }else{
          $pageResult = $this->load->view('listing/'.$this->ViewFolderName.'/frontend/templates/default',$this->data);
        }
        echo $pageResult;
        return null;
    }
    public function ShowPreviewOLD(){
        $this->load->library('Sioen');
        $dataReturn = $this->Hoosk_model->ShowEsicPageDescription();
        $listingID = $this->input->post('listingID');
        $where = array('id' => $listingID);
        $data = $this->Common_model->select_fields_where($this->tableName,'*',$where,true);
        $data->long_description = $dataReturn['long_description'];
        $data->businessShortDescriptionJSON = $dataReturn['businessShortDescriptionJSON'];
        echo json_encode($data);
        return null;
    }

    public function ShowPreviewDB(){
        $listingID = $this->input->post('listingID');
        if(!empty($listingID) && is_numeric($listingID)){
            $content =  ViewHelperGetPreview($this,$listingID);
            if(!empty($content)){
                $listingID = $content->id;
                $userID    = $content->userID;
                $slug      = $content->slug;
                $thumbsUp  = $content->thumbsUp;
                $name      = $content->name;
                $website   = $content->website;
                $StreetName   = $content->address_street_name;
                $StreetNumber = $content->address_street_number;
                $PostCode   = $content->address_post_code;
                $Town       = $content->address_town;
                $State      = $content->address_state;
                $business   = $content->business;
                $short_description = $content->short_description;
                $businessShortDescriptionJSON = $content->businessShortDescriptionJSON;
                $long_description = $content->long_description;
                $added_date = $content->added_date;
                $dataReturn = array(
                    'listingID' => $listingID,
                    'userID'    => $userID,
                    'slug'      => $slug,
                    'thumbsUp'  => $thumbsUp,
                    'name'      => $name,
                    'website'   => $website,
                    'StreetName'    => $StreetName,
                    'StreetNumber'  => $StreetNumber,
                    'PostCode'      => $PostCode,
                    'Town'          => $Town,
                    'State'         => $State,
                    'business'      => $business,
                    'description'   => $short_description,
                    'pageJson'      => $businessShortDescriptionJSON,
                    'pageContent'   => $long_description,
                    'added_date'    => $added_date
                );
                echo json_encode($dataReturn);
            }
        }
         return null;
    }
    public function SaveQuestionAnswers(){
        $this->data['return']  = ViewHelperSaveQuestionsAnswers($this);
    }
    //Dont mistake the userid with UserID
    protected function _getUserQAnswers($userID,$listingID, $year=null){
        if(empty($userID) || !is_numeric($userID)){
            return false;
        }

        if(empty($listingID) and !is_numeric($listingID)){
            $listingID = 1;
        }

        $selectData2 = array('        
                    EQ.Question as Question,
                    EQ.id as questionID,
                    QPS.Solution as PossibleSolution,
                    UA.answer as ProvidedSolution
                    -- ES.score as score
            ',false);
        $esicUserQuestionAns = 'esic_question_users_answers';
        $where = [
            'EQ.`isPublished`' => 1,
            'EQ.`isTrashed`' => 0,
            'QL.listing_id' => $listingID,
            'EQ.`isSub` !=' => 1,
         ];
        if(!empty($year)){
            $where['EQ.`year` ='] = $year;
         }else{
            $c_date = date('Y-m-d');
            $c_Year = date('Y');
            if( $c_date > date("$c_Year-06-30") && $c_date <= date("$c_Year-12-31") ){
                $c_Year +=1; // 2019 questions
                $where['EQ.`year` ='] = $c_Year;
           }else if($c_date < date("$c_Year-07-01") && $c_date >= date("$c_Year-01-01") ){
                $c_Year = date('Y'); //2018 Questions
                $where['EQ.`year` ='] = $c_Year;
            }
        }
        $joins2 = array(
            array(
                'table' => 'esic_questions_listings QL',
                'condition' => 'QL.question_id = EQ.id',
                'type' => 'LEFT'
            ),
            array(
                'table' => 'esic_questions_answers QPS',
                'condition' => 'QPS.questionID = EQ.id',
                'type' => 'LEFT'
            ),
            array(
                'table' => $esicUserQuestionAns.' UA',
                'condition' => 'UA.answer_id = QPS.id AND QL.listing_id = UA.listing_id AND user_id = '.$userID,
                'type' => 'LEFT'
            )
        );
        $groupBy = ['EQ.id'];
        $orderBy = ['QL.order'];
        return $this->Common_model->select_fields_where_like_join('esic_questions EQ',$selectData2,$joins2,$where,FALSE,'','',$groupBy,$orderBy);
    }
    public function OpenPageBuilder($listingID = ''){
        if(empty($listingID)){
            $listingID = $this->input->post('listingID');
            if(!empty($listingID)){
                $this->__setMagic('listingID',$listingID);
                echo 'OK::Open Then Page Builder::success';
            }else{
                echo 'FAIL::Please Submit Listing First::error';
            }
        }else{
            $lisitngIDWhichWasSet = $this->__getMagic('listingID');
            if($lisitngIDWhichWasSet == $listingID){
                $this->data['bodyClasses'] .= ' bg-alabaster pageBuilder';
                $this->data['userID'] = getCurrentUserID($this);
                $this->data['listingID'] = $listingID;
                $this->data['contentPage'] = getPageBuilderContentJson($this, $listingID);
                $this->load->view('structure/header',$this->data);
                $this->show_configuration('listing/default/frontend/pageBuilder' ,$this->data);
            }else{
                header('HTTP/1.0 403 Forbidden');
                $this->data['page']['pageTitle']="Oops, Error";
                $this->data['page']['pageDescription']="Oops, Error";
                $this->data['page']['pageKeywords']="Oops, Error";
                $this->data['page']['pageID']="0";
                $this->data['message'] = 'Sorry this page is not allowed directly';
                $this->data['header'] = $this->load->view('structure/header', $this->data, true);
                $this->data['footer'] = $this->load->view('structure/footer', '', true);
                $this->load->view('templates/error', $this->data);
                //echo "Sorry You Cannot Access this Url Directly, Thanks";
            }
            //$this->load->view('structure/footer');
        }

        return null;
    }
    public function updatePreviewValue(){
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        if(!$this->input->post() || !$this->input->is_ajax_request()){
            echo 'FAIL::Invalid Request::error';
            return false;
        }
        $this->form_validation->set_rules('name', 'name', 'trim');
        if($this->input->post('name')!='website' || $this->input->post('name')!='email'){
            $this->form_validation->set_rules('val', 'val', 'trim');
        }
        if ($this->form_validation->run() == FALSE) {
            echo 'FAIL::Invalid Post Data::error';
            return false;
        }
        $name= $this->input->post('name'); //It should be the column name
        $value= $this->input->post('val'); //Value to be updated in DB for that specific Column
        $id = $this->input->post('id'); //Value to be updated for that specific row.


        if(empty($id) || !is_numeric($id)){
            echo 'FAIL::Invalid Post Data::error';
            return false;
        }
        $whereUpdate = ['id' => $id];
        $table = $this->tableName;

        $updateType=$this->input->post('updateType');
        if(!empty($updateType) && $updateType === 'address'){  //Means we need to update multiple addresses.
            $streetNumber = $this->input->post('address_streetNumber');
            $streetName = $this->input->post('address_streetName');
            $town = $this->input->post('address_town');
            $state = $this->input->post('address_state');
            $post_code = $this->input->post('address_post_code');

            $updateAddressData = [
                'address_street_name' => $streetName,
                'address_street_number' => $streetNumber,
                'address_town' => $town,
                'address_state' => $state,
                'address_post_code' => $post_code,
            ];

            $updateResult = $this->Common_model->update($table,$whereUpdate,$updateAddressData);
            if($updateResult==true){
                echo 'OK::Record Successfully Updated::success';
            }else{
                echo 'FAIL::'.print_r($updateResult).'::error';
            }
            return;
        }

        if(!empty($updateType) && $updateType === 'socialLinks'){
            //Now for this when no record exist in social table then just create a new entry.
            $userID = $this->input->post('userID');
            if(empty($userID) || !is_numeric($userID)){
                return false;
            }
            $socialTable = $this->tableNameSocial;
            $insertUpdateData = [
                'listingID' => $id,
                'userID'   => $userID,
                'facebook' => $this->input->post('facebook'),
                'twitter'  => $this->input->post('twitter'),
                'google' => $this->input->post('google'),
                'linkedIn' => $this->input->post('linkedIn'),
                'youTube' => $this->input->post('youTube'),
                'vimeo' => $this->input->post('vimeo'),
                'instagram' => $this->input->post('instagram')
            ];

            //First Lets Check if Record already exist in db or not.
            $whereSocial = ['listingID'=>$id];
            $socialLinksRecords = $this->Common_model->select_fields_where($socialTable,'COUNT(1) as TotalFound',$whereSocial,true);
            //If Record already exist in db. then just update the social links.
            if($socialLinksRecords->TotalFound > 0){
                $insertUpdateData['date_updated'] = date('Y-m-d H:i:s');
                $resultUpdate = $this->Common_model->update($socialTable,$whereSocial,$insertUpdateData);
                //Throw the Message for the User.
                if($resultUpdate == true){
                    echo 'OK::Record Successfully Updated::success';
                }else{
                    echo 'FAIL::'.print_r($updateResult).'::error';
                }
            }else{ //If Not exist record for social links. then just create the new record.
                $insertUpdateData['date_created'] = date('Y-m-d H:i:s');
                $insertUpdateData['date_updated'] = date('Y-m-d H:i:s');
                $resultInsertion = $this->Common_model->insert_record($socialTable,$insertUpdateData);
                //Throw the Message for the User.
                if($resultInsertion > 0){
                    echo 'OK::Record Successfully Added::success';
                }else{
                    echo 'FAIL::'.print_r($updateResult).'::error';
                }
            }
            return;
        }


        if(empty($name)){
            echo 'FAIL::Invalid Post Data::error';
            return false;
        }


        $whereUpdate = ['id' => $id];
        $updateData = [
            $name => $value
        ];
        $updateResult = $this->Common_model->update($table,$whereUpdate,$updateData);
        if($updateResult == true){
            echo 'OK::Record Successfully Updated::success';
        }else{
            echo 'FAIL::'.print_r($updateResult).'::error';
        }
    }

    public function ApproveVersion(){

        if($this->input->post('verId') && $this->input->post('listId') &&
            !empty($this->input->post('verId')) && !empty($this->input->post('listId'))
            && $this->input->post('verId') != 'null' && $this->input->post('listId')!= 'null' )
        {
            $verId = $this->input->post('verId');
           $listId = $this->input->post('listId');
            // lets copy the latest version to active table
           $message = approveNewVersion($verId, $listId, $this);
            echo $message;
            /*
                        $where = array(
                            'id'=>$verId
                        );
                        $result = $this->Common_model->select_fields_where($this->versionTable, '*', $where, true);
                        $result->is_new_ver = 'No';
                        $field = $this->listingField;
                        $where = array('id' => $result->$field);
                        // this are some additional columns in version table, remove them from array and then update
                        $unsetAttr = [$field, 'id', 'Publish', 'not_approve', 'cancel_msg'];
                        foreach($unsetAttr as $attr)
                            unset($result->$attr);
                         $dataToCopy = array(
                             'name' => $result->name,
                             'email' => $result->email,
                             'website' => $result->website,
                             'address_street_number' => $result->address_street_number,
                             'address_street_name' =>$result->address_street_name,
                             'address_town' => $result->address_town,
                             'address_state' =>$result->address_state,
                             'address_post_code' => $result->address_post_code,
                             'business' => $result->business,
                             'corporate_date' => $result->corporate_date,
                             'expiry_date' => $result->expiry_date,
                             'acn_number' => $result->acn_number,
                             'short_description' => $result->short_description,
                             'keywords' => $result->keywords,
                             'doShowItems' => $result->doShowItems,
                             'template' => $result->template,
                             'is_new_ver'=>'No',
                             'version'=>$result->version
                             );
            
                        // update active table
                        $response = $this->Common_model->update($this->tableName, $where, $result);
                        if($response){
                            // set not_approve to zero in version table
                            $this->Common_model->update($this->versionTable, ['id'=>$verId], ['not_approve'=>0]);
                            echo 'OK::New Version of '.$result->name.' has been approved::success::Version Approved';
                        } else {
                            echo 'OK::Error! New version has not approved::error::Not Approved';
                        }*/
        }
    } // end of approveVersion function
    
    // disapprove version
    public function disapproveVersion(){
        if($this->input->post('verId') && !empty($this->input->post('verId'))){
            $verId = $this->input->post('verId');
            $response = $this->Common_model->update($this->versionTable, array('id'=>$verId), array('not_approve'=>1));
            if($response){
                echo 'OK::New Version has been disapproved::success::Version Disapproved';
            } else {
                echo 'OK::Error! Try again::error::Error';
            }
        }
    } // end of disapproveVersion function
    
    // message to illustrate why admin disapproving the particular listing version
    public function disapprovalMsg(){
        if($this->input->post('verId') && !empty($this->input->post('verId')) &&
            $this->input->post('msg') && !empty($this->input->post('msg'))){
            $verId = $this->input->post('verId');
            $cancel_msg = $this->input->post('msg');
            $response = $this->Common_model->update($this->versionTable, array('id'=>$verId), array('cancel_msg'=>$cancel_msg));
            if($response){
                echo 'OK::Message Submitted::success::Success';
            } else {
                echo 'OK::Error! Message not submitted. Try again::error::Error';
            }
        }
    }

    // for user to rollback from listing new version which's not approved yet
    public function rollBack(){
        if($this->input->post('verId') && !empty($this->input->post('verId'))){
            $verId = $this->input->post('verId');
            $listId = $this->input->post('listId');
            $response = $this->Common_model->delete($this->versionTable, array('id'=>$verId));
            if($response){
                $this->Common_model->update($this->tableName, array('id'=>$listId), array('is_new_ver'=>'No'));
                echo 'OK::Rolled Back Successfully::success::Success';
            } else {
                echo 'OK::Error! Try again::error::Error';
            }
        }
    } // end of rollback function

    public function ResetStatus()
    {
        $response = Admincontrol_helper::SavePreviousStatus($this);
        if ($response){
            echo 'OK::Status Successfully Reset::success::Success';
        }
        else
            echo 'OK::Not Reset. Try again::error::Error';
    }
    // restore previous status
    public function RestoreStatus(){
        $prevStatusId = $this->input->post('prevStatusId');
        $result = $this->Common_model->select_fields_where('listing_status','*', array('id'=>$prevStatusId), true);
        $where = array('id'=>$result->listing_id);
        $data = array(
            'date_updated'=>$result->status_date,
            $this->statusField=>$result->prev_status
            );
        $this->Common_model->update($this->tableName, $where, $data);
        // delete after restore
        $result = $this->Common_model->delete('listing_status',array('id'=>$prevStatusId));
        if($result > 0){
            // get listing name by id
            $response = $this->Common_model->select_fields_where($this->tableName,'name',$where, true);
            echo 'OK::Status of '.$response->name.' is Restored Back Successfully::success::Restored Successfully';
        } else {
            echo 'OK::Not Restored. Try again::error::Error';
        }
    }
    // delete previous status
    public function DeleteStatus(){
        $prevStatusId = $this->input->post('prevStatusId');
        $result = $this->Common_model->delete('listing_status',array('id'=>$prevStatusId));
        if($result > 0){
            echo 'OK::Record Deleted Successfully::success::Restored Successfully';
        } else {
            echo 'OK::Not Deleted. Try again::error::Error';
        }
    }
    public function bulk_actions_processings($statuscheck=NULL){ // added by HAmid Raza
       $ids       =  $this->input->post('ids');
       $action    =  $this->input->post('bulk_status');
       $DeleteRec = '';
        $Approve   = '';
        $DisApprove   = '';
        switch ($action) {
            case 'Approve':  // new versions
                $Approve = 102;
                break;
            case 'DisApprove': // Disapprove new versions
                $DataArray['not_approve'] = 1 ." ";
                $DisApprove = 101;
                break;
            case 'Trashed':
                $DataArray['trashed'] = 1 ." ";
                break;
            case 'Un-Trashed': // untrashed
                $DataArray['trashed'] = 0 ." ";
                break;
            case 'Delete':
                $DeleteRec = 'delete';
                break;
            case 'Published':
                if(isCurrentUserAdmin(get_instance())){
                    $DataArray['Publish'] = 1 ." ";
                }else{
                    $DataArray['Publish'] = 0 ." ";
                }
                break;
            case 'UnPublished': // unpublished
                $DataArray['Publish'] = 0 ." ";
                break;
            default:
                $DataArray['status'] = $action ." ";
        }
        $where = ' id IN (' . $ids . ')';
        if( $DeleteRec == 'delete' && (!empty($DeleteRec))){
            $result  = $this->Common_model->delete($this->tableName,$where);
            if($result) {
                echo "OK::Record Successfully Deleted::success";
            }else{
                echo "FAIL::Something went wrong during Delete, Please Contact System Administrator::error";
            }
        }
        elseif($DisApprove == 101 && isCurrentUserAdmin(get_instance())){
            $ids = explode(',',$ids);
            foreach($ids as $id ){
                $where = array(
                    $this->listingField => $id,
                );

                $result = $this->Common_model->select_fields_where($this->versionTable,'*', $where, true,"","","",",","version DESC",false,"1");
                $where = array(
                    'id' => $result->id,
                );
                $resultUpdate = $this->Common_model->update($this->versionTable, $where, $DataArray);
            }
            if($resultUpdate[code] == 0) {
                echo "OK::Version DisApproved Successfully::success";
            }else {
                echo "FAIL::Something went wrong during DisApproved version, Please Contact System Administrator::error";
            }
        }elseif($Approve == 102 && isCurrentUserAdmin(get_instance())){

            $ids = explode(',',$ids);
            foreach($ids as $id ){
                 $where = array(
                    $this->listingField => $id,
                );
                $result = $this->Common_model->select_fields_where($this->versionTable,'*', $where, true,"","","",",","version DESC",false,"1");
                $table_id = $this->listingField;
                $where = array(
                    'id' => $result->$table_id,
                );

                $unset_column = ['id', $this->listingField ,'not_approve','cancel_msg']; // REMOVE UNNCESSORY COLUMN
                foreach($unset_column as $attr){
                    unset($result->$attr);
                }
                $result->is_new_ver = "No". ' ';
                $resultUpdate = $this->Common_model->update($this->tableName, $where, $result);
            }
            if($resultUpdate[code] == 0) {
                echo "OK::Version Approved Successfully::success";
            }else {
                echo "FAIL::Something went wrong during Approved version, Please Contact System Administrator::error";
            }
        }else{
            $resultUpdate = $this->Common_model->update($this->tableName, $where, $DataArray);
           // echo $this->db->last_query();
           // exit;
            if($resultUpdate === true) {
                echo "OK::Record Updated Successfully::success";
            }else {
                echo "FAIL::Something went wrong during Update, Please Contact System Administrator::error";
            }
        }
    }
}
