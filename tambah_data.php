<?php
include 'connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tugas = mysqli_real_escape_string($conn, $_POST['tugas']);
    $prioritas = mysqli_real_escape_string($conn, $_POST['prioritas']);
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);
    $status = "not complete"; 
    $id_user = $_SESSION['user']['id_user']; 

    if (!$id_user) {
        echo "User tidak ditemukan!";
        exit;
    }

    $query = "INSERT INTO tugas (tugas, prioritas, status, id_user, id_kategori) 
    VALUES ('$tugas', '$prioritas', '$status', '$id_user', '$id_kategori')";


    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menambah data: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Tambah Tugas Baru</h2>
        <form action="tambah_data.php" method="POST">
        <div class="row mb-3">
                        <div class="mb-3">Kategori</div>
                            <select name="id_kategori" class="form-control">
                                <option value="" disabled selected>Pilih Kategori</option>
                                <?php
                                    $kategori_query = mysqli_query($conn, "SELECT * FROM kategori");
                                    if ($kategori_query) {
                                        while ($kategori = mysqli_fetch_array($kategori_query)) {
                                            ?>
                                            <option value="<?php echo $kategori['id_kategori']; ?>">
                                                <?php echo $kategori['kategori']; ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>            
            <div class="mb-3">
                <label for="tugas" class="form-label">Tugas</label>
                <input type="text" name="tugas" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="prioritas" class="form-label">Prioritas</label>
                <select name="prioritas" class="form-select" required>
                    <option value="normal">Normal</option>
                    <option value="urgent">Urgent</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
