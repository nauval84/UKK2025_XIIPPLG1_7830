<?php
include 'connect.php';
session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <h1 class="mt-4">Kategori Tugas</h1>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form method="post">
                        <?php
                            if (isset($_POST['submit'])) {
                                if (!isset($_SESSION['user']['id_user'])) {
                                    echo '<script>alert("Anda harus login terlebih dahulu!");</script>';
                                } else {
                                    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
                                    $id_user = $_SESSION['user']['id_user']; 

                                    $query = mysqli_query($conn, "INSERT INTO kategori (kategori, id_user) VALUES ('$kategori', '$id_user')");

                                    if ($query) {
                                        echo '<script>alert("Tambah data berhasil."); location.href="kategori.php"</script>';
                                    } else {
                                        echo '<script>alert("Tambah data gagal. ' . mysqli_error($conn) . '");</script>';
                                    }
                                }
                            }

                        ?>
                        <div class="row mb-3">
                            <div class="col-md-2">Nama Kategori</div>
                            <div class="col-md-8"><input type="text" name="kategori" class="form-control" required></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <a href="kategori.php" class="btn btn-danger">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>