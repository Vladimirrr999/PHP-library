<?php
$page = $_SERVER['REQUEST_URI'];
$sql = "INSERT INTO page_views (page) VALUES (:page)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':page', $page);
$stmt->execute();
if (strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
} else { 
    if (isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "DELETE FROM books WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['delmsg'] = "Book deleted successfully";
        header('location:dashboard.php?page=manageBook');
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>OLMS | Manage Books</title>
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
                    <h4 class="header-line">Manage Books</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Books Listing
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Book Name</th>
                                            <th>Category</th>
                                            <th>Author</th>
                                            <th>ISBN</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT books.name AS book_name, category.name AS category_name, authors.name AS author_name, books.isbn, books.price, books.id AS bookid, books.image 
                                        FROM books 
                                        JOIN category ON category.id = books.category_id 
                                        JOIN authors ON authors.id = books.author_id";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) { 
                                        ?>
                                                <tr class="odd gradeX" id="book-<?php echo htmlentities($result->bookid); ?>">
                                                    <td class="center"><?php echo htmlentities($cnt); ?></td>
                                                    <td class="center" width="300">
                                                        <img src="bookimg/<?php echo htmlentities($result->image); ?>" width="100">
                                                        <br /><b><?php echo htmlentities($result->book_name); ?></b></td>
                                                    <td class="center"><?php echo htmlentities($result->category_name); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->author_name); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->isbn); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->price); ?></td>
                                                    <td>
                                                        <a href="dashboard.php?page=editBook&bookid=<?php echo htmlentities($result->bookid); ?>">Edit</a>
                                                        <a href="dashboard.php?page=manageBook&del=<?php echo htmlentities($result->bookid); ?>" onclick="return confirm('Da li ste sigurni da želite da obrišete ovu knjigu?');">Delete</a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $cnt++;
                                            }
                                        }
                                        else { 
                                            if(isset($_GET['del'])) {
                                                $id=$_GET['del'];
                                                $sql = "DELETE FROM books WHERE id=:id";
                                                $query = $dbh->prepare($sql);
                                                $query -> bindParam(':id', $id, PDO::PARAM_STR);
                                                $query -> execute();
                                                $_SESSION['delmsg']="Category deleted successfully ";
                                                header('location:manage-books.php');
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
        <script>
            function deleteBook(bookId) {
                if (confirm('Da li ste sigurni da želite da obrišete ovu knjigu?')) {
                    $.ajax({
                        url: 'manage-books.php?del=' + bookId,
                        method: 'GET',
                        success: function() {
                            var rowId = 'book-' + bookId;
                            $('#' + rowId).remove();
                        }
                    });
                }
            }
        </script>
        <script src="../assets/js/jquery-1.10.2.js"></script>
        <script src="../assets/js/bootstrap.js"></script>
</body>
</html>
<?php 
} 
?>