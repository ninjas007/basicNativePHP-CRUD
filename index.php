<?php
session_start();
// jika sessionnya belum di set maka kembali ke halaman login
if (!isset($_SESSION['masuk'])) {
	header("Location: login.php");
	exit;
}
// menghubungkan ke functions
require 'functions.php';
// jika tombol cari di klik maka jalankan variabel dibawah
if (isset($_POST["cari"])){
	// parameter fungsi cari ini mengirimkan hasil keyword dari ketikan user ke halaman functions
	$siswa = cari($_POST["keyword"]);
	
	if (!$siswa){
echo '<script>
		alert("data tidak ditemukan");
		window.location= "index.php";
</script>';
}
}
$jumlahTampilanPerHalaman = 3;
$jumlahData = count(query("SELECT * FROM siswa"));
$jumlahHalaman = ceil($jumlahData / $jumlahTampilanPerHalaman);
$halamanTujuan = (isset($_GET['page']) ? $_GET['page'] : 1);
// untuk membuat tampilan data perhalaman gunakan limit
// limit mempunyai 2 nilai yg pertama nilai awalnya, yg keduanya jumlah yg ditampilkan perhalaman

$awalTampilData = ($jumlahTampilanPerHalaman * $halamanTujuan) - $jumlahTampilanPerHalaman;

$siswa = query("SELECT * FROM siswa LIMIT $awalTampilData, $jumlahTampilanPerHalaman");


?>


<!DOCTYPE html>
<html>
	<head>
		<title>Halaman Admin</title>
		
		<!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
		<style type="text/css">
			.kotak{
        background-color: green;
        border: solid;
        padding: 5px;
        color: black; 
        text-decoration: none; 
        margin-left: 5px
    }
		</style>
	</head>

	<body style="font-family: arial">
		<div class="header">
			<h1>Daftar Siswa</h1>
		</div>
		
		<a href="tambah.php" class="kotak">Tambah Data Siswa
		</a>
		<a href="logout.php" class="kotak">Logout
		</a>
		
		<br><br>
		<form action="" method="post">
			<input type="text" name="keyword" size="30" autofocus placeholder="masukkan keyword pencarian..." autocomplete="off" id="keyword">
			
		</form>
		<br>

		<div id="pagination">
		<?php if ($halamanTujuan > 1): ?>
			<a href="?page=<?= $halamanTujuan - 1; ?>"> << </a>
		<?php endif ?>


		<?php for ($i = 1; $i <= $jumlahHalaman; $i++) :?>
			<?php if ($i == $halamanTujuan): ?>
				<a href="?page=<?=$i; ?>" style="color:red; font-style: bold;"><?= $i; ?></a>
			<?php else: ?>
				<a href="?page=<?=$i; ?>"><?= $i; ?></a>
			<?php endif; ?>
		<?php endfor; ?>

		<?php if ($halamanTujuan < $jumlahHalaman): ?>
			<a href="?page=<?= $halamanTujuan + 1; ?>"> >> </a>
		<?php endif ?>
		</div>

		<div id="container">
			<table border="1" cellpadding="10" cellspacing="0" style="text-align: center; background-color: lightblue;">
				<tr style="background-color: lightgreen;">
					<th>No.</th>
					<th>Edit Siswa</th>
					<th>Foto</th>
					<th>NIS</th>
					<th>Nama</th>
					<th>Email</th>
					<th>Jurusan</th>
				</tr>
				<?php $i = 1; ?>
				<?php foreach ($siswa as $row) : ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td>
						<a href="ubah.php?id=<?= $row["id"]; ?>" style="color:black;">ubah</a> |
						<div style="color:black;">
							<a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin ingin menghapus data <?= $row["nama"]; ?>?');" style="color: black;">hapus</a>
						</div>
					</td>
					<td><img src="images/<?= $row['gambar']; ?>" width="50"></td>
					<td><?= $row['nis']; ?></td>
					<td><?= $row['nama']; ?></td>
					<td><?= $row['email']; ?></td>
					<td><?= $row['jurusan']; ?></td>
				</tr>
				<?php $i++; ?>
				<?php endforeach; ?>
			</table>

		</div>
		<a href="cetak.php">Cetak</a>
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/script.js"></script>
		<!-- script type="text/javascript">

		console.log('ifjlksdujlklasdjlasjdlkajsdlkasjdlkasjdlkasjdlkasjdlas')
		var keyword = document.getElementById('keyword');
		var pagination = document.getElementById('pagination');

		keyword.addEventListener('keyup', function(e){
		
		
		if (keyword.value === ''){
			pagination.style.display = 'block';
		} else {
			pagination.style.display = 'none';
		}
		});

		console.log(pagination.style);
		</script> -->
	</body>
</html>

