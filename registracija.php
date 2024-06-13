<?php
include 'database.php'; // Ensure this file includes your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $lozinka = password_hash($_POST['lozinka'], PASSWORD_BCRYPT);
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $lozinka_potvrda = $_POST['lozinka_potvrda'];
    $razina = 0;

    if ($_POST['lozinka'] != $_POST['lozinka_potvrda']) {
        echo "Lozinke se ne podudaraju. Molimo unesite ih ponovno.";
    } else {
        // Prepare the SQL statement
        $stmt = $dbc->prepare("INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES (?, ?, ?, ?, ?)");
        
        // Bind parameters
        $stmt->bind_param('ssssi', $ime, $prezime, $korisnicko_ime, $lozinka, $razina);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo '<h2>Uspješno odrađena registracija.</h2>
            <a href="login.php">Prijavite se ovdje</a>';
        } else {
            echo "Greška prilikom registracije: " . $stmt->error;
        }
        
        // Close statement and database connection
        $stmt->close();
        $dbc->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vircek - Registracija</title>
    <link rel="stylesheet" href="style-index.css">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/e2ba79ae34.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
</head>

<body>

    <header>
        <div>
            <img src="images/logo-transparent.png" alt="Logo Virceka">
            <h1 id="logo">Vircek - Registracija</h1>
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
    <h2>Registracija</h2>
    <form method="post" action="registracija.php">
        Korisničko ime: <input type="text" name="korisnicko_ime" required><br>
        Lozinka: <input type="password" name="lozinka" required><br>
        Potvrdite lozinku: <input type="password" name="lozinka_potvrda" required><br>
        Ime: <input type="text" name="ime"><br>
        Prezime: <input type="text" name="prezime"><br>
        <input type="submit" value="Registriraj se">
    </form>

</body>

</html>
