<?php
include 'conn.php';

if(isset($_GET['wisid'])) {
    $id=$_GET['wisid'];

    $sql="DELETE FROM `users_elearn` WHERE id=$id";
    $result=mysqli_query($conn, $sql);
    if ($result) {
        header('Location: crud.php');
    } else {
        die(mysqli_error($conn));
    }
}
?>