<?php
// Pastikan ada koneksi ke database
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan ID FPK dan tanggalAdmin dari data POST
    $id_fpk = $_POST['id'];
    $tanggalAdmin = $_POST['tanggalAdmin'];

    // Lakukan query untuk menyimpan tanggalAdmin ke field tglAdmin di tabel fpk
    $sql_insert_tanggalAdmin = "INSERT INTO fpk (id_fpk, tglAdmin) VALUES (?, ?)";
    $stmt_insert_tanggalAdmin = $connection->prepare($sql_insert_tanggalAdmin);
    $stmt_insert_tanggalAdmin->bind_param("is", $id_fpk, $tanggalAdmin);

    if ($stmt_insert_tanggalAdmin->execute()) {
        echo "success"; // Berhasil menyimpan tanggalAdmin
    } else {
        echo "error_insert_tanggalAdmin"; // Gagal menyimpan tanggalAdmin
    }

    // Tutup statement penyimpanan tanggalAdmin
    $stmt_insert_tanggalAdmin->close();
}

// Menutup koneksi database
$connection->close();
?>
