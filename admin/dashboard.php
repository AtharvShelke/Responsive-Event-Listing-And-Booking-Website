<?php
include 'partials/header.php';


$current_user_id = $_SESSION['user-id'];
$query = "SELECT id, title, category_id FROM posts WHERE admin_id=$current_user_id ORDER BY id DESC";
$posts = mysqli_query($conn, $query);
?>


    <section class="dashboard">
    <?php if (isset($_SESSION['add-event-success'])): ?>
                    <div class="alert__message success container">
                        <p>
                            <?= $_SESSION['add-event-success'];
                            unset($_SESSION['add-event-success']); ?>
                        </p>
                    </div>
        <?php elseif (isset($_SESSION['edit-event-success'])): ?>
                    <div class="alert__message success container">
                        <p>
                            <?= $_SESSION['edit-event-success'];
                            unset($_SESSION['edit-event-success']); ?>
                        </p>
                    </div>
            <?php elseif (isset($_SESSION['edit-event'])): ?>
                    <div class="alert__message error container">
                        <p>
                            <?= $_SESSION['edit-event'];
                            unset($_SESSION['edit-event']); ?>
                        </p>
                    </div>
                <?php elseif (isset($_SESSION['delete-event-success'])): ?>
                    <div class="alert__message success container">
                        <p>
                            <?= $_SESSION['delete-event-success'];
                            unset($_SESSION['delete-event-success']); ?>
                        </p>
                    </div>
                    <?php elseif (isset($_SESSION['delete-event'])): ?>
                    <div class="alert__message error container">
                        <p>
                            <?= $_SESSION['delete-event'];
                            unset($_SESSION['delete-event']); ?>
                        </p>
                    </div>
                    <?php elseif (isset($_SESSION['delete-location-success'])): ?>
                    <div class="alert__message success container">
                        <p>
                            <?= $_SESSION['delete-location-success'];
                            unset($_SESSION['delete-location-success']); ?>
                        </p>
                    </div>
        <?php endif ?>
        <div class="container dashboard__container">
            <button id="show__sidebar-btn" class="sidebar__toggle"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z"/>
              </svg></button>
            <button id="hide__sidebar-btn" class="sidebar__toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                  </svg>
            </button>
            <aside>
                <ul>
                    <li>
                        <a href="/wt project/admin/add-event.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-ticket-perforated-fill" viewBox="0 0 16 16">
                                <path
                                    d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6zm4-1v1h1v-1zm1 3v-1H4v1zm7 0v-1h-1v1zm-1-2h1v-1h-1zm-6 3H4v1h1zm7 1v-1h-1v1zm-7 1H4v1h1zm7 1v-1h-1v1zm-8 1v1h1v-1zm7 1h1v-1h-1z" />
                            </svg>
                            <h5>Add Event</h5>
                        </a>
                    </li>
                    <li>
                        <a href="dashboard.php"  class="active">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-bookmarks" viewBox="0 0 16 16">
                                <path
                                    d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v10.566l3.723-2.482a.5.5 0 0 1 .554 0L11 14.566V4a1 1 0 0 0-1-1z" />
                                <path
                                    d="M4.268 1H12a1 1 0 0 1 1 1v11.768l.223.148A.5.5 0 0 0 14 13.5V2a2 2 0 0 0-2-2H6a2 2 0 0 0-1.732 1" />
                            </svg>
                            <h5>Manage Event</h5>
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user_is_admin'])): ?>
                                                    <li>
                                                        <a href="add-user.php">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                                class="bi bi-person-add" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                                                                <path
                                                                    d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z" />
                                                            </svg>
                                                            <h5>Add User</h5>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="manage-users.php">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                                class="bi bi-people" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                                                            </svg>
                                                            <h5>Manage Users</h5>
                                                        </a>
                                                    </li>
                                                    <li>

                                                        <a href="add-category.php">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                                class="bi bi-bookmark-plus" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
                                                                <path
                                                                    d="M8 4a.5.5 0 0 1 .5.5V6H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V7H6a.5.5 0 0 1 0-1h1.5V4.5A.5.5 0 0 1 8 4" />
                                                            </svg>
                                                            <h5>Add Locations</h5>
                                                        </a>
                                                    </li>
                                                    <li><a href="manage-categories.php" >
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                                class="bi bi-bookmarks" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v10.566l3.723-2.482a.5.5 0 0 1 .554 0L11 14.566V4a1 1 0 0 0-1-1z" />
                                                                <path
                                                                    d="M4.268 1H12a1 1 0 0 1 1 1v11.768l.223.148A.5.5 0 0 0 14 13.5V2a2 2 0 0 0-2-2H6a2 2 0 0 0-1.732 1" />
                                                            </svg>
                                                            <h5>Manage Locations</h5>
                                                        </a>
                                                    </li>
                    <?php endif ?>
                </ul>
            </aside>
            <main>
                <h2>Manage Event</h2>
                <?php if (mysqli_num_rows($posts) > 0): ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Location</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($post = mysqli_fetch_assoc($posts)): ?>
                                                                        <?php
                                                                        $category_id = $post['category_id'];
                                                                        $category_query = "SELECT name FROM locations WHERE id=$category_id";
                                                                        $category_result = mysqli_query($conn, $category_query);
                                                                        $category = mysqli_fetch_assoc($category_result);
                                                                        ?>
                                                                        <tr>
                                                                            <td><?= $post['title'] ?></td>
                                                                            <td><?= $category['name'] ?></td>
                                                                            <td><a href="<?= ROOT_URL ?>admin/edit-event.php?id=<?= $post['id'] ?>" class="btn sm">Edit</a></td>
                                                                            <td><a href="<?= ROOT_URL ?>admin/delete-event.php?id=<?= $post['id'] ?>" class="btn sm danger">Delete</a></td>
            
                                                                        </tr>
                                        <?php endwhile ?>
        
                                    </tbody>
                                </table>
                <?php else: ?>
                                <div class="alert__message error">
                                    <?= "No Events Found"; ?>
                                </div>
                <?php endif ?>
            </main>
        </div>
    </section>


    <?php
    include 'partials/footer.php';
    ?>
