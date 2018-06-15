<?php
session_start();

if (!isset($_SESSION['masuk'])) {
	header("Location: login.php");
	exit;
}
// hubungkan ke functions php
require 'functions.php';
// ambil data dulu di url yang dikirim dari index tadi
	$id = $_GET["id"];
	$ssw = query("SELECT * FROM siswa WHERE id = $id")[0];
// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"]))
{
	
	// cek apakah data berhasil diubah atau tidak
	// data didalam form dimasukkan kedalam parameter fungsi ubah
	// ditangkap oleh parameter $data di halaman function
	// nilai nol adalah untuk mengecek query berhasil diinsert atau tidak. 1 untuk berhasil. -1 untuk gagal
	if(ubah($_POST) > 0)
	{
		echo "
<script>
	alert('data berhasil diubah');
	document.location.href = 'index.php';
</script>
";
} else {
echo "<script>
		alert('data gagal diubah');
		document.location.href = 'index.php';
</script>";
}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Ubah Data</title>
	</head>
	<body style="font-family: arial; "> <h1 align="left">Ubah Data Siswa</h1>
		
		<!-- pada saat halaman ini di submit maka form action memproses data dihalaman ini sendiri dengan metode post -->
		<!-- kemudian isi dari form tadi di submit ke fungsi (php) tambah di atas? -->
		<form action="" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?= $ssw["id"]; ?>">
			<input type="hidden" name="gambarLama" value="<?= $ssw["gambar"]; ?>">
			<table cellpadding="5" cellspacing="5"; style="text-align: left; background-color: lightblue;" >
				<th colspan="3" align="center" style="background-color: lightgreen;">UbahData Siswa</th>
				<tr>
					<td><label for="nis">NIS</label></td>
					<td><input type="text" name="nis" id="nis" required autocomplete="off" value="<?= $ssw["nis"]; ?>"></td>
				</tr>
				<tr>
					<td><label for="nama">Nama</label></td>
					<td><input type="text" name="nama" id="nama" required autocomplete="off" value="<?= $ssw["nama"]; ?>"></td>
				</tr>
				<tr>
					<td><label for="email">Email</label></td>
					<td><input type="email" name="email" id="email" required autocomplete="off" value="<?= $ssw["email"]; ?>"></td>
				</tr>
				<tr>
					<td><label for="jurusan">Jurusan</label></td>
					<td><input type="text" name="jurusan" id="jurusan" required autocomplete="off" value="<?= $ssw["jurusan"]; ?>"></td>
				</tr>
				<tr>
					<td><label for="gambar">Gambar</label></td>
					<td><input type="file" name="gambar" id="gambar"></td>
				</tr>
				<tr><td><img src="images/<?= $ssw['gambar']; ?>" width="50"></td></tr>
			</table>
			<br>
			<button type="submit" name="submit">Ubah Data</button>
			<a href="index.php" style="color: black; text-decoration: none;">Kembali</a>
		</form>
		
	</body>
</html>