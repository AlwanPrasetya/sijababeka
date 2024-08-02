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
            } else {
                // echo "<h4><strong> Tidak ada cabang dengan nama yang sama. </strong></h4>";
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
<?php
include('koneksi.php');

$query = "SELECT * from hiring_positions";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Hiring Positions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <style>
        body {
            background-color: #EAFAF1;
        }

        .container {
            padding: 0.1px;
        }

        .card {
            border-radius: 20px;
            height: auto;
            width: 100%;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
            position: relative;
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

        .app {
            background-color: yellowgreen;
            border-radius: 4px;
            text-align: center;
            font-weight: bold;
        }

        .white-bold-text {
            color: white !important;
            font-weight: bold !important;
        }
    </style>
</head>

<body>

    <a href="../typeFPK.php?id=<?php echo $userId; ?>" class="top-left-button">
        <img src="../img/left-arrow.png" alt="" style="width: 40px; height: 40px; margin: 15px 15px;">
    </a>

    <div class="container-content">
        <div class="container" style="margin-top: 80px">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #008F4D; color: white;">
                            TABEL VACANT POSITIONS
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="myTable" style="white-space: nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    <thead>
                                        <tr>
                                            <th>Posisi</th>
                                            <th>Applicants</th>
                                            <!-- <th>Candidates</th> -->
                                            <th>Interview HR</th>
                                            <th>Interview User</th>
                                            <th>Psikotes</th>
                                            <th>MCU</th>
                                            <th>Offer</th>
                                            <th>Accept</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['kodeFPK'] . " - " . $row['posisi'] . "</td>";
                                            echo "<td><div class='app'><a href='detail_applicants.php?id=" . $userId ."&branches=" . $branches  . "&posisi=" . $row['posisi']. "&KodeFPK=" . $row['kodeFPK'] . "' style='color: white !important; font-weight: bold !important;'>" . $row['applicants'] . "</a></div></td>";
                                            echo "<td>" . $row['kandidat'] . "</td>";
                                            echo "<td>" . $row['interviewHr'] . "</td>";
                                            echo "<td>" . $row['interviewUser'] . "</td>";
                                            echo "<td>" . $row['psikotes'] . "</td>";
                                            echo "<td>" . $row['offer'] . "</td>";
                                            echo "<td>" . $row['accept'] . "</td>";
                                            echo "<td>" . $row['accept'] . "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });

    $('#toggler').click(function() {
        $('#sidebar').toggleClass('active');
    });
</script>

</html>