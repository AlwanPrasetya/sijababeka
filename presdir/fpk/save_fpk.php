<?php
// Koneksi ke database
include('koneksi.php');

// Memeriksa apakah formulir telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirimkan melalui formulir
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $bisnis = $_POST['bisnis'];
    $department = $_POST['department'];
    $divisi = $_POST['divisi'];
    $golongan = $_POST['golongan'];
    $jabatan = $_POST['jabatan'];
    $lokasi = $_POST['lokasi_kerja'];
    $status = $_POST['status'];
    $requestFor = $_POST['requestFor'];
    $resignEmployee = $_POST['resignEmployee'];
    $effectiveDate = $_POST['effectiveDate'];
    $reason = $_POST['reason'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $experience = $_POST['experience'];
    $education = $_POST['education'];
    $major = $_POST['major'];
    $jobDescription = $_POST['jobDescription'];
    $softSkills = $_POST['softSkills'];
    $hardSkills = $_POST['hardSkills'];

    // Menyiapkan pernyataan SQL untuk memasukkan data ke dalam tabel fpk
    $sql = "INSERT INTO fpk (kode, nama, nik, bisnis, department, divisi, golongan, jabatan, lokasi, status, requestFor, resignEmployee, effectiveDate, reason, gender, age, experience, education, major, jobDescription, softSkills, hardSkills) VALUES ('$kode', '$nama', '$nik', '$bisnis', '$department', '$divisi', '$golongan', '$jabatan', '$lokasi', '$status', '$requestFor', '$resignEmployee', '$effectiveDate', '$reason', '$gender', '$age', '$experience', '$education', '$major', '$jobDescription', '$softSkills', '$hardSkills')";

    if ($connection->query($sql) === TRUE) {
        // Redirect ke halaman fpk.php jika data berhasil dimasukkan
        header("Location: fpk.php");
        exit(); // Pastikan untuk keluar setelah redirect
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}

// Menutup koneksi database
$connection->close();
