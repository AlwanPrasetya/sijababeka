<?php
include('koneksi.php');
include('sidebar.php');

?>
<!-- HTML body section -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<style>
    .container-content {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .card-header {
        padding: 10px;
    }

    .card-body {
        padding: 20px;
    }

    .btn {
        margin-right: 5px;
    }

    .table {
        margin-top: 20px;
    }

    /* CSS untuk membuat judul tabel tetap saat discroll */
    .table-wrapper {
        overflow-x: auto;
        position: relative;
    }

    .table-wrapper table {
        width: 100%;
    }

    .table-wrapper thead th {
        position: sticky;
        top: 0;
        background-color: #fff;
        /* Warna latar belakang judul tabel */
        z-index: 1;
        /* Mengatur z-index agar judul tabel tetap di atas */
    }

    /* Mengatur border pada kotak judul */
    .table-wrapper thead th:first-child {
        border-top-left-radius: 5px;
    }

    .table-wrapper thead th:last-child {
        border-top-right-radius: 5px;
    }


    /* Style untuk form */
    #myTable {
        margin-top: 20px;
    }

    /* Membuat tabel responsif */
    @media screen and (max-width: 768px) {
        .container-content {
            padding: 10px;
        }

        .card-header {
            font-size: 14px;
        }

        .card-body {
            padding: 10px;
        }

        .btn {
            margin-bottom: 10px;
        }

        .table {
            margin-top: 10px;
        }
    }
</style>
<!-- JavaScript section -->
<script>
    function validateForm() {
        var kode = document.getElementById('nama_kode').value;
        var jabatan = document.getElementById('nama_jabatan').value;
        if (kode == "" || jabatan == "") {
            alert("Harap lengkapi semua field!");
            return false; // Mengembalikan false jika validasi gagal
        }
        return true; // Mengembalikan true jika validasi berhasil
    }
</script>

<?php

function generateRandomKode()
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random_chars = '';
    for ($i = 0; $i < 2; $i++) {
        $random_chars .= $characters[rand(0, strlen($characters) - 1)];
    }
    $tahun2digit = date('y');
    $nomor_urut = mt_rand(100, 999);
    $kode_karyawan = $random_chars . $tahun2digit . $nomor_urut;
    return $kode_karyawan;
}
$generated_kode = generateRandomKode();
?>
<div class="container-content">
    <div class="container" style="margin-top: 20px">
        <h2 class="text-center mb-4">Form Karyawan</h2>
        <form action="save_karyawan_tetap.php" method="POST">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="kode">ID Karyawan</label>
                        <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $generated_kode; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Karyawan</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama">
                    </div>
                    <div class="form-group">
                        <label for="JoinDate">Tanggal Bergabung</label>
                        <input type="date" class="form-control" id="JoinDate" name="JoinDate" required>
                    </div>
                    <div class="form-group">
                        <label for="bisnis">Bisnis Unit</label>
                        <select class="form-control" id="bisnis" name="Bisnis Unit" required>
                            <option value="">Pilih Bisnis Unit</option>
                            <?php
                            include('koneksi.php');
                            $query_bisnis = mysqli_query($connection, "SELECT DISTINCT nama_unit FROM bisnis");
                            while ($row_bisnis = mysqli_fetch_array($query_bisnis)) {
                                echo '<option value="' . $row_bisnis['nama_unit'] . '">' . $row_bisnis['nama_unit'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label for="organisasi">Organisasi</label>
                        <select class="form-control" id="organisasi" name="organisasi" required>
                            <option value="">Pilih organisasi</option>
                            <?php
                            $query_organisasi = mysqli_query($connection, "SELECT DISTINCT nama_organisasi FROM organisasi");
                            while ($row_organisasi = mysqli_fetch_array($query_organisasi)) {
                                echo '<option value="' . $row_organisasi['nama_organisasi'] . '">' . $row_organisasi['nama_organisasi'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="golongan">Golongan</label>
                        <select class="form-control" id="golongan" name="golongan" required>
                            <option value="">Pilih Golongan</option>
                            <?php
                            $query_golongan = mysqli_query($connection, "SELECT DISTINCT nama_golongan FROM golongan");
                            while ($row_golongan = mysqli_fetch_array($query_golongan)) {
                                echo '<option value="' . $row_golongan['nama_golongan'] . '">' . $row_golongan['nama_golongan'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <select class="form-control" id="jabatan" name="jabatan" required>
                            <option value="">Pilih jabatan</option>
                            <?php
                            $query_jabatan = mysqli_query($connection, "SELECT DISTINCT nama_jabatan FROM jabatan");
                            while ($row_jabatan = mysqli_fetch_array($query_jabatan)) {
                                echo '<option value="' . $row_jabatan['nama_jabatan'] . '">' . $row_jabatan['nama_jabatan'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">Status Karyawan</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <?php
                            $query_status = mysqli_query($connection, "SELECT DISTINCT nama_status FROM status");
                            while ($row_status = mysqli_fetch_array($query_status)) {
                                echo '<option value="' . $row_status['nama_status'] . '">' . $row_status['nama_status'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12"></div>
                <div class="col-md-2"><br>
                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                    <br>
                </div>
            </div>

        </form>

        <div class="container" style="margin-top: 20px">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #008F4D; color: white;">
                            DATA KARYAWAN
                        </div>
                        <div class="card-body">
                            <div class="table-wrapper">
                                <table class="table table-bordered" id="myTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">NO.</th>
                                            <th scope="col">ID KARYAWAN</th>
                                            <th scope="col">NAMA</th>
                                            <th scope="col">TANGGAL BERGABUNG</th>
                                            <th scope="col">BISNIS UNIT</th>
                                            <th scope="col">ORGANISASI</th>
                                            <th scope="col">GOLONGAN</th>
                                            <th scope="col">JABATAN</th>
                                            <th scope="col">STATUS KARYAWAN</th>
                                            <th scope="col">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include('koneksi.php');
                                        $no = 1;

                                        if (isset($_GET['id'])) {
                                            // Ambil nilai "id" dari URL
                                            $userId = $_GET['id'];

                                            // Lakukan query SQL untuk mendapatkan cabang dari multi_user berdasarkan id
                                            $queryBranch = "SELECT branch FROM multi_user WHERE id = ?";
                                            $stmtBranch = mysqli_prepare($connection, $queryBranch);

                                            // Lindungi dari SQL injection dengan menggunakan prepared statement
                                            mysqli_stmt_bind_param($stmtBranch, "i", $userId);
                                            mysqli_stmt_execute($stmtBranch);
                                            $resultBranch = mysqli_stmt_get_result($stmtBranch);

                                            // Jika cabang ditemukan
                                            if ($rowBranch = mysqli_fetch_assoc($resultBranch)) {
                                                $branch = $rowBranch['branch'];

                                                // Lakukan query SQL untuk mendapatkan data karyawan berdasarkan cabang
                                                $queryKaryawan = "SELECT * FROM karyawan WHERE bisnis = ?";
                                                $stmtKaryawan = mysqli_prepare($connection, $queryKaryawan);

                                                // Lindungi dari SQL injection dengan menggunakan prepared statement
                                                mysqli_stmt_bind_param($stmtKaryawan, "s", $branch);
                                                mysqli_stmt_execute($stmtKaryawan);
                                                $resultKaryawan = mysqli_stmt_get_result($stmtKaryawan);

                                                // Tampilkan data karyawan
                                                while ($rowKaryawan = mysqli_fetch_assoc($resultKaryawan)) {
                                                   ?>
                                                    <tr>
                                                        <td><?php echo $no++ ?></td>
                                                        <td><?php echo $rowKaryawan['kode'] ?></td>
                                                        <td><?php echo $rowKaryawan['nama'] ?></td>
                                                        <td><?php echo $rowKaryawan['JoinDate'] ?></td>
                                                        <td><?php echo $rowKaryawan['bisnis'] ?></td>
                                                        <td><?php echo $rowKaryawan['organisasi'] ?></td>
                                                        <td><?php echo $rowKaryawan['golongan'] ?></td>
                                                        <td><?php echo $rowKaryawan['jabatan'] ?></td>
                                                        <td><?php echo $rowKaryawan['status'] ?></td>
                                                        <td class="text-center">
                                                            <a href="edit_karyawan_tetap.php?id=<?php echo $rowKaryawan['id_karyawan'] ?>" class="btn btn-sm btn-primary">EDIT</a>
                                                            <a href="delete_karyawan_tetap.php?id=<?php echo $rowKaryawan['id_karyawan'] ?>" class="btn btn-sm btn-danger">HAPUS</a>
                                                        </td>
                                                    </tr>
                                        <?php
                                                }
                                            } else {
                                                // Jika cabang tidak ditemukan untuk ID yang diberikan
                                                echo "Cabang tidak ditemukan untuk ID yang diberikan.";
                                            }
                                        } else {
                                            // Jika nilai "id" tidak ditemukan dalam URL
                                            echo "Nilai id tidak ditemukan dalam URL.";
                                        }
                                        ?>

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
</div>

<style>
    /* CSS untuk mengatur lebar kolom dan memperpanjang isi tabel ke kanan */
    .table-wrapper {
        overflow-x: auto;
    }

    th,
    td {
        white-space: nowrap;
    }
</style>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "searching": true,
            "search": {
                "regex": true,
                "caseInsensitive": false
            },
            "columns": [
                null,
                {
                    "searchable": true
                },
                null,
                {
                    "searchable": true
                },
                null,
                null,
                null,
                null,
                null,
                null
            ]
        });
    });
</script>