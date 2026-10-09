<?php
    session_start();
    include 'yhteys.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="munTyyli.css">
    <title>Uusi kategoria</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon/favicon.png">
</head>
<body>
    <header>
        <h1>TIETOVISA</h1>
        <?php include 'opettajan_navigointi.php'; ?>
    </header>
    <main>
        <h2>Uusi kategoria</h2>
        <form action="" method="post">
            <label for="kategoria"><?php echo $_SESSION['loggedIn']; ?>: </label>
            <input type="text" name="kategoria" required><br>
            <input type="submit" value="Lisää">
        </form>
    </main>
    <footer>
        <p>&copy; Tietovisa, Markus Räisänen, JEDU - 2026.</p>
    </footer>    
</body>
</html>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $kategoria = $_POST['kategoria'];
        $teacherId = $_SESSION['teacherId'];
        $haku = "INSERT INTO categories (name, teacher_id) VALUES ('$kategoria', '$teacherId')";
        if ($yhteys->query($haku) === TRUE) {
            echo "<p style='color:green;'>Kategoria lisätty onnistuneesti.</p>";
            header("Location: lisaaKategoria.php");
            exit();
        } else {
            echo "<p style='color:red;'>Virhe: " . $yhteys->error . "</p>";
        }
    }
?>