<?php
include 'partials/header.php';

// Redirect if booking_success session variable is not set
if (!isset($_SESSION['booking_success'])) {
    header('location: ' . ROOT_URL . 'events.php');
    die();
}

// Get the number of tickets booked from session
$tickets_booked = $_SESSION['booking_success'];
unset($_SESSION['booking_success']);
?>


<section class="empty__page">
        
        <h2>Booking Successful!</h2>
                    <p >You have successfully booked <strong><?= $tickets_booked ?> tickets</strong>.</p>
                    <div >
                        <a href="<?= ROOT_URL ?>events.php" class="btn btn-primary">Back to Events</a>
                    </div>
</section>
<?php
include 'partials/footer.php';
?>
