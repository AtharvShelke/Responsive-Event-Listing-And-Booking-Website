<?php
    require 'config/database.php';
    if (isset($_GET['id'])) {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT *FROM users WHERE  id = $id";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);

        if(mysqli_num_rows($result) == 1) {
            $avatar_name = $user["avatar"];
            $avatar_path = '../images/'.$avatar_name;
            if($avatar_path){
                unlink($avatar_path);
            }
        }

        $thumbnail_query = "SELECT thumbnail FROM posts WHERE admin_id=$id";
        $thumbnail_result = mysqli_query($conn, $thumbnail_query);
        if(mysqli_num_rows($thumbnail_result) > 0) {
            while($thumbnail = mysqli_fetch_assoc($thumbnail_result)) {
                $thumbnail_path = '../images/' . $thumbnail['thumbnail'];
                if($thumbnail_path){
                    unlink($thumbnail_path);
                }
            }
        }

        $delete_user_query = "DELETE FROM users WHERE id = $id";
        $delete_user_result = mysqli_query($conn, $delete_user_query);
        if(mysqli_errno($conn)){
            $_SESSION["delete-user"] = "Couldn't delete user";
        }else{
            $_SESSION["delete-user-success"] = "User deleted";
        }
    }
header("location: ". ROOT_URL ."admin/manage-users.php");
die();
?>