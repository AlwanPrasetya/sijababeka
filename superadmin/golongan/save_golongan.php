<?php
session_start();

// Lakukan koneksi ke database di sini
// Gantilah parameter koneksi dengan informasi yang sesuai
$koneksi = mysqli_connect("localhost", "alwan", "root", "settings");

// Periksa koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

// Ambil data dari form
$nama_kode = $_POST['nama_kode'];
$nama_golongan = $_POST['nama_golongan'];

// Query untuk menyimpan data ke dalam database
$query = "INSERT IGNORE INTO golongan (nama_kode, nama_golongan) VALUES ('$nama_kode', '$nama_golongan')";
if (mysqli_query($koneksi, $query)) {
    // Periksa apakah ada baris yang terpengaruh (inserted)
    if (mysqli_affected_rows($koneksi) > 0) {
        // Jika data berhasil disimpan, atur pesan ke dalam session
        $_SESSION['pesan'] = "Data bisnis berhasil dimasukkan.";
    } else {
        $_SESSION['error'] = "Kode sudah ada dalam database. Harap gunakan kode yang berbeda.";
    }
    // Redirect pengguna ke halaman sebelumnya atau halaman tertentu
    header("Location: create_golongan.php");
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

// Tutup koneksi setelah selesai menggunakan
mysqli_close($koneksi);
