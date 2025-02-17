<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $email = trim($_POST['email']);
    $telepon = trim($_POST['telepon']);
    $alamat = trim($_POST['alamat']);

    // Validasi input
    if (empty($username) || empty($password) || empty($confirm_password) || empty($email) || empty($telepon) || empty($alamat)) {
        $error = "Semua field harus diisi!";
    } elseif ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    } elseif (!preg_match('/^[0-9]{10,15}$/', $telepon)) {
        $error = "Nomor telepon harus berupa angka 10-15 digit!";
    } else {
        // Cek apakah username sudah ada
        $stmt = $pdo->prepare("SELECT id FROM user WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            $error = "Username sudah digunakan!";
        } else {
            // Simpan user baru
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO user (username, password, email, telepon, alamat) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$username, $hashed_password, $email, $telepon, $alamat]);
            header('Location: login.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="/assets/css/login.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <img src="/assets/img/logo.jpg" alt="Logo" class="logo">
            <h1><b>Register</b></h1>
            <?php if (!empty($error)) {
              echo "<p style:'color:red;'>$error</p>";
            } ?>
            <form method="POST" action="">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan Username" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukan Email" required>
                
                <label for="telepon">Telepon</label>
                <input type="number" id="telepon" name="telepon" placeholder="Masukan Nomor Telepon" required>
                
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" placeholder="Masukan Alamat" required>
                
                <button type="submit">Register</button>
            </form>
        </div>
    </div>
</body>
</html>