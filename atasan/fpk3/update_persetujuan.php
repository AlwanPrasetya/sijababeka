<?php
// Pastikan ada koneksi ke database
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan ID FPK dari data POST
    $id_fpk = $_POST['id'];

    // Lakukan query untuk mendapatkan kodeFPK pegawai dari tabel fpk
    $sql_select_kodeFPK = "SELECT kodeFPK, persetujuanUser, persetujuanAdmin, persetujuanAtasan FROM fpk WHERE id_fpk = ?";
    $stmt_select_kodeFPK = $connection->prepare($sql_select_kodeFPK);
    $stmt_select_kodeFPK->bind_param("i", $id_fpk);
    $stmt_select_kodeFPK->execute();
    $result_select_kodeFPK = $stmt_select_kodeFPK->get_result();

    if ($result_select_kodeFPK->num_rows > 0) {
        // Ambil nilai kodeFPK pegawai
        $row = $result_select_kodeFPK->fetch_assoc();
        $kodeFPK = $row['kodeFPK'];
        $persetujuanUser = $row['persetujuanUser'];
        $persetujuanAdmin = $row['persetujuanAdmin'];
        $persetujuanAtasan = $row['persetujuanAtasan'];

        // Cek apakah semua persetujuan sudah disetujui
        if ($persetujuanUser === 'Disetujui' && $persetujuanAdmin === 'Disetujui' && $persetujuanAtasan === 'Disetujui') {
            // Jika ya, atur status_penyetujuan menjadi "Approved"
            $status_penyetujuan = "Pending";
        }

        // Lakukan query untuk memeriksa apakah sudah ada nilai kodeFPK di tabel persetujuan
        $sql_check_employee = "SELECT ID FROM persetujuan WHERE kodeFPK = ?";
        $stmt_check_employee = $connection->prepare($sql_check_employee);
        $stmt_check_employee->bind_param("s", $kodeFPK);
        $stmt_check_employee->execute();
        $result_check_employee = $stmt_check_employee->get_result();

        if ($result_check_employee->num_rows > 0) {
            // Jika sudah ada, lakukan pembaruan nilai PersetujuanAtasan
            $sql_update_persetujuan = "UPDATE persetujuan SET PersetujuanDireksi3 = 'Disetujui', Status_Penyetujuan = ? WHERE kodeFPK = ?";
            $stmt_update_persetujuan = $connection->prepare($sql_update_persetujuan);
            $stmt_update_persetujuan->bind_param("ss", $status_penyetujuan, $kodeFPK);

            if ($stmt_update_persetujuan->execute()) {
                // Jika pembaruan berhasil, lakukan pembaruan di tabel fpk
                $sql_update_fpk = "UPDATE fpk SET persetujuanDireksi3 = 'Disetujui' WHERE id_fpk = ?";
                $stmt_update_fpk = $connection->prepare($sql_update_fpk);
                $stmt_update_fpk->bind_param("i", $id_fpk);

                if ($stmt_update_fpk->execute()) {
                    // Set tanggal admin jika persetujuan HR Unit disetujui
                    if ($stmt_update_fpk->affected_rows > 0) {
                        $today = date("Y-m-d"); // Ambil tanggal hari ini

                        // Update field tglDireksi3 di tabel fpk
                        $sql_update_tgl_direksi3 = "UPDATE fpk SET tglDireksi3 = ? WHERE id_fpk = ?";
                        $stmt_update_tgl_direksi3 = $connection->prepare($sql_update_tgl_direksi3);
                        $stmt_update_tgl_direksi3->bind_param("si", $today, $id_fpk);
                        
                        if ($stmt_update_tgl_direksi3->execute()) {
                            echo "success";
                        } else {
                            echo "error_update_tgl_direksi3";
                        }

                        // Tutup statement pembaruan tgldireksi3
                        $stmt_update_tgl_direksi3->close();
                    }
                } else {
                    echo "error_update_fpk";
                }

                // Tutup statement pembaruan fpk
                $stmt_update_fpk->close();
            } else {
                echo "error_update_persetujuan";
            }

            // Tutup statement pembaruan PersetujuanAtasan
            $stmt_update_persetujuan->close();
        } else {
            // Jika belum ada, tambahkan baris baru dengan kodeFPK tersebut
            $sql_insert_persetujuan = "INSERT INTO persetujuan (kodeFPK, persetujuanUser, PersetujuanAtasan, PersetujuanDireksi2, PersetujuanDireksi3, PersetujuanAdmin, PersetujuanCorpHr, Status_Penyetujuan) 
                                       VALUES (?, ?, ?, ?, 'Disetujui', ?, ?, 'Pending')";
            $stmt_insert_persetujuan = $connection->prepare($sql_insert_persetujuan);
            $stmt_insert_persetujuan->bind_param("ss", $kodeFPK, $status_penyetujuan);

            if ($stmt_insert_persetujuan->execute()) {
                // Jika penambahan berhasil, lakukan pembaruan di tabel fpk
                $sql_update_fpk = "UPDATE fpk SET persetujuanDireksi3 = 'Disetujui' WHERE id_fpk = ?";
                $stmt_update_fpk = $connection->prepare($sql_update_fpk);
                $stmt_update_fpk->bind_param("i", $id_fpk);

                if ($stmt_update_fpk->execute()) {
                    echo "success";
                } else {
                    echo "error_update_fpk";
                }

                // Tutup statement pembaruan fpk
                $stmt_update_fpk->close();
            } else {
                echo "error_insert_persetujuan";
            }

            // Tutup statement penambahan baris baru di tabel persetujuan
            $stmt_insert_persetujuan->close();
        }

        // Tutup statement pengecekan kodeFPK di tabel persetujuan
        $stmt_check_employee->close();
    } else {
        echo "error_select_kodeFPK";
    }

    // Tutup statement mendapatkan kodeFPK pegawai dari tabel fpk
    $stmt_select_kodeFPK->close();
}

// Menutup koneksi database
$connection->close();
?>
