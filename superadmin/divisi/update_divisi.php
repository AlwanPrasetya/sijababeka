<?php
include('koneksi.php');

//get data dari form
$id_divisi     = $_POST['id_divisi'];
$nama_kode        = $_POST['nama_kode'];
$nama_divisi = $_POST['nama_divisi'];

//query update data ke dalam database berdasarkan ID
$query = "UPDATE divisi SET nama_kode = '$nama_kode', nama_divisi = '$nama_divisi' WHERE id_divisi = '$id_divisi'";

//kondisi pengecekan apakah data berhasil diupdate atau tidak
if (mysqli_query($connection, $query)) {
    //redirect ke halaman index.php 
    header("location: create_divisi.php");
} else {
    //pesan error gagal update data
    echo "Data Gagal Diupdate!";
}
