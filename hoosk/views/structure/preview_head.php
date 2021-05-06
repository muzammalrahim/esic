<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title><?php echo $page['pageTitle']; ?> | <?php echo $settings['siteTitle']; ?> </title>
    <meta name="description"    content="<?= $page['pageDescription']; ?> " />
    <meta name="keywords"       content="<?= $page['pageKeywords']; ?>" />
    <meta name="viewport"       content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="<?= THEME_FOLDER; ?>css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/AdminLTE.min.css">
    <link href="<?= THEME_FOLDER; ?>css/styles.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link href="<?= base_url();?>assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="<?= THEME_FOLDER; ?>css/socicon.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="<?= base_url();?>theme/admin/js/jquery-1.12.4.js"></script>
    <script src="<?= base_url();?>assets/js/jquery-ui.js" type="text/javascript"></script>
    <script src="<?= base_url();?>assets/js/bootstrap-datepicker.js" type="text/javascript" async defer></script>
    <script src="<?= base_url();?>assets/js/daterangepicker.js" type="text/javascript" async defer></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/moment.js"></script>
</head>
<body ng-app="Esic-App" class="<?= $bodyClasses;?>">