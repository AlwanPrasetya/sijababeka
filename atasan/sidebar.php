<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <title>SETTINGS</title>
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
            padding-top: 20px;
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
            top: 20px;
            left: 20px;
            z-index: 50;
        }
    </style>
</head>

<body>
    <div id="sidebar">
        <div id="toggler">&#9776;</div>
        <ul>
            <li><a href="index.php?branch=<?php echo $branch; ?>" class="btn settings-button">Dashboard</a></li>
            <li><a href="bisnis/create_bisnis.php">Bisnis Unit</a></li>
            <li><a href="department/create_dept.php">Department</a></li>
            <li><a href="divisi/create_divisi.php">Divisi</a></li>
            <li><a href="golongan/create_golongan.php">Golongan</a></li>
            <li><a href="jabatan/create_jabatan.php">Jabatan</a></li>
            <li><a href="lokasi/create_lokasi.php">Lokasi</a></li>
            <li><a href="status/create_status.php">Status</a></li>
        </ul>
    </div>
</body>

</html>