<?php
session_start();
include('../views/fixed/connection.php');
if(strlen($_SESSION['alogin'])==0)
  { 
header('location:index.php');
}
else{?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>OLMS | Admin DashBoard</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
  <?php include('views/fixed/header.php');?>
    <div class="container">
      <?php 
        if(isset($_GET['page'])){
          switch($_GET['page']){
            case 'addCategory':
              include 'views/pages/add-category.php';
              break;
            case 'manageCategory':
              include 'views/pages/manage-categories.php';
              break;
            case 'editCategory':
              include 'views/pages/edit-category.php';
              break;
            case 'addAuthor':
              include 'views/pages/add-author.php';
              break;
            case 'manageAuthor':
              include 'views/pages/manage-authors.php';
              break;
            case 'addBook':
              include 'views/pages/add-book.php';
              break;
            case 'manageBook';
              include 'views/pages/manage-books.php';
              break;
            case 'editBook':
              include 'views/pages/edit-book.php';
              break;
            case 'issueBook':
              include 'views/pages/issue-book.php';
              break;
            case 'manageIssued':
              include 'views/pages/manage-issued-books.php';
              break;
            case 'updateIssued':
              include 'views/pages/update-issue-bookdeails.php';
              break;
            case 'regStudents':
              include 'views/pages/reg-students.php';
              break;
            case 'details':
              include 'views/pages/student-history.php';
              break;
            case 'changePass':
              include 'views/pages/change-password.php';
              break;
            case 'survey':
              include 'views/pages/survey-listed-answers.php';
              break;
            case 'questions':
              include 'views/pages/contact-review.php';
              break;
            case 'changeBook':
              include 'views/pages/change-bookimg.php';
              break;
            case 'textFile':
              include 'views/pages/text-file-users.php';
              break;
            case 'izmena':
              include 'models/izmena.php';
              break;
            case 'access':
              include 'views/pages/page-access.php';
              break;
            default:
              include 'dashboard.php';
          }
        }
        else{
          include 'views/pages/pocetnaAdmin.php';
        }
      ?>
  <?php include('../views/fixed/footer.php');?>
    <script src="../assets/js/jquery-1.10.2.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
</body>
</html>
<?php } ?>
