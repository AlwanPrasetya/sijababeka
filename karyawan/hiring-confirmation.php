<?php
// proses.php

// Konfigurasi koneksi ke database
$host = 'localhost';
$dbname = 'db_sijababeka';
$username = 'alwan';
$password = 'root';

// proses.php
// Check if id_biodata is set in the URL
if (isset($_GET['id_biodata'])) {
  $id = $_GET['id_biodata'];
} else {
  die("Error: id_biodata not found in the URL.");
}

try {
  // Koneksi ke database
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
  // Atur mode error untuk PDO ke Exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Ambil id_biodata dari URL (misalnya detail_biodata.php?id_biodata=ID-1716352436538)
  if (isset($_GET['id_biodata'])) {
    $id_biodata = $_GET['id_biodata'];

    // Query untuk mengambil data dari database
    $stmt = $pdo->prepare("SELECT * FROM biodata_karyawan WHERE id_biodata = :id_biodata");
    $stmt->bindParam(':id_biodata', $id_biodata);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Jika data ditemukan
    if ($data) {
      $posisi = $data['posisi'];
      $nama_lengkap = $data['nama_lengkap'];
      $nama_panggilan = $data['nama_panggilan'];
      $jenis_kelamin = $data['jenis_kelamin'];
      $golongan_darah = $data['golongan_darah'];
      $tm_lahir = $data['tm_lahir'];
      $tanggal_lahir = $data['tanggal_lahir'];
      $no_ktp = $data['no_ktp'];
      $no_npwp = $data['no_npwp'];
      $kewarganegaraan = $data['kewarganegaraan'];
      $agama = $data['agama'];
      $no_tlpn_rumah = $data['no_tlpn_rumah'];
      $no_tlpn = $data['no_tlpn'];
      $email = $data['email'];
      $foto = $data['foto'];
      // Tambahkan variabel lain yang diperlukan dari database

      // // Contoh penggunaan nilai yang telah diambil
      // echo "Data untuk ID Biodata: $id_biodata<br>";
      // echo "Nama Lengkap: " . ($nama_lengkap ?: 'Data tidak tersedia') . "<br>";
      // echo "Email: " . ($email ?: 'Data tidak tersedia') . "<br>";
    } else {
      echo "Data tidak ditemukan.";
    }
  } else {
    echo "ID Biodata tidak ditemukan dalam URL.";
  }
} catch (PDOException $e) {
  die("Gagal terkoneksi dengan database: " . $e->getMessage());
}
?>


<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #EAFAF1;
    margin: 0;
    padding: 0;


    h1,
    h3,
    h4 {
      color: #333;
    }

    form {
      max-width: 900px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .section {
      flex: 1 1 45%;
      min-width: 45%;
    }

    .two-columns {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    td {
      padding: 10px;
      vertical-align: top;
    }

    td input[type="text"],
    td input[type="date"],
    td input[type="email"] {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    td input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    td input[type="submit"]:hover {
      background-color: #45a049;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tr:nth-child(odd) {
      background-color: #fff;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    h1 {
      margin-top: 2rem;
      text-align: center;
    }

    .full-width {
      flex: 1 1 100%;
    }

    body {
      margin: 0;
      font-family: "Montserrat", sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
    }

    .form-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .form-table th,
    .form-table td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }

    .form-table th {
      background-color: yellowgreen;
      color: white;
    }

    .form-table td {
      background-color: #ffffff;
    }

    .form-table input,
    .form-table select {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
    }

    .form-container {
      background-color: white;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

  }
</style>
<h3 style="margin-top: 0px;">
  <center>Unggah Dokumen</center>
</h3>


<form id="myForm" action="proses-upload-file.php?id_biodata=<?php echo $id; ?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
  <!-- Tabel Data Peribadi -->
  <table style="width:100%;">
    <tr>
      <td style="width:50%">
        <!-- Kolom Kiri -->
        <table>
          <tr>
            <td style="width:50%">Referensi kerja:</td>
            <td><input type="file" id="referensi_kerja" name="referensi_kerja" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"></td>
          </tr>
          <tr>
            <td>BPJS Kesehatan</td>
            <td><input type="file" name="bpjs_ks" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"></td>
          </tr>
          <tr>
            <td>BPJS Ketenagakerjaan</td>
            <td><input type="file" name="bpjs_kg" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"></td>
          </tr>
          <tr>
            <td>BPJS Jaminan Pensiun</td>
            <td><input type="file" name="bpjs_jp" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"></td>
          </tr>
          <tr>
            <td>Fotocopy KTP:</td>
            <td><input type="file" name="foto_ktp" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"></td>
          </tr>
        </table>

      </td>

      <td style="width:50%;">
        <table>
          <tr>
            <td>Fotocopy Ijazah:</td>
            <td><input type="file" name="fc_ijazah" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required></td>
          </tr>
          <tr>
            <td>Fotocopy Transkip Nilai:</td>
            <td><input type="file" name="fc_tn" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"></td>
          </tr>
          <tr>
            <td>Fotocopy Buku Tabungan:</td>
            <td><input type="file" name="fc_bt" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"></td>
          </tr>
          <tr>
            <td>Fotocopy NPWP:</td>
            <td><input type="file" name="fc_npwp" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"></td>
          </tr>
          <tr>
            <td>Fotocopy KK:</td>
            <td><input type="file" name="fc_kk" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"></td>
          </tr>
          <tr>
            <td>Fotocopy Sertifikat</td>
            <td><input type="file" name="fc_sp" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <style>
    .container {
      display: flex;
      justify-content: space-between;
    }

    .form-column {
      width: 48%;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
    }

    .form-column h4 {
      margin-top: 0;
      font-size: 18px;
      color: #333333;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      border: 1px solid #dddddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    .form-column input[type="text"],
    .form-column input[type="date"],
    .form-column select {
      width: calc(100% - 16px);
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #cccccc;
      border-radius: 4px;
    }

    .form-column input[type="text"]:focus,
    .form-column input[type="date"]:focus,
    .form-column select:focus {
      outline: none;
      border-color: #4CAF50;
    }

    .form-column button {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin-top: 10px;
      cursor: pointer;
      border-radius: 4px;
    }

    .form-column button:hover {
      background-color: #45a049;
    }

    @media screen and (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .form-column {
        width: 100%;
        margin-bottom: 20px;
      }
    }
  </style>

  <tr>
    <td>
      <button type="submit" value="simpan" name="submit">Submit</button>
    </td>
  </tr>
</form>