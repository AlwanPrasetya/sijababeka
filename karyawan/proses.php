<?php
// proses.php

// Konfigurasi koneksi ke database
$host = 'localhost';
$dbname = 'db_sijababeka';
$username = 'alwan';
$password = 'root';

try {
    // Koneksi ke database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Atur mode error untuk PDO ke Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ambil data dari form
    $status_keluarga = isset($_POST['status_keluarga']) ? $_POST['status_keluarga'] : [];
    $nama = isset($_POST['nama']) ? $_POST['nama'] : [];
    $jenis_kelamin_status_keluarga = isset($_POST['jenis_kelamin_status_keluarga']) ? $_POST['jenis_kelamin_status_keluarga'] : [];
    $tm_lahir = isset($_POST['tm_lahir']) ? $_POST['tm_lahir'] : [];
    $tgl_lahir = isset($_POST['tgl_lahir']) ? $_POST['tgl_lahir'] : [];
    $pekerjaan = isset($_POST['pekerjaan']) ? $_POST['pekerjaan'] : [];


    // Persiapan variabel untuk menyimpan data

    $nama_suami = null;
    $tempat_lahir_suami = null;
    $tanggal_lahir_suami = null;
    $pekerjaan_suami = null;

    // // Variabel untuk menyimpan data anak-anak
    // $nama_anak = array_fill(0, 10, null);
    // $jk_anak = array_fill(0, 10, null);
    // $tempat_lahir_anak = array_fill(0, 10, null);
    // $tanggal_lahir_anak = array_fill(0, 10, null);

    // // Iterasi untuk menyimpan data berdasarkan status keluarga
    // $anak_index = 0;
    // for ($i = 0; $i < count($status_keluarga); $i++) {
    //     if (isset($nama[$i], $tempat_lahir[$i], $tgl_lahir[$i], $pekerjaan[$i])) {
    //         if ($status_keluarga[$i] === 'Suami') {
    //             $nama_suami = $nama[$i];
    //             $tempat_lahir_suami = $tempat_lahir[$i];
    //             $tanggal_lahir_suami = $tgl_lahir[$i];
    //             $pekerjaan_suami = $pekerjaan[$i];
    //         } elseif ($status_keluarga[$i] === 'Anak' && $anak_index < 10) {
    //             if (isset($jenis_kelamin_status_keluarga[$i])) {
    //                 $nama_anak[$anak_index] = $nama[$i];
    //                 $jk_anak[$anak_index] = $jenis_kelamin_status_keluarga[$i];
    //                 $tempat_lahir_anak[$anak_index] = $tempat_lahir[$i];
    //                 $tanggal_lahir_anak[$anak_index] = $tgl_lahir[$i];
    //                 $anak_index++;
    //             }
    //         }
    //     }
    // }


    // Personal biodata
    $id_biodata = isset($_POST['id_biodata']) ? htmlspecialchars(trim($_POST['id_biodata'])) : '';
    $posisi = isset($_POST['posisi']) ? htmlspecialchars(trim($_POST['posisi'])) : '';
    $nama_lengkap = isset($_POST['nama_lengkap']) ? htmlspecialchars(trim($_POST['nama_lengkap'])) : '';
    $nama_panggilan = isset($_POST['nama_panggilan']) ? htmlspecialchars(trim($_POST['nama_panggilan'])) : '';
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? htmlspecialchars(trim($_POST['jenis_kelamin'])) : '';
    $golongan_darah = isset($_POST['golongan_darah']) ? htmlspecialchars(trim($_POST['golongan_darah'])) : '';
    $tempat_lahir = isset($_POST['tempat_lahir']) ? htmlspecialchars(trim($_POST['tempat_lahir'])) : '';
    $tanggal_lahir = isset($_POST['tanggal_lahir']) ? htmlspecialchars(trim($_POST['tanggal_lahir'])) : '';
    $no_ktp = isset($_POST['no_ktp']) ? htmlspecialchars(trim($_POST['no_ktp'])) : '';
    $no_npwp = isset($_POST['no_npwp']) ? htmlspecialchars(trim($_POST['no_npwp'])) : '';
    $kewarganegaraan = isset($_POST['kewarganegaraan']) ? htmlspecialchars(trim($_POST['kewarganegaraan'])) : '';
    $agama = isset($_POST['agama']) ? htmlspecialchars(trim($_POST['agama'])) : '';
    $no_tlpn_rumah = isset($_POST['no_tlpn_rumah']) ? htmlspecialchars(trim($_POST['no_tlpn_rumah'])) : '';
    $no_tlpn = isset($_POST['no_tlpn']) ? htmlspecialchars(trim($_POST['no_tlpn'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';

    // KTP address fields
    $alamat_ktp = isset($_POST['alamat_ktp']) ? htmlspecialchars(trim($_POST['alamat_ktp'])) : '';
    $rt = isset($_POST['rt']) ? htmlspecialchars(trim($_POST['rt'])) : '';
    $rw = isset($_POST['rw']) ? htmlspecialchars(trim($_POST['rw'])) : '';
    $kelurahan = isset($_POST['kelurahan']) ? htmlspecialchars(trim($_POST['kelurahan'])) : '';
    $kecamatan = isset($_POST['kecamatan']) ? htmlspecialchars(trim($_POST['kecamatan'])) : '';
    $kota = isset($_POST['kota']) ? htmlspecialchars(trim($_POST['kota'])) : '';
    $provinsi = isset($_POST['provinsi']) ? htmlspecialchars(trim($_POST['provinsi'])) : '';
    $kode_pos = isset($_POST['kode_pos']) ? htmlspecialchars(trim($_POST['kode_pos'])) : '';

    // Current address
    $alamat_domisili = isset($_POST['alamat_domisili']) ? htmlspecialchars(trim($_POST['alamat_domisili'])) : '';

    // Emergency contact
    $nama_kd = isset($_POST['nama_kd']) ? htmlspecialchars(trim($_POST['nama_kd'])) : '';
    $no_tlpn_kd = isset($_POST['no_tlpn_kd']) ? htmlspecialchars(trim($_POST['no_tlpn_kd'])) : '';
    $hubungan_kd = isset($_POST['hubungan_kd']) ? htmlspecialchars(trim($_POST['hubungan_kd'])) : '';
    $alamat_kd = isset($_POST['alamat_kd']) ? htmlspecialchars(trim($_POST['alamat_kd'])) : '';

    // Status
    $status = isset($_POST['status']) ? htmlspecialchars(trim($_POST['status'])) : '';

    // Keluarga - Istri
    $nama_istri = isset($_POST['nama_istri']) ? htmlspecialchars(trim($_POST['nama_istri'])) : '';
    $tempat_lahir_istri = isset($_POST['tempat_lahir_istri']) ? htmlspecialchars(trim($_POST['tempat_lahir_istri'])) : '';
    $tanggal_lahir_istri = isset($_POST['tanggal_lahir_istri']) ? htmlspecialchars(trim($_POST['tanggal_lahir_istri'])) : '';
    $pekerjaan_istri = isset($_POST['pekerjaan_istri']) ? htmlspecialchars(trim($_POST['pekerjaan_istri'])) : '';
    // Keluarga - Suami
    $nama_suami = isset($_POST['nama_suami']) ? htmlspecialchars(trim($_POST['nama_suami'])) : '';
    $tempat_lahir_suami = isset($_POST['tempat_lahir_suami']) ? htmlspecialchars(trim($_POST['tempat_lahir_suami'])) : '';
    $tanggal_lahir_suami = isset($_POST['tanggal_lahir_suami']) ? htmlspecialchars(trim($_POST['tanggal_lahir_suami'])) : '';
    $pekerjaan_suami = isset($_POST['pekerjaan_suami']) ? htmlspecialchars(trim($_POST['pekerjaan_suami'])) : '';
    // Keluarga - Anak 1
    $nama_anak_1 = isset($_POST['nama_anak_1']) ? htmlspecialchars(trim($_POST['nama_anak_1'])) : '';
    $jk_anak_1 = isset($_POST['jk_anak_1']) ? htmlspecialchars(trim($_POST['jk_anak_1'])) : '';
    $tempat_lahir_anak_1 = isset($_POST['tempat_lahir_anak_1']) ? htmlspecialchars(trim($_POST['tempat_lahir_anak_1'])) : '';
    $tanggal_lahir_anak_1 = isset($_POST['tanggal_lahir_anak_1']) ? htmlspecialchars(trim($_POST['tanggal_lahir_anak_1'])) : '';
    $pekerjaan_anak_1 = isset($_POST['pekerjaan_anak_1']) ? htmlspecialchars(trim($_POST['pekerjaan_anak_1'])) : '';
    // Keluarga - Anak 2
    $nama_anak_2 = isset($_POST['nama_anak_2']) ? htmlspecialchars(trim($_POST['nama_anak_2'])) : '';
    $jk_anak_2 = isset($_POST['jk_anak_2']) ? htmlspecialchars(trim($_POST['jk_anak_2'])) : '';
    $tempat_lahir_anak_2 = isset($_POST['tempat_lahir_anak_2']) ? htmlspecialchars(trim($_POST['tempat_lahir_anak_2'])) : '';
    $tanggal_lahir_anak_2 = isset($_POST['tanggal_lahir_anak_2']) ? htmlspecialchars(trim($_POST['tanggal_lahir_anak_2'])) : '';
    $pekerjaan_anak_2 = isset($_POST['pekerjaan_anak_2']) ? htmlspecialchars(trim($_POST['pekerjaan_anak_2'])) : '';
    // Keluarga - Anak 3
    $nama_anak_3 = isset($_POST['nama_anak_3']) ? htmlspecialchars(trim($_POST['nama_anak_3'])) : '';
    $jk_anak_3 = isset($_POST['jk_anak_3']) ? htmlspecialchars(trim($_POST['jk_anak_3'])) : '';
    $tempat_lahir_anak_3 = isset($_POST['tempat_lahir_anak_3']) ? htmlspecialchars(trim($_POST['tempat_lahir_anak_3'])) : '';
    $tanggal_lahir_anak_3 = isset($_POST['tanggal_lahir_anak_3']) ? htmlspecialchars(trim($_POST['tanggal_lahir_anak_3'])) : '';
    $pekerjaan_anak_3 = isset($_POST['pekerjaan_anak_3']) ? htmlspecialchars(trim($_POST['pekerjaan_anak_3'])) : '';
    // Keluarga - Anak 4
    $nama_anak_4 = isset($_POST['nama_anak_4']) ? htmlspecialchars(trim($_POST['nama_anak_4'])) : '';
    $jk_anak_4 = isset($_POST['jk_anak_4']) ? htmlspecialchars(trim($_POST['jk_anak_4'])) : '';
    $tempat_lahir_anak_4 = isset($_POST['tempat_lahir_anak_4']) ? htmlspecialchars(trim($_POST['tempat_lahir_anak_4'])) : '';
    $tanggal_lahir_anak_4 = isset($_POST['tanggal_lahir_anak_4']) ? htmlspecialchars(trim($_POST['tanggal_lahir_anak_4'])) : '';
    $pekerjaan_anak_4 = isset($_POST['pekerjaan_anak_4']) ? htmlspecialchars(trim($_POST['pekerjaan_anak_4'])) : '';
    // Keluarga - Anak 5
    $nama_anak_5 = isset($_POST['nama_anak_5']) ? htmlspecialchars(trim($_POST['nama_anak_5'])) : '';
    $jk_anak_5 = isset($_POST['jk_anak_5']) ? htmlspecialchars(trim($_POST['jk_anak_5'])) : '';
    $tempat_lahir_anak_5 = isset($_POST['tempat_lahir_anak_5']) ? htmlspecialchars(trim($_POST['tempat_lahir_anak_5'])) : '';
    $tanggal_lahir_anak_5 = isset($_POST['tanggal_lahir_anak_5']) ? htmlspecialchars(trim($_POST['tanggal_lahir_anak_5'])) : '';
    $pekerjaan_anak_5 = isset($_POST['pekerjaan_anak_5']) ? htmlspecialchars(trim($_POST['pekerjaan_anak_5'])) : '';
    // Keluarga - Anak 6
    $nama_anak_6 = isset($_POST['nama_anak_6']) ? htmlspecialchars(trim($_POST['nama_anak_6'])) : '';
    $jk_anak_6 = isset($_POST['jk_anak_6']) ? htmlspecialchars(trim($_POST['jk_anak_6'])) : '';
    $tempat_lahir_anak_6 = isset($_POST['tempat_lahir_anak_6']) ? htmlspecialchars(trim($_POST['tempat_lahir_anak_6'])) : '';
    $tanggal_lahir_anak_6 = isset($_POST['tanggal_lahir_anak_6']) ? htmlspecialchars(trim($_POST['tanggal_lahir_anak_6'])) : '';
    $pekerjaan_anak_6 = isset($_POST['pekerjaan_anak_6']) ? htmlspecialchars(trim($_POST['pekerjaan_anak_6'])) : '';
    // Keluarga - Anak 7
    $nama_anak_7 = isset($_POST['nama_anak_7']) ? htmlspecialchars(trim($_POST['nama_anak_7'])) : '';
    $jk_anak_7 = isset($_POST['jk_anak_7']) ? htmlspecialchars(trim($_POST['jk_anak_7'])) : '';
    $tempat_lahir_anak_7 = isset($_POST['tempat_lahir_anak_7']) ? htmlspecialchars(trim($_POST['tempat_lahir_anak_7'])) : '';
    $tanggal_lahir_anak_7 = isset($_POST['tanggal_lahir_anak_7']) ? htmlspecialchars(trim($_POST['tanggal_lahir_anak_7'])) : '';
    $pekerjaan_anak_7 = isset($_POST['pekerjaan_anak_7']) ? htmlspecialchars(trim($_POST['pekerjaan_anak_7'])) : '';
    // Keluarga - Anak 8
    $nama_anak_8 = isset($_POST['nama_anak_8']) ? htmlspecialchars(trim($_POST['nama_anak_8'])) : '';
    $jk_anak_8 = isset($_POST['jk_anak_8']) ? htmlspecialchars(trim($_POST['jk_anak_8'])) : '';
    $tempat_lahir_anak_8 = isset($_POST['tempat_lahir_anak_8']) ? htmlspecialchars(trim($_POST['tempat_lahir_anak_8'])) : '';
    $tanggal_lahir_anak_8 = isset($_POST['tanggal_lahir_anak_8']) ? htmlspecialchars(trim($_POST['tanggal_lahir_anak_8'])) : '';
    $pekerjaan_anak_8 = isset($_POST['pekerjaan_anak_8']) ? htmlspecialchars(trim($_POST['pekerjaan_anak_8'])) : '';
    // Keluarga - Anak 9
    $nama_anak_9 = isset($_POST['nama_anak_9']) ? htmlspecialchars(trim($_POST['nama_anak_9'])) : '';
    $jk_anak_9 = isset($_POST['jk_anak_9']) ? htmlspecialchars(trim($_POST['jk_anak_9'])) : '';
    $tempat_lahir_anak_9 = isset($_POST['tempat_lahir_anak_9']) ? htmlspecialchars(trim($_POST['tempat_lahir_anak_9'])) : '';
    $tanggal_lahir_anak_9 = isset($_POST['tanggal_lahir_anak_9']) ? htmlspecialchars(trim($_POST['tanggal_lahir_anak_9'])) : '';
    $pekerjaan_anak_9 = isset($_POST['pekerjaan_anak_9']) ? htmlspecialchars(trim($_POST['pekerjaan_anak_9'])) : '';
    // Keluarga - Anak 10
    $nama_anak_10 = isset($_POST['nama_anak_10']) ? htmlspecialchars(trim($_POST['nama_anak_10'])) : '';
    $jk_anak_10 = isset($_POST['jk_anak_10']) ? htmlspecialchars(trim($_POST['jk_anak_10'])) : '';
    $tempat_lahir_anak_10 = isset($_POST['tempat_lahir_anak_10']) ? htmlspecialchars(trim($_POST['tempat_lahir_anak_10'])) : '';
    $tanggal_lahir_anak_10 = isset($_POST['tanggal_lahir_anak_10']) ? htmlspecialchars(trim($_POST['tanggal_lahir_anak_10'])) : '';
    $pekerjaan_anak_10 = isset($_POST['pekerjaan_anak_10']) ? htmlspecialchars(trim($_POST['pekerjaan_anak_10'])) : '';

    // Keluarga Orang Tua dan Saudara - Ayah
    $nama_ayah = isset($_POST['nama_ayah']) ? htmlspecialchars(trim($_POST['nama_ayah'])) : '';
    $tempat_lahir_ayah = isset($_POST['tempat_lahir_ayah']) ? htmlspecialchars(trim($_POST['tempat_lahir_ayah'])) : '';
    $tanggal_lahir_ayah = isset($_POST['tanggal_lahir_ayah']) ? htmlspecialchars(trim($_POST['tanggal_lahir_ayah'])) : '';
    $pekerjaan_ayah = isset($_POST['pekerjaan_ayah']) ? htmlspecialchars(trim($_POST['pekerjaan_ayah'])) : '';
    // Keluarga Orang Tua dan Saudara - Ibu
    $nama_ibu = isset($_POST['nama_ibu']) ? htmlspecialchars(trim($_POST['nama_ibu'])) : '';
    $tempat_lahir_ibu = isset($_POST['tempat_lahir_ibu']) ? htmlspecialchars(trim($_POST['tempat_lahir_ibu'])) : '';
    $tanggal_lahir_ibu = isset($_POST['tanggal_lahir_ibu']) ? htmlspecialchars(trim($_POST['tanggal_lahir_ibu'])) : '';
    $pekerjaan_ibu = isset($_POST['pekerjaan_ibu']) ? htmlspecialchars(trim($_POST['pekerjaan_ibu'])) : '';
    // Keluarga Orang Tua dan Saudara - Anak Pertama
    $nama_pertama = isset($_POST['nama_pertama']) ? htmlspecialchars(trim($_POST['nama_pertama'])) : '';
    $jk_pertama = isset($_POST['jk_pertama']) ? htmlspecialchars(trim($_POST['jk_pertama'])) : '';
    $tempat_lahir_pertama = isset($_POST['tempat_lahir_pertama']) ? htmlspecialchars(trim($_POST['tempat_lahir_pertama'])) : '';
    $tanggal_lahir_pertama = isset($_POST['tanggal_lahir_pertama']) ? htmlspecialchars(trim($_POST['tanggal_lahir_pertama'])) : '';
    $pekerjaan_pertama = isset($_POST['pekerjaan_pertama']) ? htmlspecialchars(trim($_POST['pekerjaan_pertama'])) : '';
    // Keluarga Orang Tua dan Saudara - Anak Kedua
    $nama_kedua = isset($_POST['nama_kedua']) ? htmlspecialchars(trim($_POST['nama_kedua'])) : '';
    $jk_kedua = isset($_POST['jk_kedua']) ? htmlspecialchars(trim($_POST['jk_kedua'])) : '';
    $tempat_lahir_kedua = isset($_POST['tempat_lahir_kedua']) ? htmlspecialchars(trim($_POST['tempat_lahir_kedua'])) : '';
    $tanggal_lahir_kedua = isset($_POST['tanggal_lahir_kedua']) ? htmlspecialchars(trim($_POST['tanggal_lahir_kedua'])) : '';
    $pekerjaan_kedua = isset($_POST['pekerjaan_kedua']) ? htmlspecialchars(trim($_POST['pekerjaan_kedua'])) : '';
    // Keluarga Orang Tua dan Saudara - Anak Ketiga
    $nama_ketiga = isset($_POST['nama_ketiga']) ? htmlspecialchars(trim($_POST['nama_ketiga'])) : '';
    $jk_ketiga = isset($_POST['jk_ketiga']) ? htmlspecialchars(trim($_POST['jk_ketiga'])) : '';
    $tempat_lahir_ketiga = isset($_POST['tempat_lahir_ketiga']) ? htmlspecialchars(trim($_POST['tempat_lahir_ketiga'])) : '';
    $tanggal_lahir_ketiga = isset($_POST['tanggal_lahir_ketiga']) ? htmlspecialchars(trim($_POST['tanggal_lahir_ketiga'])) : '';
    $pekerjaan_ketiga = isset($_POST['pekerjaan_ketiga']) ? htmlspecialchars(trim($_POST['pekerjaan_ketiga'])) : '';
    // Keluarga Orang Tua dan Saudara - Anak Keempat
    $nama_keempat = isset($_POST['nama_keempat']) ? htmlspecialchars(trim($_POST['nama_keempat'])) : '';
    $jk_keempat = isset($_POST['jk_keempat']) ? htmlspecialchars(trim($_POST['jk_keempat'])) : '';
    $tempat_lahir_keempat = isset($_POST['tempat_lahir_keempat']) ? htmlspecialchars(trim($_POST['tempat_lahir_keempat'])) : '';
    $tanggal_lahir_keempat = isset($_POST['tanggal_lahir_keempat']) ? htmlspecialchars(trim($_POST['tanggal_lahir_keempat'])) : '';
    $pekerjaan_keempat = isset($_POST['pekerjaan_keempat']) ? htmlspecialchars(trim($_POST['pekerjaan_keempat'])) : '';
    // Keluarga Orang Tua dan Saudara - Anak Kelima
    $nama_kelima = isset($_POST['nama_kelima']) ? htmlspecialchars(trim($_POST['nama_kelima'])) : '';
    $jk_kelima = isset($_POST['jk_kelima']) ? htmlspecialchars(trim($_POST['jk_kelima'])) : '';
    $tempat_lahir_kelima = isset($_POST['tempat_lahir_kelima']) ? htmlspecialchars(trim($_POST['tempat_lahir_kelima'])) : '';
    $tanggal_lahir_kelima = isset($_POST['tanggal_lahir_kelima']) ? htmlspecialchars(trim($_POST['tanggal_lahir_kelima'])) : '';
    $pekerjaan_kelima = isset($_POST['pekerjaan_kelima']) ? htmlspecialchars(trim($_POST['pekerjaan_kelima'])) : '';

    // Riwayat Pendidikan S3
    $nama_institusi_s3 = isset($_POST['nama_institusi_s3']) ? htmlspecialchars(trim($_POST['nama_institusi_s3'])) : '';
    $nama_fakultas_s3 = isset($_POST['nama_fakultas_s3']) ? htmlspecialchars(trim($_POST['nama_fakultas_s3'])) : '';
    $tahun_awal_s3 = isset($_POST['tahun_awal_s3']) ? htmlspecialchars(trim($_POST['tahun_awal_s3'])) : '';
    $tahun_akhir_s3 = isset($_POST['tahun_akhir_s3']) ? htmlspecialchars(trim($_POST['tahun_akhir_s3'])) : '';
    $keterangan_s3 = isset($_POST['keterangan_s3']) ? htmlentities(trim($_POST['keterangan_s3'])) : '';
    // Riwayat Pendidikan S2 
    $nama_institusi_s2 = isset($_POST['nama_institusi_s2']) ? htmlspecialchars(trim($_POST['nama_institusi_s2'])) : '';
    $nama_fakultas_s2 = isset($_POST['nama_fakultas_s2']) ? htmlspecialchars(trim($_POST['nama_fakultas_s2'])) : '';
    $tahun_awal_s2 = isset($_POST['tahun_awal_s2']) ? htmlspecialchars(trim($_POST['tahun_awal_s2'])) : '';
    $tahun_akhir_s2 = isset($_POST['tahun_akhir_s2']) ? htmlspecialchars(trim($_POST['tahun_akhir_s2'])) : '';
    $keterangan_s2 = isset($_POST['keterangan_s2']) ? htmlentities(trim($_POST['keterangan_s2'])) : '';
    // Riwayat Pendidikan S1
    $nama_institusi_s1 = isset($_POST['nama_institusi_s1']) ? htmlspecialchars(trim($_POST['nama_institusi_s1'])) : '';
    $nama_fakultas_s1 = isset($_POST['nama_fakultas_s1']) ? htmlspecialchars(trim($_POST['nama_fakultas_s1'])) : '';
    $tahun_awal_s1 = isset($_POST['tahun_awal_s1']) ? htmlspecialchars(trim($_POST['tahun_awal_s1'])) : '';
    $tahun_akhir_s1 = isset($_POST['tahun_akhir_s1']) ? htmlspecialchars(trim($_POST['tahun_akhir_s1'])) : '';
    $keterangan_s1 = isset($_POST['keterangan_s1']) ? htmlentities(trim($_POST['keterangan_s1'])) : '';
    // Riwayat Pendidikan Diploma
    $nama_institusi_diploma = isset($_POST['nama_institusi_diploma']) ? htmlspecialchars(trim($_POST['nama_institusi_diploma'])) : '';
    $nama_fakultas_diploma = isset($_POST['nama_fakultas_diploma']) ? htmlspecialchars(trim($_POST['nama_fakultas_diploma'])) : '';
    $tahun_awal_diploma = isset($_POST['tahun_awal_diploma']) ? htmlspecialchars(trim($_POST['tahun_awal_diploma'])) : '';
    $tahun_akhir_diploma = isset($_POST['tahun_akhir_diploma']) ? htmlspecialchars(trim($_POST['tahun_akhir_diploma'])) : '';
    $keterangan_diploma = isset($_POST['keterangan_diploma']) ? htmlentities(trim($_POST['keterangan_diploma'])) : '';
    // Riwayat Pendidikan SMA
    $nama_institusi_sma = isset($_POST['nama_institusi_sma']) ? htmlspecialchars(trim($_POST['nama_institusi_sma'])) : '';
    $nama_fakultas_sma = isset($_POST['nama_fakultas_sma']) ? htmlspecialchars(trim($_POST['nama_fakultas_sma'])) : '';
    $tahun_awal_sma = isset($_POST['tahun_awal_sma']) ? htmlspecialchars(trim($_POST['tahun_awal_sma'])) : '';
    $tahun_akhir_sma = isset($_POST['tahun_akhir_sma']) ? htmlspecialchars(trim($_POST['tahun_akhir_sma'])) : '';
    $keterangan_sma = isset($_POST['keterangan_sma']) ? htmlentities(trim($_POST['keterangan_sma'])) : '';
    // Riwayat Pendidikan SMP
    $nama_institusi_smp = isset($_POST['nama_institusi_smp']) ? htmlspecialchars(trim($_POST['nama_institusi_smp'])) : '';
    $nama_fakultas_smp = isset($_POST['nama_fakultas_smp']) ? htmlspecialchars(trim($_POST['nama_fakultas_smp'])) : '';
    $tahun_awal_smp = isset($_POST['tahun_awal_smp']) ? htmlspecialchars(trim($_POST['tahun_awal_smp'])) : '';
    $tahun_akhir_smp = isset($_POST['tahun_akhir_smp']) ? htmlspecialchars(trim($_POST['tahun_akhir_smp'])) : '';
    $keterangan_smp = isset($_POST['keterangan_smp']) ? htmlentities(trim($_POST['keterangan_smp'])) : '';
    // Riwayat Pendidikan SD
    $nama_institusi_sd = isset($_POST['nama_institusi_sd']) ? htmlspecialchars(trim($_POST['nama_institusi_sd'])) : '';
    $nama_fakultas_sd = isset($_POST['nama_fakultas_sd']) ? htmlspecialchars(trim($_POST['nama_fakultas_sd'])) : '';
    $tahun_awal_sd = isset($_POST['tahun_awal_sd']) ? htmlspecialchars(trim($_POST['tahun_awal_sd'])) : '';
    $tahun_akhir_sd = isset($_POST['tahun_akhir_sd']) ? htmlspecialchars(trim($_POST['tahun_akhir_sd'])) : '';
    $keterangan_sd = isset($_POST['keterangan_sd']) ? htmlentities(trim($_POST['keterangan_sd'])) : '';
    // beasiswa
    $beasiswa = isset($_POST['beasiswa']) ? htmlspecialchars(trim($_POST['beasiswa'])) : '';
    // penghargaan
    $penghargaan = isset($_POST['penghargaan']) ? htmlspecialchars(trim($_POST['penghargaan'])) : '';

    // kursus pelatihan 1
    $kursus_pelatihan_1 = isset($_POST['kursus_pelatihan_1']) ? htmlspecialchars(trim($_POST['kursus_pelatihan_1'])) : '';
    $nama_institusi_1 = isset($_POST['nama_institusi_1']) ? htmlspecialchars(trim($_POST['nama_institusi_1'])) : '';
    $lama_pelatihan_1 = isset($_POST['lama_pelatihan_1']) ? htmlspecialchars(trim($_POST['lama_pelatihan_1'])) : '';
    // kursus pelatihan 2
    $kursus_pelatihan_2 = isset($_POST['kursus_pelatihan_2']) ? htmlspecialchars(trim($_POST['kursus_pelatihan_2'])) : '';
    $nama_institusi_2 = isset($_POST['nama_institusi_2']) ? htmlspecialchars(trim($_POST['nama_institusi_2'])) : '';
    $lama_pelatihan_2 = isset($_POST['lama_pelatihan_2']) ? htmlspecialchars(trim($_POST['lama_pelatihan_2'])) : '';
    // kursus pelatihan 3
    $kursus_pelatihan_3 = isset($_POST['kursus_pelatihan_3']) ? htmlspecialchars(trim($_POST['kursus_pelatihan_3'])) : '';
    $nama_institusi_3 = isset($_POST['nama_institusi_3']) ? htmlspecialchars(trim($_POST['nama_institusi_3'])) : '';
    $lama_pelatihan_3 = isset($_POST['lama_pelatihan_3']) ? htmlspecialchars(trim($_POST['lama_pelatihan_3'])) : '';

    // kemampuan Bahasa 1
    $bahasa_1 = isset($_POST['bahasa_1']) ? htmlspecialchars(trim($_POST['bahasa_1'])) : '';
    $lisan_1 = isset($_POST['lisan_1']) ? htmlspecialchars(trim($_POST['lisan_1'])) : '';
    $tulisan_1 = isset($_POST['tulisan_1']) ? htmlspecialchars(trim($_POST['tulisan_1'])) : '';
    // kemampuan Bahasa 2
    $bahasa_2 = isset($_POST['bahasa_2']) ? htmlspecialchars(trim($_POST['bahasa_2'])) : '';
    $lisan_2 = isset($_POST['lisan_2']) ? htmlspecialchars(trim($_POST['lisan_2'])) : '';
    $tulisan_2 = isset($_POST['tulisan_2']) ? htmlspecialchars(trim($_POST['tulisan_2'])) : '';
    // kemampuan Bahasa 3
    $bahasa_3 = isset($_POST['bahasa_3']) ? htmlspecialchars(trim($_POST['bahasa_3'])) : '';
    $lisan_3 = isset($_POST['lisan_3']) ? htmlspecialchars(trim($_POST['lisan_3'])) : '';
    $tulisan_3 = isset($_POST['tulisan_3']) ? htmlspecialchars(trim($_POST['tulisan_3'])) : '';

    // riwayat pekerjaan
    $tahun_awal_1 = isset($_POST['tahun_awal_1']) ? htmlspecialchars(trim($_POST['tahun_awal_1']))  : '';
    $tahun_akhir_1 = isset($_POST['tahun_akhir_1']) ? htmlspecialchars(trim($_POST['tahun_akhir_1']))  : '';
    $nama_perusahaan_1 = isset($_POST['nama_perusahaan_1']) ? htmlspecialchars(trim($_POST['nama_perusahaan_1']))  : '';
    $jabatan_1 = isset($_POST['jabatan_1']) ? htmlspecialchars(trim($_POST['jabatan_1']))  : '';
    $gaji_1 = isset($_POST['gaji_1']) ? htmlspecialchars(trim($_POST['gaji_1']))  : '';
    $alasan_keluar_1 = isset($_POST['alasan_keluar_1']) ? htmlspecialchars(trim($_POST['alasan_keluar_1'])) : '';
    $tahun_awal_2 = isset($_POST['tahun_awal_2']) ? htmlspecialchars(trim($_POST['tahun_awal_2']))  : '';
    $tahun_akhir_2 = isset($_POST['tahun_akhir_2']) ? htmlspecialchars(trim($_POST['tahun_akhir_2']))  : '';
    $nama_perusahaan_2 = isset($_POST['nama_perusahaan_2']) ? htmlspecialchars(trim($_POST['nama_perusahaan_2']))  : '';
    $jabatan_2 = isset($_POST['jabatan_2']) ? htmlspecialchars(trim($_POST['jabatan_2']))  : '';
    $gaji_2 = isset($_POST['gaji_2']) ? htmlspecialchars(trim($_POST['gaji_2']))  : '';
    $alasan_keluar_2 = isset($_POST['alasan_keluar_2']) ? htmlspecialchars(trim($_POST['alasan_keluar_2'])) : '';
    $tahun_awal_3 = isset($_POST['tahun_awal_3']) ? htmlspecialchars(trim($_POST['tahun_awal_3']))  : '';
    $tahun_akhir_3 = isset($_POST['tahun_akhir_3']) ? htmlspecialchars(trim($_POST['tahun_akhir_3']))  : '';
    $nama_perusahaan_3 = isset($_POST['nama_perusahaan_3']) ? htmlspecialchars(trim($_POST['nama_perusahaan_3']))  : '';
    $jabatan_3 = isset($_POST['jabatan_3']) ? htmlspecialchars(trim($_POST['jabatan_3']))  : '';
    $gaji_3 = isset($_POST['gaji_3']) ? htmlspecialchars(trim($_POST['gaji_3']))  : '';
    $alasan_keluar_3 = isset($_POST['alasan_keluar_3']) ? htmlspecialchars(trim($_POST['alasan_keluar_3'])) : '';
    $tahun_awal_4 = isset($_POST['tahun_awal_4']) ? htmlspecialchars(trim($_POST['tahun_awal_4']))  : '';
    $tahun_akhir_4 = isset($_POST['tahun_akhir_4']) ? htmlspecialchars(trim($_POST['tahun_akhir_4']))  : '';
    $nama_perusahaan_4 = isset($_POST['nama_perusahaan_4']) ? htmlspecialchars(trim($_POST['nama_perusahaan_4']))  : '';
    $jabatan_4 = isset($_POST['jabatan_4']) ? htmlspecialchars(trim($_POST['jabatan_4']))  : '';
    $gaji_4 = isset($_POST['gaji_4']) ? htmlspecialchars(trim($_POST['gaji_4']))  : '';
    $alasan_keluar_4 = isset($_POST['alasan_keluar_4']) ? htmlspecialchars(trim($_POST['alasan_keluar_4'])) : '';
    $tahun_awal_5 = isset($_POST['tahun_awal_5']) ? htmlspecialchars(trim($_POST['tahun_awal_5']))  : '';
    $tahun_akhir_5 = isset($_POST['tahun_akhir_5']) ? htmlspecialchars(trim($_POST['tahun_akhir_5']))  : '';
    $nama_perusahaan_5 = isset($_POST['nama_perusahaan_5']) ? htmlspecialchars(trim($_POST['nama_perusahaan_5']))  : '';
    $jabatan_5 = isset($_POST['jabatan_5']) ? htmlspecialchars(trim($_POST['jabatan_5']))  : '';
    $gaji_5 = isset($_POST['gaji_5']) ? htmlspecialchars(trim($_POST['gaji_5']))  : '';
    $alasan_keluar_5 = isset($_POST['alasan_keluar_5']) ? htmlspecialchars(trim($_POST['alasan_keluar_5'])) : '';
    $tahun_awal_6 = isset($_POST['tahun_awal_6']) ? htmlspecialchars(trim($_POST['tahun_awal_6']))  : '';
    $tahun_akhir_6 = isset($_POST['tahun_akhir_6']) ? htmlspecialchars(trim($_POST['tahun_akhir_6']))  : '';
    $nama_perusahaan_6 = isset($_POST['nama_perusahaan_6']) ? htmlspecialchars(trim($_POST['nama_perusahaan_6']))  : '';
    $jabatan_6 = isset($_POST['jabatan_6']) ? htmlspecialchars(trim($_POST['jabatan_6']))  : '';
    $gaji_6 = isset($_POST['gaji_6']) ? htmlspecialchars(trim($_POST['gaji_6']))  : '';
    $alasan_keluar_6 = isset($_POST['alasan_keluar_6']) ? htmlspecialchars(trim($_POST['alasan_keluar_6'])) : '';
    $tahun_awal_7 = isset($_POST['tahun_awal_7']) ? htmlspecialchars(trim($_POST['tahun_awal_7']))  : '';
    $tahun_akhir_7 = isset($_POST['tahun_akhir_7']) ? htmlspecialchars(trim($_POST['tahun_akhir_7']))  : '';
    $nama_perusahaan_7 = isset($_POST['nama_perusahaan_7']) ? htmlspecialchars(trim($_POST['nama_perusahaan_7']))  : '';
    $jabatan_7 = isset($_POST['jabatan_7']) ? htmlspecialchars(trim($_POST['jabatan_7']))  : '';
    $gaji_7 = isset($_POST['gaji_7']) ? htmlspecialchars(trim($_POST['gaji_7']))  : '';
    $alasan_keluar_7 = isset($_POST['alasan_keluar_7']) ? htmlspecialchars(trim($_POST['alasan_keluar_7'])) : '';

    // keluarga di jababeka
    $saudara_kerja = isset($_POST['saudara_kerja']) ? htmlspecialchars(trim($_POST['saudara_kerja'])) : '';
    $nama_saudara_kerja = isset($_POST['nama_saudara_kerja']) ? htmlspecialchars(trim($_POST['nama_saudara_kerja'])) : '';
    $jabatan_saudara_kerja = isset($_POST['jabatan_saudara_kerja']) ? htmlspecialchars(trim($_POST['jabatan_saudara_kerja'])) : '';

    // pengalaman kerja di jababeka
    $pengalaman_jababeka = isset($_POST['pengalaman_jababeka']) ? htmlspecialchars(trim($_POST['pengalaman_jababeka'])) : '';
    $kerja_jababeka = isset($_POST['kerja_jababeka']) ? htmlspecialchars(trim($_POST['kerja_jababeka'])) : '';

    // Bidang pekerjaan yang disukai
    $bidang_pekerjaan = isset($_POST['bidang_pekerjaan']) ? htmlspecialchars(trim($_POST['bidang_pekerjaan'])) : '';

    // riwayat kecelakaan
    $riwayat_kecelakaan = isset($_POST['riwayat_kecelakaan']) ? htmlspecialchars(trim($_POST['riwayat_kecelakaan'])) : '';
    $kecelakaan = isset($_POST['kecelakaan']) ? htmlspecialchars(trim($_POST['kecelakaan'])) : '';

    // riwayat kecelakaan
    $riwayat_kriminal = isset($_POST['riwayat_kriminal']) ? htmlspecialchars(trim($_POST['riwayat_kriminal'])) : '';
    $kriminal = isset($_POST['kriminal']) ? htmlspecialchars(trim($_POST['kriminal'])) : '';

    // waktu luang
    $waktu_luang = isset($_POST['waktu_luang']) ? htmlspecialchars(trim($_POST['waktu_luang'])) : '';

    // kerja sampingan
    $kerja_sampingan = isset($_POST['kerja_sampingan']) ? htmlspecialchars(trim($_POST['kerja_sampingan'])) : '';
    $sampingan = isset($_POST['sampingan']) ? htmlspecialchars(trim($_POST['sampingan'])) : '';

    // pengalaman organisasi
    $pengalaman_organisasi = isset($_POST['pengalaman_organisasi']) ? htmlspecialchars(trim($_POST['pengalaman_organisasi'])) : '';
    $organisasi = isset($_POST['organisasi']) ? htmlspecialchars(trim($_POST['organisasi'])) : '';

    // referensi
    $nama_ref_1 = isset($_POST['nama_ref_1']) ? htmlspecialchars(trim($_POST['nama_ref_1'])) : '';
    $alamat_ref_1 = isset($_POST['alamat_ref_1']) ? htmlspecialchars(trim($_POST['alamat_ref_1'])) : '';
    $tlp_ref_1 = isset($_POST['tlp_ref_1']) ? htmlspecialchars(trim($_POST['tlp_ref_1'])) : '';
    $jabatan_ref_1 = isset($_POST['jabatan_ref_1']) ? htmlspecialchars(trim($_POST['jabatan_ref_1'])) : '';

    // $nama_ref_2 = isset($_POST['nama_ref_2']) ? htmlspecialchars(trim($_POST['nama_ref_2'])) : '';
    // $alamat_ref_2 = isset($_POST['alamat_ref_2']) ? htmlspecialchars(trim($_POST['alamat_ref_2'])) : '';
    // $tlp_ref_2 = isset($_POST['tlp_ref_2']) ? htmlspecialchars(trim($_POST['tlp_ref_2'])) : '';
    // $jabatan_ref_2 = isset($_POST['jabatan_ref_2']) ? htmlspecialchars(trim($_POST['jabatan_ref_2'])) : '';

    // $nama_ref_3 = isset($_POST['nama_ref_3']) ? htmlspecialchars(trim($_POST['nama_ref_3'])) : '';
    // $alamat_ref_3 = isset($_POST['alamat_ref_3']) ? htmlspecialchars(trim($_POST['alamat_ref_3'])) : '';
    // $tlp_ref_3 = isset($_POST['tlp_ref_3']) ? htmlspecialchars(trim($_POST['tlp_ref_3'])) : '';
    // $jabatan_ref_3 = isset($_POST['jabatan_ref_3']) ? htmlspecialchars(trim($_POST['jabatan_ref_3'])) : '';


    // Validate KTP
    if (strlen($no_ktp) != 16) {
        die("Nomor KTP harus terdiri dari 16 digit.");
    }

    // Check if the file input is present and a file has been uploaded
    $foto_new_name = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto = $_FILES['foto'];
        $foto_name = $foto['name'];
        $foto_tmp_name = $foto['tmp_name'];
        $foto_error = $foto['error'];
        $foto_size = $foto['size'];
        $foto_ext = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($foto_ext, $allowed_ext)) {
            if ($foto_size < 5000000) { // 5MB limit
                $foto_new_name = uniqid('', true) . "." . $foto_ext;
                $foto_destination = 'uploads/' . $foto_new_name;
                $foto_secondary_destination = '../adminunit/fpk/applicants/uploads/' . $foto_new_name;

                // Attempt to move the uploaded file to the primary destination
                if (move_uploaded_file($foto_tmp_name, $foto_destination)) {
                    // Copy the file to the secondary destination
                    if (!copy($foto_destination, $foto_secondary_destination)) {
                        die("Terjadi kesalahan saat mengunggah foto ke lokasi kedua.");
                    }
                    // File upload successful
                    echo "File berhasil diunggah ke kedua lokasi.";
                } else {
                    die("Terjadi kesalahan saat mengunggah foto ke lokasi pertama.");
                }
            } else {
                die("Ukuran foto terlalu besar. Maksimal 5MB.");
            }
        } else {
            die("Ekstensi file tidak diizinkan. Harus berupa jpg, jpeg, png, atau gif.");
        }
    }

    // Cek apakah id_biodata sudah ada di database
    $stmt_check = $pdo->prepare("SELECT COUNT(*) AS count FROM biodata_karyawan WHERE id_biodata = ?");
    $stmt_check->execute([$id_biodata]);
    $row = $stmt_check->fetch(PDO::FETCH_ASSOC);
    $count = intval($row['count']);

    if ($count > 0) {
        // Jika id_biodata sudah ada, lakukan update
        $stmt = $pdo->prepare("UPDATE biodata_karyawan SET
                               posisi = ?,
                               nama_lengkap = ?,
                               nama_panggilan = ?,
                               jenis_kelamin = ?,
                               golongan_darah = ?,
                               tm_lahir = ?,
                               tanggal_lahir = ?,
                               no_ktp = ?,
                               no_npwp = ?,
                               kewarganegaraan = ?,
                               agama = ?,
                               no_tlpn_rumah = ?,
                               no_tlpn = ?,
                               email = ?,
                               foto = ?,
                               alamat_ktp = ?,
                               rt = ?,
                               rw = ?,
                               kelurahan = ?,
                               kecamatan = ?,
                               kota = ?,
                               provinsi = ?,
                               kode_pos = ?,
                               alamat_domisili = ?,
                               nama_kd = ?,
                               no_tlpn_kd = ?,
                               hubungan_kd = ?,
                               alamat_kd = ?,
                               status = ?,
                               nama_istri = ?,
                               tempat_lahir_istri = ?,
                               tanggal_lahir_istri = ?,
                               pekerjaan_istri = ?,
                               nama_suami = ?,
                               tempat_lahir_suami = ?,
                               tanggal_lahir_suami = ?,
                               pekerjaan_suami = ?,
                               nama_anak_1 = ?,
                               jk_anak_1 = ?,
                               tempat_lahir_anak_1 = ?,
                               tanggal_lahir_anak_1 = ?,
                               pekerjaan_anak_1 = ?,
                               nama_anak_2 = ?,
                               jk_anak_2 = ?,
                               tempat_lahir_anak_2 = ?,
                               tanggal_lahir_anak_2 = ?,
                               pekerjaan_anak_2 = ?,
                               nama_anak_3 = ?,
                               jk_anak_3 = ?,
                               tempat_lahir_anak_3 = ?,
                               tanggal_lahir_anak_3 = ?,
                               pekerjaan_anak_3 = ?,
                               nama_anak_4 = ?,
                               jk_anak_4 = ?,
                               tempat_lahir_anak_4 = ?,
                               tanggal_lahir_anak_4 = ?,
                               pekerjaan_anak_4 = ?,
                               nama_anak_5 = ?,
                               jk_anak_5 = ?,
                               tempat_lahir_anak_5 = ?,
                               tanggal_lahir_anak_5 = ?,
                               pekerjaan_anak_5 = ?,
                               nama_ayah = ?,
                               tempat_lahir_ayah = ?,
                               tanggal_lahir_ayah = ?,
                               pekerjaan_ayah = ?,
                               nama_ibu = ?,
                               tempat_lahir_ibu = ?,
                               tanggal_lahir_ibu = ?,
                               pekerjaan_ibu = ?,
                               nama_pertama = ?,
                               jk_pertama = ?,
                               tempat_lahir_pertama = ?,
                               tanggal_lahir_pertama = ?,
                               pekerjaan_pertama = ?,
                               nama_kedua = ?,
                               jk_kedua = ?,
                               tempat_lahir_kedua = ?,
                               tanggal_lahir_kedua = ?,
                               pekerjaan_kedua = ?,
                               nama_ketiga = ?,
                               jk_ketiga = ?,
                               tempat_lahir_ketiga = ?,
                               tanggal_lahir_ketiga = ?,
                               pekerjaan_ketiga = ?,
                               nama_keempat = ?,
                               jk_keempat = ?,
                               tempat_lahir_keempat = ?,
                               tanggal_lahir_keempat = ?,
                               pekerjaan_keempat = ?,
                               nama_kelima = ?,
                               jk_kelima = ?,
                               tempat_lahir_kelima = ?,
                               tanggal_lahir_kelima = ?,
                               pekerjaan_kelima = ?,
                               nama_institusi_s3 = ?,
                               nama_fakultas_s3 = ?,
                               tahun_awal_s3 = ?,
                               tahun_akhir_s3 = ?,
                               keterangan_s3 = ?,
                               nama_institusi_s2 = ?,
                               nama_fakultas_s2 = ?,
                               tahun_awal_s2 = ?,
                               tahun_akhir_s2 = ?,
                               keterangan_s2 = ?,
                               nama_institusi_s1 = ?,
                               nama_fakultas_s1 = ?,
                               tahun_awal_s1 = ?,
                               tahun_akhir_s1 = ?,
                               keterangan_s1 = ?,
                               nama_institusi_diploma = ?,
                               nama_fakultas_diploma = ?,
                               tahun_awal_diploma = ?,
                               tahun_akhir_diploma = ?,
                               keterangan_diploma = ?,
                               nama_institusi_sma = ?,
                               nama_fakultas_sma = ?,
                               tahun_awal_sma = ?,
                               tahun_akhir_sma = ?,
                               keterangan_sma = ?,
                               nama_institusi_smp = ?,
                               tahun_awal_smp = ?,
                               tahun_akhir_smp = ?,
                               keterangan_smp = ?,
                               nama_institusi_sd = ?,
                               tahun_awal_sd = ?,
                               tahun_akhir_sd = ?,
                               keterangan_sd = ?,
                               beasiswa = ?,
                               penghargaan = ?,
                               kursus_pelatihan_1 = ?,
                               nama_institusi_1 = ?,
                               lama_pelatihan_1 = ?,
                               kursus_pelatihan_2 = ?,
                               nama_institusi_2 = ?,
                               lama_pelatihan_2 = ?,
                               kursus_pelatihan_3 = ?,
                               nama_institusi_3 = ?,
                               lama_pelatihan_3 = ?,
                               bahasa_1 = ?,
                               lisan_1 = ?,
                               tulisan_1 = ?,
                               bahasa_2 = ?,
                               lisan_2 = ?,
                               tulisan_2 = ?,
                               bahasa_3 = ?,
                               lisan_3 = ?,
                               tulisan_3 = ?,
                               tahun_awal_1 = ?,
                               tahun_akhir_1 = ?,
                               nama_perusahaan_1 = ?,
                               jabatan_1 = ?,
                               gaji_1 = ?,
                               alasan_keluar_1 = ?,
                               tahun_awal_2 = ?,
                               tahun_akhir_2 = ?,
                               nama_perusahaan_2 = ?,
                               jabatan_2 = ?,
                               gaji_2 = ?,
                               alasan_keluar_2 = ?,
                               tahun_awal_3 = ?,
                               tahun_akhir_3 = ?,
                               nama_perusahaan_3 = ?,
                               jabatan_3 = ?,
                               gaji_3 = ?,
                               alasan_keluar_3 = ?,
                               tahun_awal_4 = ?,
                               tahun_akhir_4 = ?,
                               nama_perusahaan_4 = ?,
                               jabatan_4 = ?,
                               gaji_4 = ?,
                               alasan_keluar_4 = ?,
                               tahun_awal_5 = ?,
                               tahun_akhir_5 = ?,
                               nama_perusahaan_5 = ?,
                               jabatan_5 = ?,
                               gaji_5 = ?,
                               alasan_keluar_5 = ?,
                               tahun_awal_6 = ?,
                               tahun_akhir_6 = ?,
                               nama_perusahaan_6 = ?,
                               jabatan_6 = ?,
                               gaji_6 = ?,
                               alasan_keluar_6 = ?,
                               tahun_awal_7 = ?,
                               tahun_akhir_7 = ?,
                               nama_perusahaan_7 = ?,
                               jabatan_7 = ?,
                               gaji_7 = ?,
                               alasan_keluar_7 = ?,
                               saudara_kerja = ?,
                               nama_saudara_kerja = ?,
                               jabatan_saudara_kerja = ?,
                               pengalaman_jababeka = ?,
                               kerja_jababeka = ?,
                               bidang_pekerjaan = ?,
                               riwayat_kecelakaan = ?,
                               kecelakaan = ?,
                               riwayat_kriminal = ?,
                               kriminal = ?,
                               waktu_luang = ?,
                               kerja_sampingan = ?,
                               sampingan = ?,
                               pengalaman_organisasi = ?,
                               organisasi =?,
                               nama_ref_1 = ?,
                               alamat_ref_1 = ?,
                               tlp_ref_1 = ?,
                               jabatan_ref_1 = ?
                               WHERE id_biodata = ?");

        // Eksekusi prepared statement dengan nilai yang sudah ditentukan
        $stmt->execute([
            $posisi,
            $nama_lengkap,
            $nama_panggilan,
            $jenis_kelamin,
            $golongan_darah,
            $tm_lahir,
            $tanggal_lahir,
            $no_ktp,
            $no_npwp,
            $kewarganegaraan,
            $agama,
            $no_tlpn_rumah,
            $no_tlpn,
            $email,
            $foto_new_name,
            $alamat_ktp,
            $rt,
            $rw,
            $kelurahan,
            $kecamatan,
            $kota,
            $provinsi,
            $kode_pos,
            $alamat_domisili,
            $nama_kd,
            $no_tlpn_kd,
            $hubungan_kd,
            $alamat_kd,
            $status,
            $nama_istri,
            $tempat_lahir_istri,
            $tanggal_lahir_istri,
            $pekerjaan_istri,
            $nama_suami,
            $tempat_lahir_suami,
            $tanggal_lahir_suami,
            $pekerjaan_suami,
            $nama_anak_1,
            $jk_anak_1,
            $tempat_lahir_anak_1,
            $tanggal_lahir_anak_1,
            $pekerjaan_anak_1,
            $nama_anak_2,
            $jk_anak_2,
            $tempat_lahir_anak_2,
            $tanggal_lahir_anak_2,
            $pekerjaan_anak_2,
            $nama_anak_3,
            $jk_anak_3,
            $tempat_lahir_anak_3,
            $tanggal_lahir_anak_3,
            $pekerjaan_anak_3,
            $nama_anak_4,
            $jk_anak_4,
            $tempat_lahir_anak_4,
            $tanggal_lahir_anak_4,
            $pekerjaan_anak_4,
            $nama_anak_5,
            $jk_anak_5,
            $tempat_lahir_anak_5,
            $tanggal_lahir_anak_5,
            $pekerjaan_anak_5,
            $nama_ayah,
            $tempat_lahir_ayah,
            $tanggal_lahir_ayah,
            $pekerjaan_ayah,
            $nama_ibu,
            $tempat_lahir_ibu,
            $tanggal_lahir_ibu,
            $pekerjaan_ibu,
            $nama_pertama,
            $jk_pertama,
            $tempat_lahir_pertama,
            $tanggal_lahir_pertama,
            $pekerjaan_pertama,
            $nama_kedua,
            $jk_kedua,
            $tempat_lahir_kedua,
            $tanggal_lahir_kedua,
            $pekerjaan_kedua,
            $nama_ketiga,
            $jk_ketiga,
            $tempat_lahir_ketiga,
            $tanggal_lahir_ketiga,
            $pekerjaan_ketiga,
            $nama_keempat,
            $jk_keempat,
            $tempat_lahir_keempat,
            $tanggal_lahir_keempat,
            $pekerjaan_keempat,
            $nama_kelima,
            $jk_kelima,
            $tempat_lahir_kelima,
            $tanggal_lahir_kelima,
            $pekerjaan_kelima,
            $nama_institusi_s3,
            $nama_fakultas_s3,
            $tahun_awal_s3,
            $tahun_akhir_s3,
            $keterangan_s3,
            $nama_institusi_s2,
            $nama_fakultas_s2,
            $tahun_awal_s2,
            $tahun_akhir_s2,
            $keterangan_s2,
            $nama_institusi_s1,
            $nama_fakultas_s1,
            $tahun_awal_s1,
            $tahun_akhir_s1,
            $keterangan_s1,
            $nama_institusi_diploma,
            $nama_fakultas_diploma,
            $tahun_awal_diploma,
            $tahun_akhir_diploma,
            $keterangan_diploma,
            $nama_institusi_sma,
            $nama_fakultas_sma,
            $tahun_awal_sma,
            $tahun_akhir_sma,
            $keterangan_sma,
            $nama_institusi_smp,
            $tahun_awal_smp,
            $tahun_akhir_smp,
            $keterangan_smp,
            $nama_institusi_sd,
            $tahun_awal_sd,
            $tahun_akhir_sd,
            $keterangan_sd,
            $beasiswa,
            $penghargaan,
            $kursus_pelatihan_1,
            $nama_institusi_1,
            $lama_pelatihan_1,
            $kursus_pelatihan_2,
            $nama_institusi_2,
            $lama_pelatihan_2,
            $kursus_pelatihan_3,
            $nama_institusi_3,
            $lama_pelatihan_3,
            $bahasa_1,
            $lisan_1,
            $tulisan_1,
            $bahasa_2,
            $lisan_2,
            $tulisan_2,
            $bahasa_3,
            $lisan_3,
            $tulisan_3,
            $tahun_awal_1,
            $tahun_akhir_1,
            $nama_perusahaan_1,
            $jabatan_1,
            $gaji_1,
            $alasan_keluar_1,
            $tahun_awal_2,
            $tahun_akhir_2,
            $nama_perusahaan_2,
            $jabatan_2,
            $gaji_2,
            $alasan_keluar_2,
            $tahun_awal_3,
            $tahun_akhir_3,
            $nama_perusahaan_3,
            $jabatan_3,
            $gaji_3,
            $alasan_keluar_3,
            $tahun_awal_4,
            $tahun_akhir_4,
            $nama_perusahaan_4,
            $jabatan_4,
            $gaji_4,
            $alasan_keluar_4,
            $tahun_awal_5,
            $tahun_akhir_5,
            $nama_perusahaan_5,
            $jabatan_5,
            $gaji_5,
            $alasan_keluar_5,
            $tahun_awal_6,
            $tahun_akhir_6,
            $nama_perusahaan_6,
            $jabatan_6,
            $gaji_6,
            $alasan_keluar_6,
            $tahun_awal_7,
            $tahun_akhir_7,
            $nama_perusahaan_7,
            $jabatan_7,
            $gaji_7,
            $alasan_keluar_7,
            $saudara_kerja,
            $nama_saudara_kerja,
            $jabatan_saudara_kerja,
            $pengalaman_jababeka,
            $kerja_jababeka,
            $bidang_pekerjaan,
            $riwayat_kecelakaan,
            $kecelakaan,
            $riwayat_kriminal,
            $kriminal,
            $waktu_luang,
            $kerja_sampingan,
            $sampingan,
            $pengalaman_organisasi,
            $organisasi,
            $nama_ref_1,
            $alamat_ref_1,
            $tlp_ref_1,
            $jabatan_ref_1,
            $id_biodata
        ]);

        echo "Data berhasil diperbarui.";
    } else {
        // Jika id_biodata belum ada, tambahkan data baru
        $stmt = $pdo->prepare("INSERT INTO biodata_karyawan 
                               (id_biodata, posisi, 
                               nama_lengkap, nama_panggilan, jenis_kelamin, golongan_darah, 
                               tm_lahir, tanggal_lahir, no_ktp, no_npwp, 
                               kewarganegaraan, agama,  no_tlpn_rumah, no_tlpn,
                               email, foto, alamat_ktp, rt, 
                               rw, kelurahan, kecamatan, kota, 
                               provinsi, kode_pos, alamat_domisili, nama_kd, 
                               no_tlpn_kd, hubungan_kd, alamat_kd, status,
                               nama_istri, tempat_lahir_istri, tanggal_lahir_istri, pekerjaan_istri,
                               nama_suami, tempat_lahir_suami, tanggal_lahir_suami, pekerjaan_suami,
                               nama_anak_1, jk_anak_1, tempat_lahir_anak_1, tanggal_lahir_anak_1, pekerjaan_anak_1,
                               nama_anak_2, jk_anak_2, tempat_lahir_anak_2, tanggal_lahir_anak_2, pekerjaan_anak_2,
                               nama_anak_3, jk_anak_3, tempat_lahir_anak_3, tanggal_lahir_anak_3, pekerjaan_anak_3,
                               nama_anak_4, jk_anak_4, tempat_lahir_anak_4, tanggal_lahir_anak_4, pekerjaan_anak_4,
                               nama_anak_5, jk_anak_5, tempat_lahir_anak_5, tanggal_lahir_anak_5, pekerjaan_anak_5,
                               nama_ayah, tempat_lahir_ayah, tanggal_lahir_ayah, pekerjaan_ayah,
                               nama_ibu, tempat_lahir_ibu, tanggal_lahir_ibu, pekerjaan_ibu,
                               nama_pertama, jk_pertama, tempat_lahir_pertama, tanggal_lahir_pertama, pekerjaan_pertama,
                               nama_kedua, jk_kedua, tempat_lahir_kedua, tanggal_lahir_kedua, pekerjaan_kedua,
                               nama_ketiga, jk_ketiga, tempat_lahir_ketiga, tanggal_lahir_ketiga, pekerjaan_ketiga,
                               nama_keempat, jk_keempat, tempat_lahir_keempat, tanggal_lahir_keempat, pekerjaan_keempat,
                               nama_kelima, jk_kelima, tempat_lahir_kelima, tanggal_lahir_kelima, pekerjaan_kelima, 
                               nama_institusi_s3, nama_fakultas_s3, tahun_awal_s3, tahun_akhir_s3, keterangan_s3, beasiswa, penghargaan,
                               kursus_pelatihan_1, nama_institusi_1, lama_pelatihan_1,
                               kursus_pelatihan_2, nama_institusi_2, lama_pelatihan_2,
                               kursus_pelatihan_3, nama_institusi_3, lama_institusi_3,
                               bahasa_1, lisan_1, tulisan_1,
                               bahasa_2, lisan_2, tulisan_2,
                               bahasa_3, lisan_3, tulisan_3,
                               tahun_awal_1, tahun_akhir_1, nama_perusahaan_1, jabatan_1, gaji_1, alasan_keluar_1,
                               tahun_awal_2, tahun_akhir_2, nama_perusahaan_2, jabatan_2, gaji_2, alasan_keluar_2,
                               tahun_awal_3, tahun_akhir_3, nama_perusahaan_3, jabatan_3, gaji_3, alasan_keluar_3,
                               tahun_awal_4, tahun_akhir_4, nama_perusahaan_4, jabatan_4, gaji_4, alasan_keluar_4,
                               tahun_awal_5, tahun_akhir_5, nama_perusahaan_5, jabatan_5, gaji_5, alasan_keluar_5,
                               tahun_awal_6, tahun_akhir_6, nama_perusahaan_6, jabatan_6, gaji_6, alasan_keluar_6,
                               tahun_awal_7, tahun_akhir_7, nama_perusahaan_7, jabatan_7, gaji_7, alasan_keluar_7,
                               saudara_kerja, nama_saudara_kerja, jabatan_saudara_kerja, pengalaman_jababeka, kerja_jababeka, bidang_pekerjaan,
                               riwayat_kecelakaan, kecelakaan, riwayat_kriminal, kriminal,
                               waktu_luang, kerja_sampingan, sampingan, pengalaman_organisasi, organisasi,
                               nama_ref_1, alamat_ref_1, tlp_ref_1, jabatan_ref_1
                               )
                               VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $posisi,
            $nama_lengkap,
            $nama_panggilan,
            $jenis_kelamin,
            $golongan_darah,
            $tm_lahir,
            $tanggal_lahir,
            $no_ktp,
            $no_npwp,
            $kewarganegaraan,
            $agama,
            $no_tlpn_rumah,
            $no_tlpn,
            $email,
            $foto_new_name,
            $alamat_ktp,
            $rt,
            $rw,
            $kelurahan,
            $kecamatan,
            $kota,
            $provinsi,
            $kode_pos,
            $alamat_domisili,
            $nama_kd,
            $no_tlpn_kd,
            $hubungan_kd,
            $alamat_kd,
            $status,
            $nama_istri,
            $tempat_lahir_istri,
            $tanggal_lahir_istri,
            $pekerjaan_istri,
            $nama_suami,
            $tempat_lahir_suami,
            $tanggal_lahir_suami,
            $pekerjaan_suami,
            $nama_anak_1,
            $jk_anak_1,
            $tempat_lahir_anak_1,
            $tanggal_lahir_anak_1,
            $pekerjaan_anak_1,
            $nama_anak_2,
            $jk_anak_2,
            $tempat_lahir_anak_2,
            $tanggal_lahir_anak_2,
            $pekerjaan_anak_2,
            $nama_anak_3,
            $jk_anak_3,
            $tempat_lahir_anak_3,
            $tanggal_lahir_anak_3,
            $pekerjaan_anak_3,
            $nama_anak_4,
            $jk_anak_4,
            $tempat_lahir_anak_4,
            $tanggal_lahir_anak_4,
            $pekerjaan_anak_4,
            $nama_anak_5,
            $jk_anak_5,
            $tempat_lahir_anak_5,
            $tanggal_lahir_anak_5,
            $pekerjaan_anak_5,
            $nama_ayah,
            $tempat_lahir_ayah,
            $tanggal_lahir_ayah,
            $pekerjaan_ayah,
            $nama_ibu,
            $tempat_lahir_ibu,
            $tanggal_lahir_ibu,
            $pekerjaan_ibu,
            $nama_pertama,
            $jk_pertama,
            $tempat_lahir_pertama,
            $tanggal_lahir_pertama,
            $pekerjaan_pertama,
            $nama_kedua,
            $jk_kedua,
            $tempat_lahir_kedua,
            $tanggal_lahir_kedua,
            $pekerjaan_kedua,
            $nama_ketiga,
            $jk_ketiga,
            $tempat_lahir_ketiga,
            $tanggal_lahir_ketiga,
            $pekerjaan_ketiga,
            $nama_keempat,
            $jk_keempat,
            $tempat_lahir_keempat,
            $tanggal_lahir_keempat,
            $pekerjaan_keempat,
            $nama_kelima,
            $jk_kelima,
            $tempat_lahir_kelima,
            $tanggal_lahir_kelima,
            $pekerjaan_kelima,
            $nama_institusi_s3,
            $nama_fakultas_s3,
            $tahun_awal_s3,
            $tahun_akhir_s3,
            $keterangan_s3,
            $nama_institusi_s2,
            $nama_fakultas_s2,
            $tahun_awal_s2,
            $tahun_akhir_s2,
            $keterangan_s2,
            $nama_institusi_s1,
            $nama_fakultas_s1,
            $tahun_awal_s1,
            $tahun_akhir_s1,
            $keterangan_s1,
            $nama_institusi_diploma,
            $nama_fakultas_diploma,
            $tahun_awal_diploma,
            $tahun_akhir_diploma,
            $keterangan_diploma,
            $nama_institusi_sma,
            $nama_fakultas_sma,
            $tahun_awal_sma,
            $tahun_akhir_sma,
            $keterangan_sma,
            $nama_institusi_smp,
            $tahun_awal_smp,
            $tahun_akhir_smp,
            $keterangan_smp,
            $nama_institusi_sd,
            $tahun_awal_sd,
            $tahun_akhir_sd,
            $keterangan_sd,
            $beasiswa,
            $penghargaan,
            $kursus_pelatihan_1,
            $nama_institusi_1,
            $lama_pelatihan_1,
            $kursus_pelatihan_2,
            $nama_institusi_2,
            $lama_pelatihan_2,
            $kursus_pelatihan_3,
            $nama_institusi_3,
            $lama_pelatihan_3,
            $bahasa_1,
            $lisan_1,
            $tulisan_1,
            $bahasa_2,
            $lisan_2,
            $tulisan_2,
            $bahasa_3,
            $lisan_3,
            $tulisan_3,
            $tahun_awal_1,
            $tahun_akhir_1,
            $nama_perusahaan_1,
            $jabatan_1,
            $gaji_1,
            $alasan_keluar_1,
            $tahun_awal_2,
            $tahun_akhir_2,
            $nama_perusahaan_2,
            $jabatan_2,
            $gaji_2,
            $alasan_keluar_2,
            $tahun_awal_3,
            $tahun_akhir_3,
            $nama_perusahaan_3,
            $jabatan_3,
            $gaji_3,
            $alasan_keluar_3,
            $tahun_awal_4,
            $tahun_akhir_4,
            $nama_perusahaan_4,
            $jabatan_4,
            $gaji_4,
            $alasan_keluar_4,
            $tahun_awal_5,
            $tahun_akhir_5,
            $nama_perusahaan_5,
            $jabatan_5,
            $gaji_5,
            $alasan_keluar_5,
            $tahun_awal_6,
            $tahun_akhir_6,
            $nama_perusahaan_6,
            $jabatan_6,
            $gaji_6,
            $alasan_keluar_6,
            $tahun_awal_7,
            $tahun_akhir_7,
            $nama_perusahaan_7,
            $jabatan_7,
            $gaji_7,
            $alasan_keluar_7,
            $saudara_kerja,
            $nama_saudara_kerja,
            $jabatan_saudara_kerja,
            $pengalaman_jababeka,
            $kerja_jababeka,
            $bidang_pekerjaan,
            $riwayat_kecelakaan,
            $kecelakaan,
            $riwayat_kriminal,
            $kriminal,
            $waktu_luang,
            $kerja_sampingan,
            $sampingan,
            $pengalaman_organisasi,
            $organisasi,
            $nama_ref_1,
            $alamat_ref_1,
            $tlp_ref_1,
            $jabatan_ref_1,
            $id_biodata
        ]);

        // Data berhasil disimpan, tampilkan alert dan kembalikan ke halaman sebelumnya
        echo "<script> alert('Data berhasil disimpan.'); </script>";
    }
} catch (PDOException $e) {
    // Gagal terkoneksi dengan database, tampilkan pesan kesalahan
    echo "<script> alert('Gagal terkoneksi dengan database: " . $e->getMessage() . "'); </script>";
}
