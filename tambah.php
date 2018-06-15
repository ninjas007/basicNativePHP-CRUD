<?php
session_start();

if (!isset($_SESSION['masuk'])) {
	header("Location: login.php");
	exit;
}
// hubungkan ke functions php
require 'functions.php';
// cek apakah tombol submit sudah ditekan atau belum
// jika di tekan maka lakukan aksi didalamnya
if (isset($_POST["submit"]))
{
	// cek apakah data berhasil di tambahkan atau tidak
	// data didalam form dimasukkan kedalam parameter fungsi tambah
	// ditangkap oleh parameter $data di halaman function
	// nilai nol adalah untuk mengecek query berhasil diinsert atau tidak. 1 untuk berhasil. -1 untuk gagal
	if(tambah($_POST) > 0)

	{
		echo "
			<script>
				alert('data berhasil ditambahkan');
				document.location.href = 'index.php';
			</script>
			 ";
	} else {
		echo "<script>
				alert('data gagal ditambahkan');
				document.location.href = 'tambah.php';
			</script>";
	}
}


?>
<!DOCTYPE html>
<html>
	<head>
		<title>Tambah Data</title>
	</head>
	<body style="font-family: arial; "> <h1 align="left">Tambah Data Siswa</h1>
		
		<!-- pada saat halaman ini di submit maka form action memproses data dihalaman ini sendiri dengan metode post -->
		<!-- kemudian isi dari form tadi di submit ke fungsi (php) tambah di atas? -->
		<form action="" method="post" enctype="multipart/form-data">
			<table cellpadding="10" cellspacing="20"; style="text-align: left; background-color: lightblue;" >
				<th colspan="3" align="center" style="background-color: lightgreen;">Masukkan Data Siswa</th>
				<tr>
					<td><label for="nis">NIS</label></td>
					<td><input type="number" name="nis" id="nis" required></td>
				</tr>
				<tr>
					<td><label for="nama">Nama</label></td>
					<td><input type="text" name="nama" id="nama" required></td>
				</tr>
				<tr>
					<td><label for="email">Email</label></td>
					<td><input type="email" name="email" id="email"></td>
				</tr>
				<tr>
					<td><label for="jurusan">Jurusan</label></td>
					<td><input type="text" name="jurusan" id="jurusan" required></td>
				</tr>
				<tr>
					<td><label for="gambar">Gambar</label></td>
					<td><input type="file" name="gambar" id="gambar"></td>
				</tr>
			</table>
			<br>
			<button type="submit" name="submit">Tambah Data</button>
			<a href="index.php" style="color: black; text-decoration: none;">Kembali</a>
		</form>
		
	</body>
</html>