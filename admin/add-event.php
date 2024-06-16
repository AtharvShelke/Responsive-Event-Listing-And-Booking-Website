<?php
include 'partials/header.php';

$query = "SELECT * FROM locations";
$locations = mysqli_query($conn, $query);

$title = $_SESSION['add-event-data']['title'] ?? null;
$body = $_SESSION['add-event-data']['body'] ?? null;

unset($_SESSION['add-event-data']);
?>
<section class="form__section" style="margin: 5rem 0;">
    <div class="container form__section-container">
        <h2>Add Event</h2>
        <?php if (isset($_SESSION['add-event'])): ?>
            <div class="alert__message error">
                <p><?= $_SESSION['add-event'];
                unset($_SESSION['add-event']); ?></p>
            </div>
        <?php unset($_SESSION['add-event']); endif; ?>
        <form action="<?= ROOT_URL ?>admin/add-event-logic.php" method="post" enctype="multipart/form-data">

            <input type="text" name='title' value="<?= $title ?>" placeholder="Title">
            <select name='category'>
                <?php while ($location = mysqli_fetch_assoc($locations)): ?>
                    <option value="<?= $location['id'] ?>"><?= $location['name'] ?></option>
                <?php endwhile; ?>
            </select>
            <textarea rows="10" name='body' placeholder="Description"><?= $body ?></textarea>
            <?php if (isset($_SESSION['user_is_admin'])): ?>
                <div class="form__control inline">
                    <input type="checkbox" name='is_featured' id="is_featured" value="1" checked>
                    <label for="is_featured">Featured</label>
                </div>
            <?php endif; ?>
            <div class="form__control">
                <label for="thumbnail">
                    Add Thumbnail
                </label><input type="file" name="thumbnail" id="thumbnail">
            </div>
            <input type="date" name="date" id="date">
                <input type="time" name="time" placeholder="Enter time">
                <input type="number" name="tseats" placeholder="Total Seats">
            <button type="submit" name="submit" class="btn">Add Event</button>
        </form>
    </div>
</section>
<?php
include 'partials/footer.php';
?>
