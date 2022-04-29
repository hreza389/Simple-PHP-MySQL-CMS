<?php

# check Form submission
if (isset($_POST['create_post'])) {

    $post_category_id = $_POST['post_category'];
    $post_title = $_POST['title'];
    // $post_author = $_POST['author'];
    $post_user = $_POST['post_user'];
    $post_date = date('d-m-y');

    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    move_uploaded_file($post_image_temp, "../images/$post_image");

    $post_content = $_POST['post_content'];
    $post_tags = $_POST['post_tags'];
    $post_status = $_POST['post_status'];

    $query = "INSERT INTO posts (post_category_id, post_title, post_user, post_date,post_image,post_content,post_tags,post_status) ";
    $query .= "VALUES({$post_category_id},'{$post_title}','{$post_user}',now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}') ";
    $create_post_query = mysqli_query($connection, $query);
    confirmQuery($create_post_query);

    // gets the id of the last inserted post
    $the_post_id = mysqli_insert_id($connection);
    echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$the_post_id}'>View Post</a> or <a href='posts.php'>Edit More Posts</a></p><br>";

}

?>

<!--send info to current page-->
<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>


    <div class="form-group">
        <label for="category">Category</label>
        <select name="post_category" id="">
            <?php
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);
            confirmQuery($select_categories);

            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<option value='$cat_id'>{$cat_title}</option>";
            }
            ?>
        </select>
    </div>

    <!-- Users -->
    <div class="form-group">
        <label for="users">User</label>
        <select name="post_user" id="">
            <?php
            $users_query = "SELECT * FROM users";
            $select_users = mysqli_query($connection, $users_query);
            confirmQuery($select_users);

            while ($row = mysqli_fetch_assoc($select_users)) {
                $user_id = $row['user_id'];
                $user_username = $row['user_username'];

                echo "<option value='$user_username'>{$user_username}</option>";
            }
            ?>
        </select>
    </div>

<!--    <div class="form-group">-->
<!--        <label for="post_author">Author</label>-->
<!--        <input type="text" class="form-control" name="author">-->
<!--    </div>-->

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" id="">
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>


    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control " name="post_content" id="editor" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>

</form>
    