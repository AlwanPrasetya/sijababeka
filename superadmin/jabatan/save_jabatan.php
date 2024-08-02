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
$nama_jabatan = $_POST['nama_jabatan'];

// Query untuk menyimpan data ke dalam database
$query = "INSERT IGNORE INTO jabatan (nama_kode, nama_jabatan) VALUES ('$nama_kode', '$nama_jabatan')";
if (mysqli_query($koneksi, $query)) {
    // Periksa apakah ada baris yang terpengaruh (inserted)
    if (mysqli_affected_rows($koneksi) > 0) {
        // Jika data berhasil disimpan, atur pesan ke dalam session
        $_SESSION['pesan'] = "Data jabatan berhasil dimasukkan.";
    } else {
        $_SESSION['error'] = "Kode sudah ada dalam database. Harap gunakan kode yang berbeda.";
    }
    // Redirect pengguna ke halaman sebelumnya atau halaman tertentu
    header("Location: create_jabatan.php");
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

// Tutup koneksi setelah selesai menggunakan
mysqli_close($koneksi);
