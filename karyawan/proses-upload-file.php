<?php
$servername = "localhost";
$username = "alwan";
$password = "root";
$dbname = "db_sijababeka";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if id_biodata is set in the URL
if (isset($_GET['id_biodata'])) {
    $id = $_GET['id_biodata'];
} else {
    die("Error: id_biodata not found in the URL.");
}

// Directory to save uploaded files
$target_dir = "uploads-file/";

function uploadFile($file, $target_dir)
{
    $file_name = basename($file["name"]);
    $target_file = $target_dir . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = array('pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx');

    // Check if file type is allowed
    if (in_array($file_type, $allowed_types)) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $file_name; // Return only the file name
        } else {
            return false;
        }
    } else {
        return false;
    }
}

$referensi_kerja = uploadFile($_FILES['referensi_kerja'], $target_dir);
$bpjs_ks = uploadFile($_FILES['bpjs_ks'], $target_dir);
$bpjs_kg = uploadFile($_FILES['bpjs_kg'], $target_dir);
$bpjs_jp = uploadFile($_FILES['bpjs_jp'], $target_dir);
$foto_ktp = uploadFile($_FILES['foto_ktp'], $target_dir);
$fc_ijazah = uploadFile($_FILES['fc_ijazah'], $target_dir);
$fc_tn = uploadFile($_FILES['fc_tn'], $target_dir);
$fc_bt = uploadFile($_FILES['fc_bt'], $target_dir);
$fc_npwp = uploadFile($_FILES['fc_npwp'], $target_dir);
$fc_kk = uploadFile($_FILES['fc_kk'], $target_dir);
$fc_sp = uploadFile($_FILES['fc_sp'], $target_dir);

if ($referensi_kerja && $bpjs_ks && $bpjs_kg && $bpjs_jp && $foto_ktp && $fc_ijazah && $fc_tn && $fc_bt && $fc_npwp && $fc_kk && $fc_sp) {
    $sql = "UPDATE biodata_karyawan SET 
                referensi_kerja='$referensi_kerja',
                bpjs_ks='$bpjs_ks',
                bpjs_kg='$bpjs_kg',
                bpjs_jp='$bpjs_jp',
                foto_ktp='$foto_ktp',
                fc_ijazah='$fc_ijazah',
                fc_tn='$fc_tn',
                fc_bt='$fc_bt',
                fc_npwp='$fc_npwp',
                fc_kk='$fc_kk',
                fc_sp='$fc_sp'
            WHERE id_biodata='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Sorry, there was an error uploading your files.";
    if (!$referensi_kerja) echo " Error uploading referensi_kerja.";
    if (!$bpjs_ks) echo " Error uploading BPJS Kesehatan.";
    if (!$bpjs_kg) echo " Error uploading BPJS Ketenagakerjaan.";
    if (!$bpjs_jp) echo " Error uploading BPJS Jaminan Pensiun.";
    if (!$foto_ktp) echo " Error uploading fotocopy KTP.";
    if (!$fc_ijazah) echo " Error uploading fc_ijazah.";
    if (!$fc_tn) echo " Error uploading fc_tn.";
    if (!$fc_bt) echo " Error uploading fc_bt.";
    if (!$fc_npwp) echo " Error uploading fc_npwp.";
    if (!$fc_kk) echo " Error uploading fc_kk.";
    if (!$fc_sp) echo " Error uploading fc_sp.";
}

$conn->close();
