<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="munTyyli.css">
    <title>Tietovisa - rekisteröityminen</title>
</head>
<body>
    <h1>TIETOVISA</h1>
    <h2>Rekisteröityminen</h2>
    <form action="" method="post">
        <label for="name">Uusi opettaja:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="password">Salasana:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="Lisää">
    </form>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") { 

            // Hae lomakkeelta lähetetyt tiedot.
            $name = $_POST["name"];
            $password = $_POST["password"];

            // Yhdistä tietokantaan.
            $conn = new mysqli("localhost", "root", "", "tietovisa");

            // Tarkista yhteys.
            if ($conn->connect_error) {
                die("Yhteys epäonnistui: " . $conn->connect_error);
            }

            // Tarkista, onko opettajan nimi jo olemassa
            $checkSql = "SELECT * FROM teachers WHERE username='$name'";
            $result = $conn->query($checkSql);
            if ($result->num_rows > 0) {
                echo "Opettajan nimi on jo käytössä. Valitse toinen nimi.";
                $conn->close();
            } else {
                // Lisää uusi opettaja tietokantaan
                $sql = "INSERT INTO teachers (username, password_hash) VALUES ('$name', '$password')";

                if ($conn->query($sql) === TRUE) {
                    echo "Uusi opettaja lisätty onnistuneesti.";
                    $conn->close();
                } else {
                    echo "Virhe: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    ?>
    <footer>
        <p>&copy; Tietovisa, Markus Räisänen, JEDU - 2026.</p>
    </footer>
</body>
</html>

<?php
    // Sessionin aloittaminen ja käyttäjän nimen tallentaminen istuntoon. 
    // session_start();
    // $_SESSION["name"] = $_POST["name"];
    // Muista lopuksi session_end() kun istunto on päättynyt.
    // session_end();
?>