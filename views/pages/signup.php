
<?php include 'models/register.php';
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
    <title>OLMS | Student Signup</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div class="container">
    <span id="error-msg"></span>
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Register and use our Library!</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 col-md-offset-1">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            Enter your credentials
                        </div>
                        <div class="panel-body">
                        <form name="signup" id="loginForm1" method="post" onSubmit="return validRegistration();" novalidate>
                            <div class="form-group">
                                <label for="full-name">Ime i prezime:</label>
                                <input class="form-control" type="text" name="fullname" id="full-name" autocomplete="off" required />
                                <span id="full-name-error" class="error"></span>
                            </div>
                            <div class="form-group">
                                <label for="mobile-number">Mobilni telefon:</label>
                                <input class="form-control" type="text" name="mobileNum" id="mobile-number" maxlength="10" autocomplete="off" required />
                                <span id="mobile-number-error" class="error"></span>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input class="form-control" type="email" name="email" id="email" onBlur="checkAvailability()" autocomplete="off" required />
                                <span id="email-error" class="error"></span>
                                <span id="user-availability-status" style="font-size:12px;"></span>
                            </div>
                            <div class="form-group">
                                <label for="password">Lozinka:</label>
                                <input class="form-control" type="password" name="password" id="password" autocomplete="off" required />
                                <span id="password-error" class="error"></span>
                            </div>
                            <div class="form-group">
                                <label for="confirm-password">Potvrdi lozinku:</label>
                                <input class="form-control" type="password" name="confirmpassword" id="confirm-password" autocomplete="off" required />
                                <span id="confirm-password-error" class="error"></span>
                            </div>
                            <button type="submit" name="signup" class="btn btn-danger" id="submit">Registruj se</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script><!--ZA VALIDACIJU-->
</body>
</html>
