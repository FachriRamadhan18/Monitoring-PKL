<?php
// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "monitoring_pkl";

//koneksi ke database
$conn = mysqli_connect('localhost', 'root', '', 'monitoring_pkl') or die ('koneksi gagal');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
// login.php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $status = $_POST['status'];

    if ($status !== 'Pembimbing' && $status !== 'Admin') {
        echo "Status tidak valid!";
        exit;
    }

    if ($status == 'Pembimbing') {
        $sql = "SELECT * FROM pembimbing WHERE Nama = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        }
        
        if ($status == 'Admin') {
        $sql = "SELECT * FROM login WHERE email = ? AND password = ? AND status = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email,$password, $status);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        $_SESSION['email'] = $email;
        $_SESSION['status'] = $status;
        if ($status == 'Pembimbing') {
                $_SESSION['id_pembimbing'] = $user['id_pembimbing'];
                header("Location: ../halaman_pembimbing/halaman_pembimbing.php");
        } else {
                header("Location: ../3)data_siswa/data_siswa.php");
        }
            exit;
    } else {
        echo "Pengguna tidak ditemukan!";
    }
    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="halaman_login.css">
</head>
<body>

    <div class="login-container">
        <header>
            <h1>Login Pembimbing</h1>
        </header>
        <form method="post">
            <div class="form-group">
                <label for="email">Nama :</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">NIP :</label>
                <input type="text" id="password" name="password" required>
            </div>
            <div class="form-group status">
                <label for="status">Status :</label>
                <select name="status" id="" class="status">
                    <option value="Pembimbing">Pembimbing</option>
                </select>
            </div><br>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
            <div class="link">
                <p class="pp">Halaman Login Siswa :</p>
                <a href="../3)data_siswa/data_siswa.php">Login Siswa</a>
            </div>
        </form>
    </div>
    
</body>
</html>
