<?php
if (strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
} else {
    $email = $_SESSION['login'];
    $stmt = $dbh->prepare("SELECT id FROM students WHERE email = ?");
    $stmt->execute([$email]);
    $result = $stmt->fetch();
    if ($result) {
        $student_id = $result['id']; 
        if (isset($_POST['answer_id'])) {
            $answer_id = $_POST['answer_id'];
            $stmt = $dbh->prepare("INSERT INTO student_answer (student_id, answer_id) VALUES (?, ?)");
            $stmt->execute([$student_id, $answer_id]);
            $_SESSION['success_message'] = "Answer added successfully!";
            header("Location: index.php?page=dashboard");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Could not find student with this email!";
        header("Location: index.php?page=dashboard");
        exit(); 
    }
}
?>