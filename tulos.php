<?php
    session_start();
    include 'yhteys.php';
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="munTyyli.css">
    <title>Tulos</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon/favicon.ico">
</head>
<body>
    <header>
        <h1>TIETOVISA</h1>
        <?php include 'oppilaan_navigointi.php'; ?>
    </header>
    <main>
        <h2>Tallenna tulos</h2>
        <form action="" method="post">
            <label for="pelaaja">Pelaajan nimi:</label>
            <input type="text" id="pelaaja" name="pelaaja" required><br>
            <input type="submit" value="Lähetä">
        </form>
    </main>
    <footer>
        <p>&copy; Tietovisa, Markus Räisänen, JEDU - 2026.</p>
    </footer>
</body>
</html>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pelaaja = $_POST['pelaaja'];
        $pisteet = $_SESSION['pelinPisteet'];
        $kategoria = $_SESSION['valittuPeli'];
        $maara = count($_SESSION['pelinKysymykset']);
        $tulos = $pisteet . '/' . $maara;
        $haku = "INSERT INTO tulokset (Nimi, Tulos, Testi_kategoria, Testi_aika) VALUES ('$pelaaja', '$tulos', '$kategoria', NOW())";
        if ($yhteys->query($haku) === TRUE) {
            echo "<p style='color:green;'>Tulos tallennettu onnistuneesti.</p>";
            header("Location: aloitaPeli.php");
            exit();
        } else {
            echo "<p style='color:red;'>Virhe: " . $yhteys->error . "</p>";
        }
    }
?>