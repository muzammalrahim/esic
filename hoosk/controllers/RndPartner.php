<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RndPartner extends Listing{
    
    public $data                = array('');
    public $CurrentID           = 0;
    public $LogoDbField         = 'logo';
    public $BannerDbField       = 'banner';
    public $tableName           = 'esic_rndpartner';
    public $tableFID            = 'rndpartnerID';
    public $tableNameSocial     = 'rndpartner_social';
    public $BannerNamePrefix    = 'RndPartnerBanner';
    public $LogoNamePrefix      = 'RndPartnerLogo';
    public $Name                = 'RndPartner';
    public $NameMessage         = 'R&D Partner';
    public $ImagesFolderName    = 'rndpartner';
    public $ViewFolderName      = 'rndpartner';
    public $ListFileName        = 'rndpartner';
    public $ControllerName      = 'RndPartner';
    public $ControllerRouteName = 'RndPartner';
    public $ControllerRouteManage = 'manage_rndpartner';
    public $pageMessage = 'page_message_manage_rndpartner';
    public $QuestionsView       = 'esic_questions';
    public $hasQuestionaire = false;
    public $QuestionListingID  = 5;
    public $versionTable        = 'esic_rndpartner_ver';
    public $listingField        = 'rndpartner_id';
    public $listingDatabase     = 'rndpartner_database';
    public $listingDatabaseSearch     = 'searchRNDpartner';
    function __construct(){
        parent::__construct();
        $this->load->helper('viewrndpartner');
        $this->DefaultRedirectUrl = 'rndpartner';
        $this->session->set_userdata('DefaultRedirectUrl', $this->DefaultRedirectUrl);

        //Validate the Views that needs the Redirect to Login Page if User is Not Logged In.
        $this->validate_login(['Manage','View','Edit']);
    }
}
