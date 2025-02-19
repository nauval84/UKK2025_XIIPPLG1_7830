<?php
include 'connect.php';
$id = $_GET['id'];
$query = mysqli_query($conn, "DELETE FROM kategori where id_kategori=$id");
?>
<script>
    alert('hapus data berhasil')
    location.href = "kategori.php"
</script>