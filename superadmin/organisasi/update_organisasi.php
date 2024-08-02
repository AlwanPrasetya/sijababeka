<?php
include('koneksi.php');

//get data dari form
$id_organisasi     = $_POST['id_organisasi'];
$nama_kode        = $_POST['nama_kode'];
$nama_organisasi = $_POST['nama_organisasi'];

//query update data ke dalam database berdasarkan ID
$query = "UPDATE organisasi SET nama_kode = '$nama_kode', nama_organisasi = '$nama_organisasi' WHERE id_organisasi = '$id_organisasi'";

//kondisi pengecekan apakah data berhasil diupdate atau tidak
if (mysqli_query($connection, $query)) {
    //redirect ke halaman index.php 
    header("location: create_organisasi.php");
} else {
    //pesan error gagal update data
    echo "Data Gagal Diupdate!";
}
