<?php
session_start();

// Lakukan koneksi ke database di sini
// Gantilah parameter koneksi dengan informasi yang sesuai
include('koneksi.php');


// Ambil data dari form
$nama_kode = $_POST['nama_kode'];
$nama_lokasi_kerja = $_POST['nama_lokasi_kerja'];

// Query untuk menyimpan data ke dalam database
$query = "INSERT IGNORE INTO lokasi_kerja (nama_kode, nama_lokasi_kerja) VALUES ('$nama_kode', '$nama_lokasi_kerja')";
if (mysqli_query($koneksi, $query)) {
    // Periksa apakah ada baris yang terpengaruh (inserted)
    if (mysqli_affected_rows($koneksi) > 0) {
        // Jika data berhasil disimpan, atur pesan ke dalam session
        $_SESSION['pesan'] = "Data lokasi_kerja berhasil dimasukkan.";
    } else {
        $_SESSION['error'] = "Kode sudah ada dalam database. Harap gunakan kode yang berbeda.";
    }
    // Redirect pengguna ke halaman sebelumnya atau halaman tertentu
    header("Location: create_lokasi.php");
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

// Tutup koneksi setelah selesai menggunakan
mysqli_close($koneksi);
