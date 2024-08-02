<?php
// get_candidate_details.php
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

  // Query untuk mengambil data detail kandidat
  $sql = "
        SELECT 
            a.nama AS applicant_name, 
            a.tglLahir AS applicant_dob,
            b.no_ktp AS ktp_number, 
            b.nama_institusi_s1 AS s1_institution, 
            b.nama_fakultas_s1 AS s1_faculty,
            f.requestFor AS request_for
        FROM 
            applicants a
        JOIN 
            biodata_karyawan b ON a.id_candidates = b.id_candidates
        JOIN 
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

    // Cek kelengkapan data form aplikasi
    $form_aplikasi = "Tidak Lengkap"; // Default

    // Misalnya, cek apakah semua field yang diperlukan sudah terisi
    if (!empty($row['ktp_number']) && !empty($row['s1_institution']) && !empty($row['s1_faculty'])) {
      $form_aplikasi = "Lengkap";
    }

    // Tambahkan informasi kelengkapan form aplikasi ke dalam respons
    $row['form_aplikasi'] = $form_aplikasi;

    echo json_encode($row);
  } else {
    echo json_encode(["error" => "No data found"]);
  }

  $stmt->close();
}

$conn->close();
