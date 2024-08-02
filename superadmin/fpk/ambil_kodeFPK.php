<?php
// Pastikan ada koneksi ke database
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan ID FPK dari data POST
    $id_fpk = $_POST['id'];

    // Lakukan query untuk mendapatkan kodeFPK pegawai dari tabel fpk
    $sql_select_kodeFPK = "SELECT kodeFPK FROM fpk WHERE id_fpk = ?";
    $stmt_select_kodeFPK = $connection->prepare($sql_select_kodeFPK);
    $stmt_select_kodeFPK->bind_param("i", $id_fpk);
    $stmt_select_kodeFPK->execute();
    $result_select_kodeFPK = $stmt_select_kodeFPK->get_result();

    if ($result_select_kodeFPK->num_rows > 0) {
        // Ambil nilai kodeFPK pegawai
        $row = $result_select_kodeFPK->fetch_assoc();
        $kodeFPK = $row['kodeFPK'];
        
        // Mengembalikan nilai kodeFPK
        echo $kodeFPK;
    } else {
        echo "error_select_kodeFPK";
    }

    // Tutup statement
    $stmt_select_kodeFPK->close();
}

// Menutup koneksi database
$connection->close();
?>
