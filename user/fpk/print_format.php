<?php
// Koneksi ke database
include('koneksi.php');

// Periksa apakah id_fpk telah ditentukan di URL
if (isset($_GET['id_fpk'])) {
    // Tangkap nilai id_fpk dari URL
    $id_fpk = $_GET['id_fpk'];

    // Query untuk mengambil data fpk berdasarkan id_fpk
    $sql = "SELECT * FROM fpk WHERE id_fpk = $id_fpk";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        // Tampilkan data sesuai dengan id_fpk yang tertangkap
        $row = $result->fetch_assoc();

        // Tampilkan data dalam tabel HTML
        echo "<table border='1' style='width: 100%;'>
        <tbody>
        <tr>
            <td rowspan=\"4\" style='width: 25%; padding-top: 10px; padding-bottom: 10px; padding-left: 80px;'><img src='./img/logo-jababeka.png' alt='Deskripsi gambar' style='width: 100px;'></td>
            <td style='padding-left: 180px;;'><strong>DOKUMEN PENDUKUNG</strong></td>
            <td style='padding-left: 10px;'>Nomor   : DP-HRGA-01/01</td>
        </tr>
        <tr>
            <td rowspan=\"3\" style='padding-left: 120px;'><strong>FORMULIR PERMINTAAN KARYAWAN</strong></td>
            <td style='padding-left: 10px;'>Revisi  : 04</td>
        </tr>
        <tr>
            <td style='padding-left: 10px;'>Tanggal : 18 November 2016</td>
        </tr>
        <tr>
            <td style='width: 25%; padding-left: 10px;'>Nomor : " . $row['kodeFPK'] . "</td>
        </tr>
        </tbody>
        </table>";
        echo "<br>";

        // TABEL USER
        echo "<table border='1' style='width: 100%;'>
    <tbody>
        <tr>
            <td style='width: 50%; padding-top: 10px; padding-bottom: 10px; padding-left: 10px;'>UNIT BISNIS / DIVISI : " . $row['branch'] . "</td>
            <td style='width: 50%; padding-top: 10px; padding-bottom: 10px; padding-left: 10px;'>LOKASI KERJA : " . $row['lokasi'] . "</td>
        </tr>
        <tr>
            <td style='padding-top: 10px; padding-bottom: 10px; padding-left: 10px;'>DEPARTMENT : " . $row['department'] . "</td>
            <td style='padding-top: 10px; padding-bottom: 10px; padding-left: 10px;'>GOLONGAN : " . $row['golongan'] . "</td>
            
        </tr>
        <tr>
            <td style='padding-top: 10px; padding-bottom: 10px; padding-left: 10px;'>JABATAN : " . $row['jabatan'] . "</td>
            <td style='padding-top: 10px; padding-bottom: 10px; padding-left: 10px;'>STATUS : " . $row['status'] . "</td>
        </tr>
        <tr>
        <td colspan=\"2\" style='padding-top: 10px; padding-bottom: 10px; padding-left: 10px;'>TANGGAL PERMINTAAN : " . $row['effectiveDate'] . "</td>
            
        </tr>
        <!-- Lanjutkan menampilkan kolom lainnya sesuai kebutuhan -->
    
        <tr>
            <td style='padding-top: 10px; padding-bottom: 10px; padding-left: 10px;'><strong>PERMINTAAN UNTUK :</strong> " . $row['requestFor'] . "</td>
            <td style='width: 50%; padding-left: 10px;'>CATATAN :</td>
        </tr>
        <tr>
            <td colspan=\"2\" style='width: 50%; padding-top: 10px; padding-bottom: 10px; padding-left: 10px'>ALASAN : " . $row['reason'] . "</td>
        </tr>
        </tbody>
        </table>";

        // TABEL KUALIFIKASI DIRI
        echo "<table border='1' style=' width: 100%;'>
        <tbody>
        <tr>
            <td  colspan=\"3\" style='padding-top: 10px; padding-bottom: 10px; padding-left: 10px;'><strong>KUALIFIKASI :</strong> (DIISI LENGKAP)</td>
        </tr>
        <tr>
            <td style='width: 33%; padding-top: 10px; padding-bottom: 10px; padding-left: 10px;'>JENIS KELAMIN : " . $row['gender'] . "</td>
            <td style='width: 33%; padding-top: 10px; padding-bottom: 10px; padding-left: 10px'>PENGALAMAN : " . $row['experience'] . " TH</td>
            <td style='width: 33%; padding-left: 10px;'>USIA : " . $row['age'] . "</td>
        </tr>
        <tr>
    <td style='width: 50%; padding-top: 10px; padding-bottom: 10px; padding-left: 10px;'>PENDIDIKAN : " . $row['education'] . "</td>
    <td colspan=\"2\" style='width: 50%; padding-top: 10px; padding-bottom: 10px; padding-left: 10px;'>JURUSAN : " . $row['major'] . "</td>
</tr>
        <tr>
            <td style='padding-top: 10px; padding-bottom: 10px; padding-left: 10px'>URAIAN PEKERJAAN : " . $row['jobDescription'] . "</td>
            <td colspan=\"2\" style='padding-top: 10px; padding-bottom: 10px; padding-left: 10px'>SPESIFIKASI PEKERJAAN : " . $row['jobSpecification'] . "</td>
        </tr>
        <tr>
            <td style='padding-top: 10px; padding-bottom: 10px; padding-left: 10px'>PERSYARATAN <br> SOFT SKILL : " . $row['softSkills'] . "</td>
            <td colspan=\"2\" style='padding-top: 10px; padding-bottom: 10px; padding-left: 10px'>HARD SKILL : " . $row['hardSkills'] . "</td>
        </tr>
        </tbody>
        </table>";

        echo "<table border='1' style=' width: 100%;'>
        <tbody>
        <tr>
    <td style='width: 33%; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; text-align: center;'>
        USER & HR UNIT<br>
        <div style='display: flex;'>
        <div style='flex: 1;'>
            <img src='ttd/img/alwan.png' alt='Tanda Tangan User' style='max-width: 100%; height: auto;'>
        </div>
        <div style='flex: 1;'>
            <img src='ttd/img/fahrul.png' alt='Tanda Tangan User' style='max-width: 100%; height: auto;'>
        </div>
    </div>    
        <hr style='border-top: 1px solid black;'>
        <div style='text-align: left; padding-left: 10px;'>
            " . $row["namaUser"] . " / " . $row["effectiveDate"] . "<br>
            " . $row["namaAdmin"] . " / " . $row["effectiveDate"] .  "
        </div>  
      </td>
    <td style='width: 33%; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; text-align: center;'>
        DIREKTUR FUNGSIONAL
        <div style='display: flex;'>
        <div style='flex: 1;'>
            <img src='ttd/img/frenchyani.png' alt='Tanda Tangan User' style='max-width: 100%; height: auto;'>
        </div>
        <div style='flex: 1;'>
            <img src='ttd/img/aurelia.png' alt='Tanda Tangan User' style='max-width: 100%; height: auto;'>
        </div>
        <div style='flex: 1;'>
            <img src='ttd/img/aliramli.png' alt='Tanda Tangan User' style='max-width: 100%; height: auto;'>
        </div>
    </div>   
        <hr style='border-top: 1px solid black;'>
        <div style='text-align: left; padding-left: 10px;'> 
        " . $row["namaAtasan"] . " / " . $row["effectiveDate"] . "<br>
            " . $row["namaDireksi2"] . " / " . $row["effectiveDate"] .  "<br>
            " . $row["namaDireksi3"] . " / " . $row["effectiveDate"] .  "
        </div>
    </td>
    <td style='width: 33%; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; text-align: center;'>
        DIREKTUR FUNGSIONAL
        <div style='display: flex;'>
        <div style='flex: 1;'>
            <img src='ttd/img/reza.png' alt='Tanda Tangan User' style='max-width: 100%; height: auto;'>
        </div>
    </div>   
        <hr style='border-top: 1px solid black;'>
        <div style='text-align: left; padding-left: 10px;'> 
        " . $row["namaCorpHr"] . " / " . $row["effectiveDate"] . "<br>
        </div>
    </td>
        </tr>
      
        <tr>
            <td colspan=\"3\" style=' padding-left: 10px;'>DIISI OLEH HR RECRUITMENT</td>
        </tr>
        <tr>
            <td rowspan=\"2\" style='width: 25%; padding-left: 10px;'>KANDIDAT YANG DIUSULKAN <br> 1............................ <br> 2............................ <br> 3............................ </td>
            <td style='padding-left: 10px;'>KANDIDAT TERPILIH :...............</td>
            <td style='padding-left: 10px;'>TGL JOIN :...............</td>
        </tr>
        <tr>
            <td colspan=\"2\" style='padding-left: 200px; padding-right: 200px; padding-top: 20px;'><div style='text-align: center;'>HR RECRUITMENT</div>
            <div style='display: flex;'>
        <div style='flex: 1;'>
            <img src='ttd/img/mantes.png' alt='Tanda Tangan User' style='max-width: 100%; height: auto;'>
        </div>
    </div> 
            <hr style='border-top: 1px solid black;'>
            <div style='text-align: left; padding-left: 10px;'> 
        " . $row["namaSuperadmin"] . " / " . $row["effectiveDate"] . "<br>
        </div>
            </td>
        </tr>
        </tbody>
        </table>";
  } else {
        echo "Data tidak ditemukan";
    }
} else {
    echo "ID FPK tidak ditentukan";
}

// Menutup koneksi database
$connection->close();
