<?php

//deklasrasi variabel
$db_host = "localhost";
$db_user = "alwan";
$db_pass = "root";
$db_name = "db_sijababeka";

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($connection) {
    echo "!";
} else {
    echo "Koneksi Gagal! : " . mysqli_connect_error();
}
