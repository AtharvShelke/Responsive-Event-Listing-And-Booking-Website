<?php

include 'partials/header.php';
$featured_query = "SELECT * FROM posts WHERE is_featured=1";
$featured_result = mysqli_query($conn, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);
$query = "SELECT * FROM posts ORDER BY id DESC";
$posts = mysqli_query($conn, $query);
?>
    <section class="search__bar">
        <form class="container search__bar-container" action="<?=ROOT_URL?>search.php" method="GET">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                  </svg>
                <input type="search" name="search" placeholder="Search">
                <button type="submit" name="submit" class="btn">Go</button>

            </div>
            
        </form>
    </section>
    
    <section class="posts <?= $featured ? '' : 'section__extra-margin' ?>">
        <div class="container posts__container">
            <?php while ($post = mysqli_fetch_assoc($posts)): ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="./images/<?= $post['thumbnail'] ?>" alt="">
                    </div>
                    <div class="post__info">
                    <?php
                    $category_id = $post['category_id'];
                    $category_query = "SELECT * FROM locations WHERE id=$category_id";
                    $category_result = mysqli_query($conn, $category_query);
                    $category = mysqli_fetch_assoc($category_result);

                    ?>
                        <a href="category-posts.php?id=<?= $post['category_id'] ?>" class="category__button"><?= $category['name'] ?></a>
                        <h3 class="post__title">
                            <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
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
                                <img src="./images/<?= $author['avatar'] ?>" alt="">
                            </div>
                            <div class="post__author-info">
                            <h5>by:<?= $author['firstname'] . $author['lastname'] ?></h5>
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
            <?php while ($category = mysqli_fetch_assoc($all_categories)): ?>
                    <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['name'] ?></a>
            <?php endwhile; ?>
        </div>
    </section>



   
    <?php

    include 'partials/footer.php';

    ?>