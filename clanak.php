<?php
include 'database.php';

define('UPLPATH', 'images/');

$id = $_GET['id'];

$query = "SELECT naslov, sazetak, tekst, slika, datum, kategorija FROM clanci WHERE id = $id";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vircek</title>
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

    <main id="article-main">
    <section id="article-section">
        <div>
            <p><?php echo $row['kategorija']; ?></p>
            <h2><?php echo $row['naslov']; ?></h2>
            <h3><?php echo $row['sazetak']; ?></h3>
            <img id="article-img" src="<?php echo UPLPATH . $row['slika']; ?>" alt="<?php echo $row['naslov']; ?>">
            <p><?php echo $row['tekst']; ?></p>
            <p id="datum"><?php echo $row['datum']; ?></p>
        </div>
    </section>
</main>
</body>
</html>