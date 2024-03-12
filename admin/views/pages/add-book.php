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

    if(isset($_POST['add']))
    {
        $bookname=$_POST['bookname'];
        $category=$_POST['category'];
        $author=$_POST['author'];
        $isbn=$_POST['isbn'];
        $price=$_POST['price'];
        $bookimg=$_FILES["bookpic"]["name"];
        $extension = substr($bookimg,strlen($bookimg)-4,strlen($bookimg));
        $allowed_extensions = array(".jpg","jpeg",".png",".gif");
        $imgnewname=md5($bookimg.time()).$extension;
        if(!in_array($extension,$allowed_extensions))
        {
            echo '<p class="alert alert-danger">Invalid format. Only jpg / jpeg / png / gif format allowed</p>';
        }
        else
        {
            move_uploaded_file($_FILES["bookpic"]["tmp_name"],"bookimg/".$imgnewname);
            $sql="INSERT INTO  books(name,category_id,author_id,isbn,price,image) VALUES(:bookname,:category,:author,:isbn,:price,:imgnewname)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':bookname',$bookname,PDO::PARAM_STR);
            $query->bindParam(':category',$category,PDO::PARAM_STR);
            $query->bindParam(':author',$author,PDO::PARAM_STR);
            $query->bindParam(':isbn',$isbn,PDO::PARAM_STR);
            $query->bindParam(':price',$price,PDO::PARAM_STR);
            $query->bindParam(':imgnewname',$imgnewname,PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if($lastInsertId)
            {
                echo '<p class="alert alert-success">Book added successfully</p>';
                echo '<script>setTimeout(function(){window.location.href="dashboard.php?page=manageBook";},1500);</script>';
            }
            else 
            {
                echo '<p class="alert alert-danger">Something went wrong. Please try again</p>';
                echo '<script>setTimeout(function(){window.location.href="dashboard.php?page=manageBook";},1500);</script>';
            }
        }
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
    <title>OLMS | Add Book</title>
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
                        <div class="col-md-6">   
                            <div class="form-group">
                                <label>Book Name<span style="color:red;">*</span></label>
                                <input class="form-control" type="text" name="bookname" autocomplete="off"  required />
                            </div>
                        </div>
                        <div class="col-md-6">  
                            <div class="form-group">
                                <label> Category<span style="color:red;">*</span></label>
                                <select class="form-control" name="category" required="required">
                                    <option value=""> Select Category</option>
                                    <?php 
                                    $status=1;
                                    $sql = "SELECT * FROM  category WHERE status=:status";
                                    $query = $dbh -> prepare($sql);
                                    $query -> bindParam(':status',$status, PDO::PARAM_STR);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    if($query->rowCount() > 0) {
                                        foreach($results as $result) { ?>  
                                            <option value="<?php echo htmlentities($result->id); ?>">
                                                <?php echo htmlentities($result->name); ?>
                                            </option>
                                    <?php }} ?> 
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">  
                            <div class="form-group">
                                <label> Author<span style="color:red;">*</span></label>
                                    <select class="form-control" name="author" required="required">
                                        <option value=""> Select Author</option>
                                            <?php 
                                                $sql = "SELECT * from  authors ";
                                                $query = $dbh -> prepare($sql);
                                                $query->execute();
                                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt=1;
                                                if($query->rowCount() > 0) {
                                                    foreach($results as $result) { ?>  
                                                        <option value="<?php echo htmlentities($result->id); ?>">
                                                            <?php echo htmlentities($result->name); ?>
                                                        </option>
                                             <?php }} ?> 
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">  
                                <div class="form-group">
                                    <label>ISBN Number<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="isbn" id="isbn" required="required" autocomplete="off" onBlur="checkisbnAvailability()"  />
                                        <p class="help-block">An ISBN is an International Standard Book Number.ISBN Must be unique</p>
                                            <span id="isbn-availability-status" style="font-size:12px;"></span>
                                </div>
                            </div>
                             <div class="col-md-6">  
                                <div class="form-group">
                                    <label>Price<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="price" autocomplete="off"   required="required" />
                                </div>
                            </div>
                            <div class="col-md-6">  
                                <div class="form-group">
                                    <label>Book Picture<span style="color:red;">*</span></label>
                                    <input class="form-control" type="file" name="bookpic" autocomplete="off"   required="required" />
                                </div>
                            </div>
                            <button type="submit" name="add" id="add" class="btn btn-info">Submit </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/jquery-1.10.2.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
    <script type="text/javascript">
        function checkisbnAvailability() {
        $("#loaderIcon").show();
        jQuery.ajax({
        url: "check_availability.php",
        data:'isbn='+$("#isbn").val(),
        type: "POST",
        success:function(data){
        $("#isbn-availability-status").html(data);
        $("#loaderIcon").hide();
            },
            error:function (){}
            });
        }
    </script>
</body>
</html>


