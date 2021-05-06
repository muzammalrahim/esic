<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AcceleratingCommercialisation extends Listing{

    public $data                = array('');
    public $CurrentID           = 0;
    public $LogoDbField         = 'logo';
    public $BannerDbField       = 'banner';
    public $tableName           = 'esic_acceleration';
    public $tableFID            = 'accelerationID';
    public $tableNameSocial     = 'acceleration_social';
    public $BannerNamePrefix    = 'acceleratingCommercialisationBanner';
    public $LogoNamePrefix      = 'acceleratingCommercialisationLogo';
    public $Name                = 'AcceleratingCommercialisation';
    public $NameMessage         = 'Accelerating Commercialisation';
    public $ImagesFolderName    = 'acceleratingcommercialisation';
    public $ViewFolderName      = 'acceleratingcommercialisation';
    public $ListFileName        = 'acceleratingcommercialisation';
    public $ControllerName      = 'AcceleratingCommercialisation';
    public $ControllerRouteName = 'AcceleratingCommercialisation';
    public $ControllerRouteManage = 'manage_acceleratingcommercialisation';
    public $QuestionsView       = 'esic_questions';
    public $QuestionListingID   = 6;
    public $hasQuestionaire = true;
    public $listingDatabase     = 'acceleratingcommercialisation_database';

    function __construct(){
        parent::__construct();
        $this->load->helper('viewacceleratingcommercialisation');
        $this->DefaultRedirectUrl = 'accelerator';
        $this->session->set_userdata('DefaultRedirectUrl', $this->DefaultRedirectUrl);

        //Validate the Views that needs the Redirect to Login Page if User is Not Logged In.
        $this->validate_login(['Manage','View','Edit']);
    }
}
