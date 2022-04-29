<?php

include "includes/admin_header.php";

// get and show information based on session username
if(isset($_SESSION['username'])){

    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE user_username = '{$username}'";
    $select_user_profile_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_array($select_user_profile_query)){
        $db_user_id = $row['user_id'];
        $db_user_username = $row['user_username'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_password = $row['user_password'];
        $db_user_email = $row['user_email'];
        $db_user_image = $row['user_image'];
        $db_user_role = $row['user_role'];
    }
}

?>


<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin
                        <small><?php echo $db_user_username; ?></small>
                    </h1>

                    <?php

                    // show message if post is updated
                    if (isset($_GET['updated_profile'])) {
                        if ($_GET['updated_profile'] == $db_user_id) {
                            echo "<p class='bg-success'>Profile Updated: " . " " . "<a href='users.php'>View Profile</a></p>";
                        }
                    }

                    // check form submission
                    if(isset($_POST['edit_profile'])) {
                        $f_username = $_POST['user_username'];
                        $f_user_password = $_POST['user_password'];
                        $f_user_firstname = $_POST['user_firstname'];
                        $f_user_lastname = $_POST['user_lastname'];
                        $f_user_role = $_POST['user_role'];
                        $f_user_email = $_POST['user_email'];

                        $f_user_image = $_FILES['user_image']['name'];
                        $f_user_image_temp = $_FILES['user_image']['tmp_name'];
                        move_uploaded_file($f_user_image_temp, "../images/$f_user_image");

                        // check if the user has changed the image
                        if (empty($f_user_image)) {
                            $query = "SELECT * FROM users WHERE user_id = {$db_user_id}";
                            $select_image = mysqli_query($connection, $query);
                            while ($row = mysqli_fetch_array($select_image)) {$f_user_image = $row['user_image'];}
                        }

                        // if password be empty , in the DB will be empty too.
                        if (!empty($f_user_password)) {
                            $hash_password = password_hash($f_user_password, PASSWORD_BCRYPT, array('cost' => 10));

                            $query = "UPDATE users SET user_firstname = '{$f_user_firstname}', user_lastname = '{$f_user_lastname}', user_role = '{$f_user_role}', user_username = '{$f_username}', user_email = '{$f_user_email}', user_password = '{$hash_password}', user_image = '{$f_user_image}' WHERE user_id = {$db_user_id} ";
                            $update_user_query = mysqli_query($connection, $query);
                            confirmQuery($update_user_query);
                            echo "<p style='padding: 5px' class='bg-success'>Profile Updated &nbsp;&nbsp;&nbsp;&nbsp;<a href='profile.php'>View Profile</a></p>";
                        }
                        else {
                            $query = "UPDATE users SET user_firstname = '{$f_user_firstname}', user_lastname = '{$f_user_lastname}', user_role = '{$f_user_role}', user_username = '{$f_username}', user_email = '{$f_user_email}', user_image = '{$f_user_image}' WHERE user_id = {$db_user_id} ";
                            $update_user_query = mysqli_query($connection, $query);
                            confirmQuery($update_user_query);
                            echo "<p style='padding: 5px' class='bg-success'>Profile Updated &nbsp;&nbsp;&nbsp;&nbsp;<a href='profile.php'>View Profile</a></p>";
                        }

                        header("Location: profile.php?updated_profile={$db_user_id}");
                    }
                    ?>
                    <!-- Profile Form -->
                    <form action="" method="post" enctype="multipart/form-data" autocomplete="off">

                        <div class="form-group">
                            <label for="user_username">Username</label>
                            <input value="<?php echo $db_user_username; ?>" type="text" class="form-control" name="user_username">
                        </div>

                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input value="<?php //echo $db_user_password; ?>" type="password" class="form-control" name="user_password">
                        </div>

                        <div class="form-group">
                            <label for="user_firstname">Firstname</label>
                            <input value="<?php echo $db_user_firstname; ?>" type="text" class="form-control" name="user_firstname">
                        </div>

                        <div class="form-group">
                            <label for="user_lastname">Lastname</label>
                            <input value="<?php echo $db_user_lastname; ?>" type="text" class="form-control" name="user_lastname">
                        </div>


                            <!-- user role -->
<!--                        <div class="form-group">-->
<!---->
<!--                            <label for="user_role">Role :</label>-->
<!--                            <select name="user_role" id="">-->
<!--                                <option value="--><?php //echo $db_user_role; ?><!--">--><?php //echo $db_user_role; ?><!--</option>-->
<!--                                --><?php
//                                if ($db_user_role == 'admin') {echo "<option value='subscriber'>subscriber</option>";}
//                                else {echo "<option value='admin'>admin</option>";}
//                                ?>
<!--                            </select>-->
<!--                        </div>-->

                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input value="<?php echo $db_user_email; ?>" type="email" class="form-control" name="user_email">
                        </div>

                        <div class="form-group">
                            <?php
                            // if database image is empty then display no image
                            if (!empty($db_user_image)) {echo "<img style='border-radius: 3px;border: 1px solid lightgrey' width='100' src='../images/$db_user_image' alt='image'>";}
                            else {echo "<b style='color: darkred'>No Image Chosen Yet</b>";}
                            ?>
                            <br>
                            <label for="user_image">User Image</label>
                            <input type="file" name="user_image">
                        </div>

                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="edit_profile" value="Update Profile">
                        </div>

                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php"; ?>