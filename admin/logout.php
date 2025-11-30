<?php
session_start(); //Mengaktifkan sesi PHP agar sistem bisa mengenali admin yang sudah login.
include("includes/config.php"); //Mengimpor file konfigurasi yang berisi koneksi database.
//Menghapus semua data sesi untuk logout.
$_SESSION['login']==""; 
session_unset(); 
session_destroy(); 
?>
        