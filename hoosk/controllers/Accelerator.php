<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accelerator extends Listing{

    public $data                = array('');
    public $CurrentID           = 0;
    public $LogoDbField         = 'logo';
    public $BannerDbField       = 'banner';
    public $tableName           = 'esic_accelerators';
    public $tableFID            = 'acceleratorID';
    public $tableNameSocial     = 'accelerator_social';
    public $BannerNamePrefix    = 'AcceleratorBanner';
    public $LogoNamePrefix      = 'AcceleratorLogo';
    public $Name                = 'Accelerator';
    public $NameMessage         = 'Accelerator';
    public $ImagesFolderName    = 'accelerator';
    public $ViewFolderName      = 'accelerator';
    public $ListFileName        = 'accelerator';
    public $ControllerName      = 'Accelerator';
    public $ControllerRouteName = 'Accelerator';
    public $ControllerRouteManage = 'manage_accelerator';
    public $pageMessage = 'page_message_manage_accelerator'; // Can Put the Lang Variable or can put the entire message here
    public $QuestionsView = 'esic_questions';
    public $QuestionListingID  = 3;
    public $hasQuestionaire = true;
    public $versionTable        = 'esic_accelerators_ver';
    public $listingField        = 'accelerator_id';
    public $listingDatabase     = 'accelerator_database';
    public $listingDatabaseSearch     = 'searchAccelerator';
    public $statusField         = 'AcceleratorStatus';
    public $statusText          = 'This will set all status to pending. You can view previous status after';
    function __construct(){
        parent::__construct();
        $this->load->helper('viewaccelerator'); 
        $this->DefaultRedirectUrl = 'accelerator';
        $this->session->set_userdata('DefaultRedirectUrl', $this->DefaultRedirectUrl);

        //Validate the Views that needs the Redirect to Login Page if User is Not Logged In.
        $this->validate_login(['Manage','View','Edit']);
    }
}
