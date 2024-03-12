<?php
$results_per_page = 6;
$sql = "SELECT COUNT(*) AS count FROM books";
$query = $dbh->prepare($sql);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);
$num_results = $row['count'];
$num_pages = ceil($num_results / $results_per_page);
$page = isset($_GET['pagenum']) && is_numeric($_GET['pagenum']) ? intval($_GET['pagenum']) : 1;
$page = max(1, min($page, $num_pages));
$start_index = ($page - 1) * $results_per_page;

$sql = "SELECT books.name AS bookName, category.name AS categoryName, authors.name AS authorName, books.isbn AS ISBNNumber, books.price, books.id AS bookId, books.image AS bookImage, books.is_issued AS isIssued 
        FROM books 
        JOIN category ON category.id = books.category_id 
        JOIN authors ON authors.id = books.author_id
        LIMIT $start_index, $results_per_page";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Library Books</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php
                    $cnt = 1;
                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) {
                            ?>
                            <div class="col-md-4">
                                <div class="thumbnail">
                                    <img src="admin/bookimg/<?php echo htmlentities($result->bookImage); ?>" alt="<?php echo htmlentities($result->bookName); ?>">
                                    <div class="caption">
                                        <h4><?php echo htmlentities($result->bookName); ?></h4>
                                        <p><strong>Category:</strong> <?php echo htmlentities($result->categoryName); ?></p>
                                        <p><strong>Author:</strong> <?php echo htmlentities($result->authorName); ?></p>
                                        <p><strong>ISBN (unique Book Id):</strong> <?php echo htmlentities($result->ISBNNumber); ?></p>
                                        <?php if ($result->isIssued == '1') : ?>
                                            <p class="text-danger">Book Already Issued</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $cnt = $cnt + 1;
                        }
                    }
                    ?>
                </div>

                <?php if ($num_pages > 1): ?>
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                            <li><a href="index.php?page=listed&pagenum=<?php echo $page - 1; ?>">Previous</a></li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $num_pages; $i++): ?>
                            <li<?php if ($i == $page): ?> class="active"<?php endif; ?>>
                                <a href="index.php?page=listed&pagenum=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $num_pages): ?>
                            <li><a href="index.php?page=listed&pagenum=<?php echo $page + 1; ?>">Next</a></li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
