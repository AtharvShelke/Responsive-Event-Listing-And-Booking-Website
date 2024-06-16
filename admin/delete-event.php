<?php
require 'config/database.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){
        $post = mysqli_fetch_assoc($result);
        $thumbnail_name = $post["thumbnail"];
        $thumbnail_path = '../images/'.$thumbnail_name;

        if(file_exists($thumbnail_path) && unlink($thumbnail_path)){
            $delete_post_query = "DELETE FROM posts WHERE id=$id LIMIT 1";
            $delete_post_result = mysqli_query($conn, $delete_post_query);

            if($delete_post_result && !mysqli_errno($conn)) {
                $_SESSION['delete-event-success'] = 'Event Deleted Successfully';
            } else {
                $_SESSION['delete-event'] = 'Error deleting event from database.';
            }
        } else {
            $_SESSION['delete-event'] = 'Error deleting thumbnail file.';
        }
    } else {
        $_SESSION['delete-event'] = 'Event not found.';
    }
}

header('location: ' . ROOT_URL . 'admin/dashboard.php');
die();
?>
