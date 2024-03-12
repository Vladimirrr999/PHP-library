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
if(isset($_POST['update']))
{
$category=$_POST['category'];
$status=$_POST['status'];
$catid=intval($_GET['catid']);
$sql="UPDATE  category SET name=:category,status=:status WHERE id=:catid";
$query = $dbh->prepare($sql);
$query->bindParam(':category',$category,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':catid',$catid,PDO::PARAM_STR);
$query->execute();
$_SESSION['updatemsg']="Category succefully updated";
header('location: dashboard.php?page=manageCategory');
}
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>OLMS | Edit Categories</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Edit category</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Category Info
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <?php 
                                $catid=intval($_GET['catid']);
                                $sql="SELECT * from category where id=:catid";
                                $query=$dbh->prepare($sql);
                                $query->bindParam(':catid',$catid, PDO::PARAM_STR);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                if($query->rowCount() > 0) {
                                    foreach($results as $result) { ?> 
                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <input class="form-control" type="text" name="category" value="<?php echo htmlentities($result->name);?>" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="status" id="status1" value="1" <?php if($result->status==1) echo 'checked="checked"'; ?>>Active
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="status" id="status0" value="0" <?php if($result->status==0) echo 'checked="checked"'; ?>>Inactive
                                            </label>
                                        </div>
                                    </div>
                                    <?php }} ?>
                            <button type="submit" name="update" class="btn btn-info">Update</button>
                        </form>
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
