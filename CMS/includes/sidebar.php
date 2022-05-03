<?php

// check request method (post/get)
if (ifItIsMethod('post')) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        login_user($username, $password);
    } else {
        redirect('index.php');
    }
}

?>

<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <!-- empty action means current page -->
        <form action="search.php" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                   <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                   </button>
                </span>
            </div>
        </form>
        <!-- search form -->
        <!-- /.input-group -->
    </div>

    <!-- Login -->
    <?php
    if (isset($_SESSION['user_role'])) {
        echo '<div style="margin-top: 20px;" class="well">';
        echo '<h4>Logged in as ' . $_SESSION['username'] . '</h4>';
        echo '<a href="./admin/includes/logout.php" class="btn btn-primary">Logout</a>';
        echo '</div>';
    } else {
        ?>
        <div class="well">
            <h4>Login</h4>
            <form action="" method="post">
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Enter Username">
                </div>
                <div class="input-group">
                    <input name="password" type="password" class="form-control" placeholder="Enter Password">
                    <span class="input-group-btn">
        <button class="btn btn-primary" name="login" type="submit">Login</button>
                    </span>
                </div>

                <div class="form-group">
                    <a href="./forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot Password</a>
                </div>

            </form>
        </div>
        <?php
    }
    ?>

    <!-- Blog Categories Well -->
    <div class="well">

        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    $query = "SELECT * FROM categories limit 5"; // $query = "SELECT * FROM categories limit 3";
                    $select_categories_sidebar = mysqli_query($connection, $query);
                    confirmQuery($select_categories_sidebar);

                    // loop through the categories and display them in a list
                    while ($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];
                        echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- Side Widget Well -->
    <?php include "widget.php"; ?>
</div>