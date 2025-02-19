<?php
include 'connect.php';
$id = $_GET['id'];
$query = mysqli_query($conn, "DELETE FROM tugas where id_tugas=$id");
?>
<script>
    alert('hapus data berhasil')
    location.href = "index.php"
</script>