<?php
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
  // Query untuk mengambil data FPK berdasarkan kodeFPK
  $sql = "
    SELECT 
        golongan,
        branch,
        jabatan,
        organisasi
    FROM 
        fpk 
    WHERE
        kodeFPK = ?
  ";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $kodeFPK);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
  } else {
    echo json_encode(["error" => "No data found"]);
  }

  $stmt->close();
}

$conn->close();
