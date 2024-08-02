<?php
include('koneksi.php');

// Tangkap data yang dikirimkan melalui metode POST
$requestType = $_POST['requestType'];
$effectiveDate = $_POST['effectiveDate'];
$reason = $_POST['reason'];
$nama = $_POST['nama'];
$nama_status = $_POST['nama_status'];
$nama_unit = $_POST['nama_unit'];
$nama_jabatan = $_POST['nama_jabatan'];
$nama_organisasi = $_POST['nama_organisasi'];
$nama_golongan = $_POST['nama_golongan'];
$status = $_POST['status'] ?? '';
$branch = $_POST['branch'] ?? '';
$jabatan = $_POST['jabatan'] ?? '';
$organisasi = $_POST['organisasi'] ?? '';
$golongan = $_POST['golongan'] ?? '';

// Tangkap nama file dan lokasi sementara file yang diunggah
$fileName = $_FILES['uploadFile']['name'];
$tempFilePath = $_FILES['uploadFile']['tmp_name'];

// Tentukan folder tujuan untuk menyimpan file yang diunggah
$uploadFolder = 'uploads/';

// Pindahkan file yang diunggah ke folder tujuan
$destinationFilePath = $uploadFolder . $fileName;
move_uploaded_file($tempFilePath, $destinationFilePath);

// Query untuk menyimpan data transfer karyawan ke dalam database
$query = "INSERT INTO employee_transfer (request_type, effective_date, reason, nama, nama_status, nama_unit, nama_jabatan, nama_organisasi, nama_golongan, status, branch, jabatan, organisasi, golongan, file_name) 
          VALUES ('$requestType', '$effectiveDate', '$reason', '$nama', '$nama_status', '$nama_unit', '$nama_jabatan', '$nama_organisasi', '$nama_golongan', '$status', '$branch', '$jabatan', '$organisasi', '$golongan', '$fileName')";


// Jalankan query
if (mysqli_query($connection, $query)) {
    // Jika penyimpanan berhasil, tampilkan alert modal dan redirect ke halaman utama
    echo "<script>";
    echo "alert('Data karyawan berhasil diperbarui!');";
    echo "window.location.href = 'index.php?branches=$nama_unit';";
    echo "</script>";
    exit();
} else {
    // Jika terjadi kesalahan, tampilkan pesan error
    echo "Error: " . $query . "<br>" . mysqli_error($connection);
}

// Tutup koneksi database
mysqli_close($connection);
