<?php
// Pastikan ada koneksi ke database
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan ID FPK dari data POST
    $id_fpk = $_POST['id'];

    // Lakukan query untuk memperbarui kolom persetujuan di tabel fpk
    $sql = "UPDATE fpk SET persetujuanUnit = 'Ditolak' WHERE id_fpk = ?";

    // Persiapkan statement untuk query
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id_fpk); // Mengikat parameter

    // Eksekusi statement
    if ($stmt->execute()) {
        // Jika update berhasil, kirim respons berhasil ke klien
        echo "success";
    } else {
        // Jika terjadi kesalahan saat mengupdate, kirim respons error ke klien
        echo "error";
    }

    // Tutup statement
    $stmt->close();
}

// Menutup koneksi database
$connection->close();
?>
