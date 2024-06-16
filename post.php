<?php
include 'partials/header.php';
session_start(); // Ensure session start for storing booking success message
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $post = mysqli_fetch_assoc($result);
} else {
    header('location: ' . ROOT_URL . 'events.php');
    die();
}

// Handle form submission to book tickets
if (isset($_POST['submit'])) {
    $tickets_to_book = filter_var($_POST['tickets_to_book'], FILTER_VALIDATE_INT);
  
    if ($tickets_to_book < 1) {
        echo "<script>alert('Please enter a valid number of tickets (1 or more).');</script>";
    } else {
        // Check available seats
        $check_query = "SELECT total_seats, booked_seats FROM posts WHERE id = ?";
        $stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $available_seats = mysqli_fetch_assoc($result);
        $remaining_seats = $available_seats['total_seats'] - $available_seats['booked_seats'];

        if ($tickets_to_book > $remaining_seats) {
            echo "<script>alert('Sorry, only $remaining_seats seats are available.');</script>";
        } else {
            // Update booked seats
            $update_query = "UPDATE posts SET booked_seats = booked_seats + ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($stmt, "ii", $tickets_to_book, $id);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $_SESSION['booking_success'] = $tickets_to_book;
                header('location: ' . ROOT_URL . 'booking_success.php');
                exit();
            } else {
                echo "<script>alert('Failed to book tickets.');</script>";
            }
        }
    }
}
?>

<section class="singlepost">
    <div class="container singlepost__container">
        <h2><?= htmlspecialchars($post['title']) ?></h2>
        <div class="post__author">
            <?php
            $author_id = $post['admin_id'];
            $author_query = "SELECT * FROM users WHERE id=$author_id";
            $author_result = mysqli_query($conn, $author_query);
            $author = mysqli_fetch_assoc($author_result);
            ?>
            <div class="post__author-avatar">
                <img src="./images/<?= htmlspecialchars($author['avatar']) ?>" alt="">
            </div>
            <div class="post__author-info">
                <h5>by: <?= htmlspecialchars($author['firstname'] . ' ' . $author['lastname']) ?></h5>
                <small>date: <?= date("M d, Y", strtotime($post['post_date'])) ?></small><br>
                <small>time: <?= date("H:i", strtotime($post['post_time'])) ?></small>
            </div>
        </div>
        <div class="singlepost__thumbnail">
            <img src="./images/<?= htmlspecialchars($post['thumbnail']) ?>" alt="">
        </div>
        <p>
            <?= nl2br(htmlspecialchars($post['body'])) ?>
        </p>
    </div>
</section>

<?php
// Check if the event is not housefull
if ($post['total_seats'] > $post['booked_seats']) {
?>
<section class="search__bar" style="margin-bottom: 2rem;">
    <form method="post" class="container search__bar-container" onsubmit="return validateInput()">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-ticket-perforated-fill" viewBox="0 0 16 16">
                <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6zm4-1v1h1v-1zm1 3v-1H4v1zm7 0v-1h-1v1zm-1-2h1v-1h-1zm-6 3H4v1h1zm7 1v-1h-1v1zm-7 1H4v1h1zm7 1v-1h-1v1zm-8 1v1h1v-1zm7 1h1v-1h-1z"/>
            </svg>
            <input type="number" id="number" name="tickets_to_book" placeholder="Enter No. of Tickets" min="1" max="<?=($post['total_seats']-$post['booked_seats'])?>" required>
        </div>
        <button type="submit" name="submit" class="btn">Book</button>
    </form>
</section>
<?php
} else {
    // Display "Housefull" if the event is housefull
    echo "<h1 style='text-align:center'>Housefull!</h1>";
}
?>

<script>
    function validateInput() {
        var input = document.getElementById('number');
        if (input.value < 1) {
            alert('Please enter a valid number of tickets (1 or more).');
            input.value = 1;
            return false;
        }
        return true;
    }
</script>

<?php
include 'partials/footer.php';
?>
