<html>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<?php
// Lakukan koneksi ke database di sini
// Gantilah parameter koneksi dengan informasi yang sesuai
include('koneksi.php');

// Fungsi untuk memeriksa keunikan kode
function isKodeUnique($kode, $koneksi)
{
    $query = "SELECT COUNT(*) as total FROM bisnis WHERE nama_kode = '$kode'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] == 0;
}

// ...

// Pada bagian penyimpanan data (save_bisnis.php), tambahkan kode untuk memeriksa keunikan kode sebelum menyimpan data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kode = $_POST['nama_kode'];
    $nama_unit = $_POST['nama_unit'];

    // Periksa keunikan kode sebelum menyimpan data
    if (!isKodeUnique($nama_kode, $koneksi)) {
        echo "Kode sudah ada dalam database. Harap gunakan kode yang berbeda.";
        exit();
    }

    // Lakukan penyimpanan data jika kode unik
    // ...
}

?>
<?php
include('koneksi.php');

if (isset($_GET['nama_unit'])) {
    $branch = $_GET['nama_unit'];

    // Query untuk mengambil nilai hrunit, direksi3, presdir, corphr, superadmin berdasarkan branch
    $sql = "SELECT hrunit, direksi3, presdir, corphr, superadmin FROM bisnis WHERE nama_unit = '$branch'";
    $result = $connection->query($sql);

    // Inisialisasi array untuk menyimpan hasil
    $values = array();

    // Periksa apakah query berhasil dieksekusi
    if ($result && $result->num_rows > 0) {
        // Ambil baris hasil
        $row = $result->fetch_assoc();
        // Simpan nilai ke dalam array
        $values['hrunit'] = $row['hrunit'];
        $values['direksi3'] = $row['direksi3'];
        $values['presdir'] = $row['presdir'];
        $values['corphr'] = $row['corphr'];
        $values['superadmin'] = $row['superadmin'];
    }

    // Kembalikan nilai dalam bentuk JSON
    echo json_encode($values);
}

// Menutup koneksi database
$connection->close();
?>

<!-- HTML body section -->


<?php
include('sidebar.php');
?>
<div class="container-content">
    <div class="container">
        <h2 class="text-center mt-0 mb-4">ACCESS ROLE & APPROVAL LINE</h2>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header" style="background-color: #008F4D; color: white;">
                        TAMBAH APPROVAL LINE
                    </div>
                    <div class="card-body">
                        <form action="save.php" method="POST" onsubmit="return validateForm()">
                            <div class="form-group">
                                <label for="branch">Branch</label>
                                <select id="branch" name="branch" class="form-control" required>
                                    <option value="">Pilih Branch *</option>
                                    <?php
                                    // Koneksi ke database
                                    include('koneksi.php');

                                    // SQL untuk mengambil data dari tabel bisnis
                                    $sql = "SELECT nama_unit FROM bisnis";
                                    $result = $connection->query($sql);

                                    // Periksa apakah ada hasil yang ditemukan
                                    if ($result->num_rows > 0) {
                                        // Output data dari setiap baris
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row["nama_unit"] . '">' . $row["nama_unit"] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">Data tidak tersedia</option>';
                                    }

                                    // Menutup koneksi database
                                    $connection->close();
                                    ?>
                                </select>
                            </div>

                            <style>
                                .row-satu {
                                    display: flex;
                                    justify-content: space-between;
                                }

                                .row-user {
                                    width: 45%;
                                    /* Sesuaikan lebar sesuai kebutuhan */
                                }
                            </style>

                            <div class="row-satu">
                                <div class="row-user" style="margin-left: 22px;">
                                    <label for="user">User *</label><br>
                                    <select id="user" name="user" class="select2" required>
                                        <option value="">Pilih User</option>
                                        <?php
                                        // Koneksi ke database
                                        include('koneksi.php');

                                        // SQL untuk mengambil data dari tabel karyawan dan mengurutkannya berdasarkan nama
                                        $sql = "SELECT nama FROM karyawan ORDER BY nama ASC";
                                        $result = $connection->query($sql);

                                        // Periksa apakah ada hasil yang ditemukan
                                        if ($result->num_rows > 0) {
                                            // Output data dari setiap baris
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . $row["nama"] . '">' . $row["nama"] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">Data tidak tersedia</option>';
                                        }

                                        // Menutup koneksi database
                                        $connection->close();
                                        ?>

                                    </select>
                                </div>

                                <div class="row-user" style="margin-right: 22px;">
                                    <label for="hrunit">HR Unit *</label>
                                    <input id="hrunit" name="hrunit" class="form-control" placeholder="Pilih branch terlebih dahulu" 22px required>
                                    </input>
                                </div>
                            </div>
                            <br>

                            <style>
                                .direksi-container {
                                    display: flex;
                                    justify-content: space-between;
                                }

                                .direksi-select {
                                    width: 45%;
                                    /* Sesuaikan lebar sesuai kebutuhan */
                                }
                            </style>

                            <div class="direksi-container">
                                <div class="direksi-select" style="margin-left: 22px;">
                                    <label for="direksi1">Direksi 1</label><br>
                                    <select id="direksi1" name="direksi1" class="select2">
                                        <option value="">Pilih Direksi 1</option>
                                        <?php
                                        // Koneksi ke database
                                        include('koneksi.php');

                                        // SQL untuk mengambil data dari tabel karyawan dan mengurutkannya berdasarkan nama
                                        $sql = "SELECT nama FROM karyawan ORDER BY nama ASC";
                                        $result = $connection->query($sql);

                                        // Periksa apakah ada hasil yang ditemukan
                                        if ($result->num_rows > 0) {
                                            // Output data dari setiap baris
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . $row["nama"] . '">' . $row["nama"] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">Data tidak tersedia</option>';
                                        }

                                        // Menutup koneksi database
                                        $connection->close();
                                        ?>
                                    </select>
                                </div>

                                <div class="direksi-select" style="margin-right: 22px;">
                                    <label for="direksi2">Direksi 2</label><br>
                                    <select id="direksi2" name="direksi2" class="select2">
                                        <option value="">Pilih Direksi 2</option>
                                        <?php
                                        // Koneksi ke database (disarankan menggunakan include('koneksi.php'); di bagian atas)
                                        include('koneksi.php');

                                        // SQL untuk mengambil data dari tabel karyawan dan mengurutkannya berdasarkan nama
                                        $sql = "SELECT nama FROM karyawan ORDER BY nama ASC";
                                        $result = $connection->query($sql);

                                        // Periksa apakah ada hasil yang ditemukan
                                        if ($result->num_rows > 0) {
                                            // Output data dari setiap baris
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . $row["nama"] . '">' . $row["nama"] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">Data tidak tersedia</option>';
                                        }

                                        // Menutup koneksi database
                                        $connection->close();
                                        ?>
                                    </select>
                                </div>
                            </div><br>

                            <style>
                                .row-dua {
                                    display: flex;
                                    justify-content: space-between;

                                }

                                .row-presdir {
                                    width: 45%;
                                }
                            </style>
                            <div class="row-dua">
                                <div class="row-presdir" style="margin-left: 22px;">
                                    <label for="direksi3">Direksi 3 *</label>
                                    <input id="direksi3" name="direksi3" class="form-control" placeholder="Pilih branch terlebih dahulu" 22px required>
                                    </input>
                                </div>

                                <div class="row-presdir" style="margin-right: 22px;">
                                    <label for="presdir">Presdir *</label>
                                    <input id="presdir" name="presdir" class="form-control" placeholder="Pilih branch terlebih dahulu" 22px required>
                                    <inputt>
                                </div>
                            </div>
                            <br>
                            <style>
                                .corphr {
                                    display: flex;
                                    justify-content: space-between;
                                }

                                .row-tiga {
                                    width: 45%;
                                }
                            </style>
                            <div class="corphr">
                                <div class="row-tiga" style="margin-left: 22px;">
                                    <label for="corphr">Corp HR *</label>
                                    <input id="corphr" name="corphr" class="form-control" placeholder="Pilih branch terlebih dahulu" 22px required>
                                    <inputt>
                                </div>

                                <div class="row-tiga" style="margin-right: 22px;">
                                    <label for="superadmin">Super Admin *</label>
                                    <input id="superadmin" name="superadmin" class="form-control" placeholder="Pilih branch terlebih dahulu" 22px required>
                                    </input>
                                </div>
                            </div>
                            <br>

                            <input type="text" name="username" placeholder="Username" hidden>
                            <input type="password" name="password" placeholder="Password" hidden>


                            <!-- Tombol Submit -->
                            <div class="text-right">
                                <button type="reset" class="btn btn-secondary mt-3 ml-2"><svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 48 48">
                                        <rect width="48" height="48" fill="none" />
                                        <defs>
                                            <mask id="ipTClearFormat0">
                                                <g fill="none" stroke="#fff">
                                                    <path fill="#555" stroke-linejoin="round" stroke-width="4.3" d="M44.782 24.17L31.918 7.1L14.135 20.5L27.5 37l3.356-2.336z" />
                                                    <path stroke-linejoin="round" stroke-width="4.3" d="m27.5 37l-3.839 3.075l-10.563-.001l-2.6-3.45l-6.433-8.536L14.5 20.225" />
                                                    <path stroke-linecap="round" stroke-width="4.5" d="M13.206 40.072h31.36" />
                                                </g>
                                            </mask>
                                        </defs>
                                        <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipTClearFormat0)" />
                                    </svg></button>
                                <button type="submit" class="btn btn-primary mt-3"><svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox=" 20 20">
                                        <rect width="20" height="20" fill="none" />
                                        <path fill="currentColor" d="M5 5v14h14V7.83L16.17 5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3s3 1.34 3 3s-1.34 3-3 3m3-8H6V6h9z" opacity="0.3" />
                                        <path fill="currentColor" d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V7zm2 16H5V5h11.17L19 7.83zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3M6 6h9v4H6z" />
                                    </svg></button>
                            </div>
                        </form>

                        <script>
                            function validateForm() {
                                var branch = document.getElementById('branch').value;
                                var user = document.getElementById('user').value;
                                var hrunit = document.getElementById('hrunit').value;
                                // var direksi1 = document.getElementById('direksi1').value;
                                // var direksi2 = document.getElementById('direksi2').value;
                                var direksi3 = document.getElementById('direksi3').value;
                                var corphr = document.getElementById('corphr').value;
                                var superadmin = document.getElementById('superadmin').value;

                                // Periksa apakah salah satu dropdown kosong
                                if (branch === "" || user === "" || hrunit === "" || direksi3 === "" || corphr === "" || superadmin === "") {
                                    alert("Semua kolom harus diisi.");
                                    return false; // Form tidak akan disubmit jika ada dropdown yang kosong
                                }
                                return true; // Form akan disubmit jika semua dropdown terisi
                            }

                            // Tambahkan event listener ke dropdown "Branch"
                            document.getElementById('branch').addEventListener('change', function() {
                                // Ambil nilai yang dipilih
                                var selectedBranch = this.value;

                                // Buat objek XMLHttpRequest
                                var xhr = new XMLHttpRequest();

                                // Set endpoint URL
                                var url = 'script.php?branch=' + selectedBranch;

                                // Set metode HTTP request
                                xhr.open('GET', url, true);

                                // Atur callback untuk menangani respon dari server
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === 4 && xhr.status === 200) {
                                        // Ambil data JSON dari respons
                                        var response = JSON.parse(xhr.responseText);

                                        // Isi nilai kolom isian dengan nilai yang diperoleh dari server
                                        document.getElementById('hrunit').value = response.hrunit;
                                        document.getElementById('direksi3').value = response.direksi3;
                                        document.getElementById('presdir').value = response.presdir;
                                        document.getElementById('corphr').value = response.corphr;
                                        document.getElementById('superadmin').value = response.superadmin;
                                    }
                                };

                                // Kirim permintaan ke server
                                xhr.send();
                            });
                        </script>

                        <script>
                            function clearOtherOptions(selectedValue) {
                                var dropdowns = document.querySelectorAll('select');

                                // Loop melalui setiap dropdown
                                dropdowns.forEach(function(dropdown) {
                                    // Periksa jika dropdown bukan dropdown yang sama dengan yang dipilih
                                    if (dropdown.id !== selectedValue.id) {
                                        // Loop melalui setiap opsi
                                        dropdown.querySelectorAll('option').forEach(function(option) {
                                            // Hapus opsi jika nilainya sama dengan yang dipilih di dropdown pertama
                                            if (option.value === selectedValue.value) {
                                                option.remove();
                                            }
                                        });
                                    }
                                });
                            }

                            document.addEventListener('DOMContentLoaded', function() {
                                var branchDropdown = document.getElementById('branch');

                                // Tambahkan event listener untuk dropdown "Branch"
                                branchDropdown.addEventListener('change', function() {
                                    var selectedBranch = this.value;
                                    var xhr = new XMLHttpRequest();
                                    xhr.open('GET', 'script.php?branch=' + selectedBranch, true);

                                    xhr.onload = function() {
                                        if (xhr.status == 200) {
                                            // Parse JSON response
                                            var response = JSON.parse(xhr.responseText);

                                            // Isi nilai dropdown HR Unit
                                            document.getElementById('hrunit').value = response.hrunit;
                                            // Isi nilai dropdown Direksi 3
                                            document.getElementById('direksi3').value = response.direksi3;
                                            // Isi nilai dropdown Presdir
                                            document.getElementById('presdir').value = response.presdir;
                                            // Isi nilai dropdown Corp HR
                                            document.getElementById('corphr').value = response.corphr;
                                            // Isi nilai dropdown Super Admin
                                            document.getElementById('superadmin').value = response.superadmin;
                                        }
                                    };

                                    xhr.send();
                                });
                            });
                        </script>



                    </div>
                </div>
            </div>
        </div>

        <div class="container" style="margin-top: 80px">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #008F4D; color: white;">
                            DATA BISNIS
                        </div>
                        <div class="card-body">
                            <div class="table-wrapper">
                                <table class="table table-bordered" id="myTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">NO.</th>
                                            <th scope="col">BRANCH</th>
                                            <th scope="col">USER</th>
                                            <th scope="col">HR UNIT</th>
                                            <th scope="col">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include('koneksi.php');
                                        $no = 1;
                                        $query = mysqli_query($connection, "SELECT * FROM approval");
                                        while ($row = mysqli_fetch_array($query)) {
                                        ?>

                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?php echo $row['branch'] ?></td>
                                                <td><?php echo $row['user'] ?></td>
                                                <td><?php echo $row['hrunit'] ?></td>
                                                <td class="text-center">

                                                    <!-- EDIT -->
                                                    <button href="edit.php?id=<?php echo $row['id_approval'] ?>" class="btn btn-sm btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="1.25em" height="1.25em" viewBox="0 0 640 512">
                                                            <rect width="640" height="512" fill="none" />
                                                            <path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128m89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h274.9c-2.4-6.8-3.4-14-2.6-21.3l6.8-60.9l1.2-11.1l7.9-7.9l77.3-77.3c-24.5-27.7-60-45.5-99.9-45.5m45.3 145.3l-6.8 61c-1.1 10.2 7.5 18.8 17.6 17.6l60.9-6.8l137.9-137.9l-71.7-71.7zM633 268.9L595.1 231c-9.3-9.3-24.5-9.3-33.8 0l-37.8 37.8l-4.1 4.1l71.8 71.7l41.8-41.8c9.3-9.4 9.3-24.5 0-33.9" />
                                                        </svg></button>

                                                    <!-- DELETE -->
                                                    <a href="delete.php?id=<?php echo $row['id_approval'] ?>" class="btn btn-sm btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="1.25em" height="1.25em" viewBox="0 0 24 24">
                                                            <rect width="640" height="640" fill="none" />
                                                            <path fill="currentColor" d="M21 14h-6a1 1 0 1 1 0-2h6a1 1 0 1 1 0 2m-7-5c0 1.381-.56 2.631-1.464 3.535C11.631 13.44 10.381 14 9 14s-2.631-.56-3.536-1.465C4.56 11.631 4 10.381 4 9s.56-2.631 1.464-3.535C6.369 4.56 7.619 4 9 4s2.631.56 3.536 1.465A4.984 4.984 0 0 1 14 9m-5 6c-3.75 0-6 2-6 4c0 1 2.25 2 6 2c3.518 0 6-1 6-2c0-2-2.354-4-6-4" />
                                                        </svg></a>

                                                    <!-- DETAIL -->
                                                    <a class="btn btn-sm btn-success detail-btn" data-toggle="modal" data-target="#detailModal<?php echo $row['id_approval']; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="1.25em" height="1.25em" viewBox="0 0 20 20">
                                                            <rect width="20" height="20" fill="none" />
                                                            <path fill="white" d="M15 11h7v2h-7zm1 4h6v2h-6zm-2-8h8v2h-8zM4 19h10v-1c0-2.757-2.243-5-5-5H7c-2.757 0-5 2.243-5 5v1zm4-7c1.995 0 3.5-1.505 3.5-3.5S9.995 5 8 5S4.5 6.505 4.5 8.5S6.005 12 8 12" />
                                                        </svg></a>
                                                </td>
                                            </tr>

                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .table-wrapper table {
        width: 100%;
    }

    .table-wrapper thead th,
    .table-wrapper tbody td {
        width: auto;
    }

    /* CSS untuk mengatur lebar kolom dan memperpanjang isi tabel ke kanan */
    .table-wrapper {
        /* overflow-x: auto; */
    }

    th,
    td {
        white-space: nowrap;
    }
</style>

<?php
// Modal untuk setiap baris
include('koneksi.php');
$sql = "SELECT * FROM approval";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='modal fade' id='detailModal" . $row["id_approval"] . "' tabindex='-1' role='dialog' aria-labelledby='detailModalLabel' aria-hidden='true'>";
        echo "<div class='modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered' role='document'>";
        echo "<div class='modal-content' style='border-radius: 15px;'>";
        echo "<div class='modal-header'>";
        echo "<h5 class='modal-title' id='detailModalLabel'>Detail Access Role</h5>";
        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
        echo "<span aria-hidden='true'>&times;</span>";
        echo "</button>";
        echo "</div>";
        echo "<div class='modal-body'>";
        // echo "<h5 class='modal-title' id='detailModalLabel'>Detail Employee Transfer</h5>";
        echo "<table class='table' style='margin-top: -18px'>";
        echo "<tr>";
        echo "<th>ID Persetujuan</th>";
        echo "<td>" . $row["id_approval"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Bisnis Unit</th>";
        echo "<td>" . $row["branch"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Kepala Department</th>";
        echo "<td>" . $row["user"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>HR Unit</th>";
        echo "<td>" . $row["hrunit"] . "</td>";
        echo "</tr>";
        if (!empty($row["direksi1"])) {
            echo "<tr>";
            echo "<th>Direksi 1</th>";
            echo "<td>" . $row["direksi1"] . "</td>";
            echo "</tr>";
        }

        if (!empty($row["direksi2"])) {
            echo "<tr>";
            echo "<th>Direksi 2</th>";
            echo "<td>" . $row["direksi2"] . "</td>";
            echo "</tr>";
        }
        echo "<tr>";
        echo "<th>Direksi 3</th>";
        echo "<td>" . $row["direksi3"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Presiden Direksi</th>";
        echo "<td>" . $row["presdir"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Corporate HR</th>";
        echo "<td>" . $row["corphr"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Super Admin</th>";
        echo "<td>" . $row["superadmin"] . "</td>";
        echo "</tr>";
        echo "</table>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
}
?>

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });

    $('#toggler').click(function() {
        $('#sidebar').toggleClass('active');
    });
</script>

</html>