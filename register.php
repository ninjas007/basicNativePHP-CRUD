<?php 
// hubungkan dulu ke halaman functions
require 'functions.php';

// jika tombol registrasi di tekan maka
// jalankan fungsi registrasi yang bernilai form post user yang diinput tadi
// jika ada data yang diinput maka query data bernilai 1 dan jika dibandingkan dengan angka nol maka cetak alert
// selain dari itu cetak mysqli errornya yg nilainya adalah variabel $conn yang dari functions.
if(isset($_POST['register'])){

	if(register($_POST) > 0){
		echo '<script>
				alert("user baru berhasil ditambahkan!");
				window.location = "index.php";
			 </script>';
	} else {
		echo mysqli_error($conn);
	}
}


?>

<!DOCTYPE html>
<html>
	<head>
		<title>Halaman Register</title>
		<style>
			table{
				background-color: green;

				padding : 10px;
			}
		</style>
	</head>
	<body>
		<h1>Halaman Registrasi</h1>
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
				<tr>
					<td><label for="password2">Konfirmasi Password</label></td>
					<td><input type="password" name="password2" id="password2"></td>
				</tr>
			</table>
			<br>
	
			<button type="submit" name="register">Registrasi</button>
			<a href="login.php" style="text-decoration: none; color: black;">Kembali Login</a>
			
		</form>
	</body>
</html>