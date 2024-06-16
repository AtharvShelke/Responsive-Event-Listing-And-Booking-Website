<?php
require 'partials/header.php';

if (isset($_GET['search']) && isset($_GET['submit'])) {
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $stmt = mysqli_prepare($conn, "SELECT * FROM posts WHERE title LIKE ? ORDER BY id DESC");
    if (!$stmt) {
        echo "Error preparing statement: " . mysqli_error($conn);
        die();
    }

    mysqli_stmt_bind_param($stmt, "s", $search);
    if (!mysqli_stmt_execute($stmt)) {
        echo "Error executing statement: " . mysqli_stmt_error($stmt);
        die();
    }

    $posts = mysqli_stmt_get_result($stmt);
    if (!$posts) {
        echo "No results found.";
    }
} else {
    header("location: " . ROOT_URL . "events.php");
    die();
}
?>



<?php if (mysqli_num_rows($posts) > 0): ?>
    <section class="posts section__extra-margin">
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
                    <?php if (isset($post) && is_array($post) && isset($post['body'])) {
                         $body = $post['body']; 
    
        // Ensure $body is a string before creating an excerpt
        if (is_string($body)) {
            $excerpt = substr($body, 0, 300); 
            echo $excerpt;
        } else {
            echo "Invalid post body content.";
        }
    } else {
        echo "Post body is not set.";
    }
        ?>...
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
                            <!-- haven't added date time column in posts -->
                                <!-- <small><?= date("Md, Y - H:i", strtotime($post['date-time'])) ?></small> -->
                        </div>
                    </div>
                </div>
            </article>
    <?php endwhile; ?>
    
    </div>
    </section>
<?php else: ?>
        <div class="alert__message error lg section__extra-margin">
            <p>No posts found</p>
        </div>
<?php endif; ?>
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

<?php include 'partials/footer.php' ?>
