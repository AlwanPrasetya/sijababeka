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
include('koneksi.php');

$query = "SELECT * FROM applicants WHERE level_candidates = 2";
$result = mysqli_query($connection, $query);
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
  <title>Data Hiring Positions</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <style>
    body {
      background-color: #EAFAF1;
    }

    .container {
      padding: 0.1px;
    }

    .card {
      border-radius: 20px;
      height: auto;
      width: 100%;
      box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
      position: relative;
    }

    .top-left-button {
      position: absolute;
      top: 20px;
      left: 20px;
    }

    .card-footer {
      position: absolute;
      bottom: 20px;
      right: 20px;
      left: 20px;
    }

    /* Warna header modal */
    .modal-header {
      background-color: yellowgreen;
      /* Ganti dengan warna yang Anda inginkan */
      color: white;
      /* Warna teks di dalam header modal */
      border-radius: 10px 10px 0 0;
      /* Sudut yang dibulatkan hanya di bagian atas */
    }

    .modal-content {
      border-radius: 10px 10px 10px 10px;

    }

    /* Tombol close pada header modal */
    .modal-header .close {
      color: white;
      /* Warna ikon close */
    }

    .submitPelamar {
      background-color: yellowgreen;
    }
  </style>
</head>

<body>

  <a href="hiringPositions.php?id=<?php echo $userId; ?>&branches=<?php echo $branches; ?>" class="top-left-button">
    <img src="../img/left-arrow.png " alt="" style="width: 40px; height: 40px; margin: 15px 15px;">
  </a>
  <!-- modal aktif dan latar belakang redup -->
  <div id="modalBackdrop" style="display: none; position: fixed; z-index: 999; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);"></div>

  <!-- Modal untuk form input data pelamar -->
  <div id="modalTambahPelamar" class="modal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Applicants</h5>
          <button type="button" id="btnClsTambahPelamar" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <style>
            label {
              display: block;
              margin-bottom: 5px;
            }

            input[type="text"],
            input[type="email"],
            input[type="tel"],
            input[type="date"] {
              width: 100%;
              padding: 8px;
              margin-bottom: 15px;
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
          </style>
          <!-- Formulir input data pelamar -->
          <div class="container">
            <form action="proses_form.php" method="POST" id="myForm">
              <!-- Hidden field untuk ID Candidates -->
              <input type="hidden" id="kodeFPK" name="kodeFPK" value="<?php echo htmlspecialchars($kodeFPK); ?>">
              <input type="hidden" id="id_candidates" name="id_candidates">

              <label for="nama">Nama:</label>
              <input type="text" id="nama" name="nama" required>

              <label for="email">Email:</label>
              <input type="email" id="email" name="email" required>

              <label for="wa">Nomor WhatsApp:</label>
              <input type="tel" id="wa" name="wa" pattern="[0-9]{9,15}" required placeholder="Format: 628123456789">

              <label for="tgl_lahir">Tanggal Lahir:</label>
              <input type="date" id="tgl_lahir" name="tgl_lahir" required>

              <input type="submit" value="Submit">
            </form>
          </div>
          <script>
            // Generate unique ID for id_candidates
            document.addEventListener('DOMContentLoaded', function() {
              var idCandidatesField = document.getElementById('id_candidates');
              idCandidatesField.value = generateUniqueId('ID-');
            });

            // Function to generate unique ID
            function generateUniqueId(prefix) {
              return prefix + Math.random().toString(36).substr(2, 9); // Adjust length as needed
            }
          </script>
        </div>
      </div>
    </div>
  </div>

  <div class="container-content">
    <div class="container" style="margin-top: 80px">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header" style="background-color: #008F4D; color: white; display: flex; align-items: center; padding: 10px;">
              <div class="title" style="padding: 5px; margin-right: 10px;">DATA INTERVIEW USER</div>
              <div class="posisi" style="background-color: #006F3D; padding: 5px;"><?php echo $posisi; ?></div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" style="white-space: nowrap; overflow:hidden; text-overflow:ellipsis;">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>No. WhatsApp</th>
                      <th>Move Stage</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                      // Periksa apakah kodeFPK pada baris saat ini sama dengan kodeFPK yang diterima dari URL
                      if ($row['kodeFPK'] == $_GET['KodeFPK']) {
                        echo "<tr>";
                        echo "<td><a href='candidates.php?id_biodata=" . $row['id'] . "&id=" . $userId . "&branches=" . $branches . "&posisi=" . $posisi . "&KodeFPK=" . $kodeFPK . "' style='color: darkgreen; font-weight: bold;'>" . $row['nama'] . "</a></td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['wa'] . "</td>";
                        echo "<td>
            <form action='move_interview_user.php' method='POST' style='display:inline;'>
                <input type='hidden' name='id' value='" . $row['id'] . "' />
                <button type='submit' name='moveInterviewUser' class='btn-move'>Move</button>
            </form>
        </td>";
                        echo "</tr>";
                      }
                    }
                    ?>
                  </tbody>
                  <style>
                    /* Gaya untuk tombol "Move to" */
                    button {
                      background-color: #4CAF50;
                      /* Warna latar belakang hijau */
                      color: white;
                      /* Warna teks putih */
                      padding: 5px 10px;
                      /* Padding dalam tombol */
                      text-align: center;
                      /* Perataan teks */
                      text-decoration: none;
                      /* Menghilangkan garis bawah */
                      display: inline-block;
                      /* Membuat tombol inline-block */
                      font-size: 14px;
                      /* Ukuran font */
                      margin: 2px 2px;
                      /* Margin sekitar tombol */
                      cursor: pointer;
                      /* Mengubah kursor saat dihover */
                      border: none;
                      /* Menghilangkan border */
                      border-radius: 5px;
                      /* Membuat ujung tombol melengkung */
                      /* transition-duration: 0.2s; */
                      /* Transisi untuk efek hover */
                    }

                    /* Efek hover untuk tombol */
                    button:hover {
                      /* background-color: white; */
                      /* Warna latar belakang saat dihover */
                      color: black;
                      /* Warna teks saat dihover */
                      border: 1px solid #4CAF50;
                      /* Menambahkan border hijau saat dihover */
                    }
                  </style>

                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
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
  // Fungsi untuk menampilkan modal dan latar belakang gelap saat tombol "Tambah Pelamar" ditekan
  document.getElementById('btnTambahPelamar').addEventListener('click', function() {
    document.getElementById('modalBackdrop').style.display = 'block';
    document.getElementById('modalTambahPelamar').style.display = 'block';
  });

  // Fungsi untuk menyembunyikan modal dan latar belakang gelap saat tombol "Close" pada modal ditekan
  document.getElementById('btnClsTambahPelamar').addEventListener('click', function() {
    document.getElementById('modalBackdrop').style.display = 'none';
    document.getElementById('modalTambahPelamar').style.display = 'none';
  });
</script>


</html>