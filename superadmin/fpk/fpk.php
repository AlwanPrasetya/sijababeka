<?php
// Koneksi ke database
$servername = "localhost"; // Ganti sesuai dengan server database Anda
$username = "alwan"; // Ganti sesuai dengan username database Anda
$password = "root"; // Ganti sesuai dengan password database Anda
$database = "db_sijababeka"; // Ganti sesuai dengan nama database Anda

// Buat koneksi
$connection = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($connection->connect_error) {
    die("Koneksi gagal: " . $connection->connect_error);
}

// Fungsi untuk mendapatkan data karyawan
function getEmployeeData($connection)
{
    $sql = "SELECT kode, nama, bisnis, organisasi, golongan, jabatan, status FROM karyawan"; // Sesuaikan dengan struktur tabel karyawan Anda
    $result = $connection->query($sql);

    $employeeData = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $employeeData[] = $row;
        }
    }

    return $employeeData;
}

// Panggil fungsi untuk mendapatkan data karyawan
$employeeData = getEmployeeData($connection);

// Fungsi untuk mendapatkan data employee_transfer
function getTransferData($connection)
{
    $sql = "SELECT nama, request_type, effective_date, reason  FROM employee_transfer"; // Sesuaikan dengan struktur tabel employee_transfer Anda
    $result = $connection->query($sql);

    $transferData = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transferData[] = $row;
        }
    }

    return $transferData;
}

// Panggil fungsi untuk mendapatkan data employee_transfer
$transferData = getTransferData($connection);
?>

<?php

// Tampilkan kembali data yang disimpan dalam sesi
if (isset($_SESSION['effective_date']) && isset($_SESSION['reason'])) {
    // Gunakan data untuk menampilkan kembali tampilan sebelumnya
    $effective_date = $_SESSION['effective_date'];
    $reason = $_SESSION['reason'];
} else {
}

if (isset($_GET['branch'])) {
    // Ambil nilai branch dari URL
    $branch = $_GET['branch'];
} else {
    // Jika nilai branch tidak ditemukan dalam URL
    echo "Nilai branch tidak ditemukan dalam URL.";
}
?>
<?php
if (isset($_GET['id'])) {
    // Check if 'id' is set in the session
    // if (!isset($_SESSION['id'])) {
    // echo "User ID is not set in the session.";
    // exit();
    // }

    // Get the user ID from the session
    $userId = $_GET['id'];

    // Perform database query to get branch based on user ID
    // Replace the query below with the appropriate query for your database structure
    // Make sure $connection is properly initialized
    $query = "SELECT branch, nama FROM multi_user WHERE id = $userId"; // Perhatikan perubahan disini: $userId
    $result = $connection->query($query);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Permintaan Karyawan</title>
    <style>
        /* CSS untuk styling halaman */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            background-color: #EAFAF1;
        }

        .container {
            align-items: left;
            max-width: 900px;
            width: 100%;
        }

        .form-container {
            display: flex;
            width: 100%;
        }

        form {
            width: 100%;
            /* Lebar masing-masing form */
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Atur jarak antara elemen input/select dan tombol */
        input[type="submit"],
        input[type="reset"] {
            margin-top: 10px;
        }

        .qualification-title {
            text-align: left;
        }

        h2 {
            text-align: center;
        }


        .database {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .dashboard {
            position: absolute;
            top: 20px;
            left: 20px;
        }
    </style>

</head>

<body>
    <div class="container">

        <a href="data.php?id=<?php echo $userId; ?>&branch=<?php echo $branch; ?>" class="database">
            <img src="./img/database (1).png" alt="database" style="width: 40px; height: 40px; margin: 15px 15px;"></a>

        <a href="../superadmin.php?id=<?php echo $userId; ?>" class="dashboard">
            <img src="./img/dashboard (1).png" alt="dashboard" style="width: 40px; height: 40px; margin: 15px 15px;"></a>


        <style>
            .card {
                width: 900px;
                border-radius: 10px;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
                overflow: hidden;
                background-color: #fff;
            }

            .card img {
                width: 900px;
                /* Lebar gambar 1200px */
                height: 150px;
                /* Tinggi gambar 150px */
                border-radius: 10px 10px 0 0;
            }

            .card-content {
                width: 900px;
                /* Lebar gambar 1200px */
                padding: 20px;
            }

            .card-content h3 {
                margin-top: 0;
                font-size: 1.5rem;
            }

            .card-content p {
                margin-bottom: 0;
            }

            /* CSS */
            #checkEmployeeTransferBtn {
                background-color: #4CAF50;
                /* Warna latar hijau */
                border: none;
                color: white;
                /* Warna teks putih */
                padding: 5px 10px;
                /* Padding atas dan bawah 15px, padding kiri dan kanan 32px */
                text-align: center;
                /* Teks rata tengah */
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                /* Margin atas dan bawah 4px, margin kiri dan kanan 2px */
                cursor: pointer;
                border-radius: 6px;
                /* Border radius 8px */
                transition-duration: 0.4s;
                /* Durasi animasi saat perubahan warna */
            }

            #checkEmployeeTransferBtn:hover {
                background-color: #45a049;
                /* Warna latar belakang lebih gelap saat hover */
            }
        </style>
        <div class="card">
            <img src="img/header-fpk.png" alt="Placeholder Image">
            <div class="card-content">
                <form action="save_fpk.php?branch=<?php echo $branch; ?>" method="POST" onsubmit="return validateForm()">
                    <!-- <h2>FORMULIR PERMINTAAN KARYAWAN</h2> -->
                    <?php
                    // Fungsi untuk menghasilkan kode acak dengan huruf besar dan angka
                    function generateRandomCode($length = 8)
                    {
                        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                        $randomString = '';
                        for ($i = 0; $i < $length; $i++) {
                            $randomString .= $characters[rand(0, strlen($characters) - 1)];
                        }
                        return $randomString;
                    }
                    ?>
                    <!-- Kemudian dalam formulir HTML Anda -->

                    <div id="mainForm">
                        <div class="row" style="justify-content: center; margin-right: 30px;">
                            <div class="col-md-12">
                                <label for="kodeFPK" style="display: inline-block; width: 100px;">Kode FPK:</label>
                                <input type="text" id="kodeFPK" name="kodeFPK" style="width: 100px;" value="<?php echo substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8); ?>" readonly>

                                <!-- Form untuk permintaan -->
                                <label for="" style="display: inline-block; width: 200px;">
                                    <select id="request_type" name="requestFor" style="width: 200px;">
                                        <option value="">Pilih Jenis Permintaan</option>
                                        <option value="PHK" <?php echo isset($_GET['request_type']) && $_GET['request_type'] === 'PHK' ? 'selected' : ''; ?>>PHK</option>
                                        <option value="Resign" <?php echo isset($_GET['request_type']) && $_GET['request_type'] === 'Resign' ? 'selected' : ''; ?>>Resign</option>
                                        <option value="Mutasi" <?php echo isset($_GET['request_type']) && $_GET['request_type'] === 'Mutasi' ? 'selected' : ''; ?>>Mutasi</option>
                                        <option value="Promosi" <?php echo isset($_GET['request_type']) && $_GET['request_type'] === 'Promosi' ? 'selected' : ''; ?>>Promosi</option>
                                        <option value="Demosi" <?php echo isset($_GET['request_type']) && $_GET['request_type'] === 'Demosi' ? 'selected' : ''; ?>>Demosi</option>
                                        <option value="Rotasi" <?php echo isset($_GET['request_type']) && $_GET['request_type'] === 'Rotasi' ? 'selected' : ''; ?>>Rotasi</option>
                                        <option value="karyawanBaru" <?php echo isset($_GET['request_type']) && $_GET['request_type'] === 'Rotasi' ? 'selected' : ''; ?>>New Hire</option>
                                    </select></label>
                                <!-- Tombol "Check Employee Transfer" -->
                                <button type="button" id="checkEmployeeTransferBtn" onclick="redirectToEmployeeTransfer()">Employee Transfer</button>
                            </div>
                        </div>
                    </div>

                    <!-- Form Resign -->
                    <div class="form-section" id="ResignForm" style="display: none;">
                        <h3 class="text-center mb-4" style="margin-top: 10px; text-align: left;">Form Resign</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="NamaFPK">Karyawan Pengganti:</label>
                                <input type="text" id="NamaFPK" name="NamaFPK" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama']) ? $_GET['nama'] : ''; ?>" readonly>

                                <label for="branch">Unit:</label>
                                <input type="text" id="branch" name="branch" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_unit']) ? $_GET['nama_unit'] : ''; ?>" readonly>

                                <label for="jabatan">Jabatan:</label>
                                <input type="text" id="jabatan" name="jabatan" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_jabatan']) ? $_GET['nama_jabatan'] : ''; ?>" readonly>

                            </div>

                            <div class="col-md-6">
                                <label for="organisasi">Organisasi:</label>
                                <input type="text" id="organisasi" name="organisasi" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_organisasi']) ? $_GET['nama_organisasi'] : ''; ?>" readonly>

                                <label for="golongan">Golongan:</label>
                                <input type="text" id="golongan" name="golongan" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_golongan']) ? $_GET['nama_golongan'] : ''; ?>" readonly>

                                <label for="effectiveDate">Tanggal Efektif:</label>
                                <input type="date" id="effectiveDate" name="effectiveDate" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['effective_date']) ? $_GET['effective_date'] : ''; ?>" readonly>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="reason">Alasan:</label>
                            <textarea id="reason" name="reason" style="width: 850px;" class="form-control" rows="4"><?php echo isset($_GET['reason']) ? $_GET['reason'] : ''; ?></textarea>
                        </div>
                    </div>

                    <!-- Form PHK -->
                    <div class="form-section" id="PHKForm" style="display: none;">
                        <h3 class="text-center mb-4" style="margin-top: 10px; text-align: left;">Form PHK</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="PHKEmployee">Karyawan Pengganti:</label>
                                <input type="text" id="PHKEmployee" name="PHKEmployee" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama']) ? $_GET['nama'] : ''; ?>" readonly>

                                <label for="branch">Unit:</label>
                                <input type="text" id="branch" name="branch" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_unit']) ? $_GET['nama_unit'] : ''; ?>" readonly>

                                <label for="jabatan">Jabatan:</label>
                                <input type="text" id="jabatan" name="jabatan" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_jabatan']) ? $_GET['nama_jabatan'] : ''; ?>" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="organisasi">Organisasi:</label>
                                <input type="text" id="organisasi" name="organisasi" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_organisasi']) ? $_GET['nama_organisasi'] : ''; ?>" readonly>

                                <label for="golongan">Golongan:</label>
                                <input type="text" id="golongan" name="golongan" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_golongan']) ? $_GET['nama_golongan'] : ''; ?>" readonly>

                                <label for="effectiveDate">Tanggal Efektif:</label>
                                <input type="date" id="effectiveDate" name="effectiveDate" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['effective_date']) ? $_GET['effective_date'] : ''; ?>" readonly>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <label for="reason">Alasan:</label>
                            <textarea id="reason" name="reason" style="width: 850px;" class="form-control" rows="4"><?php echo isset($_GET['reason']) ? $_GET['reason'] : ''; ?></textarea>
                        </div>
                    </div>


                    <!-- Form Mutasi, Promosi, Demosi -->
                    <div class="form-section" id="PromosiForm" style="display: none;">
                        <h3 class="text-center mb-4" style="margin-top: 30px; text-align: left;">Form Promosi</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="mutName">Yang Promosi:</label>
                                <input type="text" id="mutName" name="mutName" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama']) ? $_GET['nama'] : ''; ?>" readonly>

                                <label for="branch">Unit:</label>
                                <input type="text" id="branch" name="branch" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_unit']) ? $_GET['nama_unit'] : ''; ?>" readonly>

                                <label for="jabatan">Jabatan:</label>
                                <input type="text" id="jabatan" name="jabatan" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_jabatan']) ? $_GET['nama_jabatan'] : ''; ?>" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="organisasi">Organisasi:</label>
                                <input type="text" id="organisasi" name="organisasi" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_organisasi']) ? $_GET['nama_organisasi'] : ''; ?>" readonly>

                                <label for="golongan">Golongan:</label>
                                <input type="text" id="golongan" name="golongan" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_golongan']) ? $_GET['nama_golongan'] : ''; ?>" readonly>

                                <label for="effectiveDate">Tanggal Efektif:</label>
                                <input type="date" id="effectiveDate" name="effectiveDate" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['effective_date']) ? $_GET['effective_date'] : ''; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="reason">Alasan:</label>
                            <textarea id="reason" name="reason" style="width: 850px;" class="form-control" rows="4"><?php echo isset($_GET['reason']) ? $_GET['reason'] : ''; ?></textarea>
                        </div>
                    </div>

                    <div class="form-section" id="MutasiForm" style="display: none;">
                        <h3 class="text-center mb-4" style="margin-top: 10px; text-align: left;">Form Mutasi</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="mutName">Yang Mutasi:</label>
                                <input type="text" id="mutName" name="mutName" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama']) ? $_GET['nama'] : ''; ?>" readonly>

                                <label for="branch">Unit:</label>
                                <input type="text" id="branch" name="branch" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_unit']) ? $_GET['nama_unit'] : ''; ?>" readonly>

                                <label for="jabatan">Jabatan:</label>
                                <input type="text" id="jabatan" name="jabatan" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_jabatan']) ? $_GET['nama_jabatan'] : ''; ?>" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="organisasi">Organisasi:</label>
                                <input type="text" id="organisasi" name="organisasi" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_organisasi']) ? $_GET['nama_organisasi'] : ''; ?>" readonly>

                                <label for="golongan">Golongan:</label>
                                <input type="text" id="golongan" name="golongan" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_golongan']) ? $_GET['nama_golongan'] : ''; ?>" readonly>

                                <label for="effectiveDate">Tanggal Efektif:</label>
                                <input type="date" id="effectiveDate" name="effectiveDate" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['effective_date']) ? $_GET['effective_date'] : ''; ?>" readonly>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="reason">Alasan:</label>
                            <textarea id="reason" name="reason" style="width: 850px;" class="form-control" rows="4"><?php echo isset($_GET['reason']) ? $_GET['reason'] : ''; ?></textarea>
                        </div>
                    </div>

                    <div class="form-section" id="DemosiForm" style="display: none;">
                        <h3 class="text-center mb-4" style="margin-top: 10px; text-align: left;">Form Demosi</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="mutName">Yang Demosi:</label>
                                <input type="text" id="mutName" name="mutName" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama']) ? $_GET['nama'] : ''; ?>" readonly>

                                <label for="branch">Unit:</label>
                                <input type="text" id="branch" name="branch" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_unit']) ? $_GET['nama_unit'] : ''; ?>" readonly>

                                <label for="jabatan">Jabatan:</label>
                                <input type="text" id="jabatan" name="jabatan" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_jabatan']) ? $_GET['nama_jabatan'] : ''; ?>" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="organisasi">Organisasi:</label>
                                <input type="text" id="organisasi" name="organisasi" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_organisasi']) ? $_GET['nama_organisasi'] : ''; ?>" readonly>

                                <label for="golongan">Golongan:</label>
                                <input type="text" id="golongan" name="golongan" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['nama_golongan']) ? $_GET['nama_golongan'] : ''; ?>" readonly>

                                <label for="effectiveDate">Tanggal Efektif:</label>
                                <input type="date" id="effectiveDate" name="effectiveDate" style="width: 390px;" class="form-control" value="<?php echo isset($_GET['effective_date']) ? $_GET['effective_date'] : ''; ?>" readonly>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="reason">Alasan:</label>
                            <textarea id="reason" name="reason" style="width: 850px;" class="form-control" rows="4"><?php echo isset($_GET['reason']) ? $_GET['reason'] : ''; ?></textarea>

                        </div>
                    </div>


                    <!-- Form New Hire -->
                    <div class="form-section" id="karyawanBaruForm" style="display: none;">
                        <h3 class="text-center mb-4" style="margin-top: 10px; text-align: left;">Form New Hire</h3>
                        <div class="form-box">
                            <!-- <form action="proses_Promosi.php" method="post"> -->
                            <label for="karyawanBaru">New Hire:</label>
                            <input type="text" id="karyawanBaru" name="karyawanBaru" style="width: 850px;" value="<?php echo isset($_GET['nama']) ? $_GET['nama'] : ''; ?>" readonly>

                            <label for="branch">Unit:</label>
                            <input type="text" id="branch" name="branch" style="width: 850px;" value="<?php echo isset($_GET['nama_unit']) ? $_GET['nama_unit'] : ''; ?>" readonly>

                            <label for="jabatan">Jabatan:</label>
                            <input type="text" id="jabatan" name="jabatan" style="width: 850px;" value="<?php echo isset($_GET['nama_jabatan']) ? $_GET['nama_jabatan'] : ''; ?>" readonly>

                            <label for="organisasi">organisasi:</label>
                            <input type="text" id="organisasi" name="organisasi" style="width: 850px;" value="<?php echo isset($_GET['nama_organisasi']) ? $_GET['nama_organisasi'] : ''; ?>" readonly>

                            <label for="golongan">Golongan:</label>
                            <input type="text" id="golongan" name="golongan" style="width: 850px;" value="<?php echo isset($_GET['nama_golongan']) ? $_GET['nama_golongan'] : ''; ?>" readonly>

                            <label for="effectiveDate">Tanggal Efektif</label>
                            <input type="date" id="effectiveDate" name="effectiveDate" style="width: 850px;" value="<?php echo isset($_GET['effective_date']) ? $_GET['effective_date'] : ''; ?>" readonly>

                            <label for="reason">Alasan</label>
                            <textarea id="reason" name="reason" style="width: 850px;" rows="4"><?php echo isset($_GET['reason']) ? $_GET['reason'] : ''; ?></textarea>

                            <!-- </form> -->
                        </div>
                    </div>

                    <style>
                        .row {
                            display: flex;
                            /* justify-content: space-between; */
                        }

                        .col-md-6 {
                            flex: 0 0 calc(50% - 10px);
                            /* Set lebar 50% dengan margin 10px */
                            margin-right: 20px;
                            /* Margin antar kolom */
                        }

                        .col-md-3 {
                            flex: 0 0 calc(25% - 10px);
                            /* Set lebar 50% dengan margin 10px */
                            margin-right: 2px;
                            /* Margin antar kolom */
                        }

                        input[type="text"],
                        textarea {
                            width: 100%;
                        }
                    </style>
                    <br>
                    <!-- 
                <h3 class="text-center mb-4">FORM PEREQUEST</h3>

                <div style="display: flex; flex-wrap: wrap; margin-bottom: 20px;">

                    <div style="flex: 1; margin-right: 20px;">
                        <label for="nama">Nama:</label>
                        <select id="nama" name="nama" style="width: 100%;">
                            <option value="">Pilih Nama</option>
                            /
                        </select>
                    </div>
                </div>

                <div style="display: flex; flex-wrap: wrap; margin-bottom: 20px;">
                    <div style="flex: 1; margin-right: 20px;">
                        <label for="kode">Employee ID:</label>
                        <select id="kode" name="kode" style="width: 100%;">
                            <option value="">Pilih Employee ID</option>
                          /
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <label for="golongan">Golongan:</label>
                        <input type="text" id="golongan" name="golongan" style="width: 100%;">
                    </div>
                </div>

                <div style="display: flex; flex-wrap: wrap; margin-bottom: 20px;">
                    <div style="flex: 1; margin-right: 20px;">
                        <label for="bisnis">Bisnis:</label>
                        <input type="text" id="bisnis" name="bisnis" style="width: 100%;">
                    </div>
                    <div style="flex: 1;">
                        <label for="organisasi">Departemen:</label>
                        <input type="text" id="organisasi" name="organisasi" style="width: 100%;">
                    </div>
                </div>

                <div style="display: flex; flex-wrap: wrap; margin-bottom: 20px;">
                    <div style="flex: 1; margin-right: 20px;">
                        <label for="jabatan">Jabatan:</label>
                        <input type="text" id="jabatan" name="jabatan" style="width: 100%;">
                    </div>
                    <div style="flex: 1;">
                        <label for="lokasi_kerja">lokasi kerja:</label>
                        <input type="text" id="lokasi_kerja" name="lokasi_kerja" style="width: 100%;">
                    </div>
                </div>

                <div style="display: flex; flex-wrap: wrap;">
                    <div style="flex: 1; margin-right: 20px;">
                        <label for="divisi">Divisi:</label>
                        <input type="text" id="divisi" name="divisi" style="width: 100%;">
                    </div>
                    <div style="flex: 1;">
                        <label for="status">Status:</label>
                        <input type="text" id="status" name="status" style="width: 100%;">
                    </div>
                </div> -->

                    <script>
                        // Script untuk mengisi nilai kolom jenis permintaan dan membuka kolom formulir yang sesuai
                        document.addEventListener("DOMContentLoaded", function() {
                            // Mendapatkan parameter dari URL
                            const urlParams = new URLSearchParams(window.location.search);
                            const request_type = urlParams.get('request_type');

                            // Mengisi nilai kolom jenis permintaan
                            if (request_type) {
                                document.getElementById("request_type").value = request_type;

                                // Menampilkan atau menyembunyikan formulir isian sesuai dengan jenis permintaan
                                if (request_type === "Resign") {
                                    document.getElementById("ResignForm").style.display = "block";
                                } else if (request_type === "PHK") {
                                    document.getElementById("PHKForm").style.display = "block";
                                } else if (request_type === "Mutasi") {
                                    document.getElementById("MutasiForm").style.display = "block";
                                } else if (request_type === "Promosi") {
                                    document.getElementById("PromosiForm").style.display = "block";
                                } else if (request_type === "Demosi") {
                                    document.getElementById("DemosiForm").style.display = "block";
                                }
                            }
                        });
                    </script>
                    <script>
                        // Mendengarkan klik tombol "Check Employee Transfer" dan melakukan redirect
                        document.getElementById("checkEmployeeTransferBtn").addEventListener("click", function() {
                            // Ambil nilai dari input kodeFPK
                            var kodeFPK = document.getElementById('kodeFPK').value;
                            // Ambil nilai dari select request_type
                            var requestType = document.getElementById('request_type').value;

                            // Redirect ke halaman lain dengan menyertakan nilai branch, kodeFPK, dan request_type
                            window.location.href = "../karyawan/employee_transfer/index.php?branch=<?php echo $branch; ?>&kodeFPK=" + encodeURIComponent(kodeFPK) + "&request_type=" + encodeURIComponent(requestType);
                        });
                    </script>
                    <br>

                    <div id="qualificationForm" class="employee-form">
                        <h3>KUALIFIKASI</h3>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="question" for="gender"><b>Jenis Kelamin:</b></label>
                                <label class="answer" for="male"><input type="radio" id="male" name="gender" value="male">Laki-laki</label>
                                <label class="answer" for="female"><input type="radio" id="female" name="gender" value="female">Perempuan</label><br>
                                <label class="question" for="age"><b>Usia:</b></label>
                                <input type="number" id="age" name="age" style="width: 50px;"><br>
                            </div>
                            <div class="col-md-3">
                                <label class="question" for="experience"><b>Pengalaman:</b></label>
                                <label class="answer" for="0"><input type="radio" id="0" name="experience" value="0">0 TH</label>
                                <label class="answer" for="1-2"><input type="radio" id="1-2" name="experience" value="1-2">1-2 TH</label>
                                <label class="answer" for="3-5"><input type="radio" id="3-5" name="experience" value="3-5">3-5 TH</label>
                                <label class="answer" for="5"><input type="radio" id="5" name="experience" value="5">> 5 TH</label><br>
                            </div>
                            <div class="col-md-3">
                                <label class="question" for="education"><b>Pendidikan:</b></label>
                                <label class="answer" for="highschool"><input type="radio" id="highschool" name="education" value="highschool">SMA/SMK</label>
                                <label class="answer" for="diploma"><input type="radio" id="diploma" name="education" value="diploma">DIII</label>
                                <label class="answer" for="bachelor"><input type="radio" id="bachelor" name="education" value="bachelor">S1</label>
                                <label class="answer" for="master"><input type="radio" id="master" name="education" value="master">S2</label>
                                <label class="answer" for="phd"><input type="radio" id="phd" name="education" value="phd">S3</label><br>
                            </div>
                            <div class="col-md-3">
                                <label class="question" for="major"><b>Jurusan:</b></label>
                                <input type="text" id="major" name="major" style="width: 150px;"><br><br>
                                <label for="lokasi"><b>Lokasi Kerja:</b></label>
                                <select id="lokasi" name="lokasi" style="width: 150px;">
                                    <option value="">Pilih Lokasi Kerja</option>
                                    <?php
                                    // Koneksi ke database
                                    $servername = "localhost";
                                    $username = "alwan";
                                    $password = "root";
                                    $dbname = "db_sijababeka";

                                    // Buat koneksi
                                    $conn = new mysqli($servername, $username, $password, $dbname);

                                    // Periksa koneksi
                                    if ($conn->connect_error) {
                                        die("Koneksi gagal: " . $conn->connect_error);
                                    }

                                    // Query SQL untuk mengambil lokasi kerja dari tabel lokasi_kerja
                                    $sql = "SELECT nama_lokasi_kerja FROM lokasi_kerja";
                                    $result = $conn->query($sql);

                                    // Periksa apakah hasil query tidak kosong
                                    if ($result->num_rows > 0) {
                                        // Loop melalui setiap baris hasil query dan tampilkan sebagai opsi dropdown
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row["nama_lokasi_kerja"] . '">' . $row["nama_lokasi_kerja"] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">Tidak ada data lokasi kerja</option>';
                                    }

                                    // Tutup koneksi
                                    $conn->close();
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="question" for="jobDescription"><b>Uraian Pekerjaan:</b></label>
                            <textarea id="jobDescription" name="jobDescription" rows="3" style="width: 380px;"></textarea><br><br>
                            <label class="question" for="jobSpecification"><b>Spesifikasi Pekerjaan:</b></label>
                            <textarea id="jobSpecification" name="jobSpecification" rows="3" style="width: 380px;"></textarea><br><br>
                        </div>
                        <div class="col-md-6">
                            <label class="question" for="softSkills"><b>Persyaratan Soft Skills:</b></label>
                            <textarea id="softSkills" name="softSkills" rows="3" style="width: 380px;"></textarea><br><br>
                            <label class="question" for="hardSkills"><b>Persyaratan Hard Skills:</b></label>
                            <textarea id="hardSkills" name="hardSkills" rows="3" style="width: 380px;"></textarea><br><br>
                        </div>
                    </div>

                    <!--  script untuk mengaktifkan form sesuai dengan request_type yang ditransfer -->
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            // Mendapatkan parameter dari URL
                            const urlParams = new URLSearchParams(window.location.search);
                            const request_type = urlParams.get('request_type');

                            // Mengisi nilai kolom jenis permintaan
                            if (request_type) {
                                document.getElementById("request_type").value = request_type;

                                // Menampilkan atau menyembunyikan formulir isian sesuai dengan jenis permintaan
                                if (request_type === "Resign") {
                                    document.getElementById("ResignForm").style.display = "block";

                                    // Mengisi nilai formulir isian sesuai dengan nilai URL parameter
                                    document.getElementById("karyawanBaru").value = urlParams.get('karyawanBaru') || '';
                                    document.getElementById("NamaFPK").value = urlParams.get('nama') || '';
                                    document.getElementById("nama_unit").value = urlParams.get('nama_unit') || '';
                                    document.getElementById("nama_jabatan").value = urlParams.get('nama_jabatan') || '';
                                    document.getElementById("nama_organisasi").value = urlParams.get('nama_organisasi') || '';
                                    document.getElementById("nama_golongan").value = urlParams.get('nama_golongan') || '';
                                    document.getElementById("effectiveDate").value = urlParams.get('effective_date') || '';
                                    document.getElementById("reason").value = urlParams.get('reason') || '';
                                } else if (request_type === "PHK") {
                                    document.getElementById("PHKForm").style.display = "block";

                                    // Mengisi nilai formulir isian sesuai dengan nilai URL parameter
                                    document.getElementById("karyawanBaru").value = urlParams.get('karyawanBaru') || '';
                                    document.getElementById("PHKEmployee").value = urlParams.get('nama') || '';
                                    document.getElementById("nama_unit").value = urlParams.get('nama_unit') || '';
                                    document.getElementById("nama_jabatan").value = urlParams.get('nama_jabatan') || '';
                                    document.getElementById("nama_organisasi").value = urlParams.get('nama_organisasi') || '';
                                    document.getElementById("nama_golongan").value = urlParams.get('nama_golongan') || '';
                                    document.getElementById("effectiveDate").value = urlParams.get('effective_date') || '';
                                    document.getElementById("reason").value = urlParams.get('reason') || '';

                                } else if (request_type === "Mutasi") {
                                    document.getElementById("MutasiForm").style.display = "block";

                                    // Mengisi nilai formulir isian sesuai dengan nilai URL parameter
                                    document.getElementById("karyawanBaru").value = urlParams.get('karyawanBaru') || '';
                                    document.getElementById("mutName").value = urlParams.get('nama') || '';
                                    document.getElementById("nama_unit").value = urlParams.get('nama_unit') || '';
                                    document.getElementById("nama_jabatan").value = urlParams.get('nama_jabatan') || '';
                                    document.getElementById("nama_organisasi").value = urlParams.get('nama_organisasi') || '';
                                    document.getElementById("nama_golongan").value = urlParams.get('nama_golongan') || '';
                                    document.getElementById("effectiveDate").value = urlParams.get('effective_date') || '';
                                    document.getElementById("reason").value = urlParams.get('reason') || '';
                                } else if (request_type === "Promosi") {
                                    document.getElementById("PromosiForm").style.display = "block";

                                    // Mengisi nilai formulir isian sesuai dengan nilai URL parameter
                                    document.getElementById("karyawanBaru").value = urlParams.get('karyawanBaru') || '';
                                    document.getElementById("promName").value = urlParams.get('nama') || '';
                                    document.getElementById("nama_unit").value = urlParams.get('nama_unit') || '';
                                    document.getElementById("nama_jabatan").value = urlParams.get('nama_jabatan') || '';
                                    document.getElementById("nama_organisasi").value = urlParams.get('nama_organisasi') || '';
                                    document.getElementById("nama_golongan").value = urlParams.get('nama_golongan') || '';
                                    document.getElementById("effectiveDate").value = urlParams.get('effective_date') || '';
                                    document.getElementById("reason").value = urlParams.get('reason') || '';
                                } else if (request_type === "Demosi") {
                                    document.getElementById("DemosiForm").style.display = "block";

                                    // Mengisi nilai formulir isian sesuai dengan nilai URL parameter
                                    document.getElementById("karyawanBaru").value = urlParams.get('karyawanBaru') || '';
                                    document.getElementById("demoName").value = urlParams.get('nama') || '';
                                    document.getElementById("nama_unit").value = urlParams.get('nama_unit') || '';
                                    document.getElementById("nama_jabatan").value = urlParams.get('nama_jabatan') || '';
                                    document.getElementById("nama_organisasi").value = urlParams.get('nama_organisasi') || '';
                                    document.getElementById("nama_golongan").value = urlParams.get('nama_golongan') || '';
                                    document.getElementById("effectiveDate").value = urlParams.get('effective_date') || '';
                                    document.getElementById("reason").value = urlParams.get('reason') || '';
                                } else if (request_type === "karyawanBaru") {
                                    document.getElementById("karyawanBaruForm").style.display = "block";

                                    // Mengisi nilai formulir isian sesuai dengan nilai URL parameter
                                    document.getElementById("karyawanBaru").value = urlParams.get('karyawanBaru') || '';
                                    document.getElementById("demoName").value = urlParams.get('nama') || '';
                                    document.getElementById("nama_unit").value = urlParams.get('nama_unit') || '';
                                    document.getElementById("nama_jabatan").value = urlParams.get('nama_jabatan') || '';
                                    document.getElementById("nama_organisasi").value = urlParams.get('nama_organisasi') || '';
                                    document.getElementById("nama_golongan").value = urlParams.get('nama_golongan') || '';
                                    document.getElementById("effectiveDate").value = urlParams.get('effective_date') || '';
                                    document.getElementById("reason").value = urlParams.get('reason') || '';
                                }
                            } else {
                                // Menyembunyikan semua formulir jika request_type tidak valid
                                document.getElementById("ResignForm").style.display = "none";
                                document.getElementById("PHKForm").style.display = "none";
                                document.getElementById("MutasiForm").style.display = "none";
                                document.getElementById("PromosiForm").style.display = "none";
                                document.getElementById("DemosiForm").style.display = "none";
                                document.getElementById("karyawanBaruForm").style.display = "none";
                            }
                        });
                    </script>

                    <!-- script untuk menutup akses ubah kolom permintaan untuk -->
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            // Mendapatkan parameter dari URL
                            const urlParams = new URLSearchParams(window.location.search);
                            const request_type = urlParams.get('request_type');

                            // Mengisi nilai kolom jenis permintaan dan menonaktifkan pilihan jika sudah ada parameter URL
                            if (request_type) {
                                document.getElementById("request_type").value = request_type;

                                // Menampilkan atau menyembunyikan formulir isian sesuai dengan jenis permintaan
                                if (request_type === "Resign") {
                                    document.getElementById("ResignForm").style.display = "block";
                                } else if (request_type === "PHK") {
                                    document.getElementById("PHKForm").style.display = "block";
                                } else if (request_type === "Mutasi") {
                                    document.getElementById("MutasiForm").style.display = "block";
                                } else if (request_type === "Promosi") {
                                    document.getElementById("PromosiForm").style.display = "block";
                                } else if (request_type === "Demosi") {
                                    document.getElementById("DemosiForm").style.display = "block";
                                }
                            }
                        });
                    </script>
                    <div class="row" style="justify-content: right; margin-right: 50px;"> <!-- Menggunakan class text-right untuk memposisikan ke kanan -->
                        <input type="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>

        <!-- Script untuk menampilkan tombol lihat detail Mutasi -->
        <script>
            document.getElementById("spesificEmployee").addEventListener("change", function() {
                var selectedEmployee = document.getElementById("spesificEmployee").value;
                var redirectToMutasiButton = document.getElementById("redirectToMutasi");
                if (selectedEmployee !== "") {
                    redirectToMutasiButton.style.display = "block";
                    redirectToMutasiButton.addEventListener("click", function() {
                        var searchInput = encodeURIComponent(selectedEmployee);
                        window.location.href = "http://sijababeka.test/karyawan/employee_transfer/index.php?search=" + searchInput;
                    });
                } else {
                    redirectToMutasiButton.style.display = "none";
                }
            });
        </script>

        <!-- Script untuk mengisi tanggal efektif dan alasan berdasarkan karyawan yang dipilih -->
        <script>
            document.getElementById("spesificEmployee").addEventListener("change", function() {
                var selectedEmployee = document.getElementById("spesificEmployee").value;
                var transferData = <?php echo json_encode($transferData); ?>;

                // Mencari data Mutasi berdasarkan nama yang dipilih
                var selectedTransfer = transferData.find(function(transfer) {
                    return transfer.nama === selectedEmployee;
                });

                if (selectedTransfer) {
                    // Mengisi bidang dengan data Mutasi yang dipilih
                    document.getElementById("effectiveDate").value = selectedTransfer.effective_date;
                    document.getElementById("reason").value = selectedTransfer.reason;
                } else {
                    // Reset nilai-nilai bidang jika data Mutasi tidak valid
                    document.getElementById("effectiveDate").value = "";
                    document.getElementById("reason").value = "";
                }
            });
        </script>


    </div>

    <!-- validasi untuk kolom yang tidak diisi -->
    <script>
        function validateForm() {
            // Ambil nilai dari setiap field
            var nama = document.getElementById('nama').value;
            var kode = document.getElementById('kode').value;
            // Lanjutkan untuk field lainnya

            // Periksa apakah semua field telah diisi
            if (nama === '' || kode === '') {
                alert('Mohon lengkapi semua field yang diperlukan.');
                return false; // Hentikan pengiriman form jika ada field yang kosong
            }
            // Lanjutkan dengan validasi field lainnya jika diperlukan

            // Jika semua field terisi, kembalikan true untuk melanjutkan pengiriman form
            return true;
        }
    </script>

    <script>
        // Mendengarkan perubahan pada form Employee ID
        document.getElementById("kode").addEventListener("change", function() {
            var selectedkode = this.value;
            var selectedEmployee = <?php echo json_encode($employeeData); ?>;
            var selectedEmployeeData = selectedEmployee.find(function(employee) {
                return employee.kode === selectedkode;
            });

            if (selectedEmployeeData) {
                document.getElementById("nama").value = selectedEmployeeData.nama;
                document.getElementById("bisnis").value = selectedEmployeeData.bisnis;
                document.getElementById("organisasi").value = selectedEmployeeData.organisasi;
                document.getElementById("golongan").value = selectedEmployeeData.golongan;
                document.getElementById("jabatan").value = selectedEmployeeData.jabatan;
                document.getElementById("status").value = selectedEmployeeData.status;

                // Menandai opsi yang dipilih sebagai disabled pada dropdown "Karyawan Pengganti"
                var replacementDropdown = document.getElementById("replacementEmployee");
                for (var i = 0; i < replacementDropdown.options.length; i++) {
                    if (replacementDropdown.options[i].value === selectedkode) {
                        replacementDropdown.options[i].disabled = true;
                    } else {
                        replacementDropdown.options[i].disabled = false;
                    }
                }
            } else {
                // Reset nilai-nilai bidang jika employee ID tidak valid
                document.getElementById("nama").value = "";
                document.getElementById("bisnis").value = "";
                document.getElementById("organisasi").value = "";
                document.getElementById("golongan").value = "";
                document.getElementById("jabatan").value = "";
                document.getElementById("lokasi_kerja").value = "";
                document.getElementById("status").value = "";
            }
        });

        // Mendengarkan perubahan pada form Nama
        document.getElementById("nama").addEventListener("change", function() {
            var selectedNama = this.value;
            var selectedEmployee = <?php echo json_encode($employeeData); ?>;
            var selectedEmployeeData = selectedEmployee.find(function(employee) {
                return employee.nama === selectedNama;
            });

            if (selectedEmployeeData) {
                document.getElementById("kode").value = selectedEmployeeData.kode; // Mengisi kode berdasarkan data yang dipilih
                document.getElementById("bisnis").value = selectedEmployeeData.bisnis;
                document.getElementById("organisasi").value = selectedEmployeeData.organisasi;
                document.getElementById("golongan").value = selectedEmployeeData.golongan;
                document.getElementById("jabatan").value = selectedEmployeeData.jabatan;
                document.getElementById("lokasi_kerja").value = selectedEmployeeData.lokasi_kerja;
                document.getElementById("status").value = selectedEmployeeData.status;

                // Menandai opsi yang dipilih sebagai disabled pada dropdown "Karyawan Pengganti"
                var replacementDropdown = document.getElementById("replacementEmployee");
                for (var i = 0; i < replacementDropdown.options.length; i++) {
                    if (replacementDropdown.options[i].value === selectedEmployeeData.kode) {
                        replacementDropdown.options[i].disabled = true;
                    } else {
                        replacementDropdown.options[i].disabled = false;
                    }
                }
            } else {
                // Reset nilai-nilai bidang jika nama tidak valid
                document.getElementById("kode").value = ""; // Mengosongkan kode jika nama tidak valid
                document.getElementById("bisnis").value = "";
                document.getElementById("organisasi").value = "";
                document.getElementById("golongan").value = "";
                document.getElementById("jabatan").value = "";
                document.getElementById("lokasi_kerja").value = "";
                document.getElementById("status").value = "";
            }
        });
    </script>
</body>

</html>