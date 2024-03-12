<?php
$page = $_SERVER['REQUEST_URI'];
$sql = "INSERT INTO page_views (page) VALUES (:page)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':page', $page);
$stmt->execute();
    if(strlen($_SESSION['alogin'])==0) {   
        header('location:index.php');
    } else { 
        if(isset($_GET['del'])) {
            $id=$_GET['del'];
            $sql = "delete from category  WHERE id=:id";
            $query = $dbh->prepare($sql);
            $query -> bindParam(':id',$id, PDO::PARAM_STR);
            $query -> execute();
            header('location: dashboard.php?page=manageCategory');
            $_SESSION['delmsg']="Category deleted successfully ";
        }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>OLMS | Manage Categories</title>
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
                    <h4 class="header-line">Manage Categories</h4>
                </div>
                <div class="row">
                <?php if(isset($_SESSION['error']) && $_SESSION['error']!="") {?>
                    <div class="col-md-6">
                        <div class="alert alert-danger" >
                            <?php echo htmlentities($_SESSION['error']);?>
                            <?php echo htmlentities($_SESSION['error']="");?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(isset($_SESSION['msg']) && $_SESSION['msg']!="") {?>
                    <div class="col-md-6">
                        <div class="alert alert-success" id="sm" >
                            <?php echo htmlentities($_SESSION['msg']);?>
                            <?php echo htmlentities($_SESSION['msg']="");?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(isset($_SESSION['updatemsg']) && $_SESSION['updatemsg']!="") {?>
                    <div class="col-md-6">
                        <div class="alert alert-success" id="sm" >
                            <?php echo htmlentities($_SESSION['updatemsg']);?>
                            <?php echo htmlentities($_SESSION['updatemsg']="");?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(isset($_SESSION['delmsg']) && $_SESSION['delmsg']!="") {?>
                    <div class="col-md-6">
                        <div class="alert alert-success" >
                            <?php echo htmlentities($_SESSION['delmsg']);?>
                            <?php echo htmlentities($_SESSION['delmsg']="");?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Categories
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Creation Date</th>
                                            <th>Updation Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * from  category";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                                ?>                                      
                                                <tr class="odd gradeX">
                                                    <td class="center"><?php echo htmlentities($cnt);?></td>
                                                    <td class="center"><?php echo htmlentities($result->name);?></td>
                                                    <td class="center">
                                                        <?php if ($result->status == 1) { ?>
                                                            <a href="#" class="btn btn-success btn-xs">Active</a>
                                                        <?php } else { ?>
                                                            <a href="#" class="btn btn-danger btn-xs">Inactive</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="center"><?php echo htmlentities($result->created_at);?></td>
                                                    <td class="center"><?php echo htmlentities($result->updated_at);?></td>
                                                    <td class="center">
                                                        <a href="dashboard.php?page=editCategory&catid=<?php echo htmlentities($result->id);?>">
                                                            <button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button>
                                                        </a>
                                                        <a href="dashboard.php?page=manageCategory&del=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to delete?');">
                                                            <button class="btn btn-danger"><i class="fa fa-pencil"></i> Delete</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php $cnt = $cnt + 1;
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
<script src="../assets/js/jquery-1.10.2.js"></script>
<script src="../assets/js/bootstrap.js"></script>
<script>
        setTimeout(function() {
            document.getElementById("sm").style.display = "none";
        }, 3000);
    </script>
</body>
</html>
<?php
}
?>