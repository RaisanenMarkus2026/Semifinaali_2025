<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="munTyyli.css">
    <title>Tietovisa - tulos</title>
</head>
<body>
    <header>
        <h1>TIETOVISA</h1>
        <nav>
            <ul>
                <li><a href="etusivu.php">Etusivu</a></li>
                <li><a href="tulos.php">Tulokset</a></li>
                <li><a href="login.php">Kirjaudu</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Tulokset</h2>
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