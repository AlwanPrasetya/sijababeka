<?php
include('koneksi.php');
// Periksa apakah ada parameter 'id' dalam URL
if (isset($_GET['id'])) {
    // Ambil nilai ID dari URL
    $userId = $_GET['id'];

    // Lakukan kueri ke database untuk mendapatkan data pengguna berdasarkan ID
    $query = "SELECT nama, branch FROM multi_user WHERE id = $userId";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        // Menginisialisasi array untuk menyimpan nama cabang
        $branchNames = array();

        // Output data dari setiap baris
        while ($row = $result->fetch_assoc()) {
            $nama = $row["nama"];
            // echo "<h4>SELAMAT DATANG, <strong> $nama </strong> - <strong> HR UNIT </strong></h4>";

            // Lakukan kueri ke database untuk mendapatkan cabang dengan nama yang sama
            $queryBranches = "SELECT DISTINCT branch FROM multi_user WHERE nama = '$nama'";
            $resultBranches = $connection->query($queryBranches);

            if ($resultBranches->num_rows > 0) {
                // echo "<ul class='branch-list'>"; // Mulai daftar untuk mencetak cabang-cabang
                while ($rowBranch = $resultBranches->fetch_assoc()) {
                    // Tambahkan nama cabang ke array
                    $branchNames[] = $rowBranch["branch"];
                    // Cetak nama cabang dalam daftar
                    // echo "<li><strong>" . $rowBranch["branch"] . "</strong></li>";
                }
                // echo "</ul>"; // Akhiri daftar
            }
        }


        // Gabungkan nama cabang menjadi satu string dengan format yang diinginkan
        $branches = implode(', ', $branchNames);
    } else {
        echo "Data tidak ditemukan.";
    }
} else {
    // Jika parameter 'id' tidak ada dalam URL, tampilkan pesan kesalahan
    echo "Parameter 'id' tidak ditemukan dalam URL.";
}

// Tutup koneksi database
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPK Status</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        body {
            background-color: #EAFAF1;
       

        .container {
            padding: 100px;
        }

        .card {
            border-radius: 20px;
            height: 300px;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .card-one {
            background-color: #97edbb; /* Warna latar belakang kartu pertama */
        }

        .card-two {
            background-color: yellowgreen; /* Warna latar belakang kartu kedua */
        }

        .top-left-button {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .card-footer {
            position: absolute;
            bottom: 20px;
            right: 20px;
            left: 20px;
        }

        .btn-primary {
            background-color: #6c757d; /* Warna tombol */
            border-color: #6c757d; /* Warna border tombol */
        }

        .btn-primary:hover {
            background-color: #495057; /* Warna tombol saat dihover */
            border-color: #495057; /* Warna border tombol saat dihover */
        }

    }
    </style>
    
</head>
<body>
    <a href="../index.php?id=<?php echo $userId; ?>" class="top-left-button">
        <img src="./img/left-arrow.png " alt="" style="width: 40px; height: 40px; margin: 15px 15px;">
    </a>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card card-one text-center">
                    <div class="card-header">
                        <h5 class="card-title">FPK On Going</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">FPK dalam proses verifikasi.</p>
                    </div>
                    <div class="card-footer">
                        <a href="../fpk/Data.php?id=<?php echo $userId; ?>&branches=<?php echo $branches; ?>" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-two text-center">
                    <div class="card-header">
                        <h5 class="card-title">Vacant Positions</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Posisi FPK Yang sedang dicari dan telah disetujui.</p>
                    </div>
                    <div class="card-footer">
                        <a href="../fpk/applicants/hiringPositions.php?id=<?php echo $userId; ?>&branches=<?php echo $branches; ?>" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

