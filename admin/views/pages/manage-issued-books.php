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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>OLMS| Manage Issued Books</title>
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
                    <h4 class="header-line">Manage Issued Books</h4>
                </div>
            </div>
            <div class="row">
                <?php if(isset($_SESSION['error']) && $_SESSION['error']!="") {?>
                <div class="col-md-6">
                    <div class="alert alert-danger" id="ib">
                        <?php echo htmlentities($_SESSION['error']);?>
                        <?php echo htmlentities($_SESSION['error']="");?>
                    </div>
                </div>
                <?php } ?>
                <?php if(isset($_SESSION['msg']) && $_SESSION['msg']!="") {?>
                <div class="col-md-6">
                    <div class="alert alert-success" id="ib">
                        <?php echo htmlentities($_SESSION['msg']);?>
                        <?php echo htmlentities($_SESSION['msg']="");?>
                    </div>
                </div>
                <?php } ?>
                <?php if(isset($_SESSION['delmsg']) && $_SESSION['delmsg']!="") {?>
                <div class="col-md-6">
                    <div class="alert alert-success" id="ib">
                        <?php echo htmlentities($_SESSION['delmsg']);?>
                        <?php echo htmlentities($_SESSION['delmsg']="");?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php } ?>
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
                                        <th>Student Name</th>
                                        <th>Book Name</th>
                                        <th>ISBN</th>
                                        <th>Issued Date</th>
                                        <th>Return Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <?php 
                                        $sql = "SELECT students.name AS studentName, books.name AS bookName, books.isbn AS ISBNNumber,
                                                        issued_book_details.issue_date AS IssuesDate, issued_book_details.return_date 
                                                    AS ReturnDate, issued_book_details.id AS rid 
                                                    FROM issued_book_details 
                                                    JOIN students ON students.id = issued_book_details.student_id 
                                                    JOIN books ON books.id = issued_book_details.book_id 
                                                    ORDER BY issued_book_details.id DESC";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) { ?>
                                                <tr class="odd gradeX">
                                                    <td class="center"><?php echo htmlentities($cnt); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->studentName); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->bookName); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->ISBNNumber); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->IssuesDate); ?></td>
                                                    <td class="center"><?php if ($result->ReturnDate == "") {
                                                                                echo htmlentities("Not Return Yet");
                                                                            } else {
                                                                                echo htmlentities($result->ReturnDate);
                                                                            } ?></td>
                                                    <td class="center">
                                                        <a href="dashboard.php?page=updateIssued&rid=<?php echo htmlentities($result->rid); ?>">
                                                        <button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button>
                                                    </td>
                                                </tr>
                                        <?php $cnt = $cnt + 1;
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
    <script>
        setTimeout(function() {
            document.getElementById("ib").style.display = "none";
        }, 3000);
    </script>
</body>
</html>

