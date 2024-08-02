<!DOCTYPE html>
<html>

<head>
    <title>FORM LOGIN</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            position: relative;
            background-color: #6D8535;
            font-family: 'Roboto', sans-serif;
            color: black;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;


            .container {
                display: flex;
                justify-content: center;
                align-items: center;
                overflow-y: hidden;
                width: 100%;
                height: 100vh;
                /* Menggunakan tinggi viewport untuk mengisi seluruh tinggi layar */
            }

            .left {
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
                /* padding: 20px; */
            }

            .right {
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
                /* padding: 20px; */
            }

            .right .card {
                max-width: 700px;
                /* Atur lebar maksimum card */
                padding-top: 80px;
                padding-bottom: 80px;
                padding-left: 140px;
                padding-right: 140px;
                /* Sesuaikan padding agar card terlihat luas */
            }

            .right .textbox input,
            .right .btn {
                width: 85%;
                /* Lebarkan input dan tombol untuk mengisi card */
            }


            .card {
                /* width: 100%; */
                /* max-width: 600px; */
                height: auto;
                background-color: #BBB19B;
                border-radius: 10px;
                /* padding: 10px; */
                box-shadow: 0 0 10px black;
                /* display: flex; */
                /* flex-direction: column; */
                justify-content: start;
                align-items: start;
            }

            .logo {
                /* width: 200px; */
                height: 590px;
                margin-left: -50px;
                box-shadow: 0 0 10px black;
                /* Menyesuaikan ukuran logo */
                /* height: auto; */
                /* margin-bottom: 20px; */
            }

            .heading {
                text-align: center;
                margin-bottom: 20px;
            }

            .textbox {
                position: relative;
                margin-bottom: 20px;
                width: 100%;
            }

            .textbox input {
                width: 100%;
                padding: 10px;
                border: none;
                border-bottom: 2px solid black;
                outline: none;
                background: transparent;
                color: black;
                font-size: 16px;
            }

            .textbox input:focus {
                border-bottom: 2px solid #4CAF50;
            }

            .textbox i {
                position: absolute;
                top: 10px;
                left: 0;
                color: black;
            }

            .btn {
                width: 100%;
                background-color: #4CAF50;
                border: none;
                margin: 10px auto;
                padding: 10px;
                margin-left: 25px;
                cursor: pointer;
                font-size: 18px;
                color: #fff;
                border-radius: 5px;
                transition: background-color 0.3s;
            }

            .btn:hover {
                background-color: #45a049;
            }

            .link {
                text-align: center;
                margin-top: 20px;
            }

            .link a {
                color: #4CAF50;
                text-decoration: none;
            }

            .alert {
                background-color: #f44336;
                color: white;
                padding: 15px;
                margin-bottom: 15px;
                border-radius: 5px;
                width: 100%;
                text-align: center;
            }

            .logo-jababeka {
                max-width: 120px;
                margin-left: 80px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left">
            <img class="logo" src="./image/jababekafix.png" alt="Logo">
        </div>
        <div class="right">
            <div class="card">
                <img class="logo-jababeka" src="./img/logo-jababeka1.png" alt="Logo">
                <h2 class="heading">Welcome to the Sijababeka</h2>
                <?php
                // Mulai sesi jika belum dimulai
                // if (session_status() == PHP_SESSION_NONE) {
                //     session_start();
                // }

                // Fungsi untuk menghasilkan token CSRF
                function generateCSRFToken()
                {
                    return bin2hex(random_bytes(32)); // Menghasilkan string acak 32 byte (256 bit) dan mengonversinya menjadi string heksadesimal
                }

                // Buat token CSRF jika belum ada dalam sesi
                if (!isset($_SESSION['csrf_token'])) {
                    $_SESSION['csrf_token'] = generateCSRFToken();
                }

                if (isset($_GET['pesan'])) {
                    if ($_GET['pesan'] == "gagal") {
                        echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
                    }
                }
                ?>
                <form action="cek_login.php" method="post">
                    <div class="textbox">
                        <i class="fas fa-user"></i>
                        <input style="margin-left: 25px;" type="text" name="username" class="form-control" placeholder="Username" required="required">
                    </div>

                    <div class="textbox">
                        <i class="fas fa-lock"></i>
                        <input style="margin-left: 25px;" type="password" name="password" class="form-control" placeholder="Password" required="required">
                    </div>

                    <!-- Tambahkan input tersembunyi untuk token CSRF -->
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                    <input type="submit" class="btn" value="LOGIN">
                </form>

                <div class="link">
                    <a href="https://alwanprasetya.github.io">Created By Alwan At 2024</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>