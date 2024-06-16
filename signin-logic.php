<?php
// Assuming session_start() is called before this code snippet.

require 'config/database.php';

if (isset($_POST['submit'])) {
    $username_email = mysqli_real_escape_string($conn, $_POST['username_email']);
    $password = $_POST['password'];

    if (empty($username_email)) {
        $_SESSION['signin'] = 'Username or Email required';
    } elseif (empty($password)) {
        $_SESSION['signin'] = 'Password required';
    } else {
        $fetch_user_query = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
        $fetch_user_result = mysqli_query($conn, $fetch_user_query);

        if (!$fetch_user_result) {
            // Handle database query error
            $_SESSION['signin'] = 'Error fetching user';
        } elseif (mysqli_num_rows($fetch_user_result) == 1) {
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['password'];

            if (password_verify($password, $db_password)) {
                $_SESSION['user-id'] = $user_record['id'];
                if ($user_record['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }
                header('location: ' . ROOT_URL . 'index.php');
                exit();
            } else {
                $_SESSION['signin'] = 'Incorrect password';
            }
        } else {
            $_SESSION['signin'] = 'User not found';
        }
    }

    // Store form data in session for repopulating the form
    $_SESSION['signin-data'] = $_POST;
    header('location: ' . ROOT_URL . 'signin.php');
    exit();
} else {
    // Redirect to signin.php if 'submit' is not set
    header('location: ' . ROOT_URL . 'signin.php');
    exit();
}
?>
