<?php
include('koneksi.php');

//get data dari form
$id    = $_POST['id'];
$nama = $_POST['nama'];
$request_type = $_POST['request_type'];
$effective_date = $_POST['effective_date'];
$nama_status = $_POST['nama_status'];
$nama_unit = $_POST['nama_unit'];
$nama_jabatan = $_POST['nama_jabatan'];
$nama_organisasi = $_POST['nama_organisasi'];
$nama_golongan = $_POST['nama_golongan'];
$reason = $_POST['reason'];

//query update data ke dalam database berdasarkan ID
$query = "UPDATE employee_transfer SET nama = '$nama', request_type = '$request_type', effective_date = '$effective_date', nama_status = '$nama_status', nama_unit = '$nama_unit' , nama_jabatan = '$nama_jabatan' , nama_organisasi = '$nama_organisasi', nama_golongan = '$nama_golongan', reason = '$reason' WHERE id = '$id'";

//kondisi pengecekan apakah data berhasil diupdate atau tidak
if (mysqli_query($connection, $query)) {
    //redirect ke halaman index.php 
    header("location: index.php");
} else {
    //pesan error gagal update data
    echo "Data Gagal Diupdate!";
}
