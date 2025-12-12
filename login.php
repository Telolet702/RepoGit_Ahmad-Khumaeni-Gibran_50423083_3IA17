<?php 
include 'koneksi.php'; 
// Jika sudah login, lempar ke index
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Hacker Mode</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container auth-container">
        <h2>ACCESS CONTROL</h2>
        <form action="proses.php" method="POST">
            <input type="text" name="username" placeholder="Username" required autocomplete="off">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="add-btn">LOGIN</button>
        </form>
        <a href="register.php" class="link-auth">Belum punya akses? Daftar dulu</a>
    </div>
</body>
</html>