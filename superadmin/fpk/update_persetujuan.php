<?php
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan ID FPK dari data POST
    $id_fpk = $_POST['id'];

    // Lakukan query untuk mendapatkan kodeFPK pegawai dari tabel fpk
    $sql_select_kodeFPK = "SELECT kodeFPK, organisasi, persetujuanUser, persetujuanAdmin, persetujuanAtasan, persetujuanDireksi2, persetujuanDireksi3, persetujuanCorpHr, persetujuanSuperadmin  FROM fpk WHERE id_fpk = ?";
    $stmt_select_kodeFPK = $connection->prepare($sql_select_kodeFPK);
    $stmt_select_kodeFPK->bind_param("i", $id_fpk);
    $stmt_select_kodeFPK->execute();
    $result_select_kodeFPK = $stmt_select_kodeFPK->get_result();

    if ($result_select_kodeFPK->num_rows > 0) {
        // Ambil nilai kodeFPK pegawai
        $row = $result_select_kodeFPK->fetch_assoc();
        $kodeFPK = $row['kodeFPK'];
        $organisasi = $row['organisasi'];
        $persetujuanUser = $row['persetujuanUser'];
        $persetujuanAdmin = $row['persetujuanAdmin'];
        $persetujuanAtasan = $row['persetujuanAtasan'];
        $persetujuanDireksi2 = $row['persetujuanDireksi2'];
        $persetujuanDireksi3 = $row['persetujuanDireksi3'];
        $persetujuanCorpHr = $row['persetujuanCorpHr'];
        $persetujuanSuperadmin = $row['persetujuanSuperadmin'];

        // Cek apakah semua persetujuan sudah disetujui
        if ($persetujuanUser === 'Disetujui' && $persetujuanAdmin === 'Disetujui' &&  $persetujuanDireksi3 === 'Disetujui' &&  $persetujuanCorpHr === 'Disetujui' && $persetujuanSuperadmin === 'Disetujui') {
            // Jika ya, atur status_penyetujuan menjadi "Approved"
            $status_penyetujuan = "Approved";
        }

        // Lakukan query untuk memeriksa apakah sudah ada nilai kodeFPK di tabel persetujuan
        $sql_check_employee = "SELECT ID FROM persetujuan WHERE kodeFPK = ?";
        $stmt_check_employee = $connection->prepare($sql_check_employee);
        $stmt_check_employee->bind_param("s", $kodeFPK);
        $stmt_check_employee->execute();
        $result_check_employee = $stmt_check_employee->get_result();

        if ($result_check_employee->num_rows > 0) {
            // Jika sudah ada, lakukan pembaruan nilai PersetujuanAtasan
            $sql_update_persetujuan = "UPDATE persetujuan SET persetujuanAdmin = 'Disetujui', persetujuanUser = 'Disetujui', PersetujuanDireksi3 = 'Disetujui', PersetujuanCorpHr = 'Disetujui', PersetujuanSuperadmin = 'Disetujui', Status_Penyetujuan = ? WHERE kodeFPK = ?";
            $stmt_update_persetujuan = $connection->prepare($sql_update_persetujuan);
            $stmt_update_persetujuan->bind_param("ss", $status_penyetujuan, $kodeFPK);

            if ($stmt_update_persetujuan->execute()) {
                // Jika pembaruan berhasil, lakukan pembaruan di tabel fpk
                $sql_update_fpk = "UPDATE fpk SET persetujuanAdmin = 'Disetujui', persetujuanUser = 'Disetujui', persetujuanDireksi3 = 'Disetujui', PersetujuanCorpHr = 'Disetujui', persetujuanSuperadmin = 'Disetujui' WHERE id_fpk = ?";
                $stmt_update_fpk = $connection->prepare($sql_update_fpk);
                $stmt_update_fpk->bind_param("i", $id_fpk);

                if ($stmt_update_fpk->execute()) {
                    // Set tanggal superadmin jika persetujuan HR Unit disetujui
                    if ($stmt_update_fpk->affected_rows > 0) {
                        $today = date("Y-m-d"); // Ambil tanggal hari ini

                        // Update field tglsuperadmin di tabel fpk
                        $sql_update_tgl_superadmin = "UPDATE fpk SET tglSuperadmin = ? WHERE id_fpk = ?";
                        $stmt_update_tgl_superadmin = $connection->prepare($sql_update_tgl_superadmin);
                        $stmt_update_tgl_superadmin->bind_param("si", $today, $id_fpk);
                        
                        if ($stmt_update_tgl_superadmin->execute()) {
                            echo "success";
                        } else {
                            echo "error_update_tgl_superadmin";
                        }

                        // Tutup statement pembaruan tglsuperadmin
                        $stmt_update_tgl_superadmin->close();
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
            $sql_insert_persetujuan = "INSERT INTO persetujuan (kodeFPK, persetujuanUser, PersetujuanAtasan, PersetujuanDireksi2, PersetujuanDireksi3, PersetujuanAdmin, PersetujuanCorpHr, PersetujuanSuperadmin, Status_Penyetujuan) 
                                       VALUES (?, ?, ?, ?, ?, ?, ?, 'Disetujui', 'Pending')";
            $stmt_insert_persetujuan = $connection->prepare($sql_insert_persetujuan);
            $stmt_insert_persetujuan->bind_param("ss", $kodeFPK, $status_penyetujuan);

            if ($stmt_insert_persetujuan->execute()) {
                // Jika penambahan berhasil, lakukan pembaruan di tabel fpk
                $sql_update_fpk = "UPDATE fpk SET persetujuanSuperadmin = 'Disetujui' WHERE id_fpk = ?";
                $stmt_update_fpk = $connection->prepare($sql_update_fpk);
                $stmt_update_fpk->bind_param("i", $id_fpk);

                if ($stmt_update_fpk->execute()) {
                    // Set tanggal Superadmin jika persetujuan HR Unit disetujui
                    if ($stmt_update_fpk->affected_rows > 0) {
                        $today = date("Y-m-d"); // Ambil tanggal hari ini

                        // Update field tglSuperadmin di tabel fpk
                        $sql_update_tgl_superadmin = "UPDATE fpk SET tglSuperadmin = ? WHERE id_fpk = ?";
                        $stmt_update_tgl_superadmin = $connection->prepare($sql_update_tgl_superadmin);
                        $stmt_update_tgl_superadmin->bind_param("si", $today, $id_fpk);
                        
                        if ($stmt_update_tgl_superadmin->execute()) {
                            echo "success";
                        } else {
                            echo "error_update_tgl_superadmin";
                        }

                        // Tutup statement pembaruan tglsuperadmin
                        $stmt_update_tgl_superadmin->close();
                    }
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

// Query to select hiring positions data including organisasi field
$query = "SELECT fpk.kodeFPK, fpk.organisasi as posisi, hp.kandidat, hp.interviewHr, hp.interviewUser, hp.psikotes, hp.offer, hp.accept, hp.cvBank
          FROM hiring_positions hp
          INNER JOIN fpk ON hp.kodeFPK = fpk.kodeFPK";
$result = mysqli_query($connection, $query);

// Insert data into hiring_positions table
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql_insert_hiring_positions = "INSERT INTO hiring_positions (kodeFPK, posisi, kandidat, interviewHr, interviewUser, psikotes, offer, accept, cvBank) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert_hiring_positions = $connection->prepare($sql_insert_hiring_positions);
    $stmt_insert_hiring_positions->bind_param("sssssssss", $kodeFPK, $organisasi, $kandidat, $interviewHr, $interviewUser, $psikotes, $offer, $accept, $cvBank);

    // Set parameters and execute the statement
    $kandidat = $_POST['kandidat'];
    $interviewHr = $_POST['interviewHr'];
    $interviewUser = $_POST['interviewUser'];
    $psikotes = $_POST['psikotes'];
    $offer = $_POST['offer'];
    $accept = $_POST['accept'];
    $cvBank = $_POST['cvBank'];

    if ($stmt_insert_hiring_positions->execute()) {
        echo "Data inserted successfully into hiring_positions table.";
    } else {
        echo "Error inserting data into hiring_positions table: " . $stmt_insert_hiring_positions->error;
    }

    // Close the statement
    $stmt_insert_hiring_positions->close();
}


?>
