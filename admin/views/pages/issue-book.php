<?php
$page = $_SERVER['REQUEST_URI'];
$sql = "INSERT INTO page_views (page) VALUES (:page)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':page', $page);
$stmt->execute();
if (strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
} else { 
    if (isset($_POST['issue'])) {
        $studentid = $_POST['studentid'];
        $bookid = $_POST['bookid'];
        $isssued = 1;
        $sql_student = "SELECT id FROM students WHERE student_id_number = :studentid";
        $query_student = $dbh->prepare($sql_student);
        $query_student->bindParam(':studentid', $studentid, PDO::PARAM_STR);
        $query_student->execute();
        $studentRow = $query_student->fetch(PDO::FETCH_ASSOC);
        if ($studentRow) {
            $student_id = $studentRow['id'];
            $sql_update = "UPDATE books SET is_issued = :isissued WHERE id = :bookid";
            $query_update = $dbh->prepare($sql_update);
            $query_update->bindParam(':isissued', $isssued, PDO::PARAM_STR);
            $query_update->bindParam(':bookid', $bookid, PDO::PARAM_STR);
            $query_update->execute();
        
            if ($query_update->rowCount() > 0) {
                $sql_insert = "INSERT INTO issued_book_details(student_id, book_id) VALUES(:studentid, :bookid)";
                $query_insert = $dbh->prepare($sql_insert);
                $query_insert->bindParam(':studentid', $student_id, PDO::PARAM_INT);
                $query_insert->bindParam(':bookid', $bookid, PDO::PARAM_INT);
                $query_insert->execute();
                $lastInsertId = $dbh->lastInsertId();
        
                if ($lastInsertId) {
                    $_SESSION['msg'] = "Book issued successfully";
                    header('location:dashboard.php?page=manageIssued');
                } else {
                    $_SESSION['error'] = "Something went wrong. Please try again";
                    header('location:dashboard.php?page=manageIssued');
                }
            } else {
                $_SESSION['error'] = "Failed to update book status. Please try again";
                header('location:dashboard.php?page=manageIssued');
            }
        } else {
            $_SESSION['error'] = "Invalid student ID. Please try again";
            header('location:dashboard.php?page=manageIssued');
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>OLMS | Issue a new Book</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<style type="text/css">
    .others{
        color:red;
    }
</style>
</head>
<body>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Issue a New Book</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Issue a New Book
                        </div>
                        <div class="panel-body">
                        <form role="form" method="post">
                            <div class="form-group">
                                <label>Student ID <span style="color:red;">*</span></label>
                                <input class="form-control" type="text" name="studentid" id="studentid" onBlur="getstudent()" autocomplete="off" required />
                            </div>
                            <div class="form-group">
                                <span id="get_student_name" style="font-size:16px;"></span> 
                            </div>
                            <div class="form-group">
                                <label>ISBN Number or Book Title <span style="color:red;">*</span></label>
                                <input class="form-control" type="text" name="bookid" id="bookid" onBlur="getbook()" required="required" />
                                </div>
                            <div class="form-group" id="get_book_name">
                            </div>
                            <button type="submit" name="issue" id="submit" class="btn btn-info">Issue Book</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <script src="../assets/js/jquery-1.10.2.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
    <script>
    function getstudent() {
    $("#loaderIcon").show();
    jQuery.ajax({
    url: "get_student.php",
    data:'studentid='+$("#studentid").val(),
    type: "POST",
    success:function(data){
    $("#get_student_name").html(data);
    $("#loaderIcon").hide();
    },
    error:function (){}
    });
    }
    function getbook() {
    $("#loaderIcon").show();
    jQuery.ajax({
    url: "get_book.php",
    data:'bookid='+$("#bookid").val(),
    type: "POST",
    success:function(data){
    $("#get_book_name").html(data);
    $("#loaderIcon").hide();
    },
    error:function (){}
    });
    }
</script> 
</body>
</html>
<?php } ?>
