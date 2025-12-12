<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $check = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username sudah terpakai!'); window.location='register.php';</script>";
    } else {
        mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
        echo "<script>alert('Daftar berhasil! Silakan login.'); window.location='login.php';</script>";
    }
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: index.php");
            exit;
        }
    }
    echo "<script>alert('Username atau Password salah!'); window.location='login.php';</script>";
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['add_task'])) {
    $task = mysqli_real_escape_string($conn, $_POST['task_input']);
    
    if (!empty($task)) {
        mysqli_query($conn, "INSERT INTO tasks (task, user_id) VALUES ('$task', '$user_id')");
    }
    header("Location: index.php");
}

if (isset($_POST['edit_task'])) {
    $id = (int) $_POST['id'];
    $task = mysqli_real_escape_string($conn, $_POST['task_input']);
    
    mysqli_query($conn, "UPDATE tasks SET task = '$task' WHERE id = $id AND user_id = $user_id");
    header("Location: index.php");
}

if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM tasks WHERE id = $id AND user_id = $user_id");
    header("Location: index.php");
}

if (isset($_GET['selesai'])) {
    $id = (int) $_GET['selesai'];
    mysqli_query($conn, "UPDATE tasks SET status = 1 WHERE id = $id AND user_id = $user_id");
    header("Location: index.php");
}
?>