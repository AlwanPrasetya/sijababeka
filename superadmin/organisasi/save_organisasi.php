<?php
session_start();

// Lakukan koneksi ke database di sini
// Gantilah parameter koneksi dengan informasi yang sesuai
include('koneksi.php');


// Ambil data dari form
$nama_kode = $_POST['nama_kode'];
$nama_organisasi = $_POST['nama_organisasi'];

// Query untuk menyimpan data ke dalam database
$query = "INSERT IGNORE INTO organisasi (nama_kode, nama_organisasi) VALUES ('$nama_kode', '$nama_organisasi')";
if (mysqli_query($koneksi, $query)) {
    // Periksa apakah ada baris yang terpengaruh (inserted)
    if (mysqli_affected_rows($koneksi) > 0) {
        // Jika data berhasil disimpan, atur pesan ke dalam session
        $_SESSION['pesan'] = "Data bisnis berhasil dimasukkan.";
    } else {
        $_SESSION['error'] = "Kode sudah ada dalam database. Harap gunakan kode yang berbeda.";
    }
    // Redirect pengguna ke halaman sebelumnya atau halaman tertentu
    header("Location: create_organisasi.php");
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

// Tutup koneksi setelah selesai menggunakan
mysqli_close($koneksi);
