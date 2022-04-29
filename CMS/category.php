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

            if (isset($_GET['category'])) {

                $post_category_id = $_GET['category'];

                // if user is logged in admin, show all the posts
                if (is_admin($_SESSION['username'])) {
                    // prepare statement
                    $stmt1 = mysqli_prepare($connection, "select post_id, post_title, post_user, post_date, post_image, post_content from posts where post_category_id = ?");
                } else {
                    // prepare statement
                    $stmt2 = mysqli_prepare($connection, "select post_id, post_title, post_user, post_date, post_image, post_content from posts where post_category_id = ? and post_status = ?");
                    $published = 'published';
                }

                if (isset($stmt1)) {
                    mysqli_stmt_bind_param($stmt1, "i", $post_category_id); // bind parameters
                    mysqli_stmt_execute($stmt1);    // execute query
                    mysqli_stmt_bind_result($stmt1,$post_id, $post_title, $post_user, $post_date, $post_image, $post_content);  // get result

                    mysqli_stmt_store_result($stmt1); // store result

                    $stmt = $stmt1;
                }
                else {
                    mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published);    // bind parameters
                    mysqli_stmt_execute($stmt2);    // execute query
                    mysqli_stmt_bind_result($stmt2,$post_id, $post_title, $post_user, $post_date, $post_image, $post_content);  // get result

                    mysqli_stmt_store_result($stmt2); // store result

                    $stmt = $stmt2;

                }


                if (mysqli_stmt_num_rows($stmt) === 0) {
                    echo "<h1 class='text-center'>No Posts Available!</h1>";
                }
                else {
                    while (mysqli_stmt_fetch($stmt)) {
                        ?>
                        <h1 class="page-header">
                            Page Heading
                            <small>Secondary Text</small>
                        </h1>

                        <!-- First Blog Post -->
                        <h2>
                            <a href="post.php?p_id=<?php echo $post_id; ?>"> <?php echo $post_title; ?> </a>
                        </h2>
                        <p class="lead">
                            by <a href="index.php"> <?php echo $post_user; ?> </a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?> </p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                        <hr>
                        <p> <?php echo $post_content; ?> </p>
                        <a class="btn btn-primary" href="#">Read More <span
                                    class="glyphicon glyphicon-chevron-right"></span></a>
                        <hr>
                        <!-- close php while loop -->
                        <?php
                    }

                }
                // close prepared statement
                mysqli_stmt_close($stmt);

            }
            // if $_GET is not set
            else {
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