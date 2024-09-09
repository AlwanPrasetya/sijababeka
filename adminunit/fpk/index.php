<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Status Pengajuan FPK</title>
</head>

<body>
  <h1>Status Pengajuan FPK</h1>

  <?php
  if (isset($_GET['status']) && $_GET['status'] == 'success') {
    echo "<p>Pengajuan FPK berhasil disimpan!</p>";
  } else {
    echo "<p>Terjadi kesalahan dalam pengajuan FPK.</p>";
  }
  ?>

  <a href="form_fpk.php">Kembali ke Formulir</a>
</body>

</html>