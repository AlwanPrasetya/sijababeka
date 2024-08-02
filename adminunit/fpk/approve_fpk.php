<?php
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Mendapatkan ID FPK dari data POST
  $id_fpk = $_POST['id'];

  // Lakukan query untuk mendapatkan kodeFPK pegawai dari tabel fpk
  $sql_select_kodeFPK = "SELECT kodeFPK FROM fpk WHERE id_fpk = ?";
  $stmt_select_kodeFPK = $connection->prepare($sql_select_kodeFPK);
  $stmt_select_kodeFPK->bind_param("i", $id_fpk);
  $stmt_select_kodeFPK->execute();
  $result_select_kodeFPK = $stmt_select_kodeFPK->get_result();

  if ($result_select_kodeFPK->num_rows > 0) {
    // Ambil nilai kodeFPK pegawai
    $row = $result_select_kodeFPK->fetch_assoc();
    $kodeFPK = $row['kodeFPK'];

    // Lakukan query untuk memeriksa apakah sudah ada nilai kodeFPK di tabel persetujuan
    $sql_check_employee = "SELECT ID FROM persetujuan WHERE kodeFPK = ?";
    $stmt_check_employee = $connection->prepare($sql_check_employee);
    $stmt_check_employee->bind_param("s", $kodeFPK);
    $stmt_check_employee->execute();
    $result_check_employee = $stmt_check_employee->get_result();

    if ($result_check_employee->num_rows > 0) {
      // Jika sudah ada, lakukan pembaruan nilai persetujuanadmin jika persetujuanAtasan juga disetujui
      $sql_update_persetujuan = "UPDATE persetujuan 
                                       SET persetujuanAdmin = 'Disetujui' 
                                       WHERE kodeFPK = ? 
                                       AND PersetujuanAtasan = ''";
      $stmt_update_persetujuan = $connection->prepare($sql_update_persetujuan);
      $stmt_update_persetujuan->bind_param("s", $kodeFPK);

      if ($stmt_update_persetujuan->execute()) {
        // Periksa apakah pembaruan berhasil
        if ($stmt_update_persetujuan->affected_rows > 0) {
          // Perbarui status_penyetujuan jika kedua persetujuan sudah disetujui
          $sql_update_status = "UPDATE persetujuan 
                                          SET Status_Penyetujuan = 'Pending' 
                                          WHERE kodeFPK = ? 
                                          AND PersetujuanAtasan = 'Disetujui' 
                                          AND persetujuanAdmin = 'Disetujui'";
          $stmt_update_status = $connection->prepare($sql_update_status);
          $stmt_update_status->bind_param("s", $kodeFPK);

          if ($stmt_update_status->execute()) {
            // Jika status_penyetujuan berhasil diperbarui, lakukan pembaruan di tabel fpk
            $sql_update_fpk = "UPDATE fpk 
                                           SET persetujuanAdmin = 'Disetujui' 
                                           WHERE id_fpk = ?";
            $stmt_update_fpk = $connection->prepare($sql_update_fpk);
            $stmt_update_fpk->bind_param("i", $id_fpk);

            if ($stmt_update_fpk->execute()) {
              // Set tanggal Admin jika persetujuan HR Unit disetujui
              if ($stmt_update_fpk->affected_rows > 0) {
                $today = date("Y-m-d"); // Ambil tanggal hari ini

                // Update field tglAdmin di tabel fpk
                $sql_update_tgl_admin = "UPDATE fpk SET tglAdmin = ? WHERE id_fpk = ?";
                $stmt_update_tgl_admin = $connection->prepare($sql_update_tgl_admin);
                $stmt_update_tgl_admin->bind_param("si", $today, $id_fpk);

                if ($stmt_update_tgl_admin->execute()) {
                  echo "success";
                } else {
                  echo "error_update_tgl_admin";
                }

                // Tutup statement pembaruan tgladmin
                $stmt_update_tgl_admin->close();
              }
            } else {
              echo "error_update_fpk";
            }

            // Tutup statement pembaruan fpk
            $stmt_update_fpk->close();
          } else {
            echo "error_update_status";
          }

          // Tutup statement pembaruan status_penyetujuan
          $stmt_update_status->close();
        } else {
          // Jika persetujuanadmin tidak diupdate karena persetujuanAtasan belum disetujui
          echo "error_persetujuanAtasan_belum_disetujui";
        }
      } else {
        echo "error_update_persetujuan";
      }

      // Tutup statement pembaruan persetujuanadmin
      $stmt_update_persetujuan->close();
    } else {
      // Jika belum ada, tambahkan baris baru dengan kodeFPK tersebut
      $sql_insert_persetujuan = "INSERT INTO persetujuan (kodeFPK, PersetujuanAdmin, PersetujuanAdmin, PersetujuanAtasan, PersetujuanDireksi2, PersetujuanDireksi3, PersetujuanPresdir, PersetujuanCorpHr, PersetujuanSuperadmin, Status_Penyetujuan) 
                                       VALUES (?, 'Disetujui', '', '', '', '', '', '', '', 'Pending')";
      $stmt_insert_persetujuan = $connection->prepare($sql_insert_persetujuan);
      $stmt_insert_persetujuan->bind_param("s", $kodeFPK);

      if ($stmt_insert_persetujuan->execute()) {
        // Jika penambahan berhasil, lakukan pembaruan di tabel fpk
        $sql_update_fpk = "UPDATE fpk SET persetujuanAdmin = 'Disetujui' WHERE id_fpk = ?";
        $stmt_update_fpk = $connection->prepare($sql_update_fpk);
        $stmt_update_fpk->bind_param("i", $id_fpk);

        if ($stmt_update_fpk->execute()) {
          // Set tanggal admin jika persetujuan HR Unit disetujui
          if ($stmt_update_fpk->affected_rows > 0) {
            $today = date("Y-m-d"); // Ambil tanggal hari ini

            // Update field tglAdmin di tabel fpk
            $sql_update_tgl_admin = "UPDATE fpk SET tglAdmin = ? WHERE id_fpk = ?";
            $stmt_update_tgl_admin = $connection->prepare($sql_update_tgl_admin);
            $stmt_update_tgl_admin->bind_param("si", $today, $id_fpk);

            if ($stmt_update_tgl_admin->execute()) {
              echo "success";
            } else {
              echo "error_update_tgl_admin";
            }

            // Tutup statement pembaruan tgladmin
            $stmt_update_tgl_admin->close();
          }
        } else {
          echo "error_update_fpk";
        }

        // Tutup statement pembaruan fpk
        $stmt_update_fpk->close();
      } else {
        echo "error_insert_persetujuan";
      }

      // Tutup statement penambahan baris baru di tabel persetujuan
      $stmt_insert_persetujuan->close();
    }

    // Tutup statement pengecekan kodeFPK di tabel persetujuan
    $stmt_check_employee->close();
  } else {
    echo "error_select_kodeFPK";
  }

  // Tutup statement mendapatkan kodeFPK pegawai dari tabel fpk
  $stmt_select_kodeFPK->close();
}

// Menutup koneksi database
$connection->close();
