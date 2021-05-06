<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Esic extends Listing{

    public $data                = array('');
    public $CurrentID           = 0;
    public $LogoDbField         = 'logo';
    public $BannerDbField       = 'banner';
    public $prodImageDbField    = 'productImage';
    public $tableName           = 'esic';
    public $tableFID            = 'esicID';
    public $tableNameSocial     = 'esic_social';
    public $BannerNamePrefix    = 'EsicBanner';
    public $LogoNamePrefix      = 'EsicLogo';
    public $ProdNamePrefix      = 'EsicProdImg';
    public $Name                = 'Esic';
    public $NameMessage         = 'Esic';
    public $ImagesFolderName    = 'esic';
    public $ViewFolderName      = 'esic';
    public $ListFileName        = 'esic';
    public $ControllerName      = 'Esic';
    public $ControllerRouteName = 'Esic';
    public $ControllerRouteManage = 'manage_esic';
    public $QuestionsView       = 'esic_questions';
    public $QuestionListingID   = 1;
    public $pageMessage         = 'page_message_manage_esic';
    public $hasQuestionaire = true;
    public $versionTable        = 'esic_ver';
    public $listingField        = 'esic_id';
    public $listingDatabase     = 'esic_database';
    public $listingDatabaseSearch = 'searchDatabaseListing';
    public $statusField         = 'status';
    public $statusText          = 'This will set all status to pending. You can view previous status after';
    function __construct(){ 
        parent::__construct();
        $this->load->helper('viewesic');
        $this->DefaultRedirectUrl = 'esic';
        $this->session->set_userdata('DefaultRedirectUrl', $this->DefaultRedirectUrl);

        //Validate the Views that needs the Redirect to Login Page if User is Not Logged In.
        $this->validate_login(['Manage','View','Edit']);
    }
}
//Esic/EditSave ViewHelperEditSave in viewesic_helper