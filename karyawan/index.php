<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Depthead</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #EAFAF1;
        }

        .card {
            background-color: yellowgreen;
            margin-bottom: 20px;
            height: 190px;
            position: relative;
        }

        h4 {
            color: #008F4D;
            text-align: center;
            margin-top: 30px;
            position: relative;
            /* Tambahkan properti ini agar bisa menempatkan logo di atas judul */
        }

        h5 {
            text-align: center;
            margin-top: 10px;
        }

        img.logo {
            max-width: 120px;
            /* Atur lebar maksimum logo */
            position: absolute;
            /* Atur posisi menjadi absolute agar bisa menggunakan left */
            left: 50%;
            /* Posisikan ke tengah horizontal */
            transform: translateX(-50%);
            /* Geser ke kiri sejauh setengah dari lebar gambar */
            top: 10px;
            /* Letakkan logo 10px dari bagian atas */
            z-index: 1;
            /* Pastikan logo berada di depan judul */
        }


        .card-body {
            text-align: center;
            padding: 40px 30px;
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

        .row {
            padding: 50px;
        }

        /* Media queries untuk layout responsif */
        @media (max-width: 768px) {
            .card {
                height: auto;
                /* Set ulang tinggi kartu agar bisa menyesuaikan konten */
            }

            .card img {
                top: -100px;
                /* Atur ulang posisi logo */
                max-width: 100px;
                /* Atur ulang lebar maksimum logo */
                max-height: 100px;
                /* Atur ulang tinggi maksimum logo */
            }

            .card-body {
                padding: 20px 20px;
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

        /* CSS untuk daftar cabang-cabang */
        .branch-list {
            list-style-type: none;
            padding-top: 10px;
            text-align: center;
            font-size: 20px;
            margin-left: -15px;
        }

        .branch-list li {
            margin-bottom: 5px;
            color: #333;
        }

        .branch-list li:before {
            content: "\2022";
            /* kode untuk bullet (titik) */
            /* warna bullet */
            display: none;
            width: 1em;
        }

        /* Gaya tambahan untuk header */
        .header {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <img src="./img/logo-jababeka.png" alt="Logo" style="width: 10%; display: block; margin: 0 auto; padding-top: 20px;"><!-- Ganti path_to_your_logo dengan path logo Anda -->
    <?php

    include('koneksi.php');

    // Periksa apakah ada parameter 'id' dalam URL
    if (isset($_GET['id'])) {
        // Ambil nilai ID dari URL
        $userId = $_GET['id'];

        // Periksa apakah ada parameter 'branch' dalam URL
        if (isset($_GET['branch'])) {
            $branch = $_GET['branch'];
        } else {
            $branch = ""; // Berikan nilai default jika parameter 'branch' tidak ada dalam URL
        }

        if (isset($_GET['id_biodata'])) {
            $id_biodata = $_GET['id_biodata'];
        } else {
            $id_biodata = ""; // Berikan nilai default jika parameter 'branch' tidak ada dalam URL
        }

        // Lakukan kueri ke database untuk mendapatkan data pengguna berdasarkan ID
        $query = "SELECT nama FROM multi_user WHERE id = $userId";
        $result = $koneksi->query($query);

        if ($result->num_rows > 0) {
            // Output data dari setiap baris
            while ($row = $result->fetch_assoc()) {
                $nama = $row["nama"];
                echo "<h4>Selamat Datang, <strong> $nama </strong> </h4>";
                echo "<h5>Silahkan lengkapi Data Diri</h5>";
            }
        } else {
            echo "Data tidak ditemukan.";
        }
    } else {
        // Jika parameter 'id' tidak ada dalam URL, tampilkan pesan kesalahan
        echo "Parameter 'id' tidak ditemukan dalam URL.";
    }

    // Tutup koneksi database
    $koneksi->close();
    ?>
    <!-- Bagian HTML -->
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="biodata-tambah.php?id_biodata=<?php echo $id_biodata; ?>" class="card-link">
                    <div class="card">
                        <div class="card-body">
                            <svg xmlns="http://www.w3.org/2000/svg" width="5em" height="5em" viewBox="0 0 45 45">
                                <rect width="45" height="45" fill="none" />
                                <g fill="currentColor">
                                    <path d="M17 31v-2h2v2z" />
                                    <path fill-rule="evenodd" d="M20 4a3 3 0 0 0-3 3h-4a3 3 0 0 0-3 3v31a3 3 0 0 0 3 3h22a3 3 0 0 0 3-3V10a3 3 0 0 0-3-3h-4a3 3 0 0 0-3-3zm-1 3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-8a1 1 0 0 1-1-1zm-3 13a1 1 0 1 0 0 2h7a1 1 0 1 0 0-2zm-1-4a1 1 0 0 1 1-1h15.5a1 1 0 1 1 0 2H16a1 1 0 0 1-1-1m0 12a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1zm13 4a3 3 0 1 0 0-6a3 3 0 1 0 0 6m-6 4.5c0-2.116 3.997-3.182 6-3.182s6 1.066 6 3.182V39H22z" clip-rule="evenodd" />
                                </g>
                            </svg>
                            <h5 class="card-title">Biodata <br> Kandidat</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="hiring-confirmation.php?id_biodata=<?php echo $id_biodata; ?>" class=" card-link">
                    <div class="card">
                        <div class="card-body">
                            <svg xmlns="http://www.w3.org/2000/svg" width="5em" height="5em" viewBox="0 0 48 48">
                                <rect width="48" height="48" fill="none" />
                                <defs>
                                    <mask id="ipSUploadWeb0">
                                        <g fill="none">
                                            <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M28 40H7a3 3 0 0 1-3-3V11a3 3 0 0 1 3-3h34a3 3 0 0 1 3 3v12.059M39 41V29m-5 5l5-5l5 5" />
                                            <path fill="#fff" stroke="#fff" stroke-width="4" d="M4 11a3 3 0 0 1 3-3h34a3 3 0 0 1 3 3v9H4z" />
                                            <circle r="2" fill="#000" transform="matrix(0 -1 -1 0 10 14)" />
                                            <circle r="2" fill="#000" transform="matrix(0 -1 -1 0 16 14)" />
                                        </g>
                                    </mask>
                                </defs>
                                <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSUploadWeb0)" />
                            </svg>
                            <h5 class="card-title">Unggah Dokumen</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>

</html>