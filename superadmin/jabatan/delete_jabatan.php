<?php

include('koneksi.php');

//get id
$id = $_GET['id'];

$query = "DELETE FROM jabatan WHERE id_unit = '$id'";

if ($connection->query($query)) {
    header("location: create_jabatan.php");
} else {
    echo "DATA GAGAL DIHAPUS!";
}
