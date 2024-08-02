<?php
include('koneksi.php');
// Periksa apakah ada parameter 'id' dalam URL
if (isset($_GET['id'])) {
    // Ambil nilai ID dari URL
    $userId = $_GET['id'];
    $posisi = $_GET['posisi'];


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
// Sambungan ke database
$servername = "localhost";
$username = "alwan";
$password = "root";
$dbname = "db_sijababeka";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil data keluarga
$sql = "SELECT nama_ayah, tempat_lahir_ayah, tanggal_lahir_ayah, pekerjaan_ayah FROM biodata_karyawan";
$result = $conn->query($sql);

$keluargaData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $keluargaData[] = $row;
    }
}
$conn->close();
?>

<?php
// proses.php

// Konfigurasi koneksi ke database
$host = 'localhost';
$dbname = 'db_sijababeka';
$username = 'alwan';
$password = 'root';

// proses.php

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
            $kecamatan = $data['kecamatan'];
            $kota = $data['kota'];
            $provinsi = $data['provinsi'];
            $kode_pos = $data['kode_pos'];
            $alamat_domisili = $data['alamat_domisili'];
            $nama_kd = $data['nama_kd'];
            $no_tlpn_kd = $data['no_tlpn_kd'];
            $hubungan_kd = $data['hubungan_kd'];
            $alamat_kd = $data['alamat_kd'];
            $status = $data['status'];
            $nama_ayah = $data['nama_ayah'];
            $tempat_lahir_ayah = $data['tempat_lahir_ayah'];
            $tanggal_lahir_ayah = $data['tanggal_lahir_ayah'];
            $pekerjaan_ayah = $data['pekerjaan_ayah'];
            $nama_ibu = $data['nama_ibu'];
            $tempat_lahir_ibu = $data['tempat_lahir_ibu'];
            $tanggal_lahir_ibu = $data['tanggal_lahir_ibu'];
            $pekerjaan_ibu = $data['pekerjaan_ibu'];
            $nama_pertama = $data['nama_pertama'];
            $jk_pertama = $data['jk_pertama'];
            $tempat_lahir_pertama = $data['tempat_lahir_pertama'];
            $tanggal_lahir_pertama = $data['tanggal_lahir_pertama'];
            $pekerjaan_pertama = $data['pekerjaan_pertama'];
            $nama_kedua = $data['nama_kedua'];
            $jk_kedua = $data['jk_kedua'];
            $tempat_lahir_kedua = $data['tempat_lahir_kedua'];
            $tanggal_lahir_kedua = $data['tanggal_lahir_kedua'];
            $pekerjaan_kedua = $data['pekerjaan_kedua'];
            $nama_ketiga = $data['nama_ketiga'];
            $jk_ketiga = $data['jk_ketiga'];
            $tempat_lahir_ketiga = $data['tempat_lahir_ketiga'];
            $tanggal_lahir_ketiga = $data['tanggal_lahir_ketiga'];
            $pekerjaan_ketiga = $data['pekerjaan_ketiga'];
            $nama_keempat = $data['nama_keempat'];
            $jk_keempat = $data['jk_keempat'];
            $tempat_lahir_keempat = $data['tempat_lahir_keempat'];
            $tanggal_lahir_keempat = $data['tanggal_lahir_keempat'];
            $pekerjaan_keempat = $data['pekerjaan_keempat'];
            $nama_kelima = $data['nama_kelima'];
            $jk_kelima = $data['jk_kelima'];
            $tempat_lahir_kelima = $data['tempat_lahir_kelima'];
            $tanggal_lahir_kelima = $data['tanggal_lahir_kelima'];
            $pekerjaan_kelima = $data['pekerjaan_kelima'];
            $nama_suami = $data['nama_suami'];
            $tempat_lahir_suami = $data['tempat_lahir_suami'];
            $tanggal_lahir_suami = $data['tanggal_lahir_suami'];
            $pekerjaan_suami = $data['pekerjaan_suami'];
            $nama_istri = $data['nama_istri'];
            $tempat_lahir_istri = $data['tempat_lahir_istri'];
            $tanggal_lahir_istri = $data['tanggal_lahir_istri'];
            $pekerjaan_istri = $data['pekerjaan_istri'];
            $nama_anak_1 = $data['nama_anak_1'];
            $jk_anak_1 = $data['jk_anak_1'];
            $tempat_lahir_anak_1 = $data['tempat_lahir_anak_1'];
            $tanggal_lahir_anak_1 = $data['tanggal_lahir_anak_1'];
            $pekerjaan_anak_1 = $data['pekerjaan_anak_1'];
            $nama_anak_2 = $data['nama_anak_2'];
            $jk_anak_2 = $data['jk_anak_2'];
            $tempat_lahir_anak_2 = $data['tempat_lahir_anak_2'];
            $tanggal_lahir_anak_2 = $data['tanggal_lahir_anak_2'];
            $pekerjaan_anak_2 = $data['pekerjaan_anak_2'];
            $nama_anak_3 = $data['nama_anak_3'];
            $jk_anak_3 = $data['jk_anak_3'];
            $tempat_lahir_anak_3 = $data['tempat_lahir_anak_3'];
            $tanggal_lahir_anak_3 = $data['tanggal_lahir_anak_3'];
            $pekerjaan_anak_3 = $data['pekerjaan_anak_3'];
            $nama_anak_4 = $data['nama_anak_4'];
            $jk_anak_4 = $data['jk_anak_4'];
            $tempat_lahir_anak_4 = $data['tempat_lahir_anak_4'];
            $tanggal_lahir_anak_4 = $data['tanggal_lahir_anak_4'];
            $pekerjaan_anak_4 = $data['pekerjaan_anak_4'];
            $nama_anak_5 = $data['nama_anak_5'];
            $jk_anak_5 = $data['jk_anak_5'];
            $tempat_lahir_anak_5 = $data['tempat_lahir_anak_5'];
            $tanggal_lahir_anak_5 = $data['tanggal_lahir_anak_5'];
            $pekerjaan_anak_5 = $data['pekerjaan_anak_5'];
            $nama_institusi_s3 = $data['nama_institusi_s3'];
            $nama_fakultas_s3 = $data['nama_fakultas_s3'];
            $tahun_awal_s3 = $data['tahun_awal_s3'];
            $tahun_akhir_s3 = $data['tahun_akhir_s3'];
            $keterangan_s3 = $data['keterangan_s3'];
            $nama_institusi_s2 = $data['nama_institusi_s2'];
            $nama_fakultas_s2 = $data['nama_fakultas_s2'];
            $tahun_awal_s2 = $data['tahun_awal_s2'];
            $tahun_akhir_s2 = $data['tahun_akhir_s2'];
            $keterangan_s2 = $data['keterangan_s2'];
            $nama_institusi_s1 = $data['nama_institusi_s1'];
            $nama_fakultas_s1 = $data['nama_fakultas_s1'];
            $tahun_awal_s1 = $data['tahun_awal_s1'];
            $tahun_akhir_s1 = $data['tahun_akhir_s1'];
            $keterangan_s1 = $data['keterangan_s1'];
            $nama_institusi_diploma = $data['nama_institusi_diploma'];
            $nama_fakultas_diploma = $data['nama_fakultas_diploma'];
            $tahun_awal_diploma = $data['tahun_awal_diploma'];
            $tahun_akhir_diploma = $data['tahun_akhir_diploma'];
            $keterangan_diploma = $data['keterangan_diploma'];
            $nama_institusi_sma = $data['nama_institusi_sma'];
            $nama_fakultas_sma = $data['nama_fakultas_sma'];
            $tahun_awal_sma = $data['tahun_awal_sma'];
            $tahun_akhir_sma = $data['tahun_akhir_sma'];
            $keterangan_sma = $data['keterangan_sma'];
            $nama_institusi_smp = $data['nama_institusi_smp'];
            $tahun_awal_smp = $data['tahun_awal_smp'];
            $tahun_akhir_smp = $data['tahun_akhir_smp'];
            $keterangan_smp = $data['keterangan_smp'];
            $nama_institusi_sd = $data['nama_institusi_sd'];
            $tahun_awal_sd = $data['tahun_awal_sd'];
            $tahun_akhir_sd = $data['tahun_akhir_sd'];
            $keterangan_sd = $data['keterangan_sd'];
            $keterangan_sd = $data['keterangan_sd'];
            $beasiswa = $data['beasiswa'];
            $penghargaan = $data['penghargaan'];
            $kursus_pelatihan_1 = $data['kursus_pelatihan_1'];
            $kursus_pelatihan_2 = $data['kursus_pelatihan_2'];
            $kursus_pelatihan_3 = $data['kursus_pelatihan_3'];
            $nama_institusi_1 = $data['nama_institusi_1'];
            $nama_institusi_2 = $data['nama_institusi_2'];
            $nama_institusi_3 = $data['nama_institusi_3'];
            $lama_pelatihan_1 = $data['lama_pelatihan_1'];
            $lama_pelatihan_2 = $data['lama_pelatihan_2'];
            $lama_pelatihan_3 = $data['lama_pelatihan_3'];
            $bahasa_1 = $data['bahasa_1'];
            $bahasa_2 = $data['bahasa_2'];
            $bahasa_3 = $data['bahasa_3'];
            $lisan_1 = $data['lisan_1'];
            $lisan_2 = $data['lisan_2'];
            $lisan_3 = $data['lisan_3'];
            $tulisan_1 = $data['tulisan_1'];
            $tulisan_2 = $data['tulisan_2'];
            $tulisan_3 = $data['tulisan_3'];
            $tahun_awal_1 = $data['tahun_awal_1'];
            $tahun_awal_2 = $data['tahun_awal_2'];
            $tahun_awal_3 = $data['tahun_awal_3'];
            $tahun_awal_4 = $data['tahun_awal_4'];
            $tahun_awal_5 = $data['tahun_awal_5'];
            $tahun_awal_6 = $data['tahun_awal_6'];
            $tahun_awal_7 = $data['tahun_awal_7'];
            $tahun_akhir_1 = $data['tahun_akhir_1'];
            $tahun_akhir_2 = $data['tahun_akhir_2'];
            $tahun_akhir_3 = $data['tahun_akhir_3'];
            $tahun_akhir_4 = $data['tahun_akhir_4'];
            $tahun_akhir_5 = $data['tahun_akhir_5'];
            $tahun_akhir_6 = $data['tahun_akhir_6'];
            $tahun_akhir_7 = $data['tahun_akhir_7'];
            $nama_perusahaan_1 = $data['nama_perusahaan_1'];
            $nama_perusahaan_2 = $data['nama_perusahaan_2'];
            $nama_perusahaan_3 = $data['nama_perusahaan_3'];
            $nama_perusahaan_4 = $data['nama_perusahaan_4'];
            $nama_perusahaan_5 = $data['nama_perusahaan_5'];
            $nama_perusahaan_6 = $data['nama_perusahaan_6'];
            $nama_perusahaan_7 = $data['nama_perusahaan_7'];
            $jabatan_1 = $data['jabatan_1'];
            $jabatan_2 = $data['jabatan_2'];
            $jabatan_3 = $data['jabatan_3'];
            $jabatan_4 = $data['jabatan_4'];
            $jabatan_5 = $data['jabatan_5'];
            $jabatan_6 = $data['jabatan_6'];
            $jabatan_7 = $data['jabatan_7'];
            $gaji_1 = $data['gaji_1'];
            $gaji_2 = $data['gaji_2'];
            $gaji_3 = $data['gaji_3'];
            $gaji_4 = $data['gaji_4'];
            $gaji_5 = $data['gaji_5'];
            $gaji_6 = $data['gaji_6'];
            $gaji_7 = $data['gaji_7'];
            $alasan_keluar_1 = $data['alasan_keluar_1'];
            $alasan_keluar_2 = $data['alasan_keluar_2'];
            $alasan_keluar_3 = $data['alasan_keluar_3'];
            $alasan_keluar_4 = $data['alasan_keluar_4'];
            $alasan_keluar_5 = $data['alasan_keluar_5'];
            $alasan_keluar_6 = $data['alasan_keluar_6'];
            $alasan_keluar_7 = $data['alasan_keluar_7'];
            $saudara_kerja = $data['saudara_kerja'];
            $nama_saudara_kerja = $data['nama_saudara_kerja'];
            $jabatan_saudara_kerja = $data['jabatan_saudara_kerja'];
            $pengalaman_jababeka = $data['pengalaman_jababeka'];
            $kerja_jababeka = $data['kerja_jababeka'];
            $bidang_pekerjaan = $data['bidang_pekerjaan'];
            $riwayat_kecelakaan = $data['riwayat_kecelakaan'];
            $kecelakaan = $data['kecelakaan'];
            $riwayat_kriminal = $data['riwayat_kriminal'];
            $kriminal = $data['kriminal'];
            $waktu_luang = $data['waktu_luang'];
            $kerja_sampingan = $data['kerja_sampingan'];
            $sampingan = $data['sampingan'];
            $pengalaman_organisasi = $data['pengalaman_organisasi'];
            $organisasi = $data['organisasi'];
            $nama_ref_1 = $data['nama_ref_1'];
            $nama_ref_2 = $data['nama_ref_2'];
            $nama_ref_3 = $data['nama_ref_3'];
            $alamat_ref_1 = $data['alamat_ref_1'];
            $alamat_ref_2 = $data['alamat_ref_2'];
            $alamat_ref_3 = $data['alamat_ref_3'];
            $tlp_ref_1 = $data['tlp_ref_1'];
            $tlp_ref_2 = $data['tlp_ref_2'];
            $tlp_ref_3 = $data['tlp_ref_3'];
            $jabatan_ref_1 = $data['jabatan_ref_1'];
            $jabatan_ref_2 = $data['jabatan_ref_2'];
            $jabatan_ref_3 = $data['jabatan_ref_3'];

            $foto = $data['foto'];
            $referensi_kerja = $data['referensi_kerja'];
            $fc_ijazah = $data['fc_ijazah'];
            $bpjs_ks = $data['bpjs_ks'];
            $fc_tn = $data['fc_tn'];
            $bpjs_kg = $data['bpjs_kg'];
            $fc_bt = $data['fc_bt'];
            $bpjs_jp = $data['bpjs_jp'];
            $fc_npwp = $data['fc_npwp'];
            $foto_ktp = $data['foto_ktp'];
            $fc_kk = $data['fc_kk'];
            $fc_sp = $data['fc_sp'];

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
<?php
// Ambil nilai KodeFPK dari URL jika tersedia
$kodeFPK = isset($_GET['KodeFPK']) ? htmlspecialchars($_GET['KodeFPK']) : null;

// Gunakan nilai KodeFPK jika tersedia
if ($kodeFPK !== null) {
    // Lakukan sesuatu dengan nilai KodeFPK yang sudah diperoleh
    // echo "Nilai KodeFPK: " . $kodeFPK;
} else {
    // Tindakan yang harus diambil jika nilai KodeFPK tidak tersedia
    echo "Nilai KodeFPK tidak tersedia dalam URL.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Karyawan Baru</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <script>
        function openTab(evt, tabName) {
            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Set default tab open
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("defaultOpen").click();
        });
    </script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #EAFAF1;
            margin: 0;
            padding: 0;
        }

        h1,
        h3,
        h4 {
            color: #333;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            margin-top: -30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .tab {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .tab button {
            background-color: #f1f1f1;
            border: none;
            outline: none;
            padding: 14px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
            flex: 1;
            text-align: center;
        }

        .tab button:hover {
            background-color: #ddd;
        }

        .tab button.active {
            background-color: #ccc;
        }

        .tabcontent {
            display: none;
            padding: 20px;
            border-top: none;
        }

        .tabcontent.active {
            display: block;
        }

        form {
            max-width: 800px;
            margin: 0 auto;
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

        /* tr:hover {
            background-color: #f1f1f1;
        } */

        .foto-box {
            width: 3cm;
            height: 3cm;
            border: 1px solid #000;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
            text-align: center;
        }

        .foto-input {
            width: 100%;
            height: 100%;
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            cursor: pointer;
        }

        .foto-label {
            pointer-events: none;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 4px;
            margin: 10px;
            padding: 10px;
            width: 45%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card img {
            width: 100%;
            height: auto;
            display: block;
            margin-bottom: 10px;
        }

        .card h4 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            border: 1px solid #000;
            padding: 10px;
        }

        .form-table td {
            border: 1px solid #000;
        }

        .foto-box img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            /* Tidak ada scroll */
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 100%;
            /* Lebar maksimum */
            max-height: 100%;
            /* Tinggi maksimum */
            background-color: #fefefe;
            border: 1px solid #888;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2),
                0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .modal-content img {
            width: 100%;
            height: auto;
            object-fit: contain;
            /* Menyesuaikan gambar dengan ukuran maksimum */
        }

        .close {
            position: absolute;
            top: 0px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <a href="detail_applicants.php?id=<?php echo $userId; ?>&branches=<?php echo $branches; ?>&posisi=<?php echo $posisi; ?>&KodeFPK=<?php echo $kodeFPK; ?>" class="top-left-button">
        <img src="../img/left-arrow.png " alt="" style="width: 40px; height: 40px; margin: 15px 15px;">
    </a>
    <div class="container">
        <h1>Biodata Karyawan</h1>

        <div class="tab">
            <button class="tablinks" id="defaultOpen" onclick="openTab(event, 'info')">Info</button>
            <button class="tablinks" id="defaultOpen-file" onclick="openTab(event, 'files')">Files</button>
            <button class="tablinks" onclick="openTab(event, 'notes')">Notes</button>
        </div>

        <div id="info" class="tabcontent">
            <form action="proses_simpan.php" method="post" enctype="multipart/form-data">
                <div class="section">
                    <h3>I. Data Pribadi</h3>
                    <table class="form-table" style="margin-top: -18px;">
                        <tr style="display: none;">
                            <td>ID Biodata:</td>
                            <td><input type="text" name="id_biodata" value="<?php echo $id_biodata ?? ''; ?>" readonly></td>
                        </tr>
                        <tr>
                            <td rowspan="2">
                                <!-- Modal -->
                                <div id="modalFoto" class="modal">
                                    <span class="close">&times;</span>
                                    <img class="modal-content" id="img01">
                                </div>

                                <!-- Foto Box -->
                                <div class="foto-box">
                                    <?php if (!empty($foto)) : ?>
                                        <img id="foto-preview" src="./uploads/<?php echo $foto; ?>" alt="Foto" style="display: block; width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="openModal(this);">
                                    <?php else : ?>
                                        <img id="foto-preview" src="#" alt="Foto Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                    <?php endif; ?>
                                </div>

                                <!-- Script untuk Modal -->
                                <script>
                                    // Fungsi untuk membuka modal
                                    function openModal(imgElement) {
                                        var modal = document.getElementById("modalFoto");
                                        var modalImg = document.getElementById("img01");

                                        modal.style.display = "block";
                                        modalImg.src = imgElement.src;
                                    }

                                    // Fungsi untuk menutup modal
                                    var close = document.getElementsByClassName("close")[0];
                                    close.onclick = function() {
                                        var modal = document.getElementById("modalFoto");
                                        modal.style.display = "none";
                                    }
                                </script>

                                <!-- CSS untuk Modal -->
                                <style>
                                    /* Style untuk modal */
                                    .modal {
                                        display: none;
                                        position: fixed;
                                        z-index: 1;
                                        padding-top: 50px;
                                        left: 0;
                                        top: 0;
                                        width: 100%;
                                        height: 100%;
                                        overflow: hidden;
                                        /* Tidak ada scroll */
                                        background-color: rgba(0, 0, 0, 0.9);
                                    }

                                    .modal-content {
                                        margin: auto;
                                        display: block;
                                        max-width: 100%;
                                        /* Lebar maksimum */
                                        max-height: 100%;
                                        /* margin-top: -50px; */
                                        /* Tinggi maksimum */
                                        background-color: #fefefe;
                                        border: 1px solid #888;
                                        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                                    }

                                    .modal-content img {
                                        width: 100%;
                                        height: auto;
                                        object-fit: contain;
                                        /* Menyesuaikan gambar dengan ukuran maksimum */
                                    }

                                    .close {
                                        position: absolute;
                                        top: 0px;
                                        right: 35px;
                                        color: #f1f1f1;
                                        font-size: 40px;
                                        font-weight: bold;
                                        transition: 0.3s;
                                    }

                                    .close:hover,
                                    .close:focus {
                                        color: #bbb;
                                        text-decoration: none;
                                        cursor: pointer;
                                    }
                                </style>


                            </td>
                            <td colspan="2" style="width: 100%;">
                                Posisi Pekerjaan
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="posisi" style="width: 100%;" value="<?php echo $posisi ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <br>
                        <tr>
                            <td>Nama Lengkap:</td>
                            <td colspan="2" style="padding-top: 15px; padding-bottom: 14px;">
                                <input type="text" name="nama_lengkap" value="<?php echo $nama_lengkap ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Panggilan:</td>
                            <td colspan="2" style="padding-top: 15px; padding-bottom: 14px;">
                                <input type="text" name="nama_panggilan" value="<?php echo $nama_panggilan ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin:</td>
                            <td colspan="2" style="padding-top: 15px; padding-bottom: 14px;">
                                <input type="text" name="jenis_kelamin" value="<?php echo $jenis_kelamin ?? ''; ?>" readonly>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- DATA PRIBADI -->
                <div class="section" style="margin-top: 60px;">
                    <table class="form-table">
                        <tr>
                            <td>Golongan Darah:</td>
                            <td>
                                <input type="text" name="golongan_darah" value="<?php echo $golongan_darah ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Tempat Lahir:</td>
                            <td><input type="text" name="tempat_lahir" value="<?php echo $tm_lahir ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir:</td>
                            <td><input type="date" name="tanggal_lahir" value="<?php echo $tanggal_lahir ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>No. KTP:</td>
                            <td><input type="text" name="no_ktp" maxlength="16" value="<?php echo $no_ktp ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Nomor NPWP:</td>
                            <td><input type="text" name="no_npwp" value="<?php echo $no_npwp ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Kewarganegaraan:</td>
                            <td><input type="text" name="kewarganegaraan" value="<?php echo $kewarganegaraan ?? ''; ?>" readonly>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- ALAMAT KTP -->
                <div class="full-width" style="margin-top: -40px;">
                    <h4>Alamat KTP</h4>
                    <table class="form-table">
                        <tr>
                            <td>Agama:</td>
                            <td>
                                <input type="text" name="agama" value="<?php echo $agama ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>No. Telepon Rumah:</td>
                            <td>
                                <input type="text" name="no_tlpn_rumah" value="<?php echo $no_tlpn_rumah ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>No. Telepon Seluler:</td>
                            <td>
                                <input type="text" name="no_tlpn" value="<?php echo $no_tlpn ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>
                                <input type="email" name="email" value="<?php echo $email ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td colspan="2"><input type="submit" value="Simpan"></td>
                        </tr> -->
                    </table>
                </div>
                <div class="section" style="margin-top: 20px;">
                    <table class="form-table">
                        <tr>
                            <td>Kecamatan:</td>
                            <td>
                                <input type="text" name="kecamatan" value="<?php echo $kecamatan ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Kabupaten:</td>
                            <td><input type="text" name="kota" value="<?php echo $kota ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Provinsi:</td>
                            <td><input type="text" name="provinsi" value="<?php echo $provinsi ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Kode Pos:</td>
                            <td><input type="text" name="kode_pos" maxlength="16" value="<?php echo $kode_pos ?? ''; ?>" readonly>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- ALAMAT SEKARANG -->
                <div class="full-width" style="margin-top: -20px;">
                    <table>
                        <tr>
                            <td style="width: 100px;">Alamat Sekarang:</td>
                            <td style="width: 700px;"><input style="width: 100%;" type="text" name="alamat_domisili" maxlength="20" value="<?php echo $alamat_domisili ?? ''; ?>" readonly>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- KONTAK DARURAT -->
                <div class="full-width" style="margin-top: -20px;">
                    <table class="form-table">
                        <tr>
                            <td>Nama:</td>
                            <td>
                                <input type="text" name="nama_kd" value="<?php echo $nama_kd ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>No. Telepon:</td>
                            <td>
                                <input type="text" name="no_tlpn_kd" value="<?php echo $no_tlpn_kd ?? ''; ?>" readonly>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="section" style="margin-top: -20px;">
                    <table class="form-table">
                        <tr>
                            <td>Hubungan:</td>
                            <td>
                                <input type="text" name="hubungan_kd" value="<?php echo $hubungan_kd ?? ''; ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat:</td>
                            <td><input type="text" name="alamat_kd" value="<?php echo $alamat_kd ?? ''; ?>" readonly>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- STATUS PRIBADI -->
                <div class="full-width" style="margin-top: -20px;">
                    <table>
                        <tr>
                            <td style="width: 100px;">Status Pribadi:</td>
                            <td style="width:700px;">
                                <input style="width: 100%;" type="text" name="status" maxlength="20" value="<?php echo $status ?? ''; ?>" readonly>
                            </td>
                        </tr>
                    </table>
                </div>

                <h3 style="margin-top: -10px;">II. Data Keluarga</h3>
                <!-- SUAMI DAN ISTRI -->
                <div class="full-width" style="margin-top: -50px;">
                    <h4 style="margin-bottom: 10px;">Susunan Keluarga (Suami/Istri/Anak)</h4>
                    <table class="form-table" style="width: 795px;">
                        <thead>
                            <tr style="background-color: #9ACD32; color: white;">
                                <td>Status Keluarga</td>
                                <td>Nama</td>
                                <td>Jenis Kelamin</td>
                                <td>Tempat Lahir</td>
                                <td>Tanggal Lahir</td>
                                <td>Pekerjaan</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type=" text" name="status_keluarga" value="Suami" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_suami" value="<?php echo htmlspecialchars($nama_suami); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jenis_kelamin" value="Laki-laki" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tempat_lahir_suami" value="<?php echo htmlspecialchars($tempat_lahir_suami); ?>" readonly>
                                </td>
                                <td>
                                    <input type="date" name="tanggal_lahir_suami" value="<?php echo htmlspecialchars($tanggal_lahir_suami); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="pekerjaan_suami" value="<?php echo htmlspecialchars($pekerjaan_suami); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="status_keluarga" value="Istri" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_istri" value="<?php echo htmlspecialchars($nama_istri); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jenis_kelamin" value="Perempuan" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tempat_lahir_istri" value="<?php echo htmlspecialchars($tempat_lahir_istri); ?>" readonly>
                                </td>
                                <td>
                                    <input type="date" name="tanggal_lahir_istri" value="<?php echo htmlspecialchars($tanggal_lahir_istri); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="pekerjaan_istri" value="<?php echo htmlspecialchars($pekerjaan_istri); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="status_keluarga" value="Anak anak_1" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_anak_1" value="<?php echo htmlspecialchars($nama_anak_1); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jk_anak_1" value="<?php echo htmlspecialchars($jk_anak_1); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tempat_lahir_anak_1" value="<?php echo htmlspecialchars($tempat_lahir_anak_1); ?>" readonly>
                                </td>
                                <td>
                                    <input type="date" name="tanggal_lahir_anak_1" value="<?php echo htmlspecialchars($tanggal_lahir_anak_1); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="pekerjaan_anak_1" value="<?php echo htmlspecialchars($pekerjaan_anak_1); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="status_keluarga" value="Anak anak_2" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_anak_2" value="<?php echo htmlspecialchars($nama_anak_2); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jk_anak_2" value="<?php echo htmlspecialchars($jk_anak_2); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tempat_lahir_anak_2" value="<?php echo htmlspecialchars($tempat_lahir_anak_2); ?>" readonly>
                                </td>
                                <td>
                                    <input type="date" name="tanggal_lahir_anak_2" value="<?php echo htmlspecialchars($tanggal_lahir_anak_2); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="pekerjaan_anak_2" value="<?php echo htmlspecialchars($pekerjaan_anak_2); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="status_keluarga" value="Anak anak_3" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_anak_3" value="<?php echo htmlspecialchars($nama_anak_3); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jk_anak_3" value="<?php echo htmlspecialchars($jk_anak_3); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tempat_lahir_anak_3" value="<?php echo htmlspecialchars($tempat_lahir_anak_3); ?>" readonly>
                                </td>
                                <td>
                                    <input type="date" name="tanggal_lahir_anak_3" value="<?php echo htmlspecialchars($tanggal_lahir_anak_3); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="pekerjaan_anak_3" value="<?php echo htmlspecialchars($pekerjaan_anak_3); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="status_keluarga" value="Anak anak_4" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_anak_4" value="<?php echo htmlspecialchars($nama_anak_4); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jk_anak_4" value="<?php echo htmlspecialchars($jk_anak_4); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tempat_lahir_anak_4" value="<?php echo htmlspecialchars($tempat_lahir_anak_4); ?>" readonly>
                                </td>
                                <td>
                                    <input type="date" name="tanggal_lahir_anak_4" value="<?php echo htmlspecialchars($tanggal_lahir_anak_4); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="pekerjaan_anak_4" value="<?php echo htmlspecialchars($pekerjaan_anak_4); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="status_keluarga" value="Anak anak_5" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_anak_5" value="<?php echo htmlspecialchars($nama_anak_5); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jk_anak_5" value="<?php echo htmlspecialchars($jk_anak_5); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tempat_lahir_anak_5" value="<?php echo htmlspecialchars($tempat_lahir_anak_5); ?>" readonly>
                                </td>
                                <td>
                                    <input type="date" name="tanggal_lahir_anak_5" value="<?php echo htmlspecialchars($tanggal_lahir_anak_5); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="pekerjaan_anak_5" value="<?php echo htmlspecialchars($pekerjaan_anak_5); ?>" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- AYAH dan IBU -->
                <div class="full-width" style="margin-top: -30px;">
                    <h4 style="margin-bottom: 10px;">Susunan Keluarga (Ayah/Ibu/Saudara kandung)</h4>
                    <table class="form-table" style="width: 795px;">
                        <thead>
                            <tr style="background-color: #9ACD32; color: white;">
                                <td>Status Keluarga</td>
                                <td>Nama</td>
                                <td>Jenis Kelamin</td>
                                <td>Tempat Lahir</td>
                                <td>Tanggal Lahir</td>
                                <td>Pekerjaan</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" name="status_keluarga" value="Ayah" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_ayah" value="<?php echo htmlspecialchars($nama_ayah); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jenis_kelamin" value="Laki-laki" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tempat_lahir_ayah" value="<?php echo htmlspecialchars($tempat_lahir_ayah); ?>" readonly>
                                </td>
                                <td>
                                    <input type="date" name="tanggal_lahir_ayah" value="<?php echo htmlspecialchars($tanggal_lahir_ayah); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="pekerjaan_ayah" value="<?php echo htmlspecialchars($pekerjaan_ayah); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="status_keluarga" value="Ibu" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_ibu" value="<?php echo htmlspecialchars($nama_ibu); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jenis_kelamin" value="Perempuan" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tempat_lahir_ibu" value="<?php echo htmlspecialchars($tempat_lahir_ibu); ?>" readonly>
                                </td>
                                <td>
                                    <input type="date" name="tanggal_lahir_ibu" value="<?php echo htmlspecialchars($tanggal_lahir_ibu); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="pekerjaan_ibu" value="<?php echo htmlspecialchars($pekerjaan_ibu); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="status_keluarga" value="Anak Pertama" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_pertama" value="<?php echo htmlspecialchars($nama_pertama); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jk_pertama" value="<?php echo htmlspecialchars($jk_pertama); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tempat_lahir_pertama" value="<?php echo htmlspecialchars($tempat_lahir_pertama); ?>" readonly>
                                </td>
                                <td>
                                    <input type="date" name="tanggal_lahir_pertama" value="<?php echo htmlspecialchars($tanggal_lahir_pertama); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="pekerjaan_pertama" value="<?php echo htmlspecialchars($pekerjaan_pertama); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="status_keluarga" value="Anak kedua" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_kedua" value="<?php echo htmlspecialchars($nama_kedua); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jk_kedua" value="<?php echo htmlspecialchars($jk_kedua); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tempat_lahir_kedua" value="<?php echo htmlspecialchars($tempat_lahir_kedua); ?>" readonly>
                                </td>
                                <td>
                                    <input type="date" name="tanggal_lahir_kedua" value="<?php echo htmlspecialchars($tanggal_lahir_kedua); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="pekerjaan_kedua" value="<?php echo htmlspecialchars($pekerjaan_kedua); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="status_keluarga" value="Anak ketiga" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_ketiga" value="<?php echo htmlspecialchars($nama_ketiga); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jk_ketiga" value="<?php echo htmlspecialchars($jk_ketiga); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tempat_lahir_ketiga" value="<?php echo htmlspecialchars($tempat_lahir_ketiga); ?>" readonly>
                                </td>
                                <td>
                                    <input type="date" name="tanggal_lahir_ketiga" value="<?php echo htmlspecialchars($tanggal_lahir_ketiga); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="pekerjaan_ketiga" value="<?php echo htmlspecialchars($pekerjaan_ketiga); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="status_keluarga" value="Anak keempat" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_keempat" value="<?php echo htmlspecialchars($nama_keempat); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jk_keempat" value="<?php echo htmlspecialchars($jk_keempat); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tempat_lahir_keempat" value="<?php echo htmlspecialchars($tempat_lahir_keempat); ?>" readonly>
                                </td>
                                <td>
                                    <input type="date" name="tanggal_lahir_keempat" value="<?php echo htmlspecialchars($tanggal_lahir_keempat); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="pekerjaan_keempat" value="<?php echo htmlspecialchars($pekerjaan_keempat); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="status_keluarga" value="Anak kelima" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_kelima" value="<?php echo htmlspecialchars($nama_kelima); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jk_kelima" value="<?php echo htmlspecialchars($jk_kelima); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tempat_lahir_kelima" value="<?php echo htmlspecialchars($tempat_lahir_kelima); ?>" readonly>
                                </td>
                                <td>
                                    <input type="date" name="tanggal_lahir_kelima" value="<?php echo htmlspecialchars($tanggal_lahir_kelima); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="pekerjaan_kelima" value="<?php echo htmlspecialchars($pekerjaan_kelima); ?>" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 style="margin-top: -10px; margin-bottom: -20px;">III. Riwayat Pendidikan</h3>
                <!-- RIWAYAT PENDIDIKAN -->
                <div class="full-width">
                    <table class="form-table" style="width: 795px;">
                        <thead>
                            <tr style="background-color: #9ACD32; color: white;">
                                <td>Jenjang Pendidikan</td>
                                <td>Nama Institusi</td>
                                <td>Fakultas/Jurusan</td>
                                <td style="width: 95px;">Periode Tahun</td>
                                <td>Keterangan</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" name="nama_institusi_s3" value="Strata 3" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_institusi_s3" value="<?php echo htmlspecialchars($nama_institusi_s3); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_fakultas_s3" value="<?php echo htmlspecialchars($nama_fakultas_s3); ?>" readonly>
                                </td>
                                <td>
                                    <input id="tahun_awal_s3" name="tahun_awal_s3" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_awal_s3); ?>">
                                    <span style="font-size: 20px;"> - </span>
                                    <input id="tahun_akhir_s3" name="tahun_akhir_s3" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_akhir_s3); ?>">
                                </td>
                                <td>
                                    <input type="text" name="keterangan_s3" value="<?php echo htmlspecialchars($keterangan_s3); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="nama_institusi_s2" value="Strata 2" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_institusi_s2" value="<?php echo htmlspecialchars($nama_institusi_s2); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_fakultas_s2" value="<?php echo htmlspecialchars($nama_fakultas_s2); ?>" readonly>
                                </td>
                                <td>
                                    <input id="tahun_awal_s2" name="tahun_awal_s2" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_awal_s2); ?>">
                                    <span style="font-size: 20px;"> - </span>
                                    <input id="tahun_akhir_s2" name="tahun_akhir_s2" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_akhir_s2); ?>">
                                </td>
                                <td>
                                    <input type="text" name="keterangan_s2" value="<?php echo htmlspecialchars($keterangan_s2); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="nama_institusi_s3" value="Strata 1 / Diploma 4" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_institusi_s1" value="<?php echo htmlspecialchars($nama_institusi_s1); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_fakultas_s1" value="<?php echo htmlspecialchars($nama_fakultas_s1); ?>" readonly>
                                </td>
                                <td>
                                    <input id="tahun_awal_s1" name="tahun_awal_s1" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_awal_s1); ?>">
                                    <span style="font-size: 20px;"> - </span>
                                    <input id="tahun_akhir_s1" name="tahun_akhir_s1" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_akhir_s1); ?>">
                                </td>
                                <td>
                                    <input type="text" name="keterangan_s1" value="<?php echo htmlspecialchars($keterangan_s1); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="nama_institusi_s3" value="Diploma 1/2/3" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_institusi_diploma" value="<?php echo htmlspecialchars($nama_institusi_diploma); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_fakultas_diploma" value="<?php echo htmlspecialchars($nama_fakultas_diploma); ?>" readonly>
                                </td>
                                <td>
                                    <input id="tahun_awal_diploma" name="tahun_awal_diploma" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_awal_diploma); ?>">
                                    <span style="font-size: 20px;"> - </span>
                                    <input id="tahun_akhir_diploma" name="tahun_akhir_diploma" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_akhir_diploma); ?>">
                                </td>
                                <td>
                                    <input type="text" name="keterangan_diploma" value="<?php echo htmlspecialchars($keterangan_diploma); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="nama_institusi_s3" value="SMP" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_institusi_sma" value="<?php echo htmlspecialchars($nama_institusi_sma); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_fakultas_sma" value="<?php echo htmlspecialchars($nama_fakultas_sma); ?>" readonly>
                                </td>
                                <td>
                                    <input id="tahun_awal_sma" name="tahun_awal_sma" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_awal_sma); ?>">
                                    <span style="font-size: 20px;"> - </span>
                                    <input id="tahun_akhir_sma" name="tahun_akhir_sma" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_akhir_sma); ?>">
                                </td>
                                <td>
                                    <input type="text" name="keterangan_sma" value="<?php echo htmlspecialchars($keterangan_sma); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="nama_institusi_s3" value="SMP" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_institusi_smp" value="<?php echo htmlspecialchars($nama_institusi_smp); ?>" readonly>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <input id="tahun_awal_smp" name="tahun_awal_smp" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_awal_smp); ?>">
                                    <span style="font-size: 20px;"> - </span>
                                    <input id="tahun_akhir_smp" name="tahun_akhir_smp" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_akhir_smp); ?>">
                                </td>
                                <td>
                                    <input type="text" name="keterangan_sd" value="<?php echo htmlspecialchars($keterangan_smp); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="nama_institusi_s3" value="SD" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_institusi_sd" value="<?php echo htmlspecialchars($nama_institusi_sd); ?>" readonly>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <input id="tahun_awal_sd" name="tahun_awal_sd" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_awal_sd); ?>">
                                    <span style="font-size: 20px;"> - </span>
                                    <input id="tahun_akhir_sd" name="tahun_akhir_sd" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_akhir_sd); ?>">
                                </td>
                                <td>
                                    <input type="text" name="keterangan_sd" value="<?php echo htmlspecialchars($keterangan_sd); ?>" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- BEASISWA -->
                <div class="full-width" style="margin-top: -30px;">
                    <h4 style="margin-top: 5px; margin-bottom: 10px;">Beasiswa/Piagam/Penghargaan</h4>
                    <table>
                        <tr>
                            <td style=" width: 100px;">Beasiswa:</td>
                            <td style="width: 700px;"><input style="width: 100%;" type="text" name="beasiswa" maxlength="20" value="<?php echo $beasiswa ?? ''; ?>" readonly>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- PENGHARGAAN -->
                <div class="full-width" style="margin-top: -20px; margin-bottom: 10px;">
                    <table>
                        <tr>
                            <td style="width: 100px;">Penghargaan:</td>
                            <td style="width: 700px;"><input style="width: 100%;" type="text" name="penghargaan" maxlength="20" value="<?php echo $penghargaan ?? ''; ?>" readonly>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- PELATIHAN -->
                <div class="full-width">
                    <h4 style="margin-top: -30px; margin-bottom: 10px;">Kursus/Pelatihan yang pernah diikuti (yang bersertifikat)</h4>
                    <table class="form-table" style="width: 795px;">
                        <thead>
                            <tr style="background-color: #9ACD32; color: white;">
                                <td>Kursus / Pelatihan</td>
                                <td>Nama Institusi</td>
                                <td>Lama Kursus / Pelatihan</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" name="kursus_pelatihan_1" value="<?php echo htmlspecialchars($kursus_pelatihan_1); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_institusi_1" value="<?php echo htmlspecialchars($nama_institusi_1); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="lama_pelatihan_1" value="<?php echo htmlspecialchars($lama_pelatihan_1); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="kursus_pelatihan_2" value="<?php echo htmlspecialchars($kursus_pelatihan_2); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_institusi_2" value="<?php echo htmlspecialchars($nama_institusi_2); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="lama_pelatihan_2" value="<?php echo htmlspecialchars($lama_pelatihan_2); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="kursus_pelatihan_3" value="<?php echo htmlspecialchars($kursus_pelatihan_3); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_institusi_3" value="<?php echo htmlspecialchars($nama_institusi_3); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="lama_pelatihan_3" value="<?php echo htmlspecialchars($lama_pelatihan_3); ?>" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <!-- KEMAMPUAN BAHASA -->
                <div class="full-width">
                    <h3 style="margin-top: -10px; margin-bottom: 10px;">IV. Kemampuan bahasa</h3>
                    <table class="form-table" style="width: 795px;">
                        <thead>
                            <tr style="background-color: #9ACD32; color: white;">
                                <td>Kemampuan Bahasa</td>
                                <td>Lisan</td>
                                <td>Tulisan</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" name="bahasa_1" value="<?php echo htmlspecialchars($bahasa_1); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="lisan_1" value="<?php echo htmlspecialchars($lisan_1); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tulisan_1" value="<?php echo htmlspecialchars($tulisan_1); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="bahasa_2" value="<?php echo htmlspecialchars($bahasa_2); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="lisan_2" value="<?php echo htmlspecialchars($lisan_2); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tulisan_2" value="<?php echo htmlspecialchars($tulisan_2); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="bahasa_3" value="<?php echo htmlspecialchars($bahasa_3); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="lisan_3" value="<?php echo htmlspecialchars($lisan_3); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tulisan_3" value="<?php echo htmlspecialchars($tulisan_3); ?>" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- RIWAYAT PEKERJAAN -->
                <div class="full-width">
                    <h3 style="margin-top: -10px; margin-bottom: 10px;">V. Riwayat Pekerjaan</h3>
                    <table class="form-table" style="width: 795px;">
                        <thead>
                            <tr style="background-color: #9ACD32; color: white;">
                                <td style="width: 95px;">Periode Tahun</td>
                                <td>Nama / Alamat Perusahaan</td>
                                <td>Jabatan</td>
                                <td>Gaji Tunjangan</td>
                                <td>Alasan Keluar / Pindah Kerja</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input id="tahun_awal_1" name="tahun_awal_1" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_awal_1); ?>">
                                    <span style="font-size: 20px;"> - </span>
                                    <input id="tahun_akhir_1" name="tahun_akhir_1" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_akhir_1); ?>">
                                </td>
                                <td>
                                    <input type="text" name="nama_perusahaan_1" value="<?php echo htmlspecialchars($nama_perusahaan_1); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jabatan_1" value="<?php echo htmlspecialchars($jabatan_1); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="gaji_1" value="<?php echo htmlspecialchars($gaji_1); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="alasan_keluar_1" value="<?php echo htmlspecialchars($alasan_keluar_1); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input id="tahun_awal_2" name="tahun_awal_2" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_awal_2); ?>">
                                    <span style="font-size: 20px;"> - </span>
                                    <input id="tahun_akhir_2" name="tahun_akhir_2" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_akhir_2); ?>">
                                </td>
                                <td>
                                    <input type="text" name="nama_perusahaan_2" value="<?php echo htmlspecialchars($nama_perusahaan_2); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jabatan_2" value="<?php echo htmlspecialchars($jabatan_2); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="gaji_2" value="<?php echo htmlspecialchars($gaji_2); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="alasan_keluar_2" value="<?php echo htmlspecialchars($alasan_keluar_2); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input id="tahun_awal_3" name="tahun_awal_3" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_awal_3); ?>">
                                    <span style="font-size: 20px;"> - </span>
                                    <input id="tahun_akhir_3" name="tahun_akhir_3" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_akhir_3); ?>">
                                </td>
                                <td>
                                    <input type="text" name="nama_perusahaan_3" value="<?php echo htmlspecialchars($nama_perusahaan_3); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jabatan_3" value="<?php echo htmlspecialchars($jabatan_3); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="gaji_3" value="<?php echo htmlspecialchars($gaji_3); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="alasan_keluar_3" value="<?php echo htmlspecialchars($alasan_keluar_3); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input id="tahun_awal_4" name="tahun_awal_4" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_awal_4); ?>">
                                    <span style="font-size: 20px;"> - </span>
                                    <input id="tahun_akhir_4" name="tahun_akhir_4" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_akhir_4); ?>">
                                </td>
                                <td>
                                    <input type="text" name="nama_perusahaan_4" value="<?php echo htmlspecialchars($nama_perusahaan_4); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jabatan_4" value="<?php echo htmlspecialchars($jabatan_4); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="gaji_4" value="<?php echo htmlspecialchars($gaji_4); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="alasan_keluar_4" value="<?php echo htmlspecialchars($alasan_keluar_4); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input id="tahun_awal_5" name="tahun_awal_5" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_awal_5); ?>">
                                    <span style="font-size: 20px;"> - </span>
                                    <input id="tahun_akhir_5" name="tahun_akhir_5" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_akhir_5); ?>">
                                </td>
                                <td>
                                    <input type="text" name="nama_perusahaan_5" value="<?php echo htmlspecialchars($nama_perusahaan_5); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jabatan_5" value="<?php echo htmlspecialchars($jabatan_5); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="gaji_5" value="<?php echo htmlspecialchars($gaji_5); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="alasan_keluar_5" value="<?php echo htmlspecialchars($alasan_keluar_5); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input id="tahun_awal_6" name="tahun_awal_6" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_awal_6); ?>">
                                    <span style="font-size: 20px;"> - </span>
                                    <input id="tahun_akhir_6" name="tahun_akhir_6" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_akhir_6); ?>">
                                </td>
                                <td>
                                    <input type="text" name="nama_perusahaan_6" value="<?php echo htmlspecialchars($nama_perusahaan_6); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jabatan_6" value="<?php echo htmlspecialchars($jabatan_6); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="gaji_6" value="<?php echo htmlspecialchars($gaji_6); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="alasan_keluar_6" value="<?php echo htmlspecialchars($alasan_keluar_6); ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input id="tahun_awal_7" name="tahun_awal_7" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_awal_7); ?>">
                                    <span style="font-size: 20px;"> - </span>
                                    <input id="tahun_akhir_7" name="tahun_akhir_7" style="width: 30px;" value="<?php echo htmlspecialchars($tahun_akhir_7); ?>">
                                </td>
                                <td>
                                    <input type="text" name="nama_perusahaan_7" value="<?php echo htmlspecialchars($nama_perusahaan_7); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jabatan_7" value="<?php echo htmlspecialchars($jabatan_7); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="gaji_7" value="<?php echo htmlspecialchars($gaji_7); ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="alasan_keluar_7" value="<?php echo htmlspecialchars($alasan_keluar_7); ?>" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- SAUDARA JABABEKA -->
                <div class="full-width">
                    <h3 style="margin-top: -10px; margin-bottom: 10px;">VI. Lain-lain</h3>
                    <table style="width: 795px;">
                        <tr>
                            <td style="width: 100px;">Keluarga yang Kerja di Jababeka:</td>
                            <td><input style="width: 100%; margin-bottom:10px;" type="text" name="saudara_kerja" maxlength="20" value="<?php echo $saudara_kerja ?? ''; ?>" readonly>
                                <label for="ada_saudara">nama
                                    <input type="text" style="width: 41%;" id="nama_saudara_kerja" name="nama_saudara_kerja" value="<?php echo $nama_saudara_kerja ?? ''; ?>" readonly> jabatan
                                    <input type="text" style="width: 42.5%;" id="jabatan_saudara_kerja" name="jabatan_saudara_kerja" value="<?php echo $jabatan_saudara_kerja ?? ''; ?>" readonly>
                                </label>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- pengalaman kerja di jababeka -->
                <div class="full-width">
                    <table style="margin-top: -20px; margin-bottom: 0px;">
                        <tr>
                            <td style=" width: 100px;">Riwayat Kerja di Jababeka:</td>
                            <td style=" width: 700px;"><input style="width: 100%; margin-bottom:10px;" type="text" name="pengalaman_jababeka" maxlength="20" value="<?php echo $pengalaman_jababeka ?? ''; ?>" readonly>
                                <label for="ada_saudara">
                                    <textarea type="text" style="width: 99%;" id="pengalaman_jababeka" name="pengalaman_jababeka" readonly><?php echo $kerja_jababeka ?? ''; ?></textarea>
                                </label>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Bidang pekerjaan diminati -->
                <div class="full-width">
                    <table style="margin-bottom: 0px;">
                        <tr>
                            <td style=" width: 100px;">Minat Bidang Pekerjaan:</td>
                            <td style=" width: 700px;">
                                <textarea style="width: 99%; height: 50px;" type="text" name="bidang_pekerjaan" maxlength="20" readonly><?php echo $bidang_pekerjaan ?? ''; ?>
                        </textarea>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- riwayat penyakit -->
                <div class="full-width">
                    <table style="margin-bottom: 0px;">
                        <tr>
                            <td style=" width: 100px;">Riwayat kecelakaan, sakit keras mental:</td>
                            <td style=" width: 700px;">
                                <input style="width: 100%; margin-bottom:10px;" type="text" name="riwayat_kecelakaan" maxlength="20" value="<?php echo $riwayat_kecelakaan ?? ''; ?>" readonly>
                                <label for="ada_saudara">
                                    <textarea type="text" style="width: 99%;" id="kecelakaan" name="kecelakaan" readonly><?php echo $kecelakaan ?? ''; ?></textarea>
                                </label>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- riwayat kriminal -->
                <div class="full-width">
                    <table style="margin-bottom: 0px;">
                        <tr>
                            <td style=" width: 100px;">Riwayat tindak kriminal:</td>
                            <td style=" width: 700px;">
                                <input style="width: 100%; margin-bottom:10px;" type="text" id="riwayat_kriminal" name="riwayat_kriminal" maxlength="20" value="<?php echo $riwayat_kriminal ?? ''; ?>" readonly>
                                <label for="ada_saudara">
                                    <textarea type="text" style="width: 99%;" id="kriminal" name="kriminal" value="<?php echo $kriminal ?? ''; ?>" readonly></textarea>
                                </label>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- WAKTU LUANG -->
                <div class="full-width">
                    <table style="margin-bottom: 0px;">
                        <tr>
                            <td style=" width: 100px;">Waktu luang:</td>
                            <td style=" width: 700px;">
                                <textarea style=" width: 99%; height: 50px;" type="text" name="waktu_luang" maxlength="20" readonly><?php echo $waktu_luang ?? ''; ?>
                        </textarea>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- SAMPINGAN -->
                <div class="full-width">
                    <table style="margin-bottom: 0px;">
                        <tr>
                            <td style="width: 100px;">Sumber pendapatan lain:</td>
                            <td style="width: 700px;">
                                <input style="width: 100%; margin-bottom:10px;" type="text" name="kerja_sampingan" maxlength="20" value="<?php echo $riwayat_kriminal ?? ''; ?>" readonly>
                                <label for="ada_saudara">
                                    <textarea type="text" style="width: 99%;" id="sampingan" name="sampingan" readonly><?php echo $kriminal ?? ''; ?></textarea>
                                </label>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- SAMPINGAN -->
                <div class="full-width">
                    <table style="margin-bottom: 0px;">
                        <tr>
                            <td style="width: 100px;">Pengurus anggota organisasi:</td>
                            <td style="width: 700px;">
                                <input style="width: 100%; margin-bottom:10px;" type="text" name="pengalaman_organisasi" maxlength="20" value="<?php echo $pengalaman_organisasi ?? ''; ?>" readonly>
                                <label for="ada_saudara">
                                    <textarea type="text" style="width: 99%;" id="organisasi" name="organisasi" readonly><?php echo $organisasi ?? ''; ?>
                                </textarea>
                                </label>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- KEMAMPUAN BAHASA -->
                <div class="full-width" style="margin-bottom: 0px;">
                    <h4 style="margin-bottom: 5px; margin-top: -10px;">Referensi</h4>
                    <table class="form-table" style="width: 795px;">
                        <thead>
                            <tr style="background-color: #9ACD32; color: white;">
                                <td>Nama</td>
                                <td>Alamat</td>
                                <td>No. Telepon</td>
                                <td>Perusahaan / Jabatan</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" name="nama_ref_1" value="<?php echo isset($nama_ref_1) ? htmlspecialchars($nama_ref_1) : ''; ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="alamat_ref_1" value="<?php echo isset($alamat_ref_1) ? htmlspecialchars($alamat_ref_1) : ''; ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tlp_ref_1" value="<?php echo isset($tlp_ref_1) ? htmlspecialchars($tlp_ref_1) : ''; ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jabatan_ref_1" value="<?php echo isset($jabatan_ref_1) ? htmlspecialchars($jabatan_ref_1) : ''; ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="nama_ref_2" value="<?php echo isset($nama_ref_2) ? htmlspecialchars($nama_ref_2) : ''; ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="alamat_ref_2" value="<?php echo isset($alamat_ref_2) ? htmlspecialchars($alamat_ref_2) : ''; ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tlp_ref_2" value="<?php echo isset($tlp_ref_2) ? htmlspecialchars($tlp_ref_2) : ''; ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jabatan_ref_2" value="<?php echo isset($jabatan_ref_2) ? htmlspecialchars($jabatan_ref_2) : ''; ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="nama_ref_3" value="<?php echo isset($nama_ref_3) ? htmlspecialchars($nama_ref_3) : ''; ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="alamat_ref_3" value="<?php echo isset($alamat_ref_3) ? htmlspecialchars($alamat_ref_3) : ''; ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tlp_ref_3" value="<?php echo isset($tlp_ref_3) ? htmlspecialchars($tlp_ref_3) : ''; ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jabatan_ref_3" value="<?php echo isset($jabatan_ref_3) ? htmlspecialchars($jabatan_ref_3) : ''; ?>" readonly>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>

            </form>
        </div>

        <div id="files" class="tabcontent">
            <div class="section">
                <h3>Unggahan Dokumen Karyawan Baru</h3>
                <table class="form-table" style="margin-top: -18px;">

                    <!-- baris 1 -->
                    <tr>
                        <td rowspan="2" style="border: none;">
                            <!-- Modal -->
                            <div id="modalFoto-file" class="modal-file">
                                <span class="close-file">&times;</span>
                                <img class="modal-content-file" id="img01-file">
                            </div>

                            <!-- Foto Box -->
                            <div class="foto-box">
                                <?php if (!empty($referensi_kerja)) : ?>
                                    <img id="foto-preview-files" src="../../../karyawan/uploads-file/<?php echo $referensi_kerja; ?>" alt="Foto" style="display: block; width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="openModalFile(this);">
                                <?php else : ?>
                                    <img id="foto-preview-files" src="#" alt="Foto Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                <?php endif; ?>
                            </div>


                        </td>
                        <td rowspan="2" style="width: 50%; vertical-align: middle; padding-top: 2;">
                            Dokumen Referensi Kerja / Packlaring
                        </td>
                        <td rowspan="2" style="border: none;">
                            <!-- Modal -->
                            <div id="modalFoto-file" class="modal-file">
                                <span class="close-file">&times;</span>
                                <img class="modal-content-file" id="img01-file">
                            </div>

                            <!-- Foto Box -->
                            <div class="foto-box">
                                <?php if (!empty($fc_ijazah)) : ?>
                                    <img id="foto-preview-file" src="../../../karyawan/uploads-file/<?php echo $fc_ijazah; ?>" alt="Foto" style="display: block; width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="openModalFile(this);">
                                <?php else : ?>
                                    <img id="foto-preview-file" src="#" alt="Foto Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                <?php endif; ?>
                            </div>

                            <!-- Script untuk Modal -->
                            <script>
                                // Fungsi untuk membuka modal
                                function openModalFile(imgElement) {
                                    var modalFile = document.getElementById("modalFoto-file");
                                    var modalImgFile = document.getElementById("img01-file");

                                    modalFile.style.display = "block";
                                    modalImgFile.src = imgElement.src;
                                }

                                // Fungsi untuk menutup modal
                                var closeFile = document.getElementsByClassName("close-file")[0];
                                closeFile.onclick = function() {
                                    var modalFile = document.getElementById("modalFoto-file");
                                    modalFile.style.display = "none";
                                }

                                document.getElementById("defaultOpen-file").click();

                                function previewImageFile(event) {
                                    var reader = new FileReader();
                                    reader.onload = function() {
                                        var outputFile = document.getElementById('foto-preview-file');
                                        outputFile.src = reader.result;
                                        outputFile.style.display = 'block';

                                        var labelFile = document.querySelector('.foto-label-file');
                                        labelFile.style.display = 'none';
                                    }
                                    reader.readAsDataURL(event.target.files[0]);
                                }
                            </script>

                            <!-- CSS untuk Modal -->
                            <style>
                                /* Style untuk modal */
                                .modal-file {
                                    display: none;
                                    position: fixed;
                                    z-index: 1;
                                    padding-top: 50px;
                                    left: 0;
                                    top: 0;
                                    width: 100%;
                                    height: 100%;
                                    overflow: auto;
                                    background-color: rgba(0, 0, 0, 0.9);
                                }

                                .modal-content-file {
                                    margin: auto;
                                    display: block;
                                    max-width: 100%;
                                    max-height: calc(100% - 100px);
                                    /* Tinggi maksimum dengan jarak bawah 100px */
                                    background-color: #fefefe;
                                    border: 1px solid #888;
                                    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                                    overflow: auto;
                                    /* Tambahkan overflow untuk konten modal */
                                }

                                .modal-content-file img {
                                    width: 100%;
                                    height: auto;
                                    object-fit: contain;
                                    /* Menyesuaikan gambar dengan ukuran maksimum */
                                }

                                .close-file {
                                    position: absolute;
                                    top: 0px;
                                    right: 35px;
                                    color: #f1f1f1;
                                    font-size: 40px;
                                    font-weight: bold;
                                    transition: 0.3s;
                                }

                                .close-file:hover,
                                .close-file:focus {
                                    color: #bbb;
                                    text-decoration: none;
                                    cursor: pointer;
                                }
                            </style>
                        </td>
                        <td style="width: 50%; vertical-align: middle;" rowspan="2">
                            Dokumen Ijazah
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    <!-- baris 2 -->
                    <tr>
                        <td rowspan="2" style="border: none;">
                            <!-- Modal -->
                            <div id="modalFoto-file" class="modal-file">
                                <span class="close-file">&times;</span>
                                <img class="modal-content-file" id="img01-file">
                            </div>

                            <!-- Foto Box -->
                            <div class="foto-box">
                                <?php if (!empty($bpjs_ks)) : ?>
                                    <img id="foto-preview-files" src="../../../karyawan/uploads-file/<?php echo $bpjs_ks; ?>" alt="Foto" style="display: block; width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="openModalFile(this);">
                                <?php else : ?>
                                    <img id="foto-preview-file" src="#" alt="Foto Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                <?php endif; ?>
                            </div>


                        </td>
                        <td rowspan="2" style="width: 50%; vertical-align: middle; padding-top: 2;">
                            Dokumen BPJS Kesehatan
                        </td>
                        <td rowspan="2" style="border: none;">
                            <!-- Modal -->
                            <div id="modalFoto-file" class="modal-file">
                                <span class="close-file">&times;</span>
                                <img class="modal-content-file" id="img01-file">
                            </div>

                            <!-- Foto Box -->
                            <div class="foto-box">
                                <?php if (!empty($fc_tn)) : ?>
                                    <img id="foto-preview-files" src="../../../karyawan/uploads-file/<?php echo $fc_tn; ?>" alt="Foto" style="display: block; width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="openModalFile(this);">
                                <?php else : ?>
                                    <img id="foto-preview-file" src="#" alt="Foto Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                <?php endif; ?>
                            </div>

                        </td>
                        <td style="width: 50%; vertical-align: middle;" rowspan="2">
                            Dokumen Transkip Nilai
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    <!-- baris 3 -->
                    <tr>
                        <td rowspan="2" style="border: none;">
                            <!-- Modal -->
                            <div id="modalFoto-file" class="modal-file">
                                <span class="close-file">&times;</span>
                                <img class="modal-content-file" id="img01-file">
                            </div>

                            <!-- Foto Box -->
                            <div class="foto-box">
                                <?php if (!empty($bpjs_kg)) : ?>
                                    <img id="foto-preview-files" src="../../../karyawan/uploads-file/<?php echo $bpjs_kg; ?>" alt="Foto" style="display: block; width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="openModalFile(this);">
                                <?php else : ?>
                                    <img id="foto-preview-file" src="#" alt="Foto Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                        </td>
                        <td rowspan="2" style="width: 50%; vertical-align: middle; padding-top: 2;">
                            Dokumen BPJS Ketenagakerjaan
                        </td>
                        <td rowspan="2" style="border: none;">
                            <!-- Modal -->
                            <div id="modalFoto-file" class="modal-file">
                                <span class="close-file">&times;</span>
                                <img class="modal-content-file" id="img01-file">
                            </div>

                            <!-- Foto Box -->
                            <div class="foto-box">
                                <?php if (!empty($fc_bt)) : ?>
                                    <img id="foto-preview-files" src="../../../karyawan/uploads-file/<?php echo $fc_bt; ?>" alt="Foto" style="display: block; width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="openModalFile(this);">
                                <?php else : ?>
                                    <img id="foto-preview-file" src="#" alt="Foto Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                <?php endif; ?>
                            </div>

                        </td>
                        <td style="width: 50%; vertical-align: middle;" rowspan="2">
                            Dokumen Buku Tabungan
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    <!-- baris 4 -->
                    <tr>
                        <td rowspan="2" style="border: none;">
                            <!-- Modal -->
                            <div id="modalFoto-file" class="modal-file">
                                <span class="close-file">&times;</span>
                                <img class="modal-content-file" id="img01-file">
                            </div>

                            <!-- Foto Box -->
                            <div class="foto-box">
                                <?php if (!empty($bpjs_jp)) : ?>
                                    <img id="foto-preview-files" src="../../../karyawan/uploads-file/<?php echo $bpjs_jp; ?>" alt="Foto" style="display: block; width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="openModalFile(this);">
                                <?php else : ?>
                                    <img id="foto-preview-file" src="#" alt="Foto Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                <?php endif; ?>
                            </div>


                        </td>
                        <td rowspan="2" style="width: 50%; vertical-align: middle; padding-top: 2;">
                            Dokumen BPJS jamainan Pensiun
                        </td>
                        <td rowspan="2" style="border: none;">
                            <!-- Modal -->
                            <div id="modalFoto-file" class="modal-file">
                                <span class="close-file">&times;</span>
                                <img class="modal-content-file" id="img01-file">
                            </div>

                            <!-- Foto Box -->
                            <div class="foto-box">
                                <?php if (!empty($fc_npwp)) : ?>
                                    <img id="foto-preview-files" src="../../../karyawan/uploads-file/<?php echo $fc_npwp; ?>" alt="Foto" style="display: block; width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="openModalFile(this);">
                                <?php else : ?>
                                    <img id="foto-preview-file" src="#" alt="Foto Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                <?php endif; ?>
                            </div>

                        </td>
                        <td style="width: 50%; vertical-align: middle;" rowspan="2">
                            Dokumen Nomor Pokok Wajib Pajak (NPWP)
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    <!-- baris 5 -->
                    <tr>
                        <td rowspan="2" style="border: none;">
                            <!-- Modal -->
                            <div id="modalFoto-file" class="modal-file">
                                <span class="close-file">&times;</span>
                                <img class="modal-content-file" id="img01-file">
                            </div>

                            <!-- Foto Box -->
                            <div class="foto-box">
                                <?php if (!empty($foto_ktp)) : ?>
                                    <img id="foto-preview-files" src="../../../karyawan/uploads-file/<?php echo $foto_ktp; ?>" alt="Foto" style="display: block; width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="openModalFile(this);">
                                <?php else : ?>
                                    <img id="foto-preview-file" src="#" alt="Foto Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                <?php endif; ?>
                            </div>


                        </td>
                        <td rowspan="2" style="width: 50%; vertical-align: middle; padding-top: 2;">
                            Dokumen Kartu Tanda Penduduk (KTP)
                        </td>
                        <td rowspan="2" style="border: none;">
                            <!-- Modal -->
                            <div id="modalFoto-file" class="modal-file">
                                <span class="close-file">&times;</span>
                                <img class="modal-content-file" id="img01-file">
                            </div>

                            <!-- Foto Box -->
                            <div class="foto-box">
                                <?php if (!empty($fc_kk)) : ?>
                                    <img id="foto-preview-files" src="../../../karyawan/uploads-file/<?php echo $fc_kk; ?>" alt="Foto" style="display: block; width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="openModalFile(this);">
                                <?php else : ?>
                                    <img id="foto-preview-file" src="#" alt="Foto Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                <?php endif; ?>
                            </div>


                        </td>
                        <td style="width: 50%; vertical-align: middle;" rowspan="2">
                            Dokumen Kartu Keluarga (KK)
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    <!-- baris 6 -->
                    <tr>
                        <td rowspan="2" style="border: none;">
                        </td>
                        <td style="width: 50%; border: none;">
                        </td>

                        <td rowspan="2" style="border: none;">
                            <!-- Modal -->
                            <div id="modalFoto-file" class="modal-file">
                                <span class="close-file">&times;</span>
                                <img class="modal-content-file" id="img01-file">
                            </div>

                            <!-- Foto Box -->
                            <div class="foto-box">
                                <?php if (!empty($fc_sp)) : ?>
                                    <img id="foto-preview-files" src="../../../karyawan/uploads-file/<?php echo $fc_sp; ?>" alt="Foto" style="display: block; width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="openModalFile(this);">
                                <?php else : ?>
                                    <img id="foto-preview-file" src="#" alt="Foto Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                        </td>
                        <td style="width: 50%; vertical-align: middle;" rowspan="2">
                            Dokumen Sertifikat
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none; background-color: white;">
                        </td>

                    </tr>
                    <br>
                </table>
            </div>

            <?php
            // Konfigurasi database
            $host = "localhost";
            $username = "alwan"; // Ganti dengan username MySQL Anda
            $password = "root"; // Ganti dengan password MySQL Anda
            $database = "db_sijababeka"; // Ganti dengan nama database Anda

            // Buat koneksi ke database
            $connection = new mysqli($host, $username, $password, $database);

            // Periksa koneksi
            if ($connection->connect_error) {
                die("Koneksi ke database gagal: " . $connection->connect_error);
            }

            // Ambil nilai id_biodata dan kodeFPK dari form atau URL
            $id_biodata = isset($_GET['id_biodata']) ? $_GET['id_biodata'] : '';

            // Query untuk mengambil nama file dari database
            $query = "SELECT file_interview_user, file_interview_hr, file_hasil_psikotest, confirmation_letter, file_hasil_tes_kesehatan FROM hcc WHERE id_biodata = ? AND fpk_selection = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("ss", $id_biodata, $kodeFPK);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $file_interview_user = $row['file_interview_user'] ?? null;
            $file_interview_hr = $row['file_interview_hr'] ?? null;
            $file_hasil_psikotest = $row['file_hasil_psikotest'] ?? null;
            $confirmation_letter = $row['confirmation_letter'] ?? null;
            $file_hasil_tes_kesehatan = $row['file_hasil_tes_kesehatan'] ?? null;

            $stmt->close();
            $connection->close();

            $allFilesFilled = !empty($row['file_interview_user']) &&
                !empty($row['file_interview_hr']) &&
                !empty($row['file_hasil_psikotest']) &&
                !empty($row['confirmation_letter']) &&
                !empty($row['file_hasil_tes_kesehatan']);
            ?>

            <style>
                .card-container {
                    display: flex;
                    justify-content: center;
                    flex-wrap: wrap;
                }

                .card-img {
                    /* border: 1px solid #ccc; */
                    /* padding: 10px; */
                    margin-bottom: 20px;
                    width: calc(45%);
                    border-radius: 4px;
                    /* box-sizing: border-box; */
                    /* justify-content: center; */

                }

                .card-input {
                    margin-bottom: 10px;
                    width: calc(100% - 20px);
                    /* Sesuaikan lebar dengan margin dan border */
                    padding: 8px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-sizing: border-box;
                }

                .card-input[type="file"] {
                    display: block;
                    /* Ensure input file is displayed as block element */
                }

                .card-input[type="submit"] {
                    display: block;
                    width: 100%;
                    padding: 8px;
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    cursor: pointer;
                    border-radius: 4px;
                }

                .card-input[type="submit"]:hover {
                    background-color: #45a049;
                }

                .hidden {
                    display: none;
                }
            </style>

            <!-- DATA PRIBADI -->
            <h3>Unggahan Dokumen Karyawan Baru</h3>

            <form action="proses_upload.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_biodata" value="<?php echo htmlspecialchars($id_biodata); ?>">
                <div class="card-container">
                    <!-- File Interview User -->
                    <?php if (!empty($row['file_interview_user'])) { ?>
                        <div class="card-img">
                            <label>File Interview User:</label><br>
                            <img class="card-img" src="unggah-adminunit/<?php echo htmlspecialchars($row['file_interview_user']); ?>" width="200" alt="File Interview User">
                        </div>
                    <?php } else { ?>
                        <div class="card-input">
                            <label for="file_interview_user">File Interview User:</label>
                            <input class="card-input" type="file" name="file_interview_user" required>
                        </div>
                    <?php } ?>

                    <!-- File Interview HR -->
                    <?php if (!empty($row['file_interview_hr'])) { ?>
                        <div class="card-img">
                            <label>File Interview HR:</label><br>
                            <img class="card-img" src="unggah-adminunit/<?php echo htmlspecialchars($row['file_interview_hr']); ?>" width="200" alt="File Interview HR">
                        </div>
                    <?php } else { ?>
                        <div class="card-input">
                            <label for="file_interview_hr">File Interview HR:</label>
                            <input class="card-input" type="file" name="file_interview_hr" required>
                        </div>
                    <?php } ?>

                    <!-- File Hasil Psikotest -->
                    <?php if (!empty($row['file_hasil_psikotest'])) { ?>
                        <div class="card-img">
                            <label>File Hasil Psikotest:</label><br>
                            <img class="card-img" src="unggah-adminunit/<?php echo htmlspecialchars($row['file_hasil_psikotest']); ?>" width="200" alt="File Hasil Psikotest">
                        </div>
                    <?php } else { ?>
                        <div class="card-input">
                            <label for="file_hasil_psikotest">File Hasil Psikotest:</label>
                            <input class="card-input" type="file" name="file_hasil_psikotest" required>
                        </div>
                    <?php } ?>

                    <!-- Confirmation Letter -->
                    <?php if (!empty($row['confirmation_letter'])) { ?>
                        <div class="card-img">
                            <label>Confirmation Letter:</label><br>
                            <img class="card-img" src="unggah-adminunit/<?php echo htmlspecialchars($row['confirmation_letter']); ?>" width="200" alt="Confirmation Letter">
                        </div>
                    <?php } else { ?>
                        <div class="card-input">
                            <label for="confirmation_letter">File Confirmation Letter:</label>
                            <input class="card-input" type="file" name="confirmation_letter" required>
                        </div>
                    <?php } ?>

                    <!-- File Hasil Tes Kesehatan -->
                    <?php if (!empty($row['file_hasil_tes_kesehatan'])) { ?>
                        <div class="card-img">
                            <label>File Hasil Tes Kesehatan:</label><br>
                            <img class="card-img" src="unggah-adminunit/<?php echo htmlspecialchars($row['file_hasil_tes_kesehatan']); ?>" width="200" alt="File Hasil Tes Kesehatan">
                        </div>
                    <?php } else { ?>
                        <div class="card-input">
                            <label for="file_hasil_tes_kesehatan">File Hasil Tes Kesehatan:</label>
                            <input class="card-input" type="file" name="file_hasil_tes_kesehatan" required>
                        </div>
                    <?php } ?>

                    <!-- Tombol Unggah -->
                    <?php if (!$allFilesFilled) { ?>
                        <input class="card-input" type="submit" value="Unggah File">
                    <?php } ?>
                </div>
            </form>
            <!-- Tampilkan form input jika belum ada data -->
            <!-- <div class="card-input">
                <label for="file_interview_user">File Interview User:</label>
                <input class="card-input" type="file" name="file_interview_user" <?php echo $result->num_rows > 0 && !empty($row['file_interview_user']) ? 'disabled' : 'required'; ?>>

                <label for="file_interview_hr">File Interview HR:</label>
                <input class="card-input" type="file" name="file_interview_hr" <?php echo $result->num_rows > 0 && !empty($row['file_interview_hr']) ? 'disabled' : 'required'; ?>>

                <label for="file_hasil_psikotest">File Hasil Psikotest:</label>
                <input class="card-input" type="file" name="file_hasil_psikotest" <?php echo $result->num_rows > 0 && !empty($row['file_hasil_psikotest']) ? 'disabled' : 'required'; ?>>

                <label for="confirmation_letter">File Confirmation Letter:</label>
                <input class="card-input" type="file" name="confirmation_letter" <?php echo $result->num_rows > 0 && !empty($row['confirmation_letter']) ? 'disabled' : 'required'; ?>>

                <label for="file_hasil_tes_kesehatan">File Hasil Tes Kesehatan:</label>
                <input class="card-input" type="file" name="file_hasil_tes_kesehatan" <?php echo $result->num_rows > 0 && !empty($row['file_hasil_tes_kesehatan']) ? 'disabled' : 'required'; ?>>

                <input class="card-input" type="submit" value="Unggah File">
            </div> -->


        </div>

        <div id="notes" class="tabcontent">
            <h3>Notes</h3>
            <!-- Tambahkan catatan mengenai kandidat di sini -->
        </div>
    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;

            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        document.getElementById("defaultOpen").click();

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('foto-preview');
                output.src = reader.result;
                output.style.display = 'block';

                var label = document.querySelector('.foto-label');
                label.style.display = 'none';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>