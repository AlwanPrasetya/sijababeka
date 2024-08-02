<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Super Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #EAFAF1;
        }

        .card {
            margin-bottom: 10px;
            /* Menambahkan jarak antara kotak */
            background-color: yellowgreen;
            position: relative;
            height: 150px;
            width: 200px;
            /* width: 100%; */
            /* Tinggi kartu */
        }


        h4 {
            color: #008F4D;
            text-align: center;
            margin-top: 30px;
        }

        /* h5 {
            color: black;
            text-align: center;
            margin-top: 30px;
        } */

        img.logo {
            position: absolute;
            top: 20px;
            /* Atur posisi logo */
            left: 30px;
            transform: translateX(-50%);
            width: 20px;
            height: 20px;
            z-index: 1;
        }

        .card-body {
            text-align: center;
            padding: 30px 30px;
            /* Atur padding di sini */
            position: relative;
            /* Tambahkan properti ini untuk mengatur posisi teks */
        }

        .card-icon {
            font-size: 50px;
            color: #007bff;
            z-index: 2;
            /* Pastikan ikon berada di depan logo */
        }

        .card-title {
            margin-top: 10px;
            font-size: 13px;
            /* Kurangi ukuran teks keterangan */
            margin-bottom: 0;
            font-style: italic;
            position: relative;
            /* Tambahkan properti ini untuk mengatur posisi teks */
            z-index: 3;
            /* Pastikan teks berada di depan logo */
        }

        .card-link {
            text-decoration: none;
            color: inherit;
        }

        /* CSS untuk mengatur posisi kartu */
        .container {
            height: 60vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Media queries untuk layout responsif */
        @media (max-width: 768px) {
            .card {
                height: auto;
                /* Set ulang tinggi kartu agar bisa menyesuaikan konten */
            }

            .card img {
                top: -10px;
                /* Atur ulang posisi logo */
                max-width: 100px;
                /* Atur ulang lebar maksimum logo */
                max-height: 100px;
                /* Atur ulang tinggi maksimum logo */
            }

            .card-body {
                padding: 10px 10px;
                /* Atur ulang padding kartu */
            }

            .card-icon {
                font-size: 40px;
                /* Atur ulang ukuran ikon */
            }

            .card-title {
                font-size: 12px;
                /* Atur ulang ukuran teks keterangan */
            }
        }

        .profile-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 42px;
            color: #007bff;
            z-index: 9999;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <img src="./img/logo-jababeka.png" alt="Logo" style="width: 10%; display: block; margin: 0 auto; padding-top: 20px;"><!-- Ganti path_to_your_logo dengan path logo Anda -->
    <?php
    include('koneksi.php');
    // Mulai sesi
    // session_start();
    $branches = '';

    if (isset($_GET['id'])) {
        // Check if 'id' is set in the session
        // if (!isset($_SESSION['id'])) {
        //     echo "User ID is not set in the session.";
        //     exit();
        // }

        // Get the user ID from the session
        $userId = $_GET['id'];

        // Perform database query to get branch based on user ID
        // Replace the query below with the appropriate query for your database structure
        // Make sure $connection is properly initialized
        $query = "SELECT branch, nama FROM multi_user WHERE id = $userId"; // Perhatikan perubahan disini: $userId
        $result = $connection->query($query);

        if ($result) {
            if ($result->num_rows > 0) {
                // Output data from each row
                while ($row = $result->fetch_assoc()) {
                    $branch = $row["branch"];
                    $nama = $row["nama"];
                    echo "<h4>SELAMAT DATANG, <strong> $nama </strong> - <strong> SUPER ADMIN </strong></h4>";
                    echo "<h5><strong><center> $branch </center></strong></h5>";
                }
            } else {
                echo "Data tidak ditemukan.";
            }
            // Close the database connection
            $connection->close();
        } else {
            echo "Error in query: " . $connection->error;
        }
    } else {
        // If no session or not a superadmin user, redirect to login page
        header("location: ../");
        exit(); // Make sure no other output before redirect
    }

    ?>
    <a href="ttd.php?branch=<?php echo $branch; ?>" class="card-link" style="position: absolute; top: 20px; right: 20px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 14 14">
            <rect width="14" height="14" fill="none" />
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5v2a1 1 0 0 1-1 1h-2m0-13h2a1 1 0 0 1 1 1v2m-13 0v-2a1 1 0 0 1 1-1h2m0 13h-2a1 1 0 0 1-1-1v-2m6.5-4a2 2 0 1 0 0-4a2 2 0 0 0 0 4m3.803 4.5a3.994 3.994 0 0 0-7.606 0z" />
        </svg>
        <!-- <h5 class="card-title">PROFIL</h5> -->
    </a>
    <div class="container">
        <div class="row">
            <div class="col-md-5" style="padding-right: 30px; width: 200px; display: flex; justify-content: end;">
                <a href="fpk.php" class="card-link">
                    <div class="card"><!-- Ganti path_to_your_logo dengan path logo Anda -->
                        <div class="card-body">
                            <svg xmlns="http://www.w3.org/2000/svg" width="5em" height="4em" viewBox="0 0 24 24">
                                <rect width="24" height="24" fill="none" />
                                <path fill="currentColor" d="M10 22h4c3.771 0 5.657 0 6.828-1.171C22 19.657 22 17.77 22 14s0-5.657-1.172-6.828c-.362-.363-.794-.613-1.328-.786v2.773c.003.34.009.911-.236 1.433c-.244.522-.686.884-.95 1.1c-.026.02-.051.041-.073.06l-1.507 1.255c-.86.718-1.61 1.342-2.284 1.776c-.725.466-1.51.812-2.45.812c-.94 0-1.724-.346-2.45-.812c-.674-.434-1.423-1.058-2.284-1.775l-1.507-1.256a13.705 13.705 0 0 0-.073-.06c-.264-.216-.705-.578-.95-1.1c-.244-.522-.24-1.093-.237-1.433l.001-.096V6.385c-.534.173-.966.424-1.328.787C2 8.343 2 10.229 2 14c0 3.771 0 5.657 1.172 6.829C4.343 22 6.229 22 10 22" />
                                <path fill="currentColor" fill-rule="evenodd" d="m6.72 10.6l1.439 1.2c1.837 1.53 2.755 2.295 3.841 2.295c1.086 0 2.005-.765 3.841-2.296l1.44-1.2c.353-.294.53-.442.625-.643c.094-.202.094-.432.094-.893V7c0-.32 0-.62-.002-.898c-.012-1.771-.098-2.737-.73-3.37C16.536 2 15.358 2 13 2h-2c-2.357 0-3.535 0-4.268.732c-.632.633-.72 1.599-.732 3.37c-.002.279 0 .577 0 .898v2.063c0 .46 0 .691.095.893c.094.201.27.349.625.644M9.25 6a.75.75 0 0 1 .75-.75h4a.75.75 0 0 1 0 1.5h-4A.75.75 0 0 1 9.25 6m1 3a.75.75 0 0 1 .75-.75h2a.75.75 0 0 1 0 1.5h-2a.75.75 0 0 1-.75-.75" clip-rule="evenodd" />
                            </svg>
                            <h5 class="card-title">Aplication</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-2" style="width: 200px; display: flex; justify-content: center;">
                <a href="./fpk/fpk.php?id=<?php echo $userId; ?>&branch=<?php echo $branch; ?>" class="card-link">
                    <div class="card">
                        <div class="card-body" style="margin-top: -5px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="5em" height="4.5em" viewBox="0 0 45 45">
                                <rect width="45" height="45" fill="none" />
                                <g fill="currentColor">
                                    <path d="M17 31v-2h2v2z" />
                                    <path fill-rule="evenodd" d="M20 4a3 3 0 0 0-3 3h-4a3 3 0 0 0-3 3v31a3 3 0 0 0 3 3h22a3 3 0 0 0 3-3V10a3 3 0 0 0-3-3h-4a3 3 0 0 0-3-3zm-1 3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-8a1 1 0 0 1-1-1zm-3 13a1 1 0 1 0 0 2h7a1 1 0 1 0 0-2zm-1-4a1 1 0 0 1 1-1h15.5a1 1 0 1 1 0 2H16a1 1 0 0 1-1-1m0 12a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1zm13 4a3 3 0 1 0 0-6a3 3 0 1 0 0 6m-6 4.5c0-2.116 3.997-3.182 6-3.182s6 1.066 6 3.182V39H22z" clip-rule="evenodd" />
                                </g>
                            </svg>
                            <h5 class="card-title">FPK</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-5" style="padding-left: 30px; width: 200px; display: flex; justify-content: start;">
                <a href="./hc/hc.php?id=<?php echo $userId; ?>&branch=<?php echo $branch; ?>" class="card-link">
                    <div class="card"><!-- Ganti path_to_your_logo dengan path logo Anda -->
                        <div class="card-body">
                            <svg xmlns="http://www.w3.org/2000/svg" width="5em" height="4em" viewBox="0 0 24 24">
                                <rect width="24" height="24" fill="none" />
                                <path fill="currentColor" fill-rule="evenodd" d="M3.464 3.464C2 4.93 2 7.286 2 12c0 4.714 0 7.071 1.464 8.535C4.93 22 7.286 22 12 22c4.714 0 7.071 0 8.535-1.465C22 19.072 22 16.714 22 12s0-7.071-1.465-8.536C19.072 2 16.714 2 12 2S4.929 2 3.464 3.464m7.08 4.053a.75.75 0 1 0-1.087-1.034l-2.314 2.43l-.6-.63a.75.75 0 1 0-1.086 1.034l1.143 1.2a.75.75 0 0 0 1.086 0zM13 8.25a.75.75 0 0 0 0 1.5h5a.75.75 0 0 0 0-1.5zm-2.457 6.267a.75.75 0 1 0-1.086-1.034l-2.314 2.43l-.6-.63a.75.75 0 1 0-1.086 1.034l1.143 1.2a.75.75 0 0 0 1.086 0zM13 15.25a.75.75 0 0 0 0 1.5h5a.75.75 0 0 0 0-1.5z" clip-rule="evenodd" />
                            </svg>
                            <h5 class="card-title">HC</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-5" style="padding-right: 30px; padding-top: 15px; width: 200px; display: flex; justify-content: end;">
                <a href="./karyawan/tetap/index.php" class="card-link">
                    <div class="card"> <!-- Ganti path_to_your_logo dengan path logo Anda -->
                        <div class="card-body">
                            <svg xmlns="http://www.w3.org/2000/svg" width="5em" height="4em" viewBox="0 0 36 36">
                                <rect width="36" height="36" fill="none" />
                                <ellipse cx="18" cy="11.28" fill="currentColor" rx="4.76" ry="4.7" />
                                <path fill="currentColor" d="M10.78 11.75h.48v-.43a6.7 6.7 0 0 1 3.75-6a4.62 4.62 0 1 0-4.21 6.46Zm13.98-.47v.43h.48A4.58 4.58 0 1 0 21 5.29a6.7 6.7 0 0 1 3.76 5.99m-2.47 5.17a21.45 21.45 0 0 1 5.71 2a2.71 2.71 0 0 1 .68.53H34v-3.42a.72.72 0 0 0-.38-.64a18 18 0 0 0-8.4-2.05h-.66a6.66 6.66 0 0 1-2.27 3.58M6.53 20.92A2.76 2.76 0 0 1 8 18.47a21.45 21.45 0 0 1 5.71-2a6.66 6.66 0 0 1-2.27-3.55h-.66a18 18 0 0 0-8.4 2.05a.72.72 0 0 0-.38.64V22h4.53Zm14.93 5.77h5.96v1.4h-5.96z" />
                                <path fill="currentColor" d="M32.81 21.26h-6.87v-1a1 1 0 0 0-2 0v1H22v-2.83a20.17 20.17 0 0 0-4-.43a19.27 19.27 0 0 0-9.06 2.22a.76.76 0 0 0-.41.68v5.61h7.11v6.09a1 1 0 0 0 1 1h16.17a1 1 0 0 0 1-1V22.26a1 1 0 0 0-1-1m-1 10.36H17.64v-8.36h6.3v.91a1 1 0 0 0 2 0v-.91h5.87Z" />
                            </svg>
                            <h5 class="card-title">Employee</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-2" style="padding-top: 15px; width: 200px; display: flex; justify-content: center;">
                <a href="./bisnis/create_bisnis.php" class="card-link">
                    <div class="card"> <!-- Ganti path_to_your_logo dengan path logo Anda -->
                        <div class="card-body">
                            <svg xmlns="http://www.w3.org/2000/svg" width="5em" height="4em" viewBox="0 0 24 24">
                                <rect width="24" height="24" fill="none" />
                                <path fill="currentColor" d="M18 15h-2v2h2m0-6h-2v2h2m2 6h-8v-2h2v-2h-2v-2h2v-2h-2V9h8M10 7H8V5h2m0 6H8V9h2m0 6H8v-2h2m0 6H8v-2h2M6 7H4V5h2m0 6H4V9h2m0 6H4v-2h2m0 6H4v-2h2m6-10V3H2v18h20V7z" />
                            </svg>
                            <h5 class="card-title">Settings</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-5" style="padding-left: 30px; padding-top: 15px; width: 200px; display: flex; justify-content: start;">
                <a href="./akses/index.php?id=<?php echo $userId; ?>" class="card-link">
                    <div class="card"> <!-- Ganti path_to_your_logo dengan path logo Anda -->
                        <div class="card-body">
                            <svg xmlns="http://www.w3.org/2000/svg" width="5em" height="4em" viewBox="0 0 24 24">
                                <rect width="24" height="24" fill="none" />
                                <path fill="currentColor" d="M5 10h5v2H5Zm3.54 12H4a2.006 2.006 0 0 1-2-2V6a2.006 2.006 0 0 1 2-2h4.18a2.988 2.988 0 0 1 5.64 0H18a2.006 2.006 0 0 1 2 2v6.09a5.989 5.989 0 0 0-1-.09h-1V9H4v4h5.69a6.04 6.04 0 0 0-1.878 2H4v4h3.09a5.973 5.973 0 0 0 1.45 3M10 5a1 1 0 1 0 1-1a1.003 1.003 0 0 0-1 1m7 6a1 1 0 1 0-1 1a1 1 0 0 0 1-1M5 18h2a5.96 5.96 0 0 1 .35-2H5Zm9-7a1 1 0 1 0-1 1a1 1 0 0 0 1-1m1 9h-2a2 2 0 0 1 0-4h2v-2h-2a4 4 0 0 0 0 8h2Zm8-2a4 4 0 0 1-4 4h-2v-2h2a2 2 0 0 0 0-4h-2v-2h2a4 4 0 0 1 4 4m-5 1h-4v-2h4Z" />
                            </svg>
                            <h5 class="card-title">Access Role</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>

</html>