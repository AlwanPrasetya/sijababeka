<!DOCTYPE html>
<html lang="en">
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

<?php
// Koneksi ke database
$servername = "localhost"; // Ganti sesuai dengan server database Anda
$username = "alwan"; // Ganti sesuai dengan username database Anda
$password = "root"; // Ganti sesuai dengan password database Anda
$database = "db_sijababeka"; // Ganti sesuai dengan nama database Anda

// Buat koneksi
$connection = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($connection->connect_error) {
    die("Koneksi gagal: " . $connection->connect_error);
}

// Fungsi untuk mendapatkan data karyawan
function getEmployeeData($connection)
{
    $sql = "SELECT kode, nama, bisnis, organisasi, golongan, jabatan, status FROM karyawan"; // Sesuaikan dengan struktur tabel karyawan Anda
    $result = $connection->query($sql);

    $employeeData = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $employeeData[] = $row;
        }
    }

    return $employeeData;
}

// Panggil fungsi untuk mendapatkan data karyawan
$employeeData = getEmployeeData($connection);

// Fungsi untuk mendapatkan data employee_transfer
function getTransferData($connection)
{
    $sql = "SELECT nama, request_type, effective_date, reason  FROM employee_transfer"; // Sesuaikan dengan struktur tabel employee_transfer Anda
    $result = $connection->query($sql);

    $transferData = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transferData[] = $row;
        }
    }

    return $transferData;
}

// Panggil fungsi untuk mendapatkan data employee_transfer
$transferData = getTransferData($connection);
?>

<?php
// Periksa apakah ada parameter 'id' dalam URL
if (isset($_GET['id'])) {
    // Ambil nilai ID dari URL
    $userId = $_GET['id'];

    // Lakukan kueri ke database untuk mendapatkan data pengguna berdasarkan ID
    $query = "SELECT nama, branch FROM multi_user WHERE id = $userId";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        // Menginisialisasi array untuk menyimpan nama cabang
        $branchNames = array();

        // Output data dari setiap baris
        while ($row = $result->fetch_assoc()) {
            $nama = $row["nama"];
            // echo "<h4>SELAMAT DATANG, <strong> $nama </strong> - <strong> HR UNIT </strong></h4>";

            // Lakukan kueri ke database untuk mendapatkan cabang dengan nama yang sama
            $queryBranches = "SELECT DISTINCT branch FROM multi_user WHERE nama = '$nama'";
            $resultBranches = $connection->query($queryBranches);

            if ($resultBranches->num_rows > 0) {
                // echo "<ul class='branch-list'>"; // Mulai daftar untuk mencetak cabang-cabang
                while ($rowBranch = $resultBranches->fetch_assoc()) {
                    // Tambahkan nama cabang ke array
                    $branchNames[] = $rowBranch["branch"];
                    // Cetak nama cabang dalam daftar
                    // echo "<li><strong>" . $rowBranch["branch"] . "</strong></li>";
                }
                // echo "</ul>"; // Akhiri daftar
            } else {
                // echo "<h4><strong> Tidak ada cabang dengan nama yang sama. </strong></h4>";
            }
        }


        // Gabungkan nama cabang menjadi satu string dengan format yang diinginkan
        $branches = implode(', ', $branchNames);
    } else {
        echo "Data tidak ditemukan.";
    }
} else {
    // Jika parameter 'id' tidak ada dalam URL, tampilkan pesan kesalahan
    echo "Parameter 'id' tidak ditemukan dalam URL.";
}

// Tutup koneksi database
$connection->close();
?>

<?php
// include('sidebar.php');
include('koneksi.php');

// Query untuk mengambil data karyawan dan menyimpannya dalam bentuk array
$query_karyawan = mysqli_query($connection, "SELECT * FROM karyawan");
$data_karyawan = array();

while ($row_karyawan = mysqli_fetch_assoc($query_karyawan)) {
    $data_karyawan[$row_karyawan['nama']] = array(
        // 'nama_status' => $row_karyawan['status'],
        'nama_unit' => $row_karyawan['bisnis'],
        'nama_jabatan' => $row_karyawan['jabatan'],
        'nama_organisasi' => $row_karyawan['organisasi'],
        'nama_golongan' => $row_karyawan['golongan']
    );
}
?>

<?php
include('koneksi.php');

// Mengambil data FPK yang sudah disetujui
$sql = "SELECT * FROM fpk WHERE persetujuanAdmin = 'Disetujui' AND persetujuanUser = 'Disetujui' AND persetujuanDireksi3 = 'Disetujui' AND persetujuanPresdir = 'Disetujui' AND persetujuanCorpHr = 'Disetujui' AND persetujuanSuperadmin = 'Disetujui'";
$result = $connection->query($sql);

$fpk_data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fpk_data[] = $row;
    }
}
$connection->close();
?>
<?php
include('koneksi.php');

// Mengambil data FPK yang sudah disetujui
// $sql = "SELECT nama_lengkap, tanggal_lahir, no_ktp, nama_institusi_s1, nama_fakultas_s1 biodata_karyawan";
$result = $connection->query($sql);
$fpk_data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fpk_data[] = $row;
    }
}
$connection->close();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Permintaan Karyawan</title>
    <script>
        // Script untuk mengisi nilai kolom jenis permintaan dan membuka kolom formulir yang sesuai
        document.addEventListener("DOMContentLoaded", function() {
            // Mendapatkan parameter dari URL
            const urlParams = new URLSearchParams(window.location.search);
            const request_type = urlParams.get('request_type');

            // Mengisi nilai kolom jenis permintaan
            if (request_type) {
                document.getElementById("request_type").value = request_type;

                // Menampilkan atau menyembunyikan formulir isian sesuai dengan jenis permintaan
                if (request_type === "Resign") {
                    document.getElementById("ResignForm").style.display = "block";
                } else if (request_type === "PHK") {
                    document.getElementById("PHKForm").style.display = "block";
                } else if (request_type === "Mutasi") {
                    document.getElementById("MutasiForm").style.display = "block";
                } else if (request_type === "Promosi") {
                    document.getElementById("PromosiForm").style.display = "block";
                } else if (request_type === "Demosi") {
                    document.getElementById("DemosiForm").style.display = "block";
                }
            }
        });
    </script>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 10px;
            display: flex;
            justify-content: center;
            background-color: #EAFAF1;
        }

        .container {
            align-items: left;
            max-width: 1050px;
            width: 100%;
        }

        .form-container {
            display: flex;
            width: 100%;
        }

        form {
            width: 100%;

            /* Lebar masing-masing form */
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 2px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Atur jarak antara elemen input/select dan tombol */
        input[type="submit"],
        input[type="reset"] {
            margin-top: 10px;
        }

        .qualification-title {
            text-align: left;
        }

        h2 {
            text-align: center;
        }


        .database {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .dashboard {
            position: absolute;
            top: 20px;
            left: 20px;
        }



        table {
            width: 80%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td {
            padding-bottom: -2px;
            vertical-align: top;
        }


        td input[type="text"],
        td input[type="date"],
        td input[type="email"],
        td select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        td input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 2px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        td input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* tr:nth-child(even) {
            background-color: #f9f9f9;
        } */

        tr:nth-child(odd) {
            background-color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
    <style>
        .col-md-3 {
            flex: 0 0 calc(25% - 5px);
            /* Set lebar 50% dengan margin 10px */
            margin-right: 2px;
            /* Margin antar kolom */
        }

        input[type="text"],
        textarea {
            width: 100%;
        }
    </style>
    <script>
        function fillForm() {
            const kodeFPK = $('#fpk_selection').val();
            if (kodeFPK) {
                $.ajax({
                    url: 'get_fpk.php',
                    type: 'GET',
                    data: {
                        kodeFPK: kodeFPK
                    },
                    success: function(response) {
                        const data = JSON.parse(response);
                        $('#golongan').val(data.golongan);
                        $('#branch').val(data.branch);
                        $('#jabatan').val(data.jabatan);
                        $('#organisasi').val(data.organisasi);
                    }
                });
                fetchCandidates(kodeFPK);
            } else {
                clearCandidates();
                clearForm(); // Clear the form if kode FPK is empty
            }
        }
        // Check form completeness when all candidate-related fields are filled
        function checkFormCompleteness() {
            var nama_kandidat = $('#nama_kandidat').val();
            var form_tanggal_lengkap = $('#form_tanggal_lengkap').val();
            var no_ktp = $('#no_ktp').val();
            var pendidikan = $('#pendidikan').val();
            var alasan_penerimaan = $('#alasan_penerimaan').val();

            if (nama_kandidat !== '' && form_tanggal_lengkap !== '' && no_ktp !== '' && pendidikan !== '' && alasan_penerimaan !== '') {
                $('#form_aplikasi_lengkap').prop('checked', true);
                $('#form_aplikasi_tidak_lengkap').prop('checked', false);
            } else {
                $('#form_aplikasi_lengkap').prop('checked', false);
                $('#form_aplikasi_tidak_lengkap').prop('checked', true);
            }
        }

        // Call checkFormCompleteness when any related field changes
        $('#nama_kandidat, #form_tanggal_lengkap, #no_ktp, #pendidikan, #alasan_penerimaan').on('input', function() {
            checkFormCompleteness();
        });

        // Call checkFormCompleteness initially
        checkFormCompleteness();

        function fetchCandidates(kodeFPK) {
            fetch('get_candidates.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `kodeFPK=${kodeFPK}`
                })
                .then(response => response.json())
                .then(data => {
                    populateCandidates(data);
                })
                .catch(error => {
                    console.error('Error fetching candidates:', error);
                });
        }

        function populateCandidates(candidates) {
            const candidatesSelect = document.getElementById("id_candidates");
            candidatesSelect.innerHTML = '<option value="">Pilih Kandidat</option>';

            candidates.forEach(candidate => {
                const option = document.createElement("option");
                option.value = candidate.id_candidates;
                option.textContent = candidate.nama;
                candidatesSelect.appendChild(option);
            });

            // Reset form completeness check after populating candidates
            checkFormCompleteness();

            // Set default value for form_interview_user based on the first candidate
            if (candidates.length > 0) {
                setFormInterviewUser(candidates[0].file_interview_user);
            }
        }

        function setFormInterviewUser(value) {
            if (value !== null && value !== '') {
                $('#form_interview_user_lengkap').prop('checked', true);
                $('#form_interview_user_tidak_lengkap').prop('checked', false);
            } else {
                $('#form_interview_user_lengkap').prop('checked', false);
                $('#form_interview_user_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_interview_user value
            checkFormCompleteness();
        }

        function setFormInterviewHr(value) {
            if (value !== null && value !== '') {
                $('#form_interview_hr_lengkap').prop('checked', true);
                $('#form_interview_hr_tidak_lengkap').prop('checked', false);
            } else {
                $('#form_interview_hr_lengkap').prop('checked', false);
                $('#form_interview_hr_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_interview_user value
            checkFormCompleteness();
        }

        function setFormHasilPsikotest(value) {
            if (value !== null && value !== '') {
                $('#form_hasil_psikotest_lengkap').prop('checked', true);
                $('#form_hasil_psikotest_tidak_lengkap').prop('checked', false);
            } else {
                $('#form_hasil_psikotest_lengkap').prop('checked', false);
                $('#form_hasil_psikotest_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_interview_user value
            checkFormCompleteness();
        }

        function setFormConfirmationLettter(value) {
            if (value !== null && value !== '') {
                $('#form_confirmation_letter_lengkap').prop('checked', true);
                $('#form_confirmation_letter_tidak_lengkap').prop('checked', false);
            } else {
                $('#form_confirmation_letter_lengkap').prop('checked', false);
                $('#form_confirmation_letter_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_confirmation_letter value
            checkFormCompleteness();
        }

        function setFormHasilTesKesehatan(value) {
            if (value !== null && value !== '') {
                $('#form_hasil_tes_kesehatan_lengkap').prop('checked', true);
                $('#form_hasil_tes_kesehatan_tidak_lengkap').prop('checked', false);
            } else {
                $('#form_hasil_tes_kesehatan_lengkap').prop('checked', false);
                $('#form_hasil_tes_kesehatan_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_interview_user value
            checkFormCompleteness();
        }

        function setReferensiKerja(value) {
            if (value !== null && value !== '') {
                $('#referensi_kerja_lengkap').prop('checked', true);
                $('#referensi_kerja_tidak_lengkap').prop('checked', false);
            } else {
                $('#referensi_kerja_lengkap').prop('checked', false);
                $('#referensi_kerja_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_interview_user value
            checkFormCompleteness();
        }

        function setBpjsKesehatan(value) {
            if (value !== null && value !== '') {
                $('#bpjs_kesehatan_lengkap').prop('checked', true);
                $('#bpjs_kesehatan_tidak_lengkap').prop('checked', false);
            } else {
                $('#bpjs_kesehatan_lengkap').prop('checked', false);
                $('#bpjs_kesehatan_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_interview_user value
            checkFormCompleteness();
        }

        function setBpjsKg(value) {
            if (value !== null && value !== '') {
                $('#bpjs_ketenagakerjaan_lengkap').prop('checked', true);
                $('#bpjs_ketenagakerjaan_tidak_lengkap').prop('checked', false);
            } else {
                $('#bpjs_ketenagakerjaan_lengkap').prop('checked', false);
                $('#bpjs_ketenagakerjaan_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_interview_user value
            checkFormCompleteness();
        }

        function setBpjsJp(value) {
            if (value !== null && value !== '') {
                $('#bpjs_jaminan_pensiun_lengkap').prop('checked', true);
                $('#bpjs_jaminan_pensiun_tidak_lengkap').prop('checked', false);
            } else {
                $('#bpjs_jaminan_pensiun_lengkap').prop('checked', false);
                $('#bpjs_jaminan_pensiun_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_interview_user value
            checkFormCompleteness();
        }

        function setFoto(value) {
            if (value !== null && value !== '') {
                $('#pas_foto_lengkap').prop('checked', true);
                $('#pas_foto_tidak_lengkap').prop('checked', false);
            } else {
                $('#pas_foto_lengkap').prop('checked', false);
                $('#pas_foto_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_interview_user value
            checkFormCompleteness();
        }

        function setFcKtp(value) {
            if (value !== null && value !== '') {
                $('#foto_ktp_lengkap').prop('checked', true);
                $('#foto_ktp_tidak_lengkap').prop('checked', false);
            } else {
                $('#foto_ktp_lengkap').prop('checked', false);
                $('#foto_ktp_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_interview_user value
            checkFormCompleteness();
        }

        function setFcIjazah(value) {
            if (value !== null && value !== '') {
                $('#foto_ijazah_lengkap').prop('checked', true);
                $('#foto_ijazah_tidak_lengkap').prop('checked', false);
            } else {
                $('#foto_ijazah_lengkap').prop('checked', false);
                $('#foto_ijazah_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_interview_user value
            checkFormCompleteness();
        }

        function setFcTn(value) {
            if (value !== null && value !== '') {
                $('#foto_transkip_nilai_lengkap').prop('checked', true);
                $('#foto_transkip_nilai_tidak_lengkap').prop('checked', false);
            } else {
                $('#foto_transkip_nilai_lengkap').prop('checked', false);
                $('#foto_transkip_nilai_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_interview_user value
            checkFormCompleteness();
        }

        function setFcBt(value) {
            if (value !== null && value !== '') {
                $('#foto_buku_tabungan_lengkap').prop('checked', true);
                $('#foto_buku_tabungan_tidak_lengkap').prop('checked', false);
            } else {
                $('#foto_buku_tabungan_lengkap').prop('checked', false);
                $('#foto_buku_tabungan_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_interview_user value
            checkFormCompleteness();
        }

        function setFcNpwp(value) {
            if (value !== null && value !== '') {
                $('#foto_npwp_lengkap').prop('checked', true);
                $('#foto_npwp_tidak_lengkap').prop('checked', false);
            } else {
                $('#foto_npwp_lengkap').prop('checked', false);
                $('#foto_npwp_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_interview_user value
            checkFormCompleteness();
        }

        function setFcKk(value) {
            if (value !== null && value !== '') {
                $('#foto_kk_lengkap').prop('checked', true);
                $('#foto_kk_tidak_lengkap').prop('checked', false);
            } else {
                $('#foto_kk_lengkap').prop('checked', false);
                $('#foto_kk_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_interview_user value
            checkFormCompleteness();
        }

        function setFcSp(value) {
            if (value !== null && value !== '') {
                $('#foto_sertifikat_lengkap').prop('checked', true);
                $('#foto_sertifikat_tidak_lengkap').prop('checked', false);
            } else {
                $('#foto_sertifikat_lengkap').prop('checked', false);
                $('#foto_sertifikat_tidak_lengkap').prop('checked', true);
            }

            // Set form completeness based on form_interview_user value
            checkFormCompleteness();
        }
        // function setBpjsKs(value) {
        //     if (value !== null && value !== '') {
        //         $('#_lengkap').prop('checked', true);
        //         $('#_tidak_lengkap').prop('checked', false);
        //     } else {
        //         $('#_lengkap').prop('checked', false);
        //         $('#_tidak_lengkap').prop('checked', true);
        //     }

        //     // Set form completeness based on form_interview_user value
        //     checkFormCompleteness();
        // }

        $(document).ready(function() {
            // Fetch data when a candidate is selected
            $('#id_candidates').change(function() {
                var id_candidates = $(this).val();
                if (id_candidates) {
                    $.ajax({
                        type: "POST",
                        url: "get_candidate_data.php",
                        data: {
                            id_candidates: id_candidates
                        },
                        dataType: "json",
                        success: function(response) {
                            if (!response.error) {
                                $('#nama_kandidat').val(response.applicant_name);
                                $('#form_tanggal_lengkap').val(response.applicant_dob);
                                $('#no_ktp').val(response.ktp_number);

                                // Set nilai pendidikan berdasarkan data dari server
                                var pendidikan = response.education;
                                $('#pendidikan').val(pendidikan);

                                $('#alasan_penerimaan').val(response.request_for);

                                // Set radio button based on form completeness
                                if (response.form_aplikasi === "Lengkap") {
                                    $('#form_aplikasi_lengkap').prop('checked', true);
                                    $('#form_aplikasi_tidak_lengkap').prop('checked', false);
                                } else {
                                    $('#form_aplikasi_lengkap').prop('checked', false);
                                    $('#form_aplikasi_tidak_lengkap').prop('checked', true);
                                }

                                // Set radio button for form_interview_user based on file_interview_user value
                                setFormInterviewUser(response.file_interview_user);
                                setFormInterviewHr(response.file_interview_hr);
                                setFormHasilPsikotest(response.file_hasil_psikotest);
                                setFormConfirmationLettter(response.confirmation_letter); // Perbaikan penamaan fungsi di sini
                                setFormHasilTesKesehatan(response.file_hasil_tes_kesehatan); // Perbaikan penamaan fungsi di sini
                                setReferensiKerja(response.referensi_kerja); // Perbaikan penamaan fungsi di sini
                                setBpjsKesehatan(response.bpjs_kesehatan); // Perbaikan penamaan fungsi di sini
                                setBpjsKg(response.bpjs_kg); // Perbaikan penamaan fungsi di sini
                                setBpjsJp(response.bpjs_jp); // Perbaikan penamaan fungsi di sini
                                setFcKtp(response.foto_ktp); // Perbaikan penamaan fungsi di sini
                                setFcIjazah(response.fc_ijazah); // Perbaikan penamaan fungsi di sini
                                setFcTn(response.fc_tn); // Perbaikan penamaan fungsi di sini
                                setFcBt(response.fc_bt); // Perbaikan penamaan fungsi di sini
                                setFcNpwp(response.fc_npwp); // Perbaikan penamaan fungsi di sini
                                setFcKk(response.fc_kk); // Perbaikan penamaan fungsi di sini
                                setFcSp(response.fc_sp); // Perbaikan penamaan fungsi di sini
                                setFoto(response.foto); // Perbaikan penamaan fungsi di sini

                                // Check form completeness after setting candidate data
                                checkFormCompleteness();
                            } else {
                                alert(response.error);
                            }
                        },

                        error: function(xhr, status, error) {
                            console.error(xhr);
                        }
                    });
                } else {
                    clearForm();
                    // Check form completeness when no candidate is selected
                    checkFormCompleteness();
                }
            });

            // Check form completeness when any related field changes
            $('#nama_kandidat, #form_tanggal_lengkap, #no_ktp, #pendidikan, #alasan_penerimaan').on('input', function() {
                checkFormCompleteness();
            });


            // Function to check form completeness
            function checkFormCompleteness() {
                var nama_kandidat = $('#nama_kandidat').val();
                var form_tanggal_lengkap = $('#form_tanggal_lengkap').val();
                var no_ktp = $('#no_ktp').val();
                var pendidikan = $('#pendidikan').val();
                var alasan_penerimaan = $('#alasan_penerimaan').val();
                var form_interview_user_lengkap = $('#form_interview_user_lengkap').prop('checked');
                var form_interview_hr_lengkap = $('#form_interview_hr_lengkap').prop('checked');

                // // Check if file_interview_user exists
                // var file_interview_user_exists = $('#form_interview_user_lengkap').prop('checked');

                if (nama_kandidat !== '' && form_tanggal_lengkap !== '' && no_ktp !== '' && pendidikan !== '' && alasan_penerimaan !== '') {
                    $('#form_aplikasi_lengkap').prop('checked', true);
                    $('#form_aplikasi_tidak_lengkap').prop('checked', false);
                } else {
                    $('#form_aplikasi_lengkap').prop('checked', false);
                    $('#form_aplikasi_tidak_lengkap').prop('checked', true);
                }
            }


            // Call checkFormCompleteness when any related field changes
            $('#nama_kandidat, #form_tanggal_lengkap, #no_ktp, #pendidikan, #alasan_penerimaan').on('input', function() {
                checkFormCompleteness();
            });

            // Call checkFormCompleteness initially
            checkFormCompleteness();
        });


        function redirectToPage() {
            // Implement the redirection logic here
            alert('Redirecting to the verification page...');
        }
    </script>

</head>

<body>
    <div class="container">

        <a href="data_hc.php?id=<?php echo $userId; ?>&branches=<?php echo $branches; ?>" class="database">
            <img src="./img/database (1).png" alt="database" style="width: 40px; height: 40px; margin: 15px 15px;"></a>

        <a href="../index.php?id=<?php echo $userId; ?>" class="dashboard">
            <img src="./img/dashboard (1).png" alt="dashboard" style="width: 40px; height: 40px; margin: 15px 15px;"></a>
        <style>
            .card {
                width: 1050px;
                border-radius: 10px;
                box-shadow: 0 4px 0 0 rgba(0, 0, 0, 0.2);
                overflow: hidden;
                background-color: #fff;
            }

            .card img {
                width: 1050px;
                /* Lebar gambar 1200px */
                height: 150px;
                /* Tinggi gambar 150px */
                border-radius: 10px 10px 0 0;
            }

            .card-content {
                width: 1000px;
                /* Lebar gambar 1200px */
                /* padding: 10px; */
            }

            .card-content h3 {
                margin-top: 0;
                margin-bottom: 0;
                font-size: 1rem;
            }

            .card-content p {
                margin-bottom: 0;
            }

            /* CSS */
            #checkEmployeeTransferBtn {
                background-color: #4CAF50;
                /* Warna latar hijau */
                border: none;
                color: white;
                /* Warna teks putih */
                padding: 5px;
                /* Padding atas dan bawah 15px, padding kiri dan kanan 32px */
                text-align: center;
                /* Teks rata tengah */
                text-decoration: none;
                display: inline-block;
                font-size: 12px;
                margin: 4px 2px;
                /* Margin atas dan bawah 4px, margin kiri dan kanan 2px */
                cursor: pointer;
                border-radius: 6px;
                /* Border radius 8px */
                transition-duration: 0.4s;
                /* Durasi animasi saat perubahan warna */
            }

            #checkEmployeeTransferBtn:hover {
                background-color: #45a049;
                /* Warna latar belakang lebih gelap saat hover */
            }

            /* .table-container {
                display: flex;
                justify-content: space-between;
                width: 100%;
            } */

            .table-cell {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                width: 100%;
            }

            .radio-label {
                display: flex;
                align-items: center;
            }

            .radio-label input[type="radio"] {
                margin-right: 5px;
            }

            .radio-container {
                display: flex;
                align-items: center;
            }
        </style>
        <script>
            function redirectToPage() {
                window.location.href = 'your_redirect_url_here';
            }
        </script>

        <style>
            #bpjs_jaminan_pensiun_redirect {
                color: blue;
                text-decoration: none;
            }

            #bpjs_jaminan_pensiun_redirect:hover {
                text-decoration: underline;
            }
        </style>
        <form action="save_hc.php" method="POST">
            <div class="card">
                <img src="img/hc-header.png" alt="Placeholder Image" style="width: 1060px; margin-left: -5px;">
                <div class="card-content">


                    <!-- Kemudian dalam formulir HTML Anda -->
                    <table style="margin-left: 20px;  width: 100%;">
                        <div class="table-cell" style="display: flex; justify-content: center; align-items: center; flex-direction: column; margin-top: 10px; margin-bottom: 10px;">
                            <div style="margin-bottom: -10px; display: flex; justify-content: center; align-items: center; width: 50%;">
                                <input type="text" id="hc" name="hc" value="No : 497/HC/HRD-Div-HOLDING/VI/2024" readonly style="text-align: center;">
                            </div>
                        </div>
                        <!-- Baris 1 -->
                        <tr class="table-container">
                            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
                                <div class="table-cell">
                                    <label for="fpk_selection" style="width: 250px;">FPK No</label>
                                    <select id="fpk_selection" name="fpk_selection" onchange="fillForm()" style="width: 88%; vertical-align: middle; margin-bottom: 0px;" required>
                                        <option value="">Pilih Kode FPK</option>
                                        <?php foreach ($fpk_data as $index => $fpk) : ?>
                                            <option value="<?php echo $fpk['kodeFPK']; ?>"><?php echo $fpk['kodeFPK']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                            <td style="width: 45%; vertical-align: middle; height: 5px;">
                                <div class="table-cell">
                                    <label for="id_candidates">Pilih Kandidat:</label>
                                    <select id="id_candidates" name="id_candidates" style="width: 64%; vertical-align: middle; margin-bottom: 0px;" required onchange="updateNamaKandidat()">
                                        <option value="">Pilih Kandidat</option>
                                        <!-- Tambahkan opsi kandidat di sini -->
                                    </select>
                                    <input type="hidden" id="nama_kandidat" name="nama_kandidat">
                                </div>
                            </td>

                            <script>
                                function updateNamaKandidat() {
                                    var select = document.getElementById("id_candidates");
                                    var selectedOption = select.options[select.selectedIndex];
                                    var namaKandidat = selectedOption.text; // Asumsikan teks opsi adalah nama kandidat
                                    document.getElementById("nama_kandidat").value = namaKandidat;
                                }
                            </script>

                        </tr>

                        <!-- BARIS  2-->
                        <tr class="table-container">
                            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
                                <div class="table-cell">
                                    <label for="golongan" style="width: 250px;">Level/golongan</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="golongan" name="golongan" placeholder="Level / Golongan" required>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 45%; vertical-align: middle; height: 5px;">
                                <div class="table-cell">
                                    <label for="form_tanggal_lengkap" style="width: 250px;">Tanggal Lahir</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="date" id="form_tanggal_lengkap" name="form_tanggal_lengkap">
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- BARIS 3 -->
                        <tr class="table-container">
                            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
                                <div class="table-cell">
                                    <label for="branch" style="width: 250px;">Unit Bisnis</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="branch" name="branch" placeholder="Unit Bisnis" required>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 45%; vertical-align: middle; height: 5px;">
                                <div class="table-cell">
                                    <label for="no_ktp" style="width: 250px;">No. KTP</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="no_ktp" name="no_ktp" placeholder="No. KTP" required>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- BARIS 4 -->
                        <tr class="table-container">
                            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
                                <div class="table-cell">
                                    <label for="jabatan" style="width: 250px;">Jabatan</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="jabatan" name="jabatan" placeholder="Jabatan" required>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 45%; vertical-align: middle; height: 5px;">
                                <div class="table-cell">
                                    <label for="pendidikan" style="width: 250px;">Pendidikan</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="pendidikan" name="pendidikan" placeholder="Pendidikan" required>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- BARIS 5 -->
                        <tr class="table-container">
                            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
                                <div class="table-cell">
                                    <label for="organisasi" style="width: 250px;">Divisi/Dept</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="organisasi" name="organisasi" placeholder="Divisi / Departmen" required>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 45%; vertical-align: middle; height: 5px;">
                                <div class="table-cell">
                                    <label for="alasan_penerimaan" style="width: 250px;">Alasan Penerimaan</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="alasan_penerimaan" name="alasan_penerimaan" placeholder="Alasan Penerimaan" required>
                                    </div>
                                </div>
                            </td>
                        </tr>



                    </table>

                    <h5 style="margin-left: 23px;"><strong>Pengajuan</strong></h5>

                    <table style="margin-left: 20px;  width: 100%;">
                        <!-- Gaji Pokok -->
                        <tr class="table-container">
                            <td style="width: 70%; vertical-align: middle; height: 5px; padding-right: 20px;">
                                <div class="table-cell">
                                    <label for="gaji_pokok" style="width: 250px;">Gaji Pokok</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="gaji_pokok" name="gaji_pokok" placeholder="Gaji Pokok" required>
                                    </div>
                                </div>
                            </td>
                            <td rowspan="3" style="width: 45%; vertical-align: middle; height: 5px;">
                                <div class="table-cell">
                                    <label for="form_catatan" style="width: 100px;">Catatan</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 100%;">
                                        <textarea id="form_catatan" name="form_catatab" style="width: 100%; height: 100px;" required></textarea>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Tunjangan Makan -->
                        <tr class="table-container">
                            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
                                <div class="table-cell">
                                    <label for="tunjangan_makan" style="width: 250px;">Tunjangan Makan</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="tunjangan_makan" name="tunjangan_makan" placeholder="Tunjangan Makan" required>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Tunjangan Transport -->
                        <tr class="table-container">
                            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
                                <div class="table-cell">
                                    <label for="tunjangan_transport" style="width: 250px;">Tunjangan Transport</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="tunjangan_transport" name="tunjangan_transport" placeholder="Tunjangan Transport" required>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Tunjangan Kendaraan -->
                        <tr class="table-container">
                            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
                                <div class="table-cell">
                                    <label for="tunjangan_kendaraan" style="width: 250px;">Tunjangan Kendaraan</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="tunjangan_kendaraan" name="tunjangan_kendaraan" placeholder="Tunjangan Kendaraan" required>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- TOTAL SALLARY GROSS -->
                        <tr class="table-container">
                            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px; background-color: #f0f0f0;">
                                <div class="table-cell">
                                    <label for="total_sallary_gross" style="width: 250px; font-weight: bold;">Total Salary (Gross)</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="total_sallary_gross" name="total_sallary_gross" placeholder="Total Sallary Gross" style="font-weight: bold; background-color: #f0f0f0;" readonly>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- BPJS Ketenagakerjaan (JHT) -->
                        <tr class="table-container">
                            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
                                <div class="table-cell">
                                    <label for="bpjs_jht" style="width: 250px;">BPJS Ketenagakerjaan (JHT)</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="bpjs_jht" name="bpjs_jht" placeholder="BPJS Ketenagakerjaan (JHT)" required>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- BPJS Ketenagakerjaan (JP) -->
                        <tr class="table-container">
                            <td style="width: 55%; vertical-align: middle; height: 5px; padding-right: 20px;">
                                <div class="table-cell">
                                    <label for="bpjs_jp" style="width: 250px;">BPJS Ketenagakerjaan (JP)</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="bpjs_jp" name="bpjs_jp" placeholder="BPJS Ketenagakerjaan (JP)" required>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- BPJS Kesehatan -->
                        <tr class="table-container">
                            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
                                <div class="table-cell">
                                    <label for="bpjs_ks" style="width: 250px;">BPJS Kesehatan</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="bpjs_ks" name="bpjs_ks" placeholder="BPJS Kesehatan" required>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Koperasi Karyawan -->
                        <tr class="table-container">
                            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px;">
                                <div class="table-cell">
                                    <label for="koperasi_karyawan" style="width: 250px;">Koperasi Karyawan</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="koperasi_karyawan" name="koperasi_karyawan" placeholder="Koperasi Karyawan" required>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- TOTAL SALLARY NETT -->
                        <tr class="table-container">
                            <td style="width: 45%; vertical-align: middle; height: 5px; padding-right: 20px; background-color: #f0f0f0;">
                                <div class="table-cell">
                                    <label for="total_sallary_nett" style="width: 250px; font-weight: bold;">Total Salary (Nett)</label>
                                    <div style="margin-bottom: -10px; display: flex; align-items: center; width: 90%;">
                                        <input type="text" id="total_sallary_nett" name="total_sallary_nett" placeholder="Total Sallary Nett" style="font-weight: bold; background-color: #f0f0f0;" readonly>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <!-- JavaScript -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const grossFields = [
                                    'gaji_pokok', 'tunjangan_makan', 'tunjangan_transport',
                                    'tunjangan_kendaraan'
                                ];

                                const nettFields = [
                                    'bpjs_jht', 'bpjs_jp', 'bpjs_ks', 'koperasi_karyawan'
                                ];

                                const formatRupiah = (angka, prefix) => {
                                    const number_string = angka.replace(/[^,\d]/g, '').toString();
                                    const split = number_string.split(',');
                                    const sisa = split[0].length % 3;
                                    let rupiah = split[0].substr(0, sisa);
                                    const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                                    if (ribuan) {
                                        const separator = sisa ? '.' : '';
                                        rupiah += separator + ribuan.join('.');
                                    }

                                    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                                    return prefix === undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
                                };

                                const calculateTotal = () => {
                                    let grossTotal = 0;
                                    let nettTotal = 0;

                                    grossFields.forEach(id => {
                                        const value = document.getElementById(id).value.replace(/[^,\d]/g, '');
                                        grossTotal += parseInt(value) || 0;
                                    });

                                    nettFields.forEach(id => {
                                        const value = document.getElementById(id).value.replace(/[^,\d]/g, '');
                                        nettTotal += parseInt(value) || 0;
                                    });

                                    const totalGrossElement = document.getElementById('total_sallary_gross');
                                    const totalNettElement = document.getElementById('total_sallary_nett');
                                    totalGrossElement.value = formatRupiah(grossTotal.toString(), 'Rp ');
                                    totalNettElement.value = formatRupiah((grossTotal - nettTotal).toString(), 'Rp ');
                                };

                                const allFields = [...grossFields, ...nettFields];

                                allFields.forEach(id => {
                                    const inputElement = document.getElementById(id);
                                    inputElement.addEventListener('blur', function() {
                                        this.value = formatRupiah(this.value, 'Rp ');
                                        calculateTotal();
                                    });
                                });
                            });
                        </script>

                    </table>

                    <h5 style="margin-left: 23px; margin-top: 0px;"><strong>Dokumen Checklist</strong></h5>
                    <style>
                        #bpjs_jaminan_pensiun_redirect {
                            color: blue;
                            text-decoration: none;
                        }

                        #bpjs_jaminan_pensiun_redirect:hover {
                            text-decoration: underline;
                        }
                    </style>
                    <table style="margin-left: 20px; width: 100%;">
                        <!-- BARIS 1 -->
                        <tr class="table-container">
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <label style="width: 50%;">Form Aplikasi</label>
                                    <div style="border: 1px solid #ccc; padding: 2px; width: 90%;" class="radio-container">
                                        <div class="radio-label" style="margin-right: 10px;">
                                            <input type="radio" id="form_aplikasi_lengkap" name="form_aplikasi" value="Lengkap" required>
                                            <label for="form_aplikasi_lengkap">Lengkap</label>
                                        </div>
                                        <div class="radio-label" style="margin-right: 10px;">
                                            <input type="radio" id="form_aplikasi_tidak_lengkap" name="form_aplikasi" value="Tidak Lengkap" required>
                                            <label for="form_aplikasi_tidak_lengkap">Tidak Lengkap</label>
                                        </div>
                                        <div class="radio-label">
                                            <a href="javascript:void(0);" id="bpjs_jaminan_pensiun_redirect" name="bpjs_jaminan_pensiun_redirect" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <label style="width: 50%;">Foto</label>
                                    <div style="border: 1px solid #ccc; padding: 2px; width:90%; display: flex; align-items: center;">
                                        <label for="pas_foto_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="pas_foto_lengkap" name="pas_foto" value="Lengkap" required>
                                            Lengkap
                                        </label>
                                        <label for="pas_foto_tidak_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="pas_foto_tidak_lengkap" name="pas_foto" value="Tidak Lengkap" required>
                                            Tidak Lengkap
                                        </label>
                                        <div class="radio-label">
                                            <a href="javascript:void(0);" id="pas_foto_verifikasi" name="pas_foto_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">
                                                Verifikasi
                                            </a>
                                        </div>
                                    </div>
                            </td>
                        </tr>

                        <!-- BARIS  2-->
                        <tr class="table-container">
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <div class="table-cell">
                                        <label style="width: 50%;">Interview User</label>
                                        <div style="border: 1px solid #ccc; padding: 2px; width: 90%;" class="radio-container">
                                            <div class="radio-label" style="margin-right: 10px;">
                                                <input type="radio" id="form_interview_user_lengkap" name="form_interview_user" value="Lengkap" required>
                                                <label for="form_interview_user_lengkap">Lengkap</label>
                                            </div>
                                            <div class="radio-label" style="margin-right: 10px;">
                                                <input type="radio" id="form_interview_user_tidak_lengkap" name="form_interview_user" value="Tidak Lengkap" required>
                                                <label for="form_interview_user_tidak_lengkap">Tidak Lengkap</label>
                                            </div>
                                            <div class="radio-label">
                                                <a href="javascript:void(0);" id="form_interview_user_verifikasi" name="form_interview_user_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">Verifikasi</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <label style="width: 50%;">Scan KTP</label>
                                    <div style="border: 1px solid #ccc; padding: 2px; width:90%; display: flex; align-items: center;"> <label style="margin-right: 10px;">
                                            <input type="radio" id="foto_ktp_lengkap" name="foto_ktp" value="Lengkap" required>
                                            Lengkap
                                        </label>
                                        <label for="foto_ktp_tidak_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="foto_ktp_tidak_lengkap" name="foto_ktp" value="Tidak Lengkap" required>
                                            Tidak Lengkap
                                        </label>
                                        <div class="radio-label">
                                            <a href="javascript:void(0);" id="foto_ktp_verifikasi" name="foto_ktp_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">
                                                Verifikasi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- BARIS 3 -->
                        <tr class="table-container">
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <div class="table-cell">
                                        <label style="width: 50%;">Interview HR</label>
                                        <div style="border: 1px solid #ccc; padding: 2px; display: flex; align-items: center; width: 90%;" class="radio-container">
                                            <label for="form_interview_hr_lengkap" style="margin-right: 10px;">
                                                <input type="radio" id="form_interview_hr_lengkap" name="form_interview_hr" value="Lengkap" required>
                                                Lengkap
                                            </label>
                                            <label for="form_interview_hr_tidak_lengkap" style="margin-right: 10px;">
                                                <input type="radio" id="form_interview_hr_tidak_lengkap" name="form_interview_hr" value="Tidak Lengkap" required>
                                                Tidak Lengkap
                                            </label>
                                            <div>
                                                <a href="javascript:void(0);" id="form_interview_hr_verifikasi" name="form_interview_hr_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">
                                                    Verifikasi
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </td>
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <label style="width: 50%;">Scan Ijazah</label>
                                    <div style="border: 1px solid #ccc; padding: 2px; width: 90%; display: flex; align-items: center;">
                                        <label for="foto_ijazah_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="foto_ijazah_lengkap" name="foto_ijazah" value="Lengkap" required>
                                            Lengkap
                                        </label>
                                        <label for="foto_ijazah_tidak_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="foto_ijazah_tidak_lengkap" name="foto_ijazah" value="Tidak Lengkap" required>
                                            Tidak Lengkap
                                        </label>
                                        <div class="radio-label">
                                            <a href="javascript:void(0);" id="foto_ijazah_verifikasi" name="foto_ijazah_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">
                                                Verifikasi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- BARIS 4 -->
                        <tr class="table-container">
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <label style="width: 250px;">Laporan Hasil Psikotest</label>
                                    <div style="border: 1px solid #ccc; padding: 2px; display: flex; align-items: center; width: 90%;">
                                        <label for="form_hasil_psikotest_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="form_hasil_psikotest_lengkap" name="form_hasil_psikotest" value="Lengkap" required>
                                            Lengkap
                                        </label>
                                        <label for="form_hasil_psikotest_tidak_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="form_hasil_psikotest_tidak_lengkap" name="form_hasil_psikotest" value="Tidak Lengkap" required>
                                            Tidak Lengkap
                                        </label>
                                        <div class="radio-label">
                                            <a href="javascript:void(0);" id="form_hasil_psikotest_verifikasi" name="form_hasil_psikotest_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">
                                                Verifikasi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <label style="width: 250px;">Scan Transkip Nilai</label>
                                    <div style="border: 1px solid #ccc; padding: 2px; width: 90%; display: flex; align-items: center;">
                                        <label for="foto_transkip_nilai_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="foto_transkip_nilai_lengkap" name="foto_transkip_nilai" value="Lengkap" required>
                                            Lengkap
                                        </label>
                                        <label for="foto_transkip_nilai_tidak_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="foto_transkip_nilai_tidak_lengkap" name="foto_transkip_nilai" value="Tidak Lengkap" required>
                                            Tidak Lengkap
                                        </label>
                                        <div class="radio-label">
                                            <a href="javascript:void(0);" id="foto_transkip_nilai_verifikasi" name="foto_transkip_nilai_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">
                                                Verifikasi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- BARIS 5 -->
                        <tr class="table-container">
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <label style="width: 250px;">Confirmation Letter</label>
                                    <div style="border: 1px solid #ccc; padding: 2px; display: flex; align-items: center; width: 90%;">
                                        <label for="form_confirmation_letter_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="form_confirmation_letter_lengkap" name="form_confirmation_letter" value="Lengkap" required>
                                            Lengkap
                                        </label>
                                        <label for="form_confirmation_letter_tidak_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="form_confirmation_letter_tidak_lengkap" name="form_confirmation_letter" value="Tidak Lengkap" required>
                                            Tidak Lengkap
                                        </label>
                                        <div class="radio-label">
                                            <a href="javascript:void(0);" id="form_confirmation_letter_verifikasi" name="form_confirmation_letter_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">
                                                Verifikasi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <label style="width: 250px;">Scan Buku Tabungan</label>
                                    <div style="border: 1px solid #ccc; padding: 2px; width: 90%; display: flex; align-items: center;">
                                        <label for="foto_buku_tabungan_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="foto_buku_tabungan_lengkap" name="foto_buku_tabungan" value="Lengkap" required>
                                            Lengkap
                                        </label>
                                        <label for="foto_buku_tabungan_tidak_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="foto_buku_tabungan_tidak_lengkap" name="foto_buku_tabungan" value="Tidak Lengkap" required>
                                            Tidak Lengkap
                                        </label>
                                        <div class="radio-label">
                                            <a href="javascript:void(0);" id="foto_buku_tabungan_verifikasi" name="foto_buku_tabungan_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">
                                                Verifikasi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- BARIS 6 -->
                        <tr class="table-container">
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <label style="width: 250px;">Hasil Tes Kesehatan</label>
                                    <div style="border: 1px solid #ccc; padding: 2px; display: flex; align-items: center; width: 90%;">
                                        <label for="form_hasil_tes_kesehatan_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="form_hasil_tes_kesehatan_lengkap" name="form_hasil_tes_kesehatan" value="Lengkap" required>
                                            Lengkap
                                        </label>
                                        <label for="form_hasil_tes_kesehatan_tidak_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="form_hasil_tes_kesehatan_tidak_lengkap" name="form_hasil_tes_kesehatan" value="Tidak Lengkap" required>
                                            Tidak Lengkap
                                        </label>
                                        <div class="radio-label">
                                            <a href="javascript:void(0);" id="form_hasil_tes_kesehatan_verifikasi" name="form_hasil_tes_kesehatan_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">
                                                Verifikasi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <label style="width: 250px;">Scan NPWP</label>
                                    <div style="border: 1px solid #ccc; padding: 2px; width: 90%; display: flex; align-items: center;">
                                        <label for="foto_npwp_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="foto_npwp_lengkap" name="foto_npwp" value="Lengkap" required>
                                            Lengkap
                                        </label>
                                        <label for="foto_npwp_tidak_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="foto_npwp_tidak_lengkap" name="foto_npwp" value="Tidak Lengkap" required>
                                            Tidak Lengkap
                                        </label>
                                        <div class="radio-label">
                                            <a href="javascript:void(0);" id="foto_npwp_redirect" name="foto_npwp_redirect" onchange="redirectToPage()" style="text-decoration: none; color: blue;">
                                                Verifikasi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Baris 7 -->
                        <tr class="table-container">
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <label style="width: 250px;">Referensi Kerja</label>
                                    <div style="border: 1px solid #ccc; padding: 2px; display: flex; align-items: center; width: 90%;">
                                        <label for="referensi_kerja_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="referensi_kerja_lengkap" name="referensi_kerja" value="Lengkap" required>
                                            Lengkap
                                        </label>
                                        <label for="referensi_kerja_tidak_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="referensi_kerja_tidak_lengkap" name="referensi_kerja" value="Tidak Lengkap" required>
                                            Tidak Lengkap
                                        </label>
                                        <div class="radio-label">
                                            <a href="javascript:void(0);" id="referensi_kerja_verifikasi" name="referensi_kerja_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">
                                                Verifikasi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <label style="width: 250px;">Scan Kartu Keluarga</label>
                                    <div style="border: 1px solid #ccc; padding: 2px; width: 90%; display: flex; align-items: center;">
                                        <label for="foto_kk_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="foto_kk_lengkap" name="foto_kk" value="Lengkap" required>
                                            Lengkap
                                        </label>
                                        <label for="foto_kk_tidak_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="foto_kk_tidak_lengkap" name="foto_kk" value="Tidak Lengkap" required>
                                            Tidak Lengkap
                                        </label>
                                        <div class="radio-label">
                                            <a href="javascript:void(0);" id="foto_kk_redirect" name="foto_npwp_redirect" onchange="redirectToPage()" style="text-decoration: none; color: blue;">
                                                Verifikasi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- BARIS 8 -->
                        <tr class="table-container">
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <label style="width: 250px;">BPJS Kesehatan</label>
                                    <div style="border: 1px solid #ccc; padding: 2px; display: flex; align-items: center; width: 90%;">
                                        <label for="bpjs_kesehatan_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="bpjs_kesehatan_lengkap" name="bpjs_kesehatan" value="Lengkap" required>
                                            Lengkap
                                        </label>
                                        <label for="bpjs_kesehatan_tidak_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="bpjs_kesehatan_tidak_lengkap" name="bpjs_kesehatan" value="Tidak Lengkap" required>
                                            Tidak Lengkap
                                        </label>
                                        <div class="radio-label">
                                            <a href="javascript:void(0);" id="bpjs_kesehatan_verifikasi" name="bpjs_kesehatan_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">
                                                Verifikasi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <label style="width: 250px;">Scan Sertifikat</label>
                                    <div style="border: 1px solid #ccc; padding: 2px; width: 90%; display: flex; align-items: center;">
                                        <label for="foto_sertifikat_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="foto_sertifikat_lengkap" name="foto_sertifikat" value="Lengkap" required>
                                            Lengkap
                                        </label>
                                        <label for="foto_sertifikat_tidak_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="foto_sertifikat_tidak_lengkap" name="foto_sertifikat" value="Tidak Lengkap" required>
                                            Tidak Lengkap
                                        </label>
                                        <div class="radio-label">
                                            <a href="javascript:void(0);" id="foto_sertifikat_redirect" name="foto_sertifikat_redirect" onchange="redirectToPage()" style="text-decoration: none; color: blue;">
                                                Verifikasi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- BARIS 9 -->
                        <tr class="table-container">
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <label style="width: 250px;">BPJS Ketenagakerjaan</label>
                                    <div style="border: 1px solid #ccc; padding: 2px; display: flex; align-items: center; width: 90%;">
                                        <label for="bpjs_ketenagakerjaan_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="bpjs_ketenagakerjaan_lengkap" name="bpjs_ketenagakerjaan" value="Lengkap" required>
                                            Lengkap
                                        </label>
                                        <label for="bpjs_ketenagakerjaan_tidak_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="bpjs_ketenagakerjaan_tidak_lengkap" name="bpjs_ketenagakerjaan" value="Tidak Lengkap" required>
                                            Tidak Lengkap
                                        </label>
                                        <div class="radio-label">
                                            <a href="javascript:void(0);" id="bpjs_ketenagakerjaan_verifikasi" name="bpjs_ketenagakerjaan_verifikasi" onclick="redirectToPage()" style="text-decoration: none; color: blue;">
                                                Verifikasi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>

                        <!-- baris 10 -->
                        <tr class="table-container">
                            <td style="width: 50%; vertical-align: middle;">
                                <div class="table-cell">
                                    <label style="width: 50%;">BPJS Jaminan Pensiun</label>
                                    <div style="border: 1px solid #ccc; padding: 2px; width: 90%; display: flex; align-items: center;">
                                        <label for="bpjs_jaminan_pensiun_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="bpjs_jaminan_pensiun_lengkap" name="bpjs_jaminan_pensiun" value="Lengkap" required>
                                            Lengkap
                                        </label>
                                        <label for="bpjs_jaminan_pensiun_tidak_lengkap" style="margin-right: 10px;">
                                            <input type="radio" id="bpjs_jaminan_pensiun_tidak_lengkap" name="bpjs_jaminan_pensiun" value="Tidak Lengkap" required>
                                            Tidak Lengkap
                                        </label>
                                        <div class="radio-label">
                                            <a href="javascript:void(0);" id="bpjs_jaminan_pensiun_redirect" name="bpjs_jaminan_pensiun_redirect" onclick="redirectToPage()" style="text-decoration: none; color: blue;">
                                                Verifikasi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>

                    </table>

                </div>

                <div class="row" style="justify-content: right; margin-right: 50px; padding-bottom: 30px;"> <!-- Menggunakan class text-right untuk memposisikan ke kanan -->
                    <input type="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>
    </div>

</body>

</html>