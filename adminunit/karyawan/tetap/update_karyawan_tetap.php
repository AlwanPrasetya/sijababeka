<?php
include('koneksi.php');

//get data dari form
$id_karyawan     = $_POST['id_karyawan'];
$kode        = $_POST['kode'];
$nama = $_POST['nama'];
$nik = $_POST['nik'];
$bisnis = $_POST['bisnis'];
$department = $_POST['department'];
$divisi = $_POST['divisi'];
$golongan = $_POST['golongan'];
$jabatan = $_POST['jabatan'];
$lokasi_kerja = $_POST['lokasi_kerja'];
$status = $_POST['status'];

//query update data ke dalam database berdasarkan ID
$query = "UPDATE karyawan SET kode = '$kode', nama = '$nama', nik = '$nik', bisnis = '$bisnis', department = '$department', divisi = '$divisi', golongan = '$golongan', jabatan = '$jabatan', lokasi_kerja = '$lokasi_kerja', status = '$status' WHERE id_karyawan = '$id_karyawan'";

//kondisi pengecekan apakah data berhasil diupdate atau tidak
if (mysqli_query($connection, $query)) {
    //redirect ke halaman index.php 
    header("location: index.php");
} else {
    //pesan error gagal update data
    echo "Data Gagal Diupdate!";
}
