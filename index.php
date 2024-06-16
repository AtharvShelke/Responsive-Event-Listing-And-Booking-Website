<?php
include 'partials/header.php';

$featured_query = "SELECT * FROM posts WHERE is_featured=1";
$featured_result = mysqli_query($conn, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);

$query = "SELECT * FROM posts ORDER BY id DESC LIMIT 9";
$posts = mysqli_query($conn, $query);
?>

<?php
if (mysqli_num_rows($featured_result) == 1):
    ?>
            <section class="featured">
                <div class="container featured__container">
                    <div class="post__thumbnail">
                        <img src="./images/<?= $featured['thumbnail'] ?>" alt="" id="thumbnail" style="min-height:480px; object-fit:contain;">
                    </div>
                    <div class="post__info">
                        <?php
                        $category_id = $featured['category_id'];
                        $category_query = "SELECT * FROM locations WHERE id=$category_id";
                        $category_result = mysqli_query($conn, $category_query);
                        $category = mysqli_fetch_assoc($category_result);

                        ?>
                        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $featured['category_id'] ?>" class="category__button"><?= $category['name'] ?></a>
                        <h2 class="post__title">
                            <a href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"><?= $featured['title'] ?></a></h2>
                        <p class="post__body">
                            <?= substr($featured['body'], 0, 700) ?>
                        </p>
                        <div class="post__author">
                    <?php
                        $author_id = $featured['admin_id'];
                        $author_query = "SELECT * FROM users WHERE id=$author_id";
                        $author_result = mysqli_query($conn, $author_query);
                        $author = mysqli_fetch_assoc($author_result);
                    ?>
                            <div class="post__author-avatar">
                                <img src="./images/<?=$author['avatar']?>" alt="">
                            </div>
                            <div class="post__author-info">
                                <h5>by:<?=$author['firstname'] . $author['lastname']?></h5>
                                
                                <small>date: <?= date("M d, Y", strtotime($featured['post_date'])) ?></small><br>
                    
                                <small>time: <?= date("H:i", strtotime($featured['post_time'])) ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


<?php endif; ?>
<h1 class="event-title-h1">Events</h1>
    <section class="posts <?=$featured ? '' : 'section__extra-margin' ?>">
    
        <div class="container posts__container">
            <?php while($post = mysqli_fetch_assoc($posts)) :  ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/<?= $post['thumbnail'] ?>" alt="" >
                </div>
                <div class="post__info">
                <?php
                        $category_id = $post['category_id'];
                        $category_query = "SELECT * FROM locations WHERE id=$category_id";
                        $category_result = mysqli_query($conn, $category_query);
                        $category = mysqli_fetch_assoc($category_result);

                        ?>
                    <a href="category-posts.php?id=<?=$post['category_id']?>" class="category__button"><?= $category['name'] ?></a>
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
                        <small>date: <?= date("M d, Y", strtotime($post['post_date'])) ?></small><br>
                    
                    <small>time: <?= date("H:i", strtotime($post['post_time'])) ?></small>
                        </div>
                    </div>
                </div>
            </article>
<?php endwhile; ?>
            
        </div>
    </section>

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