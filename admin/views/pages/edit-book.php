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
$bookname=$_POST['bookname'];
$category=$_POST['category'];
$author=$_POST['author'];
$isbn=$_POST['isbn'];
$price=$_POST['price'];
$bookid=intval($_GET['bookid']);
$sql="UPDATE  books SET name=:bookname,category_id=:category,author_id=:author,price=:price WHERE id=:bookid";
$query = $dbh->prepare($sql);
$query->bindParam(':bookname',$bookname,PDO::PARAM_STR);
$query->bindParam(':category',$category,PDO::PARAM_STR);
$query->bindParam(':author',$author,PDO::PARAM_STR);
$query->bindParam(':price',$price,PDO::PARAM_STR);
$query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
$query->execute();
echo "<script>alert('Book info updated successfully');</script>";
echo "<script>window.location.href='dashboard.php?page=manageBook'</script>";
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
            <div class="col-md12 col-sm-12 col-xs-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Book Info
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post">
                                <?php 
                                $bookid=intval($_GET['bookid']);
                                $sql = "SELECT books.name AS bookname, category.name AS catname, category.id AS cid, 
                                authors.name AS athrname, authors.id AS athrid, books.isbn,
                                books.price, books.id AS bookid, books.image AS bookImage 
                                FROM books 
                                JOIN category ON category.id = books.category_id 
                                JOIN authors ON authors.id = books.author_id 
                                WHERE books.id = :bookid";
                                $query = $dbh -> prepare($sql);
                                $query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                $cnt=1;
                                if($query->rowCount() > 0) {
                                    foreach($results as $result) { 
                                ?>  
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <img src="bookimg/<?php echo htmlentities($result->bookImage);?>" width="100">
                                        <a href="dashboard.php?page=changeBook&bookid=<?php echo htmlentities($result->bookid);?>" 
                                            class="btn btn-secondary" style="color:#20b3fd;">Change Book Image
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Book Name<span style="color:red;">*</span></label>
                                        <input class="form-control" type="text" name="bookname" 
                                            value="<?php echo htmlentities($result->bookname);?>" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label> Category<span style="color:red;">*</span></label>
                                            <select class="form-control" name="category" required="required">
                                                <option value="<?php echo htmlentities($result->cid); ?>"> 
                                                    <?php echo htmlentities($catname=$result->catname); ?>
                                                </option> <?php 
                                                        $status=1;
                                                        $sql = "SELECT * FROM  category WHERE status=:status";
                                                        $query = $dbh -> prepare($sql);
                                                        $query-> bindParam(':status',$status, PDO::PARAM_STR);
                                                        $query->execute();
                                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                        if($query->rowCount() > 0) {
                                                            foreach($results as $row) {           
                                                                if($catname==$row->name) {
                                                                    continue;
                                                                } else { ?>
                                                                <option value="<?php echo htmlentities($row->id); ?>"> 
                                                                    <?php echo htmlentities($row->name); ?> 
                                                                </option> 
                                                                <?php
                                                            }}} ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Author <span style="color:red;">*</span></label>
                                        <select class="form-control" name="author" required="required">
                                            <option value="<?php echo htmlentities($result->athrid); ?>"><?php echo htmlentities($athrname=$result->athrname); ?></option>
                                            <?php
                                            $sql = "SELECT * from authors";
                                            $query2 = $dbh -> prepare($sql);
                                            $query2->execute();
                                            $result2=$query2->fetchAll(PDO::FETCH_OBJ);
                                            if($query2->rowCount() > 0) {
                                                foreach($result2 as $ret) {
                                                    if($athrname==$ret->name) {
                                                        continue;
                                                    } else {
                                            ?>
                                            <option value="<?php echo htmlentities($ret->id); ?>"><?php echo htmlentities($ret->name); ?></option>
                                            <?php }}} ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ISBN Number <span style="color:red;">*</span>
                                        </label>
                                        <input class="form-control" type="text" name="isbn" value="<?php echo htmlentities($result->isbn);?>" readonly />
                                        <p class="help-block">An ISBN is an International Standard Book Number.ISBN Must be unique</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Price in USD <span style="color:red;">*</span>
                                    </label>
                                    <input class="form-control" type="text" name="price" value="<?php echo htmlentities($result->price);?>" required="required" />
                                </div>
                                </div> <?php }} ?> 
                                    <div class="col-md-12">
                                    <button type="submit" name="update" class="btn btn-info">Update </button>
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
