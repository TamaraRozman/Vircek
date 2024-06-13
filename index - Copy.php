<?php include 'database.php'; ?>

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
    <link
        href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
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

    <main>
        <?php
        define('UPLPATH', 'images/');

        $query = "SELECT * FROM clanci WHERE kategorija='novo_kod_nas' LIMIT 3";
        $result = mysqli_query($dbc, $query);

        echo '<h2>Novo kod nas</h2><section>';
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                echo '<article title="Pročitaj više">
                <a href="clanak.php?id=' . $row['id'] . '">
                    <img src="' . UPLPATH . $row['slika'] . '">
                    <p>Objavljeno: ' . $row['datum'] . '</p>
                    <h3>' . $row['naslov'] . '</h3>
                    <p>' . $row['sazetak'] . '</p>
                </a>
            </article>';
            }
        } else {
            print ("Error: " . mysqli_error($dbc));
        }

        echo '</section>';
        ?>


        <?php

        $query = "SELECT * FROM clanci WHERE kategorija='dogadanja' LIMIT 3";
        $result = mysqli_query($dbc, $query);

        echo '<h2>Događanja</h2><section>';
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                echo '<article title="Pročitaj više">
                <a href="clanak.php?id=' . $row['id'] . '">
                    <img src="' . UPLPATH . $row['slika'] . '">
                    <h3>' . $row['naslov'] . '</h3>
                    <p>' . $row['sazetak'] . '</p>
                </a>
            </article>';
            }
        } else {
            print ("Error: " . mysqli_error($dbc));
        }

        echo '</section>';
        ?>

        <section class="social-media">
            <h4>Pratite nas na duštvenim mrežama:</h4>
            <a href="https://www.instagram.com/vircek_zagreb?fbclid=IwZXh0bgNhZW0CMTAAAR1A5bqKOryLadVtUdwNJ1AUUMI2Hgjypf81vAjjgpmWq3sEGezr_0O9YFA_aem_AaOQwN1Lhk0IpXgu__XrPz-NIr3adzyl-iPWfHLXvVTN02hV_erJEfJytYRcp9Kq1Ip5FHF-DnZGTeyJghHCuwkB"
                target="_blank"><i class="fa-brands fa-instagram fa-2xl"></i></a>
            <a href="https://www.facebook.com/profile.php?id=61553051833444" target="_blank"><i
                    class="fa-brands fa-facebook fa-2xl"></i></a>
        </section>
    </main>

    <footer>
        <p>Website: Tamara Rožman, 2024. Kontakt: tamci.rozman@gmail.com</p>
    </footer>
</body>

</html>