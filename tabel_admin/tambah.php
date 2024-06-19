<?php
include "koneksi.php";

// Tambah data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    if ($type == 'siswa') {
        $nama = $_POST['nama'];
        $nis = $_POST['nis'];
        $kelas = $_POST['kelas'];
        $jurusan = $_POST['jurusan'];
        $sql = "INSERT INTO siswa (nama, nis, kelas, jurusan) VALUES ('$nama', '$nis', '$kelas', '$jurusan')";
    } elseif ($type == 'pembimbing') {
        $nama = $_POST['nama'];
        $nip = $_POST['nip'];
        $jurusan = $_POST['jurusan'];
        $sql = "INSERT INTO pembimbing (nama, nip, jurusan) VALUES ('$nama', '$nip', '$jurusan')";
    } elseif ($type == 'instansi_pkl') {
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $pembimbing_eksternal = $_POST['pembimbing_eksternal'];
        $sql = "INSERT INTO instansi_pkl (nama, alamat, pembimbing_eksternal) VALUES ('$nama', '$alamat', '$pembimbing_eksternal')";
    }

    if ($conn->query($sql) === TRUE) {
        header('Location: tabel_admin.php');
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}