// ambil elemen yg dibutuhkan
// masukkan kedalam variabel
var keyword = document.getElementById('keyword');
var tombolCari = document.getElementById('tombol-cari');
var container = document.getElementById('container');

keyword.addEventListener('keyup', function(){
	
	// xmlhttprequest sperti class yg udah jadi
	// buat objek ajax
	// masukkan dalam variabel biasa xhr atau ajax
	var xhr = new XMLHttpRequest();

	// cek kesiapan ajax
	// dengan memanggil method dalam xmlhttprequest
	// kemudian jalankan function
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200){
			// ambil container yg didalam HTML 
			// dan isi dengan nilai yg ada didalam sumber data
			container.innerHTML = xhr.responseText;
		}
	}

	// eksekusi ajax | cetak
	// parameter 1 = request method, 2 = sumber datanya(file), 3 = TRUE ini mengacu Asynchrounous
	// ketika keyword diketik ambil dta dari siswa dan kirim data keyword yang diketik
	xhr.open('GET', 'ajax/siswa.php?keyword='+ keyword.value , true);
	xhr.send();


});

