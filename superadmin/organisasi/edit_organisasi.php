<?php
include('koneksi.php');

$id = $_GET['id'];

$query = "SELECT * FROM organisasi WHERE id_organisasi = $id LIMIT 1";

$result = mysqli_query($connection, $query);

$row = mysqli_fetch_array($result);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title>Edit organisasi</title>
</head>

<body>

    <div class="container" style="margin-top: 80px">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        EDIT organisasi
                    </div>
                    <div class="card-body">
                        <form action="update_organisasi.php" method="POST">
                            <!-- Tambahkan input tersembunyi untuk id organisasi -->
                            <input type="hidden" name="id_organisasi" value="<?php echo $row['id_organisasi']; ?>">
                            <!-- Form lainnya -->
                            <div class="form-group">
                                <label>KODE</label>
                                <input type="text" name="nama_kode" value="<?php echo $row['nama_kode'] ?>" placeholder="Masukkan Kode" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama organisasi</label>
                                <input type="text" name="nama_organisasi" value="<?php echo $row['nama_organisasi'] ?>" placeholder="Masukkan Nama organisasi" class="form-control">
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