<?php
// Periksa apakah metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Periksa apakah semua field telah diisi
  if (isset($_POST['id_candidates']) && isset($_POST['nama']) && isset($_POST['email']) && isset($_POST['wa']) && isset($_POST['tgl_lahir']) && isset($_POST['kodeFPK'])) {
    // Tangkap nilai dari formulir
    $id_candidates = $_POST['id_candidates'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $wa = $_POST['wa'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $kodeFPK = $_POST['kodeFPK']; // Tambahkan ini untuk mendapatkan nilai kodeFPK

    // Lakukan validasi data
    // Di sini Anda dapat menambahkan validasi tambahan sesuai kebutuhan

    // Proses penyimpanan data ke database
    // Ganti nilai $host, $username, $password, dan $database sesuai dengan konfigurasi MySQL Anda
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

    // Buat query untuk menyimpan data ke tabel applicants
    $queryApplicants = "INSERT INTO applicants (id_candidates, nama, email, wa, tglLahir, kodeFPK) VALUES ('$id_candidates', '$nama', '$email', '$wa', '$tgl_lahir', '$kodeFPK')";

    // Jalankan query applicants
    if ($connection->query($queryApplicants) === TRUE) {
      // Jika penyimpanan di tabel applicants berhasil, lanjutkan menyimpan ke tabel biodata_karyawan
      // Dapatkan ID yang baru saja dimasukkan
      $lastInsertId = $connection->insert_id;

      // Buat query untuk menyimpan data ke tabel biodata_karyawan
      $queryBiodata = "INSERT INTO biodata_karyawan (id_biodata, id_candidates, nama_lengkap, email, no_tlpn, tanggal_lahir) VALUES ('$lastInsertId', '$id_candidates', '$nama', '$email', '$wa', '$tgl_lahir')";

      // Jalankan query biodata_karyawan
      if ($connection->query($queryBiodata) === TRUE) {
        // Jika penyimpanan di tabel biodata_karyawan berhasil, lanjutkan menyimpan ke tabel multi_user
        $level = "candidates"; // sesuaikan dengan level yang diinginkan

        // Buat query untuk menyimpan data ke tabel multi_user
        $queryMultiUser = "INSERT INTO multi_user (username, nama, password, level, branch) VALUES ('$email', '$nama', '$wa', '$level', '$lastInsertId')";

        // Jalankan query multi_user
        if ($connection->query($queryMultiUser) === TRUE) {
          // Jika penyimpanan di tabel multi_user berhasil, tambahkan penyimpanan ke tabel hcc
          $queryHcc = "INSERT INTO hcc (fpk_selection, id_candidates, nama_kandidat, id_biodata) VALUES ('$kodeFPK', '$id_candidates', '$nama', '$lastInsertId')";

          if ($connection->query($queryHcc) === TRUE) {
            // Jika penyimpanan di tabel hcc berhasil, tambahkan penyimpanan ke tabel persetujuan_hc
            $queryPersetujuanHc = "INSERT INTO persetujuan_hc (fpk_selection) VALUES ('$kodeFPK')";

            if ($connection->query($queryPersetujuanHc) === TRUE) {
              // Jika penyimpanan di tabel persetujuan_hc berhasil, perbarui jumlah pelamar
              $queryGetApplicantsCount = "SELECT applicants FROM hiring_positions WHERE kodeFPK = '$kodeFPK'";
              $resultGetApplicantsCount = $connection->query($queryGetApplicantsCount);

              if ($resultGetApplicantsCount) {
                // Ambil jumlah pelamar saat ini
                $row = $resultGetApplicantsCount->fetch_assoc();
                $currentApplicantsCount = $row['applicants'];
                $newApplicantsCount = $currentApplicantsCount + 1;

                // Buat query untuk memperbarui jumlah pelamar di tabel hiring_positions
                $queryUpdateApplicantsCount = "UPDATE hiring_positions SET applicants = $newApplicantsCount WHERE kodeFPK = '$kodeFPK'";

                // Jalankan query untuk memperbarui jumlah pelamar
                if ($connection->query($queryUpdateApplicantsCount) === TRUE) {
                  // Jika berhasil, tampilkan pesan berhasil
                  echo "<script>alert('Data berhasil disimpan ke database.');</script>";
                  // Kembali ke halaman sebelumnya
                  echo "<script>window.location.replace(document.referrer);</script>";
                  // Reload halaman setelah kembali
                  echo "<script>location.reload();</script>";
                } else {
                  // Jika gagal, tampilkan pesan error
                  echo "Error updating applicants count: " . $connection->error;
                }
              } else {
                // Jika query untuk mendapatkan jumlah pelamar gagal, tampilkan pesan error
                echo "Error fetching applicants count: " . $connection->error;
              }
            } else {
              // Jika ada kesalahan saat menyimpan ke tabel persetujuan_hc, tampilkan pesan error
              echo "Error: " . $queryPersetujuanHc . "<br>" . $connection->error;
            }
          } else {
            // Jika ada kesalahan saat menyimpan ke tabel hcc, tampilkan pesan error
            echo "Error: " . $queryHcc . "<br>" . $connection->error;
          }
        } else {
          // Jika ada kesalahan saat menyimpan ke tabel multi_user, tampilkan pesan error
          echo "Error: " . $queryMultiUser . "<br>" . $connection->error;
        }
      } else {
        // Jika ada kesalahan saat menyimpan ke tabel biodata_karyawan, tampilkan pesan error
        echo "Error: " . $queryBiodata . "<br>" . $connection->error;
      }
    } else {
      // Jika ada kesalahan saat menyimpan ke tabel applicants, tampilkan pesan error
      echo "Error: " . $queryApplicants . "<br>" . $connection->error;
    }

    // Tutup koneksi
    $connection->close();
  } else {
    // Jika tidak semua field diisi, tampilkan pesan kesalahan
    echo "<script>alert('Semua field harus diisi!');</script>";
    // Kembali ke halaman sebelumnya
    echo "<script>window.location.replace(document.referrer);</script>";
    // Reload halaman setelah kembali
    echo "<script>location.reload();</script>";
  }
} else {
  // Jika metode yang digunakan bukan POST, tampilkan pesan kesalahan
  echo "<script>alert('Metode yang digunakan harus POST!'); history.back();</script>";
  // Kembali ke halaman sebelumnya
  echo "<script>window.location.replace(document.referrer);</script>";
  // Reload halaman setelah kembali
  echo "<script>location.reload();</script>";
}
