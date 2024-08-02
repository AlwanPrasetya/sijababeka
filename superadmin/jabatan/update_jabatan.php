<?php
include('koneksi.php');

//get data dari form
$id_jabatan     = $_POST['id_jabatan'];
$nama_kode        = $_POST['nama_kode'];
$nama_jabatan = $_POST['nama_jabatan'];

//query update data ke dalam database berdasarkan ID
$query = "UPDATE jabatan SET nama_kode = '$nama_kode', nama_jabatan = '$nama_jabatan' WHERE id_jabatan = '$id_jabatan'";

//kondisi pengecekan apakah data berhasil diupdate atau tidak
if (mysqli_query($connection, $query)) {
    //redirect ke halaman index.php 
    header("location: create_jabatan.php");
} else {
    //pesan error gagal update data
    echo "Data Gagal Diupdate!";
}
