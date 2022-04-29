<?php include "delete_modal.php"; ?>

<?php
// check if any of boxes are checked and selected
if (isset($_POST['checkBoxArray']))
    foreach ($_POST['checkBoxArray'] as $checkBoxPostIdValue) {
        // select options drop down list value.
        $bulk_options = $_POST['bulk_options'];
        // check drop down list value.
        switch ($bulk_options) {
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$checkBoxPostIdValue}";
                $update_to_published_status = mysqli_query($connection, $query);
                confirmQuery($update_to_published_status);
                break;

            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$checkBoxPostIdValue}";
                $update_to_draft_status = mysqli_query($connection, $query);
                confirmQuery($update_to_draft_status);
                break;

            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$checkBoxPostIdValue}";
                $update_to_delete_status = mysqli_query($connection, $query);
                confirmQuery($update_to_delete_status);
                break;

            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id = {$checkBoxPostIdValue}";
                $select_post_query = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_array($select_post_query)) {
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_date = $row['post_date'];
                    $post_user = $row['post_user'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_content = $row['post_content'];
                }

                $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_status) ";
                $query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";

                $copy_query = mysqli_query($connection, $query);
                if (!$copy_query) {
                    die("QUERY FAILED" . mysqli_error($connection));
                }
        }
    }
?>

<form enctype="multipart/form-data" action="" method="post">

    <div>

        <div id="bulkOptionsContainer" class="col-xs-4">
            <select name="bulk_options" id="" class="form-control">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>

        <div class="col-xs-4">
            <!-- outer form submit btn -->
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>

    </div>


    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>
                <label for="selectAllBoxes"></label>
                <input id="selectAllBoxes" type="checkbox">
            </th>
            <th>ID</th>
            <th>Users</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>View Post</th>
            <th>Views</th>
            <th>Edit</th>
            <th style="color: red">Delete</th>
        </tr>
        </thead>
        <tbody>

        <?php
        // query to select all posts from database and display in table from latest to oldest.
        $query = "select * from posts order by post_id desc";
        // $query = "select * from posts.post_id, posts.post_category_id, posts.post_title, posts.post_user, posts.post_date, posts.post_image, posts.post_content, posts.post_tags, posts.post_status, posts.post_comment_count, posts.post_views_count, categories.cat_id, categories.cat_title from posts left join categories on posts.post_category_id = categories.cat_id order by posts.post_id desc";
        $select_posts = mysqli_query($connection, $query);


        while ($row = mysqli_fetch_assoc($select_posts)) {
            $post_id = $row['post_id'];
            $post_user = $row['post_user'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date = $row['post_date'];
            $post_views_count = $row['post_views_count'];

            if (empty($post_tags)) {
                $post_tags = "No Tags";
            }

            // echo DB variables to table
            echo "<tr>";
            ?>

            <!-- checkboxes -->
            <td>
                <input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'>
            </td>

            <?php
            echo "<td>$post_id</td>";
            echo "<td>$post_user</td>";
            echo "<td>$post_title</td>";

            // get category title from category id value.
            $query = "select * from categories where cat_id = {$post_category_id}";
            $select_categories_id = mysqli_query($connection, $query);
            $cat_title = mysqli_fetch_assoc($select_categories_id)['cat_title'];

            echo "<td>$cat_title</td>";
            echo "<td>$post_status</td>";

            // if image is not empty
            if (!empty($post_image)) {
                echo "<td><img style='border-radius: 2px; border: 1px solid lightgray; max-height: 100px; max-width: 60px;' src='../images/$post_image' alt='image'></td>";
            } else {
                echo "<td style='color: lightsalmon'>No Image</td>";
            }

            echo "<td>$post_tags</td>";

            $query = "select * from comments where comment_post_id = {$post_id}";
            $send_comment_query = mysqli_query($connection, $query);
            $count_comments = mysqli_num_rows($send_comment_query);

            echo "<td><a class='btn' href='post_comments.php?p_id=$post_id'>$count_comments</a></td>";

            echo "<td>$post_date</td>";

            // LINKS - send request to post.php page
            echo "<td><a class='btn btn-primary' href='../post.php?p_id={$post_id}'>View</a></td>";
            echo "<td><a class='btn' href='posts.php?reset={$post_id}'>$post_views_count</a></td>";
            echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
            ?>


            <form action="" method="post">
                <?php
                echo "<td><input type='hidden' name='post_id' value='{$post_id}'>";
                echo "<input class='btn btn-danger' type='submit' name='delete' value='Delete'></td>";
                ?>

            <?php
//            echo "<td><a rel='$post_id' class='delete_link' href='javascript:void(0)'>Delete</a></td>";

            echo "<tr>";
        }
            ?>
        </tbody>
    </table>
</form>

<?php
# check and delete if delete link clicked --> delete=post_id
if (isset($_POST['post_id'])) {

    $delete_post_id = escape($_POST['post_id']);
    $query = "delete from posts where post_id={$delete_post_id}";
    $delete_query = mysqli_query($connection, $query);
    header("Location: posts.php");
}

# reset views count if reset link clicked --> reset=post_id
if (isset($_GET['reset'])) {

    $reset_post_id = $_GET['reset'];
    $query = "update posts set post_views_count = 0 where post_id=" . mysqli_real_escape_string($connection, $reset_post_id);
    $reset_query = mysqli_query($connection, $query);
    header("Location: posts.php");
}
?>

<!-- DELETE MODAL -->
<script>
    $(document).ready(function () {

        // check if element with the class 'delete_link' is clicked then get its 'rel' attribute value.
        $('.delete_link').on('click', function () {
            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete=" + id;

            // add delete url to the modal component 'href' attribute
            $('.modal_delete_link').attr("href", delete_url);
            $('#myModal').modal('show');
        });
    });
</script>
