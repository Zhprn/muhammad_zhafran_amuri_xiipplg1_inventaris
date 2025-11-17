<?php 
$hostname = "localhost";
$username = "root";
$password = "";
$db_name = "muhammad_zhafran_amuri_xiipplg1_inventaris";

$koneksi = mysqli_connect($hostname, $username, $password, $db_name);
if(!$koneksi){
    die("Koneksi Gagal: ".mysqli_connect_error());
}

?>