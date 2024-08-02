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
                <label for="" style="display: inline-block; width: 200px;">
                  <select id="request_type" name="requestFor" style="width: 200px;">
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
                  <select id="requestType" name="requestType" class="form-control" style="width: 100%;">
                    <option value="">Pilih Jenis Permintaan</option>
                    <option value="PHK">PHK</option>
                    <option value="Resign">Resign</option>
                    <option value="Mutasi">Mutasi</option>
                    <option value="Promosi">Promosi</option>
                    <option value="Demosi">Demosi</option>
                  </select>

                  <!-- <label for="branch" id="ketReplace" style="display: block;">:</label> -->
                  <label for="branch" id="ketAdditional" style="display: none;">UNGGAH (Lampirkan Struktur Organisasi):</label>
                  <label for="uploadFile">Lampirkan Surat Ketrangan Terkait </label>
                  <input type="file" id="uploadFile" name="uploadFile" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.docx,.doc,.xlxs,.xls" style="height: 50px;">

                  <!-- <label for="nama">
                                        Nama Karyawan:<br>
                                        <select class="select2" id="nama" name="nama" style="width: 100%;">
                                            <option value="">Pilih Nama</option>
                                            <php
                                            include('koneksi.php');
                                            $query_nama = mysqli_query($connection, "SELECT DISTINCT nama FROM karyawan ORDER BY nama ASC");
                                            while ($row_nama = mysqli_fetch_array($query_nama)) {
                                                echo '<option value="' . $row_nama['nama'] . '">' . $row_nama['nama'] . '</option>';
                                            }
                                            ?>
                                            <br>
                                        </select>
                                    </label> -->
                  <label for="nama_karyawan">Nama karyawan:</label>
                  <input class="form-control" id="namakaryawan" name="namakaryawan" style="width: 100%;" required>


                  <!-- script untuk replacement mengisi kolom nama karyawan-->
                  <!-- <script>
                                        // Array PHP yang menyimpan data karyawan
                                        var dataKaryawan = <php echo json_encode($data_karyawan); ?>;

                                        // Fungsi untuk mengisi nilai form berdasarkan nama karyawan yang dipilih
                                        function fillForm() {
                                            // Mendapatkan nilai nama karyawan yang dipilih
                                            var selectedName = document.getElementById("nama").value;

                                            // Mendapatkan data karyawan dari array berdasarkan nama yang dipilih
                                            var selectedEmployee = dataKaryawan[selectedName];

                                            // Mengisi nilai form dengan data karyawan yang ditemukan
                                            // document.getElementById("nama_status").value = selectedEmployee.nama_status;
                                            document.getElementById("nama_unit").value = selectedEmployee.nama_unit;
                                            document.getElementById("nama_jabatan").value = selectedEmployee.nama_jabatan;
                                            document.getElementById("nama_organisasi").value = selectedEmployee.nama_organisasi;
                                            document.getElementById("nama_golongan").value = selectedEmployee.nama_golongan;
                                        }
                                    </script> -->

                </div>

                <div class="col-md-6">
                  <label for="nama_golongan">Golongan:</label>
                  <input class="form-control" id="namagolongan" name="namagolongan" style="width: 100%;" required>


                  <label for="nama_jabatan">Jabatan:</label>
                  <input class="form-control" id="nama_jabatan" name="nama_jabatan" style="width: 100%;" required>

                  <label for="nama_organisasi">Organisasi:</label>
                  <input class="form-control" id="nama_organisasi" name="nama_organisasi" style="width: 100%;" required>

                  <!-- input by sistem -->
                  <label for="effectiveDate" style="width: 100%; display: none;">Tanggal Permintaan:</label>
                  <input type="date" id="effectiveDate" name="effectiveDate" style="width: 100%; display: none;" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                  <script>
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
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">

                  <label for="nama_unit">Bisnis Unit:</label>
                  <input class="form-control" id="namaunit" name="namaunit" style="width: 100%;">

                  <label for="reason">Keterangan FPK:</label>
                  <textarea id="reason" name="reason" style="width: 100%; height: 60px;" class="form-control" rows="4"><?php echo isset($_GET['reason']) ? $_GET['reason'] : ''; ?></textarea>

                  <div class="container" style="display: flex; flex-direction: row; align-items: center;">
                    <label class="question" style="margin-left: -16px; margin-right: 20px;" for="note">Catatan:</label>
                    <label class="answer" for="mpp" style="margin-right: 20px;">
                      <input type="radio" id="mpp" name="note" value="mpp"> SESUAI MPP
                    </label>
                    <label class="answer" for="nmpp" style="margin-right: 20px;">
                      <input type="radio" id="nmpp" name="note" value="nmpp"> TIDAK SESUAI MPP
                    </label>
                  </div>

                </div>

              </div>

              <!-- Transfer Ke -->
              <!-- <h3 style="margin-top:20px;">TUJUAN PINDAH</h3>
                            <div class="row">
                                <div id="move" class="col-md-8" style="display: block;">
                                    <label for="branch"></i> Bisnis Unit</label>
                                    <select class="select2" id="branch" name="branch" style="width: 100%; height: 40px !important;">
                                        <option value="">Pilih Bisnis</option>
                                        <?php
                                        include('koneksi.php');
                                        $query_nama_unit = mysqli_query($connection, "SELECT DISTINCT nama_unit FROM bisnis ORDER BY nama_unit ASC");
                                        while ($row_nama_unit = mysqli_fetch_array($query_nama_unit)) {
                                          echo '<option value="' . $row_nama_unit['nama_unit'] . '">' . $row_nama_unit['nama_unit'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="golongan" style="margin-bottom:0px;"></i>Golongan</label>
                                    <select class="select2" id="golongan" name="golongan" style="width: 100%; height: 40px !important;">
                                        <option value="">Pilih Golongan</option>
                                        <?php
                                        include('koneksi.php');
                                        $query_nama_golongan = mysqli_query($connection, "SELECT DISTINCT nama_golongan FROM golongan ORDER BY nama_golongan ASC");
                                        while ($row_nama_golongan = mysqli_fetch_array($query_nama_golongan)) {
                                          echo '<option value="' . $row_nama_golongan['nama_golongan'] . '">' . $row_nama_golongan['nama_golongan'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="organisasi" style="margin-top:20px; margin-bottom:0px;">Organisasi</label>
                                    <select class="select2" id="organisasi" name="organisasi" style="width: 100%; height: 40px !important;">
                                        <option value="">Pilih Organisasi</option>
                                        <php include('koneksi.php'); $query_nama_organisasi=mysqli_query($connection, "SELECT DISTINCT nama_organisasi FROM organisasi ORDER BY nama_organisasi ASC" ); while ($row_nama_organisasi=mysqli_fetch_array($query_nama_organisasi)) { echo '<option value="' . $row_nama_organisasi['nama_organisasi'] . '">' . $row_nama_organisasi['nama_organisasi'] . '</option>' ; } ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="jabatan" style="margin-top:20px; margin-bottom:0px;"></i> Jabatan</label>
                                    <select class="select2" id="jabatan" name="jabatan" style="width: 100%; height: 40px !important;">
                                        <option value="">Pilih Jabatan</option>
                                        <?php
                                        include('koneksi.php');
                                        $query_nama_jabatan = mysqli_query($connection, "SELECT DISTINCT nama_jabatan FROM jabatan ORDER BY nama_jabatan ASC");
                                        while ($row_nama_jabatan = mysqli_fetch_array($query_nama_jabatan)) {
                                          echo '<option value="' . $row_nama_jabatan['nama_jabatan'] . '">' . $row_nama_jabatan['nama_jabatan'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div> -->
            </div>
          </div>

          <!-- PERMINTAAN ADDITIONAL -->
          <div id="karyawanBaru" class="additional" style="display:none;">
            <div class="row">
              <div class="col-md-6">
                <label for="nama_unit">Nama:</label>
                <input class="form-control" id="nama_unit" name="nama_unit" style="width: 100%;" value="Additional" readonly>
              </div>
              <div class="col-md-6">

                <label for="uploadFile">Lampirkan Struktur Organisasi </label>
                <input type="file" id="uploadFile" name="uploadFile" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.docx,.doc,.xlxs,.xls" style="height: 50px;">
              </div>
            </div>
            <div class="row">
              <div id="move" class="col-md-6" style="display: block;">
                <label for="branch" style="margin-top:10px; margin-bottom:0px;"></i> Bisnis Unit</label>
                <select class="select2" id="branch" name="branch" style="width: 100%; height: 40px !important;">
                  <option value="">Pilih Bisnis</option>
                  <?php
                  include('koneksi.php');
                  $query_nama_unit = mysqli_query($connection, "SELECT DISTINCT nama_unit FROM bisnis ORDER BY nama_unit ASC");
                  while ($row_nama_unit = mysqli_fetch_array($query_nama_unit)) {
                    echo '<option value="' . $row_nama_unit['nama_unit'] . '">' . $row_nama_unit['nama_unit'] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-6">
                <label for="organisasi" style="margin-top:10px; margin-bottom:0px;">Organisasi</label>
                <select class="select2" id="organisasi" name="organisasi" style="width: 100%; height: 40px !important;">
                  <option value="">Pilih Organisasi</option>
                  <?php
                  include('koneksi.php');
                  $query_nama_organisasi = mysqli_query($connection, "SELECT DISTINCT nama_organisasi FROM organisasi ORDER BY nama_organisasi ASC");
                  while ($row_nama_organisasi = mysqli_fetch_array($query_nama_organisasi)) {
                    echo '<option value="' . $row_nama_organisasi['nama_organisasi'] . '">' . $row_nama_organisasi['nama_organisasi'] . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="golongan" style="margin-top:10px; margin-bottom:0px;"></i>Golongan</label>
                <select class="select2" id="golongan" name="golongan" style="width: 100%; height: 40px !important;">
                  <option value="">Pilih Golongan</option>
                  <?php
                  include('koneksi.php');
                  $query_nama_golongan = mysqli_query($connection, "SELECT DISTINCT nama_golongan FROM golongan ORDER BY nama_golongan ASC");
                  while ($row_nama_golongan = mysqli_fetch_array($query_nama_golongan)) {
                    echo '<option value="' . $row_nama_golongan['nama_golongan'] . '">' . $row_nama_golongan['nama_golongan'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="jabatan" style="margin-top: 10px; margin-bottom:0px;"></i> Jabatan</label>
                <select class="select2" id="jabatan" name="jabatan" style="width: 100%; height: 40px !important;">
                  <option value="">Pilih Jabatan</option>
                  <?php
                  include('koneksi.php');
                  $query_nama_jabatan = mysqli_query($connection, "SELECT DISTINCT nama_jabatan FROM jabatan ORDER BY nama_jabatan ASC");
                  while ($row_nama_jabatan = mysqli_fetch_array($query_nama_jabatan)) {
                    echo '<option value="' . $row_nama_jabatan['nama_jabatan'] . '">' . $row_nama_jabatan['nama_jabatan'] . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div><br>
            <div class="row">
              <div class="col-md-12">
                <label for="reason">Keterangan FPK:</label>
                <textarea id="reason" name="reason" style="width: 100%; height: 60px;" class="form-control" rows="4"><?php echo isset($_GET['reason']) ? $_GET['reason'] : ''; ?></textarea>

                <div class="container" style="display: flex; flex-direction: row; align-items: center;">
                  <label class="question" style="margin-left: -16px; margin-right: 20px;" for="note">Catatan:</label>
                  <label class="answer" for="mpp" style="margin-right: 20px;">
                    <input type="radio" id="mpp" name="note" value="mpp"> SESUAI MPP
                  </label>
                  <label class="answer" for="nmpp" style="margin-right: 20px;">
                    <input type="radio" id="nmpp" name="note" value="nmpp"> TIDAK SESUAI MPP
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div id="qualificationForm" class="employee-form" style="margin-top: 20px;">
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
              <textarea id="jobDescription" name="jobDescription" rows="3" style="width: 100%;"></textarea><br><br>
              <label class="question" for="jobSpecification"><b>Spesifikasi Pekerjaan:</b></label>
              <textarea id="jobSpecification" name="jobSpecification" rows="3" style="width: 100%;"></textarea><br><br>
            </div>
            <div class="col-md-6">
              <label class="question" for="softSkills"><b>Persyaratan Soft Skills:</b></label>
              <textarea id="softSkills" name="softSkills" rows="3" style="width: 100%;"></textarea><br><br>
              <label class="question" for="hardSkills"><b>Persyaratan Hard Skills:</b></label>
              <textarea id="hardSkills" name="hardSkills" rows="3" style="width: 100%;"></textarea><br><br>
            </div>
          </div>

          <div class="row" style="justify-content: right; margin-right: 50px;"> <!-- Menggunakan class text-right untuk memposisikan ke kanan -->
            <input type="submit" value="Submit">
          </div>
        </form>
      </div>
    </div>

    <!-- Script untuk menampilkan tombol lihat detail Mutasi
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
        </script> -->

    <!-- Script untuk mengisi tanggal efektif dan alasan berdasarkan karyawan yang dipilih
        <script>
            document.getElementById("spesificEmployee").addEventListener("change", function() {
                var selectedEmployee = document.getElementById("spesificEmployee").value;
                var transferData = <php echo json_encode($transferData); ?>;

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
        </script> -->


  </div>

  <!-- validasi untuk kolom yang tidak diisi -->


  <!-- <script>
        // Mendengarkan perubahan pada form Employee ID
        document.getElementById("kode").addEventListener("change", function() {
            var selectedkode = this.value;
            var selectedEmployee = < php echo json_encode($employeeData); ? > ;
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
            var selectedEmployee = < php echo json_encode($employeeData); ? > ;
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
    </script> -->
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
  </script>
</body>

</html>