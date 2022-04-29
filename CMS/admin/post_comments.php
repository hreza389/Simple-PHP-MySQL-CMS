<?php include "includes/admin_header.php"; ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Comments
                        <small>Hamid</small>
                    </h1>

                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Author</th>
                            <th>Comment</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>In Response to</th>
                            <th>Date</th>
                            <th style="color: green">Approve</th>
                            <th style="color: #a94442">UnApprove</th>
                            <th style="color: dodgerblue">Edit</th>
                            <th style="color: red">Delete</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        $p_id = mysqli_real_escape_string($connection, $_GET['p_id']);

                        $query = "select * from comments where comment_post_id = {$p_id}";
                        $select_comments = mysqli_query($connection, $query);

                        while ($row = mysqli_fetch_assoc($select_comments)) {
                            $comment_id = $row['comment_id'];
                            $comment_post_id = $row['comment_post_id'];
                            $comment_author = $row['comment_author'];
                            $comment_email = $row['comment_email'];
                            $comment_content = $row['comment_content'];
                            $comment_status = $row['comment_status'];
                            $comment_date = $row['comment_date'];


                            // echo DB variables to table
                            echo "<tr>";
                            echo "<td>$comment_id</td>";
                            echo "<td>$comment_author</td>";
                            echo "<td>$comment_content</td>";
                            echo "<td>$comment_email</td>";
                            echo "<td>$comment_status</td>";
                            // query to get post title based on comment_post_id and show it in "in response to" column
                            $query = "select * from posts where post_id = {$comment_post_id}";
                            $select_post_id_query = mysqli_query($connection, $query);
                            while ($row = mysqli_fetch_assoc($select_post_id_query)) {
                                $post_id = $row['post_id'];
                                $post_title = $row['post_title'];
                                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                            }
                            echo "<td>$comment_date</td>";

                            // send request to post_comments.php page
                            echo "<td><a href='post_comments.php?approve={$comment_id}&p_id={$p_id}'>Approve</a></td>";
                            echo "<td><a href='post_comments.php?unapprove={$comment_id}&p_id={$p_id}'>UnApprove</a></td>";
                            echo "<td><a href='comments.php?source={}'>Edit</a></td>";
                            echo "<td><a href='post_comments.php?delete={$comment_id}&p_id={$p_id}'>Delete</a></td>";
                            echo "<tr>";
                        }
                        ?>

                        </tbody>
                    </table>


                    <?php

                    # Approve - check and unApprove if unApprove link clicked
                    if (isset($_GET['approve'])) {
                        $the_comment_id = $_GET['approve'];
                        $query = "update comments set comment_status='approved' where comment_id = {$the_comment_id}";
                        $approve_comment_query = mysqli_query($connection, $query);
                        header("location: post_comments.php?p_id={$p_id}");
                    }

                    # unApprove - check and unApprove if unApprove link clicked
                    if (isset($_GET['unapprove'])) {
                        $the_comment_id = $_GET['unapprove'];
                        $query = "update comments set comment_status = 'unapproved' where comment_id = {$the_comment_id}";
                        $unapprove_comment_query = mysqli_query($connection, $query);
                        header("Location: post_comments.php?p_id={$p_id}");
                    }

                    # Delete - check and delete if delete link clicked
                    if (isset($_GET['delete'])) {
                        $the_comment_id = $_GET['delete'];
                        $query = "delete from comments where comment_id = {$the_comment_id}";
                        $delete_query = mysqli_query($connection, $query);
                        header("Location: post_comments.php?p_id={$p_id}");
                    }
                    ?>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php"; ?>
