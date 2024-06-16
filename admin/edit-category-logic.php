<?php
require 'config/database.php';
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$name || !$description) {
        $_SESSION['edit-category'] = "Invalid form input on edit location page";
    } else {
        $query = "UPDATE locations SET name = '$name', description='$description' WHERE id = $id LIMIT 1";
        $result = mysqli_query($conn, $query);

        if (mysqli_errno($conn)) {
            $_SESSION["edit-category"] = "Couldn't update category";
        } else {
            $_SESSION["edit-category-success"] = "Categories $name Updated Successfully";
        }
    }
}
header('location: ' . ROOT_URL . 'admin/manage-categories.php');
die();
?>