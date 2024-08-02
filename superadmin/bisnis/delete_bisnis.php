<?php

include('koneksi.php');

//get id
$id = $_GET['id'];

$query = "DELETE FROM bisnis WHERE id_unit = '$id'";

if ($connection->query($query)) {
    header("location: create_bisnis.php");
} else {
    echo "DATA GAGAL DIHAPUS!";
}
