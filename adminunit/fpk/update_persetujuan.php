<?php
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Start transaction
    $connection->begin_transaction();

    try {
        // Update status persetujuan dan persetujuanAdmin di tabel hcc
        $sql_hcc = "UPDATE hcc SET Status_Penyetujuan='Approved', persetujuanAdmin='Disetujui' WHERE fpk_selection=?";
        $stmt_hcc = $connection->prepare($sql_hcc);
        $stmt_hcc->bind_param("s", $id);

        if (!$stmt_hcc->execute()) {
            throw new Exception("Error updating hcc: " . $stmt_hcc->error);
        }

        // Update status persetujuan di tabel persetujuan_hc
        $sql_persetujuan_hc = "UPDATE persetujuan_hc SET persetujuanAdmin='Disetujui' WHERE fpk_selection=?";
        $stmt_persetujuan_persetujuan_hc = $connection->prepare($sql_persetujuan_persetujuan_hc);
        $stmt_persetujuan_persetujuan_hc->bind_param("s", $id);

        if (!$stmt_persetujuan_persetujuan_hc->execute()) {
            throw new Exception("Error updating persetujuan_hc: " . $stmt_persetujuan_persetujuan_hc->error);
        }

        // Commit transaction
        $connection->commit();

        // Output JavaScript to alert success and refresh page
        echo "<script>
            alert('Persetujuan berhasil disetujui.');
            window.location.reload();
          </script>";
    } catch (Exception $e) {
        // Rollback transaction
        $connection->rollback();
        echo "<script>
            alert('Terjadi kesalahan: " . $e->getMessage() . "');
            window.location.reload();
          </script>";
    }

    // Close statements
    $stmt_hcc->close();
    $stmt_persetujuan_persetujuan_hc->close();

    // Close connection
    $connection->close();
}
