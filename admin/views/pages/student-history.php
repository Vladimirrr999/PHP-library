<?php
$page = $_SERVER['REQUEST_URI'];
$sql = "INSERT INTO page_views (page) VALUES (:page)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':page', $page);
$stmt->execute();
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 
if(isset($_GET['inid']))
{
$id=$_GET['inid'];
$status=0;
$sql = "UPDATE students SET status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:dashboard.php?page=regStudents');
}
if(isset($_GET['id']))
{
$id=$_GET['id'];
$status=1;
$sql = "UPDATE students SET status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:dashboard.php?page=regStudents');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>OLMS | Student History</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <?php $sid=$_GET['stdid']; ?>
                    <h4 class="header-line">#<?php echo $sid;?> Book Issued History</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $sid;?> Details
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Issued Book</th>
                                            <th>Issued Date</th>
                                            <th>Returned Date</th>
                                            <th>Fine (if any)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sql = "SELECT s.student_id_number AS StudentId, s.name AS FullName, s.email, s.mobile, b.name AS BookName, b.isbn, ibd.issue_date AS IssuesDate, ibd.return_date AS ReturnDate, ibd.id AS rid, ibd.fine, ibd.return_status, b.id AS bid, b.image 
                                                FROM issued_book_details ibd 
                                                JOIN students s ON s.id = ibd.student_id 
                                                JOIN books b ON b.id = ibd.book_id 
                                                WHERE s.student_id_number = '$sid' ";
                                        $query = $dbh -> prepare($sql);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt=1;
                                        if($query->rowCount() > 0) {
                                            foreach($results as $result) { ?>
                                                <tr class="odd gradeX">
                                                    <td class="center"><?php echo htmlentities($cnt);?></td>
                                                    <td class="center"><?php echo htmlentities($result->StudentId);?></td>
                                                    <td class="center"><?php echo htmlentities($result->FullName);?></td>
                                                    <td class="center"><?php echo htmlentities($result->BookName);?></td>
                                                    <td class="center"><?php echo htmlentities($result->IssuesDate);?></td>
                                                    <td class="center">
                                                        <?php 
                                                        if($result->ReturnDate=='') {
                                                            echo "Not returned yet";
                                                        } else {
                                                            echo htmlentities($result->ReturnDate); 
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="center">
                                                        <?php 
                                                        if($result->ReturnDate=='') {
                                                            echo "Not payed yet";
                                                        } else {
                                                            echo $result->fine; 
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php 
                                            $cnt=$cnt+1;
                                            }
                                        } ?>                                      
                                    </tbody>
                                </table>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </div>
    <script src="../assets/js/jquery-1.10.2.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
</body>
</html>
<?php } ?>
