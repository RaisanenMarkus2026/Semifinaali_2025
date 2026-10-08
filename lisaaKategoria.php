<?php
    session_start();
    include 'yhteys.php';
    // var_dump($_SESSION['loggedIn']);
    // var_dump($_SESSION['teacherId']);
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="munTyyli.css">
    <title>Kategoriat</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon/favicon.ico">
</head>
<body>
    <header>
        <h1>TIETOVISA</h1>
        <?php include 'opettajan_navigointi.php'; ?>
    </header>
    <main style="border: 2px black solid;">
        <h2>Kategoriat</h2>
        <button onclick="window.location.href='uusiKategoria.php'" id="uusiAihe" style="float: right;">Luo uusi kategoria</button><br><br>
        <ol style="padding: 10px";>
            <?php
                $haku = "SELECT * FROM categories WHERE teacher_id = '$_SESSION[teacherId]'";
                $vastaus = $yhteys->query($haku);
                if ($vastaus->num_rows > 0) {
                    while ($rivi = $vastaus->fetch_assoc()) {
                        echo "<li>" . $rivi["name"] . "</li>";
                    }
                } else {
                    echo "Opettajalla ei ole yhtään kategoriaa.";
                }
                $yhteys->close();
            ?>
        </ol>
    </main>
    <footer>
        <p>&copy; Tietovisa, Markus Räisänen, JEDU - 2026.</p>
    </footer>
</body>
</html>