<?php
include 'koneksi.php';

// --- 1. PROSES REGISTER ---
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

    // Cek apakah username sudah ada
    $check = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username sudah terpakai!'); window.location='register.php';</script>";
    } else {
        mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
        echo "<script>alert('Daftar berhasil! Silakan login.'); window.location='login.php';</script>";
    }
}

// --- 2. PROSES LOGIN ---
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        // Cek kecocokan password
        if (password_verify($password, $row['password'])) {
            // Set Session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: index.php");
            exit;
        }
    }
    echo "<script>alert('Username atau Password salah!'); window.location='login.php';</script>";
}

// --- 3. PROSES LOGOUT ---
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// --- CEK LOGIN (Security Gate) ---
// Semua proses di bawah ini butuh login. Jika belum, tendang ke login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil ID user yang sedang login
$user_id = $_SESSION['user_id'];

// --- 4. TAMBAH TUGAS (Create) ---
if (isset($_POST['add_task'])) {
    $task = $_POST['task_input'];
    if (!empty($task)) {
        // Masukkan user_id juga
        mysqli_query($conn, "INSERT INTO tasks (task, user_id) VALUES ('$task', '$user_id')");
    }
    header("Location: index.php");
}

// --- 5. EDIT TUGAS (Update Teks) ---
if (isset($_POST['edit_task'])) {
    $id = $_POST['id'];
    $task = $_POST['task_input']; // Perhatikan: namanya kita samakan dengan form tambah
    
    // Update data
    mysqli_query($conn, "UPDATE tasks SET task = '$task' WHERE id = $id AND user_id = $user_id");
    
    // Kembalikan ke index bersih (tanpa ?edit=...)
    header("Location: index.php");
}

// --- 6. HAPUS TUGAS (Delete) ---
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM tasks WHERE id = $id AND user_id = $user_id");
    header("Location: index.php");
}

// --- 7. TANDAI SELESAI (Update Status) ---
if (isset($_GET['selesai'])) {
    $id = $_GET['selesai'];
    mysqli_query($conn, "UPDATE tasks SET status = 1 WHERE id = $id AND user_id = $user_id");
    header("Location: index.php");
}
?>