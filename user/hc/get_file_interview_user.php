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

// Memeriksa apakah data yang diperlukan telah dikirim melalui POST
if (isset($_POST['id_biodata'], $_POST['kodeFPK'])) {
  $id_biodata = $_POST['id_biodata'];
  $kodeFPK = $_POST['kodeFPK'];

  // Query untuk mengambil file_interview_user dari tabel hc
  $sql = "
        SELECT file_interview_user
        FROM hc
        WHERE id_biodata = ? AND kodeFPK = ?
    ";

  // Persiapkan statement SQL
  $stmt = $conn->prepare($sql);
  if ($stmt === false) {
    echo json_encode(["error" => "Prepare statement failed"]);
    exit();
  }

  // Bind parameter dan eksekusi statement
  $stmt->bind_param("ss", $id_biodata, $kodeFPK);
  $stmt->execute();

  // Mendapatkan hasil query
  $result = $stmt->get_result();

  // Jika data ditemukan, kirimkan sebagai JSON
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
  } else {
    echo json_encode(["error" => "No data found"]);
  }

  // Tutup statement
  $stmt->close();
}

// Tutup koneksi database
$conn->close();
