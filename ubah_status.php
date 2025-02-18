<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "SELECT status FROM tugas WHERE id_tugas = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    $new_status = ($row['status'] == 'complete') ? 'not complete' : 'complete';

    $update_query = "UPDATE tugas SET status = '$new_status' WHERE id_tugas = $id";
    if (mysqli_query($conn, $update_query)) {
        header("Location: index.php"); 
        exit;
    } else {
        echo "Gagal mengubah status: " . mysqli_error($conn);
    }
}
?>
