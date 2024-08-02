<?php
include('koneksi.php');

//get data dari form
$id_golongan     = $_POST['id_golongan'];
$nama_kode        = $_POST['nama_kode'];
$nama_golongan = $_POST['nama_golongan'];

//query update data ke dalam database berdasarkan ID
$query = "UPDATE golongan SET nama_kode = '$nama_kode', nama_golongan = '$nama_golongan' WHERE id_golongan = '$id_golongan'";

//kondisi pengecekan apakah data berhasil diupdate atau tidak
if (mysqli_query($connection, $query)) {
    //redirect ke halaman index.php 
    header("location: create_golongan.php");
} else {
    //pesan error gagal update data
    echo "Data Gagal Diupdate!";
}
