<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RndConsultant extends Listing {
    
    public $data                  = array('');
    public $CurrentID             = 0;
    public $LogoDbField           = 'logo';
    public $BannerDbField         = 'banner';
    public $tableName             = 'esic_rndconsultant';
    public $tableFID              = 'rndconsultantID';
    public $tableNameSocial       = 'rndconsultant_social';
    public $BannerNamePrefix      = 'RndConsultantBanner';
    public $LogoNamePrefix        = 'RndConsultantLogo';
    public $Name                  = 'RndConsultant';
    public $NameMessage           = 'R&D Consultant';
    public $ImagesFolderName      = 'rndconsultant';
    public $ViewFolderName        = 'default';
    public $ListFileName          = 'default';
    public $ControllerName        = 'RndConsultant';
    public $ControllerRouteName   = 'RndConsultant';
    public $ControllerRouteManage = 'manage_rndconsultant';
    public $pageMessage           = 'page_message_manage_rndcosultant';
    public $QuestionsView         = 'esic_questions';
    public $QuestionListingID     = 7;
    public $hasQuestionaire       = false;
    public $versionTable          = 'esic_rndconsultant_ver';
    public $listingField          = 'rndconsultant_id';
    public $listingDatabase       = 'rndconsultant_database';
    public $listingDatabaseSearch = 'searchrndconsultant';
    function __construct(){
        parent::__construct();
        $this->load->helper('view');
        $this->DefaultRedirectUrl = 'rndconsultant';
        $this->session->set_userdata('DefaultRedirectUrl', $this->DefaultRedirectUrl);
        //Validate the Views that needs the Redirect to Login Page if User is Not Logged In.
        $this->validate_login(['Manage','View','Edit']);
    }
}
