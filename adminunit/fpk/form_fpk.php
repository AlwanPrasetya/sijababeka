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

      // Lakukan kueri ke database untuk mendapatkan cabang dengan nama yang sama
      $queryBranches = "SELECT DISTINCT branch FROM multi_user WHERE nama = '$nama'";
      $resultBranches = $connection->query($queryBranches);

      if ($resultBranches->num_rows > 0) {
        while ($rowBranch = $resultBranches->fetch_assoc()) {
          // Tambahkan nama cabang ke array
          $branchNames[] = $rowBranch["branch"];
        }
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

// Periksa apakah ada parameter 'branches' dalam URL
if (isset($_GET['branches'])) {
  $selectedBranches = explode(', ', $_GET['branches']);
} else {
  $selectedBranches = array();
}

// Query untuk mendapatkan nama unit dari tabel bisnis
$sql1 = "SELECT nama_unit FROM bisnis";
$result1 = $connection->query($sql1);

// Fungsi untuk mendapatkan kode FPK berikutnya
function getNextKodeFPK($connection)
{
  // Ambil bagian numerik dari kodeFPK dan temukan nilai maksimalnya
  $sql2 = "SELECT MAX(CAST(SUBSTRING(kodeFPK, LENGTH('FPK-') + 1) AS UNSIGNED)) AS maxKode 
             FROM fpk 
             WHERE kodeFPK LIKE 'FPK-%'";

  $result2 = $connection->query($sql2);

  if ($result2->num_rows > 0) {
    $row = $result2->fetch_assoc();
    $maxKode = $row['maxKode'];

    // Jika tidak ada kode, mulai dari 001
    if (!$maxKode) {
      return 'FPK-001';
    }

    // Mengambil angka terakhir dan menambahkannya
    $nextKode = str_pad((int)$maxKode + 1, 3, '0', STR_PAD_LEFT);
    return 'FPK-' . $nextKode;
  } else {
    return 'FPK-001';
  }
}

// Dapatkan kode FPK berikutnya
$nextKodeFPK = getNextKodeFPK($connection);

// Tutup koneksi database
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulir FPK</title>
  <link rel="stylesheet" href="style.css">
  <script>
    window.onload = function() {
      // Cek jika ada parameter 'reset' di URL
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('reset')) {
        // Kosongkan nilai formulir
        document.querySelectorAll('form input, form textarea').forEach(element => {
          element.value = '';
        });
      }
    };
  </script>
</head>

<body>

  <a href="typeFPK.php?id=<?php echo $userId; ?>&branches=<?php echo $branches; ?>" class="database">
    <img src="./img/database (1).png" alt="database" style="width: 40px; height: 40px; margin: 15px 15px;"></a>

  <a href="../index.php?id=<?php echo $userId; ?>" class="dashboard">
    <img src="./img/dashboard (1).png" alt="dashboard" style="width: 40px; height: 40px; margin: 15px 15px;"></a>

  <div class="form-container">

    <div class="card">
      <div class="card-header">
        <img src="img/header-fpk.png" alt="Header FPK" class="header-image">
      </div>
      <div class="card-content">
        <form action="save_fpk.php" method="post" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group">
              <label for="kodeFPK">Kode FPK:</label>
            </div>
            <input type="text" id="kodeFPK" name="kodeFPK" value="<?php echo $nextKodeFPK; ?>" required readonly style="width: 460px; height: 35px; margin-left: -500px; margin-top: 30px;">
            <div class="form-group">
              <label for="requestType">Jenis Pengajuan:</label>
              <select id="requestType" name="requestType" required style="width: 460px; height: 35px; margin-left: 150px; margin-top: 5px; margin-left: 0px;">
                <option value="">Pilih Jenis Pengajuan</option> <!-- Pilihan default -->
                <option value="Resign">Resign</option>
                <option value="New Hire">New Hire</option>
              </select>
            </div>

          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="uploadFile">Lampiran File:</label>
              <input type="file" id="uploadFile" name="uploadFile" required>
            </div>
            <div class="form-group">
              <label for="namaFPK">Nama Karyawan:</label>
              <input type="text" id="namaFPK" name="namaFPK" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="namagolongan">Golongan:</label>
              <input type="text" id="namagolongan" name="namagolongan" required>
            </div>
            <div class="form-group">
              <label for="namajabatan">Jabatan:</label>
              <input type="text" id="namajabatan" name="namajabatan" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="namaorganisasi">Organisasi:</label>
              <input type="text" id="namaorganisasi" name="namaorganisasi" required>
            </div>
            <div class="form-group">
              <label for="effectiveDate">Tanggal Efektif:</label>
              <input type="date" id="effectiveDate" name="effectiveDate" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="namaunit">Nama Unit:</label>
              <select id="namaunit" name="namaunit" required style="width: 460px; height: 35px;">
                <option value="" selected>Pilih Nama Unit</option>
                <?php
                if ($result1->num_rows > 0) {
                  while ($row = $result1->fetch_assoc()) {
                    $unitName = htmlspecialchars($row["nama_unit"]);
                    if (in_array($unitName, $selectedBranches)) {
                      echo "<option value=\"$unitName\">$unitName</option>";
                    }
                  }
                } else {
                  echo "<option value=\"\">Tidak ada data</option>";
                }
                ?>
              </select>
            </div>

            <div class="form-group">
              <label for="reason">Alasan:</label>
              <textarea id="reason" name="reason" required></textarea>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="note">Catatan:</label>
              <textarea id="note" name="note" required></textarea>
            </div>
            <div class="form-group">
              <label for="gender">Jenis Kelamin:</label>
              <input type="text" id="gender" name="gender" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="age">Usia:</label>
              <input type="number" id="age" name="age" required>
            </div>
            <div class="form-group">
              <label for="experience">Pengalaman:</label>
              <input type="text" id="experience" name="experience" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="education">Pendidikan:</label>
              <input type="text" id="education" name="education" required>
            </div>
            <div class="form-group">
              <label for="major">Jurusan:</label>
              <input type="text" id="major" name="major" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="lokasiKerja">Lokasi Kerja:</label>
              <input type="text" id="lokasiKerja" name="lokasiKerja" required>
            </div>
            <div class="form-group">
              <label for="jobDescription">Deskripsi Pekerjaan:</label>
              <textarea id="jobDescription" name="jobDescription" required></textarea>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="jobSpecification">Spesifikasi Pekerjaan:</label>
              <textarea id="jobSpecification" name="jobSpecification" required></textarea>
            </div>
            <div class="form-group">
              <label for="softSkills">Soft Skills:</label>
              <textarea id="softSkills" name="softSkills" required></textarea>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="hardSkills">Hard Skills:</label>
              <textarea id="hardSkills" name="hardSkills" required></textarea>
            </div>
          </div>
          <div class="form-row submit-row">
            <input type="submit" value="Submit">
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>