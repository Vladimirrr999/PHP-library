<div class="row text-center justify-content-center">
                    <?php 
                        $sql = 'SELECT * FROM dashbord_icons_user';
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                        foreach ($results as $row) {
                            $id = $row->id;
                            $name = $row->name;
                            $iconClass = $row->icon_class;
                            $hrefLocation = $row->href_location;

                            if ($name == 'Books Listed') {
                    ?>
                    <a href="<?php echo $hrefLocation; ?>">
                        <div class="col-md-4 col-sm-4 col-xs-6 centr">
                            <div class="alert alert-success back-widget-set">
                                <i class="<?php echo $iconClass; ?>" style="color: <?php echo $row->icon_color; ?>;"></i>
                                <?php 
                                    $sql ="SELECT id FROM books";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $listdbooks = $query->rowCount();
                                ?>
                                <h3><?php echo htmlentities($listdbooks); ?></h3>
                                <p><?php echo $name; ?></p>
                            </div>
                        </div>
                    </a>
                    <?php } else { ?>
                    <a href="<?php echo $hrefLocation; ?>">
                        <div class="col-md-4 col-sm-4 col-xs-6 centr">
                            <div class="alert alert-success back-widget-set">
                                <i class="<?php echo $iconClass; ?>" style="color: <?php echo $row->icon_color; ?>;"></i>
                                <h3>&nbsp;</h3>
                                <p><?php echo $name; ?></p>
                            </div>
                        </div>
                    </a>
                    <?php }
                        } ?>
            </div>