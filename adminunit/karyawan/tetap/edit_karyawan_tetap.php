<?php
include('koneksi.php');

$id = $_GET['id'];

$query = "SELECT * FROM karyawan WHERE id_karyawan = $id LIMIT 1";

$result = mysqli_query($connection, $query);

$row = mysqli_fetch_array($result);

// Ambil data bisnis dari tabel bisnis
$query_bisnis = mysqli_query($connection, "SELECT DISTINCT nama_unit FROM bisnis");
$bisnis_options = '';
while ($row_bisnis = mysqli_fetch_array($query_bisnis)) {
    $selected = ($row['bisnis'] == $row_bisnis['nama_unit']) ? 'selected' : '';
    $bisnis_options .= '<option value="' . $row_bisnis['nama_unit'] . '" ' . $selected . '>' . $row_bisnis['nama_unit'] . '</option>';
}

$query_department = mysqli_query($connection, "SELECT DISTINCT nama_department FROM department");
$department_options = '';
while ($row_department = mysqli_fetch_array($query_department)) {
    $selected = ($row['department'] == $row_department['nama_department']) ? 'selected' : '';
    $department_options .= '<option value="' . $row_department['nama_department'] . '" ' . $selected . '>' . $row_department['nama_department'] . '</option>';
}

$query_divisi = mysqli_query($connection, "SELECT DISTINCT nama_divisi FROM divisi");
$divisi_options = '';
while ($row_divisi = mysqli_fetch_array($query_divisi)) {
    $selected = ($row['divisi'] == $row_divisi['nama_divisi']) ? 'selected' : '';
    $divisi_options .= '<option value="' . $row_divisi['nama_divisi'] . '" ' . $selected . '>' . $row_divisi['nama_divisi'] . '</option>';
}

$query_golongan = mysqli_query($connection, "SELECT DISTINCT nama_golongan FROM golongan");
$golongan_options = '';
while ($row_golongan = mysqli_fetch_array($query_golongan)) {
    $selected = ($row['golongan'] == $row_golongan['nama_golongan']) ? 'selected' : '';
    $golongan_options .= '<option value="' . $row_golongan['nama_golongan'] . '" ' . $selected . '>' . $row_golongan['nama_golongan'] . '</option>';
}

$query_jabatan = mysqli_query($connection, "SELECT DISTINCT nama_jabatan FROM jabatan");
$jabatan_options = '';
while ($row_jabatan = mysqli_fetch_array($query_jabatan)) {
    $selected = ($row['jabatan'] == $row_jabatan['nama_jabatan']) ? 'selected' : '';
    $jabatan_options .= '<option value="' . $row_jabatan['nama_jabatan'] . '" ' . $selected . '>' . $row_jabatan['nama_jabatan'] . '</option>';
}

$query_lokasi_kerja = mysqli_query($connection, "SELECT DISTINCT nama_lokasi_kerja FROM lokasi_kerja");
$lokasi_kerja_options = '';
while ($row_lokasi_kerja = mysqli_fetch_array($query_lokasi_kerja)) {
    $selected = ($row['lokasi_kerja'] == $row_lokasi_kerja['nama_lokasi_kerja']) ? 'selected' : '';
    $lokasi_kerja_options .= '<option value="' . $row_lokasi_kerja['nama_lokasi_kerja'] . '" ' . $selected . '>' . $row_lokasi_kerja['nama_lokasi_kerja'] . '</option>';
}

$query_status = mysqli_query($connection, "SELECT DISTINCT nama_status FROM status");
$status_options = '';
while ($row_status = mysqli_fetch_array($query_status)) {
    $selected = ($row['status'] == $row_status['nama_status']) ? 'selected' : '';
    $status_options .= '<option value="' . $row_status['nama_status'] . '" ' . $selected . '>' . $row_status['nama_status'] . '</option>';
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title>Edit status</title>
</head>

<body>

    <div class="container" style="margin-top: 80px">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        EDIT KARYAWAN TETAP
                    </div>
                    <div class="card-body">
                        <form action="update_karyawan_tetap.php" method="POST">
                            <!-- Tambahkan input tersembunyi untuk id status -->
                            <input type="hidden" name="id_karyawan" value="<?php echo $row['id_karyawan']; ?>">
                            <!-- Form lainnya -->
                            <div class="form-group">
                                <label>KODE</label>
                                <input type="text" name="kode" value="<?php echo $row['kode'] ?>" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nama karyawan</label>
                                <input type="text" name="nama" value="<?php echo $row['nama'] ?>" placeholder="Masukkan Nama Karyawan" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" name="nik" value="<?php echo $row['nik'] ?>" placeholder="Masukkan NIK" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Bisnis</label>
                                <select name="bisnis" class="form-control" required>
                                    <?php echo $bisnis_options; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>department</label>
                                <select name="department" class="form-control" required>
                                    <?php echo $department_options; ?>
                                </select>   
                            </div>
                            <div class="form-group">
                                <label>divisi</label>
                                <select name="divisi" class="form-control" required>
                                    <?php echo $divisi_options; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>golongan</label>
                                <select name="golongan" class="form-control" required>
                                    <?php echo $golongan_options; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>jabatan</label>
                                <select name="jabatan" class="form-control" required>
                                    <?php echo $jabatan_options; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>lokasi kerja</label>
                                <select name="lokasi_kerja" class="form-control" required>
                                    <?php echo $lokasi_kerja_options; ?>
                                </select></div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <?php echo $status_options; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">UPDATE</button>
                            <button type="reset" class="btn btn-warning">RESET</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>