<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<?php
include('koneksi.php');
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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data HC</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
  body {
    background-color: #EAFAF1;
  }

  /* CSS untuk button di kanan atas */
  .top-left-button {
    top: 20px;
    left: 20px;
  }
</style>


<body>
  <a href="../hc/hc.php?id=<?php echo $userId; ?>&branches=<?php echo $branches; ?>" class="top-left-button">
    <img src="./img/left-arrow.png " alt="" style="width: 40px; height: 40px; margin: 15px 15px;"></a>

  <div class="container mt-1">
    <div class="card">
      <div class="card-header" style="background-color: #008F4D; color: white;">
        TABEL HIRING CONFIRMATION
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered bg-white" id="myTable">
            <thead>
              <tr>
                <th>No</th>
                <th>FPK Selection</th>
                <th>Nama Kandidat</th>
                <th>Persetujuan HR Unit</th>
                <th>Approval</th>
                <th>Konfirmasi</th>
                <th>Aksi</th>

              </tr>
            </thead>
            <tbody>
              <?php
              include('koneksi.php');
              $no = 1;

              // Periksa apakah nilai "branches" diterima melalui URL
              if (isset($_GET['branches'])) {
                // Ambil nilai "branches" dari URL
                $branches = $_GET['branches'];

                // Jika nilai "branches" adalah string, konversi menjadi array dengan memisahkan nilainya berdasarkan koma
                if (!is_array($branches)) {
                  $branches = explode(",", $branches);
                }

                // Buat klausul WHERE untuk query SQL dengan nilai branch yang diterima
                $whereClause = "WHERE hcc.branch IN ('" . implode("', '", $branches) . "')";

                // Ubah query SQL dengan menambahkan klausul WHERE
                $sql = "SELECT hcc.*, persetujuan_hc.Status_Penyetujuan, persetujuan_hc.persetujuanAtasan, persetujuan_hc.persetujuanSuperadmin 
            FROM hcc 
            LEFT JOIN persetujuan_hc ON hcc.fpk_selection = persetujuan_hc.fpk_selection 
            $whereClause";

                $result = $connection->query($sql);
              } else {
                echo "Nilai branches tidak ditemukan dalam URL.";
              }

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $no++ . "</td>";
                  echo "<td>" . $row["fpk_selection"] . "</td>";
                  echo "<td>" . $row["nama_kandidat"] . "</td>";
                  echo "<td>" . $row["persetujuanSuperadmin"] . "</td>";

                  // Menentukan warna tombol berdasarkan status persetujuan
                  $buttonColor = ($row["Status_Penyetujuan"] == "Approved") ? "btn-success" : "btn-danger";

                  // Menampilkan tombol dengan warna yang sesuai dan menentukan target modal
                  if ($row["Status_Penyetujuan"] == "Approved") {
                    echo "<td><button type='button' class='btn $buttonColor detail-btn' data-toggle='modal' data-target='#approvedModal" . $row["fpk_selection"] . "'><svg xmlns='http://www.w3.org/2000/svg' width='1.5em' height='1.5em' viewBox='0 0 22 21'>
                                                <rect width='22' height='21' fill='none' />
                                                <path fill='currentColor' d='M19 3h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2m-7 0a1 1 0 0 1 1 1a1 1 0 0 1-1 1a1 1 0 0 1-1-1a1 1 0 0 1 1-1M7 7h10V5h2v14H5V5h2zm.5 6.5L9 12l2 2l4.5-4.5L17 11l-6 6z' />
                                            </svg></button></td>";
                  } else {
                    echo "<td><button type='button' class='btn $buttonColor detail-btn' data-toggle='modal' data-target='#pendingModal" . $row["fpk_selection"] . "'><svg xmlns='http://www.w3.org/2000/svg' width='1.5em' height='1.5em' viewBox='0 0 24 24'>
                                                <rect width='24' height='24' fill='none' />
                                                <path fill='currentColor' d='M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,20a9,9,0,1,1,9-9A9,9,0,0,1,12,21Z' />
                                                <rect width='2' height='7' x='11' y='6' fill='currentColor' rx='1'>
                                                    <animateTransform attributeName='transform' dur='45s' repeatCount='indefinite' type='rotate' values='0 12 12;360 12 12' />
                                                </rect>
                                                <rect width='2' height='9' x='11' y='11' fill='currentColor' rx='1'>
                                                    <animateTransform attributeName='transform' dur='3.75s' repeatCount='indefinite' type='rotate' values='0 12 12;360 12 12' />
                                                </rect>
                                            </svg></button></td>";
                  }

                  // Confirmation Button
                  echo "<td style='white-space: nowrap;'>";
                  echo "<a href='check_hc.php?id_hc=" . urlencode($row["id_hc"]) . "' class='btn btn-warning center-icon'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='1.6em' height='1.4em' viewBox='0 0 21 21'>
                                <path fill='currentColor' d='M3 6v12h10.32a6.4 6.4 0 0 1-.32-2H7a2 2 0 0 0-2-2v-4c1.11 0 2-.89 2-2h10a2 2 0 0 0 2 2v.06c.67 0 1.34.12 2 .34V6zm9 3c-1.7.03-3 1.3-3 3s1.3 2.94 3 3c.38 0 .77-.08 1.14-.23c.27-1.1.72-2.14 1.83-3.16C14.85 10.28 13.59 8.97 12 9m9.63 3.27l-3.87 3.9l-1.35-1.37L15 16.22L17.75 19l5.28-5.32z' />
                            </svg>
                        </a></td>";



                  echo "<td style='white-space: nowrap;'>";
                  // Detail Button
                  echo "<button type='button' class='btn btn-primary detail-btn center-icon' data-toggle='modal' data-target='#detailModal" . $row["fpk_selection"] . "' style='margin-right: 5px;'>
                                               <svg xmlns='http://www.w3.org/2000/svg' width='1.6em' height='1.4em' viewBox='0 0 21 22'>
                                                   <rect width='21' height='22' fill='none' />
                                                   <path fill='currentColor' d='M15 11h7v2h-7zm1 4h6v2h-6zm-2-8h8v2h-8zM4 19h10v-1c0-2.757-2.243-5-5-5H7c-2.757 0-5 2.243-5 5v1zm4-7c1.995 0 3.5-1.505 3.5-3.5S9.995 5 8 5S4.5 6.505 4.5 8.5S6.005 12 8 12' />
                                               </svg>
                                           </button>";
                  // Print Button
                  echo "<button type='button' class='btn btn-success print-btn' onclick='printHC(" . $row["id_hc"] . ")'><svg xmlns='http://www.w3.org/2000/svg' width='1.2em' height='1.2em' viewBox='0 0 512 512'>
                                            <rect width='512' height='512' fill='none' />
                                            <path fill='currentColor' d='M384 362.7H128V384h256zM106.7 21.3h192V128h106.7v42.7h21.3v-64L320 0H85.3v170.7h21.3V21.3zM448 192H64c-42.7 0-64 21.3-64 64v128h85.3v128h341.3V384H512V256c0-42.7-21.3-64-64-64M85.3 277.3H42.7v-42.7h42.7v42.7zm320 213.4H106.7V341.3h298.7v149.4zM384 405.3H128v21.3h256zm0 42.7H128v21.3h256z' />
                                            </svg></button>";
                  echo "</td>";
                  echo "</tr>";

                  // Ambil data nama penyetuju dari tabel approval berdasarkan branch
                  $branch = $row["branch"];
                  $fpk_selection = $row["fpk_selection"];
                  $approvalSql = "SELECT * FROM approval WHERE branch = '$branch'";
                  $approvalResult = $connection->query($approvalSql);
                  $approvalData = $approvalResult->fetch_assoc();

                  // Modal untuk setiap baris dengan persetujuan "Approved"
                  echo "<div class='modal fade' id='approvedModal" . $row["fpk_selection"] . "' tabindex='-1' role='dialog' aria-labelledby='approvedModalLabel' aria-hidden='true'>";
                  echo "<div class='modal-dialog' role='document'> ";
                  echo "<div class='modal-content'>";
                  echo "<div class='modal-header'>";
                  echo "<h5 class='modal-title' id='approvedModalLabel'>Detail Approved</h5>";
                  echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                  echo "<span aria-hidden='true'>&times;</span>";
                  echo "</button>";
                  echo "</div>";
                  echo "<div class='modal-body'>";
                  // Tambahkan detail yang relevan di sini
                  echo "<p>Persetujuan Depthead: " . $row["persetujuanUser"] . " | " . $approvalData["user"] . " | " . $row["tglUser"] . "</p>";
                  echo "<p>Persetujuan HR Unit: " . $row["persetujuanAdmin"] . " | " . $approvalData["hrunit"] . " | " . $row["tglAdmin"] . "</p>";
                  echo "<p>Persetujuan Direksi (1): " . $row["persetujuanAtasan"] . " | " . $approvalData["direksi1"] . " | " . $row["tglAtasan"] . "</p>";
                  echo "<p>Persetujuan Direksi (2): " . $row["persetujuanDireksi2"] . " | " . $approvalData["direksi2"] . " | " . $row["tglDireksi2"] . "</p>";
                  echo "<p>Persetujuan Direksi (3): " . $row["persetujuanDireksi3"] . " | " . $approvalData["direksi3"] . " | " . $row["tglDireksi3"] . "</p>";
                  echo "<p>Persetujuan Presdir: " . $row["persetujuanPresdir"] . " | " . $approvalData["presdir"] . " | " . $row["tglPresdir"] . "</p>";
                  echo "<p>Persetujuan Corp HR: " . $row["persetujuanCorpHr"] . " | " . $approvalData["corphr"] . " | " . $row["tglCorpHr"] . "</p>";
                  echo "<p>Persetujuan Super Admin: " . $row["persetujuanSuperadmin"] . " | " . $approvalData["superadmin"] . " | " . $row["tglSuperadmin"] . "</p>";
                  echo "</div>";
                  echo "<div class='modal-footer'>";
                  echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
                  echo "</div>";
                  echo "</div>";
                  echo "</div>";
                  echo "</div>";

                  // Modal untuk setiap baris dengan persetujuan "Pending"
                  echo "<div class='modal fade' id='pendingModal" . $row["fpk_selection"] . "' tabindex='-1' role='dialog' aria-labelledby='pendingModalLabel' aria-hidden='true'>";
                  echo "<div class='modal-dialog' role='document'>";
                  echo "<div class='modal-content'>";
                  echo "<div class='modal-header'>";
                  echo "<h5 class='modal-title' id='pendingModalLabel'>Detail Pending</h5>";
                  echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                  echo "<span aria-hidden='true'>&times;</span>";
                  echo "</button>";
                  echo "</div>";
                  echo "<div class='modal-body'>";
                  // Tambahkan detail yang relevan di sini
                  echo "<p>Persetujuan Depthead: " . $row["persetujuanUser"] . " | " . $approvalData["user"] . " | " . $row["tglUser"] . "</p>";
                  echo "<p>Persetujuan HR Unit: " . $row["persetujuanAdmin"] . " | " . $approvalData["hrunit"] . " | " . $row["tglAdmin"] . "</p>";
                  echo "<p>Persetujuan Direksi (1): " . $row["persetujuanAtasan"] . " | " . $approvalData["direksi1"] . " | " . $row["tglAtasan"] . "</p>";
                  echo "<p>Persetujuan Direksi (2): " . $row["persetujuanDireksi2"] . " | " . $approvalData["direksi2"] . " | " . $row["tglDireksi2"] . "</p>";
                  echo "<p>Persetujuan Direksi (3): " . $row["persetujuanDireksi3"] . " | " . $approvalData["direksi3"] . " | " . $row["tglDireksi3"] . "</p>";
                  echo "<p>Persetujuan Presdir: " . $row["persetujuanPresdir"] . " | " . $approvalData["presdir"] . " | " . $row["tglPresdir"] . "</p>";
                  echo "<p>Persetujuan Corp HR: " . $row["persetujuanCorpHr"] . " | " . $approvalData["corphr"] . " | " . $row["tglCorpHr"] . "</p>";
                  echo "<p>Persetujuan Super Admin: " . $row["persetujuanSuperadmin"] . " | " . $approvalData["superadmin"] . " | " . $row["tglSuperadmin"] . "</p>";
                  echo "</div>";
                  echo "<div class='modal-footer'>";
                  echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
                  echo "</div>";
                  echo "</div>";
                  echo "</div>";
                  echo "</div>";
                }
              } else {
                echo "<tr><td colspan='39'>Tidak ada data yang tersedia</td></tr>";
              }

              // Menutup koneksi database
              $connection->close();
              ?>


              <script>
                function printHC(id, persetujuanAdmin) {
                  // Tambahkan nilai id_fpk dan persetujuanAdmin ke URL
                  var url = 'print_format.php?fpk_selection=' + id + '&persetujuanAdmin=' + persetujuanAdmin;

                  // Lakukan permintaan AJAX untuk mendapatkan konten dari print_format.php dengan id_fpk di URL
                  $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                      // Buat jendela cetak baru dengan konten dari print_format.php
                      var printContents = response;
                      var originalContents = document.body.innerHTML;
                      document.body.innerHTML = printContents;
                      // Cetak jendela
                      window.print();
                      // Kembalikan konten asli ke halaman
                      document.body.innerHTML = originalContents;
                    },
                    error: function(xhr, status, error) {
                      // Tangani error jika terjadi
                      console.error(xhr.responseText);
                      alert('Terjadi kesalahan saat mencetak.');
                    }
                  });
                }
              </script>

            </tbody>

          </table>

        </div>
      </div>
    </div>
  </div>
  <?php
  // Modal untuk setiap baris
  include('koneksi.php');
  $sql = "SELECT * FROM hcc";
  $result = $connection->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $modalId = htmlspecialchars($row["fpk_selection"]); // Ensure the ID is safe for use

      echo "<div class='modal fade' id='detailModal" . $modalId . "' tabindex='-1' role='dialog' aria-labelledby='detailModalLabel" . $modalId . "' aria-hidden='true'>";
      echo "<div class='modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered' role='document'>";
      echo "<div class='modal-content' style='border-radius: 15px;'>";
      echo "<div class='modal-header' style='background-color: #007BFF; z-index: 1050;'>";
      echo "<h5 class='modal-title text-white' id='detailModalLabel" . $modalId . "'>Detail Request HC</h5>";
      echo "<button type='button' class='close custom-button' data-dismiss='modal' aria-label='Close'>";
      echo "<span aria-hidden='true'>&times;</span>";
      echo "</button>";
      echo "</div>";
      echo "<div class='modal-body'>";
      echo "<div class='row'>";
      echo "<div class='col-md-6'>";
      echo "<table class='table' style='margin-top: -40px'>";
      echo "<tr><td colspan='2'>&nbsp;</td></tr>";
      echo "<tr><th colspan='2' style='text-align: center;'>Detail Permintaan</th></tr>";
      echo "<tr><td colspan='2'>&nbsp;</td></tr>";
      echo "<tr><th>Kode HC</th><td>" . $modalId . "</td></tr>";
      echo "<tr><th>Nama Kandidat</th><td>" . htmlspecialchars($row["nama_kandidat"]) . "</td></tr>";
      echo "<tr><th>Bisnis</th><td>" . htmlspecialchars($row["branch"]) . "</td></tr>";
      echo "<tr><th>Organisasi</th><td>" . htmlspecialchars($row["organisasi"]) . "</td></tr>";
      echo "<tr><th>Golongan</th><td>" . htmlspecialchars($row["golongan"]) . "</td></tr>";
      echo "<tr><th>Jabatan</th><td>" . htmlspecialchars($row["jabatan"]) . "</td></tr>";
      echo "<tr><th>Jenis Permintaan</th><td>" . htmlspecialchars($row["alasan_penerimaan"]) . "</td></tr>";
      echo "<tr><th>Tanggal Permintaan</th><td>" . htmlspecialchars($row["form_tanggal_lengkap"]) . "</td></tr>";
      echo "<tr><th>Catatan</th><td>" . htmlspecialchars($row["form_catatan"]) . "</td></tr>";
      echo "<tr><th>No. KTP</th><td>" . htmlspecialchars($row["no_ktp"]) . "</td></tr>";
      echo "<tr><th>Pendidikan</th><td>" . htmlspecialchars($row["pendidikan"]) . "</td></tr>";
      echo "</table>";
      echo "</div>";
      echo "<div class='col-md-6'>";
      echo "<table class='table' style='margin-top: -40px'>";
      echo "<tr><td colspan='2'>&nbsp;</td></tr>";
      echo "<tr><th colspan='2' style='text-align: center;'>Detail Gaji</th></tr>";
      echo "<tr><td colspan='2'>&nbsp;</td></tr>";
      echo "<tr><th>Gaji Pokok</th><td>" . htmlspecialchars($row["gaji_pokok"]) . "</td></tr>";
      echo "<tr><th>Tunjangan Makan</th><td>" . htmlspecialchars($row["tunjangan_makan"]) . "</td></tr>";
      echo "<tr><th>Tunjangan Transport</th><td>" . htmlspecialchars($row["tunjangan_transport"]) . "</td></tr>";
      echo "<tr><th>Tunjangan Kendaraan</th><td>" . htmlspecialchars($row["tunjangan_kendaraan"]) . "</td></tr>";
      echo "<tr style='background-color: #E5E4E2;'><th>Total Sallary Gross</th><td>" . htmlspecialchars($row["total_sallary_gross"]) . "</td></tr>";
      echo "<tr><th>BPJS Jaminan Hari Tua</th><td>" . htmlspecialchars($row["bpjs_jht"]) . "</td></tr>";
      echo "<tr><th>BPJS Jaminan Pensiun</th><td>" . htmlspecialchars($row["bpjs_jp"]) . "</td></tr>";
      echo "<tr><th>BPJS Kesehatan</th><td>" . htmlspecialchars($row["bpjs_ks"]) . "</td></tr>";
      echo "<tr><th>Koperasi Karyawan</th><td>" . htmlspecialchars($row["koperasi_karyawan"]) . "</td></tr>";
      echo "<tr style='background-color: #E5E4E2;'><th>Total Sallary Nett</th><td>" . htmlspecialchars($row["total_sallary_nett"]) . "</td></tr>";
      echo "</table>";
      echo "</div>";
      echo "</div>";
      echo "<div class='col-md-12 mt-5'>";
      echo "<table class='table' style='margin-top: -40px'>";
      echo "<tr><th colspan='2' style='text-align: center;'>Kelengkapan Dokumen</th></tr>";
      echo "<tr><td colspan='2'>&nbsp;</td></tr>";
      echo "</table>";
      echo "</div>";
      echo "<div class='row'>";
      echo "<div class='col-md-6'>";
      echo "<table class='table' style='margin-top: -40px'>";
      echo "<tr><th>Form Aplikasi</th><td>" . htmlspecialchars($row["form_aplikasi"]) . "</td></tr>";
      echo "<tr><th>Pas Foto</th><td>" . htmlspecialchars($row["pas_foto"]) . "</td></tr>";
      echo "<tr><th>Form Interview User</th><td>" . htmlspecialchars($row["form_interview_user"]) . "</td></tr>";
      echo "<tr><th>Foto KTP</th><td>" . htmlspecialchars($row["foto_ktp"]) . "</td></tr>";
      echo "<tr><th>Form Interview HR</th><td>" . htmlspecialchars($row["form_interview_hr"]) . "</td></tr>";
      echo "<tr><th>Foto Ijazah</th><td>" . htmlspecialchars($row["foto_ijazah"]) . "</td></tr>";
      echo "<tr><th>Form Hasil Psikotest</th><td>" . htmlspecialchars($row["form_hasil_psikotest"]) . "</td></tr>";
      echo "<tr><th>Foto Transkip Nilai</th><td>" . htmlspecialchars($row["foto_transkip_nilai"]) . "</td></tr>";
      echo "</table>";
      echo "</div>";
      echo "<div class='col-md-6'>";
      echo "<table class='table' style='margin-top: -40px'>";
      echo "<tr><th>Form Confirmation Letter</th><td>" . htmlspecialchars($row["form_confirmation_letter"]) . "</td></tr>";
      echo "<tr><th>Foto Buku tabungan</th><td>" . htmlspecialchars($row["foto_buku_tabungan"]) . "</td></tr>";
      echo "<tr><th>Form Hasil Tes Kesehatan</th><td>" . htmlspecialchars($row["form_hasil_tes_kesehatan"]) . "</td></tr>";
      echo "<tr><th>Foto NPWP</th><td>" . htmlspecialchars($row["foto_npwp"]) . "</td></tr>";
      echo "<tr><th>Form Referensi Kerja</th><td>" . htmlspecialchars($row["referensi_kerja"]) . "</td></tr>";
      echo "<tr><th>Foto Kartu Keluarga</th><td>" . htmlspecialchars($row["foto_kk"]) . "</td></tr>";
      echo "<tr><th>Foto Sertifikat</th><td>" . htmlspecialchars($row["foto_sertifikat"]) . "</td></tr>";
      echo "<tr><th>BPJS Ketenagakerjaan</th><td>" . htmlspecialchars($row["bpjs_ketenagakerjaan"]) . "</td></tr>";
      echo "<tr><th>BPJS Jaminan Pensiun</th><td>" . htmlspecialchars($row["bpjs_jaminan_pensiun"]) . "</td></tr>";
      echo "<tr><th>BPJS Kesehatan</th><td>" . htmlspecialchars($row["bpjs_kesehatan"]) . "</td></tr>";
      echo "</table>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
      echo "<div class='modal-footer'>";
      echo "<button type='button' class='btn btn-danger reject-btn' data-id='" . $modalId . "'>Reject <svg xmlns='http://www.w3.org/2000/svg' width='1.2em' height='1.2em' viewBox='0 0 36 36'>
        <rect width='36' height='36' fill='none' />
        <path fill='currentColor' d='M24.879 2.879A3 3 0 1 1 29.12 7.12l-8.79 8.79a.125.125 0 0 0 0 .177l8.79 8.79a3 3 0 1 1-4.242 4.243l-8.79-8.79a.125.125 0 0 0-.177 0l-8.79 8.79a3 3 0 1 1-4.243-4.242l8.79-8.79a.125.125 0 0 0 0-.177l-8.79-8.79A3 3 0 0 1 7.12 2.878l8.79 8.79a.125.125 0 0 0 .177 0z' />
    </svg></button>";
      // Menambahkan tombol Reject
      echo "<button type='button' class='btn btn-primary approve-btn' data-id='" . $modalId . "' data-persetujuansuperadmin='" . $row["persetujuanSuperadmin"] . "'>Approve <svg xmlns='http://www.w3.org/2000/svg' width='1.2em' height='1.2em' viewBox='0 0 24 24'>
        <rect width='24' height='24' fill='none' />
        <g fill='none' fill-rule='evenodd'>
            <path d='M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z' />
            <path fill='currentColor' d='M21.546 5.111a1.5 1.5 0 0 1 0 2.121L10.303 18.475a1.6 1.6 0 0 1-2.263 0L2.454 12.89a1.5 1.5 0 1 1 2.121-2.121l4.596 4.596L19.424 5.111a1.5 1.5 0 0 1 2.122 0' />
        </g>
    </svg></button>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
    }
  }

  ?>
  <!-- Menyertakan pustaka jQuery dan Bootstrap untuk modal dan lainnya -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });

    $('#toggler').click(function() {
      $('#sidebar').toggleClass('active');
    });
  </script>
  <script>
    // Fungsi untuk menyetujui persetujuan
    $('.approve-btn').click(function() {
      var id = $(this).data('id'); // Mendapatkan ID FPK dari tombol yang ditekan
      var button = $(this); // Simpan konteks tombol

      // Lakukan permintaan AJAX untuk mengupdate kolom persetujuan di tabel
      $.ajax({
        url: 'update_persetujuam.php',
        method: 'POST',
        data: {
          id: id
        },
        success: function(response) {
          // Tampilkan alert ketika update berhasil
          alert('Persetujuan berhasil disetujui.');
          // Tutup modal setelah diklik OK pada alert

          $('#detailModal' + id).modal('hide');

          // Simpan nilai persetujuanAdmin dari tombol
          var persetujuanSuperadmin = button.data('persetujuansuperadmin');

        },
        error: function(xhr, status, error) {
          // Tangani error jika terjadi
          console.error(xhr.responseText);
          alert('Terjadi kesalahan saat menyetujui persetujuan.');
        }
      });
    });

    // Menambahkan event listener untuk modal yang menutup
    $(document).on('hidden.bs.modal', '.modal', function() {
      location.reload(); // Reload halaman ketika modal ditutup
    });
  </script>
</body>

</html>