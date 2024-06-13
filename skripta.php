<?php
include 'database.php';
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $naslov = $_POST['naslov'];
    $sazetak = $_POST['sazetak'];
    $tekst = $_POST['tekst'];
    $kategorija = $_POST['kategorija'];
    $arhiva = isset($_POST['arhiva']) ? 1 : 0;

    // Handle file upload
    $slika_name = $_FILES['slika_name']['name'];
    $target_dir = 'images/' . $slika_name;

    if ($slika_name) {
        move_uploaded_file($_FILES['slika_name']['tmp_name'], $target_dir);
    } else {
        // If no new file is uploaded, keep the current image
        $query = "SELECT slika FROM clanci WHERE id=$id";
        $result = mysqli_query($dbc, $query);
        $row = mysqli_fetch_assoc($result);
        $slika_name = $row['slika'];
    }

    // Update the database
    $query = "UPDATE clanci SET naslov='$naslov', sazetak='$sazetak', tekst='$tekst', slika='$slika_name', kategorija='$kategorija', arhiva='$arhiva' WHERE id=$id";
    $result = mysqli_query($dbc, $query);

    if ($result) {
        echo '<h2>Uspješno odrađena promjena.</h2>
        <a href="administracija.php">Povratak na administraciju</a>';
    } else {
        echo '<h2>Greška pri ažuriranju.</h2>';
    }
}

// Handle form submission for delete
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM clanci WHERE id=$id";
    $result = mysqli_query($dbc, $query);

    if ($result) {
        echo '<h2>Uspješno obrisan članak.</h2>
        <a href="administracija.php">Povratak na administraciju</a>';
    } else {
        echo '<h2>Greška pri brisanju.</h2>';
    }
}
?>