<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TaxAdvisors extends Listing {

    public $data                  = array('');
    public $CurrentID             = 0;
    public $LogoDbField           = 'logo';
    public $BannerDbField         = 'banner';
    public $tableName             = 'esic_taxadvisors';
    public $tableFID              = 'taxadvisorsID';
    public $tableNameSocial       = 'taxadvisors_social';
    public $BannerNamePrefix      = 'TaxAdvisorsBanner';
    public $LogoNamePrefix        = 'TaxAdvisorsLogo';
    public $Name                  = 'TaxAdvisors';
    public $NameMessage           = 'Tax Advisers';
    public $ImagesFolderName      = 'taxadvisors';
    public $ViewFolderName        = 'default';
    public $ListFileName          = 'default';
    public $ControllerName        = 'TaxAdvisors';
    public $ControllerRouteName   = 'TaxAdvisors';
    public $ControllerRouteManage = 'manage_taxadvisors';
    public $pageMessage           = 'page_message_manage_taxadvisors';
    public $QuestionsView         = 'esic_questions';
    public $QuestionListingID     = 7;
    public $hasQuestionaire       = false;
    public $versionTable          = 'esic_taxadvisors_ver';
    public $listingField          = 'taxadvisor_id';
    public $listingDatabase       = 'taxadvisors_database';
    public $listingDatabaseSearch = 'searchtaxadvisors';
    function __construct(){
        parent::__construct();
        $this->load->helper('view');
        $this->DefaultRedirectUrl = 'taxadvisors';
        $this->session->set_userdata('DefaultRedirectUrl', $this->DefaultRedirectUrl);
        //Validate the Views that needs the Redirect to Login Page if User is Not Logged In.
        $this->validate_login(['Manage','View','Edit']);
    }
}
