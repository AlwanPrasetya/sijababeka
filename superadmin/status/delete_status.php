<?php

include('koneksi.php');

//get id
$id = $_GET['id'];

$query = "DELETE FROM status WHERE id_status = '$id'";

if ($connection->query($query)) {
    header("location: create_status.php");
} else {
    echo "DATA GAGAL DIHAPUS!";
}
