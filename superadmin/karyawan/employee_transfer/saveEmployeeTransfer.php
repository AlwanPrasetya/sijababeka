<?php
// Koneksi ke database
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama = $_POST['nama'] ?? '';
    $requestType = $_POST['requestType'] ?? '';
    $effectiveDate = $_POST['effective_date'] ?? '';
    $nama_status = $_POST['nama_status'] ?? '';
    $nama_unit = $_POST['nama_unit'] ?? '';
    $nama_jabatan = $_POST['nama_jabatan'] ?? '';
    $nama_golongan = $_POST['nama_golongan'] ?? '';
    $nama_organisasi = $_POST['nama_organisasi'] ?? ''; 
    $reason = $_POST['reason'] ?? '';

    // Cek apakah semua data yang diperlukan telah diisi
    if (empty($nama) || empty($requestType) || empty($effectiveDate) || empty($nama_status) || empty($nama_unit) || empty($nama_jabatan) || empty($nama_golongan) || empty($nama_organisasi) || empty($reason)) {
        echo "Error: Mohon lengkapi semua kolom yang diperlukan.";
        exit;
    }

    // Cek apakah ada file yang di-upload
    if (isset($_FILES['uploadFile']) && $_FILES['uploadFile']['error'] === UPLOAD_ERR_OK) {
        // Ambil data file
        $fileData = $_FILES['uploadFile'];

        // Lakukan proses penyimpanan data ke database
        $sql = "INSERT INTO employee_transfer (nama, request_type, effective_date, nama_status, nama_unit, nama_jabatan, nama_golongan, nama_organisasi, reason, file_name, file_type, file_content) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Persiapkan statement SQL
        $stmt = $connection->prepare($sql);

        // Bind parameter ke statement
        $stmt->bind_param("ssssssssssss", $nama, $request_type, $effective_date, $nama_status, $nama_unit, $nama_jabatan, $nama_golongan, $nama_organisasi, $reason, $fileName, $fileType, $fileContent);

        // Baca isi file
        $fileName = $fileData['name'];
        $fileType = $fileData['type'];
        $fileContent = file_get_contents($fileData['tmp_name']);

        // Eksekusi statement
        if ($stmt->execute()) {
            // Tutup statement
            $stmt->close();
            // Tampilkan alert menggunakan JavaScript
            echo '<script>alert("Data transfer karyawan berhasil disimpan.");</script>';

            // Tutup koneksi ke database
            $connection->close();

            // Kembalikan pengguna ke halaman sebelumnya
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    } else {
        echo "Error: File tidak ada atau terjadi kesalahan saat mengunggah.";
    }
}
