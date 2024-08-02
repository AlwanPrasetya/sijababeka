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

    // Lakukan sesuatu dengan nilai branch yang telah diambil, misalnya menyimpannya dalam variabel atau menggunakan nilainya dalam operasi lainnya
    // echo "Nilai branch yang diterima dari URL: " . $branch;
} else {
    // Jika nilai branch tidak ditemukan dalam URL
    echo "Nilai branch tidak ditemukan dalam URL.";
}
?>
<?php
// Koneksi ke database
include('koneksi.php');

// Memeriksa apakah formulir telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirimkan melalui formulir
    $kodeFPK = $_POST['kodeFPK'];
    $requestFor = $_POST['requestFor'];
    $NamaFPK = $_POST['NamaFPK'];
    $nama_unit = $_POST['branch'];
    $nama_jabatan = $_POST['jabatan'];
    $nama_organisasi = $_POST['organisasi'];
    $nama_golongan = $_POST['golongan'];
    $nama_lokasi_kerja = $_POST['lokasi'];
    $effectiveDate = $_POST['effectiveDate'];
    $reason = $_POST['reason'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $experience = $_POST['experience'];
    $education = $_POST['education'];
    $major = $_POST['major'];
    $jobSpecification = $_POST['jobSpecification'];
    $jobDescription = $_POST['jobDescription'];
    $softSkills = $_POST['softSkills'];
    $hardSkills = $_POST['hardSkills'];

    // Query untuk mendapatkan nilai approver berdasarkan branch
    $sql_get_approvers = "SELECT user, hrunit, direksi1, direksi2, direksi3, presdir, corphr, superadmin FROM approval WHERE branch = ?";
    $stmt_get_approvers = $connection->prepare($sql_get_approvers);
    $stmt_get_approvers->bind_param("s", $nama_unit);
    $stmt_get_approvers->execute();
    $result_approvers = $stmt_get_approvers->get_result();

    if ($result_approvers->num_rows > 0) {
        // Ambil baris pertama sebagai nilai approver
        $row_approvers = $result_approvers->fetch_assoc();
        // Mendapatkan nilai approver untuk setiap kolom
        $namaAdmin = $row_approvers['hrunit'];
        $namaUser = $row_approvers['user'];
        $namaAtasan = $row_approvers['direksi1'];
        $namaDireksi2 = $row_approvers['direksi2'];
        $namaDireksi3 = $row_approvers['direksi3'];
        $namaCorpHr = $row_approvers['corphr'];
        $namaPresdir = $row_approvers['presdir'];
        $namaSuperadmin = $row_approvers['superadmin'];

        // Menyiapkan pernyataan SQL untuk memasukkan data ke dalam tabel fpk
        $sql = "INSERT INTO fpk (kodeFPK, requestFor, NamaFPK, branch, organisasi, golongan, jabatan, lokasi, effectiveDate, reason, gender, age, experience, education, major, jobSpecification, jobDescription, softSkills, hardSkills, namaAdmin, namaUser, namaAtasan, namaDireksi2, namaDireksi3, namaPresdir, namaCorpHr, namaSuperadmin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("sssssssssssssssssssssssssss", $kodeFPK, $requestFor, $NamaFPK, $nama_unit, $nama_organisasi, $nama_golongan, $nama_jabatan, $nama_lokasi_kerja, $effectiveDate, $reason, $gender, $age, $experience, $education, $major, $jobSpecification, $jobDescription, $softSkills, $hardSkills, $namaAdmin, $namaUser, $namaAtasan, $namaDireksi2, $namaDireksi3, $namaPresdir, $namaCorpHr, $namaSuperadmin);

        if ($stmt->execute()) {
            // Redirect ke halaman fpk.php jika data berhasil dimasukkan
            header("Location: fpk.php?branch=$branch");
            echo '<script>alert("Data FPK Berhasil Disimpan")</script>'; // Tampilkan alert berhasil
            exit(); // Pastikan untuk keluar setelah redirect
        } else {
            echo '<script>alert("Tidak ada approval untuk branch ini, Silahkan Hub. Superadmin"); window.location.href = "fpk.php";</script>'; // Tampilkan alert gagal dan kembali ke halaman fpk.php
        }
        // Tutup statement
        $stmt->close();
    } else {
        echo '<script>alert("Tidak ada approval untuk branch ini, Silahkan Hub. Superadmin"); window.location.href = "fpk.php";</script>'; // Tampilkan alert gagal dan kembali ke halaman fpk.php
    }
    // Tutup statement
    $stmt_get_approvers->close();
}

// Menutup koneksi database
$connection->close();
?>
