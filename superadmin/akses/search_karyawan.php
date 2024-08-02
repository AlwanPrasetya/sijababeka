<?php
// Koneksi ke database
include('koneksi.php');

// Ambil nilai pencarian dari parameter "term"
$term = $_GET['term'];

// SQL untuk melakukan pencarian karyawan berdasarkan nama
$sql = "SELECT nama FROM karyawan WHERE nama LIKE '%{$term}%' ORDER BY nama ASC";
$result = $connection->query($sql);

// Siapkan array untuk menyimpan hasil pencarian
$data = array();

// Periksa apakah ada hasil yang ditemukan
if ($result->num_rows > 0) {
    // Loop melalui hasil pencarian dan tambahkan ke dalam array
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            'id' => $row['nama'],
            'text' => $row['nama']
        );
    }
}

// Mengembalikan hasil pencarian dalam format JSON
echo json_encode($data);

// Menutup koneksi database
$connection->close();
?>
