<?php
include "../includes/db.php";
include "functions.php";

ob_start();
session_start();
?>

<?php
//checking user role and validating access to admin panel
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    header("Location: ../index.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!--admin loader-->
    <link rel="stylesheet" href="css/loader.css">

    <!--summernote WYSIWYG CSS-->
    <!--CDN link-->
    <!--<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">-->
    <!--local files link-->
    <link rel="stylesheet" href="../css/summernote.css">

    <!--google chart script-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>
<body>