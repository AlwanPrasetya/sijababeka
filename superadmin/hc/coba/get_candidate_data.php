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

if (isset($_POST['id_candidates'])) {
  $id_candidates = $_POST['id_candidates'];

  // Query untuk mengambil data
  $sql = "
        SELECT 
            a.nama AS applicant_name, 
            a.tglLahir AS applicant_dob,
            b.no_ktp AS ktp_number, 
            CONCAT(b.nama_institusi_s1, ' - ', b.nama_fakultas_s1) AS education,
            f.requestFor AS request_for
        FROM 
            applicants a
        LEFT JOIN 
            biodata_karyawan b ON a.id_candidates = b.id_candidates
        LEFT JOIN 
            fpk f ON a.kodeFPK = f.kodeFPK
        WHERE
            a.id_candidates = ?
    ";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $id_candidates);
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
