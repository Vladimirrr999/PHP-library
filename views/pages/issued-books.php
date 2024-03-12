<?php
$page = $_SERVER['REQUEST_URI'];
$sql = "INSERT INTO page_views (page) VALUES (:page)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':page', $page);
$stmt->execute();
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{ 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>OLMS |  Issued Books</title>
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    </head>
    <body>
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Your Issued Books</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Issued Books 
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Book Name</th>
                                            <th>ISBN </th>
                                            <th>Issued Date</th>
                                            <th>Return Date</th>
                                            <th>Fine in(USD)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sid=$_SESSION['stdid'];
                                            $sql = "SELECT books.name AS BookName, books.isbn AS ISBNNumber, issued_book_details.issue_date 
                                                    AS IssuesDate, issued_book_details.return_date AS ReturnDate, issued_book_details.id 
                                                    AS rid, issued_book_details.fine 
                                                    FROM issued_book_details 
                                                    JOIN students ON students.student_id_number = issued_book_details.student_id 
                                                    JOIN books ON books.id = issued_book_details.book_id 
                                                    WHERE students.student_id_number = :sid 
                                                    ORDER BY issued_book_details.id DESC";
                                            $query = $dbh -> prepare($sql);
                                            $query-> bindParam(':sid', $sid, PDO::PARAM_STR);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt=1;
                                            if($query->rowCount() > 0) {
                                                foreach($results as $result) {              
                                        ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookName);?></td>
                                            <td class="center"><?php echo htmlentities($result->ISBNNumber);?></td>
                                            <td class="center"><?php echo htmlentities($result->IssuesDate);?></td>
                                            <td class="center">
                                                <?php if($result->ReturnDate=="") {?>
                                                    <span style="color:red">
                                                        <?php   echo htmlentities("Not Return Yet"); ?>
                                                    </span>
                                                <?php } else {
                                                    echo htmlentities($result->ReturnDate);
                                                } ?>
                                            </td>
                                            <td class="center"><?php echo htmlentities($result->fine);?></td>
                                        </tr>
                                        <?php 
                                                $cnt=$cnt+1;
                                            }
                                        } 
                                        ?>                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
        </div>
        <script src="assets/js/jquery-1.10.2.js"></script>
        <script src="assets/js/bootstrap.js"></script>
    </body>
</html>
<?php 
    } 
?>