<?php
include('koneksi.php');

// Ambil nilai ID dari parameter URL
$id_hc = isset($_GET['id_hc']) ? intval($_GET['id_hc']) : 0;

// Ambil data dari database berdasarkan ID yang diterima
$query = "SELECT * FROM hcc WHERE id_hc = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $id_hc);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
} else {
  echo "Data tidak ditemukan.";
  exit();
}

// Ambil data FPK dari database jika diperlukan
$fpk_query = "SELECT fpk_selection FROM hcc"; // Sesuaikan nama tabel dan kolom
$fpk_result = $connection->query($fpk_query);
$fpk_data = $fpk_result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Check HC</title>
  <!-- Tambahkan link CSS dan JS jika diperlukan -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 14px;
      margin: 0;
      padding: 10px;
      display: flex;
      justify-content: center;
      background-color: #EAFAF1;
    }

    .container {
      align-items: left;
      max-width: 1050px;
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
      padding: 2px 20px;
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



    table {
      width: 80%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    td {
      padding-bottom: -2px;
      vertical-align: top;
    }


    td input[type="text"],
    td input[type="date"],
    td input[type="email"],
    td select {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    td input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      padding: 2px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    td input[type="submit"]:hover {
      background-color: #45a049;
    }

    /* tr:nth-child(even) {
            background-color: #f9f9f9;
        } */

    tr:nth-child(odd) {
      background-color: #fff;
    }

    tr:hover {
      background-color: #f1f1f1;
    }
  </style>
  <style>
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
  </style>
  <style>
    .card {
      width: 1050px;
      border-radius: 10px;
      box-shadow: 0 4px 0 0 rgba(0, 0, 0, 0.2);
      overflow: hidden;
      background-color: #fff;
    }

    .card img {
      width: 1050px;
      /* Lebar gambar 1200px */
      height: 150px;
      /* Tinggi gambar 150px */
      border-radius: 10px 10px 0 0;
    }

    .card-content {
      width: 1000px;
      /* Lebar gambar 1200px */
      /* padding: 10px; */
    }

    .card-content h3 {
      margin-top: 0;
      margin-bottom: 0;
      font-size: 1rem;
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
      padding: 5px;
      /* Padding atas dan bawah 15px, padding kiri dan kanan 32px */
      text-align: center;
      /* Teks rata tengah */
      text-decoration: none;
      display: inline-block;
      font-size: 12px;
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

    /* .table-container {
                display: flex;
                justify-content: space-between;
                width: 100%;
            } */

    .table-cell {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: center;
      width: 100%;
    }

    .radio-label {
      display: flex;
      align-items: center;
    }

    .radio-label input[type="radio"] {
      margin-right: 5px;
    }

    .radio-container {
      display: flex;
      align-items: center;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="card">
      <img src="img/hc-header.png" alt="Placeholder Image" style="width: 1060px; margin-left: -5px;">
      <div class="card-content">

        <table class="table mt-4" style="margin-left: 20px;  width: 100%;">
          <div class="table-cell" style="display: flex; justify-content: center; align-items: center; flex-direction: column; margin-top: 10px; margin-bottom: 10px;">
            <div style="margin-bottom: -10px; display: flex; justify-content: center; align-items: center; width: 50%;">
              <input type="text" id="hc" name="hc" value="No : 497/HC/HRD-Div-HOLDING/VI/2024" readonly style="text-align: center;">
            </div>
          </div>
          <!-- Baris 1 -->
          <tr class="table-container">
            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
              <div class="table-cell">
                <label for="fpk_selection" style="width: 250px;">FPK No</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="fpk_selection" name="fpk_selection" value="<?php echo htmlspecialchars($row['fpk_selection']); ?>">
                </div>
            </td>
            <td style="width: 45%; vertical-align: middle; height: 5px;">
              <div class="table-cell">
                <label for="id_candidates" style="width: 250px;">Nama Kandidat:</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="nama_kandidat" name="nama_kandidat" value="<?php echo htmlspecialchars($row['nama_kandidat']); ?>">
                </div>
              </div>
            </td>
          </tr>

          <!-- Baris 2 -->
          <tr class="table-container">
            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
              <div class="table-cell">
                <label for="golongan" style="width: 250px;">Level/golongan</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="golongan" name="golongan" placeholder="Level / Golongan" value="<?php echo htmlspecialchars($row['golongan']); ?>" required>
                </div>
              </div>
            </td>
            <td style="width: 45%; vertical-align: middle; height: 5px;">
              <div class="table-cell">
                <label for="form_tanggal_lengkap" style="width: 250px;">Tanggal Lahir</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="date" id="form_tanggal_lengkap" name="form_tanggal_lengkap" value="<?php echo htmlspecialchars($row['form_tanggal_lengkap']); ?>">
                </div>
              </div>
            </td>
          </tr>

          <!-- Baris 3 -->
          <tr class="table-container">
            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
              <div class="table-cell">
                <label for="branch" style="width: 250px;">Unit Bisnis</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="branch" name="branch" placeholder="Unit Bisnis" value="<?php echo htmlspecialchars($row['branch']); ?>" required>
                </div>
              </div>
            </td>
            <td style="width: 45%; vertical-align: middle; height: 5px;">
              <div class="table-cell">
                <label for="no_ktp" style="width: 250px;">No. KTP</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="no_ktp" name="no_ktp" placeholder="No. KTP" value="<?php echo htmlspecialchars($row['no_ktp']); ?>" required>
                </div>
              </div>
            </td>
          </tr>

          <!-- Baris 4 -->
          <tr class="table-container">
            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
              <div class="table-cell"> <label for="jabatan" style="width: 250px;">Jabatan</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="jabatan" name="jabatan" placeholder="Jabatan" value="<?php echo htmlspecialchars($row['jabatan']); ?>" required>
                </div>
            </td>
            <td style="width: 45%; vertical-align: middle; height: 5px;">
              <div class="table-cell"> <label for="pendidikan" style="width: 250px;">Pendidikan</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="pendidikan" name="pendidikan" placeholder="Pendidikan" value="<?php echo htmlspecialchars($row['pendidikan']); ?>" required>
                </div>
              </div>
            </td>
          </tr>

          <!-- Baris 5 -->
          <tr class="table-container">
            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
              <div class="table-cell">
                <label for="organisasi" style="width: 250px;">Divisi/Dept</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="organisasi" name="organisasi" placeholder="Divisi / Departmen" value="<?php echo htmlspecialchars($row['organisasi']); ?>" required>
                </div>
              </div>
            </td>
            <td style="width: 45%; vertical-align: middle; height: 5px;">
              <div class="table-cell"> <label for="alasan_penerimaan" style="width: 250px;">Alasan Penerimaan</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="alasan_penerimaan" name="alasan_penerimaan" placeholder="Alasan Penerimaan" value="<?php echo htmlspecialchars($row['alasan_penerimaan']); ?>" required>
                </div>
              </div>
            </td>
          </tr>
        </table>


        <table class="table mt-4" style="margin-left: 20px;  width: 100%;">
          <h5 style="margin-left: 20px;  width: 100%;"><strong>Pengajuan</strong></h5>
          <!-- Baris 1 -->
          <tr class="table-container">
            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
              <div class="table-cell">
                <label for="fpk_selection" style="width: 250px;">Gaji Pokok</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_gaji_pokok" name="check_gaji_pokok" placeholder="Gaji Pokok" value="<?php echo htmlspecialchars($row['gaji_pokok']); ?>" required>
                </div>
              </div>
            </td>
            <td style="width: 45%; vertical-align: middle; height: 5px; background-color: #fcf5cc;">
              <div class="table-cell">
                <label for="fpk_selection" style="width: 250px;">Gaji Pokok</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_gaji_pokok" name="check_gaji_pokok" placeholder="Gaji Pokok" required>
                </div>
              </div>
            </td>
          </tr>

          <!-- Baris 2 -->
          <tr class="table-container">
            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
              <div class="table-cell">
                <label for="check_tunjangan_makan" style="width: 250px;">Tunjangan Makan</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_tunjangan_makan" name="check_tunjangan_makan" placeholder="Tunjangan Makan" value="<?php echo htmlspecialchars($row['tunjangan_makan']); ?>" required>
                </div>
              </div>
            </td>
            <td style="width: 45%; vertical-align: middle; height: 5px; background-color: #fcf5cc;">
              <div class="table-cell">
                <label for="check_tunjangan_makan" style="width: 250px;">Tunjangan Makan</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_tunjangan_makan" name="check_tunjangan_makan" placeholder="Tunjangan Makan" required>
                </div>
              </div>
            </td>
          </tr>

          <!-- Baris 3 -->
          <tr class="table-container">
            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
              <div class="table-cell">
                <label for="check_tunjangan_transport" style="width: 250px;">Tunjangan Transport</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_tunjangan_transport" name="check_tunjangan_transport" placeholder="Tunjangan Transport" value="<?php echo htmlspecialchars($row['tunjangan_transport']); ?>" required>
                </div>
              </div>
            </td>
            <td style="width: 45%; vertical-align: middle; height: 5px; background-color: #fcf5cc;">
              <div class="table-cell">
                <label for="check_tunjangan_transport" style="width: 250px;">Tunjangan Transport</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_tunjangan_transport" name="check_tunjangan_transport" placeholder="Tunjangan Transport" required>
                </div>
              </div>
            </td>
          </tr>

          <!-- Baris 4 -->
          <tr class="table-container">
            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
              <div class="table-cell">
                <label for="check_tunjangan_kendaraan" style="width: 250px;">Tunjangan Kendaraan</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_tunjangan_kendaraan" name="check_tunjangan_kendaraan" placeholder="Tunjangan Kendaraan" value="<?php echo htmlspecialchars($row['tunjangan_kendaraan']); ?>" required>
                </div>
              </div>
            </td>
            <td style="width: 45%; vertical-align: middle; height: 5px; background-color: #fcf5cc;">
              <div class="table-cell">
                <label for="check_tunjangan_kendaraan" style="width: 250px;">Tunjangan Kendaraan</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_tunjangan_kendaraan" name="check_tunjangan_kendaraan" placeholder="Tunjangan Kendaraan" required>
                </div>
              </div>
            </td>
          </tr>

          <!-- Baris 5 -->
          <tr class="table-container">
            <td style="width: 45%; vertical-align: middle; background-color: #f0f0f0;">
              <div class="table-cell">
                <label for="check_total_sallary_gross" style="width: 250px; font-weight: bold;">Total Salary (Gross)</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_total_sallary_gross" name="check_total_sallary_gross" placeholder="Total Salary Gross" style="font-weight: bold; background-color: #f0f0f0;" value="<?php echo htmlspecialchars($row['total_sallary_gross']); ?>" readonly>
                </div>
              </div>
            </td>
            <td style="width: 45%; vertical-align: middle; background-color: #f8e784;">
              <div class="table-cell">
                <label for="check_total_sallary_gross" style="width: 250px; font-weight: bold;">Total Salary (Gross)</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_total_sallary_gross" name="check_total_sallary_gross" placeholder="Total Salary Gross" style="font-weight: bold; background-color: #f0f0f0;" readonly>
                </div>
              </div>
            </td>
          </tr>

          <!-- Baris 6 -->
          <tr class="table-container">
            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
              <div class="table-cell">
                <label for="check_bpjs_jht" style="width: 250px;">BPJS Ketenagakerjaan (JHT)</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_bpjs_jht" name="check_bpjs_jht" placeholder="BPJS Ketenagakerjaan (JHT)" value="<?php echo htmlspecialchars($row['bpjs_jht']); ?>" required>
                </div>
              </div>
            </td>
            <td style="width: 45%; vertical-align: middle; height: 5px; background-color: #fcf5cc;">
              <div class="table-cell">
                <label for="check_bpjs_jht" style="width: 250px;">BPJS Ketenagakerjaan (JHT)</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_bpjs_jht" name="check_bpjs_jht" placeholder="BPJS Ketenagakerjaan (JHT)" required>
                </div>
              </div>
            </td>
          </tr>

          <!-- Baris 7 -->
          <tr class="table-container">
            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
              <div class="table-cell">
                <label for="check_bpjs_jp" style="width: 250px;">BPJS Ketenagakerjaan <br> (JP)</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_bpjs_jp" name="check_bpjs_jp" placeholder="BPJS Ketenagakerjaan (JP)" value="<?php echo htmlspecialchars($row['bpjs_jp']); ?>" required>
                </div>
              </div>
            </td>
            <td style="width: 45%; vertical-align: middle; height: 5px; background-color: #fcf5cc;">
              <div class="table-cell">
                <label for="check_bpjs_jp" style="width: 250px;">BPJS Ketenagakerjaan <br> (JP)</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_bpjs_jp" name="check_bpjs_jp" placeholder="BPJS Ketenagakerjaan (JP)" required>
                </div>
              </div>
            </td>
          </tr>

          <!-- Baris 8 -->
          <tr class="table-container">
            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
              <div class="table-cell">
                <label for="check_bpjs_ks" style="width: 250px;">BPJS Kesehatan</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_bpjs_ks" name="check_bpjs_ks" placeholder="BPJS Kesehatan" value="<?php echo htmlspecialchars($row['bpjs_ks']); ?>" required>
                </div>
              </div>
            </td>
            <td style="width: 45%; vertical-align: middle; height: 5px; background-color: #fcf5cc;">
              <div class="table-cell">
                <label for="check_bpjs_ks" style="width: 250px;">BPJS Kesehatan</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_bpjs_ks" name="check_bpjs_ks" placeholder="BPJS Kesehatan" required>
                </div>
              </div>
            </td>
          </tr>

          <!-- Baris 9 -->
          <tr class="table-container">
            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
              <div class="table-cell">
                <label for="check_koperasi_karyawan" style="width: 250px;">Koperasi Karyawan</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_koperasi_karyawan" name="check_koperasi_karyawan" placeholder="Koperasi Karyawan" value="<?php echo htmlspecialchars($row['koperasi_karyawan']); ?>" required>
                </div>
              </div>
            </td>
            <td style="width: 45%; vertical-align: middle; height: 5px; background-color: #fcf5cc;">
              <div class="table-cell">
                <label for="check_koperasi_karyawan" style="width: 250px;">Koperasi Karyawan</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_koperasi_karyawan" name="check_koperasi_karyawan" placeholder="Koperasi Karyawan" required>
                </div>
              </div>
            </td>
          </tr>

          <!-- Baris 10 -->
          <tr class="table-container">
            <td style="width: 45%; vertical-align: middle; background-color: #f0f0f0;">
              <div class="table-cell">
                <label for="check_total_sallary_nett" style="width: 250px; font-weight: bold;">Total Salary (Nett)</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_total_sallary_nett" name="check_total_sallary_nett" placeholder="Total Salary Nett" style="font-weight: bold; background-color: #f0f0f0;" value="<?php echo htmlspecialchars($row['total_sallary_nett']); ?>" readonly>
                </div>
              </div>
            </td>
            <td style="width: 45%; vertical-align: middle; background-color: #f8e784;">
              <div class="table-cell">
                <label for="check_total_sallary_nett" style="width: 250px; font-weight: bold;">Total Salary (Nett)</label>
                <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                  <input type="text" id="check_total_sallary_nett" name="check_total_sallary_nett" placeholder="Total Salary Nett" style="font-weight: bold; background-color: #f0f0f0;" readonly>
                </div>
              </div>
            </td>
          </tr>
        </table>

        <!-- Bagian Checklist Dokumen -->
        <h5 style="margin-left: 20px; width: 100%;"><strong>Checklist Dokumen</strong></h5>
        <table style="margin-left: 20px; width: 100%;">
          <?php
          // Asumsi $row sudah berisi data dari database
          $pas_foto = $row['pas_foto'];
          $form_interview_user = $row['form_interview_user'];
          $foto_ktp = $row['foto_ktp'];
          $form_interview_hr = $row['form_interview_hr'];
          $foto_ijazah = $row['foto_ijazah'];
          $form_hasil_psikotest = $row['form_hasil_psikotest'];
          $foto_transkip_nilai = $row['foto_transkip_nilai'];
          $form_confirmation_letter = $row['form_confirmation_letter'];
          $foto_buku_tabungan = $row['foto_buku_tabungan'];
          ?>

          <!-- BARIS 1 -->
          <tr class="table-container">
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">Form Aplikasi</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="form_aplikasi_lengkap" name="form_aplikasi" value="Lengkap" required <?php echo ($row['form_aplikasi'] == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="form_aplikasi_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="form_aplikasi_tidak_lengkap" name="form_aplikasi" value="Tidak Lengkap" required <?php echo ($row['form_aplikasi'] == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="form_aplikasi_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="form_aplikasi_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">Foto</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="pas_foto_lengkap" name="pas_foto" value="Lengkap" required <?php echo ($pas_foto == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="pas_foto_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="pas_foto_tidak_lengkap" name="pas_foto" value="Tidak Lengkap" required <?php echo ($pas_foto == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="pas_foto_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="pas_foto_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
          </tr>

          <!-- BARIS 2 -->
          <tr class="table-container">
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">Interview User</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="form_interview_user_lengkap" name="form_interview_user" value="Lengkap" required <?php echo ($form_interview_user == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="form_interview_user_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="form_interview_user_tidak_lengkap" name="form_interview_user" value="Tidak Lengkap" required <?php echo ($form_interview_user == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="form_interview_user_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="form_interview_user_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">Scan KTP</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="foto_ktp_lengkap" name="foto_ktp" value="Lengkap" required <?php echo ($foto_ktp == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="foto_ktp_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="foto_ktp_tidak_lengkap" name="foto_ktp" value="Tidak Lengkap" required <?php echo ($foto_ktp == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="foto_ktp_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="foto_ktp_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
          </tr>

          <!-- BARIS 3 -->
          <tr class="table-container">
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">Interview HR</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="form_interview_hr_lengkap" name="form_interview_hr" value="Lengkap" required <?php echo ($form_interview_hr == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="form_interview_hr_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="form_interview_hr_tidak_lengkap" name="form_interview_hr" value="Tidak Lengkap" required <?php echo ($form_interview_hr == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="form_interview_hr_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="form_interview_hr_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">Scan Ijazah</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="foto_ijazah_lengkap" name="foto_ijazah" value="Lengkap" required <?php echo ($foto_ijazah == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="foto_ijazah_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="foto_ijazah_tidak_lengkap" name="foto_ijazah" value="Tidak Lengkap" required <?php echo ($foto_ijazah == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="foto_ijazah_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="foto_ijazah_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
          </tr>

          <!-- BARIS 4 -->
          <tr class="table-container">
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">Laporan Hasil Psikotest</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="form_hasil_psikotest_lengkap" name="form_hasil_psikotest" value="Lengkap" required <?php echo ($form_hasil_psikotest == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="form_hasil_psikotest_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="form_hasil_psikotest_tidak_lengkap" name="form_hasil_psikotest" value="Tidak Lengkap" required <?php echo ($form_hasil_psikotest == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="form_hasil_psikotest_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="form_hasil_psikotest_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">Scan Transkip Nilai</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="foto_transkip_nilai_lengkap" name="foto_transkip_nilai" value="Lengkap" required <?php echo ($foto_transkip_nilai == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="foto_transkip_nilai_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="foto_transkip_nilai_tidak_lengkap" name="foto_transkip_nilai" value="Tidak Lengkap" required <?php echo ($foto_transkip_nilai == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="foto_transkip_nilai_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="foto_transkip_nilai_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
          </tr>

          <!-- BARIS 5 -->
          <tr class="table-container">
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">Confirmation Letter</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="form_confirmation_letter_lengkap" name="form_confirmation_letter" value="Lengkap" required <?php echo ($form_confirmation_letter == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="form_confirmation_letter_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="form_confirmation_letter_tidak_lengkap" name="form_confirmation_letter" value="Tidak Lengkap" required <?php echo ($form_confirmation_letter == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="form_confirmation_letter_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="form_confirmation_letter_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">Scan Buku Tabungan</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="foto_buku_tabungan_lengkap" name="foto_buku_tabungan" value="Lengkap" required <?php echo ($foto_buku_tabungan == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="foto_buku_tabungan_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="foto_buku_tabungan_tidak_lengkap" name="foto_buku_tabungan" value="Tidak Lengkap" required <?php echo ($foto_buku_tabungan == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="foto_buku_tabungan_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="foto_buku_tabungan_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
          </tr>
          <?php
          // Asumsi $row sudah berisi data dari database
          $form_hasil_tes_kesehatan = $row['form_hasil_tes_kesehatan'];
          $foto_npwp = $row['foto_npwp'];
          $referensi_kerja = $row['referensi_kerja'];
          $foto_kk = $row['foto_kk'];
          $bpjs_kesehatan = $row['bpjs_kesehatan'];
          $foto_sertifikat = $row['foto_sertifikat'];
          $bpjs_ketenagakerjaan = $row['bpjs_ketenagakerjaan'];
          $bpjs_jaminan_pensiun = $row['bpjs_jaminan_pensiun'];
          ?>

          <!-- BARIS 6 -->
          <tr class="table-container">
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">Hasil Tes Kesehatan</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="form_hasil_tes_kesehatan_lengkap" name="form_hasil_tes_kesehatan" value="Lengkap" required <?php echo ($form_hasil_tes_kesehatan == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="form_hasil_tes_kesehatan_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="form_hasil_tes_kesehatan_tidak_lengkap" name="form_hasil_tes_kesehatan" value="Tidak Lengkap" required <?php echo ($form_hasil_tes_kesehatan == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="form_hasil_tes_kesehatan_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="form_hasil_tes_kesehatan_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">Scan NPWP</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="foto_npwp_lengkap" name="foto_npwp" value="Lengkap" required <?php echo ($foto_npwp == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="foto_npwp_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="foto_npwp_tidak_lengkap" name="foto_npwp" value="Tidak Lengkap" required <?php echo ($foto_npwp == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="foto_npwp_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="foto_npwp_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
          </tr>

          <!-- BARIS 7 -->
          <tr class="table-container">
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">Referensi Kerja</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="referensi_kerja_lengkap" name="referensi_kerja" value="Lengkap" required <?php echo ($referensi_kerja == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="referensi_kerja_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="referensi_kerja_tidak_lengkap" name="referensi_kerja" value="Tidak Lengkap" required <?php echo ($referensi_kerja == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="referensi_kerja_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="referensi_kerja_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">Scan Kartu Keluarga</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="foto_kk_lengkap" name="foto_kk" value="Lengkap" required <?php echo ($foto_kk == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="foto_kk_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="foto_kk_tidak_lengkap" name="foto_kk" value="Tidak Lengkap" required <?php echo ($foto_kk == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="foto_kk_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="foto_kk_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
          </tr>

          <!-- BARIS 8 -->
          <tr class="table-container">
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">BPJS Kesehatan</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="bpjs_kesehatan_lengkap" name="bpjs_kesehatan" value="Lengkap" required <?php echo ($bpjs_kesehatan == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="bpjs_kesehatan_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="bpjs_kesehatan_tidak_lengkap" name="bpjs_kesehatan" value="Tidak Lengkap" required <?php echo ($bpjs_kesehatan == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="bpjs_kesehatan_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="bpjs_kesehatan_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">Scan Sertifikat</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="foto_sertifikat_lengkap" name="foto_sertifikat" value="Lengkap" required <?php echo ($foto_sertifikat == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="foto_sertifikat_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="foto_sertifikat_tidak_lengkap" name="foto_sertifikat" value="Tidak Lengkap" required <?php echo ($foto_sertifikat == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="foto_sertifikat_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="foto_sertifikat_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
          </tr>

          <!-- BARIS 9 -->
          <tr class="table-container">
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">BPJS Ketenagakerjaan</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="bpjs_ketenagakerjaan_lengkap" name="bpjs_ketenagakerjaan" value="Lengkap" required <?php echo ($bpjs_ketenagakerjaan == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="bpjs_ketenagakerjaan_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="bpjs_ketenagakerjaan_tidak_lengkap" name="bpjs_ketenagakerjaan" value="Tidak Lengkap" required <?php echo ($bpjs_ketenagakerjaan == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="bpjs_ketenagakerjaan_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="bpjs_ketenagakerjaan_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
          </tr>

          <!-- BARIS 10 -->
          <tr class="table-container">
            <td style="width: 50%; vertical-align: middle;">
              <div class="table-cell">
                <label style="width: 50%;">BPJS Jaminan Pensiun</label>
                <div class="radio-container">
                  <div class="radio-label">
                    <input type="radio" id="bpjs_jaminan_pensiun_lengkap" name="bpjs_jaminan_pensiun" value="Lengkap" required <?php echo ($bpjs_jaminan_pensiun == 'Lengkap') ? 'checked' : ''; ?>>
                    <label for="bpjs_jaminan_pensiun_lengkap">Lengkap</label>
                  </div>
                  <div class="radio-label">
                    <input type="radio" id="bpjs_jaminan_pensiun_tidak_lengkap" name="bpjs_jaminan_pensiun" value="Tidak Lengkap" required <?php echo ($bpjs_jaminan_pensiun == 'Tidak Lengkap') ? 'checked' : ''; ?>>
                    <label for="bpjs_jaminan_pensiun_tidak_lengkap">Tidak Lengkap</label>
                  </div>
                  <a href="javascript:void(0);" id="bpjs_jaminan_pensiun_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                </div>
              </div>
            </td>
          </tr>

        </table>
        <!-- JavaScript -->
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            const grossFields = [
              'check_gaji_pokok', 'check_tunjangan_makan', 'check_tunjangan_transport',
              'check_tunjangan_kendaraan'
            ];

            const nettFields = [
              'check_bpjs_jht', 'check_bpjs_jp', 'check_bpjs_ks', 'check_koperasi_karyawan'
            ];

            const formatRupiah = (angka, prefix) => {
              const number_string = angka.replace(/[^,\d]/g, '').toString();
              const split = number_string.split(',');
              const sisa = split[0].length % 3;
              let rupiah = split[0].substr(0, sisa);
              const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

              if (ribuan) {
                const separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
              }

              rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
              return prefix === undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
            };

            const calculateTotal = () => {
              let grossTotal = 0;
              let nettTotal = 0;

              grossFields.forEach(id => {
                const value = document.getElementById(id).value.replace(/[^,\d]/g, '');
                grossTotal += parseInt(value) || 0;
              });

              nettFields.forEach(id => {
                const value = document.getElementById(id).value.replace(/[^,\d]/g, '');
                nettTotal += parseInt(value) || 0;
              });

              const totalGrossElement = document.getElementById('check_total_sallary_gross');
              const totalNettElement = document.getElementById('check_total_sallary_nett');
              totalGrossElement.value = formatRupiah(grossTotal.toString(), 'Rp ');
              totalNettElement.value = formatRupiah((grossTotal - nettTotal).toString(), 'Rp ');
            };

            const allFields = [...grossFields, ...nettFields];

            allFields.forEach(id => {
              const inputElement = document.getElementById(id);
              inputElement.addEventListener('blur', function() {
                this.value = formatRupiah(this.value, 'Rp ');
                calculateTotal();
              });
            });
          });
        </script>
      </div>
    </div>
</body>

</html>