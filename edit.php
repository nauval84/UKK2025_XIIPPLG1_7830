<?php
include 'connect.php';
session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <h1 class="mt-4">Edit Tugas</h1>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    // Ambil ID dari parameter URL
                    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                        echo '<script>alert("ID tidak valid!"); location.href="index.php";</script>';
                        exit;
                    }

                    $id = intval($_GET['id']);

                    // Ambil data tugas dari database
                    $query = mysqli_query($conn, "SELECT * FROM tugas WHERE id_tugas = $id");
                    $data = mysqli_fetch_array($query);

                    if (!$data) {
                        echo '<script>alert("Data tidak ditemukan!"); location.href="index.php";</script>';
                        exit;
                    }

                    if (isset($_POST['submit'])) {
                        $tugas = mysqli_real_escape_string($conn, $_POST['tugas']);
                        $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);

                        if (!empty($tugas) && !empty($id_kategori)) {
                            $update_query = "UPDATE tugas SET tugas='$tugas', id_kategori='$id_kategori' WHERE id_tugas=$id";
                            $result = mysqli_query($conn, $update_query);

                            if ($result) {
                                echo '<script>alert("Edit data berhasil."); location.href="index.php";</script>';
                            } else {
                                echo '<script>alert("Edit data gagal. ' . mysqli_error($conn) . '");</script>';
                            }
                        } else {
                            echo '<script>alert("Mohon lengkapi semua data.");</script>';
                        }
                    }
                    ?>
                    <form method="post">
                        <div class="row mb-3">
                            <div class="col-md-2">Kategori</div>
                            <div class="col-md-8">
                                <select name="id_kategori" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php
                                        $kategori_query = mysqli_query($conn, "SELECT * FROM kategori");
                                        while ($kategori = mysqli_fetch_array($kategori_query)) {
                                            $selected = ($kategori['id_kategori'] == $data['id_kategori']) ? 'selected' : '';
                                            echo "<option value='{$kategori['id_kategori']}' $selected>{$kategori['kategori']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2">Tugas</div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="tugas" value="<?php echo htmlspecialchars($data['tugas']); ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <a href="index.php" class="btn btn-danger">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
