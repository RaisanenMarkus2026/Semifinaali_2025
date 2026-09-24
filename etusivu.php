<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="munTyyli.css">
    <title>Tietovisa - etusivu</title>
</head>
<body>
    <header>
        <h1>TIETOVISA</h1>
        <nav>
            <ul>
                <li><a href="etusivu.php">Etusivu</a></li>
                <li><a href="pelaa.php">Pelaa</a></li>
                <li><a href="login.php">Kirjaudu</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h3>Haluatko testata taitojasi? Se on nyt helppoa! Valitse opettaja ja aihealue. Aloita heti!</h3>
        <button onclick="window.location.href='pelaa.php'">Pelaa nyt</button><br><br>
        <img src="assets/wireframes/gameview-desktop.png" alt="Tietovisa">
        <img src="assets/images/pexels-rdne-7092416.jpg" alt="Tietovisa">
        <h3>Miten pelataan?</h3>
        <ol>
            <li>Tee ensimmäinen valinta - keneltä haluat oppia ja mistä aiheesta?</li>
            <li>Päätä kuinka monta kysymystä haluat vastata: 5, 10 tai 15.</li>
            <li>Vastaa kysymyksiin ja seuraa tulostasi reaaliajassa.</li>
            <li>Kun olet valmis, voit tarkistaa tuloksesi ja verrata sitä muiden pelaajien tuloksiin.</li>
        </ol>
    </main>
    <footer>
        <p>&copy; Tietovisa, Markus Räisänen, JEDU - 2026.</p>
    </footer>
</body>
</html>