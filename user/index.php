<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard Depthead</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<style>
		body {
			background-color: #EAFAF1;
		}

		.card {
			background-color: yellowgreen;
			margin-bottom: 20px;
			height: 190px;
			position: relative;
		}

		h4 {
			color: #008F4D;
			text-align: center;
			margin-top: 30px;
			position: relative;
			/* Tambahkan properti ini agar bisa menempatkan logo di atas judul */
		}

		img.logo {
			max-width: 120px;
			/* Atur lebar maksimum logo */
			position: absolute;
			/* Atur posisi menjadi absolute agar bisa menggunakan left */
			left: 50%;
			/* Posisikan ke tengah horizontal */
			transform: translateX(-50%);
			/* Geser ke kiri sejauh setengah dari lebar gambar */
			top: 10px;
			/* Letakkan logo 10px dari bagian atas */
			z-index: 1;
			/* Pastikan logo berada di depan judul */
		}


		.card-body {
			text-align: center;
			padding: 40px 30px;
			/* Atur padding di sini */
			position: relative;
			/* Tambahkan properti ini untuk mengatur posisi teks */
		}

		.card-icon {
			font-size: 50px;
			color: #007bff;
			z-index: 2;
			/* Pastikan ikon berada di depan logo */
		}

		.card-title {
			margin-top: 10px;
			font-size: 13px;
			/* Kurangi ukuran teks keterangan */
			margin-bottom: 0;
			font-style: italic;
			position: relative;
			/* Tambahkan properti ini untuk mengatur posisi teks */
			z-index: 3;
			/* Pastikan teks berada di depan logo */
		}

		.card-link {
			text-decoration: none;
			color: inherit;
		}

		/* CSS untuk mengatur posisi kartu */
		.container {
			height: 60vh;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.row {
			padding: 50px;
		}

		/* Media queries untuk layout responsif */
		@media (max-width: 768px) {
			.card {
				height: auto;
				/* Set ulang tinggi kartu agar bisa menyesuaikan konten */
			}

			.card img {
				top: -100px;
				/* Atur ulang posisi logo */
				max-width: 100px;
				/* Atur ulang lebar maksimum logo */
				max-height: 100px;
				/* Atur ulang tinggi maksimum logo */
			}

			.card-body {
				padding: 20px 20px;
				/* Atur ulang padding kartu */
			}

			.card-icon {
				font-size: 40px;
				/* Atur ulang ukuran ikon */
			}

			.card-title {
				font-size: 12px;
				/* Atur ulang ukuran teks keterangan */
			}
		}

		/* CSS untuk daftar cabang-cabang */
		.branch-list {
			list-style-type: none;
			padding-top: 10px;
			text-align: center;
			font-size: 20px;
			margin-left: -15px;
		}

		.branch-list li {
			margin-bottom: 5px;
			color: #333;
		}

		.branch-list li:before {
			content: "\2022";
			/* kode untuk bullet (titik) */
			/* warna bullet */
			display: none;
			width: 1em;
		}

		/* Gaya tambahan untuk header */
		.header {
			font-size: 18px;
			font-weight: bold;
			margin-top: 10px;
		}
	</style>
</head>

<body>
	<img src="./img/logo-jababeka.png" alt="Logo" style="width: 10%; display: block; margin: 0 auto; padding-top: 20px;"><!-- Ganti path_to_your_logo dengan path logo Anda -->
	<?php
	include('koneksi.php');

	// Inisialisasi variabel branches
	$branches = '';

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
				echo "<h4>SELAMAT DATANG, <strong> $nama </strong> - <strong> Department Head </strong></h4>";

				// Lakukan kueri ke database untuk mendapatkan cabang dengan nama yang sama
				$queryBranches = "SELECT DISTINCT branch FROM multi_user WHERE nama = '$nama'";
				$resultBranches = $connection->query($queryBranches);

				if ($resultBranches->num_rows > 0) {
					echo "<ul class='branch-list'>"; // Mulai daftar untuk mencetak cabang-cabang
					while ($rowBranch = $resultBranches->fetch_assoc()) {
						// Tambahkan nama cabang ke array
						$branchNames[] = $rowBranch["branch"];
						// Cetak nama cabang dalam daftar
						echo "<li><strong>" . $rowBranch["branch"] . "</strong></li>";
					}
					echo "</ul>"; // Akhiri daftar
				} else {
					echo "<h4><strong> Tidak ada cabang dengan nama yang sama. </strong></h4>";
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
	<a href="ttd.php?id=<?php echo $userId; ?>&branch=<?php echo $branch; ?>" class="card-link" style="position: absolute; top: 20px; right: 20px;">
		<svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 16 16">
			<rect width="14" height="14" fill="none" />
			<path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5v2a1 1 0 0 1-1 1h-2m0-13h2a1 1 0 0 1 1 1v2m-13 0v-2a1 1 0 0 1 1-1h2m0 13h-2a1 1 0 0 1-1-1v-2m6.5-4a2 2 0 1 0 0-4a2 2 0 0 0 0 4m3.803 4.5a3.994 3.994 0 0 0-7.606 0z" />
		</svg>
		<!-- <h5 class="card-title">PROFIL</h5> -->
	</a>
	<!-- Bagian HTML -->
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<a href="./fpk/Data.php?id=<?php echo $userId; ?>" class="card-link">
					<div class="card">
						<div class="card-body">
							<svg xmlns="http://www.w3.org/2000/svg" width="5em" height="5em" viewBox="0 0 45 45">
								<rect width="45" height="45" fill="none" />
								<g fill="currentColor">
									<path d="M17 31v-2h2v2z" />
									<path fill-rule="evenodd" d="M20 4a3 3 0 0 0-3 3h-4a3 3 0 0 0-3 3v31a3 3 0 0 0 3 3h22a3 3 0 0 0 3-3V10a3 3 0 0 0-3-3h-4a3 3 0 0 0-3-3zm-1 3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-8a1 1 0 0 1-1-1zm-3 13a1 1 0 1 0 0 2h7a1 1 0 1 0 0-2zm-1-4a1 1 0 0 1 1-1h15.5a1 1 0 1 1 0 2H16a1 1 0 0 1-1-1m0 12a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1zm13 4a3 3 0 1 0 0-6a3 3 0 1 0 0 6m-6 4.5c0-2.116 3.997-3.182 6-3.182s6 1.066 6 3.182V39H22z" clip-rule="evenodd" />
								</g>
							</svg>
							<h5 class="card-title">APPROVAL FPK</h5>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6">
				<a href="./hc/data_hc.php?id=<?php echo $userId; ?>&branches=<?php echo $branches; ?>" class="card-link">
					<div class="card">
						<div class="card-body">
							<svg xmlns="http://www.w3.org/2000/svg" width="5em" height="5em" viewBox="0 0 24 24">
								<rect width="24" height="24" fill="none" />
								<path fill="currentColor" fill-rule="evenodd" d="M3.464 3.464C2 4.93 2 7.286 2 12c0 4.714 0 7.071 1.464 8.535C4.93 22 7.286 22 12 22c4.714 0 7.071 0 8.535-1.465C22 19.072 22 16.714 22 12s0-7.071-1.465-8.536C19.072 2 16.714 2 12 2S4.929 2 3.464 3.464m7.08 4.053a.75.75 0 1 0-1.087-1.034l-2.314 2.43l-.6-.63a.75.75 0 1 0-1.086 1.034l1.143 1.2a.75.75 0 0 0 1.086 0zM13 8.25a.75.75 0 0 0 0 1.5h5a.75.75 0 0 0 0-1.5zm-2.457 6.267a.75.75 0 1 0-1.086-1.034l-2.314 2.43l-.6-.63a.75.75 0 1 0-1.086 1.034l1.143 1.2a.75.75 0 0 0 1.086 0zM13 15.25a.75.75 0 0 0 0 1.5h5a.75.75 0 0 0 0-1.5z" clip-rule="evenodd" />
							</svg>
							<h5 class="card-title">APPROVAL HC</h5>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
</body>

</html>