<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lawyer extends Listing{

    public $data                = array('');
    public $CurrentID           = 0;
    public $LogoDbField         = 'logo';
    public $BannerDbField       = 'banner';
    public $tableName           = 'esic_lawyers';
    public $tableFID            = 'lawyerID';
    public $tableNameSocial     = 'lawyer_social';
    public $BannerNamePrefix    = 'LawyerBanner';
    public $LogoNamePrefix      = 'LawyerLogo';
    public $Name                = 'Lawyer';
    public $NameMessage         = 'Lawyer';
    public $ImagesFolderName    = 'lawyers';
    public $ViewFolderName      = 'default';
    public $ListFileName        = 'default';
    public $ControllerName      = 'Lawyer';
    public $ControllerRouteName   = 'Lawyer';
    public $ControllerRouteManage = 'manage_lawyer';
    public $pageMessage = 'page_message_manage_lawyer';
    public $QuestionsView = 'esic_questions';
    public $QuestionListingID  = 8;
    public $hasQuestionaire = false;
    public $versionTable        = 'esic_lawyers_ver';
    public $listingField        = 'lawyer_id';
    public $listingDatabase     = 'lawyer_database';
    public $listingDatabaseSearch = 'searchLawyer';
    public $statusText          = 'This will set all status to private. You can view previous status after';
    public $statusField         = 'status_flag_id';

    function __construct(){
        parent::__construct();
        $this->load->helper('view');
        $this->DefaultRedirectUrl = 'lawyer';
        $this->session->set_userdata('DefaultRedirectUrl', $this->DefaultRedirectUrl);

        //Validate the Views that needs the Redirect to Login Page if User is Not Logged In.
        $this->validate_login(['Manage','View','Edit']);
    }
}
