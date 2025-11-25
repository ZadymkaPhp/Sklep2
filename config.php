<?php
// Połączenie z bazą MySQL
$connect = mysqli_connect("localhost", "root", "", "sklep_internetowy");

// Sprawdzenie, czy połączenie się udało
if (!$connect) {
    die("Błąd połączenia: " . mysqli_connect_error());
}

// Ustawienie kodowania na UTF-8
mysqli_set_charset($connect, "utf8");
?>
