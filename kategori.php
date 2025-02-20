<?php
include 'connect.php';
session_start();

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$query = "SELECT * FROM kategori";
if (!empty($search)) {
    $query .= " WHERE kategori LIKE '%$search%'";
}

$result = mysqli_query($conn, $query);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <style>
    .floating-buttons a {
        text-decoration: none; 
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .floating-buttons a {
        position: fixed;
        bottom: 20px;
        right: 20px;
    }
    .floating-buttons a {
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
                <a class="navbar-brand m-2" href="riwayat.php">Riwayat</a>
                <form class="d-flex mx-auto" method="GET" action="kategori.php">
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari kategori" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
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
            <h3 class="mt-4">Daftar Kategori</h3>
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $query = mysqli_query($conn, "SELECT * FROM kategori");
                        
                        if (mysqli_num_rows($result) > 0) {
                            while ($data = mysqli_fetch_array($result)) {
                        ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($data['kategori']); ?></td>
                                    <td>
                                        <a href="kategori_ubah.php?id=<?= $data['id_kategori']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="kategori_hapus.php?id=<?= $data['id_kategori']; ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                           Hapus
                                        </a>
                                    </td>
                                </tr>
                        <?php
                        }
                        } else {
                        ?>
                            <tr>
                                <td colspan="3" class="text-center">Kategori tidak ditemukan</td>
                            </tr>
                        <?php
                        }
                        ?>
                        
                    </tbody>
                </table>
            </div>
            <div class="floating-buttons">
                <a class="add" href="kategori_tambah.php">➕</a>
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>