<?php

include('koneksi.php');

//get id
$id = $_GET['id'];

$query = "DELETE FROM divisi WHERE id_divisi = '$id'";

if ($connection->query($query)) {
    header("location: create_divisi.php");
} else {
    echo "DATA GAGAL DIHAPUS!";
}
