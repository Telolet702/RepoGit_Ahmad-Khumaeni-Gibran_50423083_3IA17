<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Hacker Mode</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container auth-container">
        <h2>REGISTER SYSTEM</h2>
        <form action="proses.php" method="POST">
            <input type="text" name="username" placeholder="Username" required autocomplete="off">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register" class="add-btn">DAFTAR</button>
        </form>
        <a href="login.php" class="link-auth">Sudah punya akun? Login di sini</a>
    </div>
</body>
</html>