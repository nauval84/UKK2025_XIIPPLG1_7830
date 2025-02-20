<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_tugas = intval($_POST['id_tugas']);
    $query = "SELECT * FROM tugas WHERE id_tugas = $id_tugas";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        if ($row['status'] == 'not complete') {
            $update_query = "UPDATE tugas SET status = 'complete' WHERE id_tugas = $id_tugas";
            mysqli_query($conn, $update_query);
        } else {
            $tugas = $row['tugas'];
            $prioritas = $row['prioritas'];
            $insert_query = "INSERT INTO riwayat (tugas, prioritas) VALUES ('$tugas', '$prioritas')";
            mysqli_query($conn, $insert_query);
            $delete_query = "DELETE FROM tugas WHERE id_tugas = $id_tugas";
            mysqli_query($conn, $delete_query);
        }

        header("Location: index.php");
        exit();
    } else {
        echo "Tugas tidak ditemukan.";
    }
}
?>
