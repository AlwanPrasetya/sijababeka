<?php

include('koneksi.php');

//get id
$id = $_GET['id'];

$query = "DELETE FROM golongan WHERE id_golongan = '$id'";

if ($connection->query($query)) {
    header("location: create_golongan.php");
} else {
    echo "DATA GAGAL DIHAPUS!";
}
