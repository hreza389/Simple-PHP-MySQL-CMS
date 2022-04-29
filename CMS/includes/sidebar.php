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
    }
    else {
        echo '<div class="well">';
        echo '<h4>Login</h4>';
        echo '<form action="includes/login.php" method="post">';
        echo '<div class="form-group">';
        echo '<input name="username" type="text" class="form-control" placeholder="Enter Username">';
        echo '</div>';
        echo '<div class="input-group">';
        echo '<input name="password" type="password" class="form-control" placeholder="Enter Password">';
        echo '<span class="input-group-btn">';
        echo '<button class="btn btn-primary" name="login" type="submit">Login</button>';
        echo '</span>';
        echo '</div>';
        echo '</form>';
        echo '</div>';
    }
    ?>

    <!-- Blog Categories Well -->
    <div class="well">

        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    $query = "SELECT * FROM categories";// $query = "SELECT * FROM categories limit 3";
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