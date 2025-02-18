<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}
// Pastikan untuk menyertakan koneksi ke database
require 'database.php';

// Ambil jumlah task, project, dan inbox dari database
$taskCount = $pdo->query("SELECT COUNT(*) FROM task WHERE status = 'proses'")->fetchColumn();
$inboxCount = $pdo->query("SELECT COUNT(*) FROM inbox")->fetchColumn(); // Sesuaikan tabel inbox

// Ambil task untuk hari ini
$currentDate = date('Y-m-d');
$stmt = $pdo->prepare("SELECT judul, deskripsi FROM task WHERE DATE(tgl_deadline) = ?");
$stmt->execute([$currentDate]);
$tasksToday = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HariHebatku</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo">
                <img src="../assets/img/logo.jpg" alt="Logo">
                <h2>HariHebatku</h2>
            </div>
            <nav>
                <ul>
                    <li><a href="add.php"><span class="material-icons-outlined">add_circle</span> Add Task</a></li>
                    <li><a href="inbox.php"><span class="material-icons-outlined">inbox</span> Inbox</a></li>
                    <li class="active"><a href="dashboard.php"><span class="material-icons-outlined">today</span> Today</a></li>
                    <li><a href="upcoming.php"><span class="material-icons-outlined">event</span> Upcoming</a></li>
                    <li><a href="profile.php"><span class="material-icons-outlined">person</span> Profile</a></li>
                </ul>
            </nav>
        </aside>

        <main class="content">
            <div class="stats">
                <!-- Data jumlah task, project, dan inbox -->
                <div class="stat-box">
                    <h3><?php echo $taskCount; ?></h3>
                    <p>Task</p>
                </div>
                <div class="stat-box">
                    <h3><?php echo $inboxCount; ?></h3>
                    <p>Inbox</p>
                </div>
            </div>
            <section class="tasks">
                <h2>Today</h2>
                <!-- Data task dari database -->
                <?php if (!empty($tasksToday)) : ?>
                    <?php foreach ($tasksToday as $task) : ?>
                        <div class="task-card">
                            <h3><?php echo htmlspecialchars($task['judul']); ?></h3>
                            <p><?php echo htmlspecialchars($task['deskripsi']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Tidak ada task untuk hari ini.</p>
                <?php endif; ?>
            </section>
        </main>
    </div>

<script src="../assets/js/sidebar.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>