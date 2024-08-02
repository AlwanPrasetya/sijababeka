<?php
// Pastikan ada koneksi ke database
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan ID FPK dan tanggalDireksi2 dari data POST
    $id_fpk = $_POST['id'];
    $tanggalDireksi2 = $_POST['tanggalDireksi2'];

    // Lakukan query untuk menyimpan tanggalDireksi2 ke field tglDireksi2 di tabel fpk
    $sql_insert_tanggalDireksi2 = "INSERT INTO fpk (id_fpk, tglDireksi2) VALUES (?, ?)";
    $stmt_insert_tanggalDireksi2 = $connection->prepare($sql_insert_tanggalDireksi2);
    $stmt_insert_tanggalDireksi2->bind_param("is", $id_fpk, $tanggalDireksi2);

    if ($stmt_insert_tanggalDireksi2->execute()) {
        echo "success"; // Berhasil menyimpan tanggalDireksi2
    } else {
        echo "error_insert_tanggalDireksi2"; // Gagal menyimpan tanggalDireksi2
    }

    // Tutup statement penyimpanan tanggalDireksi2
    $stmt_insert_tanggalDireksi2->close();
}

// Menutup koneksi database
$connection->close();
?>
