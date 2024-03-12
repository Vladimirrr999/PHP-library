<?php
include 'models/survey-sendingLogic.php';
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
    <title>OLMS | Survey  </title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<div class="mx-0 mx-sm-auto">
  <div class="card">
    <div class="card-body">
      <div class="text-center">
        <i class="far fa-file-alt fa-4x mb-3 text-primary"></i>
        <p>
          How did you hear about our Library?<br/>Please choose one of answers below. 
        </p>
      </div>
      <hr />
      <form class="px-4" action="index.php?page=survey" method="post" style="text-align:center;">
        <?php
        $stmt = $dbh->query("SELECT * FROM survey");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $answer_id = $row['id'];
          $answer_text = $row['answer_text'];
          ?>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="answer_id" id="answer_<?php echo $answer_id ?>" value="<?php echo $answer_id ?>" />
            <label class="form-check-label" for="answer_<?php echo $answer_id ?>">
              <?php echo $answer_text ?>
            </label>
          </div>
        <?php } ?>
        <?php
        if(isset($_POST['submit'])) {
            if(!isset($_POST['answer_id'])) {
                echo '<p class="alert alert-danger">Morate izabrati nešto!</p>';
            }
        }
        ?>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.js"></script>
</body>
</html>
