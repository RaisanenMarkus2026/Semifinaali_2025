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

        <label for="ope">Opettaja:</label><br><br>
        <select name="ope" id="ope" required>
            <option value="" selected disable>Valitse opettaja</option>
            <option value="ope1">Matti</option>
            <option value="ope2">Teppo</option>
            <option value="ope3">Kusti</option>
            <option value="ope4">Jutta</option>
        </select>
        <br><br> 

        <label for="kategoria">Kategoria:</label><br><br>
        <select name="kategoria" id="kategoria" required>
            <option value="" selected disable>Valitse aihealue</option>
            <option value="aihe1">Maantieto</option>
            <option value="aihe2">Historia</option>
            <option value="aihe3">Matematiikka</option>
            <option value="aihe4">Luonto ja ympäristö</option>
        </select> 

        <form action="" method="POST">
            <p>Valitse kysymysten määrä:</p>
            <input type="radio" id="peli1" name="peli" value="5">
            <label for="peli1">Lyhyt (5)</label><br>
            <input type="radio" id="peli2" name="peli" value="10">
            <label for="peli2">Keskipitkä (10)</label><br>  
            <input type="radio" id="peli3" name="peli" value="15">
            <label for="peli3">Pitkä (15)</label><br><br>
            <input type="submit" value="Aloita peli" id="pelaaNappi">
            <script>
            document.getElementById("pelaaNappi").addEventListener("click", myFunction);  
            function myFunction() {  
                window.location.href="pelaa.php";  
            }
        </script>
        </form>
    </main>

</body>
</html>