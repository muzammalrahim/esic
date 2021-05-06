<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GrantConsultant extends Listing{
    
    public $data                = array('');
    public $CurrentID           = 0;
    public $LogoDbField         = 'logo';
    public $BannerDbField       = 'banner';
    public $tableName           = 'esic_grantconsultant';
    public $tableFID            = 'grantconsultantID';
    public $tableNameSocial     = 'grantconsultant_social';
    public $BannerNamePrefix    = 'grantConsultantBanner';
    public $LogoNamePrefix      = 'grantConsultantLogo';
    public $Name                = 'GrantConsultant';
    public $NameMessage         = 'Grant Consultant';
    public $ImagesFolderName    = 'grantconsultant';
    public $ViewFolderName      = 'default';
    public $ListFileName        = 'default';
    public $ControllerName      = 'GrantConsultant';
    public $ControllerRouteName = 'GrantConsultant';
    public $ControllerRouteManage = 'manage_grantconsultant';
    public $pageMessage = 'page_message_manage_grantconsultant';
    public $QuestionsView = 'esic_questions';
    public $QuestionListingID  = 8;
    public $hasQuestionaire = false;
    public $versionTable        = 'esic_grantconsultant_ver';
    public $listingField        = 'grantconsultant_id';
    public $listingDatabase     = 'grantconsultant_database';
    public $listingDatabaseSearch     = 'searchgrantconsultant';
    public $statusText          = 'This will set all status to private. You can view previous status after';
    public $statusField         = 'status_flag_id';

    function __construct(){
        parent::__construct();
        $this->load->helper('view');
        $this->DefaultRedirectUrl = 'grantconsultant';
        $this->session->set_userdata('DefaultRedirectUrl', $this->DefaultRedirectUrl);

        //Validate the Views that needs the Redirect to Login Page if User is Not Logged In.
        $this->validate_login(['Manage','View','Edit']);
    }
}
