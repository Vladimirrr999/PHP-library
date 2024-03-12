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
if(isset($_POST['update'])){
    $bookid=intval($_GET['bookid']);
    $bookimg=$_FILES["bookpic"]["name"];
    $cimage=$_POST['curremtimage'];
    $cpath="bookimg"."/".$cimage;
    $extension = substr($bookimg,strlen($bookimg)-4,strlen($bookimg));
    $allowed_extensions = array(".jpg","jpeg",".png",".gif");
    $imgnewname=md5($bookimg.time()).$extension;
    if(!in_array($extension,$allowed_extensions)){
        echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
    }
    else{
        move_uploaded_file($_FILES["bookpic"]["tmp_name"],"bookimg/".$imgnewname);
        $sql="UPDATE  books SET image=:imgnewname WHERE id=:bookid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':imgnewname',$imgnewname,PDO::PARAM_STR);
        $query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
        $query->execute();
        unlink($cpath);
        echo "<script>alert('Book image updated successfully');</script>";
        echo "<script>window.location.href='dashboard.php?page=manageBook'</script>";
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
    <title>OLMS | Edit Book</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Add Book</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Book Info
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" enctype="multipart/form-data">
                            <?php 
                            $bookid=intval($_GET['bookid']);
                            $sql = "SELECT books.name,books.id as bookid,books.image from books where books.id=:bookid";
                            $query = $dbh -> prepare($sql);
                            $query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
                            $query->execute();
                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                            $cnt=1;
                            if($query->rowCount() > 0) {
                                foreach($results as $result) { ?>  
                                <input type="hidden" name="curremtimage" value="<?php echo htmlentities($result->image);?>">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <img src="bookimg/<?php echo htmlentities($result->image);?>" width="150">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Book Name</label>
                                        <input class="form-control" type="text" name="bookname" value="<?php echo htmlentities($result->name);?>" readonly />
                                    </div>
                                </div>
                                <div class="col-md-6">  
                                    <div class="form-group">
                                        <label>Book Picture<span style="color:red;">*</span></label>
                                        <input class="form-control" type="file" name="bookpic" autocomplete="off" required="required" />
                                    </div>
                                </div>
                                <?php }} ?>
                                <div class="col-md-12">
                                    <button type="submit" name="update" class="btn btn-info">Update</button>
                                </div>
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
