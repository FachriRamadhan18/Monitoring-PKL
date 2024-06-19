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

// Cek apakah pembimbing sudah login
if (!isset($_SESSION['id_pembimbing'])) {
    header("Location: ../2)halaman_login/halaman_login.php");
    exit();
}

$id_pembimbing = $_SESSION['id_pembimbing'];

// Define the institution filter based on the id_pembimbing
$institution_filter = "";
if ($id_pembimbing == 4) {
    $institution_filter = "AND instansi_pkl.nama IN ('Kantor Camat','ICT')";
} elseif ($id_pembimbing == 2) {
    $institution_filter = "AND instansi_pkl.nama IN ('PDAM', 'Peternakan')";

}

$sql = "
SELECT
    instansi_pkl.id_instansi,
    instansi_pkl.nama as 'nama_instansi',
    instansi_pkl.alamat,
    instansi_pkl.pembimbing_eksternal,
    siswa.id_siswa,
    siswa.nama as 'nama_siswa',
    siswa.nis,
    siswa.kelas,
    siswa.jurusan,
    pembimbing.id_pembimbing,
    pembimbing.nama as 'nama_pembimbing'
FROM 
    instansi_pkl
JOIN 
    pivot_pkl ON instansi_pkl.id_instansi = pivot_pkl.id_instansi
JOIN 
    siswa ON pivot_pkl.id_siswa = siswa.id_siswa
JOIN
    pembimbing ON pivot_pkl.id_pembimbing = pembimbing.id_pembimbing
WHERE
    pivot_pkl.id_pembimbing = {$id_pembimbing} 
ORDER BY 
    instansi_pkl.id_instansi, siswa.id_siswa;
";

$result = $conn->query($sql);

$instansi_data = [];
$pembimbing_data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $instansi_id = $row['id_instansi'];
        $pembimbing_id = $row['id_pembimbing'];
        if (!isset($instansi_data[$instansi_id])) {
            $instansi_data[$instansi_id] = [
                'nama_instansi' => $row['nama_instansi'],
                'alamat' => $row['alamat'],
                'pembimbing_eksternal' => $row['pembimbing_eksternal'],
                'siswa' => []
            ];
        }
        if (!isset($pembimbing_data[$pembimbing_id])) {
            $pembimbing_data[$pembimbing_id] = $row['nama_pembimbing'];
        }
        $instansi_data[$instansi_id]['siswa'][] = [
            'id_siswa' => $row['id_siswa'],
            'nama_siswa' => $row['nama_siswa'],
            'nis' => $row['nis'],
            'kelas' => $row['kelas'],
            'jurusan' => $row['jurusan']
        ];
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pembimbing</title>
    <link rel="stylesheet" href="halaman_pembimbing.css">
</head>
<body>
<div class="container">

    <div class="header">
        <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['email']); ?></h2>
    </div>
    
    <?php foreach ($instansi_data as $instansi): ?>
        <h3>Instansi: <?php echo htmlspecialchars($instansi['nama_instansi']); ?></h3>
        <p>Alamat: <?php echo htmlspecialchars($instansi['alamat']); ?></p>
        <p>Pembimbing Eksternal: <?php echo htmlspecialchars($instansi['pembimbing_eksternal']); ?></p>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Jurnal PKL</th>
                    <th>Laporan PKL</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $counter = 1; 
                foreach ($instansi['siswa'] as $siswa): ?>                
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo htmlspecialchars($siswa['nama_siswa']); ?></td>
                        <td><?php echo htmlspecialchars($siswa['nis']); ?></td>
                        <td><?php echo htmlspecialchars($siswa['kelas']); ?></td>
                        <td><?php echo htmlspecialchars($siswa['jurusan']); ?></td>
                        <td class="kecili"><a href="./halaman_jurnal_pembimbing/jurnal_pembimbing.php?id_siswa=<?php echo htmlspecialchars($siswa['id_siswa']); ?>&id_pembimbing=<?php echo htmlspecialchars($pembimbing_id); ?>">Jurnal PKL <?php echo htmlspecialchars($siswa['nama_siswa']); ?></a></td>
                        <td class="kecili"><a href="./halaman_laporan_pembimbing/laporan_pembimbing.php?id_siswa=<?php echo htmlspecialchars($siswa['id_siswa']); ?>&id_pembimbing=<?php echo htmlspecialchars($pembimbing_id); ?>">Laporan PKL <?php echo htmlspecialchars($siswa['nama_siswa']); ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</div>
<div class="link">
    <p class="pp">Kembali Ke Halaman Login :</p>
    <a href="logout.php">Halaman Login</a>
</div>
</body>
</html>
