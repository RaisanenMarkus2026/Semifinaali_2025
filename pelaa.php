<?php
session_start();
include 'yhteys.php';

$virhe = '';
$kysymys = null;
$kysymykset = $_SESSION['pelinKysymykset'] ?? [];
$kysymysNumero = $_SESSION['pelinKysymysNumero'] ?? 0;
$pisteet = $_SESSION['pelinPisteet'] ?? 0;
$kategoriaId = $_SESSION['valittuPeli'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['peli'])) {
    $kysymysMaara = is_scalar($_POST['peli'])
        ? filter_var($_POST['peli'], FILTER_VALIDATE_INT)
        : false;
    $valittuAihe = $_SESSION['valittuAihe'] ?? null;
    $kategoriaId = is_scalar($valittuAihe)
        ? filter_var($valittuAihe, FILTER_VALIDATE_INT)
        : false;

    if (!in_array($kysymysMaara, [5, 10, 15], true) || !$kategoriaId || $kategoriaId < 1) {
        $virhe = 'Valitse ensin aihealue ja kysymysten määrä.';
    } else {
        $_SESSION['valittuPeli'] = $kategoriaId;
        $kategoriaId = $_SESSION['valittuPeli'];
        $haku = $yhteys->prepare('SELECT id FROM questions WHERE category_id = ?');
        if (!$haku) {
            error_log('Kysymysten haku epäonnistui: ' . $yhteys->error);
            $virhe = 'Kysymysten lataaminen epäonnistui.';
        } else {
            $haku->bind_param('i', $kategoriaId);
            if (!$haku->execute()) {
                error_log('Kysymysten haku epäonnistui: ' . $haku->error);
                $virhe = 'Kysymysten lataaminen epäonnistui.';
            } else {
                $haku->bind_result($kysymysId);
                $kaikkiKysymysIdt = [];
                while ($haku->fetch()) {
                    $kaikkiKysymysIdt[] = (int) $kysymysId;
                }

                if (!$kaikkiKysymysIdt) {
                    $virhe = 'Valitussa aihealueessa ei ole vielä kysymyksiä.';
                } else {
                    shuffle($kaikkiKysymysIdt);
                    $_SESSION['pelinKysymykset'] = array_slice($kaikkiKysymysIdt, 0, $kysymysMaara);
                    $_SESSION['pelinKysymysNumero'] = 0;
                    $_SESSION['pelinPisteet'] = 0;
                    $kysymykset = $_SESSION['pelinKysymykset'];
                    $kysymysNumero = 0;
                    $pisteet = 0;
                }
            }
            $haku->close();
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vastaus'])) {
    $vastaus = is_scalar($_POST['vastaus']) ? strtoupper((string) $_POST['vastaus']) : '';
    $postKysymysId = $_POST['kysymys_id'] ?? null;
    $vastattuKysymysId = is_scalar($postKysymysId)
        ? filter_var($postKysymysId, FILTER_VALIDATE_INT)
        : false;

    if (
        !is_array($kysymykset)
        || !isset($kysymykset[$kysymysNumero])
        || !$vastattuKysymysId
        || $vastattuKysymysId !== (int) $kysymykset[$kysymysNumero]
        || !in_array($vastaus, ['A', 'B', 'C', 'D'], true)
    ) {
        $virhe = 'Vastausta ei voitu käsitellä. Päivitä sivu ja yritä uudelleen.';
    } else {
        $haku = $yhteys->prepare('SELECT correct_option FROM questions WHERE id = ? AND category_id = ?');
        if (!$haku) {
            error_log('Vastauksen tarkistus epäonnistui: ' . $yhteys->error);
            $virhe = 'Vastauksen tarkistaminen epäonnistui.';
        } else {
            $haku->bind_param('ii', $vastattuKysymysId, $kategoriaId);
            if (!$haku->execute()) {
                error_log('Vastauksen tarkistus epäonnistui: ' . $haku->error);
                $virhe = 'Vastauksen tarkistaminen epäonnistui.';
            } else {
                $haku->bind_result($oikeaVastaus);
                if ($haku->fetch()) {
                    if ($vastaus === strtoupper($oikeaVastaus)) {
                        $_SESSION['pelinPisteet'] = ++$pisteet;
                    }
                    $_SESSION['pelinKysymysNumero'] = ++$kysymysNumero;
                } else {
                    $virhe = 'Kysymystä ei löytynyt valitusta aihealueesta.';
                }
            }
            $haku->close();
        }
    }
}

$kysymykset = $_SESSION['pelinKysymykset'] ?? [];
$kysymysNumero = $_SESSION['pelinKysymysNumero'] ?? 0;
$pisteet = $_SESSION['pelinPisteet'] ?? 0;
$kategoriaId = $_SESSION['valittuPeli'] ?? 0;
$kysymyksiaYhteensa = is_array($kysymykset) ? count($kysymykset) : 0;

if ($virhe === '' && $kysymysNumero < $kysymyksiaYhteensa) {
    $nykyinenKysymysId = (int) $kysymykset[$kysymysNumero];
    $haku = $yhteys->prepare(
        'SELECT question, option_a, option_b, option_c, option_d
         FROM questions
         WHERE id = ? AND category_id = ?'
    );

    if (!$haku) {
        error_log('Kysymyksen lataaminen epäonnistui: ' . $yhteys->error);
        $virhe = 'Kysymyksen lataaminen epäonnistui.';
    } else {
        $haku->bind_param('ii', $nykyinenKysymysId, $kategoriaId);
        if (!$haku->execute()) {
            error_log('Kysymyksen lataaminen epäonnistui: ' . $haku->error);
            $virhe = 'Kysymyksen lataaminen epäonnistui.';
        } else {
            $haku->bind_result($teksti, $vaihtoehtoA, $vaihtoehtoB, $vaihtoehtoC, $vaihtoehtoD);
            if ($haku->fetch()) {
                $kysymys = [
                    'id' => $nykyinenKysymysId,
                    'teksti' => $teksti,
                    'vaihtoehdot' => [
                        'A' => $vaihtoehtoA,
                        'B' => $vaihtoehtoB,
                        'C' => $vaihtoehtoC,
                        'D' => $vaihtoehtoD,
                    ],
                ];
            } else {
                $virhe = 'Kysymystä ei löytynyt valitusta aihealueesta.';
            }
        }
        $haku->close();
    }
}

$esc = static fn($arvo) => htmlspecialchars((string) $arvo, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="munTyyli.css">
    <title>Taitaja Tietotesti - Pelaa</title>
</head>
<body>
    <header>
        <h1>TAITAJA TIETOTESTI</h1>
        <a href="login.php">Kirjaudu sisään</a>
    </header>
    <main>
        <?php if ($virhe !== ''): ?>
            <p class="game-message" role="alert"><?= $esc($virhe) ?></p>
            <a class="game-link" href="aloitaPeli.php">Takaisin pelin aloitukseen</a>
        <?php elseif ($kysymys !== null): ?>
            <div>
                <p>Kysymys <?= $kysymysNumero + 1 ?>/<?= $kysymyksiaYhteensa ?></p>
                <p>Pisteet: <?= (int) $pisteet ?></p>
            </div>
            <h2><?= $esc($kysymys['teksti']) ?></h2>
            <form method="post" action="pelaa.php">
                <fieldset>
                    <legend>Valitse vastaus</legend>
                    <?php foreach ($kysymys['vaihtoehdot'] as $kirjain => $vaihtoehto): ?>
                        <label>
                            <input type="radio" name="vastaus" value="<?= $kirjain ?>" required>
                            <span><?= $esc($vaihtoehto) ?></span>
                        </label>
                    <?php endforeach; ?>
                </fieldset>
                <input type="hidden" name="kysymys_id" value="<?= (int) $kysymys['id'] ?>">
                <button type="submit">Vastaa</button>
            </form>
        <?php elseif ($kysymyksiaYhteensa > 0 && $kysymysNumero >= $kysymyksiaYhteensa): ?>
            <div>
                <p>Peli päättyi</p>
                <p>Pisteet: <?= (int) $pisteet ?>/<?= $kysymyksiaYhteensa ?></p>
            </div>
            <a href="aloitaPeli.php">Pelaa uudelleen</a>
        <?php else: ?>
            <p>Aloita peli valitsemalla aihealue ja kysymysten määrä.</p>
            <a href="aloitaPeli.php">Aloita peli</a>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; Tietovisa, Markus Räisänen, JEDU - 2026.</p>
    </footer>
</body>
</html>
<?php
    $yhteys->close();
?>
