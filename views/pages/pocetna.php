<?php
$page = $_SERVER['REQUEST_URI'];
$sql = "INSERT INTO page_views (page) VALUES (:page)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':page', $page);
$stmt->execute();
if(isset($_SESSION['login']) && $_SESSION['login']) {
    header("Location: index.php?page=dashboard");
    exit();
}
?>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-sm-8 col-xs-12 col-md-offset-1">
                <div id="carousel-example" class="carousel slide slide-bdr" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="assets/img/slide1.jpg" alt="" />
                        </div>
                        <div class="item">
                            <img src="assets/img/slide2.jpeg" alt="" />
                        </div>
                        <div class="item">
                            <img src="assets/img/slide3.png" alt="" />
                        </div>
                    </div>
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example" data-slide-to="1"></li>
                        <li data-target="#carousel-example" data-slide-to="2"></li>
                    </ol>
                    <a class="left carousel-control" href="#carousel-example" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <h4 class="header-line">STUDENT LOG IN</h4>
        </div>
        <a name="ulogin"></a>
        <?php if (!isset($_SESSION['login']) || !$_SESSION['login']) : ?>
        <?php include "models/login.php"; ?>
        <?php else : ?>
        <div class="row">
            <div class="col-md-12">
                <h4 class="header-line">You are already logged in.</h4>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
