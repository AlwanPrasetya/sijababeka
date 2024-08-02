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

  // Query untuk mengambil data dari tabel applicants, biodata_karyawan, fpk, dan hc berdasarkan id_candidates
  $sql = "
        SELECT 
            a.nama AS applicant_name, 
            a.tglLahir AS applicant_dob,
            b.no_ktp AS ktp_number, 
            b.nama_institusi_s3 AS nama_institusi_s3,
            b.nama_institusi_s2 AS nama_institusi_s2,
            b.nama_institusi_s1 AS nama_institusi_s1,
            b.nama_institusi_diploma AS nama_institusi_diploma,
            b.nama_institusi_sma AS nama_institusi_sma,
            b.nama_institusi_smp AS nama_institusi_smp,
            b.nama_institusi_sd AS nama_institusi_sd,
            b.referensi_kerja AS referensi_kerja,
            b.bpjs_ks AS bpjs_ks,
            b.bpjs_kg AS bpjs_kg,
            b.bpjs_jp AS bpjs_jp,
            b.foto_ktp AS foto_ktp,
            b.fc_ijazah AS fc_ijazah,
            b.fc_tn AS fc_tn,
            b.fc_bt AS fc_bt,
            b.fc_npwp AS fc_npwp,
            b.fc_kk AS fc_kk,
            b.fc_sp AS fc_sp,
            b.foto AS foto,
            f.requestFor AS request_for,
            h.form_interview_user AS file_interview_user,
            h.form_interview_hr AS file_interview_hr, 
            h.form_hasil_psikotest AS file_hasil_psikotest, 
            h.form_confirmation_letter AS confirmation_letter, 
            h.form_hasil_tes_kesehatan AS file_hasil_tes_kesehatan
        FROM 
            applicants a
        LEFT JOIN 
            biodata_karyawan b ON a.id_candidates = b.id_candidates
        LEFT JOIN 
            fpk f ON a.kodeFPK = f.kodeFPK
        LEFT JOIN 
            hcc h ON a.id_candidates = h.id_candidates AND h.fpk_selection = f.kodeFPK
        WHERE
            a.id_candidates = ?
    ";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $id_candidates);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Menentukan pendidikan berdasarkan institusi yang ada
    $education = [];

    if (!empty($row['nama_institusi_s3'])) {
      $education[] = "Strata 3";
    }
    if (!empty($row['nama_institusi_s2'])) {
      $education[] = "Strata 2";
    }
    if (!empty($row['nama_institusi_s1'])) {
      $education[] = "Strata 1 / Diploma 4";
    }
    if (!empty($row['nama_institusi_diploma'])) {
      $education[] = "Diploma 1/2/3";
    }
    if (!empty($row['nama_institusi_sma'])) {
      $education[] = "SMA";
    }
    if (!empty($row['nama_institusi_smp'])) {
      $education[] = "SMP";
    }
    if (!empty($row['nama_institusi_sd'])) {
      $education[] = "SD";
    }

    $row['education'] = implode(" / ", $education);

    // Hapus nilai institusi individual sebelum mengembalikan hasil
    unset($row['nama_institusi_s3']);
    unset($row['nama_institusi_s2']);
    unset($row['nama_institusi_s1']);
    unset($row['nama_institusi_diploma']);
    unset($row['nama_institusi_sma']);
    unset($row['nama_institusi_smp']);
    unset($row['nama_institusi_sd']);

    // Jika field file_interview_user belum terisi, set nilai default ke null
    if (empty($row['file_interview_user'])) {
      $row['file_interview_user'] = null;
    }

    echo json_encode($row);
  } else {
    echo json_encode(["error" => "No data found"]);
  }

  $stmt->close();
}

$conn->close();
