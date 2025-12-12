<?php
include 'koneksi.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// --- LOGIKA EDIT MODE ---
$edit_mode = false;
$data_edit = null;

// Jika ada ?edit=ID di URL, berarti user mau ngedit
if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    // Ambil data tugas yang mau diedit
    $query_edit = mysqli_query($conn, "SELECT * FROM tasks WHERE id = $id_edit AND user_id = $user_id");
    
    // Jika data ditemukan, aktifkan mode edit
    if (mysqli_num_rows($query_edit) > 0) {
        $edit_mode = true;
        $data_edit = mysqli_fetch_assoc($query_edit);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>My Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <div class="user-info">
            <span>USER: <b><?php echo $_SESSION['username']; ?></b></span>
            <a href="proses.php?logout=true" class="btn-logout">LOGOUT</a>
        </div>

        <h2>My To-Do List</h2>

        <form method="POST" action="proses.php">
            
            <?php if ($edit_mode): ?>
                <input type="hidden" name="id" value="<?php echo $data_edit['id']; ?>">
            <?php endif; ?>

            <div class="input-group">
                <input type="text" name="task_input" 
                       value="<?php echo ($edit_mode) ? $data_edit['task'] : ''; ?>" 
                       placeholder="Misi baru hari ini..." required autocomplete="off">
                
                <?php if ($edit_mode): ?>
                    <button type="submit" name="edit_task" class="add-btn" style="background:orange; color:black;">UPDATE</button>
                    <a href="index.php" class="add-btn" style="background:#555; text-decoration:none; display:flex; align-items:center;">BATAL</a>
                <?php else: ?>
                    <button type="submit" name="add_task" class="add-btn">TAMBAH</button>
                <?php endif; ?>
            </div>
        </form>

        <hr style="border: 1px dashed #333; margin-bottom: 20px;">

        <ul>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM tasks WHERE user_id = '$user_id' ORDER BY id DESC");
            
            while ($row = mysqli_fetch_assoc($result)) {
                $statusClass = ($row['status'] == 1) ? 'task-done' : '';
            ?>
                <li>
                    <span class="<?php echo $statusClass; ?>">
                        <?php echo htmlspecialchars($row['task']); ?>
                    </span>

                    <div class="actions">
                        <?php if ($row['status'] == 0): ?>
                            <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn-edit">[E]</a>
                            <a href="proses.php?selesai=<?php echo $row['id']; ?>" class="btn-done">[V]</a>
                        <?php endif; ?>
                        
                        <a href="proses.php?hapus=<?php echo $row['id']; ?>" class="btn-del" onclick="return confirm('Hapus data?')">[X]</a>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>

</body>
</html>