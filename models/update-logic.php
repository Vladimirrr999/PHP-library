<?php
if(strlen($_SESSION['login']) == 0) {   
    header('location:index.php');
} else { 
    if(isset($_POST['update'])) {   
        $message = ''; 
        $sid = $_SESSION['stdid'];  
        $fname = $_POST['fullname'];
        $mobileno = $_POST['mobileno'];
        try {
            $sql = "UPDATE students SET name=:fname, mobile=:mobileno WHERE student_id_number=:sid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':sid', $sid, PDO::PARAM_STR);
            $query->bindParam(':fname', $fname, PDO::PARAM_STR);
            $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
            $query->execute();
            $affectedRows = $query->rowCount();
            if ($affectedRows > 0) {
                $message = '<p style="color:green;">Your profile has been updated successfully!</p>';
            } else {
                $message = '<p style="color:red;">Failed to update! You didn\'t make any changes.</p>';
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>