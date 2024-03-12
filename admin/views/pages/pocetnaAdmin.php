<?php
$page = $_SERVER['REQUEST_URI'];
$sql = "INSERT INTO page_views (page) VALUES (:page)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':page', $page);
$stmt->execute();
?>
<div class="row mt-4">
    <div class="col-md-12">
        <h4 class="header-line">ADMIN DASHBOARD</h4>
    </div>
</div>
<div class="row mt-4">
    <?php
    $sql = 'SELECT * FROM dashboard_admin_icons';
    $query = $dbh->prepare($sql);
    $query->execute();
    $results_icons = $query->fetchAll(PDO::FETCH_OBJ);

    $colors = array(
        'Books listed' => array('background' => '#dff0d8', 'text' => '#3c763d'),
        'Books Not Returned Yet' => array('background' => '#fcf8e3', 'text' => '#8a6d3b'),
        'Registered Users' => array('background' => '#f2dede', 'text' => '#a94442'),
        'Authors Listed' => array('background' => '#dff0d8', 'text' => '#3c763d'),
        'Survey answers' => array('background' => '#a19cd2', 'text' => 'purple'),
        'Questions from students' => array('background' => '#87CEFA', 'text' => 'white'),
        'Listed Categories' => array('background' => 'transparent', 'text' => '#31708f'),
        'Users from text file' => array('background' => 'transparent', 'text' => 'blue'),
        'Page access' => array('background' => 'pink', 'text' => 'brown')
    );

    foreach ($results_icons as $row) {
        $name = $row->name;
        $icon = $row->icon;
        $href = $row->href;
        $color = $colors[$name];
        ?>
        <div class="col-md-3 col-sm-6">
            <a href="<?php echo htmlentities($href); ?>" style="text-decoration: none;">
                <div class="alert text-center"
                     style="background-color: <?php echo $color['background']; ?>; color: <?php echo $color['text']; ?>;border: 2px solid <?php echo $color['text']; ?>">
                    <i class="fa <?php echo htmlentities($icon); ?> fa-5x"></i>
                    <?php
                    if ($name == 'Page access') {
                        $query = $dbh->prepare(upiti($name));
                        $query->execute();
                        $result = $query->fetch(PDO::FETCH_ASSOC);
                        $visits = $result['visits'];
                        echo "<h3>Page visits <br/><br/>".$visits."</h3>";
                        continue;
                    }
                    if ($name == 'Users from text file') {
                        $pokazivac = fopen("../data/korisnici.txt", "r");
                        $fileSize = filesize("../data/korisnici.txt");

                        if ($fileSize > 0) {
                            $vrednosti = fread($pokazivac, $fileSize);
                            fclose($pokazivac);
                            $vrednosti = trim($vrednosti);
                            $imenik = explode("\n", $vrednosti);
                            $brojKorisnika = "<p style='font-size:25px;'>".count($imenik). "</p>";
                            echo "<br/><b>".$brojKorisnika."</b></br>";
                        } else {
                            fclose($pokazivac);
                            $brojKorisnika = "<p style='font-size:25px;'>0</p>";
                            echo "<br/><b>".$brojKorisnika."</b></br>";
                        }
                    } else {
                        $query = $dbh->prepare(upiti($name));
                        $query->execute();
                        $count = $query->rowCount();
                        echo "<h3>".htmlentities($count)."</h3>";
                    }
                    ?>
                    <?php echo htmlentities($name); ?>
                </div>
            </a>
        </div>
    <?php
    }

    function upiti($name) {
        if ($name == 'Books listed') {
            return 'SELECT id FROM books';
        } else if ($name == 'Books Not Returned Yet') {
            return 'SELECT id FROM issued_book_details WHERE return_status = "" OR return_status IS NULL';
        } else if ($name == 'Registered Users') {
            return 'SELECT id FROM students';
        } else if ($name == 'Authors Listed') {
            return 'SELECT id FROM authors';
        } else if ($name == 'Survey answers') {
            return 'SELECT students.email, survey.answer_text FROM student_answer 
                    INNER JOIN students ON students.id = student_answer.student_id 
                    INNER JOIN survey ON survey.id = student_answer.answer_id';
        } else if ($name == 'Questions from students') {
            return 'SELECT contact_admin.message, students.email FROM students 
                    INNER JOIN contact_admin ON students.id = contact_admin.student_id';
        } else if ($name == 'Listed Categories') {
            return 'SELECT id FROM category';
        }else if($name =='Page access'){
            return "SELECT page, COUNT(*) AS visits FROM page_views WHERE timestamp >= (NOW() - INTERVAL 1 DAY) GROUP BY page";
        }
        return '';
    }
    ?>
</div>
