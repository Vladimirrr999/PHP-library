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
            <h3 class="page-title" style="margin:2rem;">Survey answers from students:</h3>
            <table class="table table-striped table-centered">
              <thead>
                <tr>
                  <th>Student</th>
                  <th>Answer</th>
                  <th>Answer Selection</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $sql = "SELECT students.email, survey.answer_text 
                          FROM student_answer 
                          INNER JOIN students ON students.id = student_answer.student_id 
                          INNER JOIN survey ON survey.id = student_answer.answer_id 
                          ORDER BY student_answer.id DESC";
                  $query = $dbh->prepare($sql);
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
                  <td class="center"><?php echo htmlentities($result->answer_text);?></td>
                </tr>
                <?php
                  $cnt=$cnt+1;
                    }
                  }
                  $stmt = $dbh->query("SELECT s.id, s.answer_text, COUNT(sr.id) AS count FROM survey s 
                                       LEFT JOIN student_answer sr ON s.id = sr.answer_id GROUP BY s.id");
                  $results = $stmt->fetchAll(PDO::FETCH_ASSOC); 
                  $numMax = 0;
                  $highestPollVote = '';
                  foreach ($results as $result) {
                      if ($result['count'] > $numMax) {
                          $numMax = $result['count'];
                          $highestPollVote = $result['answer_text'];
                      }
                  } 
                ?>                                      
              </tbody>
            </table>
            <div style="background-color: #9df0e4; border-radius: 4px; padding: 5px; text-align: center;">
              <h5 class="page-title" style="margin-top: 2rem; font-weight: bold;">Survey Answer Statistics:</h5>
              <p>Most selected answer: <span style="color:blue;"><?php echo $highestPollVote; ?></span></p>  
            </div>
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