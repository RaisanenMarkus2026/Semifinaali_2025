<?php
    session_start();
    include "yhteys.php";
    $_SESSION['loggedIn'] = '';
    $_SESSION['teacherId'] = '';
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="munTyyli.css">
    <title>Sisäänkirjautuminen</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon/favicon.ico">
</head>
<body>
    <header>
        <h1>TIETOVISA</h1>
        <?php include 'oppilaan_navigointi.php'; ?>
    </header>
    <main>
        <h2>Sisäänkirjautuminen</h2>
        <form action="" method="post">
            <label for="name">Opettajan nimi:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="password">Salasana:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Kirjaudu">
        </form>
        <h4>Jos haluat rekisteröityä, klikkaa <a href="register.php">tästä.</a></h4>
    </main>
    <footer>
        <p>&copy; Tietovisa, Markus Räisänen, JEDU - 2026.</p>
    </footer>
</body>
</html>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $haku = "SELECT * FROM teachers WHERE username = '$name'";
        $tulos = $yhteys->query($haku);

        if ($tulos->num_rows > 0) {
            $rivi = $tulos->fetch_assoc();
            if ($rivi['password_hash'] === $password) {
                $_SESSION['loggedIn'] = $name;
                $_SESSION['teacherId'] = $rivi['id'];
                header("Location: lisaaKategoria.php");
                exit();
            } else {
                echo "<p style='color:red;'>Väärä salasana.</p>";
            }
        } else {
            echo "<p style='color:red;'>Opettajaa ei löydy.</p>";
            exit();
        }
    } 
    $yhteys->close();
?>