<?php
include 'partials/header.php';

$location_query = "SELECT * FROM locations";
$locations = mysqli_query($conn, $location_query);

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $post = mysqli_fetch_assoc($result);
}else{
    header('location: ' . ROOT_URL .'admin/dashboard.php');
    die();
}
?>
    <section class="form__section" style="margin: 5rem 0;">
        <div class="container form__section-container">
            <h2>Edit Event</h2>
            
            <form action="<?=ROOT_URL?>admin/edit-event-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?=$post['id']?>" placeholder="Title">
            <input type="hidden" name="previous_thumbnail_name" value="<?=$post['thumbnail']?>" placeholder="Title">
                <input type="text" name="title" value="<?=$post['title']?>" placeholder="Title">
                <select name="category">
                    <?php while($location = mysqli_fetch_assoc($locations)): ?>
                    <option value="<?= $location['id'] ?>"><?= $location['name'] ?></option>
                    <?php endwhile ?>
                </select>
                <textarea rows="10" name="body" placeholder="Description"><?=$post['body']?></textarea>
                <div class="form__control inline">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1" checked>
                    <label for="is_featured" >Featured</label>
                </div>
                <div class="form__control">
                    <label for="thumbnail">Change Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail">
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