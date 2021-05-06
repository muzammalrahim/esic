<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class University extends Listing{

    public $data                = array('');
    public $CurrentID           = 0;
    public $LogoDbField         = 'logo';
    public $BannerDbField       = 'banner';
    public $tableName           = 'esic_institution';
    public $tableFID            = 'institutionID';
    public $tableNameSocial     = 'institution_social';
    public $BannerNamePrefix    = 'UniversityBanner';
    public $LogoNamePrefix      = 'UniversityLogo';
    public $Name                = 'University';
    public $NameMessage         = 'University';
    public $ImagesFolderName    = 'university';
    public $ViewFolderName      = 'university';
    public $ListFileName        = 'university';
    public $ControllerName      = 'University';
    public $ControllerRouteName = 'University';
    public $ControllerRouteManage = 'manage_university';
    public $QuestionsView       = 'esic_questions';
    public $QuestionListingID   = 4;
    public $hasQuestionaire = false;
    public $listingDatabase     = 'university_database';

    function __construct(){
        parent::__construct();
        $this->load->helper('viewuni');
        $this->DefaultRedirectUrl = 'university';
        $this->session->set_userdata('DefaultRedirectUrl', $this->DefaultRedirectUrl);

        //Validate the Views that needs the Redirect to Login Page if User is Not Logged In.
        $this->validate_login(['Manage','View','Edit']);
    }
}
