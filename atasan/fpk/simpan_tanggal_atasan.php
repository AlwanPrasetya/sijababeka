<?php
// Pastikan ada koneksi ke database
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan ID FPK dan tanggalAtasan dari data POST
    $id_fpk = $_POST['id'];
    $tanggalAtasan = $_POST['tanggalAtasan'];

    // Lakukan query untuk menyimpan tanggalAtasan ke field tglAtasan di tabel fpk
    $sql_insert_tanggalAtasan = "INSERT INTO fpk (id_fpk, tglAtasan) VALUES (?, ?)";
    $stmt_insert_tanggalAtasan = $connection->prepare($sql_insert_tanggalAtasan);
    $stmt_insert_tanggalAtasan->bind_param("is", $id_fpk, $tanggalAtasan);

    if ($stmt_insert_tanggalAtasan->execute()) {
        echo "success"; // Berhasil menyimpan tanggalAtasan
    } else {
        echo "error_insert_tanggalAtasan"; // Gagal menyimpan tanggalAtasan
    }

    // Tutup statement penyimpanan tanggalAtasan
    $stmt_insert_tanggalAtasan->close();
}

// Menutup koneksi database
$connection->close();
?>
