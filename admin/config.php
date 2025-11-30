<?php
define('DB_SERVER','localhost'); // Host MySQL. "localhost" = server ada di mesin yang sama.
define('DB_USER','root');        // Username MySQL (XAMPP/WAMP default sering 'root').
define('DB_PASS' ,'');           // Password MySQL (sering kosong di lokal; JANGAN di produksi).
define('DB_NAME','livenews');    // Nama database yang akan dipakai.

$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
// Membuka koneksi ke MySQL (MySQLi, gaya prosedural).
// Urutan param: host, user, password, nama_db.
// Hasilnya resource/objek koneksi di $con, dipakai semua query.

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// Jika gagal konek, tampilkan pesan error (baik untuk debug lokal, buruk untuk produksi).
?>
