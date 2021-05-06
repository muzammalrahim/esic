<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="google-site-verification" content="zGSppNJw32j9csHV6Gud68Zu2XFMTmC4iJAmWp4jnAE" />
    <meta name="google-site-verification" content="_vy9LJ9ApadtjgIHkHAi3jC5N3bLE3xY3wEcNy4T0vU" />
    <meta name="msvalidate.01" content="A4D0420422D7D432385D8B3F3B04D7DD" />
    <meta name="google-site-verification" content="4miCnvPw5bak9jdkCsQXhsU4rLeMrKWKUdSZ7nsXCCc" />
    <meta name="google-site-verification" content="r7NkuHK_4mdpYFPGhp4psqU3ywNxHOVb7xYSKfyYCCg" />
    <meta name="google-site-verification" content="4miCnvPw5bak9jdkCsQXhsU4rLeMrKWKUdSZ7nsXCCc" />
    <link rel="icon" type="image/png"  href="https://esic.directory/images/EsicLogoIcon.png">

    <title><?= !empty($this->data['blog_data']->title) ? $this->data['blog_data']->title : $page['pageTitle']; ?></title>
    <meta name="description"    content="<?= $page['pageDescription']; ?> " />
    <meta name="keywords"       content="<?= $page['pageKeywords']; ?>" />
    <meta name="viewport"       content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="<?= base_url(); ?>assets/css/structureHeader.css" rel="stylesheet">
    <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/steps/jquery.steps.css'); ?>">
    <style type="text/css">
    	.modal-dialog {
			left: 0!important;
		}
        .g-recaptcha {
            width: 305px;
        }
        .esic-logo{
            text-align: center;
        }
        @media(max-width: 768px){
            .c_collapsing{
                position: relative;
                height: 0;
                overflow: hidden;
                -webkit-transition-timing-function: ease;
                -o-transition-timing-function: ease;
                transition-timing-function: ease;
                -webkit-transition-duration: .35s;
                -o-transition-duration: .35s;
                transition-duration: .35s;
                -webkit-transition-property: height,visibility;
                -o-transition-property: height,visibility;
                transition-property: height,visibility;
            }
        }
    </style>
    <script type="text/javascript">
        var base_url = '<?=base_url();?>';
        var baseUrl  = '<?=base_url();?>';
    </script>


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-85978231-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-85978231-1');
    </script>

<!-- Following Script provided by Matthew Pinter -->
    <!-- Global site tag (gtag.js) - AdWords: 1009854832 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-1009854832"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'AW-1009854832');
        gtag('config', 'UA-57271188-1');
    </script>

    <?php
    //For Advance Search
    if(in_array(strtolower($this->router->fetch_class()),['search','services'])){
        ?>
        <link href="<?=base_url()?>assets/css/search.css" rel="stylesheet">
        <link href="<?=base_url()?>assets/css/searchResultBox.css" rel="stylesheet">
    <?php
    }//End of If Statement.
    ?>
</head>
<body ng-app="Esic-App" class="<?= $bodyClasses;?>">
<nav class="navbar navbar-fixed-top navbar-inverse navbar-inverse2">
    <div id="wrapper">
        <div class="overlay"></div>
        <!-- Sidebar -->
        <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
            <div class="leftsidebar"><?php hooskNav('sidebar') ?>
                <ul class="nav navbar-nav left-login-b">
                    <?php  if(!$UserLoggedIn){ ?>
                            <li>
                                <a href="<?= BASE_URL ?>/register"  data-toggle="tooltip" title="Sign Up">
                                    Sign Up
                                </a>
                            </li>
                            <li>
                                <a href="<?= BASE_URL ?>/admin" data-toggle="tooltip" title="Login">
                                    login
                                </a>
                            </li>
                    <?php }else{ ?>
                            <li>
                                <a href="<?= BASE_URL ?>/logout" data-toggle="tooltip" title="Logout" >
                                    Logout
                                </a>
                            </li>
                    <?php } ?>
                </ul>
            </div>
        </nav> <!--  sidebar End  -->
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                <span class="hamb-top"></span>
                <span class="hamb-middle"></span>
                <span class="hamb-bottom"></span>
            </button>
        </div>
        <button type="button" class="navbar-toggle right-button" data-toggle="collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <!-- /#page-content-wrapper -->
        <div class="esic-logo">
            <a class="" href="<?php echo BASE_URL; ?>">
                <img class="img-responsive_logo " src="<?php echo BASE_URL; ?>/images/<?php echo $settings['siteLogo']; ?>" alt="Hoosk" />
            </a>
        </div>
    <!-- /#wrapper -->
        <div class=" navbar-collapse right_sidebar c_collapsing">
            <div class="searchbar">
                <form id="demo-2" action="<?=base_url()?>search" method="POST">
                    <input type="search" name="searchKey" id="header_search" placeholder="Find an ESIC">
                </form>
            </div>
            <?php hooskNav('header') ?>
            <ul class="nav navbar-nav login_button user-action-buttons">
                <?php
                if(!$UserLoggedIn){
                    ?>
                    <li>
                        <a href="<?= BASE_URL ?>/register" data-toggle="tooltip" title="Sign Up" >
                            <i class="fa fa-user-plus" aria-hidden="true" ></i> Sign Up
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/login"  data-toggle="tooltip" title="login">
                            <i class="fa fa-sign-in" aria-hidden="true"></i> login
                        </a>
                    </li>
                <?php }else{ ?>
                    <li>
                        <a href="<?= BASE_URL ?>/admin" data-toggle="tooltip" title="Dashboard">
                            <i class="fa fa-dashboard" aria-hidden="true" ></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/logout" data-toggle="tooltip" title="Logout">
                            <i class="fa fa-sign-out" aria-hidden="true" ></i> Logout
                        </a>
                    </li>
                <?php } ?>
                <?php
                if(isset($page) && !empty($page) && isCurrentUserAdmin($this)==true){
                    $editLink = base_url().'admin/pages/edit/'.$page["pageID"];
                    ?>
                    <li data-toggle="tooltip" title="Edit Page">
                        <a href="<?= $editLink;?>" target="_blank"><i class="fa fa-pencil"></i> Edit</a>
                    </li>
                <?php } ?>
                <?php
                if(isset($detail->ListID) && !empty($detail->ListID) && isCurrentUserAdmin($this)==true){
                    //  $listingEditLink = base_url().'admin/'.$this->Name.'/view/'.$detail->ListID;
                    $listingEditLink = base_url().$this->Name.'/Edit/'.$detail->ListID;
                    ?>
                    <li>
                        <a href="<?= $listingEditLink;?>" target="_blank"><i class="fa fa-pencil"></i> Edit</a>
                    </li>
                <?php } ?>
            </ul>

        </div>
        <!-- /.container -->
    </div>
</nav><!-- /.navbar -->