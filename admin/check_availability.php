<?php 
require_once("includes/config.php");            // Memuat file konfigurasi (termasuk koneksi database $con); hanya sekali meski dipanggil berulang.

// code   username availablity
if(!empty($_POST["username"])) {                // Mengecek apakah request POST memiliki field 'username' yang tidak kosong.
	$uname= $_POST["username"];                 // Menyimpan nilai username yang dikirim dari form ke variabel $uname.

$query=mysqli_query($con,"select AdminuserName from tbladmin where AdminuserName='$uname'");		
                                               // Menjalankan query untuk mencari baris pada tabel 'tbladmin' dengan AdminuserName sama dengan $uname.
$row=mysqli_num_rows($query);                  // Menghitung jumlah baris hasil query (berapa user dengan username tersebut yang ditemukan).

if($row>0){                                    // Jika jumlah baris > 0 (username sudah dipakai)
echo "<span style='color:red'> Username already exists. Try with another username</span>";
                                               // Menampilkan pesan berwarna merah bahwa username sudah ada/tidak tersedia.
 echo "<script>$('#submit').prop('disabled',true);</script>";
                                               // Menyisipkan skrip JS untuk menonaktifkan tombol submit pada form (id tombol: #submit).
} else{                                        // Jika jumlah baris = 0 (username belum dipakai)
echo "<span style='color:green'> Username available for Registration .</span>";
                                               // Menampilkan pesan berwarna hijau bahwa username tersedia.
echo "<script>$('#submit').prop('disabled',false);</script>";
                                               // Menyisipkan skrip JS untuk mengaktifkan kembali tombol submit.
}
}
?>                                            // Penutup blok PHP.
