<?php
    // Muodosta yhteys tietokantaan.
    $yhteys = new mysqli("localhost", "root", "", "tietovisa");

    if ($yhteys->connect_error) {
        die("Yhteys epäonnistui: " . $yhteys->connect_error);
    }
?>