    <?php
$class  = $this->router->fetch_class();   // it is use only in add new page and edit page condition is use to safe
$method = $this->router->fetch_method();   // it is use only in add new page and edit page condition is use to safe
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITE_NAME; ?>  <?= isset($title) ? " | " . $title : ""; ?></title>
    <!-- Tell the browser to be responsive to screen width -->

    <!-- To prevent backend pages form Google web crawlers from indexing   -->
    <!-- To prevent backend pages form Google web crawlers from indexing   -->
    <!--<meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">-->
    <!-- End -->

    <meta name="google-site-verification" content="zGSppNJw32j9csHV6Gud68Zu2XFMTmC4iJAmWp4jnAE" />
    <meta name="google-site-verification" content="_vy9LJ9ApadtjgIHkHAi3jC5N3bLE3xY3wEcNy4T0vU" />
    <meta name="msvalidate.01" content="A4D0420422D7D432385D8B3F3B04D7DD" />
    <meta name="google-site-verification" content="4miCnvPw5bak9jdkCsQXhsU4rLeMrKWKUdSZ7nsXCCc" />
    <meta name="google-site-verification" content="r7NkuHK_4mdpYFPGhp4psqU3ywNxHOVb7xYSKfyYCCg" />
    <meta name="google-site-verification" content="4miCnvPw5bak9jdkCsQXhsU4rLeMrKWKUdSZ7nsXCCc" />


    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" type="image/png"  href="https://esic.directory/images/EsicLogoIcon.png">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/datatables/responsive.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/_all-skins.min.css">
    <link rel="stylesheet" href="<?= ADMIN_THEME ?>/css/esic-admin.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="<?= base_url();?>assets/vendors/select2/css/select2.css" />
    <link rel="stylesheet" href="<?= base_url();?>assets/css/listing.css" />

    <script src="<?= base_url();?>theme/admin/js/jquery-1.12.4.js"></script>
    <script src="<?= ADMIN_THEME; ?>/js/jquery-ui-1.9.2.js"></script>
    <script src="<?= ADMIN_THEME; ?>/js/jquery.nestable.js"></script>
    <script type="text/javascript">
    //window.addEventListener('DOMContentLoaded', function() {
        var base_url = '<?=base_url()?>';
        <?php
            if (isset($this->ControllerRouteManage) and !empty($this->ControllerRouteManage)) {
                echo 'var ControllerRouteManage = "' . $this->ControllerRouteManage . '";';
                echo 'var ControllerClassName = "' . $class . '";';
            }
        ?>
    //});
    </script>
    <script src="<?php echo ADMIN_THEME; ?>/js/excanvas.min.js"></script>
    <script src="<?php echo ADMIN_THEME; ?>/js/base.js"></script>
    <link type="text/css" href="<?= base_url()?>assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet"/>
    <script type="text/javascript" src="<?= base_url()?>assets/vendors/select2/dist/js/select2.full.js"></script>
    <script src='<?= base_url();?>assets/vendors/select2/js/select2.js'></script>
    <?php
    $path = strtolower($class.'/'.$method);
    if($path != 'contact/index' && $path != 'users/sent' && $path != 'pages/new') { ?>
    <script src='<?= base_url();?>assets/js/listing.js'></script>
    <?php }
    if ($class == 'Pages' || (strtolower($class) . '/' . strtolower($method) === 'admin/details')) {
        ?>
              <script src='<?= base_url();?>\theme\admin\js\sirTrevor\mce\tinymce.min.js'></script>
        <script  src='<?= base_url();?>\assets\tinymce\js\tinymce\plugins\jbimages\plugin.min.js'></script>
<!--        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script> change with above due for ading accordion-->
        <script>
            tinymce.init({
                selector: "body div.st-text-block",
                theme: "modern",
                menubar: false,
                plugins: "spellchecker textcolor colorpicker table jbimages media code bootstrapaccordion",
                add_unload_trigger: false,
                schema: "html5",
                inline: true,
                toolbar: "undo redo | styleselect | fontsizeselect | forecolor | backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | table | jbimages  | media | code | bootstrapaccordion",
                fontsize_formats: "8px 10px 12px 14px 18px 20px 24px 24px 28px 30px 36px 40px",
                statusbar: false
            });
        </script>
    <?php } ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div id="wrapper" class="wrapper">
    <header class="main-header">
        <a href="<?= base_url('admin') ?>" class="logo">
            <span class="logo-mini"><b>E</b>sic</span>
            <span class="logo-lg"><b>ESIC</b> <?php // echo $this->session->userdata('userName'); ?></span>
        </a>
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php
                            $userRole = $this->session->userdata('userRole');
                            $userID = $this->session->userdata('userID');
                            //Get User Image
                            $imagePath = get_user_image($userRole, $userID); ?>
                            <img src="<?= $imagePath ?>" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?= $this->session->userdata('userName'); ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="<?= $imagePath ?>" id="Profile_image" class="img-circle" alt="User Image">
                                <p>
                                    <?= $this->session->userdata('userName'); ?>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?= base_url() ?>admin/users/edit/<?= $userID ?>" class="btn btn-default btn-flat">
                                        Profile
                                    </a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?= BASE_URL; ?>/logout" class="btn btn-default btn-flat">Sign
                                        out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <script>
        window.addEventListener('DOMContentLoaded', function() { //Function to load the PostCodes from Live Server.
            $(function () {
                $("#save_Profile_image").on('submit', (function (e) { //upload profile Image
                    var current = $(this);
                    e.preventDefault();
                    $.ajax({
                        url: baseUrl + "admin/users/edit_profile_picture",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            $("#Profile_image").attr("src", "<?= base_url()?>uploads/investor/" + data);
                            $('#mydiv2').addClass('.alert alert-success');
                            $('#mydiv2').html('Your Information  updated Successfully!').show().delay(5000).fadeOut(3000);
                            $(current).closest('.edit-question').removeClass('in');
                        }
                    });
                }));
            });
        });
    </script>
    <!-- Left side column. contains the logo and sidebar -->
    <?php $this->load->view('admin/components/main-sidebar/main');
        // load approve modal
        $this->load->view('structure/version_approve');
    ?>
    <!-- Navigation -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div id="page-wrapper">
