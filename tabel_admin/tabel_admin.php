<?php
 
include "koneksi.php";

// Hapus data
if (isset($_GET['delete'])) {
    $type = $_GET['type'];
    $id = $_GET['id'];
    if ($type == 'siswa') {
        $sql = "DELETE FROM siswa WHERE id_siswa=$id";
    } elseif ($type == 'pembimbing') {
        $sql = "DELETE FROM pembimbing WHERE id_pembimbing=$id";
    } elseif ($type == 'instansi_pkl') {
        $sql = "DELETE FROM instansi_pkl WHERE id_instansi=$id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
    
// Edit data
if (isset($_POST['edit'])) {
    $type = $_POST['type'];
    $id = $_POST['id'];
    if ($type == 'siswa') {
        $nama = $_POST['nama'];
        $nis = $_POST['nis'];
        $kelas = $_POST['kelas'];
        $jurusan = $_POST['jurusan'];
        $sql = "UPDATE siswa SET nama='$nama', nis='$nis', kelas='$kelas', jurusan='$jurusan' WHERE id_siswa=$id";
        // die(var_dump($_POST));
    } elseif ($type == 'pembimbing') {
        $nama = $_POST['nama'];
        $nip = $_POST['nip'];
        $jurusan = $_POST['jurusan'];
        $sql = "UPDATE pembimbing SET nama='$nama', nip='$nip', jurusan='$jurusan' WHERE id_pembimbing=$id";
    } elseif ($type == 'instansi_pkl') {
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $pembimbing_eksternal = $_POST['pembimbing_eksternal'];
        $sql = "UPDATE instansi_pkl SET nama='$nama', alamat='$alamat', pembimbing_eksternal='$pembimbing_eksternal' WHERE id_instansi=$id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Data Siswa, Pembimbing, dan Instansi PKL</title>
    <link rel="stylesheet" href="tabel_admin.css">
</head>
<body>
<h1>Halaman Admin</h1>

<h2>Form Data Siswa</h2>
<form method="POST" action="tambah.php">
    <input type="hidden" name="type" value="siswa">
    <label>Nama:</label>
    <input type="text" name="nama" required><br>
    <label>Nis:</label>
    <input type="text" name="nis" required><br>
    <label>Kelas:</label>
    <input type="text" name="kelas" required><br>
    <label>Jurusan:</label>
    <input type="text" name="jurusan" required><br>
    <input type="submit" value="Tambah">
</form>

<h2>Form Data Pembimbing</h2>
<form method="POST" action="tambah.php">
    <input type="hidden" name="type" value="pembimbing">
    <label>Nama:</label>
    <input type="text" name="nama" required><br>
    <label>NIP:</label>
    <input type="text" name="nip" required><br>
    <label>Jurusan:</label>
    <input type="text" name="jurusan" required><br>
    <input type="submit" value="Tambah">
</form>

<h2>Form Data Instansi PKL</h2>
<form method="POST" action="tambah.php">
    <input type="hidden" name="type" value="instansi_pkl">
    <label>Nama:</label>
    <input type="text" name="nama" required><br>
    <label>Alamat:</label>
    <input type="text" name="alamat" required><br>
    <label>Pembimbing Eksternal:</label>
    <input type="text" name="pembimbing_eksternal" required><br>
    <input type="submit" value="Tambah">
</form>

<h2>Data Siswa</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>NIS</th>
        <th>Kelas</th>
        <th>Jurusan</th>
        <th>Aksi</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM siswa");
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$i}</td>
            <td>{$row['nama']}</td>
            <td>{$row['nis']}</td>
            <td>{$row['kelas']}</td>
            <td>{$row['jurusan']}</td>
            <td>
                <a href='?edit=true&type=siswa&id={$row['id_siswa']}'>Edit</a>
                <a href='?delete=true&type=siswa&id={$row['id_siswa']}'>Hapus</a>
            </td>
        </tr>";
        $i++;
    }
    ?>
</table>

<h2>Data Pembimbing</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>NIP</th>
        <th>Jurusan</th>
        <th>Aksi</th>
    </tr>
    <?php
    $ff = 1;
    $result = $conn->query("SELECT * FROM pembimbing");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$ff}</td>
            <td>{$row['nama']}</td>
            <td>{$row['nip']}</td>
            <td>{$row['jurusan']}</td>
            <td>
                <a href='?edit=true&type=pembimbing&id={$row['id_pembimbing']}'>Edit</a>
                <a href='?delete=true&type=pembimbing&id={$row['id_pembimbing']}'>Hapus</a>
            </td>
        </tr>";
        $ff++;
    }
    ?>
</table>

<h2>Data Instansi PKL</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Pembimbing Eksternal</th>
        <th>Aksi</th>
    </tr>
    <?php
    $u = 1;
    $result = $conn->query("SELECT * FROM instansi_pkl");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$u}</td>
            <td>{$row['nama']}</td>
            <td>{$row['alamat']}</td>
            <td>{$row['pembimbing_eksternal']}</td>
            <td>
                <a href='?edit=true&type=instansi_pkl&id={$row['id_instansi']}'>Edit</a>
                <a href='?delete=true&type=instansi_pkl&id={$row['id_instansi']}'>Hapus</a>
            </td>
        </tr>";
        $u++;
    }
    ?>
</table>

<?php
// Form edit data
if (isset($_GET['edit'])) {
    $type = $_GET['type'];
    $id = $_GET['id'];
    if ($type == 'siswa') {
        $result = $conn->query("SELECT * FROM siswa WHERE id_siswa=$id");
        $data = $result->fetch_assoc();
        echo "
        <h2>Edit Data Siswa</h2>
        <form method='POST' action=''>
            <input type='hidden' name='type' value='siswa'>
            <input type='hidden' name='id' value='$id'>
            <label>Nama:</label>
            <input type='text' name='nama' value='{$data['nama']}' required><br>
            <label>NIS:</label>
            <input type='text' name='nis' value='{$data['nis']}' required><br>
            <label>Kelas:</label>
            <input type='text' name='kelas' value='{$data['kelas']}' required><br>
            <label>Jurusan:</label>
            <input type='text' name='jurusan' value='{$data['jurusan']}' required><br>
            <input type='submit' name='edit' value='Simpan'>
        </form>";
    } elseif ($type == 'pembimbing') {
        $result = $conn->query("SELECT * FROM pembimbing WHERE id_pembimbing=$id");
        $data = $result->fetch_assoc();
        echo "
        <h2>Edit Data Pembimbing</h2>
        <form method='POST' action=''>
            <input type='hidden' name='type' value='pembimbing'>
            <input type='hidden' name='id' value='$id'>
            <label>Nama:</label>
            <input type='text' name='nama' value='{$data['nama']}' required><br>
            <label>NIP:</label>
            <input type='text' name='nip' value='{$data['nip']}' required><br>
            <label>Jurusan:</label>
            <input type='text' name='jurusan' value='{$data['jurusan']}' required><br>
            <input type='submit' name='edit' value='Simpan'>
        </form>";
    } elseif ($type == 'instansi_pkl') {
        $result = $conn->query("SELECT * FROM instansi_pkl WHERE id_instansi=$id");
        $data = $result->fetch_assoc();
        echo "
        <h2>Edit Data Instansi PKL</h2>
        <form method='POST' action=''>
            <input type='hidden' name='type' value='instansi'>
            <input type='hidden' name='id' value='$id'>
            <label>Nama:</label>
            <input type='text' name='nama' value='{$data['nama']}' required><br>
            <label>Alamat:</label>
            <input type='text' name='alamat' value='{$data['alamat']}' required><br>
            <label>Pembimbing Eksternal:</label>
            <input type='text' name='pembimbing_eksternal' value='{$data['pembimbing_eksternal']}' required><br>
            <input type='submit' name='edit' value='Simpan'>
        </form>";
    }
}
?>
            <br><br>
            <div class="link">
                <p class="pp">Kembali Ke Halaman Login :</p>
                <a href="../2)halaman_login/halaman_login.php">Halaman Login</a>
            </div>

</body>
</html>

<?php $conn->close(); ?>
