<?php
// Konfigurasi database
$servername = "localhost";
$username = "alwan";
$password = "root";
$dbname = "db_sijababeka";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil semua kandidat
$sql = "SELECT id_candidates, nama FROM applicants";
$result = $conn->query($sql);

$candidates = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $candidates[] = $row;
  }
}

echo json_encode($candidates);

$conn->close();
