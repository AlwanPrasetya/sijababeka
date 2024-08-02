<html>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe2Em+P1hq8dO/erPG2D0vXqz7W" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<?php
// include('sidebar.php');
include('koneksi.php');

// Query untuk mengambil data karyawan dan menyimpannya dalam bentuk array
$query_karyawan = mysqli_query($connection, "SELECT * FROM karyawan");
$data_karyawan = array();

while ($row_karyawan = mysqli_fetch_assoc($query_karyawan)) {
    $data_karyawan[$row_karyawan['nama']] = array(
        'nama_status' => $row_karyawan['status'],
        'nama_unit' => $row_karyawan['bisnis'],
        'nama_jabatan' => $row_karyawan['jabatan'],
        'nama_organisasi' => $row_karyawan['organisasi'],
        'nama_golongan' => $row_karyawan['golongan']
    );
}
?>
<style>
    body {
        background-color: #EAFAF1;
    }

    #sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100px;
        background-color: #008F4D;
        padding-top: 25px;
        z-index: 1;
    }

    #sidebar ul {
        list-style-type: none;
        padding: 0;
    }

    #sidebar ul li {
        padding: 10px 15px;
    }

    #sidebar ul li a {
        color: white;
        text-decoration: none;
        font-size: 15px;
    }

    #toggler {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }

    .container-content {
        margin-left: 100px;
    }

    .settings-button {
        position: fixed;
        top: 0px;
        left: 0px;
        padding: 10px 13px 10px 13px;
        z-index: 50;
        background-color: #9ACD32;
    }

    .fpk-button {
        display: none;
        /* Mulai dengan menyembunyikan tombol FPK */
        position: flex;
        padding: 5px 13px;
        background-color: blue;
    }
</style>
</head>

<body>
    <div id="sidebar">
        <div id="toggler">&#9776;</div>
        <ul>
            <li><a href="../../../superadmin/superadmin.php" class="btn settings-button">Dashboard</a></li>
            <li><a href="../tetap/index.php">Employee</a></li>
            <li><a href="../employee_transfer/index.php">Employee Transfer</a></li>
            <li><a href="javascript:history.go(-1);" class="btn fpk-button" id="fpkButton">Back</a></li>

        </ul>
    </div>

    <script>
        // Script untuk menampilkan tombol FPK hanya ketika URL mengandung kata "search"
        document.addEventListener("DOMContentLoaded", function() {
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has("search")) {
                var fpkButton = document.getElementById("fpkButton");
                fpkButton.style.display = "block";
            }
        });
    </script>

    <style>
        body {
            overflow-x: hidden;
        }

        .container {
            flex-direction: column;
            align-items: center;
            width: 100%;
            margin-left: 150px;
            /* Tambahkan padding kiri dan kanan */

            /* Menghilangkan margin */
        }

        .form-box {
            display: flex;
            justify-content: center;
            width: 100%;
            /* Lebar penuh */
            margin: 0;
            /* Menghilangkan margin */
        }

        .form-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            width: 100%;
            /* Lebar penuh */
            margin: 0;
            /* Menghilangkan margin */
        }

        .form-section {
            width: 100%;
            /* Lebar penuh */
            margin: 0;
            /* Menghilangkan margin */
        }

        @media screen and (max-width: 768px) {
            .container-content {
                padding: 10px;
            }

            .card-header {
                font-size: 14px;
            }

            .card-body {
                padding: 10px;
            }

            .btn {
                margin-bottom: 10px;
            }

        }
    </style>

    <div class="container">
        <h2 class="text-center mt-3 mb-4">EMPLOYEE TRANSFER</h2>
        <div class="row">
            <div id="transfer" class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- <h5 class="card-title">Transfer Type, Tanggal Transfer, Upload File & Reason</h5> -->
                        <form action="save.php" method="post" enctype="multipart/form-data" onsubmit="enableNama()">
                            <label for="requestType">Jenis Permintaan</label>
                            <select id="requestType" name="requestType" class="form-control" required onchange="updateName()">
                                <option value="">Pilih Jenis Permintaan</option>
                                <option value="PHK">PHK</option>
                                <option value="Resign">Resign</option>
                                <option value="Mutasi">Mutasi</option>
                                <option value="Promosi">Promosi</option>
                                <option value="Demosi">Demosi</option>
                                <option value="Karyawan Baru">New Hire</option>
                            </select>
                            <label for="effectiveDate">Tanggal Transfer</label>
                            <input type="date" id="effectiveDate" name="effectiveDate" class="form-control" style="height: 50px;" required>

                            <label for="uploadFile">Unggah Lampiran (pdf, jpg, ,jpeg, png, docx, doc, xls, xlsx)</label>
                            <input type="file" id="uploadFile" name="uploadFile" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.docx,.doc,.xlxs,.xls" style="height: 50px;" required>
                            <label for="reason">Alasan</label>
                            <textarea id="reason" name="reason" class="form-control" required style="height: 187px;"></textarea>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById("requestType").addEventListener("change", function() {
                    var selectedOption = this.value;
                    var notReplaceElement = document.getElementById("notReplace");
                    var notTransferElement = document.getElementById("notTransfer");
                    var transferElement = document.getElementById("transfer");
                    var moveElement = document.getElementById("move");
                    var iconElement = document.getElementById("icon");

                    if (selectedOption === "Mutasi" || selectedOption === "Promosi" || selectedOption === "Demosi") {
                        // Mengubah kelas col-md-6 menjadi col-md-4
                        notReplaceElement.classList.remove("col-md-6");
                        notReplaceElement.classList.add("col-md-8");
                        // Menampilkan elemen notReplace
                        notReplaceElement.style.display = "block";
                        // Mengubah kelas col-md-6 menjadi col-md-4
                        notTransferElement.classList.remove("col-md-12");
                        notTransferElement.classList.add("col-md-5");
                        // Menampilkan elemen transfer
                        notTransferElement.style.display = "block";
                        // Mengubah kelas col-md-6 menjadi col-md-4
                        transferElement.classList.remove("col-md-6");
                        transferElement.classList.add("col-md-4");
                        // Menampilkan elemen transfer
                        transferElement.style.display = "block";
                        moveElement.style.display = "block";
                        iconElement.style.display = "block";
                        // Menampilkan elemen replace
                        // replaceElement.style.display = "block";
                    } else if (selectedOption === "PHK" || selectedOption === "Resign" || selectedOption === "KaryawanBaru") {
                        // Mengembalikan kelas ke semula jika opsi bukan "Mutasi", "Promosi", atau "Demosi"
                        notReplaceElement.classList.remove("col-md-8");
                        notReplaceElement.classList.add("col-md-6");
                        // Menyembunyikan elemen notReplace jika opsi bukan "Mutasi", "Promosi", atau "Demosi"
                        notReplaceElement.style.display = "block";
                        // Mengembalikan kelas ke semula jika opsi bukan "Mutasi", "Promosi", atau "Demosi"
                        notTransferElement.classList.remove("col-md-4");
                        notTransferElement.classList.add("col-md-12");
                        // Menyembunyikan elemen transfer jika opsi bukan "Mutasi", "Promosi", atau "Demosi"
                        notTransferElement.style.display = "block";
                        // Menyembunyikan elemen replace jika opsi bukan "Mutasi", "Promosi", atau "Demosi"
                        transferElement.classList.remove("col-md-4");
                        transferElement.classList.add("col-md-6");
                        // Menyembunyikan elemen transfer jika opsi bukan "Mutasi", "Promosi", atau "Demosi"
                        transferElement.style.display = "block";
                        moveElement.style.display = "none";
                        iconElement.style.display = "none";
                    }
                });
            </script>
            <script>
                function updateName() {
                    var requestType = document.getElementById("requestType").value;
                    var namaSelect = document.getElementById("nama");

                    if (requestType === "Karyawan Baru") {
                        namaSelect.innerHTML = '<option value="Additional">Additional</option>';
                    } else {
                        // Reset pilihan ke nilai awal
                        namaSelect.innerHTML = '<?php
                                                include('koneksi.php');
                                                $query_nama = mysqli_query($connection, "SELECT DISTINCT nama FROM karyawan ORDER BY nama ASC");
                                                $options = '<option value="">Pilih Nama</option>';
                                                while ($row_nama = mysqli_fetch_array($query_nama)) {
                                                    $options .= '<option value="' . $row_nama['nama'] . '">' . $row_nama['nama'] . '</option>';
                                                }
                                                echo $options;
                                                ?>';
                    }
                }
            </script>

            <!-- FORM NOT REPLACE -->
            <div id="notReplace" class="col-md-6" style="display: block;">
                <div class="card mb-6">
                    <div class="card-body">
                        <!-- Isian Nama Karyawan & Status Karyawan -->
                        <center>
                            <label for="nama">
                                Nama Karyawan:
                                <select class="select2" id="nama" name="nama" required onchange="fillForm()" style="width: 305px;">
                                    <option value="">Pilih Nama</option>
                                    <?php
                                    include('koneksi.php');
                                    $query_nama = mysqli_query($connection, "SELECT DISTINCT nama FROM karyawan ORDER BY nama ASC");
                                    while ($row_nama = mysqli_fetch_array($query_nama)) {
                                        echo '<option value="' . $row_nama['nama'] . '">' . $row_nama['nama'] . '</option>';
                                    }
                                    ?>
                                    <br>
                                </select>
                            </label>
                        </center><br>
                        <div class="row">
                            <div id="notTransfer" class="col-md-12">
                                <label for="nama_status" style="margin-top: 5px;">Status Karyawan</label>
                                <input class="form-control" id="nama_status" name="nama_status" required>
                                <label for="nama_unit">Bisnis Unit</label>
                                <input class="form-control" id="nama_unit" name="nama_unit" required>
                                <label for="nama_jabatan">Jabatan</label>
                                <input class="form-control" id="nama_jabatan" name="nama_jabatan" required>
                                <label for="nama_organisasi">Organisasi</label>
                                <input class="form-control" id="nama_organisasi" name="nama_organisasi" required>
                                <label for="nama_golongan">Golongan</label>
                                <input class="form-control" id="nama_golongan" name="nama_golongan" required>
                            </div>
                            <div id="icon" class="col-md-2" style="display: none; text-align: center;">
                                <label style="margin-top: 4px;" for="">Transfer</label>
                                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" style="margin-top: 6px;" fill="rgb(0,143,77)" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                </svg>
                                <br><br>
                                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" style="margin-top: 5px;" fill="rgb(0,143,77)" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                </svg>
                                <br><br>
                                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" style="margin-top: 5px;" fill="rgb(0,143,77)" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                </svg>
                                <br><br>
                                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" style="margin-top: 10px;" fill="rgb(0,143,77)" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                </svg>
                                <br><br>
                                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" style="margin-top: 10px;" fill="rgb(0,143,77)" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                </svg>
                                <br><br>
                            </div>
                            <!-- Isian untuk Transfer -->
                            <div id="move" class="col-md-5" style="display: none;">
                                <label for="status" style="margin-top: 5px;">Status Karyawan</label>
                                <select class="select2" id="status" name="status" onchange="fillForm()" style="width: 270px; height: 40px !important;">
                                    <option value="">Pilih Status</option>
                                    <?php
                                    include('koneksi.php');
                                    $query_nama_status = mysqli_query($connection, "SELECT DISTINCT nama_status FROM status ORDER BY nama_status ASC");
                                    while ($row_nama_status = mysqli_fetch_array($query_nama_status)) {
                                        echo '<option value="' . $row_nama_status['nama_status'] . '">' . $row_nama_status['nama_status'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <label for="branch" style="margin-top:20px; margin-bottom:0px;"></i> Bisnis Unit</label>
                                <select class="select2" id="branch" name="branch" onchange="fillForm()" style="width: 270px; height: 40px !important;">
                                    <option value="">Pilih Bisnis</option>
                                    <?php
                                    include('koneksi.php');
                                    $query_nama_unit = mysqli_query($connection, "SELECT DISTINCT nama_unit FROM bisnis ORDER BY nama_unit ASC");
                                    while ($row_nama_unit = mysqli_fetch_array($query_nama_unit)) {
                                        echo '<option value="' . $row_nama_unit['nama_unit'] . '">' . $row_nama_unit['nama_unit'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <label for="jabatan" style="margin-top:20px; margin-bottom:0px;"></i> Jabatan</label>
                                <select class="select2" id="jabatan" name="jabatan" onchange="fillForm()" style="width: 270px; height: 40px !important;">
                                    <option value="">Pilih Jabatan</option>
                                    <?php
                                    include('koneksi.php');
                                    $query_nama_jabatan = mysqli_query($connection, "SELECT DISTINCT nama_jabatan FROM jabatan ORDER BY nama_jabatan ASC");
                                    while ($row_nama_jabatan = mysqli_fetch_array($query_nama_jabatan)) {
                                        echo '<option value="' . $row_nama_jabatan['nama_jabatan'] . '">' . $row_nama_jabatan['nama_jabatan'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <label for="organisasi" style="margin-top:20px; margin-bottom:0px;">Organisasi</label>
                                <select class="select2" id="organisasi" name="organisasi" onchange="fillForm()" style="width: 270px; height: 40px !important;">
                                    <option value="">Pilih Jabatan</option>
                                    <?php
                                    include('koneksi.php');
                                    $query_nama_organisasi = mysqli_query($connection, "SELECT DISTINCT nama_organisasi FROM organisasi ORDER BY nama_organisasi ASC");
                                    while ($row_nama_organisasi = mysqli_fetch_array($query_nama_organisasi)) {
                                        echo '<option value="' . $row_nama_organisasi['nama_organisasi'] . '">' . $row_nama_organisasi['nama_organisasi'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <label for="golongan" style="margin-top:20px; margin-bottom:0px;"></i>Golongan</label>
                                <select class="select2" id="golongan" name="golongan" onchange="fillForm()" style="width: 270px; height: 40px !important;">
                                    <option value="">Pilih Golongan</option>
                                    <?php
                                    include('koneksi.php');
                                    $query_nama_golongan = mysqli_query($connection, "SELECT DISTINCT nama_golongan FROM golongan ORDER BY nama_golongan ASC");
                                    while ($row_nama_golongan = mysqli_fetch_array($query_nama_golongan)) {
                                        echo '<option value="' . $row_nama_golongan['nama_golongan'] . '">' . $row_nama_golongan['nama_golongan'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="text-right">
                            <button type="reset" class="btn btn-secondary mt-3 ml-2"><svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 48 48">
                                    <rect width="48" height="48" fill="none" />
                                    <defs>
                                        <mask id="ipTClearFormat0">
                                            <g fill="none" stroke="#fff">
                                                <path fill="#555" stroke-linejoin="round" stroke-width="4.3" d="M44.782 24.17L31.918 7.1L14.135 20.5L27.5 37l3.356-2.336z" />
                                                <path stroke-linejoin="round" stroke-width="4.3" d="m27.5 37l-3.839 3.075l-10.563-.001l-2.6-3.45l-6.433-8.536L14.5 20.225" />
                                                <path stroke-linecap="round" stroke-width="4.5" d="M13.206 40.072h31.36" />
                                            </g>
                                        </mask>
                                    </defs>
                                    <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipTClearFormat0)" />
                                </svg></button>
                            <button type="submit" class="btn btn-primary mt-3"><svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox=" 20 20">
                                    <rect width="20" height="20" fill="none" />
                                    <path fill="currentColor" d="M5 5v14h14V7.83L16.17 5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3s3 1.34 3 3s-1.34 3-3 3m3-8H6V6h9z" opacity="0.3" />
                                    <path fill="currentColor" d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V7zm2 16H5V5h11.17L19 7.83zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3M6 6h9v4H6z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            </form>
        </div>
    </div>

    <!-- CARD ROW-4 -->
    <!--  -->

    <!-- EMPLOYEE TRANSFEER FROM -->

    <script>
        function fillFrom() {
            // Mendapatkan nilai nama karyawan yang dipilih
            var selectedName = document.getElementById("namaFrom").value;

            // Mendapatkan data karyawan dari array berdasarkan nama yang dipilih
            var selectedEmployee = dataKaryawan[selectedName];

            // Mengisi nilai form dengan data karyawan yang ditemukan
            document.getElementById("nama_status_from").value = selectedEmployee.nama_status;
            document.getElementById("nama_unit_from").value = selectedEmployee.nama_unit;
            document.getElementById("nama_jabatan_from").value = selectedEmployee.nama_jabatan;
            document.getElementById("nama_organisasi_from").value = selectedEmployee.nama_organisasi;
            document.getElementById("nama_golongan_from").value = selectedEmployee.nama_golongan;
        }
    </script>

    <!-- EMPLOYEE TRANSFER TO -->

    </div>

    </div>
    <style>
        .table-wrapper table {
            width: 100%;
        }

        .table-wrapper thead th,
        .table-wrapper tbody td {
            width: auto;
        }

        /* CSS untuk mengatur lebar kolom dan memperpanjang isi tabel ke kanan */
        .table-wrapper {
            /* overflow-x: auto; */
        }

        th,
        td {
            white-space: nowrap;
        }
    </style>
    <div class="container" style="margin-top: 20px;">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #008F4D; color: white;">
                        DATA KARYAWAN
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper">
                            <style>
                                /* CSS untuk menyembunyikan kolom-kolom yang tidak ingin ditampilkan */
                                .table-hide-col {
                                    display: none;
                                }
                            </style>

                            <table id="myTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">NO.</th>
                                        <th scope="col">NAMA</th>
                                        <th scope="col">PERMINTAAN</th>
                                        <th scope="col" class="table-hide-col">TANGGAL DIPINDAHKAN</th>
                                        <th scope="col" class="table-hide-col">STATUS KARYAWAN</th>
                                        <th scope="col">BISNIS UNIT</th>
                                        <th scope="col" class="table-hide-col">JABATAN</th>
                                        <th scope="col" class="table-hide-col">ORGANISASI</th>
                                        <th scope="col" class="table-hide-col">GOLONGAN</th>
                                        <th scope="col" class="table-hide-col">KETERANGAN</th>
                                        <th scope="col" class="table-hide-col">DOKUMEN</th>
                                        <th scope="col">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include('koneksi.php');
                                    $no = 1;

                                    // Query untuk mengambil semua data employee_transfer tanpa memperhatikan request_type
                                    $query = mysqli_query($connection, "SELECT * FROM employee_transfer");

                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>

                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $row['nama'] ?></td>
                                            <td><?php echo $row['request_type'] ?></td>
                                            <td class="table-hide-col"><?php echo $row['effective_date'] ?></td>
                                            <td class="table-hide-col"><?php echo $row['nama_status'] ?></td>
                                            <td><?php echo $row['nama_unit'] ?></td>
                                            <td class="table-hide-col"><?php echo $row['nama_jabatan'] ?></td>
                                            <td class="table-hide-col"><?php echo $row['nama_organisasi'] ?></td>
                                            <td class="table-hide-col"><?php echo $row['nama_golongan'] ?></td>
                                            <td class="table-hide-col"><?php echo $row['reason'] ?></td>
                                            <td class="table-hide-col"><?php echo $row['file_name'] ?></td>


                                            <td class="text-center">
                                                <?php
                                                // Tangkap nilai branch dari URL jika ada
                                                $branch = isset($_GET['branch']) ? $_GET['branch'] : '';

                                                // Tautkan nilai branch ke URL saat tombol "TRANSFER" diklik
                                                $transfer_url = "../../fpk/fpk.php?branch=" . urlencode($branch) . "&id="  . $row['id'] .  "&request_type=" . urlencode($row['request_type']) . "&nama=" . urlencode($row['nama']) . "&nama_unit=" . urlencode($row['nama_unit']) . "&nama_jabatan=" . urlencode($row['nama_jabatan']) . "&nama_organisasi=" . urlencode($row['nama_organisasi']) . "&nama_golongan=" . urlencode($row['nama_golongan']) . "&effective_date=" . $row['effective_date'] . "&reason=" . urlencode($row['reason']);
                                                $modalScript = "showDetailModal('" . $row['nama'] . "', '" . $row['request_type'] . "', '" . $row['nama_unit'] . "');";
                                                ?>
                                                <!-- EDIT -->
                                                <button href="edit_employee_transfer.php?id=<?php echo $row['id'] ?>" class="btn btn-sm btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="1.25em" height="1.25em" viewBox="0 0 640 512">
                                                        <rect width="640" height="512" fill="none" />
                                                        <path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128m89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h274.9c-2.4-6.8-3.4-14-2.6-21.3l6.8-60.9l1.2-11.1l7.9-7.9l77.3-77.3c-24.5-27.7-60-45.5-99.9-45.5m45.3 145.3l-6.8 61c-1.1 10.2 7.5 18.8 17.6 17.6l60.9-6.8l137.9-137.9l-71.7-71.7zM633 268.9L595.1 231c-9.3-9.3-24.5-9.3-33.8 0l-37.8 37.8l-4.1 4.1l71.8 71.7l41.8-41.8c9.3-9.4 9.3-24.5 0-33.9" />
                                                    </svg></button>

                                                <!-- DELETE -->
                                                <button href="delete_employee_transfer.php?id=<?php echo $row['id'] ?>" class="btn btn-sm btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="1.25em" height="1.25em" viewBox="0 0 24 24">
                                                        <rect width="640" height="640" fill="none" />
                                                        <path fill="currentColor" d="M21 14h-6a1 1 0 1 1 0-2h6a1 1 0 1 1 0 2m-7-5c0 1.381-.56 2.631-1.464 3.535C11.631 13.44 10.381 14 9 14s-2.631-.56-3.536-1.465C4.56 11.631 4 10.381 4 9s.56-2.631 1.464-3.535C6.369 4.56 7.619 4 9 4s2.631.56 3.536 1.465A4.984 4.984 0 0 1 14 9m-5 6c-3.75 0-6 2-6 4c0 1 2.25 2 6 2c3.518 0 6-1 6-2c0-2-2.354-4-6-4" />
                                                    </svg></button>

                                                <!-- DETAIL -->
                                                <button class="btn btn-sm btn-info detail-btn" data-toggle="modal" data-target="#detailModal<?php echo $row['id']; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="1.25em" height="1.25em" viewBox="0 0 20 20">
                                                        <rect width="20" height="20" fill="none" />
                                                        <path fill="currentColor" d="M15 11h7v2h-7zm1 4h6v2h-6zm-2-8h8v2h-8zM4 19h10v-1c0-2.757-2.243-5-5-5H7c-2.757 0-5 2.243-5 5v1zm4-7c1.995 0 3.5-1.505 3.5-3.5S9.995 5 8 5S4.5 6.505 4.5 8.5S6.005 12 8 12" />
                                                    </svg></button>

                                                <!-- TRANSFER -->
                                                <a href="<?php echo $transfer_url; ?>" class="btn btn-sm btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                                                        <rect width="24" height="24" fill="none" />
                                                        <g fill="none">
                                                            <path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                            <path fill="currentColor" d="M20 14a1.5 1.5 0 0 1 .144 2.993L20 17H7.621l1.44 1.44a1.5 1.5 0 0 1-2.008 2.224l-.114-.103l-3.829-3.83c-.974-.974-.34-2.617.991-2.725l.14-.006zM14.94 3.44a1.5 1.5 0 0 1 2.007-.104l.114.103l3.829 3.83c.974.974.34 2.617-.991 2.725l-.14.006H4a1.5 1.5 0 0 1-.144-2.993L4 7h12.379l-1.44-1.44a1.5 1.5 0 0 1 0-2.12Z" />
                                                        </g>
                                                    </svg></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <style>
        /* CSS untuk menghilangkan scrollbar di halaman */
        body.modal-open {
            overflow: hidden;
        }

        /* CSS untuk menambahkan scrollbar vertikal pada modal */
        .modal-body {
            overflow-y: auto;
        }

        /* CSS untuk menetapkan lebar modal */
        .modal-dialog {
            max-width: 700px;
            border-radius: 5rem !important;
            /* Atur radius sudut sesuai keinginan */
            /* Sesuaikan dengan lebar yang diinginkan */
        }
    </style>

    <?php
    // Modal untuk setiap baris
    include('koneksi.php');
    $sql = "SELECT * FROM employee_transfer";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='modal fade' id='detailModal" . $row["id"] . "' tabindex='-1' role='dialog' aria-labelledby='detailModalLabel' aria-hidden='true'>";
            echo "<div class='modal-dialog modal-dialog-scrollable modal-dialog-centered' role='document'>";
            echo "<div class='modal-content' style='border-radius: 15px;'>";
            echo "<div class='modal-header'>";
            echo "<h5 class='modal-title' id='detailModalLabel'>Detail Employee Transfer</h5>";
            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
            echo "<span aria-hidden='true'>&times;</span>";
            echo "</button>";
            echo "</div>";
            echo "<div class='modal-body'>";
            // echo "<h5 class='modal-title' id='detailModalLabel'>Detail Employee Transfer</h5>";
            echo "<table class='table' style='margin-top: -18px'>";
            echo "<tr>";
            echo "<th>ID Karyawan Diperbarui</th>";
            echo "<td>" . $row["id"] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Nama</th>";
            echo "<td>" . $row["nama"] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Jenis Permintaan</th>";
            echo "<td>" . $row["request_type"] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Tanggal Diperbarui</th>";
            echo "<td>" . $row["effective_date"] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Alasan</th>";
            echo "<td>" . $row["reason"] . "</td>";
            echo "</tr>";
            if ($row["request_type"] !== 'PHK' && $row["request_type"] !== 'Resign') {
                // Tampilkan baris "DARI" hanya jika bukan PHK atau resign
                echo "<tr>";
                echo "<th colspan='2'> <div class='tujuan' style='text-align: center;'>DARI</div> </th>";
                echo "</tr>";
            }
            echo "<tr>";
            echo "<th>Status</th>";
            echo "<td>" . $row["nama_status"] . "</td>";
            echo "</tr>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Bisnis Unit</th>";
            echo "<td>" . $row["nama_unit"] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Jabatan</th>";
            echo "<td>" . $row["nama_jabatan"] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Organisasi</th>";
            echo "<td>" . $row["nama_organisasi"] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Golongan</th>";
            echo "<td>" . $row["nama_golongan"] . "</td>";
            echo "</tr>";

            // Echo kode JavaScript di dalam tag <script>
            $requestType = $row["request_type"];

            // Echo baris dengan label dan nilai jika tidak ada PHK atau resign
            if ($requestType !== 'PHK' && $requestType !== 'Resign') {
                echo "<tr>";
                echo "<th colspan='2'> <div class='tujuan' style='text-align: center;'>KE</div> </th>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>status</th>";
                echo "<td>" . ($row["status"] != "" ? $row["status"] : "-") . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>Bisnis Unit</th>";
                echo "<td>" . ($row["branch"] != "" ? $row["branch"] : "-") . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>Jabatan</th>";
                echo "<td>" . ($row["jabatan"] != "" ? $row["jabatan"] : "-") . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>Organisasi</th>";
                echo "<td>" . ($row["organisasi"] != "" ? $row["organisasi"] : "-") . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>Golongan</th>";
                echo "<td>" . ($row["golongan"] != "" ? $row["golongan"] : "-") . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }
    ?>

    <!-- <script>
    // Mengambil elemen-elemen HTML yang akan diubah
    var statusRow = document.querySelector("th:contains('status')").parentNode;
    var branchRow = document.querySelector("th:contains('Branch')").parentNode;
    var jabatanRow = document.querySelector("th:contains('Jabatan')").parentNode;
    var organisasiRow = document.querySelector("th:contains('Organisasi')").parentNode;
    var golonganRow = document.querySelector("th:contains('Golongan')").parentNode;

    // Memeriksa nilai request
    var statusValue = "<?php echo $row['status']; ?>";

    // Jika nilai request adalah "PHK" atau "resign", sembunyikan baris-baris yang relevan
    if (statusValue === "PHK" || statusValue === "resign") {
        statusRow.style.display = "none";
        branchRow.style.display = "none";
        jabatanRow.style.display = "none";
        organisasiRow.style.display = "none";
        golonganRow.style.display = "none";
    }
</script> -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        // Menampilkan popup
        function showPopup(message) {
            var popup = document.getElementById("popup");
            var popupText = document.getElementById("popup-text");
            popupText.innerHTML = message;
            popup.style.display = "block";
        }

        // Menyembunyikan popup saat tombol close diklik
        document.querySelector(".close").addEventListener("click", function() {
            document.getElementById("popup").style.display = "none";
        });

        $(document).ready(function() {
            $('#myTable').DataTable({
                "searching": true, // Aktifkan fitur pencarian
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                "columns": [
                    null,
                    {
                        "searchable": true
                    },
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null
                ]
            });
        });
    </script>
    <script>
        // Array PHP yang menyimpan data karyawan
        var dataKaryawan = <?php echo json_encode($data_karyawan); ?>;

        // Fungsi untuk mengisi nilai form berdasarkan nama karyawan yang dipilih
        function fillForm() {
            // Mendapatkan nilai nama karyawan yang dipilih
            var selectedName = document.getElementById("nama").value;

            // Mendapatkan data karyawan dari array berdasarkan nama yang dipilih
            var selectedEmployee = dataKaryawan[selectedName];

            // Mengisi nilai form dengan data karyawan yang ditemukan
            document.getElementById("nama_status").value = selectedEmployee.nama_status;
            document.getElementById("nama_unit").value = selectedEmployee.nama_unit;
            document.getElementById("nama_jabatan").value = selectedEmployee.nama_jabatan;
            document.getElementById("nama_organisasi").value = selectedEmployee.nama_organisasi;
            document.getElementById("nama_golongan").value = selectedEmployee.nama_golongan;
        }
    </script>

</html>