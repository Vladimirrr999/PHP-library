<?php
if (isset($_SESSION['success_message'])) {
    echo '<p class="alert alert-success">' . $_SESSION['success_message'] . '</p>';
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    echo '<p class="alert alert-danger">' . $_SESSION['error_message'] . '</p>';
    unset($_SESSION['error_message']);
}
if(strlen($_SESSION['login'])==0){ 
    header('location:index.php');
}
else{
    if(isset($_POST['submit'])){
        $email = $_SESSION['login'];
        if($email != $_POST['email']){
            $_SESSION['error_message'] = 'You need to use your email.';
            header("Location: index.php?page=contact");
            exit();
        }
        $sql = "SELECT id FROM students WHERE email=:email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $studentid = $result['id'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $sql = "INSERT INTO contact_admin (student_id, Message) VALUES (:studentid, :message)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
        $query->bindParam(':message', $message, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $_SESSION['success_message'] = 'Your message has been succefully sent. Admin will contact you in 24h.';
            header("Location: index.php?page=contact");
            exit();
        } else {
            $_SESSION['error_message'] = 'Something went wrong. Please try again';
            header("Location: index.php?page=contact");
            exit();
        }
    }
}


?>