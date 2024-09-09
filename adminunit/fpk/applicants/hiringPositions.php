<?php
include('koneksi.php');

// Periksa apakah ada parameter 'id' dalam URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Lakukan kueri ke database untuk mendapatkan data pengguna berdasarkan ID
    $query = "SELECT nama, branch FROM multi_user WHERE id = $userId";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        $branchNames = array();

        while ($row = $result->fetch_assoc()) {
            $nama = $row["nama"];

            // Kueri untuk mendapatkan cabang dengan nama yang sama
            $queryBranches = "SELECT DISTINCT branch FROM multi_user WHERE nama = '$nama'";
            $resultBranches = $connection->query($queryBranches);

            if ($resultBranches->num_rows > 0) {
                while ($rowBranch = $resultBranches->fetch_assoc()) {
                    $branchNames[] = $rowBranch["branch"];
                }
            }
        }

        $branches = implode(', ', $branchNames);
    } else {
        echo "Data tidak ditemukan.";
    }
} else {
    echo "Parameter 'id' tidak ditemukan dalam URL.";
}

// Tutup koneksi database
$connection->close();
?>

<?php
include('koneksi.php');

// Kueri untuk mendapatkan hiring positions dan menghitung jumlah nilai level_candidates untuk setiap tahap
$query = "
    SELECT 
        hp.kodeFPK,
        hp.posisi,
        COUNT(CASE WHEN a.level_candidates = 0 THEN 1 END) AS applicants,
        COUNT(CASE WHEN a.level_candidates = 1 THEN 1 END) AS interview_hr,
        COUNT(CASE WHEN a.level_candidates = 2 THEN 1 END) AS interview_user,
        COUNT(CASE WHEN a.level_candidates = 3 THEN 1 END) AS psikotes,
        COUNT(CASE WHEN a.level_candidates = 4 THEN 1 END) AS mcu,
        COUNT(CASE WHEN a.level_candidates = 5 THEN 1 END) AS offer,
        COUNT(CASE WHEN a.level_candidates = 6 THEN 1 END) AS accept
    FROM hiring_positions hp
    LEFT JOIN applicants a ON hp.kodeFPK = a.kodeFPK
    GROUP BY hp.kodeFPK, hp.posisi
";
$result = mysqli_query($connection, $query);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Hiring Positions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            width: 60px;
            margin: 0 auto;
            /* Center the div horizontally */
        }

        .app a {
            color: white !important;
            font-weight: bold !important;
            display: block;
            /* Ensure the link occupies the full width of the .app div */
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
                                            <th>Interview HR</th>
                                            <th>Interview User</th>
                                            <th>Psikotes</th>
                                            <th>MCU</th>
                                            <th>Offer</th>
                                            <th>Accept</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['kodeFPK'] . " - " . $row['posisi'] . "</td>";
                                            echo "<td>
                <div class='app'>
                    <a href='detail_applicants.php?id=" . $userId . "&branches=" . $branches  . "&posisi=" . $row['posisi'] . "&KodeFPK=" . $row['kodeFPK'] . "'>" . $row['applicants'] . "</a>
                </div>
            </td>";
                                            echo "<td><div class='app'><a href='detail_interview_hr.php?id=" . $userId . "&branches=" . $branches  . "&posisi=" . $row['posisi'] . "&KodeFPK=" . $row['kodeFPK'] . "'>" . $row['interview_hr'] . "</a></div></td>";
                                            echo "<td><div class='app'><a href='detail_interview_user.php?id=" . $userId . "&branches=" . $branches  . "&posisi=" . $row['posisi'] . "&KodeFPK=" . $row['kodeFPK'] . "'>" . $row['interview_user'] . "</a></div></td>";
                                            echo "<td><div class='app'><a href='detail_psikotest.php?id=" . $userId . "&branches=" . $branches  . "&posisi=" . $row['posisi'] . "&KodeFPK=" . $row['kodeFPK'] . "'>" . $row['psikotes'] . "</a></div></td>";
                                            echo "<td><div class='app'><a href='detail_mcu.php?id=" . $userId . "&branches=" . $branches  . "&posisi=" . $row['posisi'] . "&KodeFPK=" . $row['kodeFPK'] . "'>" . $row['mcu'] . "</a></div></td>";
                                            echo "<td><div class='app'><a href='detail_offer.php?id=" . $userId . "&branches=" . $branches  . "&posisi=" . $row['posisi'] . "&KodeFPK=" . $row['kodeFPK'] . "'>" . $row['offer'] . "</a></div></td>";
                                            echo "<td><div class='app'><a href='detail_accept.php?id=" . $userId . "&branches=" . $branches  . "&posisi=" . $row['posisi'] . "&KodeFPK=" . $row['kodeFPK'] . "'>" . $row['accept'] . "</a></div></td>";
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
</script>

</html>