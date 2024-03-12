<?php include "includes/connection.php";
session_start();
$page = $_SERVER['REQUEST_URI'];
$sql = "INSERT INTO page_views (page) VALUES (:page)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':page', $page);
$stmt->execute();
?> 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>OLMS | Books Not Returned Yet</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <?php include('includes/header.php');?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Books Not Returned Yet</h4>
                </div>
            </div>   
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Book Name</th>
                                    <th>ISBN</th>
                                    <th>Issued Date</th>
                                    <th>Return Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $rsts = 0;
                                    $sid = $_SESSION['stdid'];
                                    $sql = "SELECT books.name, books.isbn, issued_book_details.issue_date, issued_book_details.return_date, issued_book_details.id as rid 
                                            FROM issued_book_details JOIN books ON books.id = issued_book_details.book_id 
                                            WHERE issued_book_details.student_id = :sid 
                                            AND (issued_book_details.return_status = :rsts 
                                            OR issued_book_details.return_status IS NULL OR issued_book_details.return_status = '')";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                                    $query->bindParam(':rsts', $rsts, PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) {              
                                ?>
                                <tr>
                                    <td><?php echo htmlentities($cnt);?></td>
                                    <td><?php echo htmlentities($result->name);?></td>
                                    <td><?php echo htmlentities($result->isbn);?></td>
                                    <td><?php echo htmlentities($result->issue_date);?></td>
                                    <td>
                                        <?php 
                                            if ($result->return_date == "") {
                                                echo htmlentities("Not Return Yet");
                                            } else {
                                                echo htmlentities($result->return_date);
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <?php 
                                    $cnt++;
                                }} 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>

