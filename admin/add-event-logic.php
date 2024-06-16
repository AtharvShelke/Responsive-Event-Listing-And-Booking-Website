<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    session_start();
    $admin_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $event_date = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
    $event_time = filter_var($_POST['time'], FILTER_SANITIZE_STRING);
    $total_seats = filter_var($_POST['tseats'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    $is_featured = $is_featured == 1 ? 1 : 0;

    // Validate inputs
    if (empty($title)) {
        $_SESSION['add-event'] = 'Enter event title';
    } elseif (empty($category_id)) {
        $_SESSION['add-event'] = "Select post category";
    } elseif (empty($body)) {
        $_SESSION["add-event"] = "Enter event body";
    } elseif (empty($event_date)) {
        $_SESSION["add-event"] = "Enter event date";
    } elseif (empty($event_time)) {
        $_SESSION["add-event"] = "Enter event time";
    } elseif (empty($total_seats) || $total_seats <= 0) {
        $_SESSION["add-event"] = "Enter a valid number of total seats";
    } elseif (empty($thumbnail['name'])) {
        $_SESSION['add-event'] = "Choose post thumbnail";
    } else {
        $time = time();
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        $allowed_extensions = ['jpg', 'png', 'jpeg'];
        $extension = strtolower(pathinfo($thumbnail_name, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowed_extensions)) {
            $_SESSION['add-event'] = "File should be png, jpg, or jpeg";
        } elseif ($thumbnail['size'] > 2_000_000) {
            $_SESSION['add-event'] = 'File size too big.';
        } elseif (!move_uploaded_file($thumbnail['tmp_name'], $thumbnail_destination_path)) {
            $_SESSION['add-event'] = 'Error uploading file.';
        } else {
            // Set is_featured to 0 for all other posts if the new post is featured
            if ($is_featured == 1) {
                $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
                $zero_all_is_featured_result = mysqli_query($conn, $zero_all_is_featured_query);
                if (!$zero_all_is_featured_result) {
                    $_SESSION['add-event'] = 'Error updating featured posts.';
                }
            }

            $query = "INSERT INTO posts (title, body, thumbnail, category_id, admin_id, is_featured, post_date, post_time, total_seats) 
                      VALUES ('$title', '$body', '$thumbnail_name', $category_id, $admin_id, $is_featured, '$event_date', '$event_time', $total_seats)";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $_SESSION["add-event-success"] = "New post added successfully";
                header('location: ' . ROOT_URL . 'admin/dashboard.php');
                die();
            } else {
                $_SESSION['add-event'] = 'Error adding new post.';
            }
        }
    }

    // Redirect to the add-event.php page if there's an error
    $_SESSION["add-event-data"] = $_POST;
    header('location: ' . ROOT_URL . 'admin/add-event.php');
    die();
}

// Redirect to the add-event.php page if there's no POST request
header('location: ' . ROOT_URL . 'admin/add-event.php');
die();
?>
