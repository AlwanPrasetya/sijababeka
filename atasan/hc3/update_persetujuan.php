<?php
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan ID hc dari data POST
    $id_hc = $_POST['id'];

    // Lakukan query untuk mendapatkan fpk_selection pegawai dari tabel hc
    $sql_select_fpk_selection = "SELECT fpk_selection FROM hcc WHERE id_hc = ?";
    $stmt_select_fpk_selection = $connection->prepare($sql_select_fpk_selection);
    $stmt_select_fpk_selection->bind_param("i", $id_hc);
    $stmt_select_fpk_selection->execute();
    $result_select_fpk_selection = $stmt_select_fpk_selection->get_result();

    if ($result_select_fpk_selection->num_rows > 0) {
        // Ambil nilai fpk_selection pegawai
        $row = $result_select_fpk_selection->fetch_assoc();
        $fpk_selection = $row['fpk_selection'];

        // Lakukan query untuk memeriksa apakah sudah ada nilai fpk_selection di tabel persetujuan
        $sql_check_employee = "SELECT ID FROM persetujuan_hc WHERE fpk_selection = ?";
        $stmt_check_employee = $connection->prepare($sql_check_employee);
        $stmt_check_employee->bind_param("s", $fpk_selection);
        $stmt_check_employee->execute();
        $result_check_employee = $stmt_check_employee->get_result();

        if ($result_check_employee->num_rows > 0) {
            // Jika sudah ada, lakukan pembaruan nilai PersetujuanAdmin jika persetujuanAtasan juga disetujui
            $sql_update_persetujuan = "UPDATE persetujuan_hc 
                                       SET PersetujuanAdmin = 'Disetujui' 
                                       WHERE fpk_selection = ? 
                                       AND persetujuanAtasan = ''";
            $stmt_update_persetujuan = $connection->prepare($sql_update_persetujuan);
            $stmt_update_persetujuan->bind_param("s", $fpk_selection);

            if ($stmt_update_persetujuan->execute()) {
                // Periksa apakah pembaruan berhasil
                if ($stmt_update_persetujuan->affected_rows > 0) {
                    // Perbarui status_penyetujuan jika kedua persetujuan sudah disetujui
                    $sql_update_status = "UPDATE persetujuan_hc 
                                          SET Status_Penyetujuan = 'Pending' 
                                          WHERE fpk_selection = ? 
                                          AND PersetujuanAtasan = 'Disetujui' 
                                          AND persetujuanAdmin = 'Disetujui'";
                    $stmt_update_status = $connection->prepare($sql_update_status);
                    $stmt_update_status->bind_param("s", $fpk_selection);

                    if ($stmt_update_status->execute()) {
                        // Jika status_penyetujuan berhasil diperbarui, lakukan pembaruan di tabel hc
                        $sql_update_hc = "UPDATE hcc
                                           SET persetujuanAdmin = 'Disetujui' 
                                           WHERE id_hc = ?";
                        $stmt_update_hc = $connection->prepare($sql_update_hc);
                        $stmt_update_hc->bind_param("i", $id_hc);

                        if ($stmt_update_hc->execute()) {
                            // Set tanggal admin jika persetujuan HR Unit disetujui
                            if ($stmt_update_hc->affected_rows > 0) {
                                $today = date("Y-m-d"); // Ambil tanggal hari ini

                                // Update field tglAdmin di tabel hc
                                $sql_update_tgl_admin = "UPDATE hcc SET tglAdmin = ? WHERE id_hc = ?";
                                $stmt_update_tgl_admin = $connection->prepare($sql_update_tgl_admin);
                                $stmt_update_tgl_admin->bind_param("si", $today, $id_hc);
                                
                                if ($stmt_update_tgl_admin->execute()) {
                                    echo "success";
                                } else {
                                    echo "error_update_tgl_admin";
                                }

                                // Tutup statement pembaruan tglAdmin
                                $stmt_update_tgl_admin->close();
                            }
                        } else {
                            echo "error_update_hc";
                        }

                        // Tutup statement pembaruan hc
                        $stmt_update_hc->close();
                    } else {
                        echo "error_update_status";
                    }

                    // Tutup statement pembaruan status_penyetujuan
                    $stmt_update_status->close();
                } else {
                    // Jika PersetujuanAdmin tidak diupdate karena persetujuanAtasan belum disetujui
                    echo "error_persetujuanAtasan_belum_disetujui";
                }
            } else {
                echo "error_update_persetujuan";
            }

            // Tutup statement pembaruan PersetujuanAdmin
            $stmt_update_persetujuan->close();
        } else {
            // Jika belum ada, tambahkan baris baru dengan fpk_selection tersebut
            $sql_insert_persetujuan = "INSERT INTO persetujuan_hc (fpk_selection, PersetujuanUser, PersetujuanAdmin, PersetujuanAtasan, PersetujuanDireksi2, PersetujuanDireksi3, PersetujuanPresdir, PersetujuanCorpHr, PersetujuanSuperadmin, Status_Penyetujuan) 
                                       VALUES (?, '', 'Disetujui', '', '', '', '', '', '', 'Pending')";
            $stmt_insert_persetujuan = $connection->prepare($sql_insert_persetujuan);
            $stmt_insert_persetujuan->bind_param("s", $fpk_selection);

            if ($stmt_insert_persetujuan->execute()) {
                // Jika penambahan berhasil, lakukan pembaruan di tabel hc
                $sql_update_hc = "UPDATE hcc SET persetujuanAdmin = 'Disetujui' WHERE id_hc = ?";
                $stmt_update_hc = $connection->prepare($sql_update_hc);
                $stmt_update_hc->bind_param("i", $id_hc);

                if ($stmt_update_hc->execute()) {
                    // Set tanggal admin jika persetujuan HR Unit disetujui
                    if ($stmt_update_hc->affected_rows > 0) {
                        $today = date("Y-m-d"); // Ambil tanggal hari ini

                        // Update field tglAdmin di tabel hc
                        $sql_update_tgl_admin = "UPDATE hcc SET tglAdmin = ? WHERE id_hc = ?";
                        $stmt_update_tgl_admin = $connection->prepare($sql_update_tgl_admin);
                        $stmt_update_tgl_admin->bind_param("si", $today, $id_hc);
                        
                        if ($stmt_update_tgl_admin->execute()) {
                            echo "success";
                        } else {
                            echo "error_update_tgl_admin";
                        }

                        // Tutup statement pembaruan tglAdmin
                        $stmt_update_tgl_admin->close();
                    }
                } else {
                    echo "error_update_hc";
                }

                // Tutup statement pembaruan hc
                $stmt_update_hc->close();
            } else {
                echo "error_insert_persetujuan";
            }

            // Tutup statement penambahan baris baru di tabel persetujuan
            $stmt_insert_persetujuan->close();
        }

        // Tutup statement pengecekan fpk_selection di tabel persetujuan
        $stmt_check_employee->close();
    } else {
        echo "error_select_fpk_selection";
    }

    // Tutup statement mendapatkan fpk_selection pegawai dari tabel hc
    $stmt_select_fpk_selection->close();
}

// Menutup koneksi database
$connection->close();
?>
