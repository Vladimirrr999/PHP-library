    
  <div class="navbar navbar-inverse set-radius-zero" >
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard.php">
                    <img src="../assets/img/myLogo.png" alt="My Logo" />
                </a>
            </div>
       </div>
  </div>
  <section class="menu-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="navbar-collapse collapse">
          <div class="right-div">
              <a href="views/pages/logout.php" class="btn btn-danger pull-right">Logout</a>
          </div>
            <ul id="menu-top" class="nav navbar-nav navbar-right">
            <?php
              $query = "SELECT * FROM navigations_admin";
              $stmt = $dbh->prepare($query);
              $stmt->execute();
              $navigations = $stmt->fetchAll(PDO::FETCH_ASSOC);

              foreach ($navigations as $navigation) {
                if ($navigation['has_subpages'] == 1) {
                  echo '<li>';
                  echo '<a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown">' . $navigation['name'] . ' <i class="fa fa-angle-down"></i></a>';
                  echo '<ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">';
                  $query = "SELECT * FROM admin_subpages WHERE navigation_id = :navigation_id";
                  $stmt = $dbh->prepare($query);
                  $stmt->bindParam(':navigation_id', $navigation['id']);
                  $stmt->execute();
                  $subpages = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  foreach ($subpages as $subpage) {
                    echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="' . $subpage['href'] . '">' . $subpage['name'] . '</a></li>';
                  }
                  
                  echo '</ul>';
                  echo '</li>';
                } else {
                  echo '<li><a href="' . $navigation['href'] . '">' . $navigation['name'] . '</a></li>';
                }
              }
            ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function() {
    $('.dropdown-toggle').dropdown();
  });
</script>

