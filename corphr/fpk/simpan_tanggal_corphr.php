<?php
// Pastikan ada koneksi ke database
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan ID FPK dan tanggalCorpHr dari data POST
    $id_fpk = $_POST['id'];
    $tanggalCorpHr = $_POST['tanggalCorpHr'];

    // Lakukan query untuk menyimpan tanggalCorpHr ke field tglCorpHr di tabel fpk
    $sql_insert_tanggalCorpHr = "INSERT INTO fpk (id_fpk, tglCorpHr) VALUES (?, ?)";
    $stmt_insert_tanggalCorpHr = $connection->prepare($sql_insert_tanggalCorpHr);
    $stmt_insert_tanggalCorpHr->bind_param("is", $id_fpk, $tanggalCorpHr);

    if ($stmt_insert_tanggalCorpHr->execute()) {
        echo "success"; // Berhasil menyimpan tanggalCorpHr
    } else {
        echo "error_insert_tanggalCorpHr"; // Gagal menyimpan tanggalCorpHr
    }

    // Tutup statement penyimpanan tanggalCorpHr
    $stmt_insert_tanggalCorpHr->close();
}

// Menutup koneksi database
$connection->close();
?>
