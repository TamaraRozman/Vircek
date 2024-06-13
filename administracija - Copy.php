<?php 
session_start();
include 'database.php';

if (!isset($_SESSION['korisnicko_ime'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['razina']==1) {
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $query = "DELETE FROM clanci WHERE id = ?";
        $stmt = $dbc->prepare($query);
        $stmt->bind_param('i', $delete_id);
        $stmt->execute();
        $stmt->close();
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_POST['update'])) {
        $edit_id = $_POST['id'];
        $naslov = $_POST['naslov'];
        $sazetak = $_POST['sazetak'];
        $tekst = $_POST['tekst'];
        $slika_name = $_FILES['slika_name']['name'];
        $slika_tmp = $_FILES['slika_name']['tmp_name'];
        $kategorija = $_POST['kategorija'];
        $arhiva = isset($_POST['arhiva']) ? 1 : 0;

        if (!empty($slika_name)) {
            $target_dir = 'images/' . $slika_name;
            move_uploaded_file($slika_tmp, $target_dir);
        } else {
            $query = "SELECT slika FROM clanci WHERE id = ?";
            $stmt = $dbc->prepare($query);
            $stmt->bind_param('i', $edit_id);
            $stmt->execute();
            $stmt->bind_result($slika_name);
            $stmt->fetch();
            $stmt->close();
        }

        // Update article in database
        $query = "UPDATE clanci SET naslov=?, sazetak=?, tekst=?, slika=?, kategorija=?, arhiva=? WHERE id=?";
        $stmt = $dbc->prepare($query);
        $stmt->bind_param('sssssii', $naslov, $sazetak, $tekst, $slika_name, $kategorija, $arhiva, $edit_id);
        if ($stmt->execute()) {
            echo '<h2>Uspješno odrađena promjena.</h2><a href="' . $_SERVER['PHP_SELF'] . '">Povratak na administraciju</a>';
        } else {
            echo '<h2>Greška pri ažuriranju.</h2>';
        }
        $stmt->close();
        exit;
    }
}
else{
    echo '<h1>Nemate pristup ovoj stranici</h1><br><a href="login.php">Povratak na prijavu</a>';
}
    // Fetch all articles
    $query = "SELECT * FROM clanci";
    $result = mysqli_query($dbc, $query);
    if (!$result) {
        die('Error querying database.');
    }

?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vircek - admin</title>
    <link rel="stylesheet" href="style-administracija.css">
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
                <li><a href="index.php">Početna</a></li>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Kategorije<i class="fa-solid fa-chevron-down"></i></button>
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
                <li><a href="administracija.html" class="selected">Administracija</a></li>
                <form action="logout.php" method="post">
        <input type="submit" value="Odjava">
    </form>
            </ul>
        </nav>
    </header>
    <main>
        <?php
        $query = "SELECT * FROM clanci";
        $result = mysqli_query($dbc, $query);
        define('UPLPATH', 'images/');
        echo '
        <a href="unos.html" id="btn-link"><button id="dodaj-button">+ Dodaj novi članak</button></a>
        <table border="1">';
        echo '<tr>
        <th>Naslov</th>
        <th>Kratki sažetak</th>
        <th>Tekst</th>
        <th>Slika</th>
        <th>Kategorija</th>
        <th>Arhiva</th>
        <th>Akcije</th>
      </tr>';

        while ($row = mysqli_fetch_array($result)) {
            echo '<tr>
            <form enctype="multipart/form-data" action="skripta.php" method="POST">
            <td>
                <input type="text" name="naslov" class="form-field-textual" value="' . $row['naslov'] . '">
            </td>
            <td>
                <textarea name="sazetak" cols="30" rows="10" class="form-field-textual">' . $row['sazetak'] . '</textarea>
            </td>
            <td>
                <textarea name="tekst" cols="30" rows="10" class="form-field-textual">' . $row['tekst'] . '</textarea>
            </td>
            <td>
                <input type="file" class="input-text" id="slika" value="' . $row['slika'] . '" name="slika_name" /> <br>
                <img src="' . UPLPATH . $row['slika'] . '" id="slika">
            </td>
            <td>
                <select name="kategorija" class="form-field-textual" value="' . $row['kategorija'] . '">
                    <option value="novo_kod_nas" ' . ($row['kategorija'] == 'novo_kod_nas' ? ' selected' : '') . '>Novo kod nas</option>
                    <option value="dogadaji" ' . ($row['kategorija'] == 'dogadaji' ? ' selected' : '') . '>Događaji</option>
                    <option value="vijesti" ' . ($row['kategorija'] == 'vijesti' ? ' selected' : '') . '>Vijesti</option>
                </select>
            </td>
            <td>
                <input type="checkbox" name="arhiva" id="arhiva"' . ($row['arhiva'] == 1 ? ' checked' : '') . ' /> Arhiviraj?
            </td>
            <td id="akcije">
                    <input type="hidden" name="id" class="form-field-textual" value="' . $row['id'] . '">
                    <button type="reset" value="Poništi" id="reset-btn">Poništi</button>
                    <button type="submit" name="update" value="Prihvati" id="update-btn">Izmjeni</button>
                    <button type="submit" name="delete" value="Izbriši" id="delete-btn">Izbriši</button>
                </form>
            </td>
          </tr>';
        }

        echo '</table>';
        
        ?>
        </table>
    </main>
    <footer>
        <p>Website: Tamara Rožman, 2024. Kontakt: tamci.rozman@gmail.com</p>
    </footer>
</body>
</html>
