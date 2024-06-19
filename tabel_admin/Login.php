<?php
session_start();
$error = '';

// Verifikasi login
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ganti dengan cara yang aman untuk menyimpan password
    $admin_username = 'Fadil';
    $admin_password = '456'; // Ganti dengan password yang lebih aman
    

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: tabel_admin.php');
        exit;
    } else {
        $error = 'Username atau password salah.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
    <div class="login-container">
        <h2>Login Admin</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <span class="error"><?php echo $error; ?></span><br>
            <input type="submit" name="submit" value="Login">
        </form>
    </div>
</body>
</html>