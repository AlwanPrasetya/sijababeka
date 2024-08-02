<?php

include('koneksi.php');

//get id
$id = $_GET['id'];

$query = "DELETE FROM lokasi_kerja WHERE id_lokasi_kerja = '$id'";

if ($connection->query($query)) {
    header("location: create_lokasi.php");
} else {
    echo "DATA GAGAL DIHAPUS!";
}
