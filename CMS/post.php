
<!-- include header -->
<?php include 'includes/header.php'; ?>
<!-- Navigation -->
<?php include 'includes/navigation.php'; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <!-- show post base on the post id -->
            <?php
            if (isset($_GET['p_id'])) {

                $the_post_id = $_GET['p_id'];

                // increase the post view count
                $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = {$the_post_id}";
                $send_query = mysqli_query($connection, $view_query);
                if (!$send_query) {
                    die("Query Failed" . mysqli_error($connection));
                }

                // select all posts from DB
                // only admin can see all (published and draft) the posts - others can only see published posts
                // if user enter a draft post url directly, it doesn't show the draft post (only admin can see them).
                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                    $query = "SELECT * FROM posts WHERE post_id = {$the_post_id}";
                } else {
                    $query = "SELECT * FROM posts WHERE post_id = {$the_post_id} AND post_status = 'published'";
                }

                $select_all_posts_query = mysqli_query($connection, $query);
                if (mysqli_num_rows($select_all_posts_query) == 0) {
                    echo "<h1 class='text-center'>No Posts Available!</h1>";
                } else {

                    // echo all selected posts
                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        ?>
                        <h1 class="page-header">
                            Posts
                        </h1>
                        <!-- First Blog Post -->
                        <h2><a href="#"> <?php echo $post_title; ?> </a></h2>
                        <p class="lead">by <a href="index.php"> <?php echo $post_user; ?> </a></p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?> </p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                        <hr>
                        <p> <?php echo $post_content; ?> </p>
                        <hr>
                        <!-- close php while loop -->
                        <?php
                    }
                    ?>
                    <!-- comment section -->
                    <!-- Blog Comments -->
                    <!-- process comment Form submission -->
                    <?php
                    if (isset($_POST['create_comment'])) {

                        $the_post_id = $_GET['p_id'];

                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];

                        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {

                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";
                            $create_comment_query = mysqli_query($connection, $query);
                            if (!$create_comment_query) {
                                die('QUERY FAILED' . mysqli_error($connection));
                            }

                            // increment post comment count
//                    $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $the_post_id ";
//                    $update_comment_count = mysqli_query($connection, $query);

                        }
                        // if comment is empty alert user
                        else {
                            echo "<script>alert('Fields cannot be empty')</script>";
                        }
                    }
                    ?>

                    <!-- Comments Form -->
                    <div class="well">
                        <h4>Leave a Comment:</h4>

                        <form action="" method="post" role="form">

                            <div class="form-group">
                                <label for="author">Author</label>
                                <input type="text" name="comment_author" class="form-control" placeholder="Name...">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="comment_email" class="form-control" placeholder="Email...">
                            </div>

                            <div class="form-group">
                                <label for="comment">Your Comment</label>
                                <textarea name="comment_content" class="form-control" rows="3"></textarea>
                            </div>

                            <button name="create_comment" type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                    <hr>

                    <?php
                    // query to select all approved comments for the current post and order by the date and show them.
                    $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} AND comment_status = 'approved' ORDER BY comment_id DESC ";
                    $select_comment_query = mysqli_query($connection, $query);

                    if (!$select_comment_query) {
                        die('QUERY FAILED' . mysqli_error($connection));
                    }

                    while ($row = mysqli_fetch_array($select_comment_query)) {
                        $comment_author = $row['comment_author'];
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content'];

                        ?>

                        <!-- Posted Comments -->
                        <!-- Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment_author; ?>
                                    <small><?php echo $comment_date; ?></small>
                                </h4>
                                <?php echo $comment_content; ?>
                            </div>
                        </div>

                    <?php }
                }
            } else {
                header("Location: index.php");
            }
            ?>

        </div>
        <!-- Blog Sidebar Widgets Column -->
        <?php include 'includes/sidebar.php'; ?>
    </div>
    <!-- /.row -->
    <hr>
    <!-- Footer -->
<?php include 'includes/footer.php'; ?>