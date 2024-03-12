<?php

if(isset($_POST['signup'])) {
    $StudentId = "SID" . rand(000, 999);
    $sql = "SELECT * FROM students WHERE student_id_number = :student_id_number";
    $query = $dbh->prepare($sql);
    $query->bindParam(':student_id_number',$StudentId,PDO::PARAM_STR);
    $query->execute();
    $count = $query->rowCount();
    while ($count > 0) {
        $StudentId = "SID" . rand(000, 999);
        $query_->execute();
        $count = $query->rowCount();
    }
        $fname=$_POST['fullname'];
        $mobileNum=$_POST['mobileNum'];
        $email=$_POST['email']; 
        $password=md5($_POST['password']); 
        $status=1;
    
        $sql = "SELECT * FROM students WHERE email = :email"; 
        $query = $dbh->prepare($sql);
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->execute();
        $count = $query->rowCount();
    
        if($count > 0) {
            echo '<p class="alert alert-danger">Email already exists. Please use a different email address.</p>';
            echo '<script>
                setTimeout(function() {
                    $(".alert").slideUp(500);
                }, 2000);
            </script>';
        } else {
            $sql="INSERT INTO students(student_id_number,name,mobile,email,password,status) 
                  VALUES(:StudentId,:fname,:mobileNum,:email,:password,:status)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':StudentId',$StudentId,PDO::PARAM_STR);
            $query->bindParam(':fname',$fname,PDO::PARAM_STR);
            $query->bindParam(':mobileNum',$mobileNum,PDO::PARAM_STR);
            $query->bindParam(':email',$email,PDO::PARAM_STR);
            $query->bindParam(':password',$password,PDO::PARAM_STR);
            $query->bindParam(':status',$status,PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if($lastInsertId) {
                $_SESSION['registration_message'] = 'Registration successful! Your student ID is: '.$StudentId;
                header("Location: index.php#ulogin");
                exit;
            } else {
                $_SESSION['registration_message'] = 'Something went wrong. Please try again.';
                header("Location: index.php#ulogin");
                exit;
            }
        }
    } 

?>