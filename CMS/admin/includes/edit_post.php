<?php


// get post id from url
if (isset($_GET['p_id'])) {
    $the_post_id = $_GET['p_id'];

    $query = "select * from posts where post_id={$the_post_id}";
    $select_posts_by_id = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
        $post_id = $row['post_id'];
        $post_user = $row['post_user'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
    }

    // get category title from category id
    $query = "select * from categories where cat_id = {$post_category_id}";
    $select_categories_id = mysqli_query($connection, $query);
    $cat_title = mysqli_fetch_assoc($select_categories_id)['cat_title'];
}

// show message if post is updated
if (isset($_GET['updated'])) {
    if ($_GET['updated'] == $the_post_id) {
        echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$the_post_id}'>View Post Page</a> or <a href='posts.php'>View All Posts</a></p>";
    }
}


if (isset($_GET['remove_image'])) {
    if ($_GET['remove_image'] == 'true') {
        $query = "UPDATE posts SET post_image = '' WHERE post_id = {$the_post_id}";
        $update_image = mysqli_query($connection, $query);
        confirmQuery($update_image);
        header("Location: posts.php?source=edit_post&p_id={$the_post_id}&updated={$the_post_id}");
    }
}

// check Form submission
if (isset($_POST['update_post'])) {

    $post_title = htmlentities($_POST['post_title'], ENT_QUOTES);
    $post_category_id = $_POST['post_category'];
    $post_user = $_POST['post_user'];
    $post_status = $_POST['post_status'];
    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    move_uploaded_file($post_image_temp, "../images/$post_image");

    $remove_image = $_POST['remove_image'];

    // if the image is empty, then use the old image
    if (empty($post_image)) {
        $query = "select * from posts where post_id = {$the_post_id}";
        $select_image = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($select_image)) {$post_image = $row['post_image'];}
    }

    // update query
    $query = "UPDATE `posts` SET `post_title` = '{$post_title}', `post_user` = '{$post_user}', `post_category_id`='{$post_category_id}' , `post_image` = '{$post_image}', `post_content` = '{$post_content}', `post_tags` = '{$post_tags}', `post_status` = '{$post_status}' WHERE `posts`.`post_id` = {$the_post_id}";
    $update_post = mysqli_query($connection, $query);
    // check query
    confirmQuery($update_post);

    // header("Refresh:4; url=posts.php");
    // refresh page to show the updated post
    header("Location: posts.php?source=edit_post&p_id={$the_post_id}&updated=$the_post_id");
}
?>

<form action="" method="post" enctype="multipart/form-data">

<!--Post Title-->
    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title ?>" type="text" class="form-control" name="post_title">
    </div>

<!--Category-->
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

                if ($cat_id == $post_category_id) {
                    echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
                }
                else {
                    echo "<option value='{$cat_id}' >{$cat_title}</option>";
                }
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

<!--Status-->
    <div class="form-group">
        <label for="category">Status</label>
        <select name="post_status" id="">
            <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>
            <?php
            if ($post_status == 'published') {echo "<option value='draft'>draft</option>";}
            else {echo "<option value='published'>published</option>";}
            ?>
        </select>
    </div>

<!--Post Image-->
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <br>

        <?php
        if (!empty($post_image)) {
            ?>
            <div class="img-wrap">
                <a class="close" href="./posts.php?source=edit_post&p_id=<?php echo $post_id; ?>&updated=<?php echo $post_id; ?>&remove_image=true">&times;</a>
                <img width="100" src="../images/<?php echo $post_image ?>" alt=""">
            </div>
            <?php
        }
        else {
            echo "<p style='margin: 0;color: #a94442'>No image choosen</p>";
        }
        ?>

        <br>

        <label class="btn btn-info">
            <i class="fa fa-image"></i> Change / Choose<input type="file" style="display: none;" name="image">
        </label>

    </div>

<!--Post Tags-->
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags ?>" type="text" class="form-control" name="post_tags">
    </div>

<!--Post Content-->
    <div class="form-group">
        <label for="editor">Post Content</label>
        <textarea class="form-control " name="post_content" id="editor" cols="30" rows="10"><?php echo str_replace('\r\n','<br>',$post_content); ?></textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>

</form>