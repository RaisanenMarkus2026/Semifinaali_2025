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
            <label for="name">Pelaajan nimi:</label>
            <input type="text" id="name" name="name" required><br>
            <input type="submit" value="Lähetä">
        </form>
    </main>
    <footer>
        <p>&copy; Tietovisa, Markus Räisänen, JEDU - 2026.</p>
    </footer>
</body>
</html>