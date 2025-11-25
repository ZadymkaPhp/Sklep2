<?php
// Dołączenie konfiguracji
require_once 'config.php';

// Sprawdzenie połączenia
if (!$connect) {
    die("Błąd połączenia z bazą: " . mysqli_connect_error());
}

// Sprawdzenie POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Błąd: Tylko formularz!'); window.location.href='formularz.html';</script>";
    exit();
}

// Pobranie danych
$imie     = isset($_POST['imie']) ? trim($_POST['imie']) : '';
$nazwisko = isset($_POST['nazwisko']) ? trim($_POST['nazwisko']) : '';
$miasto   = isset($_POST['miasto']) ? trim($_POST['miasto']) : '';
$telefon  = isset($_POST['telefon']) ? trim($_POST['telefon']) : '';
$email    = isset($_POST['email']) ? trim($_POST['email']) : '';

// Walidacja imienia
if (empty($imie) || strlen($imie) > 30) {
    echo "<script>alert('Imię: 1-30 znaków'); history.back();</script>";
    exit();
}

// Walidacja nazwiska
if (empty($nazwisko) || strlen($nazwisko) > 40) {
    echo "<script>alert('Nazwisko: 1-40 znaków'); history.back();</script>";
    exit();
}

// Walidacja miasta
if (empty($miasto) || strlen($miasto) > 30) {
    echo "<script>alert('Miasto: 1-30 znaków'); history.back();</script>";
    exit();
}

// Walidacja telefonu
if (!preg_match('/^[0-9]{9}$/', $telefon)) {
    echo "<script>alert('Telefon: 9 cyfr'); history.back();</script>";
    exit();
}

// Walidacja emaila
if (empty($email) || strlen($email) > 50 || strpos($email, '@') === false) {
    echo "<script>alert('Email: 1-50 znaków, zawiera @'); history.back();</script>";
    exit();
}

// INSERT do bazy
$sql = "INSERT INTO klient (imie, nazwisko, miasto, telefon, email) VALUES ('$imie', '$nazwisko', '$miasto', '$telefon', '$email')";

if (!$connect->query($sql)) {
    echo "<script>alert('Błąd bazy: " . addslashes($connect->error) . "'); history.back();</script>";
    exit();
}

// Pobranie ID nowego klienta
$id_klienta = $connect->insert_id;
$connect->close();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styl.css">
    <title>Potwierdzenie rejestracji</title>
</head>
<body>
    <div class="kontener">
        <h1>Dane zapisane poprawnie!</h1>
        
        <h2>Informacje o kliencie:</h2>
        <p><b>ID:</b> <?= ($id_klienta) ?></p>
        <p><b>Imię:</b> <?= ($imie) ?></p>
        <p><b>Nazwisko:</b> <?= ($nazwisko) ?></p>
        <p><b>Miasto:</b> <?= ($miasto) ?></p>
        <p><b>Telefon:</b> <?= ($telefon) ?></p>
        <p><b>Email:</b> <?= ($email) ?></p>
        
        <a href="formularz.html">← Wróć do formularza</a>
    </div>
</body>
</html>
