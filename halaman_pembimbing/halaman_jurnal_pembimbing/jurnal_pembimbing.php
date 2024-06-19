<?php
session_start();

// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "monitoring_pkl";

// Koneksi ke database
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah id_siswa ada di URL
if (!isset($_GET['id_siswa'])) {
    echo "ID Siswa tidak ditemukan!";
    exit();
}

$id_siswa = $_GET['id_siswa'];


// Query untuk mengambil data jurnal berdasarkan id_siswa
$sql = "SELECT * FROM jurnal WHERE id_siswa = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$result = $stmt->get_result();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jurnal PKL</title>
    <link rel="stylesheet" href="jurnal_pembimbing.css">
</head>
<body>
<div class="container">
    <h2>Jurnal PKL</h2>
    <table>
        <thead>
            <tr>
                <th>ID Jurnal</th>
                <th>ID Siswa</th>
                <th>Kehadiran</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Dokumentasi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_jurnal']); ?></td>
                        <td><?php echo htmlspecialchars($row['id_siswa']); ?></td>
                        <td><?php echo htmlspecialchars($row['kehadiran']); ?></td>
                        <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                        <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                        <td><?php echo htmlspecialchars($row['dokumentasi']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Tidak ada data jurnal untuk siswa ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table><br>
    <div class="link">
         <p class="pp">Kembali Ke Halaman Pembimbing :</p>
         <a href="../halaman_pembimbing.php">Halaman Pembimbing</a>
    </div>
</div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
