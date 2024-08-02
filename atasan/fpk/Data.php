<?php
session_start();

// Tampilkan kembali data yang disimpan dalam sesi
if (isset($_SESSION['effective_date']) && isset($_SESSION['reason'])) {
    // Gunakan data untuk menampilkan kembali tampilan sebelumnya
    $effective_date = $_SESSION['effective_date'];
    $reason = $_SESSION['reason'];

    // Tampilkan data dalam formulir atau bagian tampilan yang sesuai
} else {
    // Lakukan tindakan standar jika tidak ada data yang tersimpan
}

if (isset($_GET['branch'])) {
    // Ambil nilai branch dari URL
    $branch = $_GET['branch'];
    $userId = $_GET['id'];

    // Lakukan sesuatu dengan nilai branch yang telah diambil, misalnya menyimpannya dalam variabel atau menggunakan nilainya dalam operasi lainnya
    // echo "Nilai branch yang diterima dari URL: " . $branch;
} else {
    // Jika nilai branch tidak ditemukan dalam URL
    echo "Nilai branch tidak ditemukan dalam URL.";
}
?>

<?php
include('sidebar.php');
?>
<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<style>
    /* CSS untuk button di kanan atas */
    .top-left-button {
        position: absolute;
        top: 20px;
        left: 20px;
    }
</style>
<a href="../direksi1.php?id=<?php echo $userId; ?>" class="top-left-button">
    <img src="../img/left-arrow.png" alt="" style="width: 40px; height: 40px; margin: 15px 15px;"></a>

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
                                        <th>ID FPK</th>
                                        <th>Nama</th>
                                        <th>Persetujuan Direksi (1)</th>
                                        <th>Approval</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include('koneksi.php');
                                    $no = 1;

                                    // Ambil nilai "branch" dari URL
                                    $branch = $_GET['branch'];

                                    // Ubah query SQL untuk menambahkan klausul WHERE
                                    $sql = "SELECT fpk.*, persetujuan.Status_Penyetujuan, persetujuan.persetujuanAtasan, persetujuan.persetujuanAdmin FROM fpk LEFT JOIN persetujuan ON fpk.kodeFPK = persetujuan.kodeFPK WHERE fpk.branch = '$branch'";

                                    $result = $connection->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $no++ . "</td>";
                                            echo "<td>" . $row["kodeFPK"] . "</td>";
                                            echo "<td>" . $row["NamaFPK"] . "</td>";
                                            echo "<td>" . $row["persetujuanAdmin"] . "</td>";
                                            // Menentukan warna tombol berdasarkan status persetujuan
                                            $buttonColor = ($row["Status_Penyetujuan"] == "Approved") ? "btn-success" : "btn-danger";

                                            // Menampilkan tombol dengan warna yang sesuai dan menentukan target modal
                                            if ($row["Status_Penyetujuan"] == "Approved") {
                                                echo "<td><button type='button' class='btn $buttonColor detail-btn' data-toggle='modal' data-target='#approvedModal" . $row["id_fpk"] . "'><svg xmlns='http://www.w3.org/2000/svg' width='1.2em' height='1.2em' viewBox='0 0 32 32'>
                                                <rect width='32' height='32' fill='none' />
                                                <path fill='currentColor' d='M30 20a6 6 0 1 0-10 4.46V32l4-1.894L28 32v-7.54A5.98 5.98 0 0 0 30 20m-4 8.84l-2-.947l-2 .947v-3.19a5.9 5.9 0 0 0 4 0ZM24 24a4 4 0 1 1 4-4a4.005 4.005 0 0 1-4 4' />
                                                <path fill='currentColor' d='M25 5h-3V4a2.006 2.006 0 0 0-2-2h-8a2.006 2.006 0 0 0-2 2v1H7a2.006 2.006 0 0 0-2 2v21a2.006 2.006 0 0 0 2 2h9v-2H7V7h3v3h12V7h3v5h2V7a2.006 2.006 0 0 0-2-2m-5 3h-8V4h8Z' />
                                            </svg></button></td>";
                                            } else {
                                                echo "<td><button type='button' class='btn $buttonColor detail-btn' data-toggle='modal' data-target='#pendingModal" . $row["id_fpk"] . "'><svg xmlns='http://www.w3.org/2000/svg' width='1.6em' height='1.4em' viewBox='0 0 21 22'>
                                                <rect width='21' height='22' fill='none' />
                                                <path fill='currentColor' d='M17 12c-2.76 0-5 2.24-5 5s2.24 5 5 5s5-2.24 5-5s-2.24-5-5-5m1.65 7.35L16.5 17.2V14h1v2.79l1.85 1.85zM18 3h-3.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H6c-1.1 0-2 .9-2 2v15c0 1.1.9 2 2 2h6.11a6.743 6.743 0 0 1-1.42-2H6V5h2v3h8V5h2v5.08c.71.1 1.38.31 2 .6V5c0-1.1-.9-2-2-2m-6 2c-.55 0-1-.45-1-1s.45-1 1-1s1 .45 1 1s-.45 1-1 1' />
                                            </svg></button></td>";
                                            }
                                            echo "<td style='white-space: nowrap;'>";
                                            echo "<button type='button' class='btn btn-primary detail-btn center-icon' data-toggle='modal' data-target='#detailModal" . $row["id_fpk"] . "' style='margin-right: 5px;'>
                                               <svg xmlns='http://www.w3.org/2000/svg' width='1.6em' height='1.4em' viewBox='0 0 21 22'>
                                                   <rect width='21' height='22' fill='none' />
                                                   <path fill='currentColor' d='M15 11h7v2h-7zm1 4h6v2h-6zm-2-8h8v2h-8zM4 19h10v-1c0-2.757-2.243-5-5-5H7c-2.757 0-5 2.243-5 5v1zm4-7c1.995 0 3.5-1.505 3.5-3.5S9.995 5 8 5S4.5 6.505 4.5 8.5S6.005 12 8 12' />
                                               </svg>
                                           </button>";

                                        // Tambahkan margin-right di sini
                                            echo "<button type='button' class='btn btn-success print-btn' onclick='printFPK(" . $row["id_fpk"] . ")'><svg xmlns='http://www.w3.org/2000/svg' width='1.2em' height='1.2em' viewBox='0 0 512 512'>
                                            <rect width='512' height='512' fill='none' />
                                            <path fill='currentColor' d='M384 362.7H128V384h256zM106.7 21.3h192V128h106.7v42.7h21.3v-64L320 0H85.3v170.7h21.3V21.3zM448 192H64c-42.7 0-64 21.3-64 64v128h85.3v128h341.3V384H512V256c0-42.7-21.3-64-64-64M85.3 277.3H42.7v-42.7h42.7v42.7zm320 213.4H106.7V341.3h298.7v149.4zM384 405.3H128v21.3h256zm0 42.7H128v21.3h256z' />
                                        </svg></button>";
                                            echo "</td>";
                                            echo "</tr>";

                                            // Modal untuk setiap baris dengan persetujuan "Approved"
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
        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
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
        echo "<td>" . $row["branch"] . "</td>";
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
        echo "<td>" . $row["requestFor"] . "</td>";
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
        echo "<button type='button' class='btn btn-danger reject-btn' data-id='" . $row["id_fpk"] . "'><svg xmlns='http://www.w3.org/2000/svg' width='1.2em' height='1.2em' viewBox='0 0 32 32'>
        <rect width='32' height='32' fill='none' />
        <path fill='currentColor' d='M24.879 2.879A3 3 0 1 1 29.12 7.12l-8.79 8.79a.125.125 0 0 0 0 .177l8.79 8.79a3 3 0 1 1-4.242 4.243l-8.79-8.79a.125.125 0 0 0-.177 0l-8.79 8.79a3 3 0 1 1-4.243-4.242l8.79-8.79a.125.125 0 0 0 0-.177l-8.79-8.79A3 3 0 0 1 7.12 2.878l8.79 8.79a.125.125 0 0 0 .177 0z' />
    </svg></button>";
        // Menambahkan tombol Reject
        echo "<button type='button' class='btn btn-primary approve-btn' data-id='" . $row["id_fpk"] . "' data-persetujuanuser='" . $row["persetujuanUser"] . "'><svg xmlns='http://www.w3.org/2000/svg' width='1.2em' height='1.2em' viewBox='0 0 24 24'>
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

                // Simpan nilai persetujuanAdmin dari tombol
                var persetujuanAtasan = button.data('persetujuanatasan');

                // Jika persetujuan HR Unit disetujui, tambahkan tanggal hari ini ke field tglAdmin
                if (persetujuanAtasan === 'Disetujui') {
                    // Mendapatkan tanggal hari ini
                    var today = new Date();
                    var year = today.getFullYear();
                    var month = String(today.getMonth() + 1).padStart(2, '0');
                    var day = String(today.getDate()).padStart(2, '0');
                    var tanggalAtasan = year + '-' + month + '-' + day;

                    // Lakukan permintaan AJAX untuk menyimpan tanggalAdmin
                    $.ajax({
                        url: 'simpan_tanggal_atasan.php',
                        method: 'POST',
                        data: {
                            id: id,
                            tanggalAtasan: tanggalAtasan
                        },
                        success: function(response) {
                            // Tampilkan alert ketika tanggalAdmin berhasil disimpan
                            alert('Tanggal berhasil disimpan.');
                        },
                        error: function(xhr, status, error) {
                            // Tangani error jika terjadi saat menyimpan tanggalAdmin
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