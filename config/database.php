<?php

    require 'constants.php';
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);
if (mysqli_errno($conn)) {
 die("Connection failed");
}

?>