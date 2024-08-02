<?php

include('koneksi.php');

//get id
$id = $_GET['id'];

$query = "DELETE FROM approval WHERE id_approval = '$id'";

if ($connection->query($query)) {
    echo "<script>alert('Data berhasil dihapus.'); window.location.href = 'index.php';</script>";
} else {
    echo "DATA GAGAL DIHAPUS!";
}
