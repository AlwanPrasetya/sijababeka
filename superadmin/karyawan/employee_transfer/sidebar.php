<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <title>FORM KARYAWAN</title>
    <style>
        /* Tambahkan CSS khusus di sini jika diperlukan */
        /* Tambahkan CSS khusus di sini jika diperlukan */
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
            background-color: #9ACD32;
        }

        
    </style>
</head>

<body>
    <div id="sidebar">
        <div id="toggler">&#9776;</div>
        <ul>
            <li><a href="../../../superadmin/superadmin.php" class="btn settings-button">Dashboard</a></li>
            <li><a href="../tetap/index.php">Employee</a></li>
            <li><a href="../employee_transfer/index.php">Employee Transfer</a></li>
            <!-- <li><a href="javascript:history.go(-1);" class="btn fpk-button" id="fpkButton">Back</a></li> -->

        </ul>
    </div>

    <script>
        // Script untuk menampilkan tombol FPK hanya ketika URL mengandung kata "search"
        document.addEventListener("DOMContentLoaded", function() {
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has("search")) {
                var fpkButton = document.getElementById("fpkButton");
                fpkButton.style.display = "block";
            }
        });
    </script>
</body>

</html>