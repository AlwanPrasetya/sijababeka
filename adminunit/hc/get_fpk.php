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

  // Query untuk mengambil data dari tabel fpk, hanya jika level_candidates = 6 di tabel applicants
  $sql = "
    SELECT 
        f.golongan, 
        f.namaUnit, 
        f.jabatan, 
        f.organisasi  
    FROM 
        fpk f
    JOIN 
        applicants a ON f.kodeFPK = a.kodeFPK
    WHERE 
        f.kodeFPK = ? AND a.level_candidates = 6
  ";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $kodeFPK);
  $stmt->execute();
  $result = $stmt->get_result();

  // Periksa apakah ada data yang ditemukan
  if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data);
  } else {
    echo json_encode(["error" => "No valid data found"]);
  }
}

$conn->close();
