<?php
// Pastikan ada koneksi ke database
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan ID FPK dan tanggalSuperadmin dari data POST
    $id_fpk = $_POST['id'];
    $tanggalSuperadmin = $_POST['tanggalSuperadmin'];

    // Lakukan query untuk menyimpan tanggalSuperadmin ke field tglSuperadmin di tabel fpk
    $sql_insert_tanggalSuperadmin = "INSERT INTO fpk (id_fpk, tglSuperadmin) VALUES (?, ?)";
    $stmt_insert_tanggalSuperadmin = $connection->prepare($sql_insert_tanggalSuperadmin);
    $stmt_insert_tanggalSuperadmin->bind_param("is", $id_fpk, $tanggalSuperadmin);

    if ($stmt_insert_tanggalSuperadmin->execute()) {
        echo "success"; // Berhasil menyimpan tanggalSuperSuperadmin
    } else {
        echo "error_insert_tanggalSuperadmin"; // Gagal menyimpan tanggalSuperadmin
    }

    // Tutup statement penyimpanan tanggalSuperadmin
    $stmt_insert_tanggalSuperadmin->close();
}

// Menutup koneksi database
$connection->close();
?>
