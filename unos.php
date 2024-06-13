<?php
include 'database.php';
$datum = date('Y-M-d');
$naslov = $_POST['naslov'];
$sazetak = $_POST['sazetak'];
$tekst = $_POST['tekst'];
$slika_name = $_FILES['slika']['name']; // Get the name of the uploaded image file
$slika_tmp = $_FILES['slika']['tmp_name']; // Get the temporary path of the uploaded image file
$kategorija = $_POST['kategorija'];
$arhiva = isset($_POST['prikaz']) ? 1 : 0;

// Define the directory where you want to store the uploaded images
$image_dir = 'images/'; // Replace with your desired directory path

// Move the uploaded image file to the specified directory
    move_uploaded_file($slika_tmp, $image_dir . $slika_name);

// Prepare the SQL query to insert the data
$query = "INSERT INTO clanci (datum, naslov, sazetak, tekst, slika, kategorija, arhiva)
VALUES ('$datum', '$naslov', '$sazetak', '$tekst', '$slika_name', '$kategorija', '$arhiva')";

if ($result = $dbc->query($query)) {
    echo '<h2>Uspješno odrađena promjena.</h2>
        <a href="administracija.php">Povratak na administraciju</a>';
} else {
    echo "Error: " . $dbc->error;
}
mysqli_close($dbc);
?>