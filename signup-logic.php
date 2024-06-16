<?php
    
    require 'config/database.php';




    if (isset($_POST['submit'])) {
        $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $createpassword = filter_var($_POST['create-password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirmpassword = filter_var($_POST['confirm-password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $avatar = $_FILES['avatar'];
        

        if (!$firstname) {
            $_SESSION['signup'] = "Enter Your First Name";
        }
        elseif (!$lastname) {
            $_SESSION['signup'] = "Enter Your Last Name";
        }
        elseif (!$username) {
            $_SESSION['signup'] = "Enter Your UserName";
        }
        elseif (!$email) {
            $_SESSION['signup'] = "Enter Valid Email";
        }
        elseif (strlen($createpassword)<8 || strlen($confirmpassword)<8) {
            $_SESSION['signup'] = "Short Password";
        }
        elseif (!$avatar['name']) {
            $_SESSION['signup'] = "Add Avatar";
        }
        else {
            if ($createpassword !== $confirmpassword) {
                $_SESSION['signup'] = 'Passwords do not match';
            }else{
                $hased_password = password_hash($createpassword, PASSWORD_DEFAULT);
                
                $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
                $user_check_result = mysqli_query($conn, $user_check_query);
                 if (mysqli_num_rows($user_check_result)>0) {
                    $_SESSION['signup'] = "Username or Email already exist";
                 }else{
                    $time = time();
                    $avatar_name = $time.$avatar['name'];
                    $avatar_tmp_name = $avatar['tmp_name'];
                    $avatar_destination_path = 'images/'.$avatar_name;

                    $allowed_files = ['png', 'jpg', 'jpeg'];
                    $extention = explode('.', $avatar_name);
                    $extention = end($extention);
                    if (in_array($extention, $allowed_files)) {
                        if ($avatar['size']<1500000) {
                            move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                        }else {
                            $_SESSION['signup'] = 'File size is too big';
                        }
                    }else{
                        $_SESSION['signup'] = "File should be png, jpg or jpeg";
                    }
                 }
            }
        }
        
        if(isset($_SESSION['signup'])){

            $_SESSION['signup-data'] = $_POST;
            header('location: '.ROOT_URL.'signup.php');
            die();
        }else{
            $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES ('$firstname', '$lastname', '$username', '$email', '$hased_password', '$avatar_name', 0)";

            $insert_user_result = mysqli_query($conn, $insert_user_query);
            if(!mysqli_errno($conn)){
                $_SESSION['signup-success'] = "Registration successful. Log In";
                header('location: '.ROOT_URL.'signin.php');
            }
        }



    }else {
        header('location:'.ROOT_URL.'signup.php');
    }
?>