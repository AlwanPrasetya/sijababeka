<?php
// Ambil data dari $_POST
$fpk_selection = $_POST['fpk_selection'];
$id_candidates = $_POST['id_candidates'];
$nama_kandidat = $_POST['nama_kandidat'];
$golongan = $_POST['golongan'];
$form_tanggal_lengkap = $_POST['form_tanggal_lengkap'];
$branch = $_POST['branch'];
$no_ktp = $_POST['no_ktp'];
$jabatan = $_POST['jabatan'];
$pendidikan = $_POST['pendidikan'];
$organisasi = $_POST['organisasi'];
$alasan_penerimaan = $_POST['alasan_penerimaan'];
$form_catatan = $_POST['form_catatan'];

// Data gaji dan tunjangan
$gaji_pokok = $_POST['check_gaji_pokok'];
$tunjangan_makan = $_POST['check_tunjangan_makan'];
$tunjangan_transport = $_POST['check_tunjangan_transport'];
$tunjangan_kendaraan = $_POST['check_tunjangan_kendaraan'];
$total_sallary_gross = $_POST['check_total_sallary_gross'];

// Data BPJS dan lainnya
$bpjs_jht = $_POST['check_bpjs_jht'];
$bpjs_jp = $_POST['check_bpjs_jp'];
$bpjs_ks = $_POST['check_bpjs_ks'];
$koperasi_karyawan = $_POST['check_koperasi_karyawan'];
$total_sallary_nett = $_POST['check_total_sallary_nett'];

// Additional form data
$form_aplikasi = $_POST['form_aplikasi'];
$pas_foto = $_POST['pas_foto'];
$form_interview_user = $_POST['form_interview_user'];
$foto_ktp = $_POST['foto_ktp'];
$form_interview_hr = $_POST['form_interview_hr'];
$foto_ijazah = $_POST['foto_ijazah'];
$form_hasil_psikotest = $_POST['form_hasil_psikotest'];
$foto_transkip_nilai = $_POST['foto_transkip_nilai'];
$form_confirmation_letter = $_POST['form_confirmation_letter'];
$foto_buku_tabungan = $_POST['foto_buku_tabungan'];
$form_hasil_tes_kesehatan = $_POST['form_hasil_tes_kesehatan'];
$foto_npwp = $_POST['foto_npwp'];
$referensi_kerja = $_POST['referensi_kerja'];
$foto_kk = $_POST['foto_kk'];
$foto_sertifikat = $_POST['foto_sertifikat'];
$bpjs_ketenagakerjaan = $_POST['bpjs_ketenagakerjaan'];
$bpjs_jaminan_pensiun = $_POST['bpjs_jaminan_pensiun'];
$bpjs_kesehatan = $_POST['bpjs_kesehatan'];


// Contoh koneksi ke database menggunakan PDO
$host = 'localhost';
$dbname = 'db_sijababeka';
$username = 'alwan';
$password = 'root';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Query untuk menyimpan data ke dalam tabel hc
  $sql = "INSERT INTO hcc (fpk_selection, id_candidates, nama_kandidat, golongan, form_tanggal_lengkap, branch, no_ktp, jabatan, pendidikan, organisasi, alasan_penerimaan, form_catatan, 
                           check_gaji_pokok, check_tunjangan_makan, check_tunjangan_transport, check_tunjangan_kendaraan, check_total_sallary_gross,
                           check_bpjs_jht, check_bpjs_jp, check_bpjs_ks, check_koperasi_karyawan, check_total_sallary_nett,
                           form_aplikasi, pas_foto, form_interview_user, foto_ktp, form_interview_hr, foto_ijazah,
                           form_hasil_psikotest, foto_transkip_nilai, form_confirmation_letter, foto_buku_tabungan,
                           form_hasil_tes_kesehatan, foto_npwp, referensi_kerja, foto_kk, foto_sertifikat,
                           bpjs_ketenagakerjaan, bpjs_jaminan_pensiun, bpjs_kesehatan)
            VALUES (:fpk_selection, :id_candidates, :nama_kandidat, :golongan, :form_tanggal_lengkap, :branch, :no_ktp, :jabatan, :pendidikan, :organisasi, :alasan_penerimaan, :form_catatan,
                    :check_gaji_pokok, :check_tunjangan_makan, :check_tunjangan_transport, :check_tunjangan_kendaraan, :check_total_sallary_gross,
                    :check_bpjs_jht, :check_bpjs_jp, :check_bpjs_ks, :check_koperasi_karyawan, :check_total_sallary_nett,
                    :form_aplikasi, :pas_foto, :form_interview_user, :foto_ktp, :form_interview_hr, :foto_ijazah,
                    :form_hasil_psikotest, :foto_transkip_nilai, :form_confirmation_letter, :foto_buku_tabungan,
                    :form_hasil_tes_kesehatan, :foto_npwp, :referensi_kerja, :foto_kk, :foto_sertifikat,
                    :bpjs_ketenagakerjaan, :bpjs_jaminan_pensiun, :bpjs_kesehatan)";

  $stmt = $pdo->prepare($sql);

  // Bind parameter ke placeholder
  $stmt->bindParam(':fpk_selection', $fpk_selection);
  $stmt->bindParam(':id_candidates', $id_candidates);
  $stmt->bindParam(':nama_kandidat', $nama_kandidat);
  $stmt->bindParam(':golongan', $golongan);
  $stmt->bindParam(':form_tanggal_lengkap', $form_tanggal_lengkap);
  $stmt->bindParam(':branch', $branch);
  $stmt->bindParam(':no_ktp', $no_ktp);
  $stmt->bindParam(':jabatan', $jabatan);
  $stmt->bindParam(':pendidikan', $pendidikan);
  $stmt->bindParam(':organisasi', $organisasi);
  $stmt->bindParam(':alasan_penerimaan', $alasan_penerimaan);
  $stmt->bindParam(':form_catatan', $form_catatan);

  // Bind gaji dan tunjangan
  $stmt->bindParam(':check_gaji_pokok', $gaji_pokok);
  $stmt->bindParam(':check_tunjangan_makan', $tunjangan_makan);
  $stmt->bindParam(':check_tunjangan_transport', $tunjangan_transport);
  $stmt->bindParam(':check_tunjangan_kendaraan', $tunjangan_kendaraan);
  $stmt->bindParam(':check_total_sallary_gross', $total_sallary_gross);

  // Bind BPJS dan lainnya
  $stmt->bindParam(':check_bpjs_jht', $bpjs_jht);
  $stmt->bindParam(':check_bpjs_jp', $bpjs_jp);
  $stmt->bindParam(':check_bpjs_ks', $bpjs_ks);
  $stmt->bindParam(':check_koperasi_karyawan', $koperasi_karyawan);
  $stmt->bindParam(':check_total_sallary_nett', $total_sallary_nett);

  // Bind additional form data
  $stmt->bindParam(':form_aplikasi', $form_aplikasi);
  $stmt->bindParam(':pas_foto', $pas_foto);
  $stmt->bindParam(':form_interview_user', $form_interview_user);
  $stmt->bindParam(':foto_ktp', $foto_ktp);
  $stmt->bindParam(':form_interview_hr', $form_interview_hr);
  $stmt->bindParam(':foto_ijazah', $foto_ijazah);
  $stmt->bindParam(':form_hasil_psikotest', $form_hasil_psikotest);
  $stmt->bindParam(':foto_transkip_nilai', $foto_transkip_nilai);
  $stmt->bindParam(':form_confirmation_letter', $form_confirmation_letter);
  $stmt->bindParam(':foto_buku_tabungan', $foto_buku_tabungan);
  $stmt->bindParam(':form_hasil_tes_kesehatan', $form_hasil_tes_kesehatan);
  $stmt->bindParam(':foto_npwp', $foto_npwp);
  $stmt->bindParam(':referensi_kerja', $referensi_kerja);
  $stmt->bindParam(':foto_kk', $foto_kk);
  $stmt->bindParam(':foto_sertifikat', $foto_sertifikat);
  $stmt->bindParam(':bpjs_ketenagakerjaan', $bpjs_ketenagakerjaan);
  $stmt->bindParam(':bpjs_jaminan_pensiun', $bpjs_jaminan_pensiun);
  $stmt->bindParam(':bpjs_kesehatan', $bpjs_kesehatan);


  // Eksekusi statement
  $stmt->execute();

  echo "Data berhasil disimpan.";
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

// Tutup koneksi database
unset($pdo);
