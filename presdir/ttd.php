<?php
session_start();

// Tampilkan kembali data yang disimpan dalam sesi
if (isset($_SESSION['effective_date']) && isset($_SESSION['reason'])) {
    // Gunakan data untuk menampilkan kembali tampilan sebelumnya
    $effective_date = $_SESSION['effective_date'];
    $reason = $_SESSION['reason'];

    // Tampilkan data dalam formulir atau bagian tampilan yang sesuai
} else {
    // Lakukan tindakan standar jika tidak ada data yang tersimpan
}

if (isset($_GET['branch'])) {
    // Ambil nilai branch dari URL
    $branch = $_GET['branch'];
    $userId = $_GET['id'];

    // Lakukan sesuatu dengan nilai branch yang telah diambil, misalnya menyimpannya dalam variabel atau menggunakan nilainya dalam operasi lainnya
    // echo "Nilai branch yang diterima dari URL: " . $branch;
} else {
    // Jika nilai branch tidak ditemukan dalam URL
    echo "Nilai branch tidak ditemukan dalam URL.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Tanda Tangan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #EAFAF1;
        }
    </style>
</head>

<body>
    <a href="../presdir/index.php?id=<?php echo $userId; ?>" class="top-left-button">
        <img src="./img/left-arrow.png" alt="" style="width: 40px; height: 40px; margin: 25px 25px;"></a>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Unggah Tanda Tangan Presdir</h3>
                        <form action="./ttd/uploud.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="signature">Pilih File Tanda Tangan:</label>
                                <input type="file" name="signature" id="signature" class="form-control-file">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-primary btn-block">Unggah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>