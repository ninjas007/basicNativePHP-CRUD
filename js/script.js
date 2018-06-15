// kalau documentnya sudah ready masuk ke function
// ready nya ditandai dengan script yg diakses di index
$(document).ready(function(){

	// event ketika keyword ditulis
	// cari elemen berupa id keyword dan lakukan event(on)
	// keyup ketika tombol ditekan jalankan function
	// cari elemen container dan load(ubah isinya) ambil dari file siswa.php dan kirimkan nilai keywordnya
	// intinya ada di fungsi load yang mengganti container

	$('#keyword').on('keyup', function()
	{
		$('#container').load('ajax/siswa.php?keyword=' + $('#keyword').val());

		var pagination = $('#pagination')[0];
		if ($('#keyword').val() === '') {
			pagination.style.display = 'block';
		} else {
			pagination.style.display = 'none';
		}	
	});

});


