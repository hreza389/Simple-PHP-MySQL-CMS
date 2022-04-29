<?php

# check if form has been submitted
if (isset($_POST['create_user'])) {

    $user_username = $_POST['user_username'];
    $user_password = $_POST['user_password'];
    $user_password = password_hash($user_password, PASSWORD_DEFAULT, ['cost' => 10]);
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    $user_email = $_POST['user_email'];
    // $post_date = date('d-m-y');

    $user_image = $_FILES['user_image']['name'];
    $user_image_temp = $_FILES['user_image']['tmp_name'];
    echo 'Image Name : ' . $user_image;
    echo "<br>";
    echo "Temp Location : ".$user_image_temp;
    move_uploaded_file($user_image_temp, "../images/$user_image");


    $query = "INSERT INTO users (user_username, user_password, user_firstname, user_lastname, user_role, user_email, user_image) values ('$user_username', '$user_password', '$user_firstname', '$user_lastname', '$user_role', '$user_email', '$user_image')";
    $create_user_query = mysqli_query($connection, $query);
    confirmQuery($create_user_query);

    echo "<p class='bg-success'>User Created: " . " " . "<a href='users.php'>View Users</a></p>";
}
?>

<!--send info to current page-->
<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_username">Username</label>
        <input type="text" class="form-control" name="user_username">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <label for="user_role">Role :</label>
        <select name="user_role" id="">
            <option value="subscriber">Subscriber</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="user_image">User Image</label>
        <input type="file" name="user_image">
    </div>

<!--    <div class="form-group">-->
<!--        <label for="user_role">User Role</label>-->
<!--        <input type="text" class="form-control" name="user_role">-->
<!--    </div>-->

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
    </div>

</form>
