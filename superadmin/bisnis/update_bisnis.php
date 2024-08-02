<?php
include('koneksi.php');

//get data dari form
$id_unit     = $_POST['id_unit'];
$nama_kode        = $_POST['nama_kode'];
$nama_unit = $_POST['nama_unit'];

//query update data ke dalam database berdasarkan ID
$query = "UPDATE bisnis SET nama_kode = '$nama_kode', nama_unit = '$nama_unit' WHERE id_unit = '$id_unit'";

//kondisi pengecekan apakah data berhasil diupdate atau tidak
if (mysqli_query($connection, $query)) {
    //redirect ke halaman index.php 
    header("location: create_bisnis.php");
} else {
    //pesan error gagal update data
    echo "Data Gagal Diupdate!";
}
