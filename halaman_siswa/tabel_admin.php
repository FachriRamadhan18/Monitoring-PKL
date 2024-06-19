<?php
session_start();
include "koneksi.php";

// Hapus data
if (isset($_GET['delete'])) {
    $type = $_GET['type'];
    $id = $_GET['id'];
    if ($type == 'jurnal') {
        $sql = "DELETE FROM jurnal WHERE id_jurnal=$id";
    } elseif ($type == 'laporan') {
        $sql = "DELETE FROM laporan WHERE id=$id";
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
    if ($type == 'jurnal') {
        $tanggal = $_POST['tanggal'];
        $deskripsi = $_POST['deskripsi'];
        $kehadiran = $_POST['kehadiran'];
        $dokumentasi = $_POST['dokumentasi'];
        $sql = "UPDATE jurnal SET tanggal='$tanggal', deskripsi='$deskripsi', kehadiran='$kehadiran', dokumentasi='$dokumentasi' WHERE id_jurnal=$id";
    } elseif ($type == 'laporan') {
        $link_laporan = $_POST['link_laporan'];
        $sql = "UPDATE laporan SET link_laporan='$link_laporan' WHERE id=$id";
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
    <title>Form Data Jurnal dan Laporan PKL</title>
    <link rel="stylesheet" href="tabel_admin.css">
</head>
<body>
<h1>Halaman Siswa</h1>

<h2>Form Data Jurnal PKL</h2>
<form method="POST" action="tambah.php">
    <input type="hidden" name="type" value="jurnal">
    <label>ID Siswa:</label>
    <input type="text" name="id_siswa" required><br>
    <label>Kehadiran:</label>
    <select name="kehadiran" required>
        <option value="izin">Izin</option>
        <option value="sakit">Sakit</option>
        <option value="hadir">Hadir</option>
        <option value="alfa">Alfa</option>
    </select><br>
    <label>Tanggal:</label>
    <input type="date" name="tanggal" required><br>
    <label>Deskripsi:</label>
    <textarea name="deskripsi" rows="4" cols="50" required></textarea><br>
    <label>Dokumentasi:</label>
    <input type="text" name="dokumentasi"><br>
    <input type="submit" value="Tambah">
</form>

<h2>Form Data Laporan PKL</h2>
<form method="POST" action="tambah.php">
    <input type="hidden" name="type" value="laporan">
    <label>ID Siswa:</label>
    <input type="text" name="id_siswa" required><br>
    <label>Link Laporan:</label>
    <input type="text" name="link_laporan" required><br>
    <input type="submit" value="Tambah">
</form>

<h2>Data Jurnal PKL</h2>
<table border="1">
    <tr>
        <th>ID Siswa</th>
        <th>Kehadiran</th>
        <th>Tanggal</th>
        <th>Deskripsi</th>
        <th>Dokumentasi</th>
        <th>Aksi</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM jurnal");
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id_siswa']}</td>
            <td>{$row['kehadiran']}</td>
            <td>{$row['tanggal']}</td>
            <td>{$row['deskripsi']}</td>
            <td>{$row['dokumentasi']}</td>
            <td>
                <a href='?edit=true&type=jurnal&id={$row['id_jurnal']}'>Edit</a>
                <a href='?delete=true&type=jurnal&id={$row['id_jurnal']}'>Hapus</a>
            </td>
        </tr>";
        $i++;
    }
    ?>
</table>

<h2>Data Laporan PKL</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Link Laporan</th>
        <th>ID Siswa</th>
        <th>Aksi</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM laporan");
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td><a href='{$row['link_laporan']}'>Lihat Laporan</a></td>
            <td>{$row['id_siswa']}</td>
            <td>
                <a href='?edit=true&type=laporan&id={$row['id']}'>Edit</a>
                <a href='?delete=true&type=laporan&id={$row['id']}'>Hapus</a>
            </td>
        </tr>";
        $i++;
    }
    ?>
</table>

<?php
// Form edit data
if (isset($_GET['edit'])) {
    $type = $_GET['type'];
    $id = $_GET['id'];
    if ($type == 'jurnal') {
        $result = $conn->query("SELECT * FROM jurnal WHERE id_jurnal=$id");
        $data = $result->fetch_assoc();
        echo "
        <h2>Edit Data Jurnal PKL</h2>
        <form method='POST' action=''>
            <input type='hidden' name='type' value='jurnal'>
            <input type='hidden' name='id' value='$id'>
            <label>Tanggal:</label>
            <input type='date' name='tanggal' value='{$data['tanggal']}' required><br>
            <label>Deskripsi:</label>
            <textarea name='deskripsi' rows='4' cols='50' required>{$data['deskripsi']}</textarea><br>
            <label>Kehadiran:</label>
            <select name='kehadiran' required>
                <option value='izin' " . ($data['kehadiran'] == 'izin' ? 'selected' : '') . ">Izin</option>
                <option value='sakit' " . ($data['kehadiran'] == 'sakit' ? 'selected' : '') . ">Sakit</option>
                <option value='hadir' " . ($data['kehadiran'] == 'hadir' ? 'selected' : '') . ">Hadir</option>
                <option value='alfa' " . ($data['kehadiran'] == 'alfa' ? 'selected' : '') . ">Alfa</option>
            </select><br>
            <label>Dokumentasi:</label>
            <input type='text' name='dokumentasi' value='{$data['dokumentasi']}' required><br>
            <input type='submit' name='edit' value='Simpan'>
        </form>";
    } elseif ($type == 'laporan') {
        $result = $conn->query("SELECT * FROM laporan WHERE id=$id");
        $data = $result->fetch_assoc();
        echo "
        <h2>Edit Data Laporan PKL</h2>
        <form method='POST' action=''>
            <input type='hidden' name='type' value='laporan'>
            <input type='hidden' name='id' value='$id'>
            <label>Link Laporan:</label>
            <input type='text' name='link_laporan' value='{$data['link_laporan']}' required><br>
            <input type='submit' name='edit' value='Simpan'>
        </form>";
    }
}
?>
<br><br>
<div class="link">
    <p class="pp">Kembali Ke Halaman Login :</p><br>
    <a href="../2)halaman_login/halaman_login.php">Halaman Login</a>
</div>

</body>
</html>
