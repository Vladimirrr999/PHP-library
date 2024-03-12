<?php 
$page = $_SERVER['REQUEST_URI'];
$sql = "INSERT INTO page_views (page) VALUES (:page)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':page', $page);
$stmt->execute();
require_once('../includes/connection.php');
if(!empty($_POST["studentid"])) {

  $studentid= strtoupper($_POST["studentid"]);
  $sql ="SELECT name,status,email,mobile 
         FROM students 
         WHERE student_id_number=:studentid";    
  $query= $dbh -> prepare($sql);
  $query-> bindParam(':studentid', $studentid, PDO::PARAM_STR);
  $query-> execute();
  $results = $query -> fetchAll(PDO::FETCH_OBJ);
  $cnt=1;
  if($query -> rowCount() > 0)
  {
    echo "<div class='container'>";
    echo "<div class='row'>";
    echo "<div class='col-md-12'>";
    foreach ($results as $result) {
      if($result->status==0)
      {
        echo "<span style='color:red'> Student ID Blocked </span>"."<br />";
        echo "<b>Student Name-</b>" .$result->name;
        echo "<script>$('#submit').prop('disabled',true);</script>";
      } else {
        echo htmlentities($result->name)."<br />";
        echo htmlentities($result->email)."<br />";
        echo htmlentities($result->mobile);
        echo "<script>$('#submit').prop('disabled',false);</script>";
      }
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
  else{
    echo "<div class='container'>";
    echo "<div class='row'>";
    echo "<div class='col-md-12'>";
    echo "<span style='color:red'> Invalid Student ID. Please Enter Valid Student ID.</span>";
    echo "<script>$('#submit').prop('disabled',true);</script>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
}
?>
