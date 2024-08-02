<!DOCTYPE html>
<html lang="en">
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

<?php
// Koneksi ke database
$servername = "localhost"; // Ganti sesuai dengan server database Anda
$username = "alwan"; // Ganti sesuai dengan username database Anda
$password = "root"; // Ganti sesuai dengan password database Anda
$database = "db_sijababeka"; // Ganti sesuai dengan nama database Andaedrfddedwsfvgdsewaqswedxecxsdxdsds

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


?>

<?php
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
// include('sidebar.php');
include('koneksi.php');

// Query untuk mengambil data karyawan dan menyimpannya dalam bentuk array
$query_karyawan = mysqli_query($connection, "SELECT * FROM karyawan");
$data_karyawan = array();

while ($row_karyawan = mysqli_fetch_assoc($query_karyawan)) {
    $data_karyawan[$row_karyawan['nama']] = array(
        // 'nama_status' => $row_karyawan['status'],
        'nama_unit' => $row_karyawan['bisnis'],
        'nama_jabatan' => $row_karyawan['jabatan'],
        'nama_organisasi' => $row_karyawan['organisasi'],
        'nama_golongan' => $row_karyawan['golongan']
    );
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Permintaan Karyawan</title>
    <script>
        // Script untuk mengisi nilai kolom jenis permintaan dan membuka kolom formulir yang sesuai
        document.addEventListener("DOMContentLoaded", function() {
            // Mendapatkan parameter dari URL
            const urlParams = new URLSearchParams(window.location.search);
            const requestType = urlParams.get('requestType');

            // Mengisi nilai kolom jenis permintaan
            if (requestType) {
                document.getElementById("requestType").value = requestType;

                // Menampilkan atau menyembunyikan formulir isian sesuai dengan jenis permintaan
                if (requestType === "Resign") {
                    document.getElementById("ResignForm").style.display = "block";
                } else if (requestType === "PHK") {
                    document.getElementById("PHKForm").style.display = "block";
                } else if (requestType === "Mutasi") {
                    document.getElementById("MutasiForm").style.display = "block";
                } else if (requestType === "Promosi") {
                    document.getElementById("PromosiForm").style.display = "block";
                } else if (requestType === "Demosi") {
                    document.getElementById("DemosiForm").style.display = "block";
                }
            }
        });
    </script>
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

        .col-md-3 {
            flex: 0 0 calc(25% - 5px);
            /* Set lebar 50% dengan margin 10px */
            margin-right: 2px;
            /* Margin antar kolom */
        }

        input[type="text"],
        textarea {
            width: 100%;
        }

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
    </style>
</head>

<body>
    <div class="container">

        <a href="typeFPK.php?id=<?php echo $userId; ?>&branches=<?php echo $branches; ?>" class="database">
            <img src="./img/database (1).png" alt="database" style="width: 40px; height: 40px; margin: 15px 15px;"></a>

        <a href="../index.php?id=<?php echo $userId; ?>" class="dashboard">
            <img src="./img/dashboard (1).png" alt="dashboard" style="width: 40px; height: 40px; margin: 15px 15px;"></a>

        <div class="card">
            <img src="img/header-fpk.png" alt="Placeholder Image">
            <div class="card-content">
                <form action="save_fpk.php?branch=<?php echo $branch; ?>" method="POST">
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
                                <label for="kodeFPK" style="display: inline-block; width: 30%;">Kode FPK:</label>
                                <input type="text" id="kodeFPK" name="kodeFPK" style="margin-left: -160px; width: 30%;" value="<?php echo substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8); ?>" readonly>

                                <!-- Form untuk permintaan -->
                                <label for="request_type" style="display: inline-block; width: 200px;">
                                    <select id="request_type" name="request_type" style="width: 200px;">
                                        <option value="">Pilih Jenis Permintaan</option>
                                        <option value="Replace" <?php echo isset($_GET['request_type']) && $_GET['request_type'] === 'Replace' ? 'selected' : ''; ?>>Replacement</option>
                                        <option value="karyawanBaru" <?php echo isset($_GET['request_type']) && $_GET['request_type'] === 'Rotasi' ? 'selected' : ''; ?>>New Hire</option>
                                    </select></label>
                                <!-- Tombol "Check Employee Transfer" -->
                            </div>
                        </div>
                    </div>

                    <!-- PERMINTAAN UNTUK -->
                    <div id="Replace" class="permintaan" style="display: none;">
                        <h3 style="margin-top:20px;">PERMINTAAN</h3>
                        <div class="form-section" id="PromosiForm" style="display: block;">
                            <!-- <h3 class="text-center mb-4" style="margin-top: 30px; text-align: left;">Form Promosi</h3> -->
                            <div class="row">
                                <div class="col-md-6">

                                    <!--For Replacement Request Type -->
                                    <label for="requestType">Jenis Permintaan</label>
                                    <select id="requestType" name="requestType" class="form-control" style="width: 100%;" required>
                                        <option value="">Pilih Jenis Permintaan</option>
                                        <option value="PHK">PHK</option>
                                        <option value="Resign">Resign</option>
                                        <option value="Mutasi">Mutasi</option>
                                        <option value="Promosi">Promosi</option>
                                        <option value="Demosi">Demosi</option>
                                    </select>

                                    <!-- <label for="branch" id="ketReplace" style="display: block;">:</label> -->
                                    <label for="uploadFile" style="display: none;">UNGGAH (Lampirkan Struktur Organisasi):</label>
                                    <label for="uploadFile">Lampirkan Surat Ketrangan Terkait </label>
                                    <input type="file" id="uploadFile" name="uploadFile" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.docx,.doc,.xlxs,.xls" style="height: 50px;" required>

                                    <label for="namakaryawan">Nama karyawan:</label>
                                    <input class="form-control" id="namakaryawan" name="namakaryawan" style="width: 100%;" required>

                                </div>

                                <div class="col-md-6">
                                    <label for="namagolongan">Golongan:</label>
                                    <input class="form-control" id="namagolongan" name="namagolongan" style="width: 100%;" required>


                                    <label for="namajabatan">Jabatan:</label>
                                    <input class="form-control" id="namajabatan" name="namajabatan" style="width: 100%;" required>

                                    <label for="namaorganisasi">Organisasi:</label>
                                    <input class="form-control" id="namaorganisasi" name="namaorganisasi" style="width: 100%;" required>

                                    <!-- input by sistem -->
                                    <label for="effectiveDate" style="width: 100%; display: none;">Tanggal Permintaan:</label>
                                    <input type="date" id="effectiveDate" name="effectiveDate" style="width: 100%; display: none;" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <label for="namaunit">Bisnis Unit:</label>
                                    <input class="form-control" id="namaunit" name="namaunit" style="width: 100%;" required>

                                    <label for="reason">Keterangan FPK:</label>
                                    <textarea id="reason" name="reason" style="width: 100%; height: 60px;" class="form-control" rows="4" required><?php echo isset($_GET['reason']) ? $_GET['reason'] : ''; ?></textarea>

                                    <div class="container" style="display: flex; flex-direction: row; align-items: center;">
                                        <label class="question" style="margin-left: -16px; margin-right: 20px;">Catatan:</label>
                                        <label class="answer" style="margin-right: 20px;">
                                            <input type="radio" id="mpp" name="note" value="mpp" required> SESUAI MPP
                                        </label>
                                        <label class="answer" style="margin-right: 20px;">
                                            <input type="radio" id="nmpp" name="note" value="nmpp" required> TIDAK SESUAI MPP
                                        </label>
                                    </div>


                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- PERMINTAAN ADDITIONAL -->


                    <div id="qualificationForm" class="employee-form" style="margin-top: 20px;">
                        <h3>KUALIFIKASI</h3>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="question"><b>Jenis Kelamin:</b></label>
                                <label class="answer">
                                    <input type="radio" id="gender_male" name="gender" value="male" required>
                                    Laki-laki
                                </label>
                                <label class="answer">
                                    <input type="radio" id="gender_female" name="gender" value="female" required>
                                    Perempuan
                                </label><br>
                                <label class="question" for="age"><b>Usia:</b></label>
                                <input type="number" id="age" name="age" style="width: 50px;" required><br>
                            </div>
                            <div class="col-md-3">
                                <label class="question"><b>Pengalaman:</b></label><br>
                                <label class="answer">
                                    <input type="radio" id="experience_0" name="experience" value="0" required>
                                    0 TH
                                </label>

                                <label class="answer">
                                    <input type="radio" id="experience_1-2" name="experience" value="1-2" required>
                                    1-2 TH
                                </label>

                                <label class="answer">
                                    <input type="radio" id="experience_3-5" name="experience" value="3-5" required>
                                    3-5 TH
                                </label>

                                <label class="answer">
                                    <input type="radio" id="experience_5" name="experience" value="5" required>
                                    5 TH
                                </label><br>
                            </div>
                            <div class="col-md-3">
                                <label class="question"><b>Pendidikan:</b></label><br>
                                <label class="answer">
                                    <input type="radio" id="education_highschool" name="education" value="highschool" required>
                                    SMA/SMK
                                </label>
                                <label class="answer">
                                    <input type="radio" id="education_diploma" name="education" value="diploma" required>
                                    DIII
                                </label>
                                <label class="answer">
                                    <input type="radio" id="education_bachelor" name="education" value="bachelor" required>
                                    S1
                                </label>
                                <label class="answer">
                                    <input type="radio" id="education_master" name="education" value="master" required>
                                    S2
                                </label>
                                <label class="answer">
                                    <input type="radio" id="education_phd" name="education" value="phd" required>
                                    S3
                                </label><br>
                            </div>
                            <div class="col-md-3">
                                <label class="question" for="major"><b>Jurusan:</b></label>
                                <input type="text" id="major" name="major" style="width: 150px;" required><br><br>
                                <label for="lokasiKerja"><b>Lokasi Kerja:</b></label>
                                <select id="lokasiKerja" name="lokasiKerja" class="form-control" style="width: 100%;" required>
                                    <option value="">Pilih Lokasi Kerja</option>
                                    <option value="Cikarang">Cikarang</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Kendal">Kendal</option>
                                    <option value="Magelang">Magelang</option>
                                    <option value="Morotai">Morotai</option>
                                    <option value="Tanjung Lesung">Tanjung Lesung</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="question" for="jobDescription"><b>Uraian Pekerjaan:</b></label>
                            <textarea id="jobDescription" name="jobDescription" rows="3" style="width: 100%;" required></textarea><br><br>
                            <label class="question" for="jobSpecification"><b>Spesifikasi Pekerjaan:</b></label>
                            <textarea id="jobSpecification" name="jobSpecification" rows="3" style="width: 100%;" required></textarea><br><br>
                        </div>
                        <div class="col-md-6">
                            <label class="question" for="softSkills"><b>Persyaratan Soft Skills:</b></label>
                            <textarea id="softSkills" name="softSkills" rows="3" style="width: 100%;" required></textarea><br><br>
                            <label class="question" for="hardSkills"><b>Persyaratan Hard Skills:</b></label>
                            <textarea id="hardSkills" name="hardSkills" rows="3" style="width: 100%;" required></textarea><br><br>
                        </div>
                    </div>

                    <div class="row" style="justify-content: right; margin-right: 50px;"> <!-- Menggunakan class text-right untuk memposisikan ke kanan -->
                        <input type="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>

    </div>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mendapatkan elemen dropdown jenis permintaan
        var requestTypeDropdown = document.getElementById('request_type');

        // Menambahkan event listener untuk merespons perubahan pada dropdown jenis permintaan
        requestTypeDropdown.addEventListener('change', function() {
            // Mendapatkan nilai yang dipilih pada dropdown
            var selectedRequestType = requestTypeDropdown.value;

            // Mendapatkan elemen PERMINTAAN dan PERMINTAAN ADDITIONAL
            var replaceSection = document.getElementById('Replace');
            var newHireSection = document.getElementById('karyawanBaru');

            // Memeriksa jenis permintaan yang dipilih dan menampilkan/menyembunyikan bagian yang sesuai
            if (selectedRequestType === 'Replace') {
                replaceSection.style.display = 'block';
                newHireSection.style.display = 'none';
            } else if (selectedRequestType === 'karyawanBaru') {
                replaceSection.style.display = 'none';
                newHireSection.style.display = 'block';
            } else {
                replaceSection.style.display = 'none';
                newHireSection.style.display = 'none';
            }
        });
    });


    // Mendapatkan tanggal hari ini
    var today = new Date();

    // Format tanggal menjadi YYYY-MM-DD (sesuai dengan format input type date)
    var yyyy = today.getFullYear();
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var dd = String(today.getDate()).padStart(2, '0');
    var todayString = yyyy + '-' + mm + '-' + dd;

    // Mengisi nilai input tanggal dengan tanggal hari ini
    document.getElementById("effectiveDate").value = todayString;
</script>
<div id="karyawanBaru" class="additional" style="display:none;">
    <!-- <div class="row">
                            <div class="col-md-6">
                                <label for="namaunitAdd">Nama:</label>
                                <input class="form-control" id="namaunitAdd" name="namaunitAdd" style="width: 100%;" value="Additional" readonly>
                            </div>
                            <div class="col-md-6">

                                <label for="uploadFileAdd">Lampirkan Struktur Organisasi </label>
                                <input type="file" id="uploadFileAdd" name="uploadFileAdd" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.docx,.doc,.xlxs,.xls" style="height: 50px;" required>
                            </div>
                        </div>
                        <div class="row">
                            <div id="move" class="col-md-6" style="display: block;">
                                <label for="branchAdd" style="margin-top:10px; margin-bottom:0px;"></i> Bisnis Unit</label>
                                <select class="select2" id="branchAdd" name="branchAdd" style="width: 100%; height: 40px !important;" required>
                                    <option value="">Pilih Bisnis</option>
                                    <php
                                    include('koneksi.php');
                                    $query_nama_unit = mysqli_query($connection, "SELECT DISTINCT nama_unit FROM bisnis ORDER BY nama_unit ASC");
                                    while ($row_nama_unit = mysqli_fetch_array($query_nama_unit)) {
                                        echo '<option value="' . $row_nama_unit['nama_unit'] . '">' . $row_nama_unit['nama_unit'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="namaorganisasiAdd">Organisasi:</label>
                                <input class="form-control" id="namaorganisasiAdd" name="namaorganisasiAdd" style="width: 100%;" required>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="golonganAdd" style="margin-top:10px; margin-bottom:0px;"></i>Golongan</label>
                                <input class="form-control" id="golonganAdd" name="golonganAdd" style="width: 100%;" required>

                            </div>
                            <div class="col-md-6">
                                <label for="jabatanAdd" style="margin-top: 10px; margin-bottom:0px;"></i> Jabatan</label>
                                <input class="form-control" id="jabatanAdd" name="jabatanAdd" style="width: 100%;" required>

                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="reasonAdd">Keterangan FPK:</label>
                                <textarea id="reasonAdd" name="reasonAdd" style="width: 100%; height: 60px;" class="form-control" rows="4" required><?php echo isset($_GET['reason']) ? $_GET['reason'] : ''; ?></textarea>

                                <div class="container" style="display: flex; flex-direction: row; align-items: center;">
                                    <label class="question" style="margin-left: -16px; margin-right: 0px;">Catatan:</label>
                                    <label class="answer" style="margin-right: 0px;">
                                        <input type="radio" id="mppAdd" name="noteAdd" value="mppAdd" required> SESUAI MPP
                                    </label>
                                    <label class="answer" style="margin-right: 0px;">
                                        <input type="radio" id="nmppAdd" name="noteAdd" value="nmppAdd" required> TIDAK SESUAI MPP
                                    </label>
                                </div>


                            </div>
                        </div> -->
</div>

</html>