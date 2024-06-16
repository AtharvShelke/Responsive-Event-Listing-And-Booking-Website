
<?php

include 'partials/header.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE category_id=$id ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    $query = "SELECT * FROM posts ORDER BY id DESC";
$posts = mysqli_query($conn, $query);
}else{
    header('location: ' . ROOT_URL .'events.php');
    die();
}
?>

    <header class="category__title">
    <h2><?php
                        $category_id = $id;
                        $category_query = "SELECT * FROM locations WHERE id=$id";
                        $category_result = mysqli_query($conn, $category_query);
                        $category = mysqli_fetch_assoc($category_result);
    echo $category['name'];
                        ?>
                        </h2>
    </header>

   
    <?php if(mysqli_num_rows($posts)>0):?>
    <section class="posts">
        <div class="container posts__container">
            <?php while($post = mysqli_fetch_assoc($result)) :  ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/<?= $post['thumbnail'] ?>" alt="">
                </div>
                <div class="post__info">
               
                   
                    <h3 class="post__title">
                        <a href="<?=ROOT_URL?>post.php?id=<?=$post['id']?>"><?=$post['title']?></a>
                    </h3>
                    <p class="post__body">
                    <?= substr($post['body'], 0, 300) ?>...
                    </p>
                    <div class="post__author">
                    <?php
                $author_id = $post['admin_id'];
                $author_query = "SELECT * FROM users WHERE id=$author_id";
                $author_result = mysqli_query($conn, $author_query);
                $author = mysqli_fetch_assoc($author_result);
        ?>
                        <div class="post__author-avatar">
                            <img src="./images/<?=$author['avatar']?>" alt="">
                        </div>
                        <div class="post__author-info">
                        <h5>by:<?=$author['firstname'] . $author['lastname']?></h5>
                            <!-- haven't added date time column in posts -->
                                <!-- <small><?= date("Md, Y - H:i", strtotime($post['date-time'])) ?></small> -->
                        </div>
                    </div>
                </div>
            </article>
<?php endwhile; ?>
            
        </div>
    </section>
    <?php else : ?>
        <div class="alert__message error lg">
            <p>No Post found for this category</p>
        </div>
    <?php endif ?>
    <section class="category__buttons">
        <div class="container category__buttons-container">
            <?php
                $all_categories_query = "SELECT * FROM locations";
                $all_categories = mysqli_query($conn, $all_categories_query);
            ?>
            <?php while($category=mysqli_fetch_assoc($all_categories)) : ?>
                <a href="<?=ROOT_URL?>category-posts.php?id=<?=$category['id']?>" class="category__button"><?= $category['name']?></a>
            <?php endwhile; ?>
        </div>
    </section>



    
    <?php

include 'partials/footer.php';

?>