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

// Query untuk mengambil data laporan berdasarkan id_siswa
$sql = "SELECT * FROM laporan WHERE id_siswa = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan PKL</title>
    <link rel="stylesheet" href="laporan_pembimbing.css">
</head>
<body>
<div class="container">
    <h2>Laporan PKL Siswa</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Siswa</th>
                <th>Link Laporan</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['id_siswa']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($row['link_laporan']); ?>" target="_blank">Lihat Laporan</a></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Tidak ada data laporan untuk siswa ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
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
