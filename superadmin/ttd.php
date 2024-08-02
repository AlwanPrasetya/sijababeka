<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Tanda Tangan Superadmin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<?php
include('sidebar.php');
?>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Unggah Tanda Tangan <br> Superadmin </h3>
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