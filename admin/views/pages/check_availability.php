<?php 
$page = $_SERVER['REQUEST_URI'];
$sql = "INSERT INTO page_views (page) VALUES (:page)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':page', $page);
$stmt->execute();
require_once('../includes/connection.php');
if(!empty($_POST["isbn"])) {
$isbn=$_POST["isbn"];
$sql ="SELECT id FROM books WHERE isbn=:isbn";
$query= $dbh -> prepare($sql);
$query-> bindParam(':isbn', $isbn, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
 
if($query -> rowCount() > 0){
echo "<span style='color:red'> ISBN already exists with another book. .</span>"; 
echo "<script>$('#add').prop('disabled',true);</script>";
} else { echo "<script>$('#add').prop('disabled',false);</script>";}
}