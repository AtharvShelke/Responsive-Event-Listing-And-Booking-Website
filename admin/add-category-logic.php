<?php
require 'config/database.php';

if(isset($_POST['submit'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}
    if(!$name){
        $_SESSION['add-category'] = 'Enter Name';
    }else if (!$description) {
        $_SESSION['add-category'] = 'Enter Description';
    }
    if(isset($_SESSION['add-category'])){
        $_SESSION['add-category-data'] = $_POST;
        header('location: ' . ROOT_URL .'admin/add-catogory.php');
        die();
    }else{
        $query = "INSERT INTO locations (name, description) VALUES ('$name', '$description')";
        $result = mysqli_query($conn, $query);
        if(mysqli_errno($conn)){
            $_SESSION["add-category"] = "Couldn't add";
            header('location: '.ROOT_URL .'admin/add-category.php');
            die();
    }else{
        $_SESSION['add-category-success'] = "Location $title added";
        header("location: " .ROOT_URL . "admin/manage-categories.php");
        die();
    }

}

?>