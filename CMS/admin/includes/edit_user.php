<?php

// check if "edit_user" value is in url and database
if (isset($_GET['edit_user'])) {
    $edit_user_id = $_GET['edit_user'];

    $query = "SELECT * FROM users WHERE user_id = {$edit_user_id}";
    $select_users_query = mysqli_query($connection, $query);
    confirmQuery($select_users_query);

    while ($row = mysqli_fetch_assoc($select_users_query)) {
        $db_user_id = $row['user_id'];
        $db_user_username = $row['user_username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_email = $row['user_email'];
        $db_user_image = $row['user_image'];
        $db_user_role = $row['user_role'];
    }


// show message if post is updated
    if (isset($_GET['updated'])) {
        if ($_GET['updated'] == $edit_user_id) {
            echo "<p class='bg-success'>User Updated: " . " " . "<a href='users.php'>View Users</a></p>";
        }
    }

// check if form has been submitted
    if (isset($_POST['edit_user'])) {

        $f_username = $_POST['user_username'];
        $f_password = $_POST['user_password'];
        $f_firstname = $_POST['user_firstname'];
        $f_lastname = $_POST['user_lastname'];
        $f_email = $_POST['user_email'];
        $f_role = $_POST['user_role'];

        $f_image = $_FILES['user_image']['name'];
        $f_image_temp = $_FILES['user_image']['tmp_name'];
        move_uploaded_file($f_image_temp, "../images/$f_image");

        //  if the image is empty, then use the old image from database
        if (empty($f_image)) {
            $query = "select * from users where user_id = {$edit_user_id}";
            $select_image = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_array($select_image)) {
                $f_image = $row['user_image'];
            }
        }

        // if password be empty , in the DB will be empty too.
        if (!empty($f_password)) {
            $hash_password = password_hash($f_password, PASSWORD_BCRYPT, array('cost' => 10));
            $query = "UPDATE `users` SET `user_username` = '{$f_username}', `user_password` = '{$hash_password}', `user_firstname` = '{$f_firstname}', `user_lastname` = '{$f_lastname}', `user_email` = '{$f_email}', `user_image` = '{$f_image}', `user_role` = '{$f_role}' WHERE `users`.`user_id` = {$edit_user_id}";
            $update_user_query = mysqli_query($connection, $query);
            confirmQuery($update_user_query);
            echo "<p class='bg-success'>User Updated: " . " " . "<a href='users.php'>View Users</a></p>";
        } else {
            $query = "UPDATE `users` SET `user_username` = '{$f_username}', `user_firstname` = '{$f_firstname}', `user_lastname` = '{$f_lastname}', `user_email` = '{$f_email}', `user_image` = '{$f_image}', `user_role` = '{$f_role}' WHERE `users`.`user_id` = {$edit_user_id}";
            $update_user_query = mysqli_query($connection, $query);
            confirmQuery($update_user_query);
            echo "<p class='bg-success'>User Updated: " . " " . "<a href='users.php'>View Users</a></p>";
        }

        header("Location: users.php?source=edit_user&edit_user={$edit_user_id}&updated={$edit_user_id}");
    }
}
else {
    header("Location: index.php");
}
?>

<!--send info to current page-->
<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_username">Username</label>
        <input autocomplete="" value="<?php echo $db_user_username; ?>" type="text" class="form-control"
               name="user_username">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input autocomplete="off" value="<?php //echo $db_user_password; ?>" placeholder="Enter New Password ..."
               type="password"
               class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input value="<?php echo $db_user_firstname; ?>" type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input value="<?php echo $db_user_lastname; ?>" type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">

        <label for="user_role">Role :</label>
        <select name="user_role" id="">
            <option value="<?php echo $db_user_role; ?>"><?php echo $db_user_role; ?></option>
            <?php
            if ($db_user_role == 'admin') {
                echo "<option value='subscriber'>subscriber</option>";
            } else {
                echo "<option value='admin'>admin</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input value="<?php echo $db_user_email; ?>" type="email" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <?php
        // if database image is empty then display no image
        if (!empty($db_user_image)) {
            echo "<img width='100' src='../images/$db_user_image' alt='image'>";
        } else {
            echo "<b style='color: darkred'>No Image Chosen Yet</b>";
        }
        ?>
        <br>
        <label for="user_image">User Image</label>
        <input type="file" name="user_image">
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Update User">
    </div>

</form>
