<section class="footer-section bg-dark text-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <p>&copy; <?php echo date('Y');?> Visoka ICT skola<b> Vladimir Lobanov, 84/21</b></p>
                <a href="#" class="ic"><i class="fa fa-instagram"></i></a>
                <a href="#" class="ic"><i class="fa fa-twitter"></i></a>
                <a href="#" class="ic"><i class="fa fa-facebook"></i></a>
                <a href="<?php echo (strpos($_SERVER['REQUEST_URI'], 'dashboard.php') !== false) ? '../sitemap.xml' : 'sitemap.xml'; ?>" class="ic"><i class="fa fa-sitemap"></i></a>
                <br/>
                <a href="#"><h3>DOCUMENTATION</h3></a>
            </div>
        </div>
    </div>
</section>

<style>
    .ic{
        padding: 20px;
        font-size: 20px;
        color: blue;
    }
</style>
