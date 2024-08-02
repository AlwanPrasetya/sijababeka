<?php
include('koneksi.php');

$id = $_GET['id'];

$query = "SELECT * FROM employee_transfer WHERE id = $id LIMIT 1";

$result = mysqli_query($connection, $query);

$row = mysqli_fetch_array($result);

// Ambil data bisnis dari tabel bisnis
$query_nama = mysqli_query($connection, "SELECT DISTINCT nama FROM employee_transfer");
$nama_options = '';
while ($row_nama = mysqli_fetch_array($query_nama)) {
    $selected = ($row['nama'] == $row_nama['nama']) ? 'selected' : '';
    $nama_options .= '<option value="' . $row_nama['nama'] . '" ' . $selected . '>' . $row_nama['nama'] . '</option>';
}

$query_request_type = mysqli_query($connection, "SELECT DISTINCT request_type FROM employee_transfer");
$request_type_options = '';
while ($row_request_type = mysqli_fetch_array($query_request_type)) {
    $selected = ($row['request_type'] == $row_request_type['request_type']) ? 'selected' : '';
    $request_type_options .= '<option value="' . $row_request_type['request_type'] . '" ' . $selected . '>' . $row_request_type['request_type'] . '</option>';
}
$query_effective_date = mysqli_query($connection, "SELECT DISTINCT effective_date FROM employee_transfer");
$effective_date_options = '';
while ($row_effective_date = mysqli_fetch_array($query_effective_date)) {
    $selected = ($row['effective_date'] == $row_effective_date['effective_date']) ? 'selected' : '';
    $effective_date_options .= '<option value="' . $row_effective_date['effective_date'] . '" ' . $selected . '>' . $row_effective_date['effective_date'] . '</option>';
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
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                            <div class="form-group">
                                <label>Employee Name</label>
                                <input type="text" name="nama" value="<?php echo $row['nama'] ?>" placeholder="Masukkan Nama Karyawan" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Request Type</label>
                                <input type="text" name="request_type" value="<?php echo $row['request_type'] ?>" placeholder="Masukkan Tipe" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Effective Date</label>
                                <input type="text" name="effective_date" value="<?php echo $row['effective_date'] ?>" placeholder="Masukkan Tanggal" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <input type="text" name="nama_status" value="<?php echo $row['nama_status'] ?>" placeholder="Masukkan Status" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Branch</label>
                                <input type="text" name="nama_unit" value="<?php echo $row['nama_unit'] ?>" placeholder="Masukkan Unit" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Job Position</label>
                                <input type="text" name="nama_jabatan" value="<?php echo $row['nama_jabatan'] ?>" placeholder="Masukkan Jabtan" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Organisasi</label>
                                <input type="text" name="nama_organisasi" value="<?php echo $row['nama_organisasi'] ?>" placeholder="Masukkan organisasi" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Golongan</label>
                                <input type="text" name="nama_golongan" value="<?php echo $row['nama_golongan'] ?>" placeholder="Masukkan Golongan" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Reason</label>
                                <input type="text" name="reason" value="<?php echo $row['reason'] ?>" placeholder="Input Reason" class="form-control" required>
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