<?php
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$status_edit = false;
$data_edit = null;

if (isset($_GET['edit'])) {
    $id_edit = (int) $_GET['edit']; 
    $user_id = $_SESSION['user_id'];
    
    $q = mysqli_query($conn, "SELECT * FROM tasks WHERE id = '$id_edit' AND user_id = '$user_id'");
    
    if (mysqli_num_rows($q) > 0) {
        $status_edit = true;
        $data_edit = mysqli_fetch_assoc($q);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tugas Ahmad Khumaeni Gibran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <div style="display:flex; justify-content:space-between; font-size: 13px; margin-bottom: 15px; color: #555;">
            <span>Hai, <b><?php echo $_SESSION['username']; ?></b></span>
            <a href="proses.php?logout=true" style="color: #e74c3c; text-decoration: none; font-weight: bold;">Logout</a>
        </div>

        <h2>Daftar Tugas</h2>

        <form action="proses.php" method="POST">
            <?php if ($status_edit): ?>
                <input type="hidden" name="id" value="<?php echo $data_edit['id']; ?>">
            <?php endif; ?>

            <input type="text" name="task_input" 
                   placeholder="Mau ngerjain apa hari ini?" 
                   value="<?php echo ($status_edit) ? $data_edit['task'] : ''; ?>" required autocomplete="off">
            
            <?php if ($status_edit): ?>
                <button type="submit" name="edit_task" style="background-color: #f1c40f; color: black;">Update Tugas</button>
                <a href="index.php" class="link" style="margin-top:5px;">Batal Edit</a>
            <?php else: ?>
                <button type="submit" name="add_task">Tambah Tugas</button>
            <?php endif; ?>
        </form>

        <hr style="border: 0; border-top: 1px dashed #ccc; margin: 20px 0;">

        <ul>
            <?php
            $user_id = $_SESSION['user_id'];
            $result = mysqli_query($conn, "SELECT * FROM tasks WHERE user_id = '$user_id' ORDER BY id DESC");
            
            while ($row = mysqli_fetch_assoc($result)) {
                $cssClass = ($row['status'] == 1) ? 'done' : '';
            ?>
                <li>
                    <span class="<?php echo $cssClass; ?>">
                        <?php echo htmlspecialchars($row['task']); ?>
                    </span>

                    <div style="min-width: 100px; text-align: right;">
                        <?php if ($row['status'] == 0): ?>
                            <a href="proses.php?selesai=<?php echo $row['id']; ?>" class="btn-action" style="color:#00b894;">✓</a>
                            <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn-action" style="color:#f1c40f;">✎</a>
                        <?php endif; ?>
                        <a href="proses.php?hapus=<?php echo $row['id']; ?>" class="btn-action" style="color:#e74c3c;" onclick="return confirm('Yakin hapus?')">✗</a>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>

</body>
</html>