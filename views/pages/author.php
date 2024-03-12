<?php
$page = $_SERVER['REQUEST_URI'];
$sql = "INSERT INTO page_views (page) VALUES (:page)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':page', $page);
$stmt->execute();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>OLMS | User DashBoard</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">About me</h4>
                </div>
            </div>
            <div class="row text-center justify-content-center">
                    <div class="col-md-4 col-sm-4 col-xs-6 centr">
                        <img src="assets/img/author.jpg"/>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6 centr" style="margin-top:5vh;">
                        <div class="alert alert-success back-widget-set">
                        <p style="color:black;" >
                        Greetings everyone! My name is Vladimir Lobanov and i 
                        am the only author of this website. I am student of ICT college,
                         2nd year. I found my passion in creating websites and learning new 
                         possibilities after taking short course on Web design, so decided 
                         to dig deeper and learn a lot more cool stuff. I have experience 
                         working in MS Office package, as well in HTML,HTML5,CSS3 and MySQL DBMS.
                          I enjoy my free time in reading news and different forums on tech-trends, playing 
                          video games and reading about political topics. My biggest joy is to sit, turn on 
                          the music, relax and drink coffee in a cozy space while coding. :D
                    <p style="color:black;">&lt;/About me&gt;</p>
                </br><b style="color:black;">Broj indeksa: 84/21</b></p>
                    </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>