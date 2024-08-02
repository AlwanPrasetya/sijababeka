<?php
// Lakukan koneksi ke database di sini
// Gantilah parameter koneksi dengan informasi yang sesuai
$koneksi = mysqli_connect("localhost", "alwan", "root", "settings");

// Periksa koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

// Pastikan hanya menjalankan skrip jika ada permintaan GET
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['branch'])) {
    $branch = $_GET['branch'];

    // Query untuk mengambil data HR Unit, Direksi 3, Presdir, Corp HR, dan Super Admin berdasarkan cabang
    $sql = "SELECT hrunit, direksi3, presdir, corphr, superadmin FROM bisnis WHERE nama_unit = '$branch'";
    $result = mysqli_query($koneksi, $sql);

    // Inisialisasi array untuk menyimpan hasil
    $values = array();

    // Periksa apakah query berhasil dieksekusi
    if ($result && mysqli_num_rows($result) > 0) {
        // Ambil baris hasil
        $row = mysqli_fetch_assoc($result);
        // Simpan nilai ke dalam array
        $values['hrunit'] = $row['hrunit'];
        $values['direksi3'] = $row['direksi3'];
        $values['presdir'] = $row['presdir'];
        $values['corphr'] = $row['corphr'];
        $values['superadmin'] = $row['superadmin'];
    }

    // Kembalikan nilai dalam bentuk JSON
    echo json_encode($values);
} else {
    // Jika tidak ada permintaan GET atau tidak ada parameter 'branch' yang diberikan, kembalikan pesan kesalahan
    echo "Invalid request";
}

// Menutup koneksi database
mysqli_close($koneksi);
?>
