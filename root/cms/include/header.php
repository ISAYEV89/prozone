<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo $site_url; ?>template/production/images/favicon.ico" type="image/ico" />
    <title>LNS international | administration panel</title>    <!-- Bootstrap -->
    <link href="<?php echo $site_url; ?>template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">    <!-- Font Awesome -->
    <link href="<?php echo $site_url; ?>template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">    <!-- NProgress -->
    <link href="<?php echo $site_url; ?>template/vendors/nprogress/nprogress.css" rel="stylesheet">    <!-- Custom Theme Style -->
<?php 
if ($page=='list' || $page=='listcity' || $page=='list_left' || $page=='list_secret' || $page=='list_top' || $page=='list_bottom' || $page=='edit_photo') 
{
?>
    <!-- Datatables -->
    <link href="<?php echo $site_url; ?>template/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $site_url; ?>template/vendors/tab/tab.css" rel="stylesheet">
<?php 
}
?>
<?php 
if ($page=='add' || $page=='edit') 
{
?>
    <!-- Switchery -->
    <link href="<?php echo $site_url; ?>template/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- Tab -->
    <link href="<?php echo $site_url; ?>template/vendors/tab/tab.css" rel="stylesheet">
    <!-- Multi -->
    <link rel="stylesheet" href="<?php echo $site_url; ?>css/select2.css" />
    <link rel="stylesheet" href="<?php echo $site_url; ?>css/select2-bootstrap.min.css" />
    <script src="<?php echo $site_url; ?>js/modernizr.js"></script> 
    <script src="<?php echo $site_url; ?>js/jquery.js"></script>
    <script src="<?php echo $site_url; ?>js/nanoscroller.js"></script>
    <script src="<?php echo $site_url; ?>js/select2.js"></script>       
    <script src="<?php echo $site_url; ?>js/theme.js"></script>
    <script src="<?php echo $site_url; ?>js/theme.init.js"></script> 
<?php 
}
?>
    <link href="<?php echo $site_url; ?>template/build/css/custom.min.css" rel="stylesheet">
  </head>