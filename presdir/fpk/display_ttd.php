<?php
// Ambil nilai persetujuanCorpHr dari parameter GET
$persetujuanCorpHr = isset($_GET['persetujuanCorpHr']) ? $_GET['persetujuanCorpHr'] : '';

// Tentukan tanda tangan yang akan ditampilkan berdasarkan nilai persetujuanCorpHr
$ttdImage = ($persetujuanCorpHr === 'Disetujui') ? 'ttd/img/reza.png' : 'ttd/img/hidden_signature.png';

// Output tanda tangan sebagai gambar
echo "<img class='ttd-image' src='$ttdImage' alt='Tanda Tangan User' style='max-width: 100%; height: auto;'>";
?>
