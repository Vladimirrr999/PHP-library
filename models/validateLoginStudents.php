<?php
$email = "";
$password = "";
$emailErr = $passwordErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["emailid"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["emailid"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format"; 
    }
  }
  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  } else {
    $password = md5(test_input($_POST["password"]));
  }
  if (empty($emailErr) && empty($passwordErr)) {
    $sql ="SELECT email,password,student_id_number,status FROM students WHERE email=:email and password=:password";
    $query= $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
      foreach ($results as $result) {
        $_SESSION['stdid'] = $result->student_id_number;
        if ($result->status == 1) {
          $_SESSION['login'] = $email;
          echo "<script type='text/javascript'> document.location ='index.php?page=dashboard'; </script>";
        } else {
          $errorMsg = "Your Account Has been blocked. Please contact admin";
        } 
      }
    } else {
      $errorMsg = "Invalid email or password";
    }
  }
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>