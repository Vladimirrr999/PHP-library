<?php
$page = $_SERVER['REQUEST_URI'];
$sql = "INSERT INTO page_views (page) VALUES (:page)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':page', $page);
$stmt->execute();
$pokazivac = fopen("../data/korisnici.txt", "r");
$fileSize = filesize("../data/korisnici.txt");

if ($fileSize > 0) {
    $vrednosti = fread($pokazivac, $fileSize);
    $vrednosti = trim($vrednosti);
    $imenik = explode("\n", $vrednosti);
} else {
    $imenik = []; 
}
fclose($pokazivac);
?>

<div class="container" style='margin-top:60px;'>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">R.B.</th>
                    <th scope="col">Ime i Prezime</th>
                    <th scope="col">Broj telefona</th>
                    <th scope="col">Email</th>
                    <th scope="col">Izmena</th>
                    <th scope="col">Brisanje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($imenik as $indeks => $osoba):
                    list($ime, $brojTelefona, $email) = explode("_", $osoba);
                ?>
                <tr>
                    <td><?= $indeks+1; ?></td>
                    <td><?= $ime; ?></td>
                    <td><?= $brojTelefona; ?></td>
                    <td><?= $email; ?></td>
                    <td><a href="dashboard.php?page=izmena&id=<?= $indeks ?>">Izmeni</a></td>
                    <td><a href="models/brisanje.php?id=<?= $indeks ?>" onclick="return confirmDelete()">Izbrisi</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete() {
        var result = confirm("Da li ste sigurni da želite da obrišete ovog korisnika?");
        return result;
    }
</script>
