<?php
include('koneksi.php');

$id = $_GET['id'];

$query = "SELECT * FROM jabatan WHERE id_jabatan = $id LIMIT 1";

$result = mysqli_query($connection, $query);

$row = mysqli_fetch_array($result);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title>Edit jabatan</title>
</head>

<body>

    <div class="container" style="margin-top: 80px">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        EDIT jabatan
                    </div>
                    <div class="card-body">
                        <form action="update_jabatan.php" method="POST">
                            <!-- Tambahkan input tersembunyi untuk id jabatan -->
                            <input type="hidden" name="id_jabatan" value="<?php echo $row['id_jabatan']; ?>">
                            <!-- Form lainnya -->
                            <div class="form-group">
                                <label>KODE</label>
                                <input type="text" name="nama_kode" value="<?php echo $row['nama_kode'] ?>" placeholder="Masukkan Kode" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama jabatan</label>
                                <input type="text" name="nama_jabatan" value="<?php echo $row['nama_jabatan'] ?>" placeholder="Masukkan Nama jabatan" class="form-control">
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