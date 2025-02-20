<?php
include 'connect.php';
session_start();

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$query = "SELECT * FROM riwayat";
if (!empty($search)) {
    $query .= " WHERE tugas LIKE '%$search%' OR prioritas LIKE '%$search%'";
}
$query .= " ORDER BY tanggal_selesai DESC";

$result = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h2 class="mb-0">To-Do List</h2>
            <a class="navbar-brand m-2" href="index.php">Home</a>
            <a class="navbar-brand m-2" href="kategori.php">Kategori</a>
            <a class="navbar-brand m-2" href="riwayat.php">Riwayat</a>
            <form class="d-flex mx-auto" method="GET" action="riwayat.php">
                <input class="form-control me-2" type="search" name="search" placeholder="Cari riwayat" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
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
        <h3>Riwayat Tugas</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tugas</th>
                    <th>Prioritas</th>
                    <th>Tanggal Selesai</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)): 
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['tugas']); ?></td>
                        <td><?= htmlspecialchars($row['prioritas']); ?></td>
                        <td><?= $row['tanggal_selesai']; ?></td>
                    </tr>
                <?php 
                    endwhile; 
                } else {
                ?>
                    <tr>
                        <td colspan="4" class="text-center">Data tidak ditemukan</td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>
    </div>
</body>
</html>
