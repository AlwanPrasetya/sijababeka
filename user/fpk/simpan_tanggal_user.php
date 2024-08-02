<?php
// Pastikan ada koneksi ke database
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan ID FPK dan tanggalUser dari data POST
    $id_fpk = $_POST['id'];
    $tanggalUser = $_POST['tanggalUser'];

    // Lakukan query untuk menyimpan tanggalUser ke field tglUser di tabel fpk
    $sql_insert_tanggalUser = "INSERT INTO fpk (id_fpk, tglUser) VALUES (?, ?)";
    $stmt_insert_tanggalUser = $connection->prepare($sql_insert_tanggalUser);
    $stmt_insert_tanggalUser->bind_param("is", $id_fpk, $tanggalUser);

    if ($stmt_insert_tanggalUser->execute()) {
        echo "success"; // Berhasil menyimpan tanggalUser
    } else {
        echo "error_insert_tanggalUser"; // Gagal menyimpan tanggalUser
    }

    // Tutup statement penyimpanan tanggalUser
    $stmt_insert_tanggalUser->close();
}

// Menutup koneksi database
$connection->close();
?>
