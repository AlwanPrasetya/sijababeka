<?php
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan ID FPK dari data POST
    $id_fpk = $_POST['id'];

    // Mendapatkan organisasi dan kodeFPK berdasarkan ID FPK
    $sql = "SELECT organisasi, kodeFPK FROM fpk WHERE id_fpk = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id_fpk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $organisasi = $row['organisasi'];
        $kodeFPK = $row['kodeFPK'];

        // Lakukan INSERT atau UPDATE di tabel hiring_positions menggunakan ON DUPLICATE KEY UPDATE
        $sql_insert_update = "INSERT INTO hiring_positions (kodeFPK, posisi, applicants) VALUES (?, ?, 0) 
            ON DUPLICATE KEY UPDATE posisi = VALUES(posisi), applicants = 0";
        $stmt_insert_update = $connection->prepare($sql_insert_update);
        $stmt_insert_update->bind_param("ss", $kodeFPK, $organisasi);
        $stmt_insert_update->execute();

        if ($stmt_insert_update->affected_rows > 0) {
            echo "success";
        } else {
            echo "error_insert_update_hiring_positions";
        }

        $stmt_insert_update->close();
    } else {
        echo "error_select_organisasi";
    }

    $stmt->close();
} else {
    echo "No post data received";
}

$connection->close();
