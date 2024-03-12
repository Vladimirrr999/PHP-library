<?php
$page = $_SERVER['REQUEST_URI'];
$sql = "INSERT INTO page_views (page) VALUES (:page)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':page', $page);
$stmt->execute();
require_once('../includes/connection.php');
if (!empty($_POST["bookid"])) {
    $bookid = $_POST["bookid"];
    $sql = "SELECT DISTINCT books.name AS bookName, books.id, authors.name 
            AS authorName, books.image AS bookImage, books.is_issued 
            FROM books
            JOIN authors ON authors.id = books.author_id
            WHERE (isbn = :bookid OR books.name LIKE '%$bookid%')";
    $query = $dbh->prepare($sql);
    $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    if ($query->rowCount() > 0) {
?>
    <div class="container">
        <div class="row">
            <table class="table">
                <tr>
                    <?php foreach ($results as $result) { ?>
                        <th class="col-md-3">
                            <img src="bookimg/<?php echo htmlentities($result->bookImage); ?>" width="120"><br />
                            <?php echo htmlentities($result->bookName); ?><br />
                            <?php echo htmlentities($result->authorName); ?><br />
                            <?php if ($result->is_issued == '1') : ?>
                                <p style="color:red;">Book Already issued</p>
                            <?php else : ?>
                                <input type="radio" name="bookid" value="<?php echo htmlentities($result->id); ?>" required>
                            <?php endif; ?>
                        </th>
                        <?php echo "<script>$('#submit').prop('disabled',false);</script>"; ?>
                    <?php } ?>
                </tr>
            </table>
        </div>
    </div>
<?php
    } else { ?>
    <p>Record not found. Please try again.</p>
    <?php
        echo "<script>$('#submit').prop('disabled',true);</script>";
    }
}
?>
