<?php
session_start();
include('views/fixed/connection.php');
include('models/validateLoginStudents.php');
include('models/unos.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>OLMS | Home Page </title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />    
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<?php include('views/fixed/header.php');?>
<?php 
    if(isset($_GET['page'])){
        switch($_GET['page']){
            case 'admin':
                include 'views/pages/adminLogin.php';
                break;
            case 'register':
                include 'views/pages/signup.php';
                break;
            case 'pocetna':
                include 'views/pages/pocetna.php';
                break;
            case 'dashboard':
                include 'views/pages/dashboard.php';
                break;
            case 'issued':
                include 'views/pages/issued-books.php';
                break;
            case 'listed':
                include 'views/pages/listed-books.php';
                break;
            case 'contact':
                include 'views/pages/contact-admin.php';
                break;
            case 'profile':
                include 'views/pages/my-profile.php';
                break;
            case 'password-change':
                include 'views/pages/change-password.php';
                break;
            case 'survey':
                include 'views/pages/survey-review.php';
                break;
            case 'update':
                include 'views/pages/update-profile.php';
                break;
            case 'author':
                include 'views/pages/author.php';
                break;
            default:
                include 'index.php';
        }
    }
    else{
        include 'views/pages/pocetna.php';
    }
?>
    <?php include('views/fixed/footer.php');?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>