<?php
include('sidebar.php');
include('koneksi.php');
?>
<?php
if (isset($_GET['id'])) {

    $userId = $_GET['id'];

    $query = "SELECT branch, nama FROM multi_user WHERE id = $userId"; // Perhatikan perubahan disini: $userId
    $result = $connection->query($query);
}
?>
<?php

// Tampilkan kembali data yang disimpan dalam sesi
if (isset($_SESSION['effective_date']) && isset($_SESSION['reason'])) {
    // Gunakan data untuk menampilkan kembali tampilan sebelumnya
    $effective_date = $_SESSION['effective_date'];
    $reason = $_SESSION['reason'];
} else {
}

if (isset($_GET['branch'])) {
    // Ambil nilai branch dari URL
    $branch = $_GET['branch'];
} else {
    // Jika nilai branch tidak ditemukan dalam URL
    echo "Nilai branch tidak ditemukan dalam URL.";
}
?>
<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<style>
    body {
        background-color: #EAFAF1;
    }

    /* CSS untuk button di kanan atas */
    .top-left-button {
        position: absolute;
        top: 20px;
        left: 20px;
    }
</style>
<a href="./fpk.php?id=<?php echo $userId; ?>&branch=<?php echo $branch; ?>" class="top-left-button">
    <img src="./img/left-arrow.png " alt="" style="width: 40px; height: 40px; margin: 15px 15px;"></a>

<div class="container-content">
    <div class="container" style="margin-top: 80px">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #008F4D; color: white;">
                        TABEL FORMULIR PERMINTAAN KARYAWAN
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="myTable" style="white-space: nowrap; overflow:hidden; text-overflow:ellipsis;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Summary Of No FPK</th>
                                        <th>Bisnis</th>
                                        <th>Position</th>
                                        <th>organisasi</th>
                                        <th>Status Approval</th>
                                        <th>Status FPK</th>
                                        <th>Grade</th>
                                        <th>Transfer Type</th>
                                        <th>Remark:Reason</th>
                                        <th>Depthead</th>
                                        <th>FPK Received</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include('koneksi.php');

                                    $no = 1;
                                    $sql = "SELECT fpk.*, persetujuan.Status_Penyetujuan, persetujuan.persetujuanAtasan, persetujuan.persetujuanAdmin FROM fpk LEFT JOIN persetujuan ON fpk.kodeFPK = persetujuan.kodeFPK";
                                    $result = $connection->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $no++ . "</td>";
                                            echo "<td>" . $row["kodeFPK"] . "</td>";
                                            echo "<td>" . $row["namaUnit"] . "</td>";
                                            echo "<td>" . $row["jabatan"] . "</td>";
                                            echo "<td>" . $row["organisasi"] . "</td>";

                                            // Menentukan warna tombol berdasarkan status persetujuan
                                            $buttonColor = ($row["Status_Penyetujuan"] == "Approved") ? "btn-success" : "btn-danger";

                                            // Menampilkan tombol dengan warna yang sesuai dan menentukan target modal
                                            if ($row["Status_Penyetujuan"] == "Approved") {
                                                echo "<td><button type='button' class='btn $buttonColor detail-btn' data-toggle='modal' data-target='#approvedModal" . $row["id_fpk"] . "'>Approved</button></td>";
                                            } else {
                                                echo "<td><button type='button' class='btn $buttonColor detail-btn' data-toggle='modal' data-target='#pendingModal" . $row["id_fpk"] . "'>Pending</button></td>";
                                            }

                                            echo "<td>" . (($row["Status_Penyetujuan"] == "Approved") ? "Open" : "-") . "</td>";
                                            echo "<td>" . $row["golongan"] . "</td>";
                                            echo "<td>" . $row["requestType"] . "</td>";
                                            echo "<td>" . $row["NamaFPK"] . "</td>";
                                            // dari kepala organisasi
                                            echo "<td>" . ($row["persetujuanUser"] === "Disetujui" ? $row["namaUser"] : "") . "</td>";
                                            echo "<td>" . $row["tglPresdir"] . "</td>";
                                            echo "<td style='white-space: nowrap;'>";
                                            echo "<button type='button' class='btn btn-primary detail-btn' data-toggle='modal' data-target='#detailModal" . $row["id_fpk"] . "' style='margin-right: 5px;'>Detail</button>"; // Tambahkan margin-right di sini
                                            echo "<button type='button' class='btn btn-success print-btn' onclick='printFPK(" . $row["id_fpk"] . ")'>Print</button>";
                                            echo "</td>";
                                            echo "</tr>";

                                            // Modal untuk setiap baris dengan persetujuan "Approved"
                                            echo "<div class='modal fade' id='approvedModal" . $row["id_fpk"] . "' tabindex='-1' role='dialog' aria-labelledby='approvedModalLabel' aria-hidden='true'>";
                                            echo "<div class='modal-dialog' role='document'>";
                                            echo "<div class='modal-content'>";
                                            echo "<div class='modal-header'>";
                                            echo "<h5 class='modal-title' id='approvedModalLabel'>Detail Approved</h5>";
                                            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                                            echo "<span aria-hidden='true'>&times;</span>";
                                            echo "</button>";
                                            echo "</div>";
                                            echo "<div class='modal-body'>";
                                            // Tambahkan detail yang relevan di sini
                                            echo "<p>Persetujuan Depthead: " . $row["persetujuanUser"] . " | " . $row["namaUser"] . " | " . $row["tglUser"] . "</p>";
                                            echo "<p>Persetujuan HR Unit: " . $row["persetujuanAdmin"] . " | " . $row["namaAdmin"] . " | " . $row["tglAdmin"] . "</p>";
                                            echo "<p>Persetujuan Direksi (1): " . $row["persetujuanAtasan"] . " | " . $row["namaAtasan"] . " | " . $row["tglAtasan"] . "</p>";
                                            echo "<p>Persetujuan Direksi (2): " . $row["persetujuanDireksi2"] . " | " . $row["namaDireksi2"] . " | " . $row["tglDireksi2"] . "</p>";
                                            echo "<p>Persetujuan Direksi (3): " . $row["persetujuanDireksi3"] . " | " . $row["namaDireksi3"] . " | " . $row["tglDireksi3"] . "</p>";
                                            echo "<p>Persetujuan Presdir: " . $row["persetujuanPresdir"] . " | " . $row["namaPresdir"] . " | " . $row["tglPresdir"] . "</p>";
                                            echo "<p>Persetujuan Corp HR: " . $row["persetujuanCorpHr"] . " | " . $row["namaCorpHr"] . " | " . $row["tglCorpHr"] . "</p>";
                                            echo "<p>Persetujuan Super Admin: " . $row["persetujuanSuperadmin"] . " | " . $row["namaSuperadmin"] . " | " . $row["tglSuperadmin"] . "</p>";
                                            // Dan seterusnya sesuai kebutuhan
                                            echo "</div>";
                                            echo "<div class='modal-footer'>";
                                            echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";

                                            // Modal untuk setiap baris dengan persetujuan "Pending"
                                            echo "<div class='modal fade' id='pendingModal" . $row["id_fpk"] . "' tabindex='-1' role='dialog' aria-labelledby='pendingModalLabel' aria-hidden='true'>";
                                            echo "<div class='modal-dialog' role='document'>";
                                            echo "<div class='modal-content'>";
                                            echo "<div class='modal-header'>";
                                            echo "<h5 class='modal-title' id='pendingModalLabel'>Detail Pending</h5>";
                                            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                                            echo "<span aria-hidden='true'>&times;</span>";
                                            echo "</button>";
                                            echo "</div>";
                                            echo "<div class='modal-body'>";
                                            // Tambahkan detail yang relevan di sini
                                            echo "<p>Persetujuan Depthead: " . $row["persetujuanUser"] . " | " . $row["namaUser"] . " | " . $row["tglUser"] . "</p>";
                                            echo "<p>Persetujuan HR Unit: " . $row["persetujuanAdmin"] . " | " . $row["namaAdmin"] . " | " . $row["tglAdmin"] . "</p>";
                                            echo "<p>Persetujuan Direksi (1): " . $row["persetujuanAtasan"] . " | " . $row["namaAtasan"] . " | " . $row["tglAtasan"] . "</p>";
                                            echo "<p>Persetujuan Direksi (2): " . $row["persetujuanDireksi2"] . " | " . $row["namaDireksi2"] . " | " . $row["tglDireksi2"] . "</p>";
                                            echo "<p>Persetujuan Direksi (3): " . $row["persetujuanDireksi3"] . " | " . $row["namaDireksi3"] . " | " . $row["tglDireksi3"] . "</p>";
                                            echo "<p>Persetujuan Presdir: " . $row["persetujuanPresdir"] . " | " . $row["namaPresdir"] . " | " . $row["tglPresdir"] . "</p>";
                                            echo "<p>Persetujuan Corp HR: " . $row["persetujuanCorpHr"] . " | " . $row["namaCorpHr"] . " | " . $row["tglCorpHr"] . "</p>";
                                            echo "<p>Persetujuan Super Admin: " . $row["persetujuanSuperadmin"] . " | " . $row["namaSuperadmin"] . " | " . $row["tglSuperadmin"] . "</p>";
                                            // Dan seterusnya sesuai kebutuhan
                                            echo "</div>";
                                            echo "<div class='modal-footer'>";
                                            echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>Tidak ada data yang tersedia</td></tr>";
                                    }

                                    // Menutup koneksi database
                                    $connection->close();
                                    ?>
                                    <script>
                                        function printFPK(id) {
                                            // Tambahkan nilai id_fpk ke URL
                                            var url = 'print_format.php?id_fpk=' + id;

                                            // Lakukan permintaan AJAX untuk mendapatkan konten dari print_format.php dengan id_fpk di URL
                                            $.ajax({
                                                url: url,
                                                method: 'GET',
                                                success: function(response) {
                                                    // Buat jendela cetak baru dengan konten dari print_format.php
                                                    var printContents = response;
                                                    var originalContents = document.body.innerHTML;
                                                    document.body.innerHTML = printContents;
                                                    // Cetak jendela
                                                    window.print();
                                                    // Kembalikan konten asli ke halaman
                                                    document.body.innerHTML = originalContents;
                                                },
                                                error: function(xhr, status, error) {
                                                    // Tangani error jika terjadi
                                                    console.error(xhr.responseText);
                                                    alert('Terjadi kesalahan saat mencetak.');
                                                }
                                            });
                                        }
                                    </script>
                                </tbody>


                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .custom-button {
        color: white;
        /* Warna teks putih */
        font-size: 45px;
        /* Ukuran font 20px */
        background-color: transparent;
        /* Hapus latar belakang */
        border: none;
        /* Hapus border */
        /* Hapus padding */
    }

    .custom-button:hover {
        background-color: transparent;
        /* Hapus efek hover */
        color: white;
        /* Warna teks putih saat dihover */
    }
</style>
<?php
// Modal untuk setiap baris
include('koneksi.php');
$sql = "SELECT * FROM fpk";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='modal fade' id='detailModal" . $row["id_fpk"] . "' tabindex='-1' role='dialog' aria-labelledby='detailModalLabel' aria-hidden='true'>";
        echo "<div class='modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered' role='document'>";
        echo "<div class='modal-content' style='border-radius: 15px;'>";
        echo "<div class='modal-header' style='background-color: #007BFF; z-index: 1050;'>";
        echo "<h5 class='modal-title text-white' id='detailModalLabel'>Detail Request FPK</h5>";
        echo "<button type='button' class='close custom-button' data-dismiss='modal' aria-label='Close'>";
        echo "<span aria-hidden='true'>&times;</span>";
        echo "</button>";
        echo "</div>";
        echo "<div class='modal-body'>";
        echo "<div class='row'>";
        echo "<div class='col-md-6'>";
        echo "<table class='table' style='margin-top: -40px'>";
        echo "<tr><td colspan='2'>&nbsp;</td></tr>";
        echo "<tr><th colspan='2' style='text-align: center;'>Detail Permintaan</th></tr>";
        echo "<tr><td colspan='2'>&nbsp;</td></tr>";
        echo "<tr>";
        echo "<th>Kode</th>";
        echo "<td>" . $row["kodeFPK"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Nama</th>";
        echo "<td>" . $row["NamaFPK"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>bisnis</th>";
        echo "<td>" . $row["namaUnit"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>organisasi</th>";
        echo "<td>" . $row["organisasi"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>golongan</th>";
        echo "<td>" . $row["golongan"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>jabatan</th>";
        echo "<td>" . $row["jabatan"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Jenis Permintaan</th>";
        echo "<td>" . $row["requestType"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Tanggal Permintaan</th>";
        echo "<td>" . $row["effectiveDate"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>reason</th>";
        echo "<td>" . $row["reason"] . "</td>";
        echo "</tr>";
        echo "</table>";
        echo "</div>";
        echo "<div class='col-md-6'>";
        echo "<table class='table' style='margin-top: -40px'>";
        echo "<tr><td colspan='2'>&nbsp;</td></tr>";
        echo "<tr><th colspan='2' style='text-align: center;'>Kualifikasi Karyawan Pengganti</th></tr>";
        echo "<tr><td colspan='2'>&nbsp;</td></tr>";
        echo "<tr>";
        echo "<th>gender</th>";
        echo "<td>" . $row["gender"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>age</th>";
        echo "<td>" . $row["age"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>experience</th>";
        echo "<td>" . $row["experience"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>education</th>";
        echo "<td>" . $row["education"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>major</th>";
        echo "<td>" . $row["major"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>jobDescription</th>";
        echo "<td>" . $row["jobDescription"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>softSkills</th>";
        echo "<td>" . $row["softSkills"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>hardSkills</th>";
        echo "<td>" . $row["hardSkills"] . "</td>";
        echo "</tr>";
        // Tambahkan baris lain untuk detail lainnya
        echo "</table>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "<div class='modal-footer'>";
        echo "<button type='button' class='btn btn-danger reject-btn' data-id='" . $row["id_fpk"] . "'>Reject <svg xmlns='http://www.w3.org/2000/svg' width='1.2em' height='1.2em' viewBox='0 0 36 36'>
        <rect width='36' height='36' fill='none' />
        <path fill='currentColor' d='M24.879 2.879A3 3 0 1 1 29.12 7.12l-8.79 8.79a.125.125 0 0 0 0 .177l8.79 8.79a3 3 0 1 1-4.242 4.243l-8.79-8.79a.125.125 0 0 0-.177 0l-8.79 8.79a3 3 0 1 1-4.243-4.242l8.79-8.79a.125.125 0 0 0 0-.177l-8.79-8.79A3 3 0 0 1 7.12 2.878l8.79 8.79a.125.125 0 0 0 .177 0z' />
    </svg></button>";
        // Menambahkan tombol Reject
        echo "<button type='button' class='btn btn-primary approve-btn' data-id='" . $row["id_fpk"] . "' data-persetujuanuser='" . $row["persetujuanUser"] . "'>Approve <svg xmlns='http://www.w3.org/2000/svg' width='1.2em' height='1.2em' viewBox='0 0 24 24'>
        <rect width='24' height='24' fill='none' />
        <g fill='none' fill-rule='evenodd'>
            <path d='M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z' />
            <path fill='currentColor' d='M21.546 5.111a1.5 1.5 0 0 1 0 2.121L10.303 18.475a1.6 1.6 0 0 1-2.263 0L2.454 12.89a1.5 1.5 0 1 1 2.121-2.121l4.596 4.596L19.424 5.111a1.5 1.5 0 0 1 2.122 0' />
        </g>
    </svg></button>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
}
?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('.detail-btn').click(function() {
            // Menemukan modal yang sesuai dengan tombol detail yang ditekan dan menampilkannya
            var modalId = $(this).data('target');
            $(modalId).modal('show');
        });
    });

    $(document).ready(function() {
        $('.modal').on('hidden.bs.modal', function() {
            location.reload(); // Melakukan reload halaman setelah menutup modal
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });

    $('#toggler').click(function() {
        $('#sidebar').toggleClass('active');
    });
</script>
<script>
    // Fungsi untuk menyetujui persetujuan
    $('.approve-btn').click(function() {
        var id = $(this).data('id'); // Mendapatkan ID FPK dari tombol yang ditekan
        var button = $(this); // Simpan konteks tombol

        // Lakukan permintaan AJAX untuk mengupdate kolom persetujuan di tabel
        $.ajax({
            url: 'update_persetujuan.php',
            method: 'POST',
            data: {
                id: id
            },
            success: function(response) {
                // Tampilkan alert ketika update berhasil
                alert('Persetujuan berhasil disetujui.');
                // Tutup modal setelah diklik OK pada alert
                $('#detailModal' + id).modal('hide');

                // Simpan nilai persetujuansuperadmin dari tombol
                var persetujuanSuperadmin = button.data('persetujuansuperadmin');

                // Jika persetujuan HR Unit disetujui, tambahkan tanggal hari ini ke field tglSuperadmin
                if (persetujuanSuperadmin === 'Disetujui') {
                    // Mendapatkan tanggal hari ini
                    var today = new Date();
                    var year = today.getFullYear();
                    var month = String(today.getMonth() + 1).padStart(2, '0');
                    var day = String(today.getDate()).padStart(2, '0');
                    var tanggalSuperadmin = year + '-' + month + '-' + day;

                    // Lakukan permintaan AJAX untuk menyimpan tanggalSuperadmin
                    $.ajax({
                        url: 'simpan_tanggal_superadmin.php',
                        method: 'POST',
                        data: {
                            id: id,
                            tanggalSuperadmin: tanggalSuperadmin
                        },
                        success: function(response) {
                            // Tampilkan alert ketika tanggalSuperadmin berhasil disimpan
                            alert('Tanggal berhasil disimpan.');
                        },
                        error: function(xhr, status, error) {
                            // Tangani error jika terjadi saat menyimpan tanggalSuperadmin
                            console.error(xhr.responseText);
                            alert('Terjadi kesalahan saat menyimpan tanggal.');
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                // Tangani error jika terjadi
                console.error(xhr.responseText);
                alert('Terjadi kesalahan saat menyetujui persetujuan.');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Fungsi untuk menolak persetujuan
        $('.reject-btn').click(function() {
            var id = $(this).data('id'); // Mendapatkan ID FPK dari tombol yang ditekan

            // Lakukan permintaan AJAX untuk mengupdate kolom persetujuan di tabel
            $.ajax({
                url: 'reject_persetujuan.php', // Ganti dengan nama file PHP yang sesuai
                method: 'POST',
                data: {
                    id: id
                },
                success: function(response) {
                    // Tampilkan alert ketika update berhasil
                    alert('Persetujuan tidak disetujui.');
                    // Tutup modal setelah diklik OK pada alert
                    $('#detailModal' + id).modal('hide');
                },
                error: function(xhr, status, error) {
                    // Tangani error jika terjadi
                    console.error(xhr.responseText);
                    alert('Terjadi kesalahan saat menolak persetujuan.');
                }
            });
        });
    });
</script>

</html>