<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $lozinka = $_POST['lozinka'];

    $stmt = $dbc->prepare("SELECT id, lozinka, ime, razina FROM korisnik WHERE korisnicko_ime = ?");
    $stmt->bind_param('s', $korisnicko_ime);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_lozinka, $ime, $admin);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($lozinka, $hashed_lozinka)) {
            $_SESSION['korisnicko_ime'] = $korisnicko_ime;
            $_SESSION['ime'] = $ime;
            $_SESSION['razina'] = $admin;
            header('Location: administracija.php');
            exit;
        } else {
            echo "Pogrešna lozinka.";
        }
    } else {
        echo "Korisničko ime ne postoji. Registrirajte se na <a href='registracija.php'>poveznici</a>.";
    }

    $stmt->close();
    $dbc->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vircek - Login</title>
    <link rel="stylesheet" href="style-index.css">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/e2ba79ae34.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div>
        <img src="images/logo-transparent.png" alt="Logo Virceka">
        <h1 id="logo">Vircek</h1>
    </div>
    <nav>
        <ul>
            <li><a href="index.php" class="selected">Početna</a></li>
            <li>
                <div class="dropdown">
                    <button class="dropbtn">Kategorije
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="kategorija.php?kategorija=novo_kod_nas">Novo kod nas</a>
                        <a href="kategorija.php?kategorija=dogadanja">Događanja</a>
                        <a href="kategorija.php?kategorija=vijesti">Vijesti</a>
                    </div>
                </div>
            </li>
            <li><a href="galerija.html">Galerija</a></li>
            <li><a href="o-nama.html">O nama</a></li>
            <li><a href="kontakt.html">Kontakt</a></li>
            <li><a href="administracija.php">Administracija</a></li>
        </ul>
    </nav>
</header>

<h2>Prijava</h2>
<form method="post" action="login.php">
    Korisničko ime: <input type="text" name="korisnicko_ime" required><br>
    Lozinka: <input type="password" name="lozinka" required><br>
    <input type="submit" value="Prijavi se">
</form>

<footer>
    <p>Website: Tamara Rožman, 2024. Kontakt: tamci.rozman@gmail.com</p>
</footer>

</body>
</html>
