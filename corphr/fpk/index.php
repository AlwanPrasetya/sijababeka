<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        h4 {
            color: #007bff;
            text-align: center;
            margin-top: 30px;
        }

        .signature-form {
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="file"] {
            display: none;
        }

        .custom-file-upload {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
        }

        .custom-file-upload:hover {
            background-color: #0056b3;
        }

        .submit-btn {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <h4>SELAMAT DATANG, <strong>ATASAN</strong></h4>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="signature-form">
                    <form action="../ttd/" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="signature">Unggah Tanda Tangan:</label>
                            <input type="file" name="signature" id="signature" accept="image/*">
                            <label for="signature" class="custom-file-upload">Pilih File</label>
                        </div>
                        <button type="submit" class="submit-btn">Unggah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
