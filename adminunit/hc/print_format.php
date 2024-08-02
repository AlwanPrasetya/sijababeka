<style>
  body{
    background-color: white;
  }
</style>
<?php
// Koneksi ke database
$servername = "localhost";
$username = "alwan";
$password = "root";
$dbname = "db_sijababeka";

// Membuat koneksi
$connection = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($connection->connect_error) {
  die("Koneksi ke database gagal: " . $connection->connect_error);
}

// Periksa apakah id_hc telah ditentukan di URL
if (isset($_GET['fpk_selection'])) {
  // Tangkap nilai id_hc dari URL
  $id_hc = $_GET['fpk_selection'];

  // Query untuk mengambil data fpk berdasarkan id_hc
  $sql = "SELECT * FROM hcc WHERE id_hc = $id_hc";
  $result = $connection->query($sql);

  if ($result->num_rows > 0) {
    // Tampilkan data sesuai dengan id_hc yang tertangkap
    $row = $result->fetch_assoc();

    // Tampilkan data dalam tabel HTML
    echo "<table border='1' style='width: 100%; background-color: white;'>
            <tbody>
              <tr>
                  <td rowspan=\"3\" style='width: 20%; padding-top: 7px; padding-bottom: 7px; padding-left: 60px;'><img src='./img/logo-jababeka.png' alt='Deskripsi gambar' style='width: 100px;'></td>
                  <td colspan=\"2\" style='text-align: center;'>
                      <h2 style='font-size: 32px;'>HIRING CONFIRMATION</h2>
                  </td>
              </tr>
              <tr>
                  <td colspan=\"2\" style='text-align: center;'><strong>NO: 001/HC/HRD-Div-HOLDING/III/2024</strong></td>
              </tr>
            </tbody>
          </table>";
    echo "<br>";


    // TABEL USER
    echo "<table border='1' style='width: 100%; background-color: white;'>
  <tbody>
        <tr>
            <td style='width: 20%; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>Nama Kandidat</strong></td>
            <td colspan=\"4\" style='width: 80%; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['nama_kandidat'] . "</td>
        </tr>
        <tr>
            <td style='padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>Tanggal Lahir</strong></td>
            <td colspan=\"4\" style='padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['form_tanggal_lengkap'] . "</td>
        </tr>
        <tr>
            <td style='padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>No. KTP</strong></td>
            <td colspan=\"4\" style='padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['no_ktp'] . "</td>
        </tr>
        <tr>
            <td style='padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>Pendidikan</strong></td>
            <td colspan=\"4\" style='padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['pendidikan'] . "</td>
        </tr>
        <tr>
            <td style='padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>Alasan Penerimaan</strong></td>
            <td colspan=\"2\" style='padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['alasan_penerimaan'] . "</td>
            <td style='padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>Berdasarkan FPK No</strong></td> 
            <td style='padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['fpk_selection'] . "</td>
            </tr>
        <tr>
            <td style='padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>Unit Bisnis</strong></td>
            <td colspan=\"2\" style='padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['branch'] . "</td>
            <td style='padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>Divisi/Dept</strong></td> 
            <td style='padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['organisasi'] . "</td>
        </tr>
        <tr>
            <td style='padding-top: 7px; padding-bottom: 7px; width: 20%; padding-left: 7px;'><strong>Jabatan</strong></td>
            <td colspan=\"2\" style='padding-top: 7px; width: 40%; padding-bottom: 7px; padding-left: 7px;'>" . $row['jabatan'] . "</td>
            <td style='padding-top: 7px; width: 20%; padding-bottom: 7px; padding-left: 7px;'><strong>Level/Golongan</strong></td> 
            <td style='padding-top: 7px; width: 20%; padding-bottom: 7px; padding-left: 7px;'>" . $row['golongan'] . "</td>
        </tr>
        <tr>
            <td rowspan=\"11\" style='vertical-align: top; padding-top: 7px; padding-bottom: 7px; width: 20%; padding-left: 7px;'><strong>Remunerasi</strong></td>
            <td colspan=\"2\" style='width: 40%; text-align: center; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>Pengajuan (Diisi Oleh HR Unit)</strong></td>
            <td colspan=\"2\" style='width: 40%; text-align: center; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>Check & Control (Diisi Oleh HR Holding)</strong></td>
        </tr>
        <tr>
            <td style='width: 20%; text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Gaji Pokok</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['gaji_pokok'] . "</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Gaji Pokok</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'></td>
        </tr>
        <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Tunjangan makan</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['tunjangan_makan'] . "</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Tunjangan makan</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'></td>
        </tr>
        <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Tunjangan Transport</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['tunjangan_transport'] . "</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Tunjangan Transport</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'></td>
        </tr>
        <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Tunjangan Kendaraan</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['tunjangan_kendaraan'] . "</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Tunjangan Kendaraan</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'></td>
        </tr>
        <tr style='background-color: #e0e0e0;'>
        <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>Total Salary (Gross)</strong></td>
        <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['total_sallary_gross'] . "</td>
        <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>Total Salary (Gross)</strong></td>
        <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'></td>
        </tr>

        <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>BPJS Ketenagakerjaan (JHT)</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['bpjs_jht'] . "</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>BPJS Ketenagakerjaan (JHT)</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'></td>
        </tr>
        <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>BPJS Ketenagakerjaan (JP)</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['bpjs_jp'] . "</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>BPJS Ketenagakerjaan (JP)</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'></td>
        </tr>
        <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>BPJS Kesehatan</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['bpjs_ks'] . "</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>BPJS Kesehatan</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'></td>
        </tr>
        <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Koperasi Karyawan</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['koperasi_karyawan'] . "</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Koperasi Karyawan</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'></td>
        </tr>
        <tr style='background-color: #e0e0e0;'>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>Total Salary (Nett)</strong></td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['total_sallary_nett'] . "</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>Total Salary (Nett)</strong></td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'></td>
        </tr>
        
        <tr>
            <td style='width: 20%; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>Catatan</strong></td>
            <td colspan=\"4\" style=' padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['form_catatan'] . "</td>
        </tr>
        <tr>
            <td colspan=\"5\" style='padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>Dokumen Checklist (Diisi Oleh HR Unit)</strong></td>
        </tr>
                </tr>
        <tr>
            <td rowspan=\"11\" style='vertical-align: top; padding-top: 7px; padding-bottom: 7px; width: 20%; padding-left: 7px;'><strong>Form Pendukung</strong></td>
        </tr>
        <tr>
            <td style='width: 20%; text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Form Aplikasi Karyawan</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['form_aplikasi'] . "</td>
            <td style='width: 20%; text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Pas Foto</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['pas_foto'] . "</td>
        </tr>
        <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Form Interview User</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['form_interview_user'] . "</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Fotocopy KTP</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['foto_ktp'] . "</td>
        </tr>
        <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Form Interview HR Unit</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['form_interview_hr'] . "</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Fotocopy Ijazah</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['foto_ijazah'] . "</td>
        </tr>
        <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Laporan Hasil Psikotest</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['form_hasil_psikotest'] . "</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Fotocopy Transkip Nilai</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['foto_transkip_nilai'] . "</td>
        </tr>
        <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Confirmation Letter</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['form_confirmation_letter'] . "</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Fotocopy Buku Tabungan</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['foto_buku_tabungan'] . "</td>
        </tr>
        <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Hasil Tes Kesehatan</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['form_hasil_tes_kesehatan'] . "</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Fotocopy NPWP</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['foto_npwp'] . "</td>
        </tr>
        <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Fotocopy Referensi Kerja</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['referensi_kerja'] . "</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Fotocopy KK</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['foto_kk'] . "</td>
        </tr>
        <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>BPJS Kesehatan</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['bpjs_kesehatan'] . "</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Fotocopy Sertifikat</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['foto_sertifikat'] . "</td>
        </tr>
        <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>BPJS Ketenagakerjaan</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['bpjs_ketenagakerjaan'] . "</td>
        </tr>
        <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>BPJS Jaminan Pensiun</td>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>" . $row['bpjs_jaminan_pensiun'] . "</td>
        </tr>
         <tr>
            <td style='text-align: start; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'><strong>Status</strong></td>
            <td style='text-align: center; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Kontrak
                <label for='kontrak1' style='display: inline-block; width: 20px; height: 20px; border: 1px solid #000; vertical-align: middle; margin-top: 3px;'>
                    <input type='radio' id='kontrak1' name='kontrak1' style='display: none;'>
                </label>
            </td>
            <td style='text-align: center; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Bulan
                <label for='bulan1' style='display: inline-block; width: 20px; height: 20px; border: 1px solid #000; vertical-align: middle; margin-top: 3px;'>
                    <input type='radio' id='bulan1' name='bulan1' style='display: none;'>
                </label>
            </td>          
            <td style='text-align: center; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>Tanggal Join</td>
            <td style='text-align: center; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'></td>
        </tr>
        <tr>
         <td colspan='5' style='width: 100%; text-align: center; border: none;'>
            <strong>
              DAPAT DIPROSES MENJADI PEKERJA DI JABABEKA GROUP, DENGAN NOMOR INDUK KARYAWAN
            </strong>
          </td>
        </tr>
            <tr>
            <td colspan='5' style='padding: 10px; text-align: center;'>
                <!-- Membuat 10 kotak -->
                <div style='display: flex; justify-content: center;'>
                    <label for='kotak1' style='display: inline-block; width: 50px; height: 50px; border: 1px solid #000; margin: 0px;'>
                        <input type='checkbox' id='kotak1' name='kotak1' style='display: none;'>
                    </label>
                    <label for='kotak2' style='display: inline-block; width: 50px; height: 50px; border: 1px solid #000; margin: 0px;'>
                        <input type='checkbox' id='kotak2' name='kotak2' style='display: none;'>
                    </label>
                    <label for='kotak3' style='display: inline-block; width: 50px; height: 50px; border: 1px solid #000; margin: 0px;'>
                        <input type='checkbox' id='kotak3' name='kotak3' style='display: none;'>
                    </label>
                    <label for='kotak4' style='display: inline-block; width: 50px; height: 50px; border: 1px solid #000; margin: 0px;'>
                        <input type='checkbox' id='kotak4' name='kotak4' style='display: none;'>
                    </label>
                    <label for='kotak5' style='display: inline-block; width: 50px; height: 50px; border: 1px solid #000; margin: 0px;'>
                        <input type='checkbox' id='kotak5' name='kotak5' style='display: none;'>
                    </label>
                    <label for='kotak6' style='display: inline-block; width: 50px; height: 50px; border: 1px solid #000; margin: 0px;'>
                        <input type='checkbox' id='kotak6' name='kotak6' style='display: none;'>
                    </label>
                    <label for='kotak7' style='display: inline-block; width: 50px; height: 50px; border: 1px solid #000; margin: 0px;'>
                        <input type='checkbox' id='kotak7' name='kotak7' style='display: none;'>
                    </label>
                    <label for='kotak8' style='display: inline-block; width: 50px; height: 50px; border: 1px solid #000; margin: 0px;'>
                        <input type='checkbox' id='kotak8' name='kotak8' style='display: none;'>
                    </label>
                    <label for='kotak9' style='display: inline-block; width: 50px; height: 50px; border: 1px solid #000; margin: 0px;'>
                        <input type='checkbox' id='kotak9' name='kotak9' style='display: none;'>
                    </label>
                    <label for='kotak10' style='display: inline-block; width: 50px; height: 50px; border: 1px solid #000; margin: 0px;'>
                        <input type='checkbox' id='kotak10' name='kotak10' style='display: none;'>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <td style='text-align: center; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>HR, </br></br></br></br> <strong>HR Unit</strong> </br> Date:</td>
            <td colspan=\"2\" style='text-align: center; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>USER, </br></br></br></br> <strong>Div./Dept.Head</strong> <span style='margin-left: 80px;'><strong>Director Unit</strong></span> </br>Date: <span style='margin-left: 150px;'>Date:</span></td>
            <td colspan=\"2\" style='text-align: center; padding-top: 7px; padding-bottom: 7px; padding-left: 7px;'>HOLDING, </br></br></br></br> <strong>Recruitment</strong> <span style='margin-left: 80px;'><strong>HR Director</strong></span> </br>Date: <span style='margin-left: 150px;'>Date:</span></td>
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
