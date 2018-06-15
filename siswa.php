<?php 

require '../functions.php';

$keyword = $_GET['keyword'];

$jumlahTampilanPerHalaman = 3;
$jumlahData = count(query("SELECT * FROM siswa"));
$jumlahHalaman = ceil($jumlahData / $jumlahTampilanPerHalaman);
$halamanTujuan = (isset($_GET['page']) ? $_GET['page'] : 1);
// untuk membuat tampilan data perhalaman gunakan limit
// limit mempunyai 2 nilai yg pertama nilai awalnya, yg keduanya jumlah yg ditampilkan perhalaman

$awalTampilData = ($jumlahTampilanPerHalaman * $halamanTujuan) - $jumlahTampilanPerHalaman;

$query = "SELECT * FROM siswa WHERE 
			nama LIKE '%$keyword%' OR 
			nis LIKE '%$keyword%' OR 
			jurusan LIKE '%$keyword%' LIMIT $awalTampilData, $jumlahTampilanPerHalaman
		 ";

// buat variabel siswa yg isinya fungsi query
$siswa = query($query);

?>

<?php if ($siswa) : ?>
	
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

<?php else :?> 
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
		</table>
		<h2 style="color: red; font-style: bold;">Data Tidak Ditemukan</h2>
<?php endif; ?>