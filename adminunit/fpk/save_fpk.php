
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

// SQL query untuk mengambil nilai nama berdasarkan level dan branch
$query = "SELECT
(SELECT nama FROM multi_user WHERE branch='$namaUnit' AND level='user') AS namaUser,
(SELECT nama FROM multi_user WHERE branch='$namaUnit' AND level='hrunit') AS namaAdmin,
(SELECT nama FROM multi_user WHERE branch='$namaUnit' AND level='direksi1') AS namaAtasan,
(SELECT nama FROM multi_user WHERE branch='$namaUnit' AND level='direksi2') AS namaDireksi2,
(SELECT nama FROM multi_user WHERE branch='$namaUnit' AND level='direksi3') AS namaDireksi3,
(SELECT nama FROM multi_user WHERE branch='$namaUnit' AND level='presdir') AS namaPresdir,
(SELECT nama FROM multi_user WHERE branch='$namaUnit' AND level='corphr') AS namaCorphr,
(SELECT nama FROM multi_user WHERE branch='$namaUnit' AND level='superadmin') AS namaSuperadmin";

$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

// Menyimpan nilai-nilai ke variabel
$namaAdmin = $row['namaAdmin'];
$namaUser = $row['namaUser'];
$namaAtasan = $row['namaAtasan'];
$namaDireksi2 = $row['namaDireksi2'];
$namaDireksi3 = $row['namaDireksi3'];
$namaPresdir = $row['namaPresdir'];
$namaCorphr = $row['namaCorphr'];
$namaSuperadmin = $row['namaSuperadmin'];

// SQL query untuk menyimpan data ke tabel fpk
$sql = "INSERT INTO fpk (kodeFPK, requestType, uploadFile, namaFPK, golongan, jabatan,
organisasi, effectiveDate, namaUnit, reason, note, gender, age, experience,
education, major, lokasiKerja, jobDescription, jobSpecification, softSkills, hardSkills,
namaAdmin, namaUser, namaAtasan, namaDireksi2, namaDireksi3, namaPresdir, namaCorphr, namaSuperadmin)
VALUES ('$kodeFPK', '$requestType', '$uploadFile', '$namaKaryawan', '$golongan', '$jabatan',
'$organisasi', '$effectiveDate', '$namaUnit', '$reason', '$note', '$gender', '$age', '$experience',
'$education', '$major', '$lokasiKerja', '$jobDescription', '$jobSpecification', '$softSkills', '$hardSkills',
'$namaAdmin', '$namaUser', '$namaDireksi3', '$namaPresdir', '$namaCorphr', '$namaSuperadmin')";

    if (mysqli_query($connection,
        $sql
    )) {
        // Jika data berhasil disimpan, tampilkan alert sukses
        echo "<script>
            alert('Data berhasil disimpan!');
            setTimeout(function() {
                window.location.href = document.referrer; // Kembali ke halaman sebelumnya
            }, 100); // Delay 1 detik (1000 ms)
          </script>";
    } else {
        // Jika terjadi error, tampilkan pesan error
        echo "<script>
            alert('Terjadi kesalahan: " . mysqli_error($connection) . "');
            setTimeout(function() {
                window.location.href = document.referrer; // Kembali ke halaman sebelumnya
            }, 100); // Delay 1 detik (1000 ms)
          </script>";
    }

// Tutup connection database
mysqli_close($connection);
}

?>