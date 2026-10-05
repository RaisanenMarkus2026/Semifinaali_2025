<?php
    session_start();
    include 'yhteys.php';
    $_SESSION['valittuOpe'] = $_POST['ope'] ?? '';
    $_SESSION['valittuAihe'] = $_POST['kategoria'] ?? '';
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="munTyyli.css">
    <title>Tietovisa - aloita peli</title>
</head>
<body>
    <header>
        <h1>TIETOVISA</h1>
        <?php include 'oppilaan_navigointi.php'; ?>
    </header>
    <main> 

        <img src="assets/images/pexels-googledeepmind-17483873.jpg" alt="kuva" style="float: right">

        <h2>Aloita peli</h2>
        <form action="" method="POST">
            <label for="opet">Opettaja:</label><br>
            <select name="ope" id="opet" onchange="this.form.submit()">
                <option value="">--Valitse opettaja--</option>
                <?php
                    $opeHaku = "SELECT id, username FROM teachers";
                    $opeVastaus = $yhteys->query($opeHaku);
                    if ($opeVastaus->num_rows > 0) {
                        while ($rivi = $opeVastaus->fetch_assoc()) {
                            $selected = (isset($_POST['ope']) && $_POST['ope'] == $rivi['id']) ? ' selected' : '';
                            echo "<option value='{$rivi['id']}'{$selected}>{$rivi['username']}</option>";
                        }
                    } else {
                        echo '<option value="">Ei opettajia saatavilla</option>';
                    }
                ?>
            </select>
            <br><br> 

            <label for="kategoriat">Kategoria:</label><br>
            <select name="kategoria" id="kategoriat" onchange="this.form.submit()">
                <option value="">--Valitse aihealue--</option>
                <?php
                    $aiheHaku = "SELECT * FROM categories WHERE teacher_id = '$_SESSION[valittuOpe]'";
                    $aiheVastaus = $yhteys->query($aiheHaku);
                    if ($aiheVastaus->num_rows > 0) {
                        while ($rivi = $aiheVastaus->fetch_assoc()) {
                            $selected = (isset($_POST['kategoria']) && $_POST['kategoria'] == $rivi['id']) ? ' selected' : '';
                            echo "<option value='{$rivi['id']}'{$selected}>{$rivi['name']}</option>";
                        }
                    } else {
                        echo '<option value="">Ei aiheita saatavilla</option>';
                    }
                ?>
            </select>
            <br><br>
        </form>
        <form action="pelaa.php" method="POST">
            <p>Valitse kysymysten määrä:</p>
            <input type="radio" id="peli1" name="peli" value="5" required>
            <label for="peli1">Lyhyt (5)</label><br>
            <input type="radio" id="peli2" name="peli" value="10" required>
            <label for="peli2">Keskipitkä (10)</label><br>  
            <input type="radio" id="peli3" name="peli" value="15" required>
            <label for="peli3">Pitkä (15)</label><br><br>
            <input type="submit" value="Aloita peli">
        </form>
        <br><br>
    </main>
    <footer>
        <p>&copy; Tietovisa, Markus Räisänen, JEDU - 2026.</p>
    </footer>
</body>
</html>

<?php
    $yhteys->close();
?>