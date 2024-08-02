<?php
// Konfigurasi database
$host = "localhost";
$username = "alwan"; // Ganti dengan username MySQL Anda
$password = "root"; // Ganti dengan password MySQL Anda
$database = "db_sijababeka"; // Ganti dengan nama database Anda

// Buat koneksi ke database
$connection = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($connection->connect_error) {
  die("Koneksi ke database gagal: " . $connection->connect_error);
}

// Ambil nilai id_biodata dan kodeFPK dari form
$id_biodata = isset($_POST['id_biodata']) ? $_POST['id_biodata'] : '';
// $kodeFPK = isset($_POST['kodeFPK']) ? $_POST['kodeFPK'] : '';
$target_dir = "unggah-adminunit/";

// Fungsi untuk mengunggah file dan mengembalikan nama file yang diunggah
function uploadFile($file_input_name, $target_dir)
{
  global $connection;
  $fileTmpPath = $_FILES[$file_input_name]['tmp_name'];
  $fileName = $_FILES[$file_input_name]['name'];
  $fileSize = $_FILES[$file_input_name]['size'];
  $fileType = $_FILES[$file_input_name]['type'];
  $fileNameCmps = explode(".", $fileName);
  $fileExtension = strtolower(end($fileNameCmps));

  // Generate nama file unik untuk menghindari nama yang sama
  $newFileName = uniqid() . '.' . $fileExtension;

  $allowedExtensions = array('jpg', 'jpeg', 'png', 'pdf'); // Sesuaikan dengan jenis file yang diizinkan

  if (in_array($fileExtension, $allowedExtensions)) {
    $uploadFileDir = $target_dir;
    $dest_path = $uploadFileDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $dest_path)) {
      return $newFileName; // Mengembalikan nama file jika berhasil diunggah
    } else {
      return null; // Mengembalikan null jika gagal diunggah
    }
  } else {
    return null; // Mengembalikan null jika jenis file tidak diizinkan
  }
}

// Fungsi untuk mengunggah semua file dan mengembalikan true jika berhasil
function uploadAllFiles($target_dir, $id_biodata, $connection)
{
  // Unggah file satu per satu
  $file_interview_user = uploadFile('file_interview_user', $target_dir);
  $file_interview_hr = uploadFile('file_interview_hr', $target_dir);
  $file_hasil_psikotest = uploadFile('file_hasil_psikotest', $target_dir);
  $confirmation_letter = uploadFile('confirmation_letter', $target_dir);
  $file_hasil_tes_kesehatan = uploadFile('file_hasil_tes_kesehatan', $target_dir);

  // Lakukan query untuk mengecek apakah sudah ada data dengan id_biodata yang sama
  $query = "SELECT * FROM hcc WHERE id_biodata = ?";
  $stmt = $connection->prepare($query);
  $stmt->bind_param("s", $id_biodata);
  $stmt->execute();
  $result = $stmt->get_result();

  // Jika sudah ada, update baris tersebut
  if ($result->num_rows > 0) {
    $query_update = "UPDATE hcc SET 
                            file_interview_user = COALESCE(?, file_interview_user),
                            file_interview_hr = COALESCE(?, file_interview_hr),
                            file_hasil_psikotest = COALESCE(?, file_hasil_psikotest),
                            confirmation_letter = COALESCE(?, confirmation_letter),
                            file_hasil_tes_kesehatan = COALESCE(?, file_hasil_tes_kesehatan)
                        WHERE id_biodata = ?";
    $stmt_update = $connection->prepare($query_update);
    $stmt_update->bind_param("ssssss", $file_interview_user, $file_interview_hr, $file_hasil_psikotest, $confirmation_letter, $file_hasil_tes_kesehatan, $id_biodata);

    if ($stmt_update->execute()) {
      echo "Data berhasil diperbarui di database.";
      return true;
    } else {
      echo "Error: " . $query_update . "<br>" . $connection->error;
    }

    $stmt_update->close();
  } else {
    echo "Data tidak ditemukan untuk diperbarui.";
  }

  $stmt->close();

  return false;
}

// Panggil fungsi untuk mengunggah semua file
uploadAllFiles($target_dir, $id_biodata, $connection);

// Tutup koneksi
$connection->close();
