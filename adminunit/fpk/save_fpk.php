<?php
// Include koneksi ke database
include('koneksi.php');

// Tangkap data dari formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari formulir
    $kodeFPK = $_POST['kodeFPK'];
    $requestType = $_POST['requestType'];
    $uploadFile = $_FILES['uploadFile']['name'];
    $namaKaryawan = $_POST['namaFPK'];
    $golongan = $_POST['namagolongan'];
    $jabatan = $_POST['namajabatan'];
    $organisasi = $_POST['namaorganisasi'];
    $effectiveDate = $_POST['effectiveDate'];
    $namaUnit = $_POST['namaunit'];
    $reason = $_POST['reason'];
    $note = $_POST['note'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $experience = $_POST['experience'];
    $education = $_POST['education'];
    $major = $_POST['major'];
    $lokasiKerja = $_POST['lokasiKerja'];
    $jobDescription = $_POST['jobDescription'];
    $jobSpecification = $_POST['jobSpecification'];
    $softSkills = $_POST['softSkills'];
    $hardSkills = $_POST['hardSkills'];

    // Upload file lampiran
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["uploadFile"]["name"]);
    move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file);

    // SQL query untuk menyimpan data ke tabel fpk
    $sql = "INSERT INTO fpk (kodeFPK, requestType, uploadFile, namaFPK, golongan, jabatan, 
            organisasi, effectiveDate, namaUnit, reason, note, gender, age, experience, 
            education, major, lokasiKerja, jobDescription, jobSpecification, softSkills, hardSkills)
            VALUES ('$kodeFPK', '$requestType', '$uploadFile', '$namaKaryawan', '$golongan', '$jabatan',
            '$organisasi', '$effectiveDate', '$namaUnit', '$reason', '$note', '$gender', '$age', '$experience',
            '$education', '$major', '$lokasiKerja', '$jobDescription', '$jobSpecification', '$softSkills', '$hardSkills')";

    if (mysqli_query($koneksi, $sql)) {
        // Jika data berhasil disimpan, redirect ke halaman sukses atau halaman lain yang diinginkan
        header("Location: index.php?id=$userId&status=success");
        exit();
    } else {
        // Jika terjadi error, tampilkan pesan error
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }

    // Tutup koneksi database
    mysqli_close($koneksi);
}
