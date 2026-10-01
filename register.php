<?php include_once "yhteys.php" ?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="munTyyli.css">
    <title>Tietovisa - rekisteröityminen</title>
</head>
<body>
    <header>
        <h1>TIETOVISA</h1>
        <?php include 'oppilaan_navigointi.php'; ?>
    </header>
    <main>
        <h2>Rekisteröityminen</h2>
        <form action="" method="POST">
            <label for="name">Uusi opettaja:</label>
            <input type="text" id="name" name="nimi" required><br>
            <label for="password">Salasana:</label>
            <input type="password" id="password" name="s_sana" required><br>
            <input type="submit" value="Lisää">
        </form>
    </main>
    <footer>
        <p>&copy; Tietovisa, Markus Räisänen, JEDU - 2026.</p>
    </footer>
</body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") { 
        
        // Hae lomakkeelta lähetetyt tiedot.
        $nimi = $_POST["nimi"];
        $password = $_POST["s_sana"];

        // Tarkista, onko opettajan nimi jo olemassa
        $tarkistaSql = "SELECT * FROM teachers WHERE username='$nimi'";
        $result = $yhteys->query($tarkistaSql);
        if ($result->num_rows > 0) {
            echo "Opettajan nimi on jo käytössä. Valitse toinen nimi.";
            $yhteys->close();
        } else {
            // Lisää uusi opettaja tietokantaan
            $sqlLisaa = "INSERT INTO teachers (username, password_hash) VALUES ('$nimi', '$password')";

            if ($yhteys->query($sqlLisaa) === TRUE) {
                echo "Uusi opettaja lisätty onnistuneesti.";
                $yhteys->close();
            } else {
                echo "Virhe: " . $sqlLisaa . "<br>" . $yhteys->error;
            }
        }
    }
?>