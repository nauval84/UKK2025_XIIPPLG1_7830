<?php
include 'connect.php';
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['user'])) {
    echo '<script>alert("Anda harus login terlebih dahulu!"); location.href="login.php";</script>';
    exit;
}

// Ambil data pengguna dari session
$username = $_SESSION['user']['Username'];
$email = $_SESSION['user']['email'];
$foto = 'default.png'; // Gunakan foto default

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-container {
            text-align: center;
            padding: 50px 20px;
            background: linear-gradient(to bottom, #E6DAF0 50%, white 50%);
        }
        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
            margin-top: -50px;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h5><?= htmlspecialchars($username); ?></h5>
        <img src="default.png"<?= $foto; ?>" alt="Foto Profil" class="profile-pic">
        <h4 class="mt-2"><?= htmlspecialchars($username); ?></h4>
        <p class="text-muted"><?= htmlspecialchars($email); ?></p>
    </div>
</body>
</html>
