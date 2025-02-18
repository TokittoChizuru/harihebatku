<?php 

session_start();


include 'database.php';

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = $_SESSION['userid'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tgl_deadline = $_POST['tgl_deadline'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("INSERT INTO task (userid, judul, deskripsi, tgl_deadline, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$userid, $judul, $deskripsi, $tgl_deadline, $status]);

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/add.css">
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
                    <li class="active"><a href="add.php"><span class="material-icons-outlined">add_circle</span> Add Task</a></li>
                    <li><a href="inbox.php"><span class="material-icons-outlined">inbox</span> Inbox</a></li>
                    <li><a href="dashboard.php"><span class="material-icons-outlined">today</span> Today</a></li>
                    <li><a href="upcoming.php"><span class="material-icons-outlined">event</span> Upcoming</a></li>
                    <li><a href="profile.php"><span class="material-icons-outlined">person</span> Profile</a></li>
                </ul>
            </nav>
        </aside>

        <div class="content">
            <h2>Tambah Task</h2>
        <form method="POST">
        <label for="judul">Judul Task</label>
    <input type="text" id="judul" name="judul" placeholder="Masukan Judul" required> <!-- Tambahkan name="judul" -->

    <label for="deskripsi">Deskripsi</label>
    <textarea name="deskripsi" id="deskripsi" placeholder="Masukan Deskripsi" required></textarea>

    <label for="tgl-deadline">Tanggal Deadline: </label>
    <input type="datetime-local" id="tgl-deadline" name="tgl_deadline" required>

    <label for="status">Status</label>
    <select name="status" id="status" required>
        <option value="proses">Proses</option>
        <option value="sukses">Sukses</option>
    </select>

    <button type="submit">Tambah Task</button>
        </form>
        </div>
    </div>
<script src="../assets/js/sidebar.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>