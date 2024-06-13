<?php include 'database.php'; ?>
<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vircek</title>
    <link rel="stylesheet" href="style-vijesti.css">
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
                <li><a href="index.php">Početna</a></li>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn selected">Kategorije
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
        <section>
            <?php
            define('UPLPATH', 'images/');

            // Check if kategorija is set in $_GET
            if (isset($_GET['kategorija'])) {
                $kategorija = mysqli_real_escape_string($dbc, $_GET['kategorija']); // Sanitize input
                $query = "SELECT * FROM clanci WHERE kategorija='$kategorija' AND arhiva=0";
                $result = mysqli_query($dbc, $query);

                if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                        echo '<article>';
                        echo '<a href="clanak.php?id=' . $row['id'] . '"><img src="' . UPLPATH . $row['slika'] . '" class="article-image"></a>'; // Adjust link to article
                        echo '<div class="article-text">';
                        echo '<h5>Objavljeno: ' . $row['datum'] . '</h5>'; // Added closing tag for <h5>
                        echo '<h3>' . $row['naslov'] . '</h3>';
                        echo '<p>' . $row['sazetak'] . '</p>';
                        echo '<a href="clanak.php?id=' . $row['id'] . '">Saznaj više...</a>';
                        echo '</div>';
                        echo '</article>';
                    }
                } else {
                    print ("Error: " . mysqli_error($dbc)); // Display MySQL error if query fails
                }
            } else {
                print ("Kategorija nije odabrana."); // Handle case where kategorija is not set in $_GET
            }
            ?>
        </section>
    </main>
</body>

</html>