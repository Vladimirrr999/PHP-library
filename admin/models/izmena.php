<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>OLMS | Change users</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../../assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $ime = $_POST['ime'];
        $brojTelefona = $_POST['brojTelefona'];
        $email = $_POST['email'];
        $indeks = $_POST['indeks'];

        $pokazivac = fopen("../../data/korisnici.txt", "r");
        $fileSize = filesize("../../data/korisnici.txt");

        if ($fileSize > 0) {
            $vrednosti = fread($pokazivac, $fileSize);
            $vrednosti = trim($vrednosti);
            $imenik = explode("\n", $vrednosti);
        } else {
            $imenik = []; 
        }
        fclose($pokazivac);
        $imenik[$indeks] = "{$ime}_{$brojTelefona}_{$email}";

        $pokazivac = fopen("../../data/korisnici.txt", "w");
        fwrite($pokazivac, implode("\n", $imenik));
        fclose($pokazivac);
        header("Location: ../dashboard.php?page=textFile");
        exit();
    } else {
        if (!isset($_GET['id'])) {
            header("Location: ../dashboard.php?page=textFile");
            exit();
        }
        $indeks = $_GET['id'];
        $pokazivac = fopen("../data/korisnici.txt", "r");
        $fileSize = filesize("../data/korisnici.txt");

        if ($fileSize > 0) {
            $vrednosti = fread($pokazivac, $fileSize);
            $vrednosti = trim($vrednosti);
            $imenik = explode("\n", $vrednosti);

            if (!isset($imenik[$indeks])) {
                fclose($pokazivac);
                header("Location: ../dashboard.php?page=textFile");
                exit();
            }
            list($ime, $brojTelefona, $email) = explode("_", $imenik[$indeks]);
        } else {
            fclose($pokazivac);
            header("Location: ../dashboard.php?page=textFile");
            exit();
        }
        fclose($pokazivac);
    }
    ?>
    <div class="container" style='margin-top:110px;'>
        <div class="row">
            <form method="POST" action='models/izmena.php'>
                <input type="hidden" name="indeks" value="<?= $indeks ?>">
                <div class="form-group">
                    <label for="ime">Ime i Prezime</label>
                    <input type="text" class="form-control" id="ime" name="ime" value="<?= $ime ?>">
                </div>
                <div class="form-group">
                    <label for="brojTelefona">Broj telefona</label>
                    <input type="text" class="form-control" id="brojTelefona" name="brojTelefona" value="<?= $brojTelefona ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Sačuvaj izmene</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
