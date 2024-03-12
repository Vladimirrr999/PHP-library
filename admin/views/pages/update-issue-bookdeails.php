<?php
$page = $_SERVER['REQUEST_URI'];
$sql = "INSERT INTO page_views (page) VALUES (:page)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':page', $page);
$stmt->execute();
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['return'])) {
        $rid = intval($_GET['rid']);
        $fine = $_POST['fine'];
        $rstatus = 1;
        $bookid = $_POST['bookid'];
        $sql = "UPDATE issued_book_details SET fine=:fine,return_status=:rstatus WHERE id=:rid;
                UPDATE books SET is_issued = 0 WHERE id=:bookid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_STR);
        $query->bindParam(':fine', $fine, PDO::PARAM_STR);
        $query->bindParam(':rstatus', $rstatus, PDO::PARAM_STR);
        $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
        $query->execute();

        $_SESSION['msg'] = "Book Returned successfully";
        header('location:manage-issued-books.php');
    } ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>OLMS| Issued Book Details</title>
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
                        <h4 class="header-line">Issued Book Details</h4>          
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Issued Book Details
                            </div>
                            <div class="panel-body">
                            <form role="form" method="post">
                            <?php
                            $rid = intval($_GET['rid']);
                            $sql = "SELECT students.student_id_number AS studentIdNumber, students.name AS studentName, students.email, students.mobile, books.name AS bookName, books.isbn, issued_book_details.issue_date AS issueDate, issued_book_details.return_date AS returnDate, issued_book_details.id AS rid, issued_book_details.fine, issued_book_details.return_status, books.id AS bid, books.image 
                            FROM issued_book_details 
                            JOIN students ON students.id = issued_book_details.student_id 
                            JOIN books ON books.id = issued_book_details.book_id 
                            WHERE issued_book_details.id = :rid";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':rid', $rid, PDO::PARAM_STR);
                            $query->execute();
                            $result = $query->fetch(PDO::FETCH_OBJ);
                            
                            if ($result) { ?>
                                <div class="panel-body">
                                    <input type="hidden" name="bookid" value="<?php echo htmlentities($result->bid); ?>">
                                    <h4 style="font-size: 25px;"><b>Student Details</b></h4>
                                    <hr />
                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            <label>Student ID :</label>
                                            <?php echo htmlentities($result->studentIdNumber); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            <label>Student Name :</label>
                                            <?php echo htmlentities($result->studentName); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            <label>Student Email Id :</label>
                                            <?php echo htmlentities($result->email); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            <label>Student Contact No :</label>
                                            <?php echo htmlentities($result->mobile); ?>
                                        </div>
                                    </div>
                                    
                                    <h4>Book Details</h4>
                                    <hr />
                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            <label>Book Image :</label>
                                            <img src="bookimg/<?php echo htmlentities($result->image); ?>" width="120">
                                        </div>
                                    </div>
                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            <label>Book Name :</label>
                                            <?php echo htmlentities($result->bookName); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            <label>ISBN :</label>
                                            <?php echo htmlentities($result->isbn); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            <label>Book Issued Date :</label>
                                            <?php echo htmlentities($result->issueDate); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            <label>Book Returned Date :</label>
                                            <?php
                                            if ($result->returnDate == "") {
                                                echo htmlentities("Not Return Yet");
                                            } else {
                                                echo htmlentities($result->returnDate);
                                            }
                                            ?>
                                        </div>
                                            </div>

                                            <div class="col-md-12"> 
                                                <div class="form-group">
                                                    <label>Fine (in USD) :</label>
                                                    <?php if ($result->fine == "") { ?>
                                                        <input class="form-control" type="text" name="fine" id="fine" required />
                                                    <?php } else {
                                                        echo htmlentities($result->fine);
                                                    } ?>
                                                </div>
                                            </div>
                                            <?php if ($result->return_status == 0) { ?>
                                                <button type="submit" name="return" id="submit" class="btn btn-info">Return Book</button>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </form>                     
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
<?php
} ?>
