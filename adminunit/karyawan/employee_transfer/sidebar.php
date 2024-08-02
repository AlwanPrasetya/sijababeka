<?php
session_start();

// Tampilkan kembali data yang disimpan dalam sesi
if (isset($_SESSION['effective_date']) && isset($_SESSION['reason'])) {
    // Gunakan data untuk menampilkan kembali tampilan sebelumnya
    $effective_date = $_SESSION['effective_date'];
    $reason = $_SESSION['reason'];

    // Tampilkan data dalam formulir atau bagian tampilan yang sesuai
} else {
    // Lakukan tindakan standar jika tidak ada data yang tersimpan
}

// Memeriksa apakah nilai id diterima melalui URL
if (isset($_GET['id'])) {
    // Ambil nilai id dari URL
    $id = $_GET['id'];

    // Simpan id dalam sesi
    $_SESSION['id'] = $id;
} else {
    // Jika nilai id tidak ditemukan dalam URL
    echo "Nilai id tidak ditemukan dalam URL.";
}

// Memeriksa apakah nilai branch diterima melalui URL
if (isset($_GET['branches'])) {
    // Ambil nilai branch dari URL
    $branches = $_GET['branches'];

    // Jika nilai branch adalah string, konversi menjadi array dengan memisahkan nilainya berdasarkan koma
    if (!is_array($branches)) {
        $branches = explode(",", $branches);
    }
} else {
    // Jika nilai branch tidak ditemukan dalam URL
    echo "Nilai branch tidak ditemukan dalam URL.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <title>FORM KARYAWAN</title>
    <style>
        body {
            background-color: #EAFAF1;
        }

        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100px;
            background-color: #008F4D;
            padding-top: 25px;
            z-index: 1;
        }

        #sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        #sidebar ul li {
            padding: 10px 15px;
        }

        #sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 15px;
        }

        #toggler {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .container-content {
            margin-left: 100px;
        }

        .settings-button {
            position: fixed;
            top: 0px;
            left: 0px;
            padding: 10px 13px 10px 13px;
            z-index: 50;
            background-color: yellowgreen;
        }
    </style>
</head>

<body>
    <div id="sidebar">
        <div id="toggler">&#9776;</div>
        <ul>
            <li><a href="../../index.php?id=<?php echo $_SESSION['id']; ?>" class="btn settings-button">Dashboard</a></li>
            <li><a href="../tetap/index.php?id=<?php echo $_SESSION['id']; ?>&branches=<?php echo implode(",", $branches); ?>">Employee</a></li>
            <li><a href="../employee_transfer/index.php?id=<?php echo $_SESSION['id']; ?>&branches=<?php echo implode(",", $branches); ?>">Employee Transfer</a></li>
        </ul>
    </div>
</body>

</html>