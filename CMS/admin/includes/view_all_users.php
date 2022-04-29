<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Role</th>
        <th>Image</th>
        <th style="color: gold">Make Admin</th>
        <th style="color: lightsalmon">Make Subscriber</th>
        <th style="color: dodgerblue">Edit</th>
        <th style="color: red">Delete</th>
    </tr>
    </thead>
    <tbody>

    <?php
    // if x btn clicked , remove post image

    ?>

    <?php
    $query = "select * from users";
    $select_users = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_users)) {
        $user_id = $row['user_id'];
        $user_username = $row['user_username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];


        echo "<tr>";
        echo "<td>$user_id</td>";
        echo "<td>$user_username</td>";
        echo "<td>$user_firstname</td>";
        echo "<td>$user_lastname</td>";
        echo "<td>$user_email</td>";
        echo "<td>$user_role</td>";

        // if image is not empty
        if (!empty($user_image)) {
            echo "<td><img style='border-radius: 2px; border: 1px solid lightgray; max-height: 100px; max-width: 60px;' src='../images/$user_image' alt='image'></td>";
        } else {
            echo "<td>No Image</td>";
        }

        echo "<td><a href='users.php?change_to_admin=$user_id'>Admin</a></td>";
        echo "<td><a href='users.php?change_to_subscriber=$user_id'>Subscriber</a></td>";

        echo "<td><a href='users.php?source=edit_user&edit_user=$user_id'>Edit</a></td>";
        echo "<td><a onclick=\"javascript: return confirm('Delete?'); \" href='users.php?delete=$user_id'>Delete</a></td>";
        echo "</tr>";
    }
    ?>

    </tbody>
</table>


<?php

// make admin
if (isset($_GET['change_to_admin'])) {
    $the_user_id = $_GET['change_to_admin'];
    $query = "update users set user_role = 'admin' where user_id = {$the_user_id}";
    $change_to_admin_query = mysqli_query($connection, $query);
    header("Location: users.php");
}

// make subscriber
if (isset($_GET['change_to_subscriber'])) {
    $the_user_id = $_GET['change_to_subscriber'];
    $query = "update users set user_role = 'subscriber' where user_id = {$the_user_id}";
    $change_to_subscriber_query = mysqli_query($connection, $query);
    header("Location: users.php");
}


# Delete - check and delete if delete link clicked
if (isset($_GET['delete'])) {

    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'admin') {
            $the_user_id = mysqli_real_escape_string($connection, $_GET['delete']);
            $query = "delete from users where user_id = {$the_user_id}";
            $delete_user_query = mysqli_query($connection, $query);
            header("Location: users.php");
        }
    }
}
?>