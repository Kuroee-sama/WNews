<?php
$host = "mysql";       // <--- WAJIB ini, bukan 'localhost'
$user = "root";
$pass = "password";    // samakan dengan MYSQL_ROOT_PASSWORD
$db   = "newsportal";  // atau 'livenews' kalau kamu pilih itu

$con = mysqli_connect($host, $user, $pass, $db);

if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

?>