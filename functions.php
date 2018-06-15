<?php 
// buat koneksi ke database
// 1. hostnamenya 2.usernamenya 3.paswordnya 4.databasenya
$conn = mysqli_connect("localhost", "root", "root", "phpdasar");

// buat function query data dan masukkan dalam variabel hasil
// nilai dari parameter $query adalah dari variabel $siswa di index.php
function query($query){
	// ini adalah untuk mengakses variabel global
	global $conn;

	// query (ambil) tabel siswa yang dimasukkan ke dalam $result atau hasil
	$result = mysqli_query($conn, $query); 
	// buat variabel untuk menampung fetch data siswa
	$rows = []; 

	// buat perulangan untuk mengambil setiap data siswa 
	// nilai variabelnya(row) adalah fetch data dimana parameternya adalah query tabel siswa ($hasil).
	while ($row = mysqli_fetch_assoc($result)) {

		// masukkan hasil fetch setiap data siswa ke dalam variabel $rows atau isi array $rows dengan hasil array dari fetch data diatas
	    $rows[] = $row; 
	}

	return $rows; // cetak nilai $rows tiap perulangan
}


// parameter data nilainya berasal dari inputan $_POST
function tambah($data)
{
	global $conn;
	// nilai dari variabel dibawah adalah dari inputan form $_POST(user) yg sebelum itu dimasukkan kedalam parameter $data
	$nis = htmlspecialchars($data["nis"]);
	$nama = htmlspecialchars($data["nama"]);
	$email = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);
	
	// jika user memasukkan data yang benar
	// tetap masukkan data tersebut ke dalam database

	//upload gambar dulu
	$gambar = upload();

	if( !$gambar ){
		return false;
	}

	// query (insert) data dan masukkan ke dalam variabel query
	$query = "INSERT INTO siswa VALUES
			 ('', '$nis', '$nama', '$email', '$jurusan', '$gambar')
			 ";

	// masukkan data ke database/ query (insert) data dan masukkan parameternya
	mysqli_query($conn, $query);

	// kembalikan angka jika ada tabel yg berubah didatabase
	return mysqli_affected_rows($conn);

}

function upload()
{
	// buat beberapa variable untuk mengecek file yg diupload
	// $_FILES = superglobal yg mengambil nilai dari form data yg di input
	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$eror = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek dulu apakah ada file gambar yg diupload menggunakan $error

	if ($eror === 4) {
		echo "<script>
				alert('upload gambar terlebih dahulu');
			 </script>";
		return false;
	}

	// cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['png', 'jpeg', 'jpg'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	// in_array adalah buat mengecek ada tidak string di dalam array
	// fungsi in_array akan menghasilkan nilai true jika ada
	if( !in_array($ekstensiGambar, $ekstensiGambarValid)){
		echo "<script>
				alert('yang anda upload bukan gambar');
			 </script>";
		return false;
	}

	// cek jika ukuran gambar terlalu besar
	if($ukuranFile > 100000){
		echo "<script>
				alert('ukuran gambar terlalu besar!');
			 </script>";
		return false;
	}


	// lolos pengecekan dan siap upload
	// upload file dengan fungsi move uploaded
	// $tmpName = tmpat file yg mau diupload yg disini mengacu kepada si user yg diambil dari inputan $_FILES['gambar']['tmp_name'] dan untuk insert ke database tetap menggunakan query yg ada di function tambah
	// paramater keduanya adalah tujuan pemindahan file
	
	// generate file baru dan uniqid = buat bilangan random
	$fileUpload = uniqid();
	// tambahkan titik dan juga ekstensi gambarnya
	$fileUpload .= '.';
	$fileUpload .= $ekstensiGambar;

	move_uploaded_file($tmpName, "images/". $fileUpload);

	return $fileUpload;

}





function hapus($id){
	global $conn; 

	mysqli_query($conn, "DELETE FROM siswa WHERE id = $id");

	return mysqli_affected_rows($conn);
}




function ubah($post){
	global $conn;

	$id = $post["id"];
	$nis = htmlspecialchars($post["nis"]);
	$nama = htmlspecialchars($post["nama"]);
	$email = htmlspecialchars($post["email"]);
	$jurusan = htmlspecialchars($post["jurusan"]);
	$gambarLama = htmlspecialchars($post["gambarLama"]);

	// cek apakah mengubah gambar atau tidak
	// jika tidak ada gambar yang diupload maka dia pasti akan error 4
	// maka dari itu cetak kembali gambar lama
	if ($_FILES["gambar"]["error"] === 4){
		$gambar = $gambarLama;
	} else {
		// selain dari perintah if diatas maka masukkan fungsi upload ke gambar
		// dimana fungsi upload itu sama dengan aksi dihalaman tambah
		$gambar = upload();
	}

	$query = " UPDATE siswa SET
			 -- ambil field(kolom) yg ada dalam database dan ganti --
			 	nis = '$nis',
			 	nama = '$nama',
			 	email = '$email',
			 	jurusan = '$jurusan',
			 	gambar = '$gambar'

			  WHERE id = $id
			 ";
 
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);

}




// buat fungsi cari dan parameter adalah hasil ketikan user di index.php
function cari($keyword){

	$query = "SELECT * FROM siswa WHERE 
				nama LIKE '%$keyword%' OR 
				nis LIKE '%$keyword%' OR 
				jurusan LIKE '%$keyword%'
			 ";

	return query($query);
}





// buat fungsi registrasi yg nilainya akan di kirim ke if dihalaman register
function register($post){
	global $conn;

	$username = strtolower(stripslashes($post["username"]));
	$password = mysqli_real_escape_string($conn, $post["password"]);
	$password2 = mysqli_real_escape_string($conn, $post["password2"]);

	// cek username sudah ada atau belum dengan cara query dari data base
	$hasil = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username' ");

	// jika fungsi ini menghasilkan nilai true maka
	// lakukan aksi didalam bloknya
	if (mysqli_fetch_assoc($hasil)){
		echo "<script>alert('username sudah ada')</script>";

		// berhentikan functionnya biar insertnya gagal dan yg lain ga dijalankan
		return false;
	}

	// cek konfirmasi password
	if ($password !== $password2){
		echo "<script>
				alert('password tidak sesuai');
				
			 </script>";
	return false;
	}

	// enkripsi password
	$passwordEnkripsi = password_hash($password, PASSWORD_DEFAULT);

	// masukkan user baru ke database
	mysqli_query($conn, "INSERT INTO user VALUES ('', '$username','$passwordEnkripsi')");

	// untuk menghasilkan angka 1 jika berhasil dan -1 jika gagal
	// nilai ini dipakai untuk mengecek ketika tombol register diklik
	return mysqli_affected_rows($conn);

}

?>