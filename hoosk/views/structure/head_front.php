<?php 
if(!isset($ListingName) || empty($ListingName)){
    $ListingName = '';
}
if(!isset($ListingLabel) || empty($ListingLabel)){
    $ListingLabel = '';
}
if(!isset($ControllerRouteName) || empty($ControllerRouteName)){
    $ControllerRouteName = '';
}
if(!isset($ControllerRouteManage) || empty($ControllerRouteManage)){
    $ControllerRouteManage = 'Controller Has Error';
}
if(!isset($PageType) || empty($PageType)){
    $PageType = '';
}

?>
<link rel="stylesheet" href="<?= base_url();?>assets/vendors/select2/css/select2.css"/ >
<link rel="stylesheet" href="<?= base_url();?>assets/css/listing.css"/>
<!-- Main content -->
    <section class="content container form-container">