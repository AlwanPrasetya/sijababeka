<?php
include('koneksi.php');

//get data dari form
$id_lokasi_kerja     = $_POST['id_lokasi_kerja'];
$nama_kode        = $_POST['nama_kode'];
$nama_lokasi_kerja = $_POST['nama_lokasi_kerja'];

//query update data ke dalam database berdasarkan ID
$query = "UPDATE lokasi_kerja SET nama_kode = '$nama_kode', nama_lokasi_kerja = '$nama_lokasi_kerja' WHERE id_lokasi_kerja = '$id_lokasi_kerja'";

//kondisi pengecekan apakah data berhasil diupdate atau tidak
if (mysqli_query($connection, $query)) {
    //redirect ke halaman index.php 
    header("location: create_lokasi.php");
} else {
    //pesan error gagal update data
    echo "Data Gagal Diupdate!";
}
