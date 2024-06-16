<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    define('ROOT_URL', 'http://localhost/wt%20project/');
    define('DB_HOST', 'localhost:3307');
    define('DB_USER', 'atharv');
    define('DB_PASSWD', 'atharv964');
    define('DB_NAME', 'events');
?>