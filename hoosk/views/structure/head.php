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
<div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>

            <?= $ListingLabel; ?>
            <small><?= $PageType; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><?= $ListingLabel; ?></a></li>
            <li class="active"><?= $PageType; ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

 
        