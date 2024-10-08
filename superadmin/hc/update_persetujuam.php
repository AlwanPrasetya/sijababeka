<?php
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST['id'];
  $tglSuperadmin = date('Y-m-d'); // Mendapatkan tanggal hari ini dalam format YYYY-MM-DD

  // Start transaction
  $connection->begin_transaction();

  try {
    // Update status persetujuan, persetujuanSuperadmin, dan tglSuperadmin di tabel hcc
    $sql_hcc = "UPDATE hcc SET Status_Penyetujuan='Approved', persetujuanSuperadmin='Disetujui', tglSuperadmin=? WHERE fpk_selection=?";
    $stmt_hcc = $connection->prepare($sql_hcc);

    if (!$stmt_hcc) {
      throw new Exception("Error preparing statement for hcc: " . $connection->error);
    }

    $stmt_hcc->bind_param("ss", $tglSuperadmin, $id);

    if (!$stmt_hcc->execute()) {
      throw new Exception("Error executing hcc update: " . $stmt_hcc->error);
    }

    // Update status persetujuan di tabel persetujuan_hc
    $sql_persetujuan_hc = "UPDATE persetujuan_hc SET persetujuanSuperadmin='Disetujui' WHERE fpk_selection=?";
    $stmt_persetujuan_hc = $connection->prepare($sql_persetujuan_hc);

    if (!$stmt_persetujuan_hc) {
      throw new Exception("Error preparing statement for persetujuan_hc: " . $connection->error);
    }

    $stmt_persetujuan_hc->bind_param("s", $id);

    if (!$stmt_persetujuan_hc->execute()) {
      throw new Exception("Error executing persetujuan_hc update: " . $stmt_persetujuan_hc->error);
    }

    // Commit transaction
    $connection->commit();

    // Update status_penyetujuan in persetujuan_hc table from 'Pending' to 'Approved'
    $sql_update_status = "UPDATE persetujuan_hc SET status_penyetujuan='Approved' WHERE persetujuanSuperadmin='Disetujui' AND fpk_selection=?";
    $stmt_update_status = $connection->prepare($sql_update_status);

    if (!$stmt_update_status) {
      throw new Exception("Error preparing statement for updating status_penyetujuan: " . $connection->error);
    }

    $stmt_update_status->bind_param("s", $id);

    if (!$stmt_update_status->execute()) {
      throw new Exception("Error executing status_penyetujuan update: " . $stmt_update_status->error);
    }

    // Output JavaScript to alert success and refresh page
    echo "<script>
            alert('Persetujuan berhasil disetujui.');
            window.location.href = document.referrer;
          </script>";
  } catch (Exception $e) {
    // Rollback transaction
    $connection->rollback();
    echo "<script>
            alert('Terjadi kesalahan: " . addslashes($e->getMessage()) . "');
          </script>";
  }

  // Close statements
  if (isset($stmt_hcc)) {
    $stmt_hcc->close();
  }
  if (isset($stmt_persetujuan_hc)) {
    $stmt_persetujuan_hc->close();
  }
  if (isset($stmt_update_status)) {
    $stmt_update_status->close();
  }

  // Close connection
  $connection->close();
}
