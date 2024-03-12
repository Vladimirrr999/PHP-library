<?php
if (strlen($_SESSION['login']) == 0) {   
    header('location:index.php');
    exit();
}

$msg = null;
$error = null;

if (isset($_POST['change'])) {
    $password = md5($_POST['password']);
    $newpassword = md5($_POST['newpassword']);
    $email = $_SESSION['login'];
    $sql = "SELECT Password FROM students WHERE email=:email and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    
    if ($query->rowCount() > 0) {
        if (strlen($_POST['newpassword']) >= 8) {
            $con = "UPDATE students SET password=:newpassword WHERE email=:email";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();
            $_SESSION['msg'] = "Your password has been successfully changed.";
            $msg = isset($_SESSION['msg']) ? htmlentities($_SESSION['msg']) : "";
            $type = "succWrap";
        } else {
            $_SESSION['error'] = "Your new password must have at least 8 characters.";
            $error = isset($_SESSION['error']) ? htmlentities($_SESSION['error']) : "";
            $type = "errorWrap";
        }
    } else {
        $_SESSION['error'] = "Your current password is wrong.";
        $error = isset($_SESSION['error']) ? htmlentities($_SESSION['error']) : "";
        $type = "errorWrap";
    }
}
?>