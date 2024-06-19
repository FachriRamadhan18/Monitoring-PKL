<?php
// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "monitoring_pkl";

//koneksi ke database
$conn = mysqli_connect('localhost', 'root', '', 'monitoring_pkl') or die ('koneksi gagal');


// Proses login jika form dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];

    // Query untuk memeriksa apakah data siswa ada di database
    $sql = "SELECT * FROM siswa WHERE nama = ? AND nis = ? AND kelas = ? AND jurusan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nama, $nis, $kelas, $jurusan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Data siswa valid, simpan sesi dan arahkan ke halaman dashboard
        $_SESSION['nama'] = $nama;
        $_SESSION['nis'] = $nis;
        $_SESSION['kelas'] = $kelas;
        $_SESSION['jurusan'] = $jurusan;
        header("Location: ../halaman_siswa/tabel_admin.php");
        exit();
    } else {
        // Data siswa tidak valid, kembali ke halaman login dengan pesan error
        $_SESSION['error'] = "Data siswa tidak valid. Silakan coba lagi.";
        header("Location: ");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa</title>
    <link rel="stylesheet" href="data_siswa.css">
</head>
<body>
    <?php if (!isset($_SESSION['id_siswa'])): ?>
    <div class="login-container">
        <header>
            <h1>Login Siswa</h1>
        </header>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="nama">Nama :</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="nis">NIS :</label>
                <input type="text" id="nis" name="nis" required>
            </div>
            <div class="form-group">
                <label for="kelas">Kelas :</label>
                <input type="text" id="kelas" name="kelas" required>
            </div>
            <div class="form-group">
                <label for="jurusan">Jurusan :</label>
                <input type="text" id="jurusan" name="jurusan" required>
            </div>
            <div class="form-group buttons">
                <button type="submit">Login</button>
            </div>
            <div class="link">
                <p class="pp">Halaman Login Pembimbing :</p>
                <a href="../2)halaman_login/halaman_login.php">Login Pemibimbing</a>
            </div>
        </form>
    </div>
    <?php else: ?>
    <div class="container">
        <header>
            <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama']); ?></h1>
        </header>
        <p>NIS: <?php echo htmlspecialchars($_SESSION['nis']); ?></p>
        <p>Kelas: <?php echo htmlspecialchars($_SESSION['kelas']); ?></p>
        <p>Jurusan: <?php echo htmlspecialchars($_SESSION['jurusan']); ?></p>
        <div class="form-group buttons">
            <a href="jurnal_pkl.php?id_siswa=<?php echo $_SESSION['id_siswa']; ?>"><button>Jurnal PKL</button></a>
            <a href="laporan_pkl.php?id_siswa=<?php echo $_SESSION['id_siswa']; ?>"><button>Laporan PKL</button></a>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>
