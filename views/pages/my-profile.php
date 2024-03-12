<?php 
$page = $_SERVER['REQUEST_URI'];
$sql = "INSERT INTO page_views (page) VALUES (:page)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':page', $page);
$stmt->execute();
include "models/update-logic.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>OLMS | Student Profile</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> 
</head>
<body>
  <div class="content-wrapper">
    <div class="container">
      <div class="row pad-botm">
        <div class="col-md-12">
          <h4 class="header-line">My Profile</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-9 col-md-offset-1">
          <div class="panel panel-danger">
            <div class="panel-heading">
              My Profile
            </div>
            <div class="panel-body">
              <form name="signup" method="post" id="update-form" action="index.php?page=update">
                <?php 
                $sid=$_SESSION['stdid'];
                $sql="SELECT student_id_number,name,email,mobile,created_at,updated_at,status from  students  where student_id_number=:sid ";
                $query = $dbh -> prepare($sql);
                $query-> bindParam(':sid', $sid, PDO::PARAM_STR);
                $query->execute();
                $results=$query->fetchAll(PDO::FETCH_OBJ);
                $cnt=1;
                if($query->rowCount() > 0)
                {
                  foreach($results as $result)
                  {               
                  ?>  
                  <div class="form-group">
                    <label>Student ID : </label>
                    <?php echo htmlentities($result->student_id_number);?>
                  </div>
                  <div class="form-group">
                    <label>Registration Date : </label>
                    <?php echo htmlentities($result->created_at);?>
                  </div>
                  <?php if($result->updated_at!=""){?>
                  <div class="form-group">
                    <label>Last Updation Date : </label>
                    <?php echo htmlentities($result->updated_at);?>
                  </div>
                  <?php } ?>
                  <div class="form-group">
                    <label>Profile Status : </label>
                    <?php if($result->status==1){?>
                    <span style="color: green">Active</span>
                    <?php } else { ?>
                    <span style="color: red">Blocked</span>
                    <?php }?>
                  </div>
                  <div class="form-group">
                    <label>Enter Full Name</label>
                    <input class="form-control" type="text" name="fullname" value="<?php echo htmlentities($result->name);?>" autocomplete="off" required />
                  </div>
                  <div class="form-group">
                    <label>Mobile Number :</label>
                    <input class="form-control" type="text" name="mobileno" maxlength="10" value="<?php echo htmlentities($result->mobile);?>" autocomplete="off" required />
                  </div>
                  <div class="form-group">
                    <label>Your Email</label>
                    <input class="form-control" type="email" name="email" id="emailid" value="<?php echo htmlentities($result->email);?>"  autocomplete="off" required readonly />
                  </div>
                  <small>You cannot change email. In order to do so, contact admin!</small>
                  <div class="form-group">
                        <p class="help-block"><a href="index.php?page=password-change">Change Password</a></p>
                   </div>
                  <?php }} ?>
                  <button type="submit" name="update" class="btn btn-primary" id="submit">Update Now </button>
                  <div id="update-message"></div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script>
        const updateForm = document.getElementById('update-form');
        const updateMessage = document.getElementById('update-message');
        updateForm.addEventListener('submit', (event) => {
            $.ajax({
                url: "update-profile.php",
                type: "POST",
                data: $("#update-form").serialize(),
                success: function(response) {
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  console.log(textStatus);
                }
            });
        });
    </script>
</body>
</html>
