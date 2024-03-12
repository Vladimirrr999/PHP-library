<style>
    .dropdown a{
        background-color: #f5f5f5 !important;
    }
    .dropdown a:hover{
        background-color: #f5f5f5 !important;
    }
    .dropdown a:focus{
        background-color: #f5f5f5 !important;

    }
</style>
<nav class="navbar navbar-inverse set-radius-zero">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a id="logo" href="<?php echo isset($_SESSION['login']) ? 'index.php?page=dashboard' : 'index.php'; ?>">
                <img src="assets/img/myLogo.png" alt="Logo">
            </a>
        </div>
        <?php if(isset($_SESSION['login']) && $_SESSION['login'])
{
?> 
    <div class="right-div">
        <a href="models/logout.php" class="btn btn-danger pull-right">LOG ME OUT</a>
    </div>
<?php }?>
</div>
</div>
<!-- LOGO HEADER END-->
<?php if(isset($_SESSION['login']) && $_SESSION['login'])
{
?>
<section class="menu-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="navbar-collapse collapse">
                    <ul id="menu-top" class="nav navbar-nav navbar-right">
                        <li><a href="index.php?page=dashboard" class="menu-top-active">DASHBOARD</a></li>
                        <li><a href="index.php?page=issued">Issued Books</a></li>
                        <li><a href="index.php?page=contact">Contact Admin</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Account <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="index.php?page=profile">My Profile</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="index.php?page=password-change">Change Password</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php } else { ?>
    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <?php
                            $sql = "SELECT * FROM navigations";
                            $stmt = $dbh->query($sql);
                            $navItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <?php foreach ($navItems as $navItem) { ?>
                                <li><a href="<?php echo $navItem['href']; ?>"><?php echo $navItem['name']; ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('.dropdown-toggle').on('click', function(e) {
        e.preventDefault();
        $(this).parent().toggleClass('open');
    });
    var currentPage = "<?php echo $_GET['page'] ?? ''; ?>";
    $('#menu-top li a').each(function() {
        var linkPage = $(this).attr('href').split('=')[1];
        if (linkPage === currentPage) {
            $(this).addClass('menu-top-active');
            if (linkPage !== 'profile' && linkPage !== 'password-change') {
                $(this).parents('.dropdown').addClass('open');
            }
        }
    });
});
</script>



    