<?php
// get_candidates.php
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

if (isset($_POST['kodeFPK'])) {
  $kodeFPK = $_POST['kodeFPK'];

  // Query untuk mengambil data kandidat berdasarkan kodeFPK
  $sql = "SELECT id_candidates, nama FROM applicants WHERE kodeFPK = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $kodeFPK);
  $stmt->execute();
  $result = $stmt->get_result();

  $candidates = [];
  while ($row = $result->fetch_assoc()) {
    $candidates[] = $row;
  }

  echo json_encode($candidates);

  $stmt->close();
}

$conn->close();
