<?php
// set session
session_start();
// konek ke database
require "functions.php";
// cek dulu cookienya karena jika browser di close cookie mengecek dulu expirednya
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
	// buat dulu variabel id untuk membandingkan nantinya dengan id di database
	$id = $_COOKIE['id'];
	$key = $_COOKIE['key'];
	// ambil username didatabase berdasarkan id
	$hasil = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
	// ambil data dengan fetch dari hasil query username masukkan ke dalam variabel row
	// disini dipastikan bahwa $row itu isinya username yg berdasarkan idnya
	$row = mysqli_fetch_assoc($hasil);
	// cek username dan cookie
	if ($key === hash('sha256', $row['username'])){
		// jika benar maka masuk ke login
		$_SESSION["masuk"] = true;
	}
	
}
// jika sessionnya sudah diset maka redirect ke index
if (isset($_SESSION["masuk"])) {
	header("Location: index.php");
	exit;
}
if (isset($_POST["login"])){
	// masukkan dulu data username name dan password ke dalam variabel dari post user
	$username = $_POST["username"];
	$password = $_POST["password"];
	// ambil dulu data usernamenya dari database
	// kalau ada masukkan ke dalam variable hasil
	$hasil = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

	// cek usernamenya
	// mysqli_num_rows berfungsi untuk menghitung ada berapa baris yg dikembalikan dari query select diatas
	// kalau ada username didalam tabel user pasti 1
	// kalau tidak ada nilainya pasti 0
	if (mysqli_num_rows($hasil) === 1)
	{
		// kalau ada cek password dulu
		$row = mysqli_fetch_assoc($hasil);
		// parameter dibawah string dari ketikan user
		// dan string dari database berdasarkan username yg di query diatas
		if (password_verify($password, $row['password']))
		{
			// set session
			$_SESSION["masuk"] = true;
			// cek remember me
			if (isset($_POST['remember'])) {
				// cara buat cookie lebih aman
				// buat 2 cookie dengan nama yg disamarkan, nilainya adalah mengambil dari id tabel user database
				setcookie('id', $row['id'], time()+60);
				// cookie kedua ini adalah username yg nilainya dari tabel user juga tapi di hash biar teracak
				setcookie('key', hash(sha256, $row['username']), time()+120);
			}
			header("Location: index.php");
			exit;
		}
	}

	$error = true;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Halaman Login</title>
	</head>
	<body>
		<h1>Halaman Login</h1>
		<?php if (isset($error)) :?>
		<p style="color: red; font-style: italic;">username atau password salah</p>
		<?php endif; ?>
		<form action="" method="post">
			<table>
				<tr>
					<td><label for="username">Username</label></td>
					<td><input type="text" name="username" id="username"></td>
				</tr>
				<tr>
					<td><label for="password">Password</label></td>
					<td><input type="password" name="password" id="password"></td>
				</tr>
			</table>
			<br>
			<input type="checkbox" name="remember" id="remember">
			<label for="remember">Remember Me</label>
			<br>
			<button type="submit" name="login">Login</button>
		</form>
	</body>
</html>