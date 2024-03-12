<?php
    if(isset($_POST['signup'])){

        $separator = "_";
        $ime = $_POST['fullname'];
        $mob = $_POST['mobileNum'];
        $email = $_POST['email'];

        $fajl = fopen("data/korisnici.txt", "a");
        $sadrzaj = $ime.$separator.$mob.$separator.$email."\n";
        fwrite($fajl,$sadrzaj);
        if(fclose($fajl)){
            header("Location: index.php#ulogin");
        }
    }

?>
