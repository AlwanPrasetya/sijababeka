<?php
// Database connection
$servername = "localhost";
$username = "alwan";
$password = "root";
$dbname = "db_sijababeka";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['kodeFPK'])) {
  $kodeFPK = $_GET['kodeFPK'];
  $sql = "SELECT golongan, branch, jabatan, organisasi  FROM fpk WHERE kodeFPK = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $kodeFPK);
  $stmt->execute();
  $result = $stmt->get_result();
  $data = $result->fetch_assoc();

  echo json_encode($data);
}

$conn->close();
