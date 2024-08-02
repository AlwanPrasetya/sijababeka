<?php
// Pastikan ada koneksi ke database
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan ID FPK dan tanggalDireksi3 dari data POST
    $id_fpk = $_POST['id'];
    $tanggalDireksi3 = $_POST['tanggalDireksi3'];

    // Lakukan query untuk menyimpan tanggalDireksi3 ke field tglDireksi3 di tabel fpk
    $sql_insert_tanggalDireksi3 = "INSERT INTO fpk (id_fpk, tglDireksi3) VALUES (?, ?)";
    $stmt_insert_tanggalDireksi3 = $connection->prepare($sql_insert_tanggalDireksi3);
    $stmt_insert_tanggalDireksi3->bind_param("is", $id_fpk, $tanggalDireksi3);

    if ($stmt_insert_tanggalDireksi3->execute()) {
        echo "success"; // Berhasil menyimpan tanggalDireksi3
    } else {
        echo "error_insert_tanggalDireksi3"; // Gagal menyimpan tanggalDireksi3
    }

    // Tutup statement penyimpanan tanggalDireksi3
    $stmt_insert_tanggalDireksi3->close();
}

// Menutup koneksi database
$connection->close();
?>
