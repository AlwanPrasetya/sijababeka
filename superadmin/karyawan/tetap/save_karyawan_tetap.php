<?php
// Include file koneksi.php untuk menghubungkan ke database
include 'koneksi.php';

// Tangkap data yang dikirim dari formulir
$kode = $_POST['kode'];
$nama = $_POST['nama'];
$nik = $_POST['nik'];
$bisnis = $_POST['bisnis'];
$department = $_POST['department'];
$jabatan = $_POST['jabatan'];
$divisi = $_POST['divisi'];
$golongan = $_POST['golongan'];
$lokasi_kerja = $_POST['lokasi_kerja'];
$status = $_POST['status'];

// Query untuk menyimpan data ke database
$query = "INSERT INTO karyawan (nama, kode, nik, bisnis, department, jabatan, divisi, golongan, lokasi_kerja, status) VALUES ('$nama', '$kode','$nik', '$bisnis', '$department', '$jabatan', '$divisi', '$golongan', '$lokasi_kerja', '$status')";

// Jalankan query
if (mysqli_query($connection, $query)) {
    // Jika penyimpanan berhasil, tampilkan pesan sukses
    echo "<script>alert('Data karyawan berhasil disimpan.'); window.location.href = 'index.php';</script>";
} else {
    // Jika terjadi kesalahan, tampilkan pesan error
    echo "<script>alert('Error: " . mysqli_error($connection) . "');</script>";
}

// Tutup koneksi database
mysqli_close($connection);
?>
