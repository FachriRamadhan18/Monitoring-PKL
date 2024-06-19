<?php
// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "monitoring_pkl";

//koneksi ke database
$conn = mysqli_connect('localhost', 'root', '', 'monitoring_pkl') or die ('koneksi gagal');
