<?php
include('koneksi.php');
include ('sidebar.php');

?>
<!-- HTML body section -->
<style>
    .card-body {
        overflow-x: auto;
    }

    .table {
        width: 200%;
    }

    .table thead th,
    .table tbody td {
        white-space: nowrap;
        min-width: 50%;
    }

    .table tbody td:first-child,
    .table tbody td:nth-child(2) {
        width: 1%;
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
        <h2 class="text-center mb-4">Form Demosi</h2>
        <form action="save_karyawan_tetap.php" method="POST">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="kode">Employee ID</label>
                        <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $generated_kode; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Karyawan</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama">
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" required>
                    </div>
                    <div class="form-group">
                        <label for="bisnis">Bisnis</label>
                        <select class="form-control" id="bisnis" name="bisnis" required>
                            <option value="">Pilih Bisnis</option>
                            <?php
                            include('koneksi.php');
                            $query_bisnis = mysqli_query($connection, "SELECT DISTINCT nama_unit FROM bisnis");
                            while ($row_bisnis = mysqli_fetch_array($query_bisnis)) {
                                echo '<option value="' . $row_bisnis['nama_unit'] . '">' . $row_bisnis['nama_unit'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="department">Department</label>
                        <select class="form-control" id="department" name="department" required>
                            <option value="">Pilih Department</option>
                            <?php
                            $query_department = mysqli_query($connection, "SELECT DISTINCT nama_department FROM department");
                            while ($row_department = mysqli_fetch_array($query_department)) {
                                echo '<option value="' . $row_department['nama_department'] . '">' . $row_department['nama_department'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="divisi">Divisi</label>
                        <select class="form-control" id="divisi" name="divisi" required>
                            <option value="">Pilih Divisi</option>
                            <?php
                            $query_divisi = mysqli_query($connection, "SELECT DISTINCT nama_divisi FROM divisi");
                            while ($row_divisi = mysqli_fetch_array($query_divisi)) {
                                echo '<option value="' . $row_divisi['nama_divisi'] . '">' . $row_divisi['nama_divisi'] . '</option>';
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
                        <label for="lokasi_kerja">Lokasi Kerja</label>
                        <select class="form-control" id="lokasi_kerja" name="lokasi_kerja" required>
                            <option value="">Pilih Lokasi Kerja</option>
                            <?php
                            $query_lokasi_kerja = mysqli_query($connection, "SELECT DISTINCT nama_lokasi_kerja FROM lokasi_kerja");
                            while ($row_lokasi_kerja = mysqli_fetch_array($query_lokasi_kerja)) {
                                echo '<option value="' . $row_lokasi_kerja['nama_lokasi_kerja'] . '">' . $row_lokasi_kerja['nama_lokasi_kerja'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
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
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">NO.</th>
                                        <th scope="col">EMPLOYEE ID</th>
                                        <th scope="col">NAMA</th>
                                        <th scope="col">NIK</th>
                                        <th scope="col">BISNIS</th>
                                        <th scope="col">DEPT</th>
                                        <th scope="col">DIVISI</th>
                                        <th scope="col">GOL</th>
                                        <th scope="col">JABATAN</th>
                                        <th scope="col">LOKASI</th>
                                        <th scope="col">STATUS</th>
                                        <th scope="col">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include('koneksi.php');
                                    $no = 1;
                                    $query = mysqli_query($connection, "SELECT * FROM karyawan");
                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $row['kode'] ?></td>
                                            <td><?php echo $row['nama'] ?></td>
                                            <td><?php echo $row['nik'] ?></td>
                                            <td><?php echo $row['bisnis'] ?></td>
                                            <td><?php echo $row['department'] ?></td>
                                            <td><?php echo $row['divisi'] ?></td>
                                            <td><?php echo $row['golongan'] ?></td>
                                            <td><?php echo $row['jabatan'] ?></td>
                                            <td><?php echo $row['lokasi_kerja'] ?></td>
                                            <td><?php echo $row['status'] ?></td>
                                            <td class="text-center">
                                                <a href="edit_karyawan_tetap.php?id=<?php echo $row['id_karyawan'] ?>" class="btn btn-sm btn-primary">EDIT</a>
                                                <a href="delete_karyawan_tetap.php?id=<?php echo $row['id_karyawan'] ?>" class="btn btn-sm btn-danger">HAPUS</a>
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
                null,
                null,
                null
            ]
        });
    });
</script>


</html>