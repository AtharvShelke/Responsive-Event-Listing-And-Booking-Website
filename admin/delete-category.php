<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);


    $update_query = "UPDATE posts SET category_id=$id";
    $update_result = mysqli_query($conn, $update_query);
    if(!mysqli_errno($conn)){
        $query = "DELETE FROM locations WHERE id=$id LIMIT 1";
        $result = mysqli_query($conn, $query); 
        $_SESSION['delete-location-success'] = 'Location Deleted Successfully';
    }


    $query = "DELETE FROM locations WHERE id=$id LIMIT 1";
    $result = mysqli_query($conn, $query);
    $_SESSION['delete-location-success'] = 'Location Deleted Successfully';
}
header('location: ' . ROOT_URL .'admin/manage-categories.php');
