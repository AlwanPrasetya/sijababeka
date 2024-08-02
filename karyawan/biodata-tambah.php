<?php
// proses.php

// Konfigurasi koneksi ke database
$host = 'localhost';
$dbname = 'db_sijababeka';
$username = 'alwan';
$password = 'root';

// proses.php

try {
    // Koneksi ke database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Atur mode error untuk PDO ke Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ambil id_biodata dari URL (misalnya detail_biodata.php?id_biodata=ID-1716352436538)
    if (isset($_GET['id_biodata'])) {
        $id_biodata = $_GET['id_biodata'];

        // Query untuk mengambil data dari database
        $stmt = $pdo->prepare("SELECT * FROM biodata_karyawan WHERE id_biodata = :id_biodata");
        $stmt->bindParam(':id_biodata', $id_biodata);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Jika data ditemukan
        if ($data) {
            $posisi = $data['posisi'];
            $nama_lengkap = $data['nama_lengkap'];
            $nama_panggilan = $data['nama_panggilan'];
            $jenis_kelamin = $data['jenis_kelamin'];
            $golongan_darah = $data['golongan_darah'];
            $tm_lahir = $data['tm_lahir'];
            $tanggal_lahir = $data['tanggal_lahir'];
            $no_ktp = $data['no_ktp'];
            $no_npwp = $data['no_npwp'];
            $kewarganegaraan = $data['kewarganegaraan'];
            $agama = $data['agama'];
            $no_tlpn_rumah = $data['no_tlpn_rumah'];
            $no_tlpn = $data['no_tlpn'];
            $email = $data['email'];
            $foto = $data['foto'];
            // Tambahkan variabel lain yang diperlukan dari database

            // // Contoh penggunaan nilai yang telah diambil
            // echo "Data untuk ID Biodata: $id_biodata<br>";
            // echo "Nama Lengkap: " . ($nama_lengkap ?: 'Data tidak tersedia') . "<br>";
            // echo "Email: " . ($email ?: 'Data tidak tersedia') . "<br>";
        } else {
            echo "Data tidak ditemukan.";
        }
    } else {
        echo "ID Biodata tidak ditemukan dalam URL.";
    }
} catch (PDOException $e) {
    die("Gagal terkoneksi dengan database: " . $e->getMessage());
}
?>


<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #EAFAF1;
        margin: 0;
        padding: 0;


        h1,
        h3,
        h4 {
            color: #333;
        }

        form {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .section {
            flex: 1 1 45%;
            min-width: 45%;
        }

        .two-columns {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td {
            padding: 10px;
            vertical-align: top;
        }

        td input[type="text"],
        td input[type="date"],
        td input[type="email"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        td input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        td input[type="submit"]:hover {
            background-color: #45a049;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:nth-child(odd) {
            background-color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        h1 {
            margin-top: 2rem;
            text-align: center;
        }

        .full-width {
            flex: 1 1 100%;
        }

        body {
            margin: 0;
            font-family: "Montserrat", sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .form-table th,
        .form-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .form-table th {
            background-color: yellowgreen;
            color: white;
        }

        .form-table td {
            background-color: #ffffff;
        }

        .form-table input,
        .form-table select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .foto-box {
            width: 3cm;
            height: 3cm;
            border: 1px solid #000;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
            text-align: center;
        }

        .foto-input {
            width: 100%;
            height: 100%;
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            cursor: pointer;
        }

        .foto-label {
            pointer-events: none;
        }

    }
</style>

<h1>Biodata Karyawan Jababeka</h1>

<form id="myForm" action="proses.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
    <table style="display: none;">
        <tr>
            <td width="150">ID Biodata:</td>
            <td><input type="text" name="id_biodata" value="<?php echo $id_biodata ?? ''; ?>" readonly></td>
        </tr>
    </table>

    <!-- Tabel Foto -->
    <table>
        <tr>
            <td style=" border: 0px;"></td>
            <td width="650px">POSISI PEKERJAAN YANG DILAMAR:</td>
        </tr>
        <tr style="background-color: white; border: 0px;">
            <style>
                .foto-box {
                    margin-top: -50px;
                    width: 200px;
                    /* Tentukan lebar kotak unggah */
                    height: 200px;
                    /* Tentukan tinggi kotak unggah */
                    border: 2px dashed #ccc;
                    /* Tambahkan border agar terlihat seperti kotak unggah */
                    position: relative;
                    overflow: hidden;
                    /* Pastikan gambar tidak keluar dari kotak */
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .foto-input {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    opacity: 0;
                    /* Sembunyikan input file */
                    cursor: pointer;
                }

                .foto-label {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    font-size: 16px;
                    color: #666;
                    pointer-events: none;
                    /* Pastikan label tidak menghalangi klik pada input file */
                }

                .foto-preview {
                    max-width: 100%;
                    max-height: 100%;
                    display: none;
                    /* Sembunyikan gambar awalnya */
                }
            </style>

            <td style="margin-top: -100px; border: 0px;">
                <div class="foto-box">
                    <input type="file" name="foto" id="foto" class="foto-input" onchange="previewImage(event)" required>
                    <label for="foto" class="foto-label">Upload Foto Terbaru</label>
                    <img id="foto-preview" class="foto-preview" src="#" alt="Preview">
                </div>
            </td>

            <script>
                function previewImage(event) {
                    var reader = new FileReader();
                    reader.onload = function() {
                        var output = document.getElementById('foto-preview');
                        output.src = reader.result;
                        output.style.display = 'block';

                        var label = document.querySelector('.foto-label');
                        label.style.display = 'none'; // Sembunyikan label saat gambar diunggah
                    }
                    reader.readAsDataURL(event.target.files[0]);
                }
            </script>

            <td><input type="text" name="posisi" required></td>
        </tr>
    </table>

    <!-- Tabel Data Peribadi -->
    <h3 style="margin-top: 0px;">I. Data Pribadi</h3>
    <table style="width:100%; margin-top: -25px;">
        <tr>
            <td style="width:50%">
                <!-- Kolom Kiri -->
                <table>
                    <tr>
                        <td style="width:50%">Nama Lengkap:</td>
                        <td><input type="text" name="nama_lengkap" required></td>
                    </tr>
                    <tr>
                        <td>Nama Panggilan</td>
                        <td><input type="text" name="nama_panggilan" required></td>
                    </tr>

                    <tr>
                        <td>Jenis Kelamin:</td>
                        <td>
                            <select style="width: 200px; height: 35px;" name="jenis_kelamin" class="jenis_kelamin" required>
                                <option value="">pilih</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Golongan Darah:</td>
                        <td>
                            <select style="width: 200px; height: 35px;" name="golongan_darah" required>
                                <option value="">pilih</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Tempat Lahir:</td>
                        <td><input type="text" name="tm_lahir" required></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir:</td>
                        <td><input type="date" name="tanggal_lahir" required></td>
                    </tr>
                    <tr>
                        <td>No. KTP:</td>
                        <td><input type="text" name="no_ktp" id="no_ktp" maxlength="16" oninput="validateKTP(this)" required></td>
                    </tr>
                </table>
                <script>
                    function validateKTP(input) {
                        // Remove any non-digit characters
                        input.value = input.value.replace(/\D/g, '');

                        // Ensure the input length does not exceed 16 digits
                        if (input.value.length > 16) {
                            input.value = input.value.slice(0, 16);
                        }
                    }

                    function validateForm() {
                        var no_ktp = document.getElementById('no_ktp').value;

                        // Check if no_ktp is exactly 16 digits
                        if (no_ktp.length !== 16) {
                            alert('Nomor KTP harus terdiri dari 16 digit.');
                            return false; // Prevent form submission
                        }

                        // Continue with form submission
                        return true;
                    }
                </script>
            </td>

            <td style="width:50%;">
                <!-- Kolom Kanan -->
                <table>
                    <tr>
                        <td>Nomor NPWP:</td>
                        <td><input type="text" name="no_npwp" requuired></td>
                    </tr>
                    <tr>
                        <td>Kewarganegaraan:</td>
                        <td><input type="text" name="kewarganegaraan" required></td>
                    </tr>
                    <tr>
                        <td>Agama:</td>
                        <td>
                            <select style="width: 200px; height: 35px;" name="agama" required>
                                <option value="">pilih</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>No. Telepon Rumah:</td>
                        <td><input type="text" name="no_tlpn_rumah" required></td>
                    </tr>
                    <tr>
                        <td>No. Telepon Seluler:</td>
                        <td><input type="text" name="no_tlpn" required></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="text" name="email" required></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <style>
        .container {
            display: flex;
            justify-content: space-between;
        }

        .form-column {
            width: 48%;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }

        .form-column h4 {
            margin-top: 0;
            font-size: 18px;
            color: #333333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .form-column input[type="text"],
        .form-column input[type="date"],
        .form-column select {
            width: calc(100% - 16px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }

        .form-column input[type="text"]:focus,
        .form-column input[type="date"]:focus,
        .form-column select:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .form-column button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .form-column button:hover {
            background-color: #45a049;
        }

        @media screen and (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .form-column {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>

    <table style="width:100%; margin-top: -30px;">
        <tr>
            <td style="width:50%;">
                <h4>Alamat KTP</h4>
                <table>
                    <tr>
                        <td>Alamat:</td>
                        <td><input type="text" id="alamat" name="alamat_ktp" required></td>
                    </tr>
                    <tr>
                        <td>RT / RW:</td>
                        <td>
                            <input type="text" name="rt" style="width: 40px;" required> /
                            <input type="text" name="rw" style="width: 40px;" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Kelurahan:</td>
                        <td><input type="text" id="kelurahan" name="kelurahan" required></td>
                    </tr>
                </table>
            </td>
            <td style="width:50%; padding-top: 50px;">
                <table>
                    <tr>
                        <td>Kecamatan:</td>
                        <td><input type="text" id="kecamatan" name="kecamatan" required></td>
                    </tr>
                    <tr>
                        <td>Kabupaten:</td>
                        <td><input type="text" id="kota" name="kota" required></td>
                    </tr>
        </tr>
        <tr>
            <td>Provinsi:</td>
            <td><input type="text" id="provinsi" name="provinsi" required></td>
        </tr>
        </tr>
        <td>Kode Pos:</td>
        <td><input type="text" id="kode_pos" name="kode_pos" style="width: 80px;" required></td>
        </tr>
    </table>
    </td>
    </tr>
    </table>
    <script>
        // Validasi form
        function validateForm() {
            var rt = document.getElementsByName('rt')[0].value;
            var rw = document.getElementsByName('rw')[0].value;
            var kode_pos = document.getElementById('kode_pos').value;

            // Validasi RT dan RW harus berupa angka
            var regex = /^\d+$/;

            if (!regex.test(rt)) {
                alert('RT harus berupa angka.');
                return false;
            }

            if (!regex.test(rw)) {
                alert('RW harus berupa angka.');
                return false;
            }

            // Validasi kode pos harus berupa angka dan 5 digit
            var regexKodePos = /^\d{5}$/;

            if (!regexKodePos.test(kode_pos)) {
                alert('Kode Pos harus berupa angka dan 5 digit.');
                return false;
            }

            // Lanjutkan dengan pengiriman formulir
            return true;
        }
    </script>

    <!-- ALAMAT SEKARANG -->
    <table style="width: 100%; margin-top: -30px;">
        <tr>
            <td style="width: 200px;">
                <h4>Alamat Sekarang </h4>
                <input type="radio" id="sesuaiKtp" name="alamat_domisili" value="Sesuai KTP" required>
                <label for="sesuaiKtp">Sesuai KTP</label>

                <input type="radio" id="tidakSesuaiKtp" name="alamat_domisili" value="Tidak Sesuai KTP" required>
                <label for="tidakSesuaiKtp">Tidak Sesuai KTP</label>
            </td>
        </tr>
        <tr class="hidden-row-alamatKtp" id="data-ktp">
            <td colspan="2">
                <textarea id="alamatTextarea" name="alamat_domisili" style="width: 100%; height: 100px;"></textarea>
            </td>
        </tr>
    </table>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tidakSesuaiKtpRadio = document.getElementById('tidakSesuaiKtp');
            const alamatTextarea = document.getElementById('alamatTextarea');
            const dataKtpRow = document.getElementById('data-ktp');

            tidakSesuaiKtpRadio.addEventListener('change', function() {
                if (this.checked) {
                    dataKtpRow.style.display = 'table-row';
                    alamatTextarea.setAttribute('required', 'required');
                }
            });

            document.getElementById('sesuaiKtp').addEventListener('change', function() {
                dataKtpRow.style.display = 'none';
                alamatTextarea.removeAttribute('required');
            });
        });
    </script>
    <style>
        .hidden-row-alamatKtp {
            display: none;
        }
    </style>


    <!-- Tabel untuk kontak darurat dalam 1 -->
    <table style="width:100%; margin-top: -30px;">
        <tr>
            <td style="width:50%">
                <h4>Kontak Darurat (Tidak tinggal serumah)</h4>
                <table>
                    <tr>
                        <td width="100">Nama:</td>
                        <td><input type="text" name="nama_kd" required></td>
                    </tr>
                    <tr>
                        <td>No. Telepon:</td>
                        <td><input type="text" name="no_tlpn_kd" required></td>
                    </tr>
                </table>
            </td>
            <td style="width:50%; padding-top:50px;">
                <table>
                    <tr>
                        <td>Hubungan:</td>
                        <td><input type="text" name="hubungan_kd" required></td>
                    </tr>
                    <tr>
                        <td>Alamat:</td>
                        <td><input type="text" name="alamat_kd" required></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Status Pribadi -->
    <table style="width:60%; margin-top: -30px;">
        <tr>
            <td>Status Pribadi Anda:</td>
            <td>
                <input type="radio" id="status_bujangan" name="status" value="bujangan" required>
                <label for="status_bujangan">Bujangan</label>

                <input type="radio" id="status_nikah" name="status" value="nikah" required>
                <label for="status_nikah">Nikah</label>

                <input type="radio" id="status_cerai" name="status" value="cerai" required>
                <label for="status_cerai">Cerai</label>
            </td>
        </tr>
        <script>
            function validateForm() {
                // Cek apakah salah satu radio button "Status Pribadi Anda" telah dipilih
                var bujanganRadio = document.getElementById("status_bujangan");
                var nikahRadio = document.getElementById("status_nikah");
                var ceraiRadio = document.getElementById("status_cerai");

                // Jika tidak ada yang dipilih, tampilkan pesan kesalahan
                if (!bujanganRadio.checked && !nikahRadio.checked && !ceraiRadio.checked) {
                    alert("Anda harus memilih status pribadi Anda.");
                    return false; // Form tidak akan dikirim
                }

                // Lanjutkan pengiriman formulir jika validasi berhasil
                return true;
            }
        </script>

        <script>
            // Function to show or hide the family status table based on personal status selection
            function toggleFamilyStatusTable() {
                const status = document.querySelector('input[name="status"]:checked').value;
                const familyStatusTable = document.getElementById('formTable');
                const familyTableSub = document.getElementById('formTableSub');

                // Show or hide the family status table based on personal status selection
                if (status === 'nikah' || status === 'cerai') {
                    familyStatusTable.style.display = 'table';
                    familyTableSub.style.display = 'block';
                } else {
                    familyStatusTable.style.display = 'none';
                    familyTableSub.style.display = 'none';
                }
            }

            // Add event listener to the radio buttons
            const radioButtons = document.querySelectorAll('input[name="status"]');
            radioButtons.forEach(button => {
                button.addEventListener('change', toggleFamilyStatusTable);
            });

            function validateForm() {
                // Get the value of the selected status
                const status = document.querySelector('input[name="status"]:checked').value;

                // If the selected status is 'nikah' or 'cerai', check if the family table is filled
                if (status === 'nikah' || status === 'cerai') {
                    const familyTableRows = document.querySelectorAll('#familyTable tr');
                    // If there are no rows in the family table, display an error message
                    if (familyTableRows.length <= 1) {
                        alert('Mohon isi susunan keluarga.');
                        return false; // Prevent form submission
                    }
                }

                // If the form is valid, allow submission
                return true;
            }
        </script>

    </table>

    <!-- DATA KELUARGA -->
    <h3 style="width:100%; margin-top: 10px;">II. DATA KELUARGA</h3>
    <table class="form-table" id="formTable" style="margin-top: -30px;">
        <h4 class="form-table" id="formTableSub" style="margin-left: 20px; margin-top: -20px;">
            Susunan Keluarga (Suami/Istri/Anak)
        </h4>
        <thead>
            <tr>
                <th style="width: 110px;">Status Keluarga<button type="button" id="addRowButton" onclick="showModal()" style="margin-left: 10px;">+</button></th>
                <th>Nama</th>
                <th style="width: 110px;">Jenis Kelamin</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Pekerjaan</th>
            </tr>
        </thead>
        <tbody id="familyTable">
            <!-- Baris data anggota keluarga akan ditambahkan di sini -->
        </tbody>

        <!-- style modal -->
        <style>
            /* CSS untuk modal */
            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgb(0, 0, 0);
                background-color: rgba(0, 0, 0, 0.4);
                padding-top: 60px;
            }

            .modal-content {
                background-color: #fefefe;
                margin: 5% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 20%;
                height: 30%;
            }

            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
        </style>


        <!-- Modal -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <h2 style="margin-top: -3px;">Pilih Status Keluarga</h2>
                <select id="statusKeluargaSelect">
                    <option value="Suami">Suami</option>
                    <option value="Istri">Istri</option>
                    <option value="Anak ke-1">Anak ke-1</option>
                    <option value="Anak ke-2">Anak ke-2</option>
                    <option value="Anak ke-3">Anak ke-3</option>
                    <option value="Anak ke-4">Anak ke-4</option>
                    <option value="Anak ke-5">Anak ke-5</option>
                </select>
                <button type="button" onclick="addRow()">Tambah</button>
            </div>
        </div>

        <script>
            // JavaScript untuk membuka dan menutup modal
            function showModal() {
                document.getElementById('myModal').style.display = 'block';
            }

            function closeModal() {
                document.getElementById('myModal').style.display = 'none';
            }

            // JavaScript untuk menambahkan baris baru ke tabel berdasarkan pilihan
            function addRow() {
                const table = document.getElementById('familyTable');
                const select = document.getElementById('statusKeluargaSelect');
                const statusKeluarga = select.value;

                let rowHtml = '';
                switch (statusKeluarga) {
                    case 'Suami':
                        rowHtml = `
                            <tr>
                                <td><input type="text" value="Suami" name="suami" readonly></td>
                                <td><input type="text" name="nama_suami" required></td>
                                <td><input type="text" value="Laki-laki" name="jk_suami" readonly></td>
                                <td><input type="text" name="tempat_lahir_suami" required></td>
                                <td><input type="date" name="tanggal_lahir_suami" required></td>
                                <td><input type="text" name="pekerjaan_suami" required></td>
                            </tr>
                        `;
                        break;
                    case 'Istri':
                        rowHtml = `
                            <tr>
                                <td><input type="text" value="Istri" name="istri" readonly></td>
                                <td><input type="text" name="nama_istri" required></td>
                                <td><input type="text" value="Perempuan" name="jk_istri" readonly></td>
                                <td><input type="text" name="tempat_lahir_istri" required></td>
                                <td><input type="date" name="tanggal_lahir_istri" required></td>
                                <td><input type="text" name="pekerjaan_istri" required></td>
                            </tr>
                        `;
                        break;
                    case 'Anak ke-1':
                        rowHtml = `
                            <tr>
                                <td><input type="text" value="Anak ke-1" name="anak_1" readonly></td>
                                <td><input type="text" name="nama_anak_1"></td>
                                <td>
                                    <select name="jk_anak_1">
                                        <option value="">Pilih...</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </td>
                                <td><input type="text" name="tempat_lahir_anak_1"></td>
                                <td><input type="date" name="tanggal_lahir_anak_1"></td>
                                <td><input type="text" name="pekerjaan_anak_1"></td>
                            </tr>
                        `;
                        break;
                    case 'Anak ke-2':
                        rowHtml = `
                            <tr>
                                <td><input type="text" value="Anak ke-2" name="anak_2" readonly></td>
                                <td><input type="text" name="nama_anak_2"></td>
                                <td>
                                    <select name="jk_anak_2">
                                        <option value="">Pilih...</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </td>
                                <td><input type="text" name="tempat_lahir_anak_2"></td>
                                <td><input type="date" name="tanggal_lahir_anak_2"></td>
                                <td><input type="text" name="pekerjaan_anak_2"></td>
                            </tr>
                        `;
                        break;
                    case 'Anak ke-3':
                        rowHtml = `
                            <tr>
                                <td><input type="text" value="Anak ke-3" name="anak_3" readonly></td>
                                <td><input type="text" name="nama_anak_3"></td>
                                <td>
                                    <select name="jk_anak_3">
                                        <option value="">Pilih...</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </td>
                                <td><input type="text" name="tempat_lahir_anak_3"></td>
                                <td><input type="date" name="tanggal_lahir_anak_3"></td>
                                <td><input type="text" name="pekerjaan_anak_3"></td>
                            </tr>
                        `;
                        break;
                    case 'Anak ke-4':
                        rowHtml = `
                            <tr>
                                <td><input type="text" value="Anak ke-4" name="anak_4" readonly></td>
                                <td><input type="text" name="nama_anak_4"></td>
                                <td>
                                    <select name="jk_anak_4">
                                        <option value="">Pilih...</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </td>
                                <td><input type="text" name="tempat_lahir_anak_4"></td>
                                <td><input type="date" name="tanggal_lahir_anak_3"></td>
                                <td><input type="text" name="pekerjaan_anak_4"></td>
                            </tr>
                        `;
                        break;
                    case 'Anak ke-5':
                        rowHtml = `
                                    <tr>
                                        <td><input type="text" value="Anak ke-5" name="anak_5" readonly></td>
                                        <td><input type="text" name="nama_anak_5"></td>
                                        <td>
                                            <select name="jk_anak_5">
                                                <option value="">Pilih...</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="tempat_lahir_anak_5"></td>
                                        <td><input type="date" name="tanggal_lahir_anak_5"></td>
                                        <td><input type="text" name="pekerjaan_anak_5"></td>
                                    </tr>
                                `;
                        break;
                }

                table.insertAdjacentHTML('beforeend', rowHtml);

                // Disable the selected option
                select.querySelector(`option[value="${statusKeluarga}"]`).disabled = true;

                closeModal();
            }

            // Menambahkan event listener pada window untuk menutup modal jika pengguna mengklik di luar modal
            window.onclick = function(event) {
                const modal = document.getElementById('myModal');
                if (event.target === modal) {
                    closeModal();
                }
            }
        </script>
        </tbody>
    </table>
    <br>

    <!-- Tabel untuk ayah/ibu -->
    <h4 style="margin-top: -20px;">Susunan Keluarga (Ayah/Ibu/Saudara kandung)</h4>
    <table class="form-table" id="formTableFamily" style="margin-top: -30px;">
        <thead>
            <tr>
                <th style="width: 110px;">Status Keluarga<button type="button" id="addRowOt" onclick="showModalOrtu()" style="margin-left: 10px;">+</button></th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Pekerjaan</th>
            </tr>
        </thead>
        <tbody id="familyTableOrtu">
        </tbody>
        <style>
            .modal-ortu {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgb(0, 0, 0);
                background-color: rgba(0, 0, 0, 0.4);
                padding-top: 60px;
            }

            .modal-content-ortu {
                background-color: #fefefe;
                margin: 5% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 20%;
                height: 30%;
            }

            .close-ortu {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close-ortu:hover,
            .close-ortu:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
        </style>

        <!-- Modal -->
        <div id="myModalOrtu" class="modal-ortu">
            <div class="modal-content-ortu">
                <span class="close-ortu" onclick="closeModalOrtu()">&times;</span>
                <h2 style="margin-top: -3px;">Pilih Status Keluarga</h2>
                <select id="statusKeluargaOrtuSelect">
                    <option value="Ayah">Ayah</option>
                    <option value="Ibu">Ibu</option>
                    <option value="Anak ke-1">Anak ke-1</option>
                    <option value="Anak ke-2">Anak ke-2</option>
                    <option value="Anak ke-3">Anak ke-3</option>
                    <option value="Anak ke-4">Anak ke-4</option>
                    <option value="Anak ke-5">Anak ke-5</option>
                </select>
                <button type="button" onclick="addRowOrtu()">Tambah</button>
            </div>
        </div>


        <script>
            // JavaScript untuk membuka dan menutup modal
            function showModalOrtu() {
                document.getElementById('myModalOrtu').style.display = 'block';
            }

            function closeModalOrtu() {
                document.getElementById('myModalOrtu').style.display = 'none';
            }

            // JavaScript untuk menambahkan baris baru ke tabel berdasarkan pilihan
            function addRowOrtu() {
                const table = document.getElementById('familyTableOrtu');
                const select = document.getElementById('statusKeluargaOrtuSelect');
                const statusOrtu = select.value;

                // Check if the status already exists in the table
                const existingRows = Array.from(table.querySelectorAll('tr'));
                for (const row of existingRows) {
                    const statusCell = row.querySelector('input[name="status_keluarga_sub"]');
                    if (statusCell && statusCell.value === statusOrtu) {
                        alert(`${statusOrtu} sudah ada di dalam tabel.`);
                        closeModalOrtu();
                        return;
                    }
                }

                let rowHtml = '';
                switch (statusOrtu) {
                    case 'Ayah':
                        rowHtml = `
                    <tr>
                        <td><input type="text" name="status_keluarga_sub" value="Ayah" readonly></td>
                        <td><input type="text" name="nama_ayah" required></td>
                        <td><input type="text" name="jk_ayah" value="Laki-laki" readonly></td>
                        <td><input type="text" name="tempat_lahir_ayah" required></td>
                        <td><input type="date" name="tanggal_lahir_ayah" required></td>
                        <td><input type="text" name="pekerjaan_ayah" required></td>
                    </tr>
                `;
                        break;
                    case 'Ibu':
                        rowHtml = `
                    <tr>
                        <td><input type="text" name="status_keluarga_sub" value="Ibu" readonly></td>
                        <td><input type="text" name="nama_ibu" required></td>
                        <td><input type="text" name="jk_ibu" value="Perempuan" readonly></td>
                        <td><input type="text" name="tempat_lahir_ibu" required></td>
                        <td><input type="date" name="tanggal_lahir_ibu" required></td>
                        <td><input type="text" name="pekerjaan_ibu" required></td>
                    </tr>
                `;
                        break;
                    case 'Anak ke-1':
                        rowHtml = `
                    <tr>
                        <td><input type="text" value="Anak pertama" name="anak_1" readonly></td>
                        <td><input type="text" name="nama_pertama" required></td>
                        <td>
                            <select name="jk_pertama" required>
                                <option value="">Pilih...</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </td>
                        <td><input type="text" name="tempat_lahir_pertama" required></td>
                        <td><input type="date" name="tanggal_lahir_pertama" required></td>
                        <td><input type="text" name="pekerjaan_pertama" required></td>
                    </tr>
                `;
                        break;
                    case 'Anak ke-2':
                        rowHtml = `
                    <tr>
                        <td><input type="text" value="Anak kedua" name="kedua" readonly></td>
                        <td><input type="text" name="nama_kedua" required></td>
                        <td>
                            <select name="jk_kedua" required>
                                <option value="">Pilih...</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </td>
                        <td><input type="text" name="tempat_lahir_kedua" required></td>
                        <td><input type="date" name="tanggal_lahir_kedua" required></td>
                        <td><input type="text" name="pekerjaan_kedua" required></td>
                    </tr>
                `;
                        break;
                    case 'Anak ke-3':
                        rowHtml = `
                    <tr>
                        <td><input type="text" value="Anak ketiga" name="ketiga" readonly></td>
                        <td><input type="text" name="nama_ketiga" required></td>
                        <td>
                            <select name="jk_ketiga" required>
                                <option value="">Pilih...</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </td>
                        <td><input type="text" name="tempat_lahir_ketiga" required></td>
                        <td><input type="date" name="tanggal_lahir_ketiga" required></td>
                        <td><input type="text" name="pekerjaan_ketiga" required></td>
                    </tr>
                `;
                        break;
                    case 'Anak ke-4':
                        rowHtml = `
                    <tr>
                        <td><input type="text" value="Anak keempat" name="keempat" readonly></td>
                        <td><input type="text" name="nama_keempat" required></td>
                        <td>
                            <select name="jk_keempat" required>
                                <option value="">Pilih...</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </td>
                        <td><input type="text" name="tempat_lahir_keempat" required></td>
                        <td><input type="date" name="tanggal_lahir_keempat" required></td>
                        <td><input type="text" name="pekerjaan_keempat" required></td>
                    </tr>
                `;
                        break;
                    case 'Anak ke-5':
                        rowHtml = `
                            <tr>
                                <td><input type="text" value="Anak kelima" name="kelima" readonly></td>
                                <td><input type="text" name="nama_kelima" required></td>
                                <td>
                                    <select name="jk_kelima" required>
                                        <option value="">Pilih...</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </td>
                                <td><input type="text" name="tempat_lahir_kelima" required></td>
                                <td><input type="date" name="tanggal_lahir_kelima" required></td>
                                <td><input type="text" name="pekerjaan_kelima" required></td>
                            </tr>
                        `;
                        break;
                }

                table.insertAdjacentHTML('beforeend', rowHtml);

                // Disable the selected option
                select.querySelector(`option[value="${statusOrtu}"]`).disabled = true;

                // Check if all options are disabled
                const allOptionsDisabled = Array.from(select.options).every(option => option.disabled);
                if (allOptionsDisabled) {
                    alert("Maksimal susunan keluarga ayah/ibu/saudara tercapai.");
                    document.getElementById('addRowOt').disabled = true; // Disable the add button
                }

                closeModalOrtu();
            }

            // Menambahkan event listener pada window untuk menutup modal jika pengguna mengklik di luar modal
            window.onclick = function(event) {
                const modal = document.getElementById('myModalOrtu');
                if (event.target === modal) {
                    closeModalOrtu();
                }
            }
        </script>


        </tbody>
    </table>
    <br>

    <!-- Tabel Untuk Riwayat Pendidikan -->
    <h3 style="margin-left: -20px; margin-top: 10px;">III. Riwayat Pendidikan</h3>
    <table class="form-table" id="formTablePendidikan" style="margin-top: -30px;">
        <thead>
            <tr>
                <th style="width: 125px;">Jenjang Pendidikan <button type="button" id="addRowPend" onclick="showModalPendidikan()" style="margin-left: 10px;">+</button></th>
                <th>Nama Institusi</th>
                <th>Fakultas/Jurusan</th>
                <th style="width: 175px;">Periode Tahun</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <style>
            .modal-pendidikan {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgb(0, 0, 0);
                background-color: rgba(0, 0, 0, 0.4);
                padding-top: 60px;
            }

            .modal-content-pendidikan {
                background-color: #fefefe;
                margin: 5% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 20%;
                height: 30%;
            }

            .close-pendidikan {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close-pendidikan:hover,
            .close-pendidikan:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
        </style>

        <tbody id="familyTablePendidikan">
            <!-- isi form data riwayat pendidikan -->

            <!-- Modal -->
            <div id="myModalPendidikan" class="modal-pendidikan">
                <div class="modal-content-pendidikan">
                    <span class="close-pendidikan" onclick="closeModalPendidikan()">&times;</span>
                    <h2 style="margin-top: -3px;">Pilih Riwayat Pendidikan</h2>
                    <select id="statusKeluargaPendidikanSelect">
                        <option value="Strata 3">Strata 3</option>
                        <option value="Strata 2">Strata 2</option>
                        <option value="Strata 1">Strata 1</option>
                        <option value="Diploma 1/2/3">Diploma 1/2/3</option>
                        <option value="SMA">SMA</option>
                        <option value="SMP">SMP</option>
                        <option value="SD">SD</option>
                    </select>
                    <button type="button" onclick="addRowPendidikan()">Tambah</button>
                </div>
            </div>

            <script>
                // JavaScript untuk membuka dan menutup modal
                function showModalPendidikan() {
                    document.getElementById('myModalPendidikan').style.display = 'block';
                }

                function closeModalPendidikan() {
                    document.getElementById('myModalPendidikan').style.display = 'none';
                }

                // JavaScript untuk menambahkan baris baru ke tabel berdasarkan pilihan
                function addRowPendidikan() {
                    const table = document.getElementById('familyTablePendidikan');
                    const select = document.getElementById('statusKeluargaPendidikanSelect');
                    const statusPendidikan = select.value;

                    let rowHtml = '';
                    switch (statusPendidikan) {
                        case 'Strata 3':
                            rowHtml = `
                        <tr>
                          <td>
                            <input type="text" id="jenjang_s3" value="Strata 3">
                          </td>
                          <td><input type="text" id="nama_institusi_s3" name="nama_institusi_s3" required></td>
                          <td><input type="text" id="nama_fakultas_s3" name="nama_fakultas_s3" required></td>
                          <td>
                            <select id="tahun_awal_s3" name="tahun_awal_s3" style="width: 70px;" required>
                              <option value="">Dari</option>
                              <?php
                                for ($i = 1970; $i <= 2024; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                            <span style="font-size: 20px;"> - </span>
                            <select id="tahun_akhir_s3" name="tahun_akhir_s3" style="width: 85px;" required>
                              <option value="">Sampai</option>
                              <?php
                                for ($i = 1970; $i <= 2024; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                          </td>
                          <td><input type="text" id="keterangan_s3" name="keterangan_s3" required></td>
                        </tr>
                    `;
                            break;
                        case 'Strata 2':
                            rowHtml = `
                        <tr>
                          <td>
                            <input type="text" id="jenjang_s2" value="Strata 2">
                          </td>
                          <td><input type="text" id="nama_institusi_s2" name="nama_institusi_s2" required></td>
                          <td><input type="text" id="nama_fakultas_s2" name="nama_fakultas_s2" required></td>
                          <td>
                            <select id="tahun_awal_s2" name="tahun_awal_s2" style="width: 70px;" required>
                              <option value="">Dari</option>
                              <?php
                                for ($i = 1970; $i <= 2024; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                            <span style="font-size: 20px;"> - </span>
                            <select id="tahun_akhir_s2" name="tahun_akhir_s2" style="width: 85px;" required>
                              <option value="">Sampai</option>
                              <?php
                                for ($i = 1970; $i <= 2024; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                          </td>
                          <td><input type="text" id="keterangan_s2" name="keterangan_s2" required></td>
                        </tr>
                    `;
                            break;
                        case 'Strata 1':
                            rowHtml = `
                        <tr>
                          <td>
                            <input type="text" id="jenjang_s1" value="Strata 1">
                          </td>
                          <td><input type="text" id="nama_institusi_s1" name="nama_institusi_s1" required></td>
                          <td><input type="text" id="nama_fakultas_s1" name="nama_fakultas_s1" required></td>
                          <td>
                            <select id="tahun_awal_s1" name="tahun_awal_s1" style="width: 70px;" required>
                              <option value="">Dari</option>
                              <?php
                                for ($i = 1970; $i <= 2024; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                            <span style="font-size: 20px;"> - </span>
                            <select id="tahun_akhir_s1" name="tahun_akhir_s1" style="width: 85px;" required>
                              <option value="">Sampai</option>
                              <?php
                                for ($i = 1970; $i <= 2024; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                          </td>
                          <td><input type="text" id="keterangan_s1" name="keterangan_s1" required></td>
                        </tr>
                    `;
                            break;
                        case 'Diploma 1/2/3':
                            rowHtml = `
                        <tr>
                          <td>
                            <input type="text" id="jenjang_diploma" value="Diploma 1/2/3">
                          </td>
                          <td><input type="text" id="nama_institusi_diploma" name="nama_institusi_diploma" required></td>
                          <td><input type="text" id="nama_fakultas_diploma" name="nama_fakultas_diploma" required></td>
                          <td>
                            <select id="tahun_awal_diploma" name="tahun_awal_diploma" style="width: 70px;" required>
                              <option value="">Dari</option>
                              <?php
                                for ($i = 1970; $i <= 2024; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                            <span style="font-size: 20px;"> - </span>
                            <select id="tahun_akhir_diploma" name="tahun_akhir_diploma" style="width: 85px;" required>
                              <option value="">Sampai</option>
                              <?php
                                for ($i = 1970; $i <= 2024; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                          </td>
                          <td><input type="text" id="keterangan_diploma" name="keterangan_diploma" required></td>
                        </tr>
                    `;
                            break;
                        case 'SMA':
                            rowHtml = `
                            <tr>
                              <td>
                                <input type="text" id="jenjang_sma" value="SMA">
                              </td>
                              <td><input type="text" id="nama_institusi_sma" name="nama_institusi_sma" required></td>
                              <td><input type="text" id="nama_fakultas_sma" name="nama_fakultas_sma" required></td>
                              <td>
                                <select id="tahun_awal_sma" name="tahun_awal_sma" style="width: 70px;" required>
                                  <option value="">Dari</option>
                                  <?php
                                    for ($i = 1970; $i <= 2024; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                                <span style="font-size: 20px;"> - </span>
                                <select id="tahun_akhir_sma" name="tahun_akhir_sma" style="width: 85px;" required>
                                  <option value="">Sampai</option>
                                  <?php
                                    for ($i = 1970; $i <= 2024; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                              </td>
                              <td><input type="text" id="keterangan_sma" name="keterangan_sma" required></td>
                            </tr>
                    `;
                            break;
                        case 'SMP':
                            rowHtml = `
                            <tr>
                              <td>
                                <input type="text" id="jenjang_smp" value="SMP">
                              </td>
                              <td><input type="text" id="nama_institusi_smp" name="nama_institusi_smp" required></td>
                              <td></td>
                              <td>
                                <select id="tahun_awal_smp" name="tahun_awal_smp" style="width: 70px;" required>
                                  <option value="">Dari</option>
                                  <?php
                                    for ($i = 1970; $i <= 2024; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                                <span style="font-size: 20px;"> - </span>
                                <select id="tahun_akhir_smp" name="tahun_akhir_smp" style="width: 85px;" required>
                                  <option value="">Sampai</option>
                                  <?php
                                    for ($i = 1970; $i <= 2024; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                              </td>
                              <td><input type="text" id="keterangan_smp" name="keterangan_smp" required></td>
                            </tr>
                    `;
                            break;
                        case 'SD':
                            rowHtml = `
                            <tr>
                              <td>
                                <input type="text" id="jenjang_sd" value="SD">
                              </td>
                              <td><input type="text" id="nama_institusi_sd" name="nama_institusi_sd" required></td>
                              <td></td>
                              <td>
                                <select id="tahun_awal_sd" name="tahun_awal_sd" style="width: 70px;" required>
                                  <option value="">Dari</option>
                                  <!-- Isi dengan opsi tahun yang diinginkan -->
                                  <?php
                                    for ($i = 1970; $i <= 2024; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                                <span style="font-size: 20px;"> - </span>
                                <select id="tahun_akhir_sd" name="tahun_akhir_sd" style="width: 85px;" required>
                                  <option value="">Sampai</option>
                                  <!-- Isi dengan opsi tahun yang diinginkan -->
                                  <?php
                                    for ($i = 1970; $i <= 2024; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                              </td>
                              <td><input type="text" id="keterangan_sd" name="keterangan_sd" required></td>
                            </tr>
                    `;
                            break;
                    }

                    table.insertAdjacentHTML('beforeend', rowHtml);

                    // Disable the selected option
                    select.querySelector(`option[value="${statusPendidikan}"]`).disabled = true;

                    closeModalPendidikan();
                }

                // Menambahkan event listener pada window untuk menutup modal jika pengguna mengklik di luar modal
                window.onclick = function(event) {
                    const modal = document.getElementById('myModalPendidikan');
                    if (event.target === modal) {
                        closeModalPendidikan();
                    }
                }
            </script>
        </tbody>
    </table>

    <br>
    <!-- Tabel untuk beasiswa -->
    <h4 style="margin-top: -20px;">Beasiswa/Piagam/Penghargaan</h4>
    <table style="width:100%; margin-top: -30px;">
        <tr>
            <td>Sebutkan beasiswa yang pernah Anda peroleh, kapan, dan bagaimana kriteria penilaiannya?</td>
        </tr>
    </table>
    <textarea name="beasiswa" style="width:100%; height: 100px; margin-top: -40px;" required></textarea>

    <!-- Tabel untuk piagam -->
    <table style="width:100%">
        <tr>
            <td>Sebutkan piagam / penghargaan yang pernah Anda peroleh, kapan, dan bagaimana kriteria penilaiannya?</td>
        </tr>
    </table>
    <textarea name="penghargaan" style="width:100%; height: 100px; margin-top: -40px;" required></textarea>

    <!-- Tabel untuk pelatihan -->
    <style>
        .hidden-header {
            display: none;
        }

        .hidden-row {
            display: none;
        }
    </style>
    <h4 style="margin-left: 25px; margin-top: 0px;">Kursus/Pelatihan yang pernah diikuti (yang bersertifikat)</h4>
    <table class="form-table" id="formTablePelatihan" style="margin-top: -30px;">
        <thead>
            <tr>
                <th>Kursus Pelatihan <button type="button" id="addButtonPelatihan" onclick="addRowPelatihan()" style="margin-left: 10px;">+</button></th>
                <th>Nama institusi</th>
                <th>Lama kursus / pelatihan</th>
            </tr>
        </thead>
        <tbody id="istriSuami">
            <!-- Baris akan ditambahkan oleh JavaScript -->
        </tbody>
    </table>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.getElementById('istriSuami');
            const addButtonPelatihan = document.getElementById('addButtonPelatihan');

            // Function to add a new row
            const addRowPelatihan = () => {
                const rowCount = tableBody.getElementsByTagName('tr').length + 1;
                if (rowCount <= 3) { // Max 3 rows
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                    <td><input type="text" id="kursus_pelatihan_${rowCount}" name="kursus_pelatihan_${rowCount}" required></td>
                    <td><input type="text" id="nama_institusi_${rowCount}" name="nama_institusi_${rowCount}" required></td>
                    <td><input type="text" id="lama_pelatihan_${rowCount}" name="lama_pelatihan_${rowCount}" required></td>
                `;
                    tableBody.appendChild(newRow);
                    if (rowCount === 3) {
                        addButtonPelatihan.style.display = 'none'; // Hide the button when adding the third row
                    }
                }
            };

            addButtonPelatihan.addEventListener('click', addRowPelatihan);
        });
    </script>



    <!-- Tabel untuk Kemampuan Bahasa -->
    <h3 style="margin-top: 10px;">IV. Kemampuan Bahasa</h3>
    <table class="form-table" id="formTableBahasa" style="margin-top: -30px;">
        <thead>
            <tr>
                <th style="width: 33%;">BAHASA <button type="button" id="addButtonBahasa" onclick="addRowBahasa()" style="margin-left: 10px;">+</button></th>
                <th>LISAN</th>
                <th>TULISAN</th>
            </tr>
        </thead>
        <tbody id="bahasa">
            <!-- Baris akan ditambahkan oleh JavaScript -->
        </tbody>
    </table>
    <style>
        .hidden-row {
            display: none;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tableBodyBahasa = document.getElementById('bahasa');
            const addButtonBahasa = document.getElementById('addButtonBahasa');

            const addRowBahasa = () => {
                const rowCount = tableBodyBahasa.getElementsByTagName('tr').length + 1;
                const row = document.createElement('tr');

                row.innerHTML = `
                <td><input type="text" id="bahasa_${rowCount}" name="bahasa_${rowCount}" required></td>
                <td>
                    <select name="lisan_${rowCount}" required>
                        <option value="">Pilih...</option>
                        <option value="Sangat Baik">Sangat Baik</option>
                        <option value="Baik">Baik</option>
                        <option value="Cukup">Cukup</option>
                        <option value="Kurang">Kurang</option>
                    </select>
                </td>
                <td>
                    <select name="tulisan_${rowCount}" required>
                        <option value="">Pilih...</option>
                        <option value="Sangat Baik">Sangat Baik</option>
                        <option value="Baik">Baik</option>
                        <option value="Cukup">Cukup</option>
                        <option value="Kurang">Kurang</option>
                    </select>
                </td>
            `;

                tableBodyBahasa.appendChild(row);

                // Check the number of rows and hide the button if there are 3 or more rows
                if (tableBodyBahasa.getElementsByTagName('tr').length >= 3) {
                    addButtonBahasa.style.display = 'none';
                }
            };

            window.addRowBahasa = addRowBahasa;
        });
    </script>

    <!-- Tabel untuk Riwayat Pekerjaan -->
    <h3 style="margin-top: 10px;">V. Riwayat Pekerjaan</h3>
    <table class="form-table" id="formTablePekerjaan" style="margin-top: -30px;">
        <thead>
            <tr>
                <th style="width: 175px;">Periode Tahun<button type="button" id="addButtonPekerjaan" onclick="addRowPekerjaan()" style="margin-left: 10px;">+</button></th>
                <th>Nama / Alamat Perusahaan</th>
                <th>Jabatan</th>
                <th>Gaji Tunjangan</th>
                <th>Alasan Keluar / Pindah kerja</th>
            </tr>
        </thead>
        <tbody id="pekerjaan">
            <!-- Baris akan ditambahkan oleh JavaScript -->
        </tbody>
    </table>
    <style>
        .hidden-row {
            display: none;
        }
    </style>
    <script>
        // Function to format number to Indonesian Rupiah
        function formatRupiah(angka, prefix) {
            var numberString = angka.replace(/[^,\d]/g, "").toString(),
                split = numberString.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp " + rupiah : "";
        }

        // Function to add event listener to an input field
        function addCurrencyFormattingListener(input) {
            input.addEventListener('blur', function() {
                input.value = formatRupiah(input.value, 'Rp');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const tableBodyPekerjaan = document.getElementById('pekerjaan');
            const addButtonPekerjaan = document.getElementById('addButtonPekerjaan');

            const addRowPekerjaan = () => {
                const rowCount = tableBodyPekerjaan.getElementsByTagName('tr').length + 1;
                if (rowCount <= 7) { // Check if row count is 7 or less
                    const row = document.createElement('tr');

                    row.innerHTML = `
                    <td>
                        <select id="tahun_awal_${rowCount}" name="tahun_awal_${rowCount}" style="width: 70px;" required>
                            <option value="">Dari</option>
                            <?php
                            for ($i = 1970; $i <= 2024; $i++) {
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                        <span style="font-size: 20px;"> - </span>
                        <select id="tahun_akhir_${rowCount}" name="tahun_akhir_${rowCount}" style="width: 85px;" required>
                            <option value="">Sampai</option>
                            <?php
                            for ($i = 1970; $i <= 2024; $i++) {
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="text" id="nama_perusahaan_${rowCount}" name="nama_perusahaan_${rowCount}" required></td>
                    <td><input type="text" id="jabatan_${rowCount}" name="jabatan_${rowCount}" required></td>
                    <td><input type="text" id="gaji_${rowCount}" name="gaji_${rowCount}" placeholder="1000000" required></td>
                    <td><input type="text" id="alasan_keluar_${rowCount}" name="alasan_keluar_${rowCount}" required></td>
                `;

                    tableBodyPekerjaan.appendChild(row);

                    // Add currency formatting listener to the new gaji input field
                    addCurrencyFormattingListener(document.getElementById(`gaji_${rowCount}`));

                    if (rowCount === 7) {
                        addButtonPekerjaan.style.display = 'none'; // Hide the button when 7 rows are added
                    }
                }
            };

            window.addRowPekerjaan = addRowPekerjaan;
        });
    </script>

    <!-- LAIN_LAIN -->
    <h3 style="margin-top: 10px;">VI. LAIN - LAIN</h3>

    <!-- soal 1 -->
    <table style="width: 100%; margin-top: -30px;">
        <tr>
            <td>Adakah keluarga atau kenalan anda yang bekerja di Jababeka Group?</td>
            <td style="width: 200px;">
                <input type="radio" id="ada" name="saudara_kerja" value="ada" required>
                <label for="ada">Ada</label>

                <input type="radio" id="tidak_ada" name="saudara_kerja" value="tidak ada" required>
                <label for="tidak_ada">Tidak ada</label>
            </td>
        </tr>
        <tr class="hidden-row" id="saudara-info">
            <td colspan="2">
                <label for="ada_saudara">Sebutkan nama
                    <input type="text" style="width: 270px;" id="nama_saudara_kerja" name="nama_saudara_kerja"> dan jabatannya
                    <input type="text" style="width: 270px;" id="jabatan_saudara_kerja" name="jabatan_saudara_kerja">
                </label>
            </td>
        </tr>
    </table>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const adaRadio = document.getElementById('ada');
            const tidakAdaRadio = document.getElementById('tidak_ada');
            const saudaraInfoRow = document.getElementById('saudara-info');
            const namaSaudaraKerja = document.getElementById('nama_saudara_kerja');
            const jabatanSaudaraKerja = document.getElementById('jabatan_saudara_kerja');

            adaRadio.addEventListener('change', function() {
                if (this.checked) {
                    saudaraInfoRow.style.display = 'table-row';
                    namaSaudaraKerja.setAttribute('required', 'required');
                    jabatanSaudaraKerja.setAttribute('required', 'required');
                }
            });

            tidakAdaRadio.addEventListener('change', function() {
                if (this.checked) {
                    saudaraInfoRow.style.display = 'none';
                    namaSaudaraKerja.removeAttribute('required');
                    jabatanSaudaraKerja.removeAttribute('required');
                }
            });
        });
    </script>
    
    <style>
        .hidden-row {
            display: none;
        }
    </style>


    <table style="width: 100%; margin-top: -30px;">
        <tr>
            <td>Apakah anda pernah bekerja atau ditawari bekerja di salah satu perusahaan atau anak perusahaan Jababeka Group?</td>
            <td style="width: 200px;">
                <input type="radio" id="pernah" name="pengalaman_jababeka" value="Pernah" required>
                <label for="pernah">Pernah</label>

                <input type="radio" id="tidak_pernah" name="pengalaman_jababeka" value="Tidak Pernah" required>
                <label for="tidak_pernah">Tidak pernah</label>
            </td>
        </tr>
        <tr class="hidden-row-jababeka" id="kerja-jababeka">
            <td colspan="2">
                <label for="kerja_jababeka">Sebutkan?
                    <textarea id="kerja_jababeka" name="kerja_jababeka" style="width: 100%; height: 100px;"></textarea>
                </label>
            </td>
        </tr>
    </table>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pernahRadio = document.getElementById('pernah');
            const tidakPernahRadio = document.getElementById('tidak_pernah');
            const kerjaJababekaRow = document.getElementById('kerja-jababeka');
            const kerjaJababekaTextarea = document.getElementById('kerja_jababeka');

            pernahRadio.addEventListener('change', function() {
                if (this.checked) {
                    kerjaJababekaRow.style.display = 'table-row';
                    kerjaJababekaTextarea.setAttribute('required', 'required');
                }
            });

            tidakPernahRadio.addEventListener('change', function() {
                if (this.checked) {
                    kerjaJababekaRow.style.display = 'none';
                    kerjaJababekaTextarea.removeAttribute('required');
                }
            });
        });
    </script>
    <style>
        .hidden-row-jababeka {
            display: none;
        }
    </style>


    <!-- soal 3 -->
    <table style="width: 100%; margin-top: -30px;">
        <tr>
            <td>Bidang pekerjaan apa yang paling anda minati dan mengapa?</td>
        </tr>
        <tr>
            <td>
                <label for="ada-pengalamanKerjaJababeka">
                    <textarea type="text" id="bidang_pekerjaan" name="bidang_pekerjaan" style="width: 100%; height: 100px;" required></textarea>
                </label>
            </td>
        </tr>
    </table>

    <!-- soal 4 -->
    <table style="width: 100%; margin-top: -30px;">
        <tr>
            <td>Apakah anda pernah menderita kecelakaan, sakit keras mental? </td>
            <td style="width: 200px;">
                <input type="radio" id="pernah_kecelakaan" name="riwayat_kecelakaan" value="Pernah" required>
                <label for="pernah_kecelakaan">Pernah</label>

                <input type="radio" id="tidak_pernah_kecelakaan" name="riwayat_kecelakaan" value="Tidak Pernah" required>
                <label for="tidak_pernah_kecelakaan">Tidak pernah</label>
            </td>
        </tr>
        <tr class="kecelakaan" id="kecelakaan">
            <td colspan="2">
                <label for="ada_kecelakaan">Sebutkan?
                    <textarea name="kecelakaan" id="kecelakaan_textarea" style="width: 100%; height: 80px;"></textarea>
                </label>
            </td>
        </tr>
    </table>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pernahKecelakaan = document.getElementById('pernah_kecelakaan');
            const tidakPernahKecelakaan = document.getElementById('tidak_pernah_kecelakaan');
            const kecelakaanRow = document.getElementById('kecelakaan');
            const kecelakaanTextarea = document.getElementById('kecelakaan_textarea');

            pernahKecelakaan.addEventListener('change', function() {
                if (this.checked) {
                    kecelakaanRow.style.display = 'table-row';
                    kecelakaanTextarea.setAttribute('required', 'required');
                }
            });

            tidakPernahKecelakaan.addEventListener('change', function() {
                if (this.checked) {
                    kecelakaanRow.style.display = 'none';
                    kecelakaanTextarea.removeAttribute('required');
                }
            });
        });
    </script>
    <style>
        .kecelakaan {
            display: none;
        }
    </style>


    <!-- soal 5 -->
    <table style="width: 100%; margin-top: -30px;">
        <tr>
            <td>Apakah anda pernah terlibat tindak kriminal? </td>
            <td style="width: 200px;">
                <input type="radio" id="pernah_kriminal" name="riwayat_kriminal" value="Pernah" required>
                <label for="pernah_kriminal">Pernah</label>

                <input type="radio" id="tidak_pernah_kriminal" name="riwayat_kriminal" value="Tidak Pernah" required>
                <label for="tidak_pernah_kriminal">Tidak pernah</label>
            </td>
        </tr>
        <tr class="kriminal" id="kriminal">
            <td colspan="2">
                <label for="ada_kriminal">Sebutkan?
                    <textarea name="kriminal" id="kriminal_textarea" style="width: 100%; height: 80px;"></textarea>
                </label>
            </td>
        </tr>
    </table>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pernahKriminal = document.getElementById('pernah_kriminal');
            const tidakPernahKriminal = document.getElementById('tidak_pernah_kriminal');
            const kriminalRow = document.getElementById('kriminal');
            const kriminalTextarea = document.getElementById('kriminal_textarea');

            pernahKriminal.addEventListener('change', function() {
                if (this.checked) {
                    kriminalRow.style.display = 'table-row';
                    kriminalTextarea.setAttribute('required', 'required');
                }
            });

            tidakPernahKriminal.addEventListener('change', function() {
                if (this.checked) {
                    kriminalRow.style.display = 'none';
                    kriminalTextarea.removeAttribute('required');
                }
            });
        });
    </script>
    <style>
        .kriminal {
            display: none;
        }
    </style>



    <!-- soal 6 -->
    <table style="width: 100%; margin-top: -30px;">
        <tr>
            <td>Bagaimana cara anda menghabiskan waktu luang?</td>
        </tr>
        <tr>
            <td>
                <label for="ada-pengalamanKerjaJababeka">
                    <textarea type="text" id="waktu_luang" name="waktu_luang" style="width: 100%; height: 100px;" required></textarea>
                </label>
            </td>
        </tr>
    </table>

    <!-- soal 7 -->
    <table style="width: 100%; margin-top: -30px;">
        <tr>
            <td>Apakah anda mempunyai sumber pendapatan lain selain gaji yang anda terima tiap bulan? </td>
            <td style="width: 200px;">
                <input type="radio" id="pernah_sampingan" name="kerja_sampingan" value="Ada" required>
                <label for="pernah_sampingan">Ada</label>

                <input type="radio" id="tidak_pernah_sampingan" name="kerja_sampingan" value="Tidak ada" required>
                <label for="tidak_pernah_sampingan">Tidak ada</label>
            </td>
        </tr>
        <tr class="sampingan" id="sampingan">
            <td colspan="2">
                <label for="ada_sampingan">Sebutkan?
                    <textarea name="sampingan" id="sampingan_textarea" style="width: 100%; height: 80px;"></textarea>
                </label>
            </td>
        </tr>
    </table>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pernahSampingan = document.getElementById('pernah_sampingan');
            const tidakPernahSampingan = document.getElementById('tidak_pernah_sampingan');
            const sampinganRow = document.getElementById('sampingan');
            const sampinganTextarea = document.getElementById('sampingan_textarea');

            pernahSampingan.addEventListener('change', function() {
                if (this.checked) {
                    sampinganRow.style.display = 'table-row';
                    sampinganTextarea.setAttribute('required', 'required');
                }
            });

            tidakPernahSampingan.addEventListener('change', function() {
                if (this.checked) {
                    sampinganRow.style.display = 'none';
                    sampinganTextarea.removeAttribute('required');
                }
            });
        });
    </script>
    <style>
        .sampingan {
            display: none;
        }
    </style>


    <!-- soal 8 -->
    <table style="width: 100%; margin-top: -30px;">
        <tr>
            <td>Pernahkah anda menjadi anggota pengurus dari suatu organisasi?</td>
            <td style="width: 200px;">
                <input type="radio" id="ada_organisasi" name="pengalaman_organisasi" value="ada" required>
                <label for="ada">Ada</label>

                <input type="radio" id="tidak_ada_organisasi" name="pengalaman_organisasi" value="tidak ada" required>
                <label for="tidak_ada">Tidak ada</label>
            </td>
        </tr>
        <tr class="hidden-row" id="organisasiRow">
            <td colspan="2">
                <label for="organisasi">Kapan, dan apa saja tugasnya?
                    <textarea name="organisasi" id="organisasi" style="width: 100%; height: 80px;"></textarea>
                </label>
            </td>
        </tr>
    </table>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pernahOrganisasiRadios = document.getElementsByName('pernah_organisasi');
            const organisasiRow = document.getElementById('organisasiRow');
            const organisasiTextarea = document.getElementById('organisasi');

            pernahOrganisasiRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'ya') {
                        organisasiRow.classList.remove('hidden-row');
                        organisasiTextarea.setAttribute('required', 'required');
                    } else {
                        organisasiRow.classList.add('hidden-row');
                        organisasiTextarea.removeAttribute('required');
                    }
                });
            });
        });

        document.getElementById('ada_organisasi').addEventListener('change', function() {
            document.getElementById('organisasiRow').style.display = 'table-row';
        });

        document.getElementById('tidak_ada_organisasi').addEventListener('change', function() {
            document.getElementById('organisasiRow').style.display = 'none';
        });
    </script>
    <style>
        .organisasiRow {
            display: none;
        }
    </style>

    <!-- REFERENSI -->
    <style>
        .hidden {
            display: none;
        }
    </style>
    <table class="form-table" id="formTableRef" style="margin-top: -30px;">
        <thead>
            <tr>
                <td colspan="4">
                    Sebutkan referensi anda :
                </td>
            </tr>
            <tr>
                <th style="width: 180px;">Nama<button type="button" id="addRowRefButton" onclick="toggleRowVisibility()" style="margin-left: 10px;">+</button></th>
                <th>Alamat</th>
                <th>No. Telepon</th>
                <th>Perusahaan / Jabatan</th>
            </tr>
        </thead>
        <tbody id="referensi">
            <!-- Initially empty tbody -->
        </tbody>
    </table>
    <script>
        let currentRow = 0;

        function toggleRowVisibility() {
            if (currentRow < 3) {
                currentRow++;
                const newRow = document.createElement('tr');
                newRow.id = `row_${currentRow}`;
                newRow.innerHTML = `
                <td><input type="text" id="nama_ref_${currentRow}" name="nama_ref_${currentRow}"></td>
                <td><input type="text" id="alamat_ref_${currentRow}" name="alamat_ref_${currentRow}"></td>
                <td><input type="text" id="tlp_ref_${currentRow}" name="tlp_ref_${currentRow}"></td>
                <td><input type="text" id="jabatan_ref_${currentRow}" name="jabatan_ref_${currentRow}"></td>
            `;
                document.getElementById('referensi').appendChild(newRow);

                if (currentRow === 3) {
                    document.getElementById('addRowRefButton').style.display = 'none';
                }
            }
        }
    </script>


    <!-- Konfirmasi -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        p {
            text-align: justify;
            /* Center-align the text */
            margin: 20px 0;
            /* Add vertical margin */
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-style: italic;
            color: #888;
        }

        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 20px 0;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            /* Darker background */
            padding-top: 20px;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 60px;
            padding-top: 20px;
            border-radius: 10px;
            /* Rounded corners */
            width: 80%;
            height: 250px;
            max-width: 600px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            /* Stronger shadow */
            animation: fadeIn 0.5s;
            position: relative;
            /* Position relative to contain child absolute elements */
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .checkbox-container input {
            margin-right: 10px;
        }

        .checkbox-container label {
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
    <table style="margin-bottom: -20px; margin-top: -30px;">
        <tr>
            <td style="text-align: justify;">
                <div class="checkbox-container">
                    <input type="checkbox" id="bookletRadio" name="options" required>
                    <label for="bookletRadio">Persyaratan</label>
                </div>
            </td>
        </tr>
    </table>
    <script>
        function validateForm() {
            // Cek apakah checkbox Persyaratan telah dicentang
            var bookletCheckbox = document.getElementById("bookletRadio");

            // Jika checkbox tidak dicentang, tampilkan pesan kesalahan
            if (!bookletCheckbox.checked) {
                alert("Anda harus menyetujui persyaratan.");
                return false; // Form tidak akan dikirim
            }

            // Lanjutkan pengiriman formulir jika validasi berhasil
            return true;
        }
    </script>

    <!-- Modal -->
    <div id="modalBooklet" class="modal">
        <div class="modal-content">
            <tab style="margin-top: -15px;">
                <tr>
                    <td>
                        <h2 style="text-align: center;">Pernyataan Kesediaan</h2>
                        <hr> <!-- Garis di atas paragraf -->
                        <p>
                            Dengan ini saya menyatakan bahwa saya bersedia untuk mengikuti seluruh proses seleksi yang berlangsung di Jababeka Group dan keterangan dalam formulir ini diberikan dengan jujur dan benar. Oleh karenanya saya bersedia menerima konsekuensi, tanpa kewajiban apapun bagi perusahaan, apabila dikemudian hari keterangan yang saya berikan ternyata tidak benar/palsu.
                        </p>
                        <div class="checkbox-container" style="text-align: center;">
                            <input type="checkbox" id="modalCheckbox" required>
                            <label for="modalCheckbox">Saya setuju dengan pernyataan di atas</label>
                        </div>
                        <hr> <!-- Garis di bawah paragraf -->
                        <div class="footer">@rekrutmen jababeka 2024</div>
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                </tr>
            </tab>
        </div>

    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("modalBooklet");

        // Get the radio button
        var bookletRadio = document.getElementById("bookletRadio");

        // Get the checkbox in the modal
        var modalCheckbox = document.getElementById("modalCheckbox");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // Disable the radio button initially
        bookletRadio.disabled = true;

        // Open the modal when the radio button or label is clicked
        bookletRadio.parentElement.onclick = function(event) {
            event.preventDefault(); // Prevent the default behavior of the radio button
            modal.style.display = "block";
        }

        // When the checkbox in the modal is clicked
        modalCheckbox.onclick = function() {
            // Set the value of the radio button based on checkbox state
            bookletRadio.checked = modalCheckbox.checked;

            // If checkbox is checked, close the modal and enable the radio button
            if (modalCheckbox.checked) {
                modal.style.display = "none";
                bookletRadio.disabled = false;
            }
        }
    </script>


    <table>
        <tr>
            <td>
                <?php
                // Mendapatkan tanggal hari ini
                $tanggal_hari_ini = date("Y-m-d");

                // Menampilkan tanggal hari ini
                echo "Tanggal : " . $tanggal_hari_ini;
                ?>

            </td>
        </tr>
    </table>

    <!-- Tombol Sumbit -->
    <tr>
        <td></td>
        <td><input type="submit" value="Simpan" name="proses"></td>
    </tr>
</form>