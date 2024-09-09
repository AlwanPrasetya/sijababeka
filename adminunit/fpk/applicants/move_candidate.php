<?php
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['moveCandidate'])) {
    $id = $_POST['id'];

    // Update level_candidates menjadi 1 berdasarkan id
    $query = "UPDATE applicants SET level_candidates = 1 WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
      // Redirect ke halaman awal dan reload
      header("Location: {$_SERVER['HTTP_REFERER']}");
      exit();
    } else {
      echo "Terjadi kesalahan: " . $stmt->error;
    }

    $stmt->close();
  }
}

$connection->close();
