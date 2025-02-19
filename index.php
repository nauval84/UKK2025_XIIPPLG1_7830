<?php
include 'connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tugas = mysqli_real_escape_string($conn, $_POST['tugas']);
    $prioritas = mysqli_real_escape_string($conn, $_POST['prioritas']); 
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']); 
    $status = "not complete"; 

    if (!in_array($prioritas, ['normal', 'urgent'])) {
        echo "Prioritas tidak valid!";
        exit;
    }

    $query = "INSERT INTO tugas (tugas, prioritas, status, id_kategori) 
              VALUES ('$tugas', '$prioritas', '$status', '$id_kategori')";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php"); 
        exit;
    } else {
        echo "Gagal menambah data: " . mysqli_error($conn);
    }
}


$query = "SELECT tugas.*, kategori.kategori 
          FROM tugas 
          LEFT JOIN kategori ON tugas.id_kategori = kategori.id_kategori 
          ORDER BY FIELD(prioritas, 'urgent', 'normal'), id_tugas DESC";
$result = mysqli_query($conn, $query);

?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .floating-buttons a {
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: blue;
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        font-size: 20px;
        margin: 5px;
        cursor: pointer;
    }
</style>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h2 class="mb-0">To-Do List</h2>
            <a class="navbar-brand m-2" href="index.php">Home</a>
            <a class="navbar-brand m-2" href="kategori.php">Kategori</a>
            <form class="d-flex mx-auto" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown">
                        <?php echo isset($_SESSION['user']) ? $_SESSION['user']['Username'] : 'Guest'; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-3">
        <h3>Daftar Tugas</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tugas</th>
                    <th>Kategori</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['tugas']) ?></td>
                    <td><?= !empty($row['kategori']) ? htmlspecialchars($row['kategori']) : '<i>Tidak ada</i>' ?></td>
                    <td>
                        <span class="badge bg-<?= $row['prioritas'] == 'urgent' ? 'danger' : 'secondary' ?>">
                            <?= htmlspecialchars($row['prioritas']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="ubah_status.php?id=<?= $row['id_tugas'] ?>" 
                            class="btn btn-<?= $row['status'] == 'complete' ? 'success' : 'warning' ?>">
                            <?= htmlspecialchars($row['status']) ?>
                        </a>
                    </td>

                    <td>
                        <a href="edit.php?id=<?= $row['id_tugas'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?= $row['id_tugas'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
    <div class="floating-buttons">
        <a class="add" href="tambah_data.php">➕</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
