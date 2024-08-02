<?php
// Lakukan koneksi ke database di sini
// Gantilah parameter koneksi dengan informasi yang sesuai
$koneksi = mysqli_connect("localhost", "alwan", "root", "settings");

// Periksa koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

// Fungsi untuk memeriksa keunikan kode
function isKodeUnique($kode, $koneksi)
{
    $query = "SELECT COUNT(*) as total FROM divisi WHERE nama_kode = '$kode'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] == 0;
}

// ...

// Pada bagian penyimpanan data (save_divisi.php), tambahkan kode untuk memeriksa keunikan kode sebelum menyimpan data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kode = $_POST['nama_kode'];
    $nama_divisi = $_POST['nama_divisi'];

    // Periksa keunikan kode sebelum menyimpan data
    if (!isKodeUnique($nama_kode, $koneksi)) {
        echo "Kode sudah ada dalam database. Harap gunakan kode yang berbeda.";
        exit();
    }

    // Lakukan penyimpanan data jika kode unik
    // ...
}

include('sidebar.php');

?>
<!-- HTML body section -->

<!-- JavaScript section -->
<script>
    function validateForm() {
        var kode = document.getElementById('nama_kode').value;
        var divisi = document.getElementById('nama_divisi').value;
        if (kode == "" || divisi == "") {
            alert("Harap lengkapi semua field!");
            return false; // Mengembalikan false jika validasi gagal
        }
        return true; // Mengembalikan true jika validasi berhasil
    }
</script>

<?php
include('sidebar.php');
?>
<div class="container-content">
    <div class="container" style="margin-top: 80px">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header" style="background-color: #008F4D; color: white;">
                        TAMBAH DIVISI
                    </div>
                    <div class="card-body">
                        <form action="save_divisi.php" method="POST" onsubmit="return validateForm()">
                            <div class="form-group">
                                <label for="nama_kode">Kode</label>
                                <input type="text" id="nama_kode" name="nama_kode" placeholder="Masukkan Kode" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="nama_divisi">Nama Divisi</label>
                                <input type="text" id="nama_divisi" name="nama_divisi" placeholder="Masukkan Nama divisi" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-success">SIMPAN</button>
                            <button type="reset" class="btn btn-warning">RESET</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="container" style="margin-top: 80px">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #008F4D; color: white;">
                            DATA DIVISI
                        </div>
                        <div class="card-body">
                            <!-- <a href="create_divisi.php" class="btn btn-md btn-success mb-3">TAMBAH DATA</a> -->
                            <div class="table-responsive">
                                <table class="table table-bordered" id="myTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">NO.</th>
                                            <th scope="col">KODE</th>
                                            <th scope="col">NAMA DIVISI</th>
                                            <th scope="col">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include('koneksi.php');
                                        $no = 1;
                                        $query = mysqli_query($connection, "SELECT * FROM divisi");
                                        while ($row = mysqli_fetch_array($query)) {
                                        ?>

                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?php echo $row['nama_kode'] ?></td>
                                                <td><?php echo $row['nama_divisi'] ?></td>
                                                <td class="text-center">
                                                    <a href="edit_divisi.php?id=<?php echo $row['id_divisi'] ?>" class="btn btn-sm btn-primary">EDIT</a>
                                                    <a href="delete_divisi.php?id=<?php echo $row['id_divisi'] ?>" class="btn btn-sm btn-danger">HAPUS</a>
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

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });

    $('#toggler').click(function() {
        $('#sidebar').toggleClass('active');
    });
</script>
<script>
    function validateForm() {
        var kode = document.getElementById('nama_kode').value;
        var divisi = document.getElementById('nama_divisi').value;
        if (kode == "" || divisi == "") {
            alert("Harap lengkapi semua field!");
            return false; // Mengembalikan false jika validasi gagal
        }
        return true; // Mengembalikan true jika validasi berhasil
    }
</script>


</html>