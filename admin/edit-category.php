<?php
include 'partials/header.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM locations WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) == 1){
        $location = mysqli_fetch_assoc($result);
    }
}else{
    header('location: ' . ROOT_URL .'admin/manage-categories.php');
    die();
}
?>
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Edit Location</h2>
            
            <form action="<?= ROOT_URL ?>admin/edit-category-logic.php" method="POST">

            <input type="hidden" name="id" value="<?=$location['id']?>" placeholder="Title">

                <input type="text" name="name" value="<?=$location['name']?>">

                <textarea name="description" rows="4" placeholder="Description">"<?=$location['description']?>"</textarea>


                <button type="submit" name="submit" class="btn">Edit Location</button>
            </form>
        </div>
    </section>
    <?php
include 'partials/footer.php';
?>