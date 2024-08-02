<?php
// Pastikan metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['branch']) && !empty($_POST['user']) && !empty($_POST['hrunit']) && !empty($_POST['direksi3']) && !empty($_POST['presdir']) && !empty($_POST['corphr']) && !empty($_POST['superadmin'])) {
        $branch = $_POST['branch'];
        $user = $_POST['user'];
        $hrunit = $_POST['hrunit'];
        $direksi1 = isset($_POST['direksi1']) ? $_POST['direksi1'] : ""; // Gunakan isset untuk memeriksa apakah direksi1 diisi atau tidak
        $direksi2 = isset($_POST['direksi2']) ? $_POST['direksi2'] : ""; // Gunakan isset untuk memeriksa apakah direksi2 diisi atau tidak
        $direksi3 = $_POST['direksi3'];
        $presdir = $_POST['presdir'];
        $corphr = $_POST['corphr'];
        $superadmin = $_POST['superadmin'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Koneksi ke database
        include('koneksi.php');

        // SQL untuk menyimpan data ke dalam tabel approval
        $sql = "INSERT INTO approval (branch, user, hrunit, direksi1, direksi2, direksi3, presdir, corphr, superadmin) VALUES ('$branch', '$user', '$hrunit', '$direksi1', '$direksi2', '$direksi3', '$presdir', '$corphr', '$superadmin')";

        // Eksekusi query
        if ($connection->query($sql) === TRUE) {
            // SQL untuk menyimpan data ke dalam tabel multi_user
            $sql_multi_user = "INSERT INTO multi_user (branch,  nama, username, password, level) VALUES ('$branch', '$user', '$user', '$user', 'user')";
            $sql_multi_hrunit = "INSERT INTO multi_user (branch,  nama, username, password, level) VALUES ('$branch', '$hrunit', '$hrunit', '$hrunit', 'hrunit')";
            $sql_multi_direksi1 = "INSERT INTO multi_user (branch,  nama, username, password, level) VALUES ('$branch', '$direksi1', '$direksi1', '$direksi1', 'direksi1')";
            $sql_multi_direksi2 = "INSERT INTO multi_user (branch,  nama, username, password, level) VALUES ('$branch', '$direksi2', '$direksi2', '$direksi2', 'direksi2')";
            $sql_multi_direksi3 = "INSERT INTO multi_user (branch,  nama, username, password, level) VALUES ('$branch', '$direksi3', '$direksi3', '$direksi3', 'direksi3')";
            $sql_multi_presdir = "INSERT INTO multi_user (branch,  nama, username, password, level) VALUES ('$branch', '$presdir', '$presdir', '$presdir', 'presdir')";
            $sql_multi_corphr = "INSERT INTO multi_user (branch,  nama, username, password, level) VALUES ('$branch', '$corphr', '$corphr', '$corphr', 'corphr')";
            $sql_multi_superadmin = "INSERT INTO multi_user (branch,  nama, username, password, level) VALUES ('$branch', '$superadmin', '$superadmin', '$superadmin', 'superadmin')";

            // Eksekusi query multi_user
            if ($connection->query($sql_multi_user) === TRUE && $connection->query($sql_multi_hrunit) === TRUE && $connection->query($sql_multi_direksi1) === TRUE && $connection->query($sql_multi_direksi2) === TRUE && $connection->query($sql_multi_direksi3) === TRUE && $connection->query($sql_multi_presdir) === TRUE && $connection->query($sql_multi_corphr) === TRUE && $connection->query($sql_multi_superadmin) === TRUE) {
                // SQL untuk menyimpan data ke dalam tabel fpk hanya jika branch sesuai
                $sql_fpk = "UPDATE fpk 
                SET 
                    namaUser = CASE WHEN namaUser = '' THEN '$user' ELSE namaUser END,
                    namaAdmin = CASE WHEN namaAdmin = '' THEN '$hrunit' ELSE namaAdmin END,
                    namaAtasan = CASE WHEN namaAtasan = '' THEN '$direksi1' ELSE namaAtasan END,
                    namaDireksi2 = CASE WHEN namaDireksi2 = '' THEN '$direksi2' ELSE namaDireksi2 END,
                    namaDireksi3 = CASE WHEN namaDireksi3 = '' THEN '$direksi3' ELSE namaDireksi3 END,
                    namaPresdir = CASE WHEN namaPresdir = '' THEN '$presdir' ELSE namaPresdir END,
                    namaCorpHr = CASE WHEN namaCorpHr = '' THEN '$corphr' ELSE namaCorpHr END,
                    namaSuperadmin = CASE WHEN namaSuperadmin = '' THEN '$superadmin' ELSE namaSuperadmin END,
                    effectiveDate = NOW()
                WHERE branch = '$branch'";

                

                // Eksekusi query fpk
                if ($connection->query($sql_fpk) === TRUE) {
                    // Tampilkan alert "Berhasil Disimpan" menggunakan JavaScript
                    echo "<script>
                    alert('Silahkan Login dengan Username dan Password menggunakan Nama');
                    window.location.href = 'index.php'; // Redirect ke halaman index.php setelah alert
                </script>";
                } else {
                    echo "Terjadi kesalahan: " . $connection->error;
                }
            } else {
                echo "Terjadi kesalahan: " . $connection->error;
            }

            // Menutup koneksi database
            $connection->close();
        } else {
            echo "Data tidak lengkap.";
        }
    } else {
        echo "Metode yang digunakan harus POST.";
    }
}
