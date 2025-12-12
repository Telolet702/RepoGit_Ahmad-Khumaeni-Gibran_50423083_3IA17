<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Daftar Akun</h2>
        <form action="proses.php" method="POST">
            <input type="text" name="username" placeholder="Username Baru" required autocomplete="off">
            <input type="password" name="password" placeholder="Password Baru" required>
            <button type="submit" name="register" style="background: #00b894;">DAFTAR SEKARANG</button>
        </form>
        <a href="login.php" class="link">Sudah punya akun? Login</a>
    </div>
</body>
</html>