<?php
// Pastikan tombol submit ditekan
if (isset($_POST["submit"])) {
    // Direktori tempat menyimpan file
    $targetDirectory = "files/";

    // Simpan teks ke dalam file metadata.txt
    if (isset($_POST['textData']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['timeToSend'])) {
        $textData = $_POST['textData'];
        $timeToSend = strtotime($_POST['timeToSend']); // Mengubah string waktu menjadi timestamp
        $name = $_POST['name'];
        $email = $_POST['email'];

        // Format data
        $userData = "Name: $name\nEmail: $email\nTime to Send: $timeToSend\nText: $textData\n\n";

        // Menyimpan data ke dalam file metadata.txt
        file_put_contents($targetDirectory . 'metadata.txt', $userData, FILE_APPEND);

        echo "Data has been saved successfully.";
    } else {
        echo "Error: Form data not received.";
    }
}
