<!-- include header -->
<?php include 'includes/header.php'; ?>

<!-- Navigation -->
<?php include 'includes/navigation.php'; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php

            $posts_per_page = 4;

            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = "";
            }

            if ($page == "" || $page == 1) {
                $page_1 = 0;
            } else {
                $page_1 = ($page * $posts_per_page) - $posts_per_page;
            }

            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                $post_query_count = "SELECT * FROM posts";
            } else {
                $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";
            }


            // Get the number of all published posts and count them for pagination
            //            $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";
            $find_count = mysqli_query($connection, $post_query_count);
            $count = mysqli_num_rows($find_count);

            if ($count == 0) {
                echo "<h1 class='text-center'>No Posts Available!</h1>";
            } else {

                $count = ceil($count / $posts_per_page); // gives the number of pages
//                echo "number of pages = " . $count;

                // select all published posts from DB
                $query = "SELECT * FROM posts where post_status = 'published' limit {$page_1}, {$posts_per_page}";
                $select_all_posts_query = mysqli_query($connection, $query);


                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'], 0, 100) . '...'; // substr() is used to limit the length of the content
                    $post_status = $row['post_status'];
                    ?>
                    <!-- html -->

                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>
                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>"> <?php echo $post_title; ?> </a>
                    </h2>
                    <p class="lead">
                        by
                        <a href="author_posts.php?author=<?php echo $post_user; ?>&p_id=<?php echo $post_id; ?>"> <?php echo $post_user; ?> </a>
                    </p>

                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?>

                    <hr>

                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                        <img class="img-responsive img-rounded" src="images/<?php echo $post_image; ?>" alt="">
                    </a>

                    <hr>
                    <p> <?php echo $post_content; ?> </p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span
                                class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>

                    <!-- close php while loop and else statement -->
                    <?php
                }
            }
            ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include 'includes/sidebar.php'; ?>

    </div>
    <!-- /.row -->
    <hr>

    <ul class="pager">
        <?php
        // pagination
        for ($i = 1; $i <= $count; $i++) {
            if ($i == $page) {
                echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
            } else {
                echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
            }
        }

        ?>
    </ul>

    <!-- Footer -->
<?php include 'includes/footer.php'; ?>