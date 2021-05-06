<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/


//Update the tables.
$route['admin/Cron_Update_Status/SavePreviousStatus'] = "Cron_Update_Status/SavePreviousStatus";
$route['admin/sessions'] = "Admin/esic_sessions";
$route['admin/barcode123'] = "Admin/barcode";
$route['updates'] = "Admin/updateDB";
//$route['prePopulated/(:any)/(:any)/(:any)'] = "Admin/getListingValues/$1/$2/$3";
$route['template/(:any)'] = "Esic/view_template/$1";

//For Feed
$route['feed'] = "Feeds/index";
$route['feed/atom'] = "Feeds/atom";

//For Search
$route['searchEsicCheck'] = "Search/searchEsicCheck";
$route['search'] = "Search/fetchdata";
$route['searchListing'] = "Search/fetchdata";
$route['searchListing/(:any)'] = "Search/fetchdata";
$route['search/(:any)'] = "Search/fetch/$1";

// for search  local  providers
$route['search_local_providers'] = "Search/search_local_providers";
$route['search_local_providers/(:any)'] = "Search/search_local_providers/$1";


//For Services Search.
$route['services/search'] = "Services/fetch";
$route['services/searchListing'] = "Services/fetchdata";
$route['services/search/(:any)'] = "Services/fetch/$1";
$route['services/filter'] = "Services/updateServiceFilter";
$route['get_post_codes'] = "Services/GetPostCodes";
$route['admin/setting/services'] = "Services/AdminSetting";
$route['admin/setting/services/(:any)'] = "Services/Edit/$1";
$route['Service/Edit/Save'] = "Services/EditSave";


$route['login'] 		= "Login/login";
$route['logout'] 		= "Login/logout";
$route['login/checked']   = "Login/loginChecked";
$route['login/loginCheckeds']   = "Login/loginCheckeds"; // after registerations
$route['login/googlejslogins']   = "Login/googlejslogins";

$route['login/google_login']   = "Login/google_login"; // google plus
$route['Login/google_login']   = "Login/google_login"; // google plus


$route['register'] = "Register/index";
$route['Register/createmember'] = "Register/signup";
$route['User/New'] = "Users/newUser";


//$route['admin/fb'] = "admin/fb";
$route['scriptConvertMake'] = "Script/makeSlug";

$route['sitemap\.xml'] = "Update_sitemap/index";
//$route['sitemap']        = "Sitemap/index";

$route['attachments'] = "Users/upload";
$route['admin'] = "Admin";
$route['admin/status/(:any)'] = "Admin/index/$1";
$route['admin/esicListing'] = "Admin/esicDashBoardListing";
$route['admin/esicListing/(:any)'] = "Admin/esicDashBoardListing/$1";
$route['admin/allListings'] = "Admin/allDashBoardListing";
$route['admin/allListings/(:any)'] = "Admin/allDashBoardListing/$1";
$route['admin/users'] = "Users";
$route['admin/users/new'] = "Users/addUser";
$route['admin/users/new/add'] = "Users/confirm";
$route['admin/users/delete/(:any)'] = "Users/delete";
$route['admin/users/edit/(:any)'] = "Users/editUser";
$route['admin/users/edited/(:any)'] = "Users/edited";
//$route['admin/user/forgot'] = 'Admin/users/forgot'; //
//$route['admin/users/forgot'] = 'Users/forgot'; //
$route['admin/reset_password/forgot'] = 'Reset_password/forgot';
$route['admin/users/(:any)'] = "Users";
$route['admin/reset/(:any)'] = 'Admin/users/getPassword'; //
$route['admin/pages'] = "Pages";
$route['admin/pages/search_widget_status'] = "Pages/search_widget_status";
$route['admin/users/email'] = "Users/email";
$route['admin/users/email/(:any)'] = "Users/email/$1";
$route['admin/users/single_email'] = "Users/single_email";
$route['admin/users/single_email/(:any)'] = "Users/single_email/$1";
$route['admin/users/single_email_content'] = "Users/single_email_content";
$route['admin/users/single_email_content/(:any)'] = "Users/single_email_content/$1";
$route['admin/users/send_email'] = "Users/send_email";
$route['admin/users/send_email/(:any)'] = "Users/send_email/$1";
$route['admin/users/sent'] = "Users/sent";
$route['admin/users/sent/listing'] = "Users/sent/listing";
$route['admin/users/sent/delete'] = "Users/sent/delete";


$route['Admin/subscribe/add'] = "Users/subscribe_add";
$route['admin/subscriptions'] = "Users/subscribe_list";// for page load
$route['admin/subscriptions/listing'] = "Users/subscribe_list/listing"; //for ajax to show data table data
$route['admin/subscriptions/delete'] = "Users/subscribe_list/delete"; //for ajax to delete


//For Adding Custom Entries in Listing
$route['Esic/storeInPrePopulated'] = "Esic/storeInPrePopulated";
$route['Investor/storeInPrePopulated'] = "Investor/storeInPrePopulated";
$route['RndConsultant/storeInPrePopulated'] = "RndConsultant/storeInPrePopulated";
$route['TaxAdvisors/storeInPrePopulated'] = "TaxAdvisors/storeInPrePopulated";
$route['Lawyer/storeInPrePopulated'] = "Lawyer/storeInPrePopulated";
$route['Accelerator/storeInPrePopulated'] = "Accelerator/storeInPrePopulated";
$route['AcceleratingCommercialisation/storeInPrePopulated'] = "AcceleratingCommercialisation/storeInPrePopulated";
$route['GrantConsultant/storeInPrePopulated'] = "GrantConsultant/storeInPrePopulated";
$route['RndPartner/storeInPrePopulated'] = "RndPartner/storeInPrePopulated";


//Add of Esic Weebly Live
// manage pre assessment profile
$route['admin/manage_profile']        = "Admin/manage_profile";
$route['admin/manage_profile/(:any)'] = "Admin/manage_profile/$1";

$route['admin/assessments_list']        = "Admin/assessments_list";
$route['admin/fetch_esic_status']        = "Admin/fetch_esic_status";

$route['admin/assessments_list/(:any)'] = "Admin/assessments_list/$1";
$route['admin/assessment_list']       	= "Admin/assessment_list";
$route['admin/assessment_list/(:any)']  = "Admin/assessment_list/$1";
$route['admin/publish_assessment_list']  = "Admin/publish_assessment_list";
$route['admin/publish_assessment_list/(:any)']  = "Admin/publish_assessment_list/$1";
//$route['admin/details']      	= "Admin/details";
$route['admin/details/(:any)']      	= "Admin/details/$1";
$route['admin/getanswers']	= "Admin/getanswers";
$route['admin/saveanswer']	= "Admin/saveanswer";
$route['admin/savedate']  	= "Admin/savedate";
$route['admin/savedesc']  	= "Admin/savedesc";
$route['admin/saveshortdesc']	= "Admin/saveshortdesc";
$route['admin/savelogo']		= "Admin/savelogo";
$route['admin/saveBannerImage']  	= "Admin/saveBannerImage";
$route['admin/saveProductImage']  	= "Admin/saveProductImage";
$route['admin/updatename']  	= "Admin/updatename";
$route['admin/resetThumbsUp']  	= "Admin/resetThumbsUp";
$route['admin/updatewebsite']	= "Admin/updatewebsite";
$route['admin/updatecompany']	= "Admin/updatecompany";
$route['admin/updateemail']  	= "Admin/updateemail";
$route['admin/updateip']  		= "Admin/updateip";
$route['admin/updateacn']  		= "Admin/updateacn";
$route['admin/updateAddress']  		= "Admin/updateAddress";
$route['admin/updatebsName']  	= "Admin/updatebsName";
$route['admin/getsectors']		= "Admin/getsectors";
$route['admin/savesector']		= "Admin/savesector";
$route['admin/updateemail']  	= "Admin/updateemail";
$route['admin/updateip']  		= "Admin/updateip";
$route['admin/manage_status']          	= "Admin/manage_status";
$route['admin/manage_status/(:any)']    = "Admin/manage_status/$1";
$route['admin/manage_appstatus']       	= "Admin/manage_appstatus";
$route['admin/manage_appstatus/(:any)'] = "Admin/manage_appstatus/$1";
//$route['admin/serachListing']   = "Admin/SearchAllListing";



//For Esic
$route['admin/manage_esic']    	  	= "Esic/Manage";
$route['admin/manage_esic/(:any)']  = "Esic/Manage/$1";
$route['admin/Esic/view/(:any)']    = "Esic/View/$1";
$route['admin/Esic/detail/(:any)']  = "Esic/Detail/$1";
$route['Esic/Listing']      		= "Esic/Manage";
$route['Esic/Add']    	  			= "Esic/Add";
$route['Esic/New']    	  			= "Esic/NewListing";
$route['Esic/AddSave']      		= "Esic/AddSave";
$route['Esic/Edit/(:any)']  		= "Esic/Edit/$1";
$route['Esic/EditSave']     		= "Esic/EditSave";
$route['admin/Esic/emailcheck'] 	= "Esic/EmailCheck";
$route['admin/Esic/savedesc']   	= "Esic/SavePageBuilderContent";
$route['Esic/QuestionAnwsers/Save'] = "Esic/SaveQuestionAnswers";
$route['admin/Esic/getPreview'] 	= "Esic/ShowPreview";
$route['esic']  					= "Esic/FrontForm";
$route['Esic']  					= "Esic/FrontForm";
$route['Esic/bulk_actions_processings'] = "Esic/bulk_actions_processings";
$route['Esic/bulk_actions_processings/(:any)'] = "Esic/bulk_actions_processings/$1";
$route['admin/Esic/details/(:any)'] = "Esic/Detail/$1";
$route['Admin/Esic/resetStatus']    = "Esic/ResetStatus";
$route['Admin/Esic/prevStatus']     = "Esic/PrevStatusListing";
$route['Admin/Esic/restore']        = "Esic/RestoreStatus";
$route['Admin/Esic/deleteStatus']        = "Esic/DeleteStatus";
$route['Esic/OpenPageBuilder'] 		= "Esic/OpenPageBuilder";
$route['Esic/OpenPageBuilder/(:any)'] = "Esic/OpenPageBuilder/$1";
$route['Esic/ApproveVersion']      = "Esic/approveVersion";
$route['Esic/DisapproveVersion']      = "Esic/disapproveVersion";
$route['Esic/disapprovalMsg']      = "Esic/disapprovalMsg";
$route['Esic/rollBack']      = "Esic/rollBack";
$route['Esic/(:any)']  	   			= "Esic/Details/$1";
$route['Esic/(:any)/(:any)']  	   	= "Esic/DetailByTemplate/$1/$2";
$route['Esic/previewValueUpdate'] = 'Esic/updatePreviewValue';


//For Investors
$route['admin/manage_investor']    	    = "Investor/Manage";
$route['admin/manage_investor/(:any)']  = "Investor/Manage/$1";
$route['admin/Investor/view/(:any)']    = "Investor/View/$1";
$route['admin/Investor/detail/(:any)']  = "Investor/Detail/$1";
$route['Investor/Listing']    			= "Investor/Manage";
$route['Investor/Add']    	   			= "Investor/Add";
$route['Investor/AddSave']      		= "Investor/AddSave";
$route['Investor/Edit/(:any)']  		= "Investor/Edit/$1";
$route['Investor/EditSave']     		= "Investor/EditSave";
$route['Investor/New']     				= "Investor/NewListing";
$route['investor']  					= "Investor/FrontForm";
$route['Investor']  					= "Investor/FrontForm";
$route['Investor/bulk_actions_processings'] = "Investor/bulk_actions_processings";
$route['Investor/bulk_actions_processings/(:any)'] = "Investor/bulk_actions_processings/$1";
$route['Investor/ApproveVersion']      = "Investor/ApproveVersion";
$route['Investor/DisapproveVersion']      = "Investor/disapproveVersion";
$route['Investor/disapprovalMsg']      = "Investor/disapprovalMsg";
$route['Investor/rollBack']      = "Investor/rollBack";
$route['investor_database']    			= "Investor/Listing";
$route['Investor/(:any)']  	  			= "Investor/Details/$1";
$route['Investor/(:any)/(:any)'] 		= "Investor/DetailByTemplate/$1/$2";



//$route['investor-pre-assessment']  	= "Investor/investor_form";
$route['investor-pre-assessment']  	= "Investor/FrontForm";
$route['investor-pre-assessment.html']  	= "Investor/FrontForm";





$route['admin/investor/certificate/upload']  = "Investor/Certificate";
$route['admin/Investor/emailcheck'] = "Investor/EmailCheck";
$route['Investor/QuestionAnwsers/Save'] = "Investor/SaveQuestionAnswers";



//For Lawyers
$route['admin/manage_lawyer']    	  = "Lawyer/Manage";
$route['admin/manage_lawyer/(:any)']  = "Lawyer/Manage/$1";
$route['admin/Lawyer/view/(:any)']    = "Lawyer/View/$1";
$route['admin/Lawyer/detail/(:any)']  = "Lawyer/Detail/$1";
$route['Lawyer/Listing']      = "Lawyer/Manage";
//$route['Lawyer/New']    	  = "Lawyer/Create";
$route['Lawyer/New']    	  = "Lawyer/NewListing";
$route['Lawyer/Add']    	  = "Lawyer/Add";
$route['Lawyer/AddSave']      = "Lawyer/AddSave";
$route['Lawyer/Edit/(:any)']  = "Lawyer/Edit/$1";
$route['Lawyer/EditSave']     = "Lawyer/EditSave";
$route['admin/Lawyer/emailcheck'] 	= "Lawyer/EmailCheck";
$route['admin/Lawyer/savedesc']   	= "Lawyer/SavePageBuilderContent";
$route['Admin/Lawyer/prevStatus']        = "Lawyer/PrevStatusListing";
$route['Admin/Lawyer/resetStatus']        = "Lawyer/ResetStatus";
$route['Admin/Lawyer/restore']        = "Lawyer/RestoreStatus";
$route['Admin/Lawyer/deleteStatus']        = "Lawyer/DeleteStatus";
$route['Lawyer/QuestionAnwsers/Save'] = "Lawyer/SaveQuestionAnswers";
$route['admin/Lawyer/getPreview'] 	= "Lawyer/ShowPreview";
$route['lawyer']  			  = "Lawyer/FrontForm";
$route['Lawyer']  			  = "Lawyer/FrontForm";
$route['lawyer_database']  	  = "Lawyer/Listing";

$route['lawyer_database/searchLawyer']= "Lawyer/listingDatabase";



$route['Lawyer/(:any)']  	  = "Lawyer/Details/$1";
$route['Lawyer/saveIntro']    = "Lawyer/saveIntro";
$route['Lawyer/OpenPageBuilder'] 		= "Lawyer/OpenPageBuilder";
$route['Lawyer/OpenPageBuilder/(:any)'] = "Lawyer/OpenPageBuilder/$1";
$route['Lawyer/(:any)']  	   			= "Lawyer/Details/$1";
$route['Lawyer/(:any)/(:any)']  	   	= "Lawyer/DetailByTemplate/$1/$2";
$route['Lawyer/previewValueUpdate']   = 'Lawyer/updatePreviewValue';
$route['Lawyer/ApproveVersion']      = "Lawyer/ApproveVersion";
$route['Lawyer/DisapproveVersion']      = "Lawyer/disapproveVersion";
$route['Lawyer/disapprovalMsg']      = "Lawyer/disapprovalMsg";
$route['Lawyer/rollBack']      = "Lawyer/rollBack";

$route['Lawyer/bulk_actions_processings'] = "Lawyer/bulk_actions_processings";
$route['Lawyer/bulk_actions_processings/(:any)'] = "Lawyer/bulk_actions_processings/$1";

//For  Accelerators
//old
$route['admin/manage_accelerators']    			= "Admin/manage_accelerators";
$route['admin/manage_accelerators/(:any)']    	= "Admin/manage_accelerators/$1";
//new
$route['admin/manage_accelerator']    	  	= "Accelerator/Manage";
$route['admin/manage_accelerator/(:any)']  	= "Accelerator/Manage/$1";
$route['admin/Accelerator/view/(:any)']    	= "Accelerator/View/$1";
$route['admin/Accelerator/detail/(:any)']  	= "Accelerator/Detail/$1";
$route['Accelerator/Listing']      	= "Accelerator/Manage";
$route['Accelerator/New']    	  	= "Accelerator/NewListing";
$route['Accelerator/Add']    	  	= "Accelerator/Add";
$route['Accelerator/AddSave']      	= "Accelerator/AddSave";
$route['Accelerator/Edit/(:any)']  	= "Accelerator/Edit/$1";
$route['Accelerator/EditSave']     	= "Accelerator/EditSave";
$route['accelerator_database']  	= "Accelerator/Listing";
$route['Accelerator/bulk_actions_processings'] = "Accelerator/bulk_actions_processings";
$route['Accelerator/bulk_actions_processings/(:any)'] = "Accelerator/bulk_actions_processings/$1";

//$route['accelerator_database/searchDatabaseListing']= "Accelerator/listingDatabase";
$route['accelerator_database/searchAccelerator']= "Accelerator/listingDatabase";
$route['admin/Accelerator/emailcheck'] 	= "Accelerator/EmailCheck";
$route['admin/Accelerator/savedesc']   	= "Accelerator/SavePageBuilderContent";
$route['Admin/Accelerator/resetStatus']    = "Accelerator/ResetStatus";
$route['Admin/Accelerator/prevStatus']    = "Accelerator/PrevStatusListing";
$route['Admin/Accelerator/restore']    = "Accelerator/RestoreStatus";
$route['Admin/Accelerator/deleteStatus']        = "Accelerator/DeleteStatus";
$route['Accelerator/QuestionAnwsers/Save'] = "Accelerator/SaveQuestionAnswers";
$route['admin/Accelerator/getPreview'] 	= "Accelerator/ShowPreview";
$route['accelerator']  	= "Accelerator/FrontForm";
$route['Accelerator']  	= "Accelerator/FrontForm";

$route['admin/Accelerator/details/(:any)'] = "Accelerator/Detail/$1";
$route['Accelerator/OpenPageBuilder'] 		= "Accelerator/OpenPageBuilder";
$route['Accelerator/OpenPageBuilder/(:any)'] = "Accelerator/OpenPageBuilder/$1";
$route['Accelerator/(:any)']  	   			= "Accelerator/Details/$1";
$route['Accelerator/(:any)/(:any)']  	   	= "Accelerator/DetailByTemplate/$1/$2";
$route['Accelerator/previewValueUpdate']   = 'Accelerator/updatePreviewValue';
$route['Accelerator/ApproveVersion']      = "Accelerator/ApproveVersion";
$route['Accelerator/DisapproveVersion']      = "Accelerator/disapproveVersion";
$route['Accelerator/disapprovalMsg']      = "Accelerator/disapprovalMsg";
$route['Accelerator/rollBack']      = "Accelerator/rollBack";


//For  Accelerating Commercialisation OR Grant Recipients
//old
$route['admin/manage_acc_commercials'] 			= "Admin/manage_acc_commercials";
$route['admin/manage_acc_commercials/(:any)'] 	= "Admin/manage_acc_commercials/$1";
//new
//Temporarily Removing the accerlating commercialization.
/*$route['admin/manage_acceleratingcommercialisation']    	   = "AcceleratingCommercialisation/Manage";
$route['admin/manage_acceleratingcommercialisation/(:any)']  = "AcceleratingCommercialisation/Manage/$1";
$route['admin/AcceleratingCommercialisation/view/(:any)']    = "AcceleratingCommercialisation/View/$1";
$route['admin/AcceleratingCommercialisation/detail/(:any)']  = "AcceleratingCommercialisation/Detail/$1";*/
$route['AcceleratingCommercialisation/Listing'] = "AcceleratingCommercialisation/Manage";
$route['AcceleratingCommercialisation/New']    	= "AcceleratingCommercialisation/NewListing";
$route['AcceleratingCommercialisation/Add']    	   	= "AcceleratingCommercialisation/Add";
$route['AcceleratingCommercialisation/AddSave']      	= "AcceleratingCommercialisation/AddSave";
$route['AcceleratingCommercialisation/Edit/(:any)']  	= "AcceleratingCommercialisation/Edit/$1";
$route['AcceleratingCommercialisation/EditSave']      = "AcceleratingCommercialisation/EditSave";
$route['admin/AcceleratingCommercialisation/emailcheck'] 	= "AcceleratingCommercialisation/EmailCheck";
$route['acceleratingcommercialisation_database']  	= "AcceleratingCommercialisation/Listing";

$route['acceleratingcommercialisation_database/searchDatabaseListing']= "AcceleratingCommercialisation/listingDatabase";

$route['admin/AcceleratingCommercialisation/savedesc']   	= "AcceleratingCommercialisation/SavePageBuilderContent";
$route['AcceleratingCommercialisation/QuestionAnwsers/Save'] = "AcceleratingCommercialisation/SaveQuestionAnswers";
$route['admin/AcceleratingCommercialisation/getPreview'] 	= "AcceleratingCommercialisation/ShowPreview";
$route['acceleratingcommercialisation']  	= "AcceleratingCommercialisation/FrontForm";
$route['AcceleratingCommercialisation/(:any)']  	  = "AcceleratingCommercialisation/Details/$1";
$route['AcceleratingCommercialisation/(:any)/(:any)']  	   	= "AcceleratingCommercialisation/DetailByTemplate/$1/$2";
$route['AcceleratingCommercialisation/OpenPageBuilder'] 		= "AcceleratingCommercialisation/OpenPageBuilder";
$route['AcceleratingCommercialisation/OpenPageBuilder/(:any)'] = "AcceleratingCommercialisation/OpenPageBuilder/$1";

//For Grant Consultants
$route['admin/manage_grantconsultant']    	   = "GrantConsultant/Manage";
$route['admin/manage_grantconsultant/(:any)']  = "GrantConsultant/Manage/$1";
$route['admin/GrantConsultant/view/(:any)']    = "GrantConsultant/View/$1";
$route['admin/GrantConsultant/detail/(:any)']  = "GrantConsultant/Detail/$1";
$route['GrantConsultant/Listing']    	= "GrantConsultant/Manage";
$route['GrantConsultant/New']    	  	= "GrantConsultant/NewListing";
$route['GrantConsultant/Add']    	   	= "GrantConsultant/Add";
$route['GrantConsultant/AddSave']      	= "GrantConsultant/AddSave";
$route['GrantConsultant/Edit/(:any)']  	= "GrantConsultant/Edit/$1";
$route['GrantConsultant/EditSave']      = "GrantConsultant/EditSave";
$route['grantconsultant_database']  	= "GrantConsultant/Listing";

$route['GrantConsultant/bulk_actions_processings'] = "GrantConsultant/bulk_actions_processings";
$route['GrantConsultant/bulk_actions_processings/(:any)'] = "GrantConsultant/bulk_actions_processings/$1";

$route['grantconsultant_database/searchgrantconsultant']= "GrantConsultant/listingDatabase";

$route['admin/GrantConsultant/emailcheck'] 	= "GrantConsultant/EmailCheck";
$route['admin/GrantConsultant/savedesc']   	= "GrantConsultant/SavePageBuilderContent";
$route['GrantConsultant/QuestionAnwsers/Save'] = "GrantConsultant/SaveQuestionAnswers";
$route['admin/GrantConsultant/getPreview'] 	= "GrantConsultant/ShowPreview";
$route['Admin/GrantConsultant/prevStatus']        = "GrantConsultant/PrevStatusListing";
$route['Admin/GrantConsultant/resetStatus']        = "GrantConsultant/ResetStatus";
$route['Admin/GrantConsultant/restore']        = "GrantConsultant/RestoreStatus";
$route['Admin/GrantConsultant/deleteStatus']        = "GrantConsultant/DeleteStatus";
$route['grantconsultant']  	= "GrantConsultant/FrontForm";
$route['GrantConsultant']  	= "GrantConsultant/FrontForm";
$route['GrantConsultant/OpenPageBuilder'] 		= "GrantConsultant/OpenPageBuilder";
$route['GrantConsultant/OpenPageBuilder/(:any)'] = "GrantConsultant/OpenPageBuilder/$1";
$route['GrantConsultant/(:any)']  	   			= "GrantConsultant/Details/$1";
$route['GrantConsultant/(:any)/(:any)']  	   	= "GrantConsultant/DetailByTemplate/$1/$2";
$route['GrantConsultant/previewValueUpdate']   = 'GrantConsultant/updatePreviewValue';
$route['GrantConsultant/ApproveVersion']      = "GrantConsultant/ApproveVersion";
$route['GrantConsultant/DisapproveVersion']      = "GrantConsultant/disapproveVersion";
$route['GrantConsultant/disapprovalMsg']      = "GrantConsultant/disapprovalMsg";
$route['GrantConsultant/rollBack']      = "GrantConsultant/rollBack";

//old Rnd Routes but still active for backfall links
$route['admin/manage_rd']              	= "Admin/manage_rd";
$route['admin/manage_rd/(:any)']        = "Admin/manage_rd/$1";

//For Rnd Consultants
$route['admin/manage_rndconsultant']    	 = "RndConsultant/Manage";
$route['admin/manage_rndconsultant/(:any)']  = "RndConsultant/Manage/$1";
$route['admin/RndConsultant/view/(:any)']    = "RndConsultant/View/$1";
$route['admin/RndConsultant/detail/(:any)']  = "RndConsultant/Detail/$1";
$route['RndConsultant/Listing']    	   	= "RndConsultant/Manage";
$route['RndConsultant/New']    	  		= "RndConsultant/NewListing";
$route['RndConsultant/Add']    	   		= "RndConsultant/Add";
$route['RndConsultant/AddSave']      	= "RndConsultant/AddSave";
$route['RndConsultant/Edit/(:any)']  	= "RndConsultant/Edit/$1";
$route['RndConsultant/EditSave']      	= "RndConsultant/EditSave";
$route['admin/RndConsultant/emailcheck'] 		= "RndConsultant/EmailCheck";
$route['admin/RndConsultant/savedesc']   		= "RndConsultant/SavePageBuilderContent";
$route['RndConsultant/QuestionAnwsers/Save'] 	= "RndConsultant/SaveQuestionAnswers";
$route['admin/RndConsultant/getPreview'] 		= "RndConsultant/ShowPreview";
$route['rndconsultant_database']  				= "RndConsultant/Listing";

$route['RndConsultant/bulk_actions_processings'] = "RndConsultant/bulk_actions_processings";
$route['RndConsultant/bulk_actions_processings/(:any)'] = "RndConsultant/bulk_actions_processings/$1";

$route['rndconsultant_database/searchrndconsultant']= "RndConsultant/listingDatabase";

$route['rndconsultant']  						= "RndConsultant/FrontForm";
$route['RndConsultant']  						= "RndConsultant/FrontForm";
$route['admin/RndConsultant/details/(:any)'] 	= "RndConsultant/Detail/$1";
$route['RndConsultant/OpenPageBuilder'] 		= "RndConsultant/OpenPageBuilder";
$route['RndConsultant/OpenPageBuilder/(:any)'] 	= "RndConsultant/OpenPageBuilder/$1";
$route['RndConsultant/(:any)']  	   			= "RndConsultant/Details/$1";
$route['RndConsultant/(:any)/(:any)']  	   		= "RndConsultant/DetailByTemplate/$1/$2";
$route['RndConsultant/previewValueUpdate']   = 'RndConsultant/updatePreviewValue';
$route['RndConsultant/ApproveVersion']      = "RndConsultant/ApproveVersion";
$route['RndConsultant/DisapproveVersion']      = "RndConsultant/disapproveVersion";
$route['RndConsultant/disapprovalMsg']      = "RndConsultant/disapprovalMsg";
$route['RndConsultant/rollBack']      = "RndConsultant/rollBack";

//For Tax Advisors
$route['admin/manage_taxadvisors']    	   = "TaxAdvisors/Manage";
$route['admin/manage_taxadvisors/(:any)']    = "TaxAdvisors/Manage/$1";
$route['admin/TaxAdvisors/view/(:any)']      = "TaxAdvisors/View/$1";
$route['admin/TaxAdvisors/detail/(:any)']   = "TaxAdvisors/Detail/$1";
$route['TaxAdvisors/Listing']    	   	      = "TaxAdvisors/Manage";
$route['TaxAdvisors/New']    	  		      = "TaxAdvisors/NewListing";
$route['TaxAdvisors/Add']    	   		      = "TaxAdvisors/Add";
$route['TaxAdvisors/AddSave']      	      = "TaxAdvisors/AddSave";
$route['TaxAdvisors/Edit/(:any)']  	      = "TaxAdvisors/Edit/$1";
$route['TaxAdvisors/EditSave']      	      = "TaxAdvisors/EditSave";
$route['admin/TaxAdvisors/emailcheck'] 		= "TaxAdvisors/EmailCheck";
$route['admin/TaxAdvisors/savedesc']   		= "TaxAdvisors/SavePageBuilderContent";
$route['TaxAdvisors/QuestionAnwsers/Save'] 	= "TaxAdvisors/SaveQuestionAnswers";
$route['admin/TaxAdvisors/getPreview'] 		= "TaxAdvisors/ShowPreview";
$route['taxadvisors_database']  				= "TaxAdvisors/Listing";

$route['TaxAdvisors/bulk_actions_processings'] = "TaxAdvisors/bulk_actions_processings";
$route['TaxAdvisors/bulk_actions_processings/(:any)'] = "TaxAdvisors/bulk_actions_processings/$1";

$route['taxadvisors_database/searchtaxadvisors']= "TaxAdvisors/listingDatabase";

$route['taxadvisers']  					    	= "TaxAdvisors/FrontForm";
$route['TaxAdvisers']  						= "TaxAdvisors/FrontForm";
$route['admin/TaxAdvisors/details/(:any)'] 	= "TaxAdvisors/Detail/$1";
$route['TaxAdvisors/OpenPageBuilder'] 		= "TaxAdvisors/OpenPageBuilder";
$route['TaxAdvisors/OpenPageBuilder/(:any)'] 	= "TaxAdvisors/OpenPageBuilder/$1";
$route['TaxAdvisors/(:any)']  	   			= "TaxAdvisors/Details/$1";
$route['TaxAdvisors/(:any)/(:any)']  	   		= "TaxAdvisors/DetailByTemplate/$1/$2";
$route['TaxAdvisors/previewValueUpdate']      = 'TaxAdvisors/updatePreviewValue';
$route['TaxAdvisors/ApproveVersion']          = "TaxAdvisors/ApproveVersion";
$route['TaxAdvisors/DisapproveVersion']        = "TaxAdvisors/disapproveVersion";
$route['TaxAdvisors/disapprovalMsg']           = "TaxAdvisors/disapprovalMsg";
$route['TaxAdvisors/rollBack']                 = "TaxAdvisors/rollBack";

//For Rnd Partners
$route['admin/manage_rndpartner']    	  = "RndPartner/Manage";
$route['admin/manage_rndpartner/(:any)']  = "RndPartner/Manage/$1";
$route['admin/RndPartner/view/(:any)']    = "RndPartner/View/$1";
$route['admin/RndPartner/detail/(:any)']  = "RndPartner/Detail/$1";
$route['RndPartner/Listing']    		  = "RndPartner/Manage";
$route['RndPartner/New']  				= "RndPartner/NewListing";
$route['RndPartner/Add']    	   		= "RndPartner/Add";
$route['RndPartner/AddSave']      		= "RndPartner/AddSave";
$route['RndPartner/Edit/(:any)']  		= "RndPartner/Edit/$1";
$route['RndPartner/EditSave']      		= "RndPartner/EditSave";
$route['admin/RndPartner/emailcheck'] 		= "RndPartner/EmailCheck";
$route['admin/RndPartner/savedesc']   		= "RndPartner/SavePageBuilderContent";
$route['RndPartner/QuestionAnwsers/Save'] 	= "RndPartner/SaveQuestionAnswers";
$route['admin/RndPartner/getPreview'] 		= "RndPartner/ShowPreview";
$route['rndpartner_database'] 				= "RndPartner/Listing";

$route['RndPartner/bulk_actions_processings'] = "RndPartner/bulk_actions_processings";
$route['RndPartner/bulk_actions_processings/(:any)'] = "RndPartner/bulk_actions_processings/$1";
$route['rndpartner_database/searchRNDpartner']= "RndPartner/listingDatabase";
//$route['accelerator_database/searchAccelerator']= "Accelerator/listingDatabase";


$route['rndpartner'] = "RndPartner/FrontForm";
$route['RndPartner'] = "RndPartner/FrontForm";
$route['Rndpartner'] = "RndPartner/FrontForm";
$route['RndPartner/OpenPageBuilder'] 		= "RndPartner/OpenPageBuilder";
$route['RndPartner/OpenPageBuilder/(:any)'] = "RndPartner/OpenPageBuilder/$1";
$route['RndPartner/(:any)']   		= "RndPartner/Details/$1";
$route['RndPartner/(:any)/(:any)'] 	= "RndPartner/DetailByTemplate/$1/$2";
$route['RndPartner/previewValueUpdate']   = 'RndPartner/updatePreviewValue';
$route['RndPartner/ApproveVersion']      = "RndPartner/ApproveVersion";
$route['RndPartner/DisapproveVersion']      = "RndPartner/disapproveVersion";
$route['RndPartner/disapprovalMsg']      = "RndPartner/disapprovalMsg";
$route['RndPartner/rollBack']      = "RndPartner/rollBack";

//For Universities
//old
$route['admin/manage_universities']    		= "Admin/manage_universities";
$route['admin/manage_universities/(:any)']  = "Admin/manage_universities/$1";
//new
$route['admin/manage_university']    	  = "University/Manage";
$route['admin/manage_university/(:any)']  = "University/Manage/$1";
$route['admin/University/view/(:any)']    = "University/View/$1";
$route['admin/University/detail/(:any)']  = "University/Detail/$1";
$route['University/Listing']    	= "University/Manage";
$route['University/New']    	  	= "University/NewListing";
$route['University/Add']    	   	= "University/Add";
$route['University/AddSave']      	= "University/AddSave";
$route['University/Edit/(:any)']  	= "University/Edit/$1";
$route['University/EditSave']      	= "University/EditSave";
$route['university_database']    	= "University/Listing";
$route['admin/University/emailcheck'] 	= "University/EmailCheck";
$route['admin/University/savedesc']   	= "University/SavePageBuilderContent";
$route['University/QuestionAnwsers/Save'] = "University/SaveQuestionAnswers";
$route['admin/University/getPreview'] 	= "University/ShowPreview";
$route['university']  	= "University/FrontForm";
$route['University']  	= "University/FrontForm";
$route['University/OpenPageBuilder'] 		= "University/OpenPageBuilder";
$route['University/OpenPageBuilder/(:any)'] = "University/OpenPageBuilder/$1";
$route['University/(:any)']  	   			= "University/Details/$1";
$route['University/(:any)/(:any)']  	   	= "University/DetailByTemplate/$1/$2";

$route['university_database/searchDatabaseListing']= "University/listingDatabase";

//For manage_sectors
$route['admin/manage_sectors']         	= "Admin/manage_sectors";
$route['admin/manage_sectors/(:any)']   = "Admin/manage_sectors/$1";
$route['admin/showExpDate']  	= "Admin/showExpDate";
$route['contact']  	= "contact/contact_us";
$route['contact.html']  	= "contact/contact_us";
$route['contact/submit']  	= "contact/submit";
$route['contact/submit/(:any)']  	= "contact/submit/$1";
$route['admin/contact/manage_contact']  	= "contact/index";
$route['admin/contact/manage_contact/listing']  	= "contact/manage_contact/listing";
$route['admin/contact/manage_contact/delete']  	= "contact/manage_contact/delete";
$route['admin/contact/view_contact']  	= "contact/view_contact";    // view single email
$route['admin/contact/view_contact/(:any)']  	= "contact/view_contact/$1";
$route['admin/contact/single_email_content']  	= "contact/single_email_content";
$route['admin/contact/single_email_content/(:any)']  	= "contact/single_email_content/$1";  // view NEXT ETC single email
//admin panel
$route['admin/blog']  	= "Blog";
$route['admin/blog/show']=  "Blog/show";
$route['admin/blog/show/listing']=  "Blog/show/listing";
$route['admin/blog/show/delete']  	= "Blog/show/delete";
$route['admin/blog/show/status']  	= "Blog/show/status";
$route['admin/blog/add_blog']  	= "Blog/add_blog";
$route['admin/blog/add_blog/(:any)']  	= "Blog/add_blog/$1";
$route['admin/blog/insert_blog']  	= "Blog/insert_blog";
$route['admin/blog/insert_blog/(:any)']  	= "Blog/insert_blog/$1";
//Comment section
$route['admin/blog/comments']=  "Blog/comments";
$route['admin/blog/comments/listing']=  "Blog/comments/listing";
$route['admin/blog/comments/delete']  	= "Blog/comments/delete";
$route['admin/blog/delete_comments']  	= "Blog/delete_comments";
$route['admin/blog/delete_comments/(:any)']  	= "Blog/delete_comments/$1";
$route['admin/blog/delete_comments_reply']  	= "Blog/delete_comments_reply";
$route['admin/blog/delete_comments_reply/(:any)']  	= "Blog/delete_comments_reply/$1";
$route['admin/blog/change_comment_status']       	= "Blog/change_comment_status";
$route['admin/blog/change_comments_reply_status']  	= "Blog/change_comments_reply_status";
//for front end


$route['all-about-innovation']  	= "blog/lists";
$route['all-about-innovation/previous']  	= "blog/lists";
$route['all-about-innovation/(:any)/(:any)']  	= "blog/lists/$1/$2";
$route['all-about-innovation/(:any)']  	= "blog/details/$1";   //for single blog
$route['blog/insert_comment']  	= "blog/insert_comment";
$route['blog/insert_comment/(:any)']  	= "blog/insert_comment/$1";
$route['blog/insert_comment/(:any)/(:any)']  	= "blog/insert_comment/$1/$2";


//investor front end Routes nvestor/submit
//$route['investor-pre-assessment']  	= "Investor/investor_form";
$route['Investor/submit']  	= "Investor/submit";
$route['Investor/submit/(:any)']  	= "Investor/submit/$1";
$route['Investor/email_check']  	= "Investor/email_check";
$route['Investor/email_check/(:any)']  	= "Investor/email_check/$1";
$route['Investor/password_check']  	= "Investor/password_check";

$route['admin/investor_list']        = "Investor/investor_list";
$route['admin/investor/investor_list/listing']        = "Investor/investor_list/listing";
$route['admin/investor_list/(:any)'] = "Investor/investor_list/$1";
$route['admin/investor/investor_list/delete']        = "Investor/investor_list/delete";
$route['admin/investor/investor_list/status']        = "Investor/investor_list/status";
$route['admin/investor/edit_profile']        = "Investor/edit_profile";                   //view investor edit profile
$route['admin/investor/edit_profile/(:any)']        = "Investor/edit_profile/$1";
$route['admin/investor/edit_investor_profile/(:any)']        = "Investor/edit_investor_profile/$1";  // edit investor profile
$route['admin/investor/view_profile']        = "Investor/view_profile";                   //view investor profile
$route['admin/investor/view_profile/(:any)']        = "Investor/view_profile/$1";

//upload image for investor
$route['admin/investor/edit_certificate_picture'] = "Investor/edit_certificate_picture";
$route['admin/investor/edit_certificate_picture/(:any)'] = "Investor/edit_certificate_picture/$1";
$route['admin/investor/edit_profile_picture'] = "Investor/edit_profile_picture";
$route['admin/investor/edit_profile_picture/(:any)'] = "Investor/edit_profile_picture/$1";

$route['admin/investor/investor_list/(:any)']        = "Investor/investor_list/$1";

// Esic 2 Controller
$route['esic_database2']  	= "Esic2/index";
$route['esic_database']  	= "Esic/Listing";

$route['esic_database/searchDatabaseListing']= "Esic/listingDatabase";



$route['Esic2']  	= "Esic2";
$route['Esic2/index']  			= "Esic2/index";
$route['Esic2/index/(:any)']  	= "Esic2/index/$1";
$route['Esic2/getlist']  		= "Esic2/getlist";
$route['Esic2/getlist/(:any)']  		= "Esic2/getlist/$1";
$route['Esic2/getfilterlist']	= "Esic2/getfilterlist";
$route['Esic2/updatethumbs']	= "Esic2/updatethumbs";
$route['Esic2/info']  		= "Esic2/info";
$route['Esic2/info/(:any)'] = "Esic2/info/$1";
$route['esic_database/company/(:any)'] = "Esicdetails/getdetails/$1";
$route['admin/UpDateSocials']  = "admin/UpDateSocials";
// Esicdetails Controller
$route['Esicdetails']  			 = "Esicdetails";
$route['Esicdetails/getdetails'] = "Esicdetails/getdetails";
$route['Esicdetails/getdetails/(:any)'] = "Esicdetails/getdetails/$1";
// Esicfilter Controller
$route['Esicfilter']  		= "Esicfilter";
$route['Esicfilter/index'] 	= "Esicfilter/index";
$route['Esicfilter/index/(:any)'] = "Esicfilter/index/$1";
// Imagecreate Controller
$route['Imagecreate']  		= "Imagecreate";
$route['Imagecreate/index'] 	= "Imagecreate/index";
$route['Imagecreate/Resize_image'] = "Imagecreate/Resize_image";
$route['Imagecreate/Resize_image/(:any)'] = "Imagecreate/Resize_image/$1"; //1
$route['Imagecreate/Resize_image/(:any)/(:any)'] = "Imagecreate/Resize_image/$1/$2";//2
$route['Imagecreate/Resize_image/(:any)/(:any)/(:any)'] = "Imagecreate/Resize_image/$1/$2/$1";//3
$route['Imagecreate/Resize_image/(:any)/(:any)/(:any)/(:any)'] = "Imagecreate/Resize_image/$1/$2/$3/$4";//4
$route['Imagecreate/Resize_image/(:any)/(:any)/(:any)/(:any)/(:any)'] = "Imagecreate/Resize_image/$1/$2/$3/$5/$6";//5
$route['Imagecreate/Get_file_extension/(:any)'] = "Imagecreate/Get_file_extension/$1";
// Reg Controller
$route['Reg']  = "Reg";
$route['Reg/index'] 	= "Reg/index";
$route['Reg/submit'] 	= "Reg/submit";
$route['Reg/step2'] 	= "Reg/step2";
$route['Reg/addInstitution'] 			= "Reg/addInstitution";
$route['Reg/addRnD'] 					= "Reg/addRnD";
$route['Reg/addIndustryClassification'] = "Reg/addIndustryClassification";
$route['Reg/addEntrepreneurProgramme'] 	= "Reg/addEntrepreneurProgramme";
$route['Reg/addAcceleratorProgramme'] 	= "Reg/addAcceleratorProgramme";
// Reg2 Controller
$route['Reg2']  = "Reg2";
$route['Reg2/index'] 	= "Reg2/index";
//$route['innovators/esic_pre_assessment'] 	= "Reg2/index";
//$route['innovators'] 	= "Reg2/index";
$route['Reg2/submit'] 	= "Reg2/submit";
$route['Reg2/step2'] 	= "Reg2/step2";
$route['Reg2/addInstitution'] 			= "Reg2/addInstitution";
$route['Reg2/addRnD'] 					= "Reg2/addRnD";
$route['Reg2/addIndustryClassification'] = "Reg2/addIndustryClassification";
$route['Reg2/addEntrepreneurProgramme'] 	= "Reg2/addEntrepreneurProgramme";
$route['Reg2/addEntrepreneurProgramme/(:any)'] 	= "Reg2/addEntrepreneurProgramme/$1";
$route['Reg2/addAcceleratorProgramme'] 	= "Reg2/addAcceleratorProgramme";
$route['admin/pages/new'] = "Pages/addPage";

$route['admin/pages/new/add'] = "Pages/confirm";
$route['admin/pages/delete/(:any)'] = "Pages/delete";
$route['admin/pages/edit/(:any)'] = "Pages/editPage";
$route['admin/pages/edited/(:any)'] = "Pages/edited";
$route['admin/pages/jumbo/(:any)'] = "Pages/jumbo";
$route['admin/pages/jumbotron/(:any)'] = "Pages/jumboAdd";
$route['admin/pages/(:any)'] = "Pages";
$route['admin/navigation'] = "Navigation";
$route['admin/navigation/new'] = "Navigation/newNav";
$route['admin/navigation/edit/(:any)'] = "Navigation/editNav";
$route['admin/navigation/updateNavTos'] = "Navigation/updateNavTos";
$route['admin/navigation/getNavTos'] = "Navigation/getNavTos";
//sliders


$route['admin/slider'] = "Slider/index"; //list all the sliders
$route['admin/slider/new'] = "Slider/addSlider"; //list all the sliders
$route['admin/slider/newSlider'] = "Slider/newSlider"; //save new sliders
$route['admin/slider/updateSliderLayout'] = "Slider/updateSliderLayout"; //updates the layout
$route['admin/slider/updateSliderType'] = "Slider/updateSliderType"; //updates the layout
$route['admin/navigation/delete/(:any)'] = "Navigation/deleteNav";
$route['admin/navadd/(:any)'] = "Navigation/navAdd";
$route['admin/navigation/insert'] = "Navigation/insert";
$route['admin/navigation/update/(:any)'] = "Navigation/update";
$route['admin/navigation/(:any)'] = "Navigation";
$route['admin/settings'] = "Admin/settings";
$route['admin/settings/submit'] = "Admin/uploadLogo";
$route['admin/settings/update'] = "Admin/updateSettings";
$route['admin/social'] = "Admin/social";
$route['admin/social/update'] = "Admin/updateSocial";
$route['admin/posts'] = "Posts";
$route['admin/posts/new'] = "Posts/addPost";
$route['admin/posts/new/add'] = "Posts/confirm";
$route['admin/posts/delete/(:any)'] = "Posts/delete";
$route['admin/posts/edit/(:any)'] = "Posts/editPost";
$route['admin/posts/edited/(:any)'] = "Posts/edited";
$route['admin/posts/categories'] = "Categories";
$route['admin/posts/categories/new'] = "Categories/addCategory";
$route['admin/posts/categories/new/add'] = "Categories/confirm";
$route['admin/posts/categories/delete/(:any)'] = "Categories/delete";
$route['admin/posts/categories/edit/(:any)'] = "Categories/editCategory";
$route['admin/posts/categories/edited/(:any)'] = "Categories/edited";
$route['admin/posts/categories/(:any)'] = "Categories";
$route['admin/posts/(:any)'] = "Posts";
$route['category/(:any)'] = "Hoosk_default/category";
$route['article/(:any)'] = "Hoosk_default/article";
//SearchResult
$route['results_investors']  = "Investor/investor_search";
$route['results_innovators'] = "Esic2/getfilterlist";
//Front End Add Listings.
$route['add_lawyer'] = "Listing/add_lawyer";
//$route['add_lawyer/(:any)'] = "Listing/add_lawyer/$1";

//Questions
$route['admin/questions/index'] = "Question/index";
$route['admin/questions/ordering'] = "Question/order";
$route['admin/questions/sort'] = "Question/sort";
$route['admin/questions/getQuestionsList'] = "Question/getQuestionsList";
$route['admin/questions/listing'] = "Question/index/listing";
$route['admin/questions/create'] = "Question/create";
$route['admin/questions/edit/(:any)'] = "Question/edit/$1";
$route['admin/question/update'] = "Question/update";
$route['admin/question/updateRoles'] = "Question/update_question_roles";
$route['admin/question/updateAnswerType'] = "Question/update_answer_types";
$route['admin/question/updateYears'] = "Question/updateYears";
$route['admin/question/store'] = "Question/store";
$route['admin/question/trash'] = "Question/trashQuestion";
$route['admin/questions/layout/(:any)'] = "Question/fetchAnswerTemplate/$1";
$route['admin/questions/SubQuestionLayout/(:any)'] = "Question/fetchSubQuestionLayout/$1";
$route['admin/question/getTextboxTemplate'] = "Question/getTextboxTemplate";
//Radio
$route['admin/questions/update_answer_radio'] = "Question/updateAnswer_radio";
$route['admin/questions/removeRadio'] = "Question/updateAnswer_removeRadio";
//Checkbox
$route['admin/questions/update_answer_checkbox'] = "Question/updateAnswer_checkbox";
$route['admin/questions/removeCheckbox'] = "Question/updateAnswer_removeCheckbox";
//SelectBox
$route['admin/questions/updateSelect'] = "Question/update_selectBox";
//TextBox
$route['admin/question/updateTextBox'] = "Question/update_textBox";
$route['admin/question/trashTextBox'] = "Question/trash_textBox";

//QuestionListings
$route['admin/question/updateUserAnswer'] = "Question/updateUserAnswer";


//SubQuestion Crud
$route['admin/question/updateChild'] = "Question/updateSubQuestion";
$route['admin/question/trashSubQuestion'] = "Question/trashSubQuestion";
$route['admin/question/updatePrePopulatedUserAnswer'] = "Question/updatePrePopulatedUserAnswer";
$route['admin/question/getListingConfiguration'] = "Question/getListingConfiguration";
$route['admin/question/updateListingConfiguration'] = "Question/updateListingConfiguration";
$route['admin/question/updateQuestionType'] = "Question/updateQuestionType";


//estimator
$route['calculator.html']  	= "Estimator/index";
$route['estimator/submit']  	= "Estimator/submit";
$route['estimator/incorporated']  	= "Estimator/incorporated";
$route['estimator/save_answers']  	= "Estimator/save_questions_answers";


//Tweets
$route['Tweet'] 		= "Tweet/stream";
$route['Tweet/(:any)'] 	= "Tweet/getTweetByID/$1";

// google login code
$route['login/googleCallback?(:any)']   = "Login/googleCallback?$1";
$route['login/googleCallback/(:any)']   = "Login/googleCallback/$1";
$route['login/googleCallback']  		= "Login/googleCallback";

// for facebook login Login/twitterLogin
$route['login/fbook/(:any)'] = "Login/fbook/$1";
$route['login/fbook']  	  = "Login/fbook";
//  for twitter login
//$route['login/twitterLogin/(:any)']   	= "Login/twitterLogin/$1";
//$route['login/twitterLogin']  			= "Login/twitterLogin";
//$route['login/twitterCallback']  		= "Login/twitterCallback";
//$route['login/twitterCallback/(:any)']  = "Login/twitterCallback/$1";



//$route['getAccountDetailsFromFB/(:any)'] = "Register/getAccountDetailsFromFB/$1'";
//$route['getAccountDetailsFromFB']  	   = "Register/getAccountDetailsFromFB";

//$route['getAccountDetailsFromGoogle']  = "Register/getAccountDetailsFromGoogle";
//$route['getAccountDetailsFromTwitter'] = "Register/getAccountDetailsFromTwitter";


//Resize Image
$route['admin/updateimage']  = "Admin/resizeImage";
$route['minify'] = "Admin/updateAssets";
$route['minify/(:any)'] = "Admin/updateAssets/$1";


//$route['Esic']  					= "Esic/FrontForm";
$route['innovators'] 	= "Esic/FrontForm";  // not in use
$route['innovators.html'] 	= "Esic/FrontForm";
// old pages links sss

$route['esic-database.html'] 	= "Esic/listingDatabase";
$route['esic-database1.html'] 	= "Esic/listingDatabase";
$route['esic-databaseold.html'] 	= "Esic/listingDatabase";
$route['innovators-237983.html'] 	= "Esic/FrontForm";
$route['investors.html'] 	= "Investor/FrontForm";






// Default
$route['(.+)'] = "hoosk_default";
//$route['default_controller'] = "admin";
$route['default_controller'] = "hoosk_default";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
