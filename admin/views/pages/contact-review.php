<?php
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
    <title>OLMS | Survey Answers</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
  <section class="vh-100 gradient-custom" style="margin-left:33%;">
  <div class="py-5">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="tabelaCreate">
          <div class="table-responsive" style="margin-top:10rem;">
            <h3 class="page-title" style="margin:2rem;">Questions from students: </h3>
            <table class="table table-striped table-centered">
              <thead>
                <tr>
                  <th>Student</th>
                  <th>Email</th>
                  <th>Message</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $sql ="SELECT students.email, contact_admin.message from students INNER JOIN contact_admin
                  ON students.id = contact_admin.student_id
                  ORDER BY contact_admin.posting_date ASC";

                  $query = $dbh -> prepare($sql);
                  $query->execute();
                  $results=$query->fetchAll(PDO::FETCH_OBJ);
                  $cnt=1;
                  if($query->rowCount() > 0)
                  {
                    foreach($results as $result)
                    {
                    ?>                                      
                        <tr class="odd gradeX">
                        <td class="center"><?php echo htmlentities($cnt);?></td>
                        <td class="center"><?php echo htmlentities($result->email);?></td>
                        <td class="center"><?php echo htmlentities($result->message);?></td>
                        </tr>
                        <?php
                        $cnt=$cnt+1;
                    }
                  }
                ?>                                      
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    <script src="../assets/js/jquery-1.10.2.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
</body>
</html>