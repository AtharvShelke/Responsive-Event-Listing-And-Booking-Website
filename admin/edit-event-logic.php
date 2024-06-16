<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'],FILTER_SANITIZE_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    $is_featured = $is_featured == 1 ? 1 : 0;

    if (empty($title)) {
        $_SESSION['edit-event'] = 'Enter event title';
    } elseif (empty($category_id)) {
        $_SESSION['edit-event'] = "Select post category";
    } elseif (empty($body)) {
        $_SESSION["edit-event"] = "Enter event body";
    
    } else {
        if($thumbanil['name']){
            $previous_thumbnail_path = '../images/'.$previous_thumbnail_name;
            if($previous_thumbnail_path){
                unlink($previous_thumbnail_path);
            }
        }


        $time = time();
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        $allowed_extensions = ['jpg', 'png', 'jpeg'];
        $extension = strtolower(pathinfo($thumbnail_name, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowed_extensions)) {
            $_SESSION['edit-event'] = "File should be png, jpg, or jpeg";
        } elseif ($thumbnail['size'] > 2_000_000) {
            $_SESSION['edit-event'] = 'File size too big.';
        } elseif (!move_uploaded_file($thumbnail['tmp_name'], $thumbnail_destination_path)) {
            $_SESSION['edit-event'] = 'Error uploading file.';
        } else {
            
            if ($is_featured == 1) {
                $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
                $zero_all_is_featured_result = mysqli_query($conn, $zero_all_is_featured_query);
                if (!$zero_all_is_featured_result) {
                    $_SESSION['edit-event'] = 'Error updating featured posts.';
                }
            }
            move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            $thumnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;
            $query = "UPDATE posts SET title='$title', body='$body', thumbnail='$thumbanil_to_insert', category_id=$category_id, is_featured=$is_featured WHERE id=$id LIMIT 1";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $_SESSION["edit-event-success"] = "New post edited successfully";
                header('location: ' . ROOT_URL . 'admin/dashboard.php');
                die();
            } else {
                $_SESSION['edit-event'] = 'Error editing new post.';
            }
        }
    }

    // Redirect to the edit-event.php page if there's an error
    $_SESSION["edit-event-data"] = $_POST;
    header('location: ' . ROOT_URL . 'admin/edit-event.php');
    die();
}

// Redirect to the edit-event.php page if there's no POST request
header('location: ' . ROOT_URL . 'admin/edit-event.php');
die();
?>
