<?php
include('koneksi.php');

//get data dari form
$id_status     = $_POST['id_status'];
$nama_kode        = $_POST['nama_kode'];
$nama_status = $_POST['nama_status'];

//query update data ke dalam database berdasarkan ID
$query = "UPDATE status SET nama_kode = '$nama_kode', nama_status = '$nama_status' WHERE id_status = '$id_status'";

//kondisi pengecekan apakah data berhasil diupdate atau tidak
if (mysqli_query($connection, $query)) {
    //redirect ke halaman index.php 
    header("location: create_status.php");
} else {
    //pesan error gagal update data
    echo "Data Gagal Diupdate!";
}
