<?php
include "koneksi.php";

// Tambah data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    
    if ($type == 'jurnal') {
        $id_siswa = $_POST['id_siswa'];
        $kehadiran = $_POST['kehadiran'];
        $tanggal = $_POST['tanggal'];
        $deskripsi = $_POST['deskripsi'];
        $dokumentasi = $_POST['dokumentasi'];
        $sql = "INSERT INTO jurnal (id_siswa, kehadiran, tanggal, deskripsi, dokumentasi) 
                VALUES ('$id_siswa', '$kehadiran', '$tanggal', '$deskripsi', '$dokumentasi')";
    } elseif ($type == 'laporan') {
        $id_siswa = $_POST['id_siswa'];
        $link_laporan = $_POST['link_laporan'];
        $sql = "INSERT INTO laporan (id_siswa, link_laporan) 
                VALUES ('$id_siswa', '$link_laporan')";
    }

    if ($conn->query($sql) === TRUE) {
        header('Location: tabel_admin.php');
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
