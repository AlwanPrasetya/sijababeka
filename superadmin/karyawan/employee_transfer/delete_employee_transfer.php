<?php
include('koneksi.php');

// Get id
$id = $_GET['id'];

$query = "DELETE FROM employee_transfer WHERE id = '$id'";

if ($connection->query($query)) {
    echo '<script>alert("Data berhasil dihapus!"); window.location.href = "index.php";</script>';
} else {
    echo "DATA GAGAL DIHAPUS!";
}
?>
