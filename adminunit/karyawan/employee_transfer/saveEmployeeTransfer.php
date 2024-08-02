<?php
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $request_type = isset($_POST['requestType']) ? $_POST['requestType'] : '';
    $effective_date = isset($_POST['effective_date']) ? $_POST['effective_date'] : '';
    $reason = isset($_POST['reason']) ? $_POST['reason'] : '';
    $nama_status = $_POST['nama_status'];
    $nama_unit = $_POST['nama_unit'];
    $nama_jabatan = $_POST['nama_jabatan'];
    $nama_organisasi = $_POST['nama_organisasi'];
    $nama_golongan = $_POST['nama_golongan'];

    if (isset($_FILES['uploadFile']) && $_FILES['uploadFile']['error'] === UPLOAD_ERR_OK) {
        $fileData = $_FILES['uploadFile'];
        $sql = "INSERT INTO employee_transfer (nama, request_type, effective_date, nama_status, nama_unit, nama_jabatan, nama_organisasi, nama_golongan, reason, file_name, file_type, file_content) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("ssssssssssss", $nama, $request_type, $effective_date, $nama_status, $nama_unit, $nama_jabatan, $nama_organisasi, $nama_golongan, $reason, $fileName, $fileType, $fileContent);

        $fileName = $fileData['name'];
        $fileType = $fileData['type'];
        $fileContent = file_get_contents($fileData['tmp_name']);

        if ($stmt->execute()) {
            $stmt->close();
            echo '<script>alert("Data transfer karyawan berhasil disimpan.");</script>';
            $connection->close();
            header("Location: {$_SERVER['HTTP_REFERER']}?branches=" . urlencode($_GET['branches']));

            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    } else {
        echo "Error: File tidak ada atau terjadi kesalahan saat mengunggah.";
    }
}
