<?php
// Konfigurasi database
$servername = "localhost";
$username = "alwan"; // Ganti dengan username MySQL Anda
$password = "root"; // Ganti dengan password MySQL Anda
$dbname = "settings"; // Ganti dengan nama database Anda

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pastikan file yang diunggah adalah gambar
$target_dir = "img/"; // Folder tempat tanda tangan akan disimpan
$target_file = $target_dir . basename($_FILES["signature"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Cek apakah file yang diunggah adalah gambar
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["signature"]["tmp_name"]);
    if ($check !== false) {
        // File adalah gambar
        // Cek apakah file sudah ada
        if (file_exists($target_file)) {
            echo "Maaf, file sudah ada.";
        } else {
            // Pindahkan file yang diunggah ke folder tujuan
            if (move_uploaded_file($_FILES["signature"]["tmp_name"], $target_file)) {
                // Simpan informasi tanda tangan ke database
                $file_name = basename($_FILES["signature"]["name"]);
                $ttd_id = uniqid(); // ID unik untuk tanda tangan
                $sql = "INSERT INTO ttd (nama_file, ttd_id) VALUES ('$file_name', '$ttd_id')";
                if ($conn->query($sql) === TRUE) {
                    // Alert berhasil
                    echo "<script>alert('File " . basename($_FILES["signature"]["name"]) . " - TTD Corp HR berhasil diunggah.');</script>";
                    // Kembali ke halaman sebelumnya
                    echo "<script>window.history.back();</script>";
                    // Kosongkan nilai input file tanda tangan
                    echo "<script>clearSignatureInput();</script>";
                    exit();
                } else {
                    echo "Maaf, terjadi kesalahan saat menyimpan informasi tanda tangan ke database.";
                }
            } else {
                echo "Maaf, terjadi kesalahan saat mengunggah file.";
            }
        }
    } else {
        echo "Maaf, file yang diunggah bukan gambar.";
    }
}

// Tutup koneksi ke database
$conn->close();
?>

<!-- Tambahkan skrip JavaScript untuk mengosongkan nilai input file tanda tangan -->
<script>
    function clearSignatureInput() {
        document.getElementById("signature").value = ""; // Ubah "signature" dengan ID input file Anda
    }
</script>