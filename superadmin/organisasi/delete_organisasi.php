<?php

include('koneksi.php');

//get id
$id = $_GET['id'];

$query = "DELETE FROM organisasi WHERE id_organisasi = '$id'";

if ($connection->query($query)) {
    header("location: create_organisasi.php");
} else {
    echo "DATA GAGAL DIHAPUS!";
}
