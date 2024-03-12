<div class="row mt-4">
    <div class="col-md-12">
        <h4 class="header-line">Page Visits</h4>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Stranica</th>
                    <th>Pristupi</th>
                    <th>Procenat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT page, COUNT(*) AS visits FROM page_views WHERE timestamp >= (NOW() - INTERVAL 1 DAY) GROUP BY page";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_ASSOC);

                $totalVisits = 0;

                foreach ($results as $row) {
                    $totalVisits += $row['visits'];
                }

                foreach ($results as $row) {
                    $page = $row['page'];
                    $visits = $row['visits'];
                    $percentage = ($visits / $totalVisits) * 100;
                    ?>
                    <tr>
                        <td><?php echo $page; ?></td>
                        <td><?php echo $visits; ?></td>
                        <td><?php echo $percentage; ?>%</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
