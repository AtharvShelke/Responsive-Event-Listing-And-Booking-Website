<?php
require 'config/database.php';

if(isset($_SESSION['user-id'])){
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $avatar = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Multipage Blog Website</title>

    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>

<body>
    <nav>
        <div class="container nav__container">
            <a href="<?=ROOT_URL?>" class="nav__logo">EventMania</a>
            <ul class="nav__items">
                <li><a href="<?=ROOT_URL?>events.php">Events</a></li>
                <li><a href="<?=ROOT_URL?>about.php">About</a></li>
                <li><a href="<?=ROOT_URL?>services.php">Services</a></li>
                <li><a href="<?=ROOT_URL?>contact.php">Contact</a></li>
                
                <?php if(isset($_SESSION['user-id'])): ?>
                <li class="nav__profile">
                    <div class="avatar">
                        <img src="<?= ROOT_URL . 'images/'.$avatar['avatar']?>" alt="">
                    </div>
                    <ul>
                        <li><a href="<?=ROOT_URL?>admin/dashboard.php">Dashboard</a></li>
                        <li><a href="<?=ROOT_URL?>logout.php">LogOut</a></li>
                    </ul>
                </li>
                <?php else: ?>
                    <li><a href="<?=ROOT_URL?>signin.php">Sign In</a></li>
                <?php endif ?>
            </ul>

            <button id="open__nav-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" id="menu">
                    <path fill="#fff" d="M3 6a1 1 0 0 1 1-1h16a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1zm0 6a1 1 0 0 1 1-1h16a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1zm1 5a1 1 0 1 0 0 2h16a1 1 0 1 0 0-2H4z">
                    </path>
                </svg></button>
            <button id="close__nav-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" id="close">
                    <path fill="#fff" d="M7.05 7.05a1 1 0 0 0 0 1.414L10.586 12 7.05 15.536a1 1 0 1 0 1.414 1.414L12 13.414l3.536 3.536a1 1 0 0 0 1.414-1.414L13.414 12l3.536-3.536a1 1 0 0 0-1.414-1.414L12 10.586 8.464 7.05a1 1 0 0 0-1.414 0Z">
                    </path>
                </svg></button>
        </div>
    </nav>