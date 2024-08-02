<?php
// // mengaktifkan session pada php
// session_start();

// menghubungkan php dengan koneksi database
include 'koneksi.php';

// menangkap data yang dikirim dari form login
$username = $_POST['username'];
$password = $_POST['password'];

// Function to get branches with hrunit value
// Function to get branches with hrunit value
function getBranchesWithHrUnitAndName($hrunitValue, $namaValue)
{
    // Anda harus mengganti ini dengan koneksi ke database Anda
    $koneksi = new mysqli("localhost", "alwan", "root", "settings");

    // Periksa koneksi
    if ($koneksi->connect_error) {
        die("Koneksi database gagal: " . $koneksi->connect_error);
    }

    // Query untuk mendapatkan nilai branch yang sesuai dengan nilai hrunit dan nama
    $query = "SELECT branch FROM multi_user WHERE level = 'hrunit' AND nama = ?";
    $statement = $koneksi->prepare($query);
    $statement->bind_param("s", $namaValue);
    $statement->execute();
    $result = $statement->get_result();

    // Simpan nilai branch dalam sebuah array
    $branches = array();
    while ($row = $result->fetch_assoc()) {
        $branches[] = $row['branch'];
    }

    // Tutup statement dan koneksi
    $statement->close();
    $koneksi->close();

    return $branches;
}


// menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($koneksi, "select * from multi_user where username='$username' and password='$password'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);

// cek apakah username dan password ditemukan pada database
if ($cek > 0) {
    $data = mysqli_fetch_assoc($login);

    // Set session 'id' dengan nilai ID pengguna dari database
    // $_SESSION['id'] = $data['id'];

    // buat session login dan username
    // $_SESSION['username'] = $username;

    // cek level pengguna
    if ($data['level'] == "superadmin") {
        header("location: superadmin/superadmin.php?id=" . $data['id']);

        // } elseif ($data['level'] == "hrunit") {
        //     $_SESSION['level'] = "hrunit";
        //     // Mendapatkan daftar cabang dengan nilai hrunit yang sama dan nama yang sama
        //     $branches = getBranchesWithHrUnitAndName("hrunit", $data['nama']);
        //     // Membuat string berisi daftar cabang yang dipisahkan oleh koma
        //     $branchesString = implode(",", $branches);
        //     // alihkan ke halaman dashboard adminunit dengan daftar cabang dalam URL
        //     header("location: adminunit/index.php?branches=" . $branchesString);   
        // } elseif ($data['level'] == "user") {
            
    } elseif ($data['level'] == "hrunit") {
        // alihkan ke halaman dashboard user dengan ID pengguna
        header("location: adminunit/index.php?id=" . $data['id']);
    } elseif ($data['level'] == "direksi1" || $data['level'] == "direksi2" || $data['level'] == "direksi3") {
        // alihkan ke halaman dashboard atasan sesuai level
        header("location: atasan/" . $data['level'] . ".php?id=" . $data['id']);
        // } elseif ($data['level'] == "user") {
    } elseif ($data['level'] == "user") {
        // alihkan ke halaman dashboard user dengan ID pengguna
        header("location: user/index.php?id=" . $data['id']);
    } elseif ($data['level'] == "corphr") {
        // alihkan ke halaman dashboard user dengan ID pengguna
        header("location: corphr/index.php?id=" . $data['id']);
    } elseif ($data['level'] == "presdir") {
        // alihkan ke halaman dashboard user dengan ID pengguna
        header("location: presdir/index.php?id=" . $data['id']);
    } elseif ($data['level'] == "candidates") {
        // alihkan ke halaman dashboard user dengan ID pengguna
        header("location: karyawan/index.php?id=" . $data['id'] . "&id_biodata=" . $data['branch']);
    } else {
        // alihkan ke halaman login kembali jika level tidak sesuai
        header("location:index.php?pesan=gagal");
    }
} else {
    // alihkan ke halaman login kembali jika data tidak ditemukan
    header("location:index.php?pesan=gagal");
}
